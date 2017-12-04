<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ============================================================================
 * 版权所有 2013-2018 余姚市一洋网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.163.com;
 * QQ: 57790081
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/


class Login extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/Admin_model','a');		
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		if ($this->form_validation->run("login/index") == FALSE)
		{	
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'login/index', $this->_d);
		}
		else
		{
			if ($this->_d['cfg']['vercode_adminlogin'] == '1')				
			{
				$varcode = $this->session->userdata('vercode');
				$this->session->unset_userdata('vercode');

				if ($this->input->post('vercode') != $varcode)
				{
					$retmsg['code'] = '0';
					$retmsg['msg'] = '验证码出错';
					exit(json_encode($retmsg));
				}
			}

			$sdata['user_name'] = $this->input->post('username');
			$sdata['password'] = setEncry($this->input->post('passwd'));
			$retmsg = $this->a->getLogin($this->input->post('username'),setEncry($this->input->post('passwd')));
			if (count($retmsg) > 0)
			{
				$this->setAdminAuth($retmsg);
				$retmsg['code'] = '1';
				$retmsg['msg'] = validation_errors();
				$retmsg['tourl'] = site_url('admin/user/setmain');
				exit(json_encode($retmsg));
			}
			else
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('error_login');
				exit(json_encode($retmsg));
			}
		}
	}

	public function modi()
	{
		if ($this->form_validation->run("admin/modi") == FALSE)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->load->view($this->_d['cfg']['tpl_admin'].'login/modi', $this->_d);
		}
		else
		{
			$session = $this->session->userdata('adminfo');
			$postdata['passwd'] = md5($this->input->post("newpasswd"));
			$postdata['mtime'] = time();
			if ($this->a->M($postdata, array('adminid'=>$session['adminid'])) > 0)
			{
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

	public function setmain()
	{
		if ($this->isAdmin() == false) redirect("admin/login"); 

		$this->_d['adminfo'] = $this->session->userdata('adminfo');
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'index/index', $this->_d);
	}

	public function logout()
	{
		parent::adminLogout();
		redirect("admin/login");
	}
}