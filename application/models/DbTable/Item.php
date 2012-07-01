<?php
/**
 * Navo_Model_DbTable_Item
 * 
 * @author Yuan
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class Navo_Model_DbTable_Item extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'item';
    
    public function sqlSave(SimpleXMLElement $item)
    {
        $data = array(); // $data 内容参见 Navo_Model_Top_Item::getKeys()
        
		foreach (Navo_Model_Top_Item::getKeys() as $key) {
			$data[$key] = (string)$item->$key;
		} 
		
    
    	if (false === ($itemId = $this->sqlHasItem($item->num_iid) ))
    	{
    		return $this->insert($data);
    	}
    	else
    	{
    		$this->update($data, array('num_iid = ?' => $item->num_iid));
    		return $itemId;
    	}
    
    }
    
    public function sqlHasItem($numIid)
    {
    	$where = $this->select()->where('num_iid = ?' , $numIid);
    	$rst = $this->fetchRow($where);
    	return ($rst === null) ? false : $rst->item_id;
    }
    
    public function sqlGetAllItemByUser($userId)
    {
        $item = new Navo_Model_DbTable_UserItem();
        $itemIdArray = $item->sqlGetAllItemByUser($userId);
        
        $where = $this->select()->where('item_id IN (?)', $itemIdArray)->order('volume DESC');
        return $this->fetchAll($where);
    }
    
    public function sqlGetItem($numIid)
    {
        $where = $this->select()->where('num_iid = ?' , $numIid);
        return $this->fetchRow($where);
    }
    
}
