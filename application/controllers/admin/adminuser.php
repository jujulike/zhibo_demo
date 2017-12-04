<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ============================================================================
 * 版权所有 2013-2018 余姚市洋网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.yyaoit.cn;
 * QQ: 150730730
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

/**
*/

class Adminuser extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/Admin_model','a');
		$this->load->model('admin/Role_model','r');
		$this->load->model('admin/Action_model','ac');
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login"); 
	}

	public function admin_list()
	{
		if (!$this->admin_priv('admin_user'))
		{
			show_error("您没有权限进行此操作！");
		}
		$sdata =array();
		$list = $this->a->getAdmin();
		$this->_d['list'] = $list;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'adminuser/user_list', $this->_d);
	}

	public function role_list()
	{
		if (!$this->admin_priv('role'))
		{
			show_error("您没有权限进行此操作！");
		}
		$sdata =array();
		$list = $this->r->L();
		$this->_d['list'] = $list;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'adminuser/role_list', $this->_d);
	}

	public function add_user()
	{
		if (!$this->admin_priv('admin_user'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($this->form_validation->run('admin_user/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['row'] = $this->a->INIT();
			$role = $this->r->L(array(),'role_id as id,role_name as name',0,0);
			$this->_d['role'] = array2option($role);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'adminuser/add_user', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			unset($postdata['user_id']);
			$postdata['add_time'] = time();
			if ($postdata['role_id'] == '')
				$postdata['action_list'] = 'all';
			if ($this->a->A($postdata))
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"添加管理员",$postdata['user_name']);
				$retmsg['code'] = '1';
				$retmsg['msg'] = $this->lang->line('add_success');
				exit(json_encode($retmsg));
			}
			else
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('add_fail');
				exit(json_encode($retmsg));
			}
		}
	}

	public function edit_user($user_id)
	{
		if (!$this->admin_priv('admin_user'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($this->form_validation->run('admin_user/edit') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['row'] = $this->a->O(array('user_id'=>$user_id));
			$role = $this->r->L(array(),'role_id as id,role_name as name',0,0);
			$this->_d['role'] = array2option($role,$this->_d['row']['role_id']);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'adminuser/edit_user', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			if (!empty($postdata['newpassword']))
			{
				$postdata['password'] = $postdata['newpassword'];
			}
			if ($this->a->M($postdata,array('user_id'=>$user_id)))
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"编辑管理员",$postdata['user_name']);
				$retmsg['code'] = '1';
				$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
				exit(json_encode($retmsg));
			}
			else
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('comm_fail_tip');
				exit(json_encode($retmsg));
			}
		}
	}

	public function del_one_user($user_id)
	{
		if (!$this->admin_priv('admin_user'))
		{
			show_error("您没有权限进行此操作！");
		}
		$sdata = array('user_id'=>$user_id);
		$userinfo = $this->a->O($sdata);
		$this->a->D($sdata);
		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"删除管理员",$userinfo['user_name']);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('success');
		exit(json_encode($retmsg));
	}

	public function del_user()
	{
		if (!$this->admin_priv('admin_user'))
		{
			show_error("您没有权限进行此操作！");
		}
		$postdata = $this->input->post('user_id');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
			$user_id = implode(',',$postdata);
			}
			$userinfo = $this->a->L(array('user_id in(' . $user_id . ')'=>''));
			foreach ($userinfo as $k => $v) $username[] = $v['user_name'];
			$this->a->D(array('user_id in(' . $user_id . ')'=>''));
			$admininfo = $this->isAdmin();
			$this->action_log('1',$admininfo['user_id'],"批量删除管理员",implode(",",$username));
			$retmsg['code'] = '1';
			$retmsg['msg'] = $this->lang->line('success');
			exit(json_encode($retmsg));
		}
		else
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = $this->lang->line('fail');
			exit(json_encode($retmsg));
		}
	}

	
	public function checkOldpasswd($password)
	{

		$postdata = $this->input->post();
		if (!empty($postdata['newpassword']))
		{
			if (empty($postdata['oldpassword']))
			{
				$this->form_validation->set_message('checkOldpasswd', $this->lang->line('required'));
				return false;
			}
			else
			{
				$userinfo = $this->a->O(array('password'=>setEncry($postdata['oldpassword'])));
				if (count($userinfo) == 0)
				{
					$this->form_validation->set_message('checkOldpasswd', $this->lang->line('passwd_fail_old'));
					return false;
				}
				else
				{
					return true;
				}
			}				
		}
		else
		{
			return true;
		}
		
	}

	public function checkrepasswd($password)
	{

		$postdata = $this->input->post();
		if (!empty($postdata['newpassword']))
		{
			if (empty($postdata['renewpassword']))
			{
				$this->form_validation->set_message('checkrepasswd', $this->lang->line('required'));
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
		
	}

	public function add_role($role_id='')
	{
		if (!$this->admin_priv('role'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($this->form_validation->run('role/add') == false)
		{

			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['row'] = $this->r->INIT();
			$this->_d['action'] ="add_role";
			$checkboxdata = array();
			$parentAction = $this->ac->L(array('level'=>'2'),'action_id,action_code as id,action_name as name',0,0,'parent_id');
			foreach ($parentAction as $k => $v)
			{
				$subaction = $this->ac->L(array('parent_id'=>$v['action_id'],'level'=>'3'),'action_code as id,action_name as name',0,0,'parent_id');
				$parentcheckbox[0]['id'] = $v['id'];
				$parentcheckbox[0]['name'] = $v['name'];

				$checkboxdata[$k]['parent_checkbox'] = array2checkbox('parent_action',$parentcheckbox,'');

				$checkboxdata[$k]['sub_checkbox'] = array2checkbox('sub_action',$subaction,'',4);
			}

			$this->_d['checkboxdata'] = $checkboxdata;
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'adminuser/role_info', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();

			$adata['role_name'] = $postdata['role_name'];
			$adata['role_describe'] = $postdata['role_describe'];
			if (empty($postdata['sub_action']))
				$adata['action_list'] = '';
			else
				$adata['action_list'] = implode(",",$postdata['sub_action']);

			if ($this->r->A($adata))
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"添加管理员角色",$postdata['role_name']);
				$retmsg['code'] = '1';
				$retmsg['msg'] = $this->lang->line('add_success');
				exit(json_encode($retmsg));
			}
			else
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('add_fail');
				exit(json_encode($retmsg));
			}

		}
	}

	public function edit_role($role_id)
	{
		if (!$this->admin_priv('role'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($this->form_validation->run('role/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['row'] = $this->r->O(array('role_id'=>$role_id));
			$this->_d['action'] ="edit_role";
			$checkboxdata = array();
			$parentAction = $this->ac->L(array('level'=>'2'),'parent_id,action_id,action_code as id,action_name as name',0,0,'parent_id');
			//print_r($parentAction);
			foreach ($parentAction as $k => $v)
			{
				$subaction = $this->ac->L(array('parent_id'=>$v['action_id'],'level'=>'3'),'action_code as id,action_name as name',0,0,'parent_id');
				//print_r($subaction);
				$parentcheckbox[0]['id'] = $v['id'];
				$parentcheckbox[0]['name'] = $v['name'];
				//print_r($parentcheckbox);
				$checkboxdata[$k]['parent_checkbox'] = array2checkbox('parent_action',$parentcheckbox,'');
				//print_r($checkboxdata);
				$checkboxdata[$k]['sub_checkbox'] = array2checkbox('sub_action',$subaction,explode(',',$this->_d['row']['action_list']),4);
			}

			$this->_d['checkboxdata'] = $checkboxdata;
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'adminuser/role_info', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();

			$mdata['role_name'] = $postdata['role_name'];
			$mdata['role_describe'] = $postdata['role_describe'];
			if (empty($postdata['sub_action']))
				$mdata['action_list'] = '';
			else
				$mdata['action_list'] = implode(",",$postdata['sub_action']);

			if ($this->r->M($mdata,array('role_id'=>$role_id)))
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"编辑管理员角色",$postdata['role_name']);
				$retmsg['code'] = '1';
				$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
				exit(json_encode($retmsg));
			}
			else
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('comm_fail_tip');
				exit(json_encode($retmsg));
			}

		}
	}

	public function del_one_role($role_id)
	{
		$roleinfo = $this->r->O(array('role_id'=>$role_id));
		if (!$this->admin_priv('role'))
		{
			show_error("您没有权限进行此操作！");
		}
		$sdata = array('role_id'=>$role_id);
		$this->r->D($sdata);
		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"删除管理员角色",$roleinfo['role_name']);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('success');
		exit(json_encode($retmsg));
	}

	public function del_role()
	{
		if (!$this->admin_priv('role'))
		{
			show_error("您没有权限进行此操作！");
		}
		$postdata = $this->input->post('role_id');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
			$role_id = implode(',',$postdata);
			}
			$roleinfo = $this->r->L(array('role_id in(' . $role_id . ')'=>''));
			foreach ($roleinfo as $k => $v)
			{
				$rolename[] = $v['role_name'];
			}
			$admininfo = $this->isAdmin();
			$this->action_log('1',$admininfo['user_id'],"批量删除管理员角色",implode(',',$rolename));
			$this->r->D(array('role_id in(' . $role_id . ')'=>''));
			$retmsg['code'] = '1';
			$retmsg['msg'] = $this->lang->line('success');
			exit(json_encode($retmsg));
		}
		else
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = $this->lang->line('fail');
			exit(json_encode($retmsg));
		}
	}

}