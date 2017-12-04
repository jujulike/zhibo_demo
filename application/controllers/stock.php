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
class Stock extends MY_Controller {

	public function __construct() {
        parent::__construct();

		$this->load->model('Livemaster_model','master');		
		$this->load->model('Live_model','room');		
		$this->load->model('Category_model','cate');		
		$this->load->model('Article_model','article');		
		$this->load->model('Advertising_model','ad');		

    }


	public function index()
	{
		// 今日关注
		$this->_d['jrgz'] = $this->article->L(array('cateid'=>132), 'title,url', 4, 0, 'sort', 'asc');
		// 今日策略
		$this->_d['jrcl'] = $this->article->L(array('cateid'=>133), 'title,url', 4, 0, 'sort', 'asc');

		// 右栏图片广告
		$this->_d['tpgg'] = $this->ad->O(array('cateid'=>135), 'title,link,imgthumb');

		// 中间通栏图片广告
		$this->_d['tlgg'] = $this->ad->O(array('cateid'=>134), 'title,link,imgthumb');

		// 直播室广告
		$this->_d['zbsgg'] = $this->ad->O(array('cateid'=>34), 'title,link,desc');
		$this->load->view($this->_d['cfg']['tpl'] . "stock/index", $this->_d);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */