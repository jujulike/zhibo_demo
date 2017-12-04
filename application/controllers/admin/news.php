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
* 教材管理功能
*/

class News extends MY_Controller{

	var $_data = array();

	public function __construct() {
		parent::__construct();
		$this->load->model('News_model','n');		
		$this->load->model('Category_model','cate');		
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		$this->tlist();
	}

	public function tlist()
	{
		if ($this->isAdmin() == false) redirect("admin/user/login"); 

		$sdata = array();
		$offset = $this->uri->segment(4, 0);		
		$this->load->library('pagination');
		$pg['base_url'] = site_url('admin/news/tlist');
		$pg['total_rows'] = $this->n->C($sdata);
		$pg['per_page'] = $this->perpages;
		$pg['uri_segment'] = 4;
		$this->pagination->initialize($pg);
		
		$this->_data['page'] = $this->pagination->create_links();
		$this->_data['count'] = $pg['total_rows'];
		$this->_data['list'] = $this->n->L($sdata, '*', $pg['per_page'], $offset);


		$sdata['func'] = 'news';
		$sdata['status'] = '1';
		$catename = $this->cate->L($sdata, 'cateid,catename');
		foreach ($catename as $k => $v) 
			$category[$v['cateid']] = $v['catename'];

		$list = $this->n->L(array(), '*', $pg['per_page'], $offset, 'sort', 'asc');
		foreach ($list as $k => $v)
		{
			if (!empty($category[$v['cateid']]))
				$list[$k]['catename'] = $category[$v['cateid']];
			else
				$list[$k]['catename'] = '';
		}

		$this->_data['list'] = $list;
		$this->_data['count'] = $pg['total_rows'];
		$this->load->view('admin/news/list', $this->_data);
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
			$this->load->view('admin/news/detail', $this->_data);
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

		if ($this->form_validation->run('news/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}

			$this->_data['row'] = $this->n->O(array('articleid'=>$id));
			$this->_data['act'] = 'modi';

			$catedata =  cate2list(0, $this->cate->getCateData('news','all'));		
			$this->_data['catelist'] = array2option($catedata, $this->_data['row']['cateid'], 1);
			$this->load->view('admin/news/detail', $this->_data);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['mtime'] = time();
			if ($this->n->M($postdata, array('articleid'=>$id)) === true)
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
		$sdata['articleid'] = $id;
		$this->n->D($sdata);
	}
}

?>
