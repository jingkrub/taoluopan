<?php
/**
 * TOP API: taobao.ump.mbb.getbycode request
 * 
 * @author auto create
 * @since 1.0, 2012-06-18 12:34:14
 */
class UmpMbbGetbycodeRequest
{
	/** 
	 * 营销积木块code
	 **/
	private $code;
	
	private $apiParas = array();
	
	public function setCode($code)
	{
		$this->code = $code;
		$this->apiParas["code"] = $code;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getApiMethodName()
	{
		return "taobao.ump.mbb.getbycode";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->code,"code");
	}
}
