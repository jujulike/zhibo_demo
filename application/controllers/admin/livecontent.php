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

class Livecontent extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/Admin_model','a');		
		$this->load->model('Userinfo_model','u');
		$this->load->model('Livecontent_model','content');
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login"); 
	}
	
	public function index()
	{
		$this->tlist();
	}



	public function tlist()
	{
		if (!$this->admin_priv('live_content'))
		{
			show_error("您没有权限进行此操作！");
		}
		$sdata = array();
		$content = '';
		$s_btime='';
		$s_etime='';
		$postdata = $this->input->post();
		if (!empty($postdata['content']))
		{
			$content = $postdata['content'];
			$sdata['content like '.'\'%' . $content . '%\''] = '';
		}
		if (!empty($postdata['s_btime']))
		{
			$s_btime = $postdata['s_btime'];
			$sdata['ctime >='.strtotime($s_btime." 00:00:00")] = '';
		}
		if (!empty($postdata['s_etime']))
		{
			$s_etime = $postdata['s_etime'];
			$sdata['ctime <='.strtotime($s_etime." 23:59:59")] = '';
		}
		$list = $this->content->L($sdata,'*',$this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->content->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['list'] = $list;
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['content'] = $content;
		$this->_d['s_btime'] = $s_btime;
		$this->_d['s_etime'] = $s_etime;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'livecontent/list', $this->_d);
	}

	public function del($id)
	{
		if (!$this->admin_priv('live_content'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($id == '') exit($this->lang->line('access_error'));
		$sdata['contentid'] = $id;
		$content = $this->content->O($sdata);
		$this->content->D($sdata);
		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"删除内容",$content['content']);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
		exit(json_encode($retmsg));
	}


	public function delmore()
	{
		if (!$this->admin_priv('live_content'))
		{
			show_error("您没有权限进行此操作！");
		}
		$postdata = $this->input->post('contentid');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
			$contentid = implode(',',$postdata);
			}
			$adinfo = $this->content->L(array('contentid in(' . $contentid . ')'=>''));
			foreach ($adinfo as $k => $v)
			{
				$adname[] = $v['content'];
			}
			$this->content->D(array('contentid in(' . $contentid . ')'=>''));
			$admininfo = $this->isAdmin();
			$this->action_log('1',$admininfo['user_id'],"批量删除内容",implode(',',$adname));
			$retmsg['code'] = '1';
			$retmsg['msg'] = $this->lang->line('success');
			exit(json_encode($retmsg));
		}
		else
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '请选择内容';
			exit(json_encode($retmsg));
		}
	}
}

?>
