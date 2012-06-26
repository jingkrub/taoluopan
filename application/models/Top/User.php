<?php
class Navo_Model_Top_User
{
    private $c;
    private $item;
    
    public function __construct() {
        $this->c = Navo_Model_Top_Endpoint::getEndpoint();
//         $this->item = new Navo_Model_DbTable_Item();
    }
    
	static public function getKeys()
	{
	    return array(
			'user_id',	//	Number	用户数字ID
// 	        'uid',	//	String	用户字符串ID
// 	        'nick',	//	String	用户昵称
	        'sex',	//	String	性别。可选值:m(男),f(女)
// 	        'buyer_credit',	//	UserCredit	买家信用
// 	        'seller_credit',	//	UserCredit	卖家信用
// 	        'location',	//	Location	用户当前居住地公开信息。如：location.city获取其中的city数据
// 	        'created',	//	Date	用户注册时间。格式:yyyy-MM-dd HH:mm:ss
	        'last_visit',	//	Date	最近登陆时间。格式:yyyy-MM-dd HH:mm:ss
	        'type',	//	String	用户类型。可选值:B(B商家),C(C商家)
	        'avatar',	//	String	用户头像地址
	        'has_shop',	//	Boolean	用户作为卖家是否开过店
	        'is_lightning_consignment',	//	Boolean	是否24小时闪电发货(实物类)
	        'is_golden_seller',	//	Boolean	用户是否是金牌卖家
	        'vip_info',	//	String	用户的全站vip信息，可取值如下：c(普通会员),asso_vip(荣誉会员)，vip1,vip2,vip3,vip4,vip5,vip6(六个等级的正式vip会员)，共8种取值，其中asso_vip是由vip会员衰退而成，与主站上的vip0对应。
	   );
	}
    
    public function userGet($userNick , $userId)
    {
//         $key = 'itemInventoryGet'.$sessionKey;
        
//         $cache = new Navo_Model_TopCache();
//         $resp = $cache->loadFromCache($key);
        
//         if ($resp == false)
//         {
            $resp = $this->_userGet($userNick);
//             $cache->saveToCache($resp, $key);
//         }
        $respXml = simplexml_load_string($resp);
        if (true == isset($respXml->user->user_id) && (string)$respXml->user->user_id == $userId )
        {
            return $respXml->user;
        }
        else {
            throw new Exception('Cannot Find User By Nick.');
        }
    }
    
    private function _userGet($userNick) 
    {        
        $req = new UserGetRequest();
        $req->setFields(join(",", self::getKeys()));
        //$req->setFields("approve_status,num_iid,title,nick,type,cid,volume,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id");
		$req->setNick($userNick);
        return $this->c->execute($req)->saveXML();
    }
        
}
