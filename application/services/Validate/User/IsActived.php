<?php

class Navo_Service_Validate_User_IsActived extends Navo_Service_Validate_Abstract
{
    const INVALID   = 'userActivedInvalid';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' is not actived.",
    );

    /**
     * Defined by Navo_Service_Validate_Interface
     *
     * @param  Navo_Model_User $value
     * @return boolean
     */
    public function isValid($user)
    {
        if ($user->getIsActived() === false ) {
            $this->_error(self::INVALID , $user->getUserId() );
            return false;
        }
        
		return true;
    }
}
