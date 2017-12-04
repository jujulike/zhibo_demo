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
class Aboutus extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Category_model','cate');
		$this->load->model('Pages_model','pg');
		$aboutus = cate2array($this->pg->L(array('cateid'=>'100','status'=>'1'),'pageid,title,content',0,0,'sort'),'pageid');
		$this->_d['aboutus'] = $aboutus;
		$this->_d['menu'] = '77';
    }

	// 关于我们
	public function page($pageid='')
	{
		$this->_d['pageid'] = $pageid;
		$this->load->view("themes/feibei/aboutus", $this->_d);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */