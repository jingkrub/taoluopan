<?php
class Navo_Model_Top_Item
{
    private $c;
    private $item;
    
    public function __construct() {
        $this->c = Navo_Model_Top_Endpoint::getEndpoint();
//         $this->item = new Navo_Model_DbTable_Item();
    }
    
    public function itemInventoryGet($sessionKey)
    {
        $key = 'itemInventoryGet'.$sessionKey;
        
        $cache = new Navo_Model_TopCache();
        $resp = $cache->loadFromCache($key);
        
        if ($resp == false)
        {
            $resp = $this->_itemInventoryGet($sessionKey);
            $cache->saveToCache($resp, $key);
        }
        
        return $resp;
    }
    
    private function _itemInventoryGet($sessionKey) 
    {        
        $req = new ItemsInventoryGetRequest;
        $req->setFields(join(",", Navo_Model_Item::getKeys()));
        //$req->setFields("approve_status,num_iid,title,nick,type,cid,volume,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id");
        $req->setPageSize(200);
        return $this->c->execute($req, $sessionKey)->saveXML();
    }
    
    public function itemOnsaleGet($sessionKey)
    {
        $key = 'itemOnsaleGet'.$sessionKey;
        
        $cache = new Navo_Model_TopCache();
        $resp = $cache->loadFromCache($key);
        
        if ($resp == false)
        {
            $resp = $this->_itemOnsaleGet($sessionKey);
            $cache->saveToCache($resp, $key);
        }
        
        return $resp;
    }
    
    private function _itemOnsaleGet($sessionKey)
    {
    	$req = new ItemsOnsaleGetRequest;
    	$req->setFields(join(",", Navo_Model_Item::getKeys()));
    	//$req->setFields("approve_status,num_iid,title,nick,type,cid,volume,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id");
    	$req->setPageSize(200);
    	return $this->c->execute($req, $sessionKey)->saveXML();
    }
    
}
