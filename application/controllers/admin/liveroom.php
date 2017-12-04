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
* 
*/

class Liveroom extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Live_model','n');		
		$this->load->model('Category_model','cate');		
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login"); 
	}
	
	public function index($cateid)
	{
		show_404();
	}

	public function tlist($cateid = '')
	{

		if (!$this->admin_priv('live_room'))
		{
			show_error("您没有权限进行此操作！");
		}

		if ($cateid == '') exit($this->lang->line('access_error'));

		$master_sdata = array('cateid'=>$cateid);
		$sdata['func'] = 'live';
		//$sdata['status'] = '1';
		$catename = $this->cate->L($sdata, 'cateid,catename');
		foreach ($catename as $k => $v) 
			$category[$v['cateid']] = $v['catename'];

		$list = $this->n->L($master_sdata, '*', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
			
		foreach ($list as $k => $v)
		{
			if (!empty($category[$v['cateid']]))
				$list[$k]['catename'] = $category[$v['cateid']];
			else
				$list[$k]['catename'] = '';
		}
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->n->C($master_sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$master_sdata);
		$this->_d['list'] = $list;
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'liveroom/list', $this->_d);
	}

	public function add()
	{

		if ($this->form_validation->run() == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}

			$this->_data['row'] = $this->n->INIT();
			$this->_data['act'] = 'add';

			$catedata =  cate2list(0, $this->cate->getCateData('news','all'));
			$this->_data['catelist'] = array2option($catedata, '', 1);
			$this->load->view('admin/liveroom/detail', $this->_data);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['ctime'] = time();

			if ($this->n->A($postdata) > 0)
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

	public function modi($id)
	{

		$this->load->model('Userinfo_model','u');		

		if ($this->form_validation->run('live/roomapp') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}

			$row = $this->n->O(array('roomid'=>$id));
			/*$userinfo = $this->u->O(array('userid'=>$row['userid']));
			$row['name'] = $userinfo['name'];
			$row['username'] = $userinfo['username'];
			$row['user_imgthumb'] = $userinfo['imgthumb'];*/

			$u = $this->u->L(array('ismaster'=>$id));
			foreach ($u as $k => $v) $master[] = $v['name'] . '('.$v['username'].')';

			$row['master'] = $master;

			$this->_d['row'] = $row;
			$this->_d['act'] = 'modi';


			$catedata =  cate2list(0, $this->cate->getCateData('live','all'));		
			$this->_d['cateid'] = array2option($catedata, $this->_d['row']['cateid'], 1);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'liveroom/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['mtime'] = time();
			if ($this->n->M($postdata, array('roomid'=>$id)) === true)
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

	public function del($id)
	{
		if ($id == '') exit($this->lang->line('access_error'));
		$this->load->model('Livemaster_model','m');
		$sdata = array('roomid'=>$id);
		if ($this->m->C($sdata) > 0)
		{
			$this->m->D($sdata);
		
		}

		//	$sdata['roomid'] = $id;
			$this->n->D($sdata);	
	}
}

?>
