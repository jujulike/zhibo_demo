<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* ��ɫ����ģ��
*
*/

class Role_model extends MY_Model {

	function __construct()
    {
        parent::__construct();
		$this->tbl		= 'live_role';
		$this->tbl_key	= 'role_id';
    }
}
?>