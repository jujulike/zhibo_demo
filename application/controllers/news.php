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
class News extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Article_model','article');
		$this->load->model('Category_model','c');
		$this->_d['menu'] = '79';
    }

	// 新闻资讯
	public function tlist($cateid='')
	{
		$cateinfo = $this->c->O(array('cateid'=>$cateid));
		$news_cate = $this->c->L(array('func'=>'article','status'=>'1','parentid'=>$cateinfo['parentid']),'cateid,catename',0,0,'sort');
		$this->_d['news_cate'] = $news_cate;
		$firstcateid = $news_cate[0]['cateid'];
		$this->_d['cateid'] = $cateid;
		$news_cate_t = cate2array($news_cate,'cateid');
		$this->_d['catename'] = $news_cate_t[$cateid]['catename'];
		
		$this->_p['pagenumb'] = 30;
		$sdata['cateid'] = $cateid;
		$sdata['status'] = 1;
		$news = $this->article->L($sdata,'articleid,title,desc,content,ctime',$this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->article->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		
		$this->_d['news'] = $news;
		$this->_d['firstcateid'] = $firstcateid;
		$this->_d['parentcateinfo'] = $this->c->O(array('cateid'=>$cateinfo['parentid']));
		$this->load->view("themes/feibei/news", $this->_d);
	}

	public function detail($cateid='',$id='')
	{
		$cateinfo = $this->c->O(array('cateid'=>$cateid));
		$news_cate = $this->c->L(array('func'=>'article','status'=>'1','parentid'=>$cateinfo['parentid']),'cateid,catename',0,0,'sort');
		$this->_d['news_cate'] = $news_cate;
		$firstcateid = $news_cate[0]['cateid'];
		$news_cate_t = cate2array($news_cate,'cateid');
		$this->_d['catename'] = $news_cate_t[$cateid]['catename'];

		$row = $this->article->O(array('articleid'=>$id));
		$this->_d['cateid'] = $cateid;
		$this->_d['row'] = $row;
		$this->_d['firstcateid'] = $firstcateid;
		$this->_d['parentcateinfo'] = $this->c->O(array('cateid'=>$cateinfo['parentid']));
		$this->load->view("themes/feibei/news_detail", $this->_d);
	}
	
	public function shishi()
	{
		$this->load->view("themes/feibei/shishi", $this->_d);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */