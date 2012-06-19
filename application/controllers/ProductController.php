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
        // TODO Auto-generated ProductController::indexAction() default action
        $c = $this->startTopService();
        
        //$this->test($c, '6000278296');
        //http://item.taobao.com/item.htm?id=4697747146
        $this->test($c, '4697747146');
		exit;
    }
    
	private function startTopService()
	{
			include 'TopSdk.php';
			$c = new TopClient ();
			$c->appkey = Ecmpc_Model_Authentication::getAuthEndpoint()->appKey;
			$c->secretKey = Ecmpc_Model_Authentication::getAuthEndpoint()->appSecret;
			$c->gatewayUrl = Ecmpc_Model_Authentication::getAuthEndpoint()->router;

			return $c;
	}
	
	public function test($c ,$productIid)
	{
		$authNamespace = new Zend_Session_Namespace('Ecmpc_Auth');
		var_dump($authNamespace->topSession);

		
		
//		$req = new ItemGetRequest ();
//			$req->setFields ( "detail_url,num_iid,title,nick,type,cid,seller_cids,props,input_pids,input_str,desc,pic_url,num,valid_thru,list_time,de-list_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,has_showcase,modified,increment,approve_status,postage_id,product_id,auction_point,property_alias,item_img,prop_img,sku,video,outer_id,is_virtual" );
//			$req->setNumIid ( $productIid );
////			var_dump($authNamespace->nick);exit;
////$authNamespace->topSession
//			$result = $c->execute ( $req )->saveXML();
//			var_dump($result);


	$req = new ItemsGetRequest;
	$req->setFields("num_iid,title,nick,pic_url,cid,price,type,delist_time,post_fee,score,volume");
	$req->setQ("phone");
	$result = $c->execute ( $req )->saveXML();
	var_dump(html_entity_decode($result));

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
