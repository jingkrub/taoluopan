<?php

class Navo_Service_Validate_Item_Violation extends Navo_Service_Validate_Abstract
{
    const INVALID   = 'violationInvalid';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' is violation.",
    );

    /**
     * Defined by Navo_Service_Validate_Interface
     *
     * @param  Navo_Model_DbTable_Item $value
     * @return boolean
     */
    public function isValid($item)
    {
        if ($item->violation == true ) {
            $this->_error(self::INVALID , $item->num_iid);
            return false;
        }
        
		return true;
    }
}
