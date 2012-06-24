<?php
/**
 * UserController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class UserController extends Zend_Controller_Action
{
	var $baseHttp = null;
	
	public function init(){
		echo '<pre>';
		$options = Zend_Registry::get('config');
		$this->baseHttp = $options->baseHttp;
	}
	
    public function indexAction ()
    {
        $error = null;
    	if ($this->_hasParam('error')) {
        	$error = $this->_getParam('error');
        }
        
        echo '<a href="'.$this->baseHttp.'/user/sign-in/">SignIn</a>';
        echo '<p>'.$error.'</p>';
        exit;
    }
    
    public function signInAction() {
    	
    	$authenticationUri = Navo_Model_Top_Endpoint::getAuthenticationUri();
		header("Location: $authenticationUri");
    	exit;
    }
    
	public function signInCallbackAction()
	{
		if (false == $this->_hasParam('top_parameters') || false == $this->_hasParam('top_session') || false == $this->_hasParam('top_sign') ) 
		{
			$this->_redirect('/user/index/error/'.urlencode('Login Error: Missing callback paramaters.').'/');
		}
		
		$topParameters = $this->_getParam('top_parameters');
		$topSession = $this->_getParam('top_session'); 
		$topSign = $this->_getParam('top_sign');
		
		try {
			$user = Navo_Model_Authentication::validCallback($topSign, $topParameters, $topSession);
		} catch (Exception $e) {
			$this->_redirect('/user/index/error/'.urlencode($e->getMessage()) );
		}
				
		//TODO: 如果需要跳转回用户指定页面
		$this->_helper->redirector('index' , 'index');
	}
	
	public function signOutAction()
	{
//	    $ref = $_REQUEST['ref'];
		$authNamespace = new Zend_Session_Namespace('Navo_Auth');
		$authNamespace->unsetAll();
		$this->_helper->redirector('index' , 'index');
	}
	
}
