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
class Service extends MY_Controller {

	public function __construct() {
        parent::__construct();
    }

	// 在线预约
	public function reserver()
	{
		if ($this->input->post())
		{
			$data = $this->input->post();

			if( empty($data['yzm']) || 
				(strtolower($data['yzm'])!=$this->session->userdata("vcode")))
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = '请输入正确的验证码';
				exit(json_encode($retmsg));
			}

			if (empty($data['name']) || 
				(strlen($data['name']) < 4) ||
				(strlen($data['name']) > 20))
			{
				echo json_encode(array('code'=>'0','msg'=>'姓名不符合规则!'));
				exit;
			}

			if (empty($data['phone']) || 
				(strlen($data['phone']) < 10) ||
				(strlen($data['phone']) > 16) ||
				(!is_numeric($data['phone'])))
			{
				echo json_encode(array('code'=>'0','msg'=>'电话号码不符合规则!'));
				exit;
			}

			if (empty($data['cardnumber']) || 
				((strlen($data['cardnumber']) != 15) &&
				(strlen($data['cardnumber']) != 18)) ||
				(!is_numeric($data['cardnumber'])))
			{
				echo json_encode(array('code'=>'0','msg'=>'身份证号码不符合规则!'));
				exit;
			}


			if( preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $data['email']))
			{
			}
			else
			{
				echo json_encode(array('code'=>'0','msg'=>'邮箱地址不符合规则!'));
				exit;				
			}


			$this->load->model('Service_model','s');	

			$data['ctime'] = time();
			if ($this->s->A($data))
			{
				echo json_encode(array('code'=>'1','msg'=>'预约成功!'));
				exit;
			}
			else
			{
				echo json_encode(array('code'=>'0','msg'=>'请再次偿试预约!'));
				exit;
			}
		}
		else
			$this->load->view($this->_d['cfg']['tpl'] . "service/reserver", $this->_d);
	}


	public function result($date = '')
	{
		if ($date =='') $date = date("Y-m-d");
		$_data = $this->v->getRate($date);
		if (empty($_data)) show_error('当前还没有人参与投票');

		$data = cate2array($_data, 'votetype');
		$sumtotal = 0;
		foreach ($data as $k => $v) $sumtotal +=  $v['c'];
		
		if (empty($data[0]['c'])) $data[0]['c'] = 0;
		if (empty($data[1]['c'])) $data[1]['c'] = 0;
		if (empty($data[2]['c'])) $data[2]['c'] = 0;

		$this->_d['votedata'][0]['name'] = $data[0]['c'] . '人选择看空';
		$this->_d['votedata'][0]['v'] = round($data[0]['c']/$sumtotal, 1);
		$this->_d['votedata'][1]['name'] = $data[1]['c'] . '人选择震荡';
		$this->_d['votedata'][1]['v'] = round($data[1]['c']/$sumtotal, 1);
		$this->_d['votedata'][2]['name'] = $data[2]['c'] . '人选择看多';
		$this->_d['votedata'][2]['v'] = round($data[2]['c']/$sumtotal, 1);
		$this->load->view($this->_d['cfg']['tpl'] . "vote/result", $this->_d);		
	}

}