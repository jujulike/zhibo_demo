<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 企业公告模型
*
*/

class Notice_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->tbl = 'live_notice';
		$this->tbl_key = 'noticeid';
	}

}
?>