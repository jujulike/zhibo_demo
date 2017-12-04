<?php

class Live_Useronline_Module extends CI_Module {

	private $_data = array();
	private $_tpl = '';

	public function __construct() {
        parent::__construct();
		$this->load->model('Userinfo_model', 'u');
		$this->load->model('Livemaster_model', 'm');
		$this->load->model('Livechat_model', 'chat');
		$this->load->model('Userinfo_model', 'user');
		$this->load->model('Userstatus_model', 'us');
		$this->load->model('admin/Config_model', 'conf');
		if ($this->session->userdata('userinfo'))
			$this->_data['u'] = $this->session->userdata('userinfo');

		$_temp = $this->conf->O(array('confkey'=>'tpl'),'confval',0);
		$_arr_temp = explode("/",$_temp['confval']);
		$this->_tpl = $_arr_temp[1];
    }


	public function userlist($cateid, $roominfo, $hostinfo)
	{
		// 初始化在线网友
		$masterinfo = $this->m->O(array('roomid'=>$roominfo[0]['roomid']));
		$this->_data['masterinfo'] = $masterinfo;	
		$sdata['masterid'] = $masterinfo['masterid'];
		$retdata = $this->conf->O(array('confkey'=>'isaudit'),'confval',0);
		
		
		$this->_data['confdisallowed'] = $this->config->item('confdisallowed');
		$this->_data['hostinfo'] = $hostinfo;
		$this->_data['isaudit'] = $retdata['confval'];
		$this->_data['masterinfo'] = $masterinfo;

		$this->load->view($this->_tpl . '/useronline', $this->_data);
	}

	public function getUsers($masterid)
	{
		$userlist = $this->us->L(array('cannotchat'=>1),'*',0,0,'ctime','desc');
		foreach ($userlist as $k => $v)
		{
			$username = $this->user->O(array('userid'=>$v['userid']));
			$userlist[$k]['username'] = $username['username'];
		}
		$this->_data['userlist'] = $userlist;
		$this->load->view($this->_tpl. '/user_item', $this->_data);
	}

	public function canChat($id)
	{
		if($this->us->M(array('cannotchat'=>'0','mtime'=>time()),array('id'=>$id)))
		{
			$retmsg['code'] = '1';
			$retmsg['msg'] = '该用户被激活！';
			exit(json_encode($retmsg));
		}
		else
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '激活失败！';
			exit(json_encode($retmsg));
		}
	}

}
