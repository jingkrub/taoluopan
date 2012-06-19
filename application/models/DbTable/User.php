<?php
/**
 * UserModel
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
    
    public function sqlInsert( $userId , $userName , $userSessionKey , $expireTime, $reExpireTime , $timestamp)
    {
		$data = array(
			'user_id' => $userId, 
			'name' => $userName , 
			'session_key' => $userSessionKey , 
			'expire_time' => $expireTime , 
			're_expire_time' => $reExpireTime,
			'signin_timestamp' => $timestamp,
		);
		$this->insert($data);
    }
    
    public function sqlGetUser($userId)
    {
    	$where = $this->select()->where('user_id = ?' , $userId);
		return $this->fetchRow($where);
    }
    
    public function sqlUpdate($userId , $userName , $userSessionKey , $expireTime, $reExpireTime , $timestamp) 
    {
    	$data = array( 
			'name' => $userName , 
			'session_key' => $userSessionKey , 
			'expire_time' => $expireTime , 
			're_expire_time' => $reExpireTime,
			'signin_timestamp' => $timestamp,
		);
		$this->update($data, 'user_id = '.$userId);
    }
}
