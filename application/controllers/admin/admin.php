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

class Admin extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Author: dgt <QQ:57790081;EMAIL:57790081@qq.com>
	 */


	public function __construct() {
        parent::__construct();    
		$this->load->library('form_validation');
		$this->load->model('admin/Admin_model', 'a');
    }


	public function index()
	{
		show_404();
	}

	public function modiPasswd()
	{
		if (($this->_data['adminfo'] = $this->isadmin()) === false) redirect("admin/uuser/login"); 

		if ($this->form_validation->run('passwdmodi') == FALSE)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}

			$this->load->view('admin/admin/modiPasswd', $this->_data);
		}
		else
		{
			$postdata = $this->input->post();
			$sdata['userid'] = $this->_data['adminfo']['userid'];
			if ($this->a->M($postdata, $sdata) == '1')
			{
				$retmsg['code'] = '1';
				$retmsg['msg'] = $this->lang->line('passwd_modi_success');
				exit(json_encode($retmsg));
			}
			else
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('passwd_modi_fail');
				exit(json_encode($retmsg));
			}

		}
	}

	public function logout()
	{
		parent::adminLogout();
		redirect('admin/user/login');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */