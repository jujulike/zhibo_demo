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
//error_reporting(2047);
class Service extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Service_model','s');
		if ($this->isAdmin() == false) redirect("admin/login");
		if (!$this->admin_priv('service'))
		{
			show_error("您没有权限进行此操作！");
		}
	}

	public function index()
	{
		$this->listApply();
	}


	public function listApply()
	{
		$sdata = array();
		$this->_p['pagenumb'] = 20;
		$list_t = $this->s->L($sdata,'*', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->s->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['list'] = $list_t;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'service/reserve', $this->_d);
	}


	public function del($id)
	{
		$sdata['id']=$id;
		//$ztinfo = $this->zt->O(array('id'=>$id));
		$this->s->D($sdata);
		// 统计分类
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('success');
		exit(json_encode($retmsg));
	}

	public function delMore()
	{
		$postdata = $this->input->post('id');
		if(!empty($postdata))
		{
			$this->s->D(array('id in (' . implode(",",$postdata) . ')' => ''));
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

?>