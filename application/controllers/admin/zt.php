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
class Zt extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Zt_model','zt');
		$this->load->model('Template_model','t');
		$this->load->model('Ztapply_model','a');
		$this->load->model('Userinfo_model','u');
		$this->load->model('Category_model','c');		
		$this->load->library('form_validation');
		$this->load->helper('valid');
		if ($this->isAdmin() == false) redirect("admin/login");
		if (!$this->admin_priv('zt'))
		{
			show_error("您没有权限进行此操作！");
		}
	}

	public function index()
	{
		$this->listZt();
	}

	public function listZt()
	{
		$sdata = array();
		$postdata = $this->input->post();
		/*$s_title='';
		$s_cateid='';
		if (!empty($postdata['s_title']))
		{
			$sdata['title like \'%'.$postdata['s_title'].'%\''] = '';
			$s_title = $postdata['s_title'];
		}
		if (!empty($postdata['s_cateid']))
		{
			$sdata['cateid'] = $postdata['s_cateid'];
			$s_cateid=$postdata['s_cateid'];
		}*/
		$this->_p['pagenumb'] = 20;
		$list_t = $this->zt->L($sdata,'*', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		/*if (!empty($list_t))
		{
			foreach ($list_t as $k => $v)
			{
				$cateIdAry[] = $v['cateid'];
			}
			$cateId = implode(',',$cateIdAry);
			$categoryList_t = $this->c->L(array('cateid in (' . $cateId . ')' =>''));
			$categoryList = cate2array($categoryList_t, 'cateid');
			
			foreach ($list_t as $k => $v)
			{
				if (!empty($categoryList[$v['cateid']])) $list_t[$k]['cateinfo'] = $categoryList[$v['cateid']];		
			}
		}*/
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->zt->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['list'] = $list_t;
		/*$catedata =  cate2list(0, $this->c->getCateData('zt'));		
		$this->_d['s_cate'] = array2option($catedata, $postdata['s_cateid'], 1);
		$this->_d['s_title'] = $s_title; */
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'zt/list', $this->_d);
	}

	public function add($func = 'zt')
	{

		if ($this->form_validation->run('zt/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}

			$this->_d['action'] = 'add';
			$row = $this->zt->INIT();
			$row['func'] = $func;
			$this->_d['row'] = $row;
			//$catedata =  cate2list(0, $this->c->getCateData('zt'));		
			//$this->_d['parentcate'] = array2option($catedata, '', 1);
			$zt_tempalte = $this->t->L(array(),'id,temp_name as name');
			$this->_d['zt_tempalte'] = array2option($zt_tempalte);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'zt/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['ctime'] = time();
			$postdata['mtime'] = time();
			//$admininfo = $this->isAdmin();
			//$postdata['adminid'] = $admininfo['adminid'];
			$postdata['audit'] = '2';
			//$postdata['btime'] = strtotime($postdata['btime']);
			//$postdata['etime'] = strtotime($postdata['etime']);
			if ($this->zt->A($postdata) > 0)
			{
				//$this->c->countcate($postdata['cateid'],'add');
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

	public function delArticle($id)
	{
		$sdata['id']=$id;
		$this->zt->D($sdata);
		// 统计分类
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('success');
		exit(json_encode($retmsg));
	}

	public function delMoreArticle()
	{
		$postdata = $this->input->post('id');
		if(!empty($postdata))
		{
			$this->zt->D(array('id in (' . implode(",",$postdata) . ')' => ''));
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

	public function editArticle($id)
	{
		$ztinfo = $this->zt->O(array('id'=>$id));
		if ($this->form_validation->run('zt/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['action'] ="editArticle";
			$sdata['id'] = $id;
			$row = $this->zt->O($sdata);
			$this->_d['row'] = $row;
			//$catedata =  cate2list(0, $this->c->getCateData('zt'));		
			//$this->_d['parentcate'] = array2option($catedata, $this->_d['row']['cateid']);
			$zt_tempalte = $this->t->L(array(),'id,temp_name as name');
			$this->_d['zt_tempalte'] = array2option($zt_tempalte,$row['zt_template']);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'zt/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			//$admininfo = $this->isAdmin();
			//$postdata['mid'] = $admininfo['adminid'];
			$sdata['id'] = $id;
			$postdata['mtime'] = time();
			//$postdata['btime'] = strtotime($postdata['btime']);
			//$postdata['etime'] = strtotime($postdata['etime']);
			if ($this->zt->M($postdata,$sdata) >0)
			{
				/*if ($ztinfo['cateid'] != $postdata['cateid'])
				{
					$this->c->countcate($postdata['cateid'],'add');
					$this->c->countcate($ztinfo['cateid'],'del');
				}*/
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

	public function copyArticle($id)
	{
		if (!empty($id))
		{
			$row = $this->zt->O(array('id'=>$id));
			unset($row['id']);
			$row['status'] = 0;
			$row['ctime'] = time();
			$row['audit'] = '2';
			if ($this->zt->A($row))
			{
				$this->c->countcate($row['cateid'],'add');
				$retmsg['code'] = '1';
				$retmsg['msg'] = '复制成功';
				exit(json_encode($retmsg));
			}
		}
		$retmsg['code'] = '0';
		$retmsg['msg'] = '资讯参数丢失';
		exit(json_encode($retmsg));
	}

	public function listApply($id)
	{
		$sdata = array();
		$this->_p['pagenumb'] = 20;
		$list_t = $this->a->L($sdata,'*', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->a->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['zt'] = $this->zt->O(array('id'=>$id));
		$this->_d['list'] = $list_t;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'zt/applylist', $this->_d);
	}

	public function addApply($zt_id='')
	{
		if ($this->form_validation->run('apply/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['action'] ="addApply";
			$row = $this->a->INIT();
			$this->_d['zt_id'] = $zt_id;
			$this->_d['row'] = $row;
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'zt/apply_detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['ctime'] = time();
			if ($this->a->A($postdata) >0)
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

	public function editApply($id)
	{
		if ($this->form_validation->run('apply/add') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['action'] ="editApply";
			$sdata['id'] = $id;
			$row = $this->a->O($sdata);
			$this->_d['row'] = $row;
			$this->_d['zt_id'] = $row['zt_id'];
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'zt/apply_detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$sdata['id'] = $id;
			$postdata['mtime'] = time();
			if ($this->a->M($postdata,$sdata) >0)
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
		$sdata['id']=$id;
		//$ztinfo = $this->zt->O(array('id'=>$id));
		$this->a->D($sdata);
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
			$this->a->D(array('id in (' . implode(",",$postdata) . ')' => ''));
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


	// 电话验证
	public function phone_Check($tel)
	{
		if (!empty($tel) && !isPhone($tel))
		{
			$this->form_validation->set_message('phone_Check', $this->lang->line('error_phone'));
			return FALSE;
		}
		else
		{
			return true;
		}
	}

	// 手机验证
	public function mobile_Check($mobile)
	{
		if (!empty($mobile) && !isMobile($mobile))
		{
			$this->form_validation->set_message('mobile_Check', $this->lang->line('error_mobile'));
			return FALSE;
		}
		else
		{
			return true;
		}
	}

	// 电话和手机验证
	public function tel_Check($tel)
	{
		if (!empty($tel))
		{
			if (!isPhone($tel) && !isMobile($tel))
			{
				$this->form_validation->set_message('tel_Check', $this->lang->line('error_tel'));
				return FALSE;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}

}

?>