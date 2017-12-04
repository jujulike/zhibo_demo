<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 广告信息模型
*
*/

class Advertisement_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->tbl = 'live_advertising';
		$this->tbl_key = 'advertid';
		$this->tbl2 = 'live_category';
	}

	public function delMoreAdvertisement($advertid)
	{
		$sql = 'delete from '.$this->tbl.' where advertid in ('.$advertid.')';
		$this->db->query($sql);
	}

	/**
	*  获取频道下的所有广告数据
	* （默认使用别名标识alias为参数字段）
	*
	*/
	public function getChannelAds($alias)
	{
		$c = " where func='advertising' and a.status=1";
		if (is_array($alias))
		{
			$c = $c . " and a.cateid in (" . implode(',', $alias) . ")";
		}
		else
		{
			$c = $c . " and b.alias='" . $alias . "'";
		}

		$sql = "select a.*,b.catename,b.parentid,b.alias
				from " . $this->tbl . " as a 
				left join " . $this->tbl2 . " as b 
				on a.cateid=b.cateid " . $c . "
				order by a.sort";	

		$query = $this->db->query($sql);
		$_d = $query->result_array();
		if ($_d)
		{
			return cate2arraydata($_d, 'cateid');
		}

		return '';
	}

}
?>