<?php
class Ecmpc_Model_Endpoint
{
	private static $instance = null;
	
	private static $c = null;
	
	private function __construct()
    {
        include 'TopSdk.php';
		self::$c = new TopClient ();
		self::$c->appkey = Ecmpc_Model_Authentication::getAuthEndpoint()->appKey;
		self::$c->secretKey = Ecmpc_Model_Authentication::getAuthEndpoint()->appSecret;
		self::$c->gatewayUrl = Ecmpc_Model_Authentication::getAuthEndpoint()->router;
    } 
    
	static private function getInstance() {
		if (null === self::$instance ) {
			 self::$instance = new Ecmpc_Model_Endpoint();
		}
		
		return self::$instance;
	}
	
	static public function getEndpoint() {
	    self::getInstance();
	    return self::$c;
	}
	
}
