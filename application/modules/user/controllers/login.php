<?php

class User_Login_Module extends CI_Module {

	private $_data = array();

	public function __construct() {
        parent::__construct();
		$this->load->model('Userinfo_model', 'u');
		$this->load->model('Live_model', 'room');
		if ($this->session->userdata('userinfo'))
			$this->_data['u'] = $this->session->userdata('userinfo');


		$this->load->model('Category_model','cate');
		$this->_data['native'] = $this->cate->L(array('cateid in(29,30,31)'=>'','status'=>'1'),'*','',0,'sort');

    }

	public function index($type = '')
	{
		if (empty($this->_data['u']) || ($this->_data['u']['level'] == '-1'))
			$this->fail($type);
		else
			$this->success();
	}

	public function success()
	{
		$this->_data['regnum'] = $this->u->C();
		if (!empty($this->_data['u']['ismaster']))
		{
			$cateid_t = $this->room->O(array('roomid'=>$this->_data['u']['ismaster']));
			$cateid = $cateid_t['cateid'];
			$native = $this->_data['native'];
			$flag = 0;
			foreach ($native as $k => $v)
			{
				if ($v['cateid'] == $cateid ) $flag = 1;
			}
			$this->_data['hasCate'] = $flag;
		}
		$this->load->view('loginshow', $this->_data);
	}

	public function fail($type)
	{
		$this->_data['regnum'] = $this->u->C();

		if ($type == 'poplogin')
			$this->_data['hidereg'] = '0';
		$this->load->view('loginform', $this->_data);		
	}
}
