<?php

class Navo_Service_Validate_Item_SecondKill extends Navo_Service_Validate_Abstract
{
    const INVALID   = 'secondKillInvalid';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' is second kill product.",
    );

    /**
     * Defined by Navo_Service_Validate_Interface
     *
     * @param  Navo_Model_DbTable_Item $value
     * @return boolean
     */
    public function isValid($item)
    {
        if ($item->second_kill == true ) {
            $this->_error(self::INVALID , $item->num_iid);
            return false;
        }
        
		return true;
    }
}
