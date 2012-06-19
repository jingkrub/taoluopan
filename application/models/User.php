<?php
class Ecmpc_Model_User
{
	public function saveUserSignIn($authNamespace)
	{		
		$user = new Ecmpc_Model_DbTable_User();
		$userInfo = $user->sqlGetUser($authNamespace->userId);
		
		$ts = date("Y-m-d H:i:s" , $authNamespace->timestamp);
		
		if (null == $userInfo)
		{
			$user->sqlInsert($authNamespace->userId, $authNamespace->nick, $authNamespace->topSession, 
						  $authNamespace->expiresIn, $authNamespace->reExpiresIn, $ts );
		}
		else
		{
			$user->sqlUpdate($authNamespace->userId, $authNamespace->nick, $authNamespace->topSession, 
						  $authNamespace->expiresIn, $authNamespace->reExpiresIn, $ts );
		}
		
	}	
}
