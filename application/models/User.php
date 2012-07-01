<?php
class Navo_Model_User extends Navo_Model_UserAuth
{    
	protected $_sex;
	protected $_last_visit;
	protected $_type;
	protected $_avatar;
	protected $_has_shop;
	protected $_is_lightning_consignment;
	protected $_is_golden_seller;
	protected $_vip_info;
	
	public function setSex($sex)
	{
	    $this->_sex = $sex;
	}
	public function getSex()
	{
	    return $this->_sex;
	}
	
	public function setLastVisit($lastVisit)
	{
	    $this->_last_visit = $lastVisit;
	}
	
	public function getLastVisit()
	{
	    return $this->_last_visit;
	}
	
	public function setType($type)
	{
	    $this->_type = $type;
	}
	public function getType()
	{
	    return $this->_type;
	}
	
	public function setAvatar($avatar)
	{
		$this->_avatar = $avatar;
	}
	public function getAvatar()
	{
		return $this->_avatar;
	}
	
	public function setHasShop ($hasShop)
	{
		$this->_has_shop = $hasShop;
	}
	public function getHasShop ()
	{
		return $this->_has_shop;
	}
	
	public function setIsLightningConsignment ($isLightningConsignment)
	{
		$this->_is_lightning_consignment = $isLightningConsignment;
	}
	
	public function getIsLightningConsignment ()
	{
		return $this->_is_lightning_consignment;
	}
	
	public function setIsGoldenSeller ($isGoldenSeller)
	{
		$this->_is_golden_seller = $isGoldenSeller;
	}
	public function getIsGoldenSeller ()
	{
		return $this->_is_golden_seller;
	}
	
	public function setVipInfo ($vipInfo)
	{
		$this->_vip_info = $vipInfo;
	}
	
	public function getVipInfo ()
	{
		return $this->_vip_info;
	}
}
