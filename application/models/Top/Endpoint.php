<?php
class Navo_Model_Top_Endpoint
{
	private static $instance = null;
	
	private static $c = null;
	
	private static $endpointOptions = null;
	
	private function __construct()
    {
         
          
        $options = Zend_Registry::get('config');
        self::$endpointOptions = new stdClass();
        self::$endpointOptions->router = $options->taobao->api->router->url;
        self::$endpointOptions->oauth = $options->taobao->api->oauth->url;
        self::$endpointOptions->appKey = $options->taobao->api->appKey;
        self::$endpointOptions->appSecret = $options->taobao->api->appSecret;
        self::$endpointOptions->container = $options->taobao->api->container->url;
        self::$endpointOptions->oauthToken = $options->taobao->api->oauth->token->url;
        self::$endpointOptions->authMethod = $options->taobao->api->auth->method;
        
        include 'TopSdk.php';
		self::$c = new TopClient ();
		self::$c->appkey = self::$endpointOptions->appKey;
		self::$c->secretKey = self::$endpointOptions->appSecret;
		self::$c->gatewayUrl = self::$endpointOptions->router;
    } 
    
	static private function getInstance() {
		if (null === self::$instance ) {
			 self::$instance = new Navo_Model_Top_Endpoint();
		}
		
		return self::$instance;
	}
	
	static public function getEndpoint() {
	    self::getInstance();
	    return self::$c;
	}
	
	static public function getEndpointOptions()
	{
	    self::getInstance();
	    return self::$endpointOptions;
	}
	
// 	static public function getAppSecret()
// 	{
// 	    self::getInstance();
// 	    return self::$endpointOptions->appSecret;
// 	}
	
	
	static public function getAuthenticationUri ()
	{
		self::getInstance();
		if (self::$endpointOptions->authMethod == "oauth"){
			return self::getOauthUri();
		} else {
			return self::getContainerUri();
		}
	}
	
	private function getOauthUri()
	{
		$options = Zend_Registry::get('config');
		$params = array(
				'response_type' => 'code',
				'client_id' => self::$endpointOptions->appKey,
				'redirect_uri' => '',
		);
		$uri = $options->baseHttp . '/user/sign-in-callback/';
		return self::$endpointOptions->oauth . '?' .http_build_query($params).$uri;
			
	}
	
	private function getContainerUri() {
		return self::$endpointOptions->container . self::$endpointOptions->appKey . '&encode=utf-8';
		//http://container.api.tbsandbox.com/container?appkey=1012384059&ref=/taobao.items.inventory.get.php
	}
	
}
