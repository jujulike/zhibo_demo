<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* ��ҵ����ģ��
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