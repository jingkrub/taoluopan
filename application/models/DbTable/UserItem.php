<?php
/**
 * Navo_Model_DbTable_UserItem
 * 
 * @author Yuan
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class Navo_Model_DbTable_UserItem extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'user_item';
    
    public function sqlSave( $userId , $itemId)
    {
        
		$data = array(
			'user_id' => $userId,
		    'item_id' => $itemId, 
		);
    
    	if (false == $this->sqlHasPair($data))
    	{
    		$this->insert($data);
    	}    
    }
    
    public function sqlHasPair($data)
    {
        $where = $this->select()->where('user_id = ?' , $data['user_id'])->where('item_id = ?' , $data['item_id']);
        $rst = $this->fetchAll($where);
    	return ($rst->count() == 0 ) ? false : true;
    }
    
    /**
     * @return Array
     */
    public function sqlGetAllItemByUser( $userId) {
        
        $itemArray = array();
        $where = $this->select()->where('user_id = ?' , $userId);
        $resultSet = $this->fetchAll($where);
		
    	foreach ($resultSet as $row) {
    	    $itemArray[] = $row->item_id;
        }
        
    	return $itemArray;
    }
    
    public function sqlRefreshPairs( $userId , array $userItemArray)
    {
        $orgItemArray = $this->sqlGetAllItemByUser($userId);
        $diffResultSet = array_diff($orgItemArray, $userItemArray);
        
        $item = new Navo_Model_DbTable_Item();
        foreach ($diffResultSet as $itemId) {
        	$this->delete(array('user_id = ?' => $userId, 'item_id = ?'=> $itemId));
        	$item->delete(array('item_id = ?' => $itemId) );
        }
    }    
}
