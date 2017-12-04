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

class Qacontent extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/Admin_model','a');		
		$this->load->model('Userinfo_model','u');
		$this->load->model('Livequestion_model','qa');
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login"); 
	}
	
	public function index()
	{
		$this->tlist();
	}



	public function tlist()
	{
		if (!$this->admin_priv('qa_content'))
		{
			show_error("您没有权限进行此操作！");
		}
		$sdata = array();
		$questioncontent = '';
		$answercontent = '';
		$question_btime='';
		$question_etime='';
		$answer_btime='';
		$answer_etime='';
		$postdata = $this->input->post();
		if (!empty($postdata['questioncontent']))
		{
			$questioncontent = $postdata['questioncontent'];
			$sdata['questioncontent like '.'\'%' . $questioncontent . '%\''] = '';
		}
		if (!empty($postdata['answercontent']))
		{
			$answercontent = $postdata['answercontent'];
			$sdata['answercontent like '.'\'%' . $answercontent . '%\''] = '';
		}
		if (!empty($postdata['question_btime']))
		{
			$question_btime = $postdata['question_btime'];
			$sdata['ctime >='.strtotime($question_btime." 00:00:00")] = '';
		}
		if (!empty($postdata['question_etime']))
		{
			$question_etime = $postdata['question_etime'];
			$sdata['ctime <='.strtotime($question_etime." 23:59:59")] = '';
		}
		if (!empty($postdata['answer_btime']))
		{
			$answer_btime = $postdata['answer_btime'];
			$sdata['mtime >='.strtotime($answer_btime." 00:00:00")] = '';
		}
		if (!empty($postdata['answer_etime']))
		{
			$answer_etime = $postdata['answer_etime'];
			$sdata['mtime <='.strtotime($answer_etime." 23:59:59")] = '';
		}
		$list = $this->qa->L($sdata,'*',$this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->qa->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['list'] = $list;
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['questioncontent'] = $questioncontent;
		$this->_d['answercontent'] = $answercontent;
		$this->_d['question_btime'] = $question_btime;
		$this->_d['question_etime'] = $question_etime;
		$this->_d['answer_btime'] = $answer_btime;
		$this->_d['answer_etime'] = $answer_etime;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'qacontent/list', $this->_d);
	}


	public function detail($id)
	{
		if (!$this->admin_priv('qa_content'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($id == '') exit($this->lang->line('access_error'));

		$row = $this->qa->O(array('questionid'=>$id));
		if (empty($row)) exit($this->lang->line('access_error'));
		$this->_d['row'] = $row;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'qacontent/detail', $this->_d);
	}

	public function del($id)
	{
		if (!$this->admin_priv('qa_content'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($id == '') exit($this->lang->line('access_error'));
		$sdata['questionid'] = $id;
		$content = $this->qa->O($sdata);
		$this->qa->D($sdata);
		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"删除内容",$content['questioncontent']);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
		exit(json_encode($retmsg));
	}


	public function delmore()
	{
		if (!$this->admin_priv('qa_content'))
		{
			show_error("您没有权限进行此操作！");
		}
		$postdata = $this->input->post('questionid');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
			$questionid = implode(',',$postdata);
			}
			$adinfo = $this->qa->L(array('questionid in(' . $questionid . ')'=>''));
			foreach ($adinfo as $k => $v)
			{
				$adname[] = $v['questioncontent'];
			}
			$this->qa->D(array('questionid in(' . $questionid . ')'=>''));
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
