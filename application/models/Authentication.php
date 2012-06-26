<?php
class Navo_Model_Authentication
{
	private static $instance = null;
	private static $endPointOptions = null;
	private static $authNamespace = null;
	
	/**
	 * @var Navo_Model_User
	 */
	private static $user = null;
	
	private function __construct()
    {
    	self::$endPointOptions = Navo_Model_Top_Endpoint::getEndpointOptions();
        self::$authNamespace = new Zend_Session_Namespace('Navo_Auth');
        self::$user = new Navo_Model_User();

    } 
    
	static private function getInstance() {
		if (null === self::$instance ) {
			 self::$instance = new Navo_Model_Authentication();
		}
		
		return self::$instance;
	}
	
	static public function validCallback( $topSign , $topParameters , $topSession )
	{
		self::getInstance();
		
		$md5 = md5(  self::$endPointOptions->appKey. $topParameters . $topSession . self::$endPointOptions->appSecret , true ); 
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
		
		return self::setUser($parameters);
		
	}
	
	static public function getUser()
	{
	    self::getInstance();
	    if ( null != self::$user &&  null != self::$user->getId() )
	    return self::$user;
	    else 
	        throw new Exception('User Session Expired.');
	}
	
	static private function setUser($params)
	{
	    self::getInstance();
 
	    $userTop = new Navo_Model_Top_User();
	    $userInfoXml = $userTop->userGet($params['visitor_nick'] , $params['visitor_id']);
	    
	    $userData = array(
	    		'userId' => $params['visitor_id'],
	    		'name' => $params['visitor_nick'],
	    		'sessionKey' => $params['refresh_token'],
	    		'expiresTime' => $params['expires_in'],
	    		'reExpiresTime' => $params['re_expires_in'],
	    		'signInTimestamp' => date('Y-m-d H:i:s', $params['ts']/1000),
	            
	            'sex' => (string) $userInfoXml->sex,
	            'lastVisit' => (string) $userInfoXml->last_visit,
	            'type' => (string) $userInfoXml->type,
	            'avatar' => (string) $userInfoXml->avatar,
	            'hasShop' => (string) $userInfoXml->has_shop,
	            'isLightningConsignment' => (string) $userInfoXml->is_lightning_consignment,
	            'isGoldenSeller' => (string) $userInfoXml->is_golden_seller,
	            'vip_info' => (string) $userInfoXml->vip_info,
	    );
	    
	    self::$user->setOptions($userData);
	    self::$user = self::$user->save();
	    
	    self::$authNamespace->user = self::$user;	
	    self::$authNamespace->setExpirationSeconds(self::$user->getExpiresTime());
	}
	
	static public function valid()
	{
	    self::getInstance();
	    if  ( isset( self::$authNamespace->user ) == true && null != self::$authNamespace->user->getId() ) {
	        self::$user = self::$authNamespace->user;
	    	return true;
	    } else {
	        return false;
	    }
	}
	
}
