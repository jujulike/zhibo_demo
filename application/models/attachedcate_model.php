<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ============================================================================
 * 版权所有 2013-2018 余姚市一洋网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.163.cn;
 * QQ: 57790081
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/


/**
 */
class Attachedcate_model extends MY_Model{
	
	public function __construct() {
		parent::__construct();
		$this->tbl = 'live_attach_cate';
		$this->tbl_key = 'attachcateid';
		$this->tbl_ext = '';
		$this->tb2 = 'live_attach_detail';
	}

	public function LL($detailid,$action = '')
	{
		if (is_array($detailid))
		{
			$strdetailid = implode(',',$detailid);
		}
		else
		{
			$strdetailid = $detailid;
		}

		$sql = "select a.detailid, b.* from ".$this->tbl . " as a left join " .$this->tb2 . " as b on (a.attachcateid = b.attachcateid) where a.detailid in (" . $strdetailid . ")";

		if ($action != '') $sql = $sql . " and action = '" .$action."'";
		//print_r($sql);
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getdetail($detailid)
	{
		$attached = $this->LL($detailid);
		if (!empty($attached))
		{

			return array2group($attached, 'detailid');
		}
		else
		{
			return false;
		}
	}

}
