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
class Help extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Advertising_model','ad');
		$this->load->model('Category_model','cate');
		$this->load->model('Pages_model','pg');	
    }

	// 平台介绍
	public function intro()
	{
		// 通栏图片广告
		$this->_d['page'] = $this->pg->O(array('cateid'=>52));
		$this->load->view($this->_d['cfg']['tpl'] . "help/intro", $this->_d);
	}
	// 联系我们
	public function contact()
	{
		// 通栏图片广告
		$this->_d['page'] = $this->pg->O(array('cateid'=>53));

		$this->load->view($this->_d['cfg']['tpl'] . "help/contact", $this->_d);
	}

	// 服务协议
	public function service()
	{
		// 通栏图片广告
		$this->_d['page'] = $this->pg->O(array('cateid'=>54));

		$this->load->view($this->_d['cfg']['tpl'] . "help/service", $this->_d);
	}

	// 模板页面
	public function perpage($cateid)
	{
		$this->_d['page'] = $this->pg->O(array('cateid'=>$cateid,'status'=>1));
		$cate = $this->cate->O(array('cateid'=>$cateid,'status'=>1));
		$this->_d['cateid'] = $cate['cateid'];
		$this->_d['catename'] = $cate['catename'];

		$this->load->view($this->_d['cfg']['tpl'] . "help/page", $this->_d);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */