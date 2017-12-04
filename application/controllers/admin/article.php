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
class Article extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Article_model','article');
		$this->load->model('Category_model','c');		
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login");
		if (!$this->admin_priv('article'))
		{
			show_error("您没有权限进行此操作！");
		}
	}

	public function index()
	{
		$this->listArticle();
	}

	public function listArticle()
	{
		$sdata = array();
		$this->_p['pagenumb'] = 30;
		$list_t = $this->article->L($sdata,'articleid,cateid,title,status,sort,ctime', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'articleid','desc');
		if (!empty($list_t))
		{
			foreach ($list_t as $k => $v) $cateIdAry[] = $v['cateid'];
			$cateId = implode(',',$cateIdAry);
			$categoryList_t = $this->c->L(array('cateid in (' . $cateId . ')' =>''));
			$categoryList = cate2array($categoryList_t, 'cateid');
			
			foreach ($list_t as $k => $v)
			{
				if (!empty($categoryList[$v['cateid']])) $list_t[$k]['cateinfo'] = $categoryList[$v['cateid']];
				
			}
		}

		$_t = cate2array($this->config->item("showtype"),'id');
		foreach ($list_t as $k => $v)
		{
			$showtype = array();
			if (!empty($v['cateinfo']['showtype']))
			{
				$showtype=explode(",",$v['cateinfo']['showtype']);
				
				if (!empty($showtype))
				{
					foreach ($showtype as $k2 => $v2)
					{
						if (!empty($_t[$v2])) $showtext[$k2] = $_t[$v2]['name'];
					}
				}
				if (!empty($showtext)) $list_t[$k]['cateinfo']['showtext'] = implode(",",$showtext);
			}
		}
		$this->_p['pagecount'] = $this->input->post('pagecount');
			if (empty($this->_p['pagecount'])) 
			{
				$this->_p['pagecount'] = $this->article->C();
			}
				$this->_d['page'] = eyPage($this->_p,$sdata);
				$this->_d['pagecount'] = $this->_p['pagecount'];
				$this->_d['list'] = $list_t;
				$this->load->view($this->_d['cfg']['tpl_admin'] . 'article/list', $this->_d);
	}

	public function add($func = 'article')
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
			$row = $this->article->INIT();
			$row['func'] = $func;
			$this->_d['row'] = $row;
			$catedata =  cate2list(0, $this->c->getCateData('article'));		
			$this->_d['parentcate'] = array2option($catedata, '', 1);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'article/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['ctime'] = time();
			$articleid = $this->article->A($postdata);
			if ( $articleid > 0)
			{
				//附件入库
				if (!empty($postdata['imgsource']))
				{
					// 原图
					$source_imgthumb = $postdata['imgsource'];
					// 切割图
					$imgthumb = $postdata['attachpath'];

					// 附件入库
					$this->load->module("attached/upload/addAttach",array($articleid,'article',$imgthumb,$source_imgthumb));
				}

				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"添加文章",$postdata['title']);
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
		$sdata['articleid']=$articleid;
		$adinfo = $this->article->O($sdata);
		$this->article->D($sdata);
		// 附件删除
		$this->load->module("attached/upload/delAttach",array($articleid,'article'));

		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"删除文章",$adinfo['title']);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('success');
		exit(json_encode($retmsg));
	}

	public function delMoreArticle()
	{
		$postdata = $this->input->post('articleid');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
				$articleid = implode(',',$postdata);
			}
			$adinfo = $this->article->L(array('articleid in(' . $articleid . ')'=>''));
			foreach ($adinfo as $k => $v)
			{
				$adname[] = $v['title'];
			}
			$this->article->D(array('articleid in (' . $articleid . ')' => ''));
			// 附件删除
			$this->load->module("attached/upload/delAttach",array($postdata,'article'));
			$admininfo = $this->isAdmin();
			$this->action_log('1',$admininfo['user_id'],"批量删除文章",implode(',',$adname));
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
		if ($this->form_validation->run('article/edit') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			$this->_d['action'] ="editArticle";
			$sdata['articleid'] = $articleid;
			$this->_d['row'] = $this->article->O($sdata);
			$catedata =  cate2list(0, $this->c->getCateData('article'));		
			$this->_d['parentcate'] = array2option($catedata, $this->_d['row']['cateid'],1);

			// 附件取得
			$attach = $this->getAttach($articleid,'article');
			if ($attach)
			{
				$this->_d['attach'] = $attach;
			}
			
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'article/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			//附件入库
			if (!empty($postdata['imgsource']))
			{
				// 原图
				$source_imgthumb = $postdata['imgsource'];
				// 切割图
				$imgthumb = $postdata['attachpath'];

				// 附件入库
				$this->load->module("attached/upload/addAttach",array($articleid,'article',$imgthumb,$source_imgthumb));
			}

			$sdata['articleid'] = $articleid;
			$postdata['mtime'] = time();
			if ($this->article->M($postdata,$sdata) >0)
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"编辑文章",$postdata['title']);
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
			$row = $this->article->O(array('articleid'=>$articleid));
			unset($row['articleid']);
			$row['status'] = 0;
			if ($this->article->A($row))
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"复制文章",$row['title']);
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