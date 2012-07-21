<?php
/**
 * TOP API: tmall.temai.subcats.search request
 * 
 * @author auto create
 * @since 1.0, 2012-06-18 12:34:14
 */
class TmallTemaiSubcatsSearchRequest
{
	/** 
	 * 父类目ID，固定是特卖前台一级类目id：50100982
	 **/
	private $cat;
	
	private $apiParas = array();
	
	public function setCat($cat)
	{
		$this->cat = $cat;
		$this->apiParas["cat"] = $cat;
	}

	public function getCat()
	{
		return $this->cat;
	}

	public function getApiMethodName()
	{
		return "tmall.temai.subcats.search";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->cat,"cat");
	}
}
