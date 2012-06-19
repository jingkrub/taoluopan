<?php
/**
 * TOP API: taobao.ump.activity.delete request
 * 
 * @author auto create
 * @since 1.0, 2012-06-18 12:34:14
 */
class UmpActivityDeleteRequest
{
	/** 
	 * 活动id
	 **/
	private $actId;
	
	private $apiParas = array();
	
	public function setActId($actId)
	{
		$this->actId = $actId;
		$this->apiParas["act_id"] = $actId;
	}

	public function getActId()
	{
		return $this->actId;
	}

	public function getApiMethodName()
	{
		return "taobao.ump.activity.delete";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->actId,"actId");
	}
}
