<?php
/**
 * Navo_Model_DbTable_UpdateQueue
 * 
 * @author Yuan
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class Navo_Model_DbTable_UpdateQueue extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'update_queue';
    
    public function sqlSave( $updateInfo = array() )
    {
        $data = array(
                'item_id' => $updateInfo['item_id'],
                'user_id' => $updateInfo['user_id'],
                'from_date' => $updateInfo['from_date'],
                'to_date' => $updateInfo['to_date'],
                'function' => $updateInfo['function'],
                'update_timestamp' => null,
        );
        
    	if (false == $this->sqlQueueHasItem( $updateInfo['item_id'] ) )
    	{
    		return $this->insert($data);
    	}
    	else
    	{
    	    throw new Exception('Duplicate item: '.$updateInfo['item_id'] .' function: '.$updateInfo['function']);
    		return false;
    	}
    
    }
    
    public function sqlQueueHasItem($itemId)
    {
    	$rst = $this->sqlQueryItem($itemId);
    	return ($rst == null) ? false : true;
    }
    
    public function sqlQueryItem($itemId)
    {
        $where = $this->select()->where('item_id = ?' , $itemId);
        return $this->fetchRow($where);
    }
    
    public function sqlFlushByUser($userId)
    {
        return $this->delete(array('user_id = ?' => $userId));
    }

}
