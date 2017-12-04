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
class Home extends MY_Controller {

	public function __construct() {
        parent::__construct();
		
		$this->load->model('Category_model','cate');
		$this->load->model('Advertisement_model','ad');
		$this->load->model('Article_model','article');
		$this->load->model('Pages_model','page');
		$this->load->model('Live_model','lv');
		$this->load->model('Home_model','hm');
		$this->load->model('Userinfo_model','user');
    }
	
	public function recomm($pid = '')
	{
		if ($this->_d['cfg']['open_recommend'] == '1')
		{
			if ($pid != '')	$this->session->set_userdata('recommid', $pid);			
		}

		$this->index();
	}

	public function index()
	{
		$this->session->unset_userdata('roomkey');
		$adlist = $this->ad->getChannelAds('home');
		$this->_d['adlist'] = $adlist;

		$f = FCPATH . APPPATH . 'cache/room/26_useronline';
		if (file_exists($f))
			$this->_d['usertotal'] = count(json_decode(file_get_contents($f, FILE_BINARY, NULL, 0, 8196), true));
		else
			$this->_d['usertotal'] = 0;

		$this->load->view($this->_d['cfg']['tpl'] . "home/index", $this->_d);	
	}
	
	public function checkPhone($phoneId = '')
	{
		if (!$phoneId || trim($phoneId) == '')
		{			
			$retmsg['code'] = '0';
			$retmsg['msg'] = '请输入手机号码！';
			exit(json_encode($retmsg));
		}

		if (!($this->isMobile($phoneId)))
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '请输入有效格式的手机号码！';
			exit(json_encode($retmsg));
		}

		// 验证该手机是否被使用过
		if (!($this->hasRegisted($phoneId)))
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '该手机号码已经被注册！';
			exit(json_encode($retmsg));
		}

		$retmsg['code'] = '1';
		$retmsg['msg'] = '';
		exit(json_encode($retmsg));
	}

	public function reg()
	{
		$postdata = $this->input->post();
		if ($this->form_validation->run() == FALSE)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();				
				exit(json_encode($retmsg));
			}
		}
		else
		{
			if ($this->_d['cfg']['checkmobile'] == '1')
			{
				if ($postdata['r_code'] == '')
				{
					$retmsg['code'] = '0';
					$retmsg['msg'] = "验证码不能为空！";				
					exit(json_encode($retmsg));
				}

				if ($this->checkCode($postdata['r_phone'],$postdata['r_code']))
				{
					$cdata['username'] = $postdata['r_name'];
					$cdata['name'] = $postdata['r_name'];//$this->repTel($postdata['r_phone']);
					$cdata['passwd'] = md5($postdata['r_password']);
					$cdata['email'] = $postdata['r_email'];
					$cdata['phone'] = $postdata['r_phone'];
					$cdata['ctime'] = time();
					$cdata['regip'] = ip2long($this->input->ip_address());
					if ($this->user->A($cdata) > 0)
					{
						$retmsg['code'] = '1';
						$retmsg['msg'] = $this->lang->line('reg_user_success');
						exit(json_encode($retmsg));
					}
					else
					{
						$retmsg['code'] = '0';
						$retmsg['msg'] = $this->lang->line('reg_user_fail');
						exit(json_encode($retmsg));
					}
				}
				else
				{
					$retmsg['code'] = '0';
					$retmsg['msg'] = "验证码不匹配！";				
					exit(json_encode($retmsg));
				}
			}
			else
			{
				if ($this->_d['cfg']['site_reg_vcode'] == '1')
				{
					$vcode = $postdata['vcode'];
					if(strtolower($vcode)!=$this->session->userdata("vcode"))
					{
						$retmsg['code'] = '0';
						$retmsg['msg'] = '请输入正确的验证码';
						exit(json_encode($retmsg));
					}
				}

				$cdata['username'] = $postdata['r_qq'];
				$cdata['name'] = $postdata['r_name'];//$this->repTel($postdata['r_phone']);
				$cdata['passwd'] = md5($postdata['r_password']);
//				$cdata['email'] = $postdata['r_email'];
				$cdata['phone'] = $postdata['r_phone'];
				$cdata['qq'] = $postdata['r_qq'];
				$cdata['ctime'] = time();
				$cdata['regip'] = ip2long($this->input->ip_address());

				// 增加推荐者
				if (($this->_d['cfg']['open_recommend'] == '1') && ($this->session->userdata('recommid')))
				{
					$cdata['recommid'] = $this->session->userdata('recommid');
					$this->session->unset_userdata('recommid');
				}

				if ($this->user->A($cdata) > 0)
				{
					// modi 2014-05-15 dgt 
					$_info = $this->user->O(array('username'=>$cdata['username'], 'passwd'=>$cdata['passwd']));
					$this->setAuthor($_info);
					// end;

					$retmsg['code'] = '1';
					$retmsg['msg'] = $this->lang->line('reg_user_success');
					exit(json_encode($retmsg));
				}
				else
				{
					$retmsg['code'] = '0';
					$retmsg['msg'] = $this->lang->line('reg_user_fail');
					exit(json_encode($retmsg));
				}
			}
		}

	}

	/*
	验证手机号码
	*/
	public function isMobile($mobilephone)
	{

		if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/",$mobilephone)){   

			return true;
	         
		}else{
			$this->form_validation->set_message('isMobile', '手机号码格式不正确！');	    
			return false;
		}
	}

	/*
	验证手机是否被注册过
	*/
	/*public function hasRegisted($mobilephone)
	{

		if(0 < ($this->user->C(array('username'=>$mobilephone))))
		{  
			$this->form_validation->set_message('hasRegisted', '该手机已被注册！');
			return false;
			
	         
		}else{   
		    
			return true;
		}
	}*/
	/*
	验证QQ是否被注册过
	*/
	public function hasRegisted($qq)
	{

		if(0 < ($this->user->C(array('qq'=>$qq))))
		{  
			$this->form_validation->set_message('hasRegisted', '该qq已被注册！');
			return false;
			
	         
		}else{   
		    
			return true;
		}
	}

	/*
	验证昵称是否被注册过
	*/
	public function hasName($name)
	{

		if(0 < ($this->user->C(array('name'=>$name))))
		{  
			$this->form_validation->set_message('hasName', '该昵称已其他用户使用！');
			return false;
			
	         
		}else{   
		    
			return true;
		}
	}

	/*
	随即产生四位数字
	*/
	public function geneYZM()
	{
		$yzm = '';
		for ($i = 0; $i < 4; $i ++)
		{
			$d = rand(0,9);
			$yzm = $yzm . $d;
		}

		return $yzm;
	}

	/*
	验证码是否有效
	*/
	public function checkCode($phone,$yzm)
	{
		if ($yzm == $this->session->userdata[$phone])
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	隐藏手机号码中间几位数字
	*/
	public function repTel($phone= '')
	{
		$pattern = "/(1\d{1,2})\d\d(\d{0,3})/";
		$replacement = "\$1****\$3";

		return preg_replace($pattern, $replacement, $phone);
	}

}