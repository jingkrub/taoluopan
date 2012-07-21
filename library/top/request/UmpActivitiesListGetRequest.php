<?php
/**
 * TOP API: taobao.ump.activities.list.get request
 * 
 * @author auto create
 * @since 1.0, 2012-06-18 12:34:14
 */
class UmpActivitiesListGetRequest
{
	/** 
	 * 营销活动id列表。
	 **/
	private $ids;
	
	private $apiParas = array();
	
	public function setIds($ids)
	{
		$this->ids = $ids;
		$this->apiParas["ids"] = $ids;
	}

	public function getIds()
	{
		return $this->ids;
	}

	public function getApiMethodName()
	{
		return "taobao.ump.activities.list.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->ids,"ids");
		RequestCheckUtil::checkMaxListSize($this->ids,40,"ids");
	}
}
