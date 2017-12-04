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
class Jsvote_model extends MY_Model{
	
	public function __construct() {
		parent::__construct();
		$this->tbl = 'live_jsvote';
		$this->tbl_key = 'id';
		$this->tbl_ext = '';
	}

	public function getRate($d , $id=0)
	{
		$c = ' where vote_id=\''.$id.'\' and votedate=\'' . date("Y-m-d") . '\'';
		if ($d != '') $c .= " and votedate='" . $d . "'";
		$sql = "select count(*) as c, votetype from " . $this->tbl . $c . " group by votetype " ;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

}
