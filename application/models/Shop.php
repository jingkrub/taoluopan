<?php
class Navo_Model_Shop
{    
	protected $_id = null;
	protected $_userId;
	protected $_sid;
	protected $_cid;
	protected $_title;
	protected $_pic_path;
	protected $_created;
	protected $_modified;
	protected $_all_count;
	protected $_remain_count;
	protected $_used_count;
	protected $_updateTimestamp;

	/**
	 * @var Navo_Model_DbTable_Shop
	 */
	protected $shop;
	
	/**
	 * 
	 * @param int $userId
	 * @param array $options
	 */
	public function __construct($userId = null, array $options = null)
	{
	    $this->shop = new Navo_Model_DbTable_Shop();
	    if ($userId !== null && true == $this->shop->sqlUserHasShop($userId))
	    {
	        $shopDbRow = $this->shop->sqlQueryUserShop($userId);
	        $data = array();
	        foreach ($shopDbRow as $key => $value) {
	        	$data[Navo_Service_NamingConvention::flatToCamel($key)] = $value;
	        }
	        if (count($data)>0)
	        {
	            $this->setOptions($data);
	        }
	    }
	    
		if (is_array($options)) {
			$this->setOptions($options);
		}
		
	}
	public function save()
	{
		$id = $this->shop->sqlSave($this);
		$this->setId($id);
		return $this;
	}
	
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid user property: '.$name);
		}
		$this->$method($value);
	}
	
	public function __get($name)
	{
		$method = 'get' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid user property: '.$name);
		}
		return $this->$method();
	}
	
	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}
	
	public function setId($id)
	{
		$this->_id = (int) $id;
		return $this;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function setUserId($userId)
	{
		$this->_userId = (string) $userId;
		return $this;
	}
	
	public function getUserId()
	{
		return $this->_userId;
	}
	
	public function setSid($sid)
	{
	    $this->_sid = (string) $sid;
	    return $this;
	}
	
	public function getSid()
	{
		return $this->_sid;
	}
	
	public function setCid($cid)
	{
		$this->_cid = (string) $cid;
		return $this;
	}
	
	public function getCid()
	{
		return $this->_cid;
	}
	
	public function setTitle($title)
	{
		$this->_title = (string) $title;
		return $this;
	}
	
	public function getTitle()
	{
		return $this->_title;
	}
	
	public function setPicPath($pic_path)
	{
		$this->_pic_path = (string) $pic_path;
		return $this;
	}
	
	public function getPicPath()
	{
		return $this->_pic_path;
	}
	
	public function setCreated($created)
	{
		$this->_created = (string) $created;
		return $this;
	}
	
	public function getCreated()
	{
		return $this->_created;
	}
	
	public function setModified($modified)
	{
		$this->_modified = (string) $modified;
		return $this;
	}
	
	public function getModified()
	{
		return $this->_modified;
	}
	
	public function setAllCount($count)
	{
		$this->_all_count = (string) $count;
		return $this;
	}
	
	public function getAllCount()
	{
		return $this->_all_count;
	}
	
	public function setRemainCount($count)
	{
		$this->_remain_count = (string) $count;
		return $this;
	}
	
	public function getRemainCount()
	{
		return $this->_remain_count;
	}
	
	public function setUsedCount($count)
	{
		$this->_used_count = (string) $count;
		return $this;
	}
	
	public function getUsedCount()
	{
		return $this->_used_count;
	}
	
	
	public function setUpdateTimestamp($updateTimestamp)
	{
		$this->_updateTimestamp = (string) $updateTimestamp;
		return $this;
	}
	
	public function getUpdateTimestamp()
	{
		return $this->_updateTimestamp;
	}
	
}
