<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 管理员信息基本模型
*
*/

class Admin_model extends MY_Model {

	function __construct()
    {
        parent::__construct();
		$this->tbl		= 'live_admin_user';
		$this->tb2		= 'live_role';
		$this->tbl_key	= 'user_id';
    }

	function getLogin($username,$password)
	{
		$sql = "select a.*,b.role_name,b.action_list as action from " .$this->tbl. " as a left join " .$this->tb2." as b on a.role_id = b.role_id where a.user_name = '" . $username . "' and a.password = '" . $password . "'";

		$query = $this->db->query($sql);
		return $query->row_array();
	}

	function getAdmin()
	{
		$sql = "select a.*,b.role_name from " .$this->tbl. " as a left join " .$this->tb2." as b on a.role_id = b.role_id";

		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
?>