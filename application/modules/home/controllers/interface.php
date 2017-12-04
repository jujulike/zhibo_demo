<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 */
class Home_Interface_Module extends CI_Module {

	private $_data = array();
	public function __construct() {
        parent::__construct();
		$this->load->model('Livequestion_model', 'qa');
		$this->load->model('Livecontent_model', 'mc');
		$this->load->model('Live_model', 'room');
		$this->load->model('Livemaster_model', 'master');
		$this->load->model('Userinfo_model','user');
		if ($this->session->userdata('userinfo'))
			$this->_data['u'] = $this->session->userdata('userinfo');

    }


	public function login()
	{
		if (empty($this->_data['u']))
		{
			$this->load->model('admin/Config_model', 'conf');
			$retdata = $this->conf->O(array('confkey'=>'checkmobile'),'confval',0);
			$this->_data['checkmobile']	= $retdata['confval'];
			$this->load->view("login", $this->_data);
		}
		else
		{
			$this->_data['hasregister'] = $this->user->C(array());
			$this->load->view("haslogin", $this->_data);
		}
	}

	public function master($cateid, $number = 6, $offset = 0)
	{
		if (empty($cateid)) $cateid = 29;
		$roomlist = $this->room->L(array('status'=>1, 'cateid'=>$cateid), 'roomid, roomname, hits, imgthumb as roomimgthumb', $number, $offset, 'hits', 'desc');

		if (!empty($roomlist))
		foreach ($roomlist as $k => $v) $listary[] = $v['roomid'];
		
		$roomid = implode(",",$listary);
		$todaytime = mktime(0,0,0,date("m"),date("d"),date("Y"));
		if (empty($this->_data['u']))
		{
			$masterinfo_t = $this->master->getLastMaster(6,$todaytime,$roomid);
		}
		else
		{
			$masterinfo_t = $this->master->getLastMaster(6,'',$roomid);
		}

//print_r($this->db->last_query());
		$masterinfo = cate2array($masterinfo_t,'roomid');

		foreach ($roomlist as $k => $v) if (!empty($masterinfo[$v['roomid']])) $roomlist[$k]['masterinfo'] = $masterinfo[$v['roomid']];			

		$this->_data['list'] = $roomlist;
		
		$this->load->view('recommend_master', $this->_data);
	}

	public function q2a()
	{
		$sdata["answeruserid <> '' "] = '';
		$q2alist = $this->qa->O($sdata,'*','mtime','desc');
		//print_r($this->db->last_query());
		$this->_data['row'] = $q2alist;
		$todaytime = mktime(0,0,0,date("m"),date("d"),date("Y"));
		if (empty($this->_data['u']))
		{
			$masterinfo = $this->master->O(array('userid'=>$q2alist['answeruserid'],'ctime <'.$todaytime =>''),'masterid,ctime,roomid','ctime','desc');
		}
		else
		{
			$masterinfo = $this->master->O(array('userid'=>$q2alist['answeruserid']),'masterid,ctime,roomid','ctime','desc');
		}
		$this->_data['masterinfo'] = $masterinfo;
		$this->load->view('q2a', $this->_data);

	}

	public function getMasterInfo($ary, $field = 'roomid')
	{
		if (empty($ary)) return '';
		$query = $this->db->query('select * from
						(select * from ' . $this->master->tbl .
						' where ' . $field. ' in(' .  implode(',', $ary) .')
						order by ' . $field . ',masterid desc)
						' . $this->master->tbl . '  group by ' . $field);
		$masterlist_t = $query->result_array();
		return cate2array($masterlist_t, $field);		
	}

	public function getLastLive()
	{
		$todaytime = mktime(0,0,0,date("m"),date("d"),date("Y"));
		if (empty($this->_data['u']))
		{
			$list = $this->master->getLastMaster(3,$todaytime);
		}
		else
		{
			$list = $this->master->getLastMaster(3);
		}
		//print_r($this->db->last_query());
		foreach ($list as $k => $v)
		{
			$contentlist = array();
			$contentlist = $this->mc->O(array('masterid'=>$v['masterid']),'content, ctime as lasttime','ctime','desc');
			if (!empty($contentlist))
			{
				$list[$k]['content'] = $contentlist['content'];
				$list[$k]['lasttime'] = $contentlist['lasttime'];
			}
			else
				$list[$k]['content'] = '';
			
			$userinfo = $this->user->O(array('userid'=>$v['userid']));
			$list[$k]['userphoto'] = $userinfo['imgthumb'];
		}

		$this->_data['list'] = $list;
		$this->load->view('master', $this->_data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */