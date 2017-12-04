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
class Zt extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Zt_model','zt');
		$this->load->model('Template_model','t');
		$this->load->model('Ztapply_model','a');
		$this->load->model('Category_model','c');
    }

	// 专题列表
	public function tlist($cateid='')
	{
		$zt_cate = $this->c->L(array('func'=>'zt','status'=>'1'),'cateid,catename',0,0,'sort');
		$this->_d['zt_cate'] = $zt_cate;

		if ($cateid == '') $cateid = $zt_cate[0]['cateid'];
		$this->_d['cateid'] = $cateid;
		$zt_cate_t = cate2array($zt_cate,'cateid');
		$this->_d['catename'] = $zt_cate_t[$cateid]['catename'];
		
		$this->_p['pagenumb'] = 30;
		$sdata['cateid'] = $cateid;
		$sdata['status'] = 1;
		$zt = $this->zt->L($sdata,'*',$this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->zt->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		
		$this->_d['zt'] = $zt;
		$this->_d['cateid'] = $cateid;
		$this->load->view("themes/feibei/zt", $this->_d);
	}

	public function detail($id='')
	{
		/*$news_cate = $this->c->L(array('func'=>'article','status'=>'1'),'cateid,catename',0,0,'sort');
		$this->_d['news_cate'] = $news_cate;
		$news_cate_t = cate2array($news_cate,'cateid');
		$this->_d['catename'] = $news_cate_t[$cateid]['catename'];*/

		$row = $this->zt->O(array('id'=>$id));
		//$this->_d['cateid'] = $cateid;
		$this->_d['row'] = $row;
		$zt_template = $this->t->O(array('id'=>$row['zt_template']));
		$this->_d['new_apply'] = $this->a->C(array('user_type'=>1));
		$this->_d['old_apply'] = $this->a->C(array('user_type'=>2));
		$this->_d['applylist'] = $this->a->L(array('status'=>1),'*',0,0,'ctime','desc');
		$this->load->view("themes/feibei/".$zt_template['temp_url'], $this->_d);
	}

	public function zt_apply()
	{
		$postdata = $this->input->post();
		if ($postdata['real_name'] == '' || $postdata['real_name'] == '真实姓名')
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '真实姓名不能为空';
			exit(json_encode($retmsg));
		}
		if ($postdata['mobile'] == ''  || $postdata['mobile'] == '手机号码')
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '手机号码不能为空';
			exit(json_encode($retmsg));
		}
		if (!($this->isMobile($postdata['mobile'])))
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '手机号码格式不正确';
			exit(json_encode($retmsg));
		}

		if ($this->a->C(array('mobile'=>$postdata['mobile'])) > 0)
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '您的手机号码已提交过，不能再次提交！';
			exit(json_encode($retmsg));
		}

		if ($postdata['card_no'] == ''  || $postdata['card_no'] == '身份证号码')
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '身份证号码不能为空';
			exit(json_encode($retmsg));
		}

		if ($this->a->C(array('card_no'=>$postdata['card_no'])) > 0)
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '您的身份证号码已提交过，不能再次提交！';
			exit(json_encode($retmsg));
		}

		if ($postdata['qq'] == ''  || $postdata['qq'] == 'QQ')
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = 'qq不能为空';
			exit(json_encode($retmsg));
		}

		if ($postdata['user_type'] == '2')
		{
			if (empty($postdata['push_money']))
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = '预入金不能为空';
				exit(json_encode($retmsg));
			}

			if ($postdata['push_money'] >= 1000)
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = '预入金是以万为单位';
				exit(json_encode($retmsg));
			}
		}

		$postdata['ctime'] = time();

		if ($this->a->A($postdata))
		{
			$retmsg['code'] = '1';
			if ($postdata['user_type'] == '2')
				$retmsg['msg'] = '尊敬的客户您好，您的申请已提交成功。请您及早完成入金操作，奖品就真真是您的了。';
			else
				$retmsg['msg'] = '尊敬的客户您好，您的开户申请已提交成功。稍后我们会尽快与您取得联系，协助您办理开户。';

			exit(json_encode($retmsg));
		}
		else
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '申请失败，请重试！';
			exit(json_encode($retmsg));
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */