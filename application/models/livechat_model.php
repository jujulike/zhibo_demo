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
class Livechat_model extends MY_Model{
	
	public function __construct() {
		parent::__construct();
		$this->tbl = 'live_chatcontent';
		$this->tbl_key = 'chatid';
		$this->tbl_ext = '';
	}

	public function getChat($masteruserid, $masterid, $chatid = '') {
		$sql = "select * from " . $this->tbl. " where (status = 1 or (chatuserid = ".$masteruserid.")) and masterid = " .$masterid;
		if ($chatid != '')
		{
			$sql = $sql . " and (chatid > " .$chatid.")";
		}
		$sql = $sql . " order by ctime desc limit 0,20";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

}