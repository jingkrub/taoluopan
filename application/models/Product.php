<?php
class Ecmpc_Model_Product
{
    public function itemInventoryGet($sessionKey)
    {
        $key = 'itemInventoryGet'.$sessionKey;
        
        $cache = new Ecmpc_Model_TopCache();
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
        $c = Ecmpc_Model_Endpoint::getEndpoint();
        $req = new ItemsInventoryGetRequest;
        $req->setFields("approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id");
        return $c->execute($req, $sessionKey)->saveXML();
    }
    
}
