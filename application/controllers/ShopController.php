<?php

class ShopController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        if (false == Navo_Service_Authentication::valid() )
        {
        	$this->_helper->redirector('index' , 'user');
        }
    }

    public function indexAction()
    {
        //获取用户店铺信息。
        $user = Navo_Service_Authentication::getUser();
        $shop = new Navo_Model_Shop($user->getUserId());

        $shopTop = new Navo_Model_Top_Shop();
        $shopXml = $shopTop->shopGet($user->getName() , $user->getSessionKey());
        $shop->setOptionsByXml($shopXml);
        $shop->setUserId($user->getUserId());
        $shop->save();
        
       echo 'done';
       exit;
    }


}

