<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* ��ɫ����ģ��
*
*/

class Action_model extends MY_Model {

	function __construct()
    {
        parent::__construct();
		$this->tbl		= 'live_admin_action';
		$this->tbl_key	= 'action_id';
    }
}
?>