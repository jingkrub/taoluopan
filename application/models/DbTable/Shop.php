<?php
/**
 * Navo_Model_DbTable_Shop
 * 
 * @author Yuan
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class Navo_Model_DbTable_Shop extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'shop';
    
    public function sqlSave(Navo_Model_Shop $shop)
    {
        $data = array(
                'user_id' => $shop->getUserId(),
                'sid' => $shop->getSid(),
                'cid' => $shop->getCid(),
                'title' => $shop->getTitle(),
                'pic_path' => $shop->getPicPath(),
                'created' => $shop->getCreated(),
                'modified' => $shop->getModified(),
                'update_timestamp' => null,
        );
        
    	if (false == $this->sqlUserHasShop( $shop->getUserId() ) )
    	{
    		return $this->insert($data);
    	}
    	else
    	{
    		return $this->update($data, array('user_id = ?' => $shop->getUserId() ) );
    	}
    
    }
    
    public function sqlUserHasShop($userId)
    {
    	$rst = $this->sqlQueryUserShop($userId);
    	return ($rst == null) ? false : true;
    }
    
    public function sqlQueryUserShop($userId)
    {
        $where = $this->select()->where('user_id = ?' , $userId);
        return $this->fetchRow($where);
    }

}
