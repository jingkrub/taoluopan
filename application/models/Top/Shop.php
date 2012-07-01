<?php
class Navo_Model_Top_Shop
{
    private $c;
    
    public function __construct() {
        $this->c = Navo_Model_Top_Endpoint::getEndpoint();
    }
    
	static public function getKeys()
	{
	    return array (
	        "sid",		//	Number	店铺编号。shop+sid.taobao.com即店铺地址，如shop123456.taobao.com
	        "cid",		//	Number	店铺所属的类目编号
// 	        "nick",		//	String	卖家昵称
	        "title",		//	String	店铺标题
// 	        "desc",		//	String	店铺描述
// 	        "bulletin",		//	String	店铺公告
	        "pic_path",		//	String	店标地址。返回相对路径，可以用"http://logo.taobao.com/shop-logo"来拼接成绝对路径
	        "created",		//	Date	开店时间。格式：yyyy-MM-dd HH:mm:ss
	        "modified",		//	Date	最后修改时间。格式：yyyy-MM-dd HH:mm:ss
	            	      
	   );
	}
    
    public function shopGet( $userNick )
    {
        $resp = $this->_shopGet($userNick);
        $respXml = simplexml_load_string($resp);
        
        if (true == isset( $respXml->code ) ) {
            //TODO: Add Zend_Logger
        	throw new Exception('From: '.get_class($this).' Top code: "'.$respXml->code .'" Msg: '.$respXml->msg);
        }
        
        return $respXml;
    }
    
    private function _shopGet($userNick) 
    {        
        $req = new ShopGetRequest();
        $req->setFields(join(",", self::getKeys()));
		$req->setNick($userNick);
        return $this->c->execute($req)->saveXML();
    }
        
}
