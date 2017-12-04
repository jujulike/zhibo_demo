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
class Advertisement extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Advertisement_model','advertisement');
		$this->load->model('Category_model','c');		
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login");
	}

	public function index()
	{
		$this->tlist();
	}

	public function tlist($alias = "")
	{
		if (!$this->admin_priv('ad_' . $alias))
		{
			show_error("您没有权限进行此操作！");
		}
		$csdata['func'] = 'advertising';
		if ($alias != '') $csdata['alias'] = $alias;
		$cateid = $this->c->L($csdata,'cateid',0,0);
		if (!empty($cateid)) 
		{ 
			foreach ($cateid as $k => $v) { $cateidary[]=$v['cateid'];}
			$sdata['cateid in (' . implode(',',$cateidary). ')'] = '';
			$this->_p['pagenumb'] = 30;
			$list_t = $this->advertisement->L($sdata,'advertid,cateid,title,link,desc,imgthumb,status,sort', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'cateid, sort','asc');
			if (!empty($list_t))
			{
				foreach ($list_t as $k => $v) $cateIdAry[] = $v['cateid'];
				$cateId = implode(',',$cateIdAry);
				$categoryList_t = $this->c->L(array('cateid in (' . $cateId . ')' =>''),'*',0,0);
				$categoryList = cate2array($categoryList_t, 'cateid');
				
				foreach ($list_t as $k => $v)
				{
					if (!empty($categoryList[$v['cateid']])) $list_t[$k]['cateinfo'] = $categoryList[$v['cateid']];
					
				}
			}
			$this->_p['pagecount'] = $this->input->post('pagecount');
			if (empty($this->_p['pagecount'])) 
			{
				$this->_p['pagecount'] = $this->advertisement->C($sdata);
			}
			
		}
		else
		{
			$sdata = array();
			$list_t = array();
			$this->_p['pagecount'] = 0;
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['func'] = "advertising";
		$this->_d['list'] = $list_t;
		$this->_d['alias'] = $alias;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'advertisement/advertisement', $this->_d);
	}

	public function add($func = 'advertising',$alias='')
	{
		if (!$this->admin_priv('ad_' . $alias))
		{
			show_error("您没有权限进行此操作！");
		}

		if ($this->form_validation->run('advertisement/edit') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}

			$this->_d['action'] = 'add';
			$row = $this->advertisement->INIT();
			$row['func'] = $func;
			$this->_d['row'] = $row;
			if (!empty($alias)) $search['alias'] = $alias;
			else $search= array();
			$catedata =  cate2list(0, $this->c->getCateData($func,$search));		
			$this->_d['parentcate'] = array2option($catedata, 1, 1);
			$this->_d['adtype'] = array2option($this->config->item('adtype'), $this->_d['row']['adtype']);
			$this->_d['alias'] =$alias;
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'advertisement/editAdvertisement', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['ctime'] = time();
			$postdata['btime'] = 0;
            unset($postdata['advertid']);
			if ($this->advertisement->A($postdata) > 0)
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"添加广告",$postdata['title']);
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

	public function delAdvertisement($advertid,$alias='')
	{
		if (!$this->admin_priv('ad_' . $alias))
		{
			show_error("您没有权限进行此操作！");
		}
		$sdata['advertid']=$advertid;
		$adinfo = $this->advertisement->O($sdata);
		$this->advertisement->D($sdata);
		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"删除广告",$adinfo['title']);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('success');
		exit(json_encode($retmsg));
	}

	public function delMoreAdvertisement($alias)
	{
		if (!$this->admin_priv('ad_' . $alias))
		{
			show_error("您没有权限进行此操作！");
		}
		$postdata = $this->input->post('advertid');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
				$advertid = implode(',',$postdata);
			}
			$adinfo = $this->advertisement->L(array('advertid in(' . $advertid . ')'=>''));
			foreach ($adinfo as $k => $v)
			{
				$adname[] = $v['title'];
			}
			$this->advertisement->delMoreAdvertisement($advertid);
			$admininfo = $this->isAdmin();
			$this->action_log('1',$admininfo['user_id'],"批量删除广告",implode(',',$adname));
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

	public function editAdvertisement($advertid,$func='advertising',$alias='')
	{
		if (!$this->admin_priv('ad_' . $alias))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($this->form_validation->run('advertisement/edit') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['action'] ="editAdvertisement";
			$sdata['advertid'] = $advertid;
			$this->_d['row'] = $this->advertisement->O($sdata);
			if (!empty($alias)) $search['alias'] = $alias;
			else $search= array();
			$catedata =  cate2list(0, $this->c->getCateData($func,$search));		
			$this->_d['parentcate'] = array2option($catedata, $this->_d['row']['cateid'], 1);
			$this->_d['adtype'] = array2option($this->config->item('adtype'), $this->_d['row']['adtype']);
			$this->_d['alias'] =$alias;
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'advertisement/editAdvertisement', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$sdata['advertid'] = $advertid;
			$postdata['mtime'] = time();
			if ($this->advertisement->M($postdata,$sdata) >0)
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"编辑广告",$postdata['title']);
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


	public function copyAdvertisement($advertid,$alias='')
	{
		if (!$this->admin_priv('ad_' . $alias))
		{
			show_error("您没有权限进行此操作！");
		}
		if (!empty($advertid))
		{
			$row = $this->advertisement->O(array('advertid'=>$advertid));
			unset($row['advertid']);
			$row['status'] = 0;
			if ($this->advertisement->A($row))
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"复制广告",$row['title']);
				$retmsg['code'] = '1';
				$retmsg['msg'] = '复制成功';
				exit(json_encode($retmsg));
			}
		}
		$retmsg['code'] = '0';
		$retmsg['msg'] = '广告参数丢失';
		exit(json_encode($retmsg));
	}

}

?>