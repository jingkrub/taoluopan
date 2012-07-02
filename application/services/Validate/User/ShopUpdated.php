<?php

class Navo_Service_Validate_User_ShopUpdated extends Navo_Service_Validate_Abstract
{
    const INVALID   = 'userShopNotUpdated';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' user's shop is not updated.",
    );

    /**
     * Defined by Navo_Service_Validate_Interface
     *
     * @param  Navo_Model_User $user
     * @return boolean
     */
    public function isValid($user)
    {
        $options = Zend_Registry::get('config');
        $recheckTimeframe = $options->navo->rechecked->timeframe;
        
        $shop = new Navo_Model_Shop($user->getUserId());
        if (strtotime($shop->getModified()) > time()-$recheckTimeframe ) {
            $this->_error(self::INVALID , $user->getUserId() );
            return false;
        }
        
		return true;
    }
}
