<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 操作日志基本模型
*
*/

class Actionlog_model extends MY_Model {

	function __construct()
    {
        parent::__construct();
		$this->tbl		= 'live_action_log';
		$this->tbl_key	= 'log_id';
    }
}
?>