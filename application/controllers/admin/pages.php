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
class Pages extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Pages_model','pg');
		$this->load->model('Category_model','c');		
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login");
		if (!$this->admin_priv('page'))
		{
			show_error("您没有权限进行此操作！");
		}
	}

	public function index()
	{
		$this->listPage();
	}

	public function listPage()
	{
		$sdata = array();
		$this->_p['pagenumb'] = 45;
		$list_t = $this->pg->L($sdata,'pageid,cateid,title,status', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'pageid','desc');
		if (!empty($list_t))
		{
			foreach ($list_t as $k => $v) $cateIdAry[] = $v['cateid'];
			$cateId = implode(',',$cateIdAry);
			$categoryList_t = $this->c->L(array('cateid in (' . $cateId . ')' =>''));
			$_t = cate2array($this->config->item("showtype"),'id');
			foreach ($categoryList_t as $k => $v)
			{
				if (!empty($v['showtype']))
				{
					$showtype=array();
					$showtype=explode(",",$v['showtype']);
					
			
					if (!empty($showtype))
					{
						$showtext = array();
						foreach ($showtype as $k2 => $v2)
						{
							if (!empty($_t[$v2])) $showtext[$k2] = $_t[$v2]['name'];
						}
					}
					if (!empty($showtext)) $categoryList_t[$k]['showtext'] = implode(",",$showtext);
				}
			}
			$categoryList = cate2array($categoryList_t, 'cateid');
			
			foreach ($list_t as $k => $v)
			{
				if (!empty($categoryList[$v['cateid']])) $list_t[$k]['cateinfo'] = $categoryList[$v['cateid']];
				
			}
		}
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->pg->C();
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['list'] = $list_t;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'page/list', $this->_d);
	}

	public function add($func = 'pages')
	{

		if ($this->form_validation->run('article/edit') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}

			$this->_d['action'] = 'add';
			$row = $this->pg->INIT();
			$row['func'] = $func;
			$this->_d['row'] = $row;
			$catedata =  cate2list(0, $this->c->getCateData('pages'));
			$this->_d['parentcate'] = array2option($catedata, '', 1);
			//$template =$this->tm->L(array(),'templateid as id,title as name','','','templateid');
			//$this->_d['template'] = array2option($template,$this->_d['row']['templateid']);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'page/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['ctime'] = time();
			if ($this->pg->A($postdata) > 0)
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

	public function delPage($pageid)
	{
		$sdata['pageid']=$pageid;
		$this->pg->D($sdata);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('success');
		exit(json_encode($retmsg));
	}

	public function delMorePage()
	{
		$postdata = $this->input->post('pageid');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
				$pageid = implode(',',$postdata);
			}
			$this->pg->D(array('pageid in (' . $pageid . ')' => ''));
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

	public function editPage($pageid)
	{
		if ($this->form_validation->run('article/edit') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['action'] ="editPage";
			$sdata['pageid'] = $pageid;
			$this->_d['row'] = $this->pg->O($sdata);
			$catedata =  cate2list(0, $this->c->getCateData('pages'));
			$this->_d['parentcate'] = array2option($catedata, $this->_d['row']['cateid'],1);
			//$template =$this->tm->L(array(),'templateid as id,title as name','','','templateid');
			//$this->_d['template'] = array2option($template,$this->_d['row']['templateid']);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'page/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$sdata['pageid'] = $pageid;
			$postdata['mtime'] = time();
			if ($this->pg->M($postdata,$sdata) >0)
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

	public function search()
	{

	}

}

?>