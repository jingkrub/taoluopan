<?php
class Ecmpc_Model_SlotContainer
{
//     /**
//      * @var Array
//      */
//     private $_container = array();
    
    /**
     * 
     * @var Zend_Date
     */
    private $_date;
    
    /**
     * @var Array
     */
    private $_weightTable;
    
    private $_itemWeight;
    
    private $_itemArray;
    
    public function __construct( $itemCount ) {
        
//         $this->_container = array_fill(0, 168, null);		//填充一个168位的空数组
        
        $this->_date = new Zend_Date();
        $this->_weightTable = Ecmpc_Model_Weight::getWeights();
        $itemWeight = $this->setItemWeight($itemCount);
        $this->resetWeightByItem( $itemWeight );
        $this->_itemArray = array();
    }
    
    private function setItemWeight($itemCount)
    {
        $totalWeight = array_sum($this->_weightTable);
        return round( $totalWeight / 100 * $itemCount , 3 ); 
    }
    
    public function resetWeightByItem( $itemWeight )
    {
		arsort($this->_weightTable);		//arsort — 对数组进行逆向排序并保持索引关系
		foreach ($this->_weightTable as $key => $weight) {
		    if ($weight == 0) {
		        unset($this->_weightTable[$key]);
			} else {
		    	$this->_weightTable[$key] =(int) ceil( $weight / $itemWeight);
		    }
		}
		//ksort($this->_weightTable);		//ksort — 对数组按照键名排序
    }
    
    private function getItemOrgSlot( $item )
    {
        $this->_date->set($item->delist_time , 'yyyy-MM-dd HH:mm:ss');
        return ( $this->_date->get(Zend_Date::WEEKDAY_DIGIT) * 24 + $this->_date->get(Zend_Date::HOUR_SHORT) ) -1;
    }
    
    public function setItem( $item )
    {
        $slot = $this->getItemOrgSlot( $item );
        $index = count($this->_itemArray);
        $this->_itemArray[$index]->slot = $slot;
        $this->_itemArray[$index]->item = $item;
        
    }
    
    private function applySlot($item , $slot)
    {
        $this->_weightTable[$slot][] = $item->item;
        var_dump('item_id: '.$item->item->item_id.' -> to slot: '.$slot.' -> from slot: '.$item->slot);
    }
    
    private function matchBestSlot($slot)
    {
    	foreach ($this->_weightTable as $key => $weight) {
		    if ($key >= $slot && $weight > 0)
		    {
		        $this->_weightTable[$key]--;
		        if ($this->_weightTable[$key] == 0) {
		        	unset($this->_weightTable[$key]);
		        }
		        return $key;
		    }
		}
    }
    
    public function reAllocate()
    {
    	//item 位移
    	print_r($this->_weightTable);
    	foreach ($this->_itemArray as $item) {
    		$slot = $this->matchBestSlot($item->slot);
    		$this->applySlot($item , $slot);
    	}
    }
}
