<?php
/**
 * Navo_Model_DbTable_User
 * 
 * @author Yuan
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class Navo_Model_DbTable_User extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'user';
    
    public function sqlSave(Navo_Model_User $user)
    {
        $data = array(
                'user_id' => $user->getUserId(),
                'name' => $user->getName(),
                'session_key' => $user->getSessionKey(),
                'expires_time' => $user->getExpiresTime(),
                're_expires_time' => $user->getReExpiresTime(),
                'signin_timestamp' => $user->getSignInTimestamp(),
                
                'sex' => $user->getSex(),
                'last_visit' => $user->getLastVisit(),
                'type' => $user->getType(),
                'avatar' => $user->getAvatar(),
                'has_shop' => $user->getHasShop(),
                'is_lightning_consignment' => $user->getIsLightningConsignment(),
                'is_golden_seller' => $user->getIsGoldenSeller(),
                'vip_info' => $user->getVipInfo(),
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
    	$rst = $this->sqlQueryUser($userId);
    	return ($rst == null) ? false : true;
    }
    
    public function sqlActiveUser(Navo_Model_User $user)
    {
        $data = array('is_actived' => 1);
        return $this->update($data, array('user_id = ?' => $user->getUserId() ) );
    }
    
    public function sqlDeactiveUser(Navo_Model_User $user)
    {
    	$data = array('is_actived' => 0);
    	return $this->update($data, array('user_id = ?' => $user->getUserId() ) );
    }
    
    public function sqlQueryActivedStatus(Navo_Model_User $user)
    {
        $rst = $this->sqlQueryUser($user->getUserId());
        return $rst->is_actived;
    }
    
    public function sqlQueryUser($userId)
    {
        $where = $this->select()->where('user_id = ?' , $userId);
        return $this->fetchRow($where);
    }

}
