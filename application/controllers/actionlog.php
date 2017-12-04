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

/**
*/

class Actionlog extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Actionlog_model','aclog');
		$this->load->model('Userinfo_model','userinfo');
		$this->load->model('admin/Admin_model','admin');
	}

	public function index()
	{
		$sdata = array();
		$this->_p['pagenumb'] = 30;
		$list = $this->aclog->L($sdata,'*',$this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		
		if (!empty($list))
		{
			foreach ($list as $k => $v)
			{
				if ($v['isadmin'] == '1') $adminid[] = $v['userid'];
				else if ($v['isadmin'] == '2') $userid[] = $v['userid'];
			}

			if (!empty($adminid)) $admininfo = cate2array($this->admin->L(array('user_id in (' . implode(",",$adminid) . ')' =>''),'user_id,user_name',0,0),'user_id');
			if (!empty($userid)) $userinfo = cate2array($this->userinfo->L(array('userid in (' . implode(",",$userid) . ')' =>''),'userid,username',0,0),'userid');

			foreach ($list as $k => $v)
			{
				if ($v['isadmin'] == '1')
				{
					if (!empty($admininfo[$v['userid']])) $list[$k]['username'] = $admininfo[$v['userid']]['user_name'];
				}
				if ($v['isadmin'] == '2')
				{
					if (!empty($userinfo[$v['userid']])) $list[$k]['username'] = $userinfo[$v['userid']]['username'];
				}
			}
		}

		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->aclog->C($sdata);
		}

		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['list'] = $list;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'user/log_list', $this->_d);
	}

	public function clearlog()
	{
		if ($this->isAdmin() == false) redirect("admin/login"); 
		$this->db->empty_table('live_action_log');
		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"清空操作日志",'action_log');
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('success');
		exit(json_encode($retmsg));
	}

}