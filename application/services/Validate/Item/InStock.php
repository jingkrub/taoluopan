<?php

//FIXME: 这个可以不用，因为数据库中将不会存储inStock 的商品。Navo_Service_Validate_Item_InStock
class Navo_Service_Validate_Item_InStock extends Navo_Service_Validate_Abstract
{
    const INVALID   = 'inStockInvalid';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID => "'%value%' right now is in stock.",
    );

    /**
     * Defined by Navo_Service_Validate_Interface
     *
     * @param  Navo_Model_DbTable_Item $value
     * @return boolean
     */
    public function isValid($item)
    {
        if ($item->approve_status == 'instock' ) {
            $this->_error(self::INVALID , $item->num_iid);
            return false;
        }
        
		return true;
    }
}
