<?php
class Navo_Model_Top_Shop
{
    private $c;
    
    public function __construct() {
        $this->c = Navo_Model_Top_Endpoint::getEndpoint();
    }
    
	static public function getKeys()
	{
		return array_merge(self::_getDefaultKeys(), self::_getShowcaseKeys());
	}
	
	static private function _getDefaultKeys()
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
	static private function _getShowcaseKeys(){
	     return array (
	        "remain_count",	 //Number	剩余橱窗数量，对于C卖家返回剩余橱窗数，对于B卖家返回-1（只有taobao.shop.remainshowcase.get可以返回）
	        "all_count",	 //Number	总橱窗数量，对于C卖家返回总橱窗数，对于B卖家返回0（只有taobao.shop.remainshowcase.get可以返回）
	        "used_count",	 //Number	 已用的橱窗数量，对于C卖家返回已使用的橱窗数，对于B卖家返回-1（只有taobao.shop.remainshowcase.get可以返回）
	   );
	}
	
	public function setOptionsByXml($xmlData)
	{
	    $data = array();
	    foreach (Navo_Model_Top_Shop::getKeys() as $value) {
	    	$data[Navo_Service_NamingConvention::flatToCamel($value)] = (string) $xmlData->shop->$value;
	    }
	    
	    $this->setOptions($data);
	}
    
    public function shopGet( $userNick , $sessionKey )
    {
        $respXml = $this->_shopGet($userNick);
        
        if (true == isset( $respXml->code ) ) {
            //TODO: Add Zend_Logger
        	throw new Exception('From: '.get_class($this).' Top code: "'.$respXml->code .'" Msg: '.$respXml->msg);
        }
        
        $respShowcaseXml = $this->_shopRemainshowcaseGet($sessionKey);
        
        if (true == isset( $respShowcaseXml->code ) ) {
        	//TODO: Add Zend_Logger
        	throw new Exception('From: '.get_class($this).' Top code: "'.$respShowcaseXml->code .'" Msg: '.$respShowcaseXml->msg);
        }
        
        foreach ($respShowcaseXml->shop->children() as $child) {
        	$respXml->shop->addChild($child->getName() , (string) $child);
        }
        
        return $respXml;
    }
    
    private function _shopGet($userNick) 
    {        
        $req = new ShopGetRequest();
        $req->setFields(join(",", self::_getDefaultKeys()));
		$req->setNick($userNick);
        return $this->c->execute($req);
    }
    
    private function _shopRemainshowcaseGet($sessionKey)
    {
        $req = new ShopRemainshowcaseGetRequest();
//         $req->setFields(join(",", self::_getShowcaseKeys()));
        return $this->c->execute($req , $sessionKey);
    }
        
}
