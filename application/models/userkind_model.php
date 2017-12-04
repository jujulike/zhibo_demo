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
class Userkind_model extends MY_Model{
	
	public function __construct() {
		parent::__construct();
		$this->tbl = 'live_userinfo_kind';
		$this->tbl_key = 'id';
		$this->tbl_ext = '';
	}

	public function getUserVip($userid)
	{
		if (empty($userid)) return false;
		return $this->L(array('userid'=>$userid), 'roomid', 100);
	}

	public function setUserVip($data)
	{
		if (empty($data['userid']) || (empty($data['roomid']))) return false;
		$string = '';
		foreach ($data['roomid'] as $k => $v)
		{
			$string .= '(' . $data['userid'] . ',' . $v . '),';			
		}

		$string = substr($string, 0, -1);

		return  $this->db->query("INSERT INTO " . $this->tbl . "(userid,roomid) VALUES " . $string);
	}

	public function delUserVip($userid)
	{
		if (empty($userid)) return false;
		return $this->D(array('userid' => $userid));
	}



}
