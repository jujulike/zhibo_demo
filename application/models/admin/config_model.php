<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 系统配置信息基本模型
*
*/

class Config_model extends MY_Model {

	function __construct()
	{
		parent::__construct();
		$this->tbl = 'live_system_config';
		$this->tbl_key = 'confid';
		$this->tbl_ext = '';
	}
}