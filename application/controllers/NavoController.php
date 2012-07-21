<?php

class NavoController extends Zend_Controller_Action
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
        $user = Navo_Service_Authentication::getUser();
        
       //获取user的所有 item

       $item = new Navo_Model_DbTable_Item();
       $itemRowset = $item->sqlGetAllItemByUser( $user->getId() );
       
       $slotContainer = new Navo_Service_SlotContainer( $itemRowset->count() );
       
       foreach ($itemRowset as $item) {
           $slotContainer->setItem($item);
       }
       $slotContainer->reAllocate();
       
       exit;
    }
    
    public function validationAction()
    {
        //TODO: Fetch user_id.
        
        //取出所有的user
        
        //按照每一个user 取出可以改动的item
        
        //取出可以改动的时间表。
        
        $userId = '13424324';
        $user = new Navo_Model_User($userId);
        
        $userValidatorChain = new Navo_Service_Validate();
        $userValidatorChain->addValidator( new Navo_Service_Validate_User_IsActived() )
        ->addValidator(new Navo_Service_Validate_User_ShopUpdated());
        
        if ($userValidatorChain->isValid($user)) {
        	//TODO: contune;
        }
        ///////////////////////////////////////////////////////////////////////
        
        $item = new Navo_Model_DbTable_Item();
        //TODO: Fetch num_iid.
        $itemRow = $item->sqlGetItem('num_iid');
        
        
        // Create a validator chain and add validators to it
        $itemValidatorChain = new Navo_Service_Validate();
        $itemValidatorChain->addValidator( new Navo_Service_Validate_Item_Violation() )
        			    ->addValidator( new Navo_Service_Validate_Item_SecondKill() )
        				->addValidator( new Navo_Service_Validate_Item_FrequentUpdate());
        
        if ($itemValidatorChain->isValid($itemRow)) {
        	//TODO: contune;
        } 
    }
    
    public function onShelfAction()
    {
    
    }
    
    public function showcaseAction()
    {
    
    }
    public function advancedAction()
    {
    
    }


}

