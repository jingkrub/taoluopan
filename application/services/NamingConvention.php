<?php

class Navo_Service_NamingConvention
{
    static private $_camel = array("A","B","C","D","E","F","G","H","I","J",
    		"K","L","M","N","O","P","Q","R","S","T",
    		"U","V","W","X","Y","Z",);
     
    static private $_flat = array("_a","_b","_c","_d","_e","_f","_g","_h","_i","_j",
    		"_k","_l","_m","_n","_o","_p","_q","_r","_s","_t",
    		"_u","_v","_w","_x","_y","_z",);
    
	static public function camelToFlat($string)
	{
	    return str_replace(self::$_camel, self::$_flat, $string);
	}
	
	static public function flatToCamel($string)
	{
	    return str_replace(self::$_flat, self::$_camel, $string);
	}
}
