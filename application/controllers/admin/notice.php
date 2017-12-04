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
class Notice extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Notice_model','notice');		
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login");
		if (!$this->admin_priv('notice'))
		{
			show_error("您没有权限进行此操作！");
		}
	}

	public function index()
	{
		$this->listNotice();
	}

	public function listNotice()
	{
		$sdata = array();
		$postdata = $this->input->post();
		$s_title='';
		if (!empty($postdata['s_title']))
		{
			$sdata['title like \'%'.$postdata['s_title'].'%\''] = '';
			$s_title = $postdata['s_title'];
		}
		$this->_p['pagenumb'] = 10;
		$list_t = $this->notice->L($sdata,'noticeid,title,status,sort,ctime', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->notice->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['list'] = $list_t;
		$this->_d['s_title'] = $s_title; 
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'notice/list', $this->_d);
	}

	public function add()
	{

		if ($this->form_validation->run('notice/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}

			$this->_d['action'] = 'add';
			$row = $this->notice->INIT();
			$this->_d['row'] = $row;
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'notice/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['ctime'] = time();
			if ($this->notice->A($postdata) > 0)
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

	public function delArticle($articleid)
	{
		$sdata['noticeid']=$articleid;
		$this->notice->D($sdata);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('success');
		exit(json_encode($retmsg));
	}

	public function delMoreArticle()
	{
		$postdata = $this->input->post('noticeid');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
				$noticeid = implode(',',$postdata);
			}
			$this->notice->D(array('noticeid in (' . $noticeid . ')' => ''));
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

	public function editArticle($articleid)
	{
		if ($this->form_validation->run('notice/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['action'] ="editArticle";
			$sdata['noticeid'] = $articleid;
			$this->_d['row'] = $this->notice->O($sdata);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'notice/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$sdata['noticeid'] = $articleid;
			$postdata['mtime'] = time();
			if ($this->notice->M($postdata,$sdata) >0)
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

	public function copyArticle($articleid)
	{
		if (!empty($articleid))
		{
			$row = $this->notice->O(array('noticeid'=>$articleid));
			unset($row['noticeid']);
			$row['status'] = 0;
			if ($this->notice->A($row))
			{
				$retmsg['code'] = '1';
				$retmsg['msg'] = '复制成功';
				exit(json_encode($retmsg));
			}
		}
		$retmsg['code'] = '0';
		$retmsg['msg'] = '资讯参数丢失';
		exit(json_encode($retmsg));
	}

}

?>