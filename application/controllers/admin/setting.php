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

class Setting extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/config_model','set');
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login");
	}
	
	public function index($settingid)
	{
		if (!$this->admin_priv('setting_' . $settingid))
		{
			show_error("您没有权限进行此操作！");
		}

		if ($this->input->post())
		{	
			$postdata = $this->input->post();
			$mtime = time();

			foreach ($postdata as $k => $v)
			{
				$this->set->M(array('confval'=>$v,'mtime'=>$mtime), array('confkey'=>$k));
			}
			$admininfo = $this->isAdmin();
			$this->action_log('1',$admininfo['user_id'],"编辑系统设置");		
			@unlink(FCPATH . APPPATH . 'cache/config');
			$retmsg['code'] = '1';
			$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
			exit(json_encode($retmsg));
		}
		else
		{
			$this->_d['setting'] = $this->config->item('setting');
			$this->_d['settingid'] = $settingid;
			$this->_d['list'] = $this->set->L(array('status'=>1, 'cfgcate'=>$settingid), '*', 1000,0, 'sort', 'asc');
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'setting/config', $this->_d);

		}
	}

}