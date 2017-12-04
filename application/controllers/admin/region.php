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
* 地区管理功能
*/

class Region extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Region_model','r');
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login");
		if (!$this->admin_priv('region'))
		{
			show_error("您没有权限进行此操作！");
		}
	}
	
	public function index()
	{
		$this->regionList();
	}
	
	//列表
	public function regionList($regionid= '')
	{
		if ($regionid == '')
		{
			$regionid = '1';
		}

		$sdata = array('parentid'=>$regionid);
		$this->_d['list'] = $this->r->L($sdata, '*','','','regionid');
		//print_r($this->_d['list']);
		$parentid = $this->r->O(array('regionid'=>$regionid));
		$this->_d['parentid'] = $parentid['parentid'];
		if (empty($parentid)) $this->_d['regiontype'] = 1;
		else $this->_d['regiontype'] = $parentid['regiontype']+1;
		$this->_d['parent'] = $parentid;
		$this->_d['regionid'] = $regionid;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'region/region', $this->_d);
	}

    //增加地区
	public function addRegion($parentid='',$regiontype = '')
	{
		if ($this->form_validation->run('region/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['row'] = $this->r->INIT();
			$this->_d['parentid'] = $parentid;
			$this->_d['regiontype'] = $regiontype;
			$this->_d['action'] = 'addRegion';
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'region/region_edit', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();		
			$postdata['ctime'] = time();
			if ($this->r->C(array('name'=>$postdata['name'],'parentid'=>$postdata['parentid'])) > 0)
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('region_check_exist');
				exit(json_encode($retmsg));
			}

			if ($this->r->A($postdata) > 0)
			{
				$retmsg['code'] = '1';
				$retmsg['msg'] = $this->lang->line('region_success_tip');
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

	//修改地区
	public function editRegion($regionid='')
	{
		if ($this->form_validation->run('region/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['row'] = $this->r->O(array('regionid'=>$regionid));
			if(empty($this->_d['row']))
			{
				$this->_d['row'] = $this->r->INIT();
			}
			$this->_d['action'] = 'editRegion';
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'region/region_edit', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['mtime'] = time();
			// 判断是否重名
			$namearry = $this->r->L(array(),'regionid,name');
			foreach ($namearry as $k => $v)
			{
				if ($postdata['name'] == $v['name'] && $postdata['parentid'] == $v['parentid'] && ($postdata['regionid'] != $v['regionid']))
				{
					$retmsg['code'] = '0';
					$retmsg['msg'] = $this->lang->line('region_check_exist');
					exit(json_encode($retmsg));
				}
			}
			
			if ($this->r->M($postdata, array('regionid'=>$regionid))>0)
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
	
	//地区删除
	public function del($regionid='')
	{
		$sdata['regionid'] = $regionid;
		if ($this->r->C(array('parentid'=>$sdata['regionid'])) > 0)
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = $this->lang->line('region_check_children');
			exit(json_encode($retmsg));
		}
		
		$this->r->D($sdata);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('region_delete_success');
		exit(json_encode($retmsg));
		
	}

	//地区删除
	public function delMore()
	{
		$postdata = $this->input->post('regionid');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
			$regionid = implode(',',$postdata);
			}
			if ($this->r->O(array('parentid in (' . $regionid . ')' => '')))
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('region_check_children');
				exit(json_encode($retmsg));
			}
			$this->r->D(array('regionid in (' . $regionid . ')' => ''));
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
