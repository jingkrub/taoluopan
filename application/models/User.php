<?php
class Navo_Model_User
{    
	private $_id = null;
	private $_userId;
	private $_name;
	private $_sessionKey;
	private $_expiresTime;
	private $_reExpiresTime;
	private $_signInTimestamp;
	
	/**
	 * @var Navo_Model_DbTable_User
	 */
	private $user;
	
	public function __construct(array $options = null)
	{
	    $this->user = new Navo_Model_DbTable_User();
		if (is_array($options)) {
			$this->setOptions($options);
		}
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
	
	public function setName($name)
	{
	    $this->_name = (string) $name;
	    return $this;
	}
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function setSessionKey($sessionKey)
	{
		$this->_sessionKey = (string) $sessionKey;
		return $this;
	}
	
	public function getSessionKey()
	{
		return $this->_sessionKey;
	}
	
	public function setExpiresTime($expiresTime)
	{
		$this->_expiresTime = (string) $expiresTime;
		return $this;
	}
	
	public function getExpiresTime()
	{
		return $this->_expiresTime;
	}
	
	public function setReExpiresTime($reExpiresTime)
	{
		$this->_reExpiresTime = (string) $reExpiresTime;
		return $this;
	}
	
	public function getReExpiresTime()
	{
		return $this->_reExpiresTime;
	}
	
	public function setSignInTimestamp($signInTimestamp)
	{
		$this->_signInTimestamp = (string) $signInTimestamp;
		return $this;
	}
	
	public function getSignInTimestamp()
	{
		return $this->_signInTimestamp;
	}
	
	public function save()
	{
	    $id = $this->user->sqlSave($this);
	    $this->setId($id);
	    return $this;
	}
}
