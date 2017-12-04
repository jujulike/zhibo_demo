<?php

class Live_Recommend_Module extends CI_Module {

	private $_data = array();

	public function __construct() {
        parent::__construct();
		$this->load->model('Userinfo_model', 'user');
		$this->load->model('Livemaster_model', 'master');
		$this->load->model('Live_model', 'room');

    }

	/**
	* 取直播室数据并附带最新的直播主题数据 
	*/

	public function room($cateid, $number = 6)
	{
		if (empty($cateid)) $cateid = 29;
		$roomlist = $this->room->L(array('status'=>1, 'cateid'=>$cateid), 'roomid, roomname, hits, imgthumb as roomimgthumb', $number, 0, 'hits', 'desc');


		foreach ($roomlist as $k => $v) $listary[] = $v['roomid'];



		if (!empty($listary))
		$masterinfo = $this->getMasterInfo($listary);
		


		if (!empty($masterinfo))
		{
			foreach ($roomlist as $k => $v) if (!empty($masterinfo[$v['roomid']])) $roomlist[$k]['masterinfo'] = $masterinfo[$v['roomid']];			


			// 排序规则：1.正在直播比暂时直播之前；2.关注人多的排前；
	//		$v['masterinfo']['etime'] + $this->config->item('master_status_sleep') > time() 
			foreach ($roomlist as $k => $v)
			{
				if (!empty($v['masterinfo']))
				{
					if ($v['masterinfo']['etime'] + $this->config->item('master_status_sleep') > time())
					{
						$running[] = $v;
					}else
					{
						$stoping[] = $v;
					}
				}
			}
			
			if ((!empty($running)) && (!empty($stoping)))
				$roomlist = array_merge($running, $stoping);

			$this->_data['list'] = $roomlist;
		}
		else
			$this->_data['list'] = array();
		$this->load->view('recommend_room', $this->_data);
	}

	// 推荐主题排行

	public function master($cateid, $number = 6, $offset = 0)
	{
		if (empty($cateid)) $cateid = 29;
		$roomlist = $this->room->L(array('status'=>1, 'cateid'=>$cateid), 'roomid, roomname, hits, imgthumb as roomimgthumb', $number, $offset, 'hits', 'desc');

		if (!empty($roomlist))
		foreach ($roomlist as $k => $v) $listary[] = $v['roomid'];

		$masterinfo = $this->getMasterInfo(@$listary);
		foreach ($roomlist as $k => $v) if (!empty($masterinfo[$v['roomid']])) $roomlist[$k]['masterinfo'] = $masterinfo[$v['roomid']];			

		// 排序规则：1.正在直播比暂时直播之前；2.关注人多的排前；
		// $v['masterinfo']['etime'] + $this->config->item('master_status_sleep') > time() 
		// modi by dgt 2013-1-29
		foreach ($roomlist as $k => $v)
		{
			if (!empty($v['masterinfo']) && ($v['masterinfo']['etime'] + $this->config->item('master_status_sleep') > time()))
			{
				$running[] = $v;
			}else
			{
				$stoping[] = $v;
			}
		}
		
		if ((!empty($running)) && (!empty($stoping)))
			$roomlist = array_merge($running, $stoping);

		$this->_data['list'] = $roomlist;
		
		$this->load->view('recommend_master', $this->_data);
	}

	// 推荐播主
	public function host($cateid, $number = 3)
	{
		if (empty($cateid)) $cateid = 29;
		
		$roomlist = $this->room->L(array('cateid'=>$cateid, 'status'=>1), 'roomname,roominfo,userinfo,userid', $number, 0, 'hits', 'desc');
		if (!empty($roomlist))
		{
			foreach ($roomlist as $k => $v) $userid[] = $v['userid'];
			$hostinfo = $this->user->L(array('status'=>'1','ismaster not in(0)'=>'','userid in (' . implode(',', $userid) .')' =>''), 'userid, username,name,ismaster,gender,imgthumb', $number, 0, 'recomm_sort', 'asc');
			if (!empty($hostinfo))
			foreach ($hostinfo as $k => $v) $listary[] = $v['userid'];
			$masterinfo = $this->getMasterInfo(@$listary, 'userid');

			foreach ($hostinfo as $k => $v) if (!empty($masterinfo[$v['userid']])) $hostinfo[$k]['masterinfo'] = $masterinfo[$v['userid']];				
			$this->_data['list'] = $hostinfo;
		}
		else
		{
			$this->_data['list'] = array();
		}

		
		$this->load->view('recommend_host', $this->_data);
	}

	// 新晋直播
	public function newHost($cateid, $number=4)
	{
		if (empty($cateid)) $cateid = 29;

		$roomlist = $this->room->L(array('cateid'=>$cateid, 'status'=>1), 'roomname,roominfo,userinfo,userid', 100, 0, 'roomid', 'desc');
		if (!empty($roomlist))
		{
			foreach ($roomlist as $k => $v) $userid[] = $v['userid'];
			$hostinfo = $this->user->L(array('status'=>'1','ismaster not in(0)'=>'','userid in (' . implode(',', $userid) .')' =>''), 'userid, username,name,ismaster,gender,imgthumb', $number, 0, 'userid', 'desc');
			if (!empty($hostinfo))
			foreach ($hostinfo as $k => $v) $listary[] = $v['userid'];
			$roominfo_t = $this->room->L(array('userid in (' . implode(',', $listary) .')' =>''), '*', $number);
			$roominfo = cate2array($roominfo_t, 'userid');

			foreach ($hostinfo as $k => $v) if (!empty($roominfo[$v['userid']])) $hostinfo[$k]['roominfo'] = $roominfo[$v['userid']];				
			$this->_data['list'] = $hostinfo;
		}
		else
		{
			$this->_data['list'] = array();
		}
		
		$this->load->view('recommend_newhost', $this->_data);
	}

	public function getRoomInfo($ary)
	{
		
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

}
