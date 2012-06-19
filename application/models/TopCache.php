<?php
class Ecmpc_Model_TopCache
{
	private $_cache;
	
	public function __construct($timer = 86400)
	{
	    $options = Zend_Registry::get('config');
	    
		if ($timer < 86400)	{
			$dbFile = $options->top->cache->dbname;
		} else {
			$dbFile = $options->top->cache->dbname;
		}
	
		$frontendOptions = array(
				'lifetime' => $timer, // day = 86400
				'automatic_serialization' => true
		);
			
		$backendOptions = array(
				'cache_db_complete_path' => $dbFile, // Directory where to put the cache files
		);
			
		// getting a Zend_Cache_Core object
		$this->_cache = Zend_Cache::factory('Core',
				'Sqlite',
				$frontendOptions,
				$backendOptions);
	}
	
	public function loadFromCache($key)
	{
		if( $this->_cache->test($key) !== false ) {
			return $this->_cache->load($key);
		}
		return false;
	}
	
	public function saveToCache($data , $key)
	{
	    $this->_cache->save($data , $key);
	}
}
