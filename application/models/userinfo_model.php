<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 用户信息基本模型
*
*/

class Userinfo_model extends MY_Model {

	function __construct()
    {
        parent::__construct();
		$this->tbl		= 'live_userinfo_base';
		$this->tbl_key	= 'userid';
    }

	public function setMaster($userid, $roomid)
	{
		$pdata['ismaster'] = $roomid;
		$pdata['kind'] = serialize(array($roomid));
		$sdata['userid'] = $userid;
		$this->M($pdata, $sdata);
	}

}
?>