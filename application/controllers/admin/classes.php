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

class Classes extends MY_Controller{

	public function __construct() {
		parent::__construct();
		if ($this->isAdmin() == false) redirect("admin/login");
		if (!$this->admin_priv('classes'))
		{
			show_error("您没有权限进行此操作！");
		}
	}

	public function index()
	{
		$this->setting();
	}


	public function setting($roomid = '26')
	{
		$postdata = $this->input->post();
		$this->_d['weekdate'] = $this->config->item('classes_setdate');

		$setpath = FCPATH . APPPATH . 'cache/classes/';
		if (!file_exists($setpath . $roomid)) mkdir($setpath . $roomid, 0777);

		$setfile = $setpath . $roomid . '/setting';
		
		if (empty($postdata))
		{
			if (file_exists($setfile))
			{
				$_postdata = unserialize(file_get_contents($setfile, FILE_BINARY, NULL, 0, 4096));
				$this->_d['class_bime'] = $_postdata['class_btime'];
				$this->_d['class_etime'] = $_postdata['class_etime'];
				$this->_d['class_name'] = $_postdata['class_name'];
			}
		}
		else 
		{
			file_put_contents($setfile, serialize($postdata), LOCK_EX);
			$ret['code'] = 1;
			$ret['msg'] = '修改成功';
			exit(json_encode($ret));
		}

		$this->_d['roomid'] = $roomid;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'classes/setting', $this->_d);
	}
}

?>