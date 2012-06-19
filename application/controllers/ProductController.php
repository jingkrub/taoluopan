<?php
/**
 * ProductController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class ProductController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $authNamespace = new Zend_Session_Namespace('Ecmpc_Auth');
        $sessionKey = $authNamespace->topSession;
        
        
        $product = new Ecmpc_Model_Product();
        $resp = $product->itemInventoryGet($sessionKey);
        
        header('Content-Type: text/xml');
        echo $resp;
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
