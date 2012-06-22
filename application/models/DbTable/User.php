<?php
/**
 * Ecmpc_Model_DbTable_User
 * 
 * @author Yuan
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class Ecmpc_Model_DbTable_User extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'user';
    
    public function sqlSave(Ecmpc_Model_User $user)
    {
        $data = array(
                'user_id' => $user->getUserId(),
                'name' => $user->getName(),
                'session_key' => $user->getSessionKey(),
                'expire_time' => $user->getExpiresTime(),
                're_expire_time' => $user->getReExpiresTime(),
                'signin_timestamp' => $user->getSignInTimestamp(),
        );
    
    	if (null == $this->sqlHasUser( $user->getUserId() ) )
    	{
    		return $this->insert($data);
    	}
    	else
    	{
    		return $this->update($data, array('user_id = ?' => $user->getUserId() ) );
    	}
    
    }
    
    public function sqlHasUser($userId)
    {
    	$where = $this->select()->where('user_id = ?' , $userId);
    	$rst = $this->fetchRow($where);
    	return ($rst == null) ? false : true;
    }
    

}
