<?php

class Live_Content_Module extends CI_Module {

	var $_d;
	private $_tpl = '';

	public function __construct() {
        parent::__construct();
		$this->load->model('Userinfo_model', 'u');
		$this->load->model('Livemaster_model', 'm');
		$this->load->model('Livecontent_model', 'lc');
		$this->load->model('Livequestion_model', 'qa');
		$this->load->model('Livechat_model', 'chat');
		$this->load->model('Category_model','c');
		$this->load->model('admin/Config_model', 'conf');

		if ($this->session->userdata('userinfo'))
			$this->_d['u'] = $this->session->userdata('userinfo');
		$_temp = $this->conf->O(array('confkey'=>'tpl'),'confval',0);
		$_arr_temp = explode("/",$_temp['confval']);
		$this->_tpl = $_arr_temp[1];
    }

	public function getlivedata($cateid, $roominfo, $hostinfo)
	{
		//$this->db->cache_on();

		$this->_d['roominfo'] = $roominfo;
		$this->_d['hostinfo'] = $hostinfo;
		
		// 初始化直播主题o
		$masterinfo = $this->m->O(array('roomid'=>$roominfo[0]['roomid']));
		$this->_d['masterinfo'] = $masterinfo;

		// 初始化直播内容
		/*$toplist = $this->lc->L(array('type'=>'1','masterid'=>$masterinfo['masterid'],'istop'=>'1'), '*', '1000', 0, 'ctime', 'desc');
		$livelist = $this->lc->L(array('type'=>'1','masterid'=>$masterinfo['masterid'],'istop'=>'0'), '*', '1000', 0, 'contentid', 'asc');
		$livelist = array_merge($toplist,$livelist);
		foreach ($livelist as $k => $v) $livecate[] = $v['contentcate'];
		if (!empty($livecate))
		{
			$livecatelist_t = $this->c->L(array('cateid in (' .implode(",",$livecate). ')'=>''),'cateid,catename',0,0);
			$livecatelist = cate2array($livecatelist_t,'cateid');
			//print_r(implode(",",$livecate));
			foreach ($livelist as $k => $v)
			{
				if (!empty($livecatelist[$v['contentcate']]))
					$livelist[$k]['livecatename'] = $livecatelist[$v['contentcate']]['catename'];
			}
		}
		//print_r($livelist);
		$this->_d['contentlist'] = $livelist;
		$lastid = $this->lc->getLastid($masterinfo['masterid'],'1');
		$lastcontentid = $lastid['lastcontentid'];
		$this->_d['lastcontentid'] = $lastcontentid;

		// 初始化VIP直播内容
		$viptoplist = $this->lc->L(array('type'=>'2','masterid'=>$masterinfo['masterid'],'istop'=>'1'), '*', '1000', 0, 'ctime', 'desc');
		$viplist = $this->lc->L(array('type'=>'2','masterid'=>$masterinfo['masterid'],'istop'=>'0'), '*', '1000', 0, 'contentid', 'asc');
		$viplist = array_merge($viptoplist,$viplist);
		foreach ($viplist as $k => $v) $viplivecate[] = $v['contentcate'];
		if (!empty($viplivecate))
		{
			$viplivecatelist_t = $this->c->L(array('cateid in (' .implode(",",$viplivecate). ')'=>''),'cateid,catename',0,0);
			$viplivecatelist = cate2array($viplivecatelist_t,'cateid');

			foreach ($viplist as $k => $v)
			{
				if (!empty($viplivecatelist[$v['contentcate']]))
					$viplist[$k]['livecatename'] = $viplivecatelist[$v['contentcate']]['catename'];
			}
		}
		$this->_d['viplist'] = $viplist;
		$lastvipid = $this->lc->getLastid($masterinfo['masterid'],'2');
		$this->_d['lastvipid'] = $lastvipid['lastcontentid'];


		// 初始化问答内容
		$qalist = $this->qa->O(array('masterid'=>$masterinfo['masterid']), 'questionid','questionid', 'desc');
		$this->_d['lastquestionid'] = @$qalist['questionid'];
		
		if (!empty($u))
		{
			// 初始化我的问答内容
			$myqalist = $this->qa->O(array('masterid'=>$masterinfo['masterid'],'questionuserid'=>$this->_d['u']['userid']), 'questionid','questionid', 'desc');
			$this->_d['lastmyquestionid'] = @$myqalist['questionid'];
		}

		// 直播内容分类
		$parent = $this->c->O(array('func'=>'livecate','parentid'=>0));
		$livecate_t = $this->c->L(array('parentid'=>$parent['cateid']),'cateid as id,catename as name',0,0,'sort','asc');
		$this->_d['livecate'] = array2option($livecate_t);
		*/
		$this->load->model('admin/Config_model', 'conf');
		$retdata = $this->conf->O(array('confkey'=>'isaudit'),'confval',0);
		// 初始化聊天内容
		if ($retdata['confval'] == '1')
		{			
			if (!empty($this->_d['u']['ismaster']) && ($masterinfo['roomid'] == $this->_d['u']['ismaster']))
			{
				$contentlist = $this->chat->O(array('masterid'=>$masterinfo['masterid']), 'chatid','chatid', 'desc');
				
			}
			else
			{
				$sdata['status'] = '1';
				$contentlist = $this->chat->O(array('masterid'=>$masterinfo['masterid'],'status'=>'1'), 'chatid','chatid', 'desc');
			}
		}
		else
		{
			$contentlist = $this->chat->O(array('masterid'=>$masterinfo['masterid']), 'chatid','chatid', 'desc');
		}
		$this->_d['lastchatid'] = @$contentlist['chatid'];


		$this->load->view($this->_tpl . '/live_content', $this->_d);
	}

	public function getchatdata()
	{
		$this->load->view('chat_content', $this->_d);
	}


	// 初始化直播内容
	public function getLiveInit()
	{
		$this->load->view('content_item', $this->_d);
	}


	// 初始化直播内容
	public function getVipdata()
	{
		$this->load->view('vip_item', $this->_d);
	}

	// 实时请求普通直播内容
	public function appLiveContent($masterid, $contentid = 0,$cate='',$ishot='')
	{
		//$this->db->cache_on();
		$sdata['type'] = 1;
		$sdata['masterid'] = $masterid;
		$sdata['contentid >' . $contentid ] = '';
		if ($cate != '') $sdata['contentcate'] = $cate;
		if ($ishot != '') $sdata['ishot'] = 1;
		$contentlist = $this->lc->L($sdata, '*', '100', 0, 'contentid', 'asc');
		if (count($contentlist) == 0) exit('');
		foreach ($contentlist as $k => $v) $livecate[] = $v['contentcate'];
		if (!empty($contentlist))
		{
			$livecatelist_t = $this->c->L(array('cateid in (' .implode(",",$livecate). ')'=>''),'cateid,catename',0,0);
			$livecatelist = cate2array($livecatelist_t,'cateid');
			//print_r(implode(",",$livecate));
			foreach ($contentlist as $k => $v)
			{
				if (!empty($livecatelist[$v['contentcate']]))
					$contentlist[$k]['livecatename'] = $livecatelist[$v['contentcate']]['catename'];
			}
		}
		$masterinfo = $this->m->O(array('masterid'=>$masterid));
		$this->_d['masterinfo']  = $masterinfo;
		$this->_d['contentlist']  = $contentlist;
		$this->load->view('content_item', $this->_d);
	}


	// 实时请求VIP直播内容
	public function appVipContent($roomid, $masterid, $contentid = 0)
	{
		//$this->db->cache_on();

		if (empty($roomid) || empty($masterid)) exit('');
		if (empty($this->_d['u']['kind']) || 
			!in_array($roomid, unserialize($this->_d['u']['kind']))) exit();
		
		$contentlist = $this->lc->L(array('type'=>'2', 'masterid'=>$masterid, 'contentid >' . $contentid=>''), '*', '100', 0, 'contentid', 'asc');
		if (count($contentlist) == 0) exit('');
		foreach ($contentlist as $k => $v) $viplivecate[] = $v['contentcate'];
		if (!empty($contentlist))
		{
			$viplivecatelist_t = $this->c->L(array('cateid in (' .implode(",",$viplivecate). ')'=>''),'cateid,catename',0,0);
			$viplivecatelist = cate2array($viplivecatelist_t,'cateid');

			foreach ($contentlist as $k => $v)
			{
				if (!empty($viplivecatelist[$v['contentcate']]))
					$contentlist[$k]['livecatename'] = $viplivecatelist[$v['contentcate']]['catename'];
			}
		}
		$masterinfo = $this->m->O(array('masterid'=>$masterid));
		$this->_d['masterinfo']  = $masterinfo;
		$this->_d['viplist']  = $contentlist;
		$this->load->view('vip_item', $this->_d);
	}

	// 获取问答列表
	public function getQuestions($roomid, $masterid,$questionid = 0)
	{
		//$this->db->cache_on();

		if (empty($roomid) || empty($masterid)) exit('');

		if (!empty($this->_d['u']['ismaster']) && ($this->_d['u']['ismaster'] == $roomid))
		{
			$this->_d['u']['role'] = 1;
			$questionlist = $this->qa->L(array('masterid'=>$masterid), '*',200,0,'questionid','asc');	
		}else{
			$questionlist = $this->qa->L(array('masterid'=>$masterid, 'answeruserid != \'\''=>''), '*',200,0,'questionid','asc');
		}


		$this->_d['contentlist']  = $questionlist;
		$this->load->view('question_item', $this->_d);	
	}

	// 获取问题列表
	public function getQuestionsAll($masterid, $questionid = 0)
	{
		//$this->db->cache_on();

		$questionlist = $this->qa->L(array('questionid >'.$questionid=>'','masterid'=>$masterid));
		$this->_d['contentlist']  = $questionlist;
		$this->_d['u']['role'] = 1;
		$this->load->view('question_item', $this->_d);	
	}

	// 获取问题列表
	public function getMyQuestions($roomid,$masterid, $questionid = 0)
	{
		//$this->db->cache_on();

		$questionlist = $this->qa->L(array('masterid'=>$masterid,'questionuserid'=>$this->_d['u']['userid'],'questionid >'.$questionid=>''),'*',0,0,'questionid','asc');
		$this->_d['contentlist']  = $questionlist;
		$this->load->view('question_item', $this->_d);	
	}

	// 播主修改直播内容
	public function editContent($id,$flag,$mtype='')
	{
		if ($flag == '1')
		{
			if ($mtype == '1' || $mtype == '3')
			{
				$row = $this->lc->O(array('contentid'=>$id));
				$this->_d['row'] = $row;
			}
			else if ($mtype == '2')
			{
				$row = $this->qa->O(array('questionid'=>$id));
				$this->_d['row'] = $row;
			}
			$this->_d['mtype'] = $mtype;
			$this->load->view('modicontent', $this->_d);	
		}
		else
		{
			$postdata = $this->input->post();
			$postdata['mtime'] = time();
			if ($mtype == '1' || $mtype=='3')
			{
				if ($this->lc->M($postdata,array('contentid'=>$id)))
				{
					$retmsg['code'] = '1';
					$retmsg['modiid'] = $id;
					$retmsg['content'] = $postdata['content'];
					$retmsg['mtype'] = $mtype;
					$retmsg['msg'] = '修改成功';				
					exit(json_encode($retmsg));
				}
			}
			else if ($mtype == '2')
			{
				if ($this->qa->M($postdata,array('questionid'=>$id)))
				{
					$retmsg['code'] = '1';
					$retmsg['modiid'] = $id;
					$retmsg['content'] = $postdata['answercontent'];
					$retmsg['mtype'] = $mtype;
					$retmsg['msg'] = '修改成功';				
					exit(json_encode($retmsg));
				}
			}

		}
	}
}
