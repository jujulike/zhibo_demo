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
class Simula extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Advertising_model','ad');
		$this->load->model('Pages_model','pg');	
    }


	public function index()
	{
		// 通栏图片广告
		$this->_d['tlgg'] = $this->ad->O(array('cateid'=>41), 'title,link,imgthumb');
		$this->_d['page'] = $this->pg->O(array('cateid'=>42));
		$this->load->view($this->_d['cfg']['tpl'] . "simula/index", $this->_d);
	}

	public function set()
	{
		// 通栏图片广告
		$this->_d['tlgg'] = $this->ad->O(array('cateid'=>41), 'title,link,imgthumb');
		$this->_d['page'] = $this->pg->O(array('cateid'=>43));

		$this->load->view($this->_d['cfg']['tpl'] . "simula/set", $this->_d);
	}
	public function rule()
	{
		// 通栏图片广告
		$this->_d['tlgg'] = $this->ad->O(array('cateid'=>41), 'title,link,imgthumb');
		$this->_d['page'] = $this->pg->O(array('cateid'=>44));

		$this->load->view($this->_d['cfg']['tpl'] . "simula/rule", $this->_d);
	}
	public function linkus()
	{
		// 通栏图片广告
		$this->_d['tlgg'] = $this->ad->O(array('cateid'=>41), 'title,link,imgthumb');
		$this->_d['page'] = $this->pg->O(array('cateid'=>45));

		$this->load->view($this->_d['cfg']['tpl'] . "simula/linkus", $this->_d);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */