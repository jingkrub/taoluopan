<?php
class Ecmpc_Model_Authentication
{
	private static $instance = null;
	
	private static $taobaoAuthEndpoint = null;
	
	private function __construct()
    {
    	$options = Zend_Registry::get('config');
        
        self::$taobaoAuthEndpoint->router = $options->taobao->api->router->url;
        self::$taobaoAuthEndpoint->oauth = $options->taobao->api->oauth->url;
        self::$taobaoAuthEndpoint->appKey = $options->taobao->api->appKey;
        self::$taobaoAuthEndpoint->appSecret = $options->taobao->api->appSecret;
        self::$taobaoAuthEndpoint->container = $options->taobao->api->container->url;
        self::$taobaoAuthEndpoint->oauthToken = $options->taobao->api->oauth->token->url;
        self::$taobaoAuthEndpoint->authMethod = $options->taobao->api->auth->method;

    } 
    
    static public function getAuthenticationUri ()
    {
    	self::getInstance();
    	if (self::$taobaoAuthEndpoint->authMethod == "oauth"){
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
    		'client_id' => self::$taobaoAuthEndpoint->appKey,
    		'redirect_uri' => '',
    	);
    	$uri = $options->baseHttp . '/user/sign-in-callback/';
    	return self::$taobaoAuthEndpoint->oauth . '?' .http_build_query($params).$uri;
    	
    }
    
    private function getContainerUri() {
    	return self::$taobaoAuthEndpoint->container . self::$taobaoAuthEndpoint->appKey . '&encode=utf-8';
    	//http://container.api.tbsandbox.com/container?appkey=1012384059&ref=/taobao.items.inventory.get.php
    }
    
    

    static public function getAuthEndpoint()
    {
    	self::getInstance();
    	return self::$taobaoAuthEndpoint;
    }
    
	static public function getInstance() {
		if (null === self::$instance ) {
			 self::$instance = new Ecmpc_Model_Authentication();
		}
		
		return self::$instance;
	}
	
	static function getAppSecret()
	{
		self::getInstance();
		return self::$taobaoAuthEndpoint->appSecret;
	}
	
	static public function validCallback( $topSign , $topParameters , $topSession )
	{
		self::getInstance();
		
		$md5 = md5(  self::$taobaoAuthEndpoint->appKey. $topParameters . $topSession . self::$taobaoAuthEndpoint->appSecret , true ); 
		$sign = base64_encode( $md5 );
		
		if ( $sign != $topSign ) { 
			throw new Exception('Login Error: Signature invalid.');
		} 
		
		$parameters = array(); 
		parse_str( base64_decode( $topParameters ), $parameters );
		$now = time(); 
		$ts = $parameters['ts'] / 1000; 
		if ( $ts > ( $now + 60 * 10 ) || $now > ( $ts + 60 * 30 ) ) { 
			throw new Exception('Login Error: request out of date.');
		}
		
		return $parameters;
	}
	
}
