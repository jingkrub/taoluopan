<?php

class Navo_Service_Validate_Item_FrequentUpdate extends Navo_Service_Validate_Abstract
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
     * @param  Zend_Db_Table_Rowset $item
     * @return boolean
     */
    public function isValid($item)
    {
        $itemHistory = new Navo_Model_DbTable_ItemHistory();
        $itemhisRowset = $itemHistory->sqlGetLastItemUpdate($item->item_id);
        
        $options = Zend_Registry::get('config');
        $itemUpdateThreshold = $options->application->navo->item->update->threshold;
        
        //FIXME: double check here
        
        if (strtotime( $itemhisRowset->update_timestamp ) + $itemUpdateThreshold <  time() ) {
            $this->_error(self::INVALID , $item->num_iid);
            return false;
        }
        
		return true;
    }
}
