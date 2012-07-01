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
		$this->_redirect($authenticationUri);
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
			$user = Navo_Service_Authentication::validCallback($topSign, $topParameters, $topSession);
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
	
	public function statusAction()
	{
	    $user = $this->_getAuthUser();
	    
	    $userDb = new Navo_Model_DbTable_User();
	    $is_actived = $userDb->sqlQueryActivedStatus($user);
	    var_dump($is_actived);
	    
	    //TODO: 显示active 的开关。
	    exit;
	}
	
	public function activeAction()
	{
	    $user = $this->_getAuthUser();
	    
	    $userDb = new Navo_Model_DbTable_User();
	    $userDb->sqlActiveUser($user);
//		打开服务的时候 重新初始化任务队列。
	    $this->_helper->redirector('status');
	}
	
	public function deactiveAction()
	{
	    $user = $this->_getAuthUser();
	    
	    $userDb = new Navo_Model_DbTable_User();
	    $userDb->sqlDeactiveUser($user);
// 	    #15: 用户关掉服务的时候立即清除该用户的任务队列
		$queueDb = new Navo_Model_DbTable_UpdateQueue();
		$queueDb->sqlFlushByUser($user->getId());
		
	    $this->_helper->redirector('status');
	}
	
	private function _getAuthUser()
	{
	    if (false == Navo_Service_Authentication::valid() )
	    {
	    	$this->_helper->redirector('index' , 'user');
	    }
	     
	    return Navo_Service_Authentication::getUser();
	}
}
