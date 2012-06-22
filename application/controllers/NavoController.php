<?php

class NavoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        if (false == Ecmpc_Model_Authentication::valid() )
        {
        	$this->_helper->redirector('index' , 'user');
        }
    }

    public function indexAction()
    {
        $user = Ecmpc_Model_Authentication::getUser();
        
       //获取user的所有 item
       
       $item = new Ecmpc_Model_DbTable_Item();
       $itemRowset = $item->sqlGetAllItemByUser( $user->getId() );
       
       $slotContainer = new Ecmpc_Model_SlotContainer( $itemRowset->count() );
       
       foreach ($itemRowset as $item) {
           $slotContainer->setItem($item);
       }
       $slotContainer->reAllocate();
       
       exit;
    }


}

