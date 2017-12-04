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
class Page extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Category_model','cate');
		$this->load->model('Pages_model','pg');
		$this->_d['menu'] = '77';
    }

	// 
	public function d($pageid='')
	{
		$this->_d['pageid'] = $pageid;
		$pg = $this->pg->O(array('pageid'=>$pageid));
		$cateinfo = $this->cate->O(array('cateid'=>$pg['cateid']));
		$this->_d['cateinfo'] = $cateinfo;
		$this->_d['pg'] = $pg;
		$this->_d['cateid'] = $pg['cateid'];
		$pagecate = cate2array($this->pg->L(array('cateid'=>$pg['cateid'],'status'=>'1'),'pageid,title,content',0,0,'sort'),'pageid');
		$this->_d['pagecate'] = $pagecate;
		$this->_d['firstpage'] = $this->pg->O(array('cateid'=>$pg['cateid'],'status'=>'1'),'pageid,title,content','sort','asc');
		$this->load->view("themes/feibei/page", $this->_d);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */