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
class Homenew extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->model('Category_model','cate');
		$this->load->model('Live_model','lv');
		$this->load->model('Home_model','hm');
		$this->load->model('Userinfo_model','user');

    }


	public function index()
	{
		$this->load->view($this->_d['cfg']['tpl'] . "homenew/index", $this->_d);
	}


}