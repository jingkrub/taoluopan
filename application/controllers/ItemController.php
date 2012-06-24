<?php
/**
 * ProductController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class ItemController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    
    public function init()
    {
        if (false == Navo_Model_Authentication::valid() )
        {
            $this->_helper->redirector('index' , 'user');
        }
    }
    
    public function indexAction ()
    {
        echo '<a href="fetch/" >fetch item</a> ';
        exit;
    }
    public function fetchAction ()
    {
        
        //FIXME: 还没有做多页的处理！！！
        
        //TODO: 不知道有没有子账号登录，现在每一个item绑定到一个用户上，如果刷新，用户废弃的item将被删除。
                
        $user = Navo_Model_Authentication::getUser();
        
        $itemTop = new Navo_Model_Top_Item();
        
        $respInventory = $itemTop->itemInventoryGet($user->getSessionKey());
        $itemInventoryXml = simplexml_load_string($respInventory);
        
        $respOnSale = $itemTop->itemOnsaleGet($user->getSessionKey());
        $itemOnsaleXml = simplexml_load_string($respOnSale);
        
        $userItemArray = array();
        
        $item = new Navo_Model_DbTable_Item();
        $userItem = new Navo_Model_DbTable_UserItem();
        
        $db = $item->getDefaultAdapter();
        $db->beginTransaction();
        try {
            
            foreach ($itemInventoryXml->items->item as $xmlItem) {
            
            	$id = $item->sqlSave($xmlItem);
            	$userItem->sqlSave($user->getId(), $id);
            	$userItemArray[] = $id;
            }
            
            foreach ($itemOnsaleXml->items->item as $xmlItem) {
            	$id = $item->sqlSave($xmlItem);
            	$userItem->sqlSave($user->getId(), $id);
            	$userItemArray[] = $id;
            }
            
            $userItem->sqlRefreshPairs($user->getId(), $userItemArray);
            
            $db->commit();
            
        } catch (Exception $e) {
            $db->rollBack();
            echo $e->getMessage();
            exit;
        }
        
        $this->_helper->redirector('index');
       	exit;
    }
	
    public function autoOptimizationAction()
    {
    	//自动上架时间修订：
    	
    	//获取用户店铺类别 req1 cache 1day
    	//获取用户店铺销售曲线 req？
    	
    	//寻找用户卖的最好的5个产品  req1 cache 1day
    	//执行：自动分布最好的产品位置
    	
    	//保存产品位置。
    	//：如果没有保存在自己数据库中则创建新的。
    	//：如果保存过则对比已有的更换最新的。 
    	
    	//TODO: 自动上架问题？
    	
    }
}
