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

class Handan extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/Admin_model','a');		
		$this->load->model('Userinfo_model','u');
		$this->load->model('Handan_model','hd');
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login"); 
	}
	
	public function index()
	{
		$this->tlist('29');
	}



	public function tlist($masterid = '')
	{
		if (empty($masterid)) show_error("主题ID丢失!");

		if (!$this->admin_priv('live_handan'))
		{
			show_error("您没有权限进行此操作！");
		}


		$sdata = array('masterid'=>$masterid);
		$postdata = $this->input->post();
		$list = $this->hd->L($sdata,'*',$this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->hd->C($sdata);
		}

		$this->_d['masterid'] = $masterid;

		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['list'] = $list;
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'handan/list', $this->_d);
	}

	public function act($masterid, $id='')
	{
		if (empty($masterid)) show_error("主题ID丢失!");

		if (!$this->admin_priv('live_handan'))
		{
			show_error("您没有权限进行此操作！");
		}

		$this->_d['masterid'] = $masterid;

		$postdata = $this->input->post();
		if(!empty($postdata))
		{
			if (empty($postdata['id']))
			{
				$postdata['ctime'] = time();
				if ($this->hd->A($postdata) > 0)
				{
					$admininfo = $this->isAdmin();
					$this->action_log('1',$admininfo['user_id'],"添加喊单", $postdata['handan_type'] . $postdata['handan_product']);
					$retmsg['code'] = '1';
					$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
					exit(json_encode($retmsg));
				}
			}
			else
			{
				$postdata['mtime'] = time();
				if ($this->hd->M($postdata, array('id'=>$postdata['id'])))
				{
					$admininfo = $this->isAdmin();
					$this->action_log('1',$admininfo['user_id'],"修改喊单", $postdata['handan_type'] . $postdata['handan_product']);
					$retmsg['code'] = '1';
					$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
					exit(json_encode($retmsg));
				}				
			}

			$retmsg['code'] = '0';
			$retmsg['msg'] = $this->lang->line('comm_fail_tip');
			exit(json_encode($retmsg));
		}
		else
		{
			if (empty($id))
				$this->_d['row']= $this->hd->INIT();
			else
				$this->_d['row'] = $this->hd->O(array('id'=>$id));
			$this->_d['handan_type'] = $this->config->item('handan_type');
			$this->_d['handan_product'] = $this->config->item('handan_product');
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'handan/add', $this->_d);
		}
	}


	public function del($id)
	{
		if (!$this->admin_priv('live_handan'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($id == '') exit($this->lang->line('access_error'));
		$sdata['id'] = $id;
		$content = $this->hd->O($sdata);
		$this->hd->D($sdata);
		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"删除内容", $content['handan_type'] . $content['handan_product']);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
		exit(json_encode($retmsg));
	}


	public function delmore()
	{
		if (!$this->admin_priv('live_handan'))
		{
			show_error("您没有权限进行此操作！");
		}
		$postdata = $this->input->post('id');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
			$contentid = implode(',',$postdata);
			}
			$adinfo = $this->hd->L(array('id in(' . $contentid . ')'=>''));
			foreach ($adinfo as $k => $v)
			{
				$adname[] = $v['handan_type'] . $v['handan_product'];
			}
			$this->hd->D(array('id in(' . $contentid . ')'=>''));
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
