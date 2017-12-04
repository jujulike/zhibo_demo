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

class User extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/Admin_model','a');		
		$this->load->model('Userinfo_model','u');	
		$this->load->model('useronline_model','un');
		$this->load->model('Live_model','room');
		$this->load->library('form_validation');
		$this->load->model('Userstatus_model', 'us');
		$this->load->model('admin/Login_log_model','l');
		if ($this->isAdmin() == false) redirect("admin/login"); 
	}
	
	public function index()
	{
		$this->tlist();
	}



	public function tlist()
	{
		if (!$this->admin_priv('user'))
		{
			show_error("您没有权限进行此操作！");
		}
		$sdata = array('type !=' => '2');
		$username = '';
		$s_btime='';
		$s_etime='';
		$postdata = $this->input->post();
		if (!empty($postdata['username']))
		{
			$username = $postdata['username'];
			$sdata['username like '.'\'' . $username . '%\''] = '';
		}
		if (!empty($postdata['s_btime']))
		{
			$s_btime = $postdata['s_btime'];
			$sdata['ctime >='.strtotime($s_btime." 00:00:00")] = '';
		}
		if (!empty($postdata['s_etime']))
		{
			$s_etime = $postdata['s_etime'];
			$sdata['ctime <='.strtotime($s_etime." 23:59:59")] = '';
		}
		$list = $this->u->L($sdata,'*',$this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->u->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['list'] = $list;
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['username'] = $username;
		$this->_d['s_btime'] = $s_btime;
		$this->_d['s_etime'] = $s_etime;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'user/list', $this->_d);
	}

	public function appvip()
	{
		$sdata = array('appstatus not in(0)'=>'');
		$userlist = $this->u->L($sdata, '*', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		$this->_p['pagecount'] = $this->input->post('pagecount');
		foreach ($userlist as $k => $v) $useridary[] = $v['approomvip'];
		
		if (!empty($useridary))
		{
			$roominfo_t = $this->room->L(array('status'=>1, 'roomid in (' . implode(',', $useridary) . ')'=>''), 'roomid, roomname');
			$roominfo = cate2array($roominfo_t, 'roomid');
			foreach ($userlist as $k => $v) if (!empty($roominfo[$v['approomvip']])) $userlist[$k]['roominfo'] = $roominfo[$v['approomvip']];		
		}
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->u->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['list'] = $userlist;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'user/viplist', $this->_d);
	}

	public function delVipapp($id)
	{
		if (!$this->admin_priv('vipapp'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($id == '') exit($this->lang->line('access_error'));

		$pdata['appstatus'] = 0;
		$pdata['approomvip'] = 0;
		$sdata['userid'] = $id;
		$this->u->M($pdata, $sdata);
		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"删除用户VIP申请",$id);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
		exit(json_encode($retmsg));
	}


	public function del_app()
	{
		if (!$this->admin_priv('vipapp'))
		{
			show_error("您没有权限进行此操作！");
		}
		$postdata = $this->input->post('userid');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
			$user_id = implode(',',$postdata);
			}
			$adinfo = $this->u->L(array('userid in(' . $user_id . ')'=>''));
			foreach ($adinfo as $k => $v)
			{
				$adname[] = $v['username'];
			}
			$pdata['appstatus'] = 0;
			$pdata['approomvip'] = 0;
			$this->u->M($pdata,array('userid in(' . $user_id . ')'=>''));
			$admininfo = $this->isAdmin();
			$this->action_log('1',$admininfo['user_id'],"批量删除vip申请",implode(',',$adname));
			$retmsg['code'] = '1';
			$retmsg['msg'] = $this->lang->line('success');
			exit(json_encode($retmsg));
		}
		else
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '请选择会员';
			exit(json_encode($retmsg));
		}
	}

	public function admin_menu()
	{
		$this->load->model('admin/Action_model', 'action');

		$adminfo = $this->isAdmin();

		if ($adminfo['action_list'] == 'all' || $adminfo['action'] == '')
		{
			$menu_list = $this->action->L(array('level'=>1));
			//print_r($menu_list);
			foreach ($menu_list as $k => $v)
			{
				$menu_list[$k]['menu_2'] = $this->action->L(array('parent_id'=>$v['action_id'],'level'=>'2'));

				foreach ($menu_list[$k]['menu_2'] as $k2 => $v2)
				{
					$menu_list[$k]['menu_2'][$k2]['menu_3'] = $this->action->L(array('parent_id'=>$v2['action_id'],'level'=>'3'));
				}
			}

			return $menu_list;
		}
		
		$action = explode(",",$adminfo['action']);
		foreach ($action as $k => $v)
		{
			$level3_t = $this->action->O(array('action_code'=>$v,'level'=>'3'));
			$level3[] = $level3_t['action_id'];
			$level2_t = $this->action->O(array('action_id'=>$level3_t['parent_id'],'level'=>'2'));
			$level2[] = $level2_t['action_id'];
			$level1_t = $this->action->O(array('action_id'=>$level2_t['parent_id'],'level'=>'1'));
			$level1[] = $level1_t['action_id'];
		}
		$level1 = array_unique($level1);
		$level2 = array_unique($level2);
		$level3 = array_unique($level3);
		$menu_list = $this->action->L(array('level'=>1,'action_id in (' . trim(implode(",",$level1),',') . ')'=>''));
		foreach ($menu_list as $k => $v)
		{
			$menu_list[$k]['menu_2'] = $this->action->L(array('parent_id'=>$v['action_id'],'level'=>'2','action_id in (' . implode(",",$level2) . ')'=>''));

			foreach ($menu_list[$k]['menu_2'] as $k2 => $v2)
			{
				$menu_list[$k]['menu_2'][$k2]['menu_3'] = $this->action->L(array('parent_id'=>$v2['action_id'],'level'=>'3','action_id in (' . implode(",",$level3) . ')'=>''));
			}
		}
			//print_r($menu_list);
			//exit;
		return $menu_list;
	
	}

	public function setmain()
	{
//		if ($this->isAdmin() == false) redirect("admin/user/login"); 

		$this->_d['adminfo'] = $this->session->userdata('adminfo');

		$this->_d['menu_list'] = $this->admin_menu();
		//print_r($this->_d['menu_list']);
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'index/index', $this->_d);
	}

	public function setmenu()
	{
		if ($this->isAdmin() == false) redirect("admin/user/login"); 

		$this->_d['adminfo'] = $this->isAdmin();
		$this->load->view('admin/public/menu', $this->_d);	
	}

	public function setBegin()
	{
		$this->_d['adminfo'] = $this->isAdmin();
		$this->load->view('admin/public/welcome', $this->_d);	
	}


	public function logout()
	{
		parent::adminLogout();
		redirect("admin/user/login");
	}

    public function add($func = '') {
        if (!$this->admin_priv('user')) {
            show_error("您没有权限进行此操作！");
        }
        if ($this->form_validation->run() == false) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $this->_d['act'] = 'add';
            $row = $this->u->INIT();
            $row['func'] = $func;
            $this->_d['row'] = $row;
            $this->load->view($this->_d['cfg']['tpl_admin'] . 'user/add', $this->_d);
        } else {
            $postdata = $this->input->post();
            $this->add_user($postdata, true);
        }
    }

    public function muladd($func = '') {
        if (!$this->admin_priv('user')) {
            show_error("您没有权限进行此操作！");
        }
        if ($this->form_validation->run() == false) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $this->_d['act'] = 'muladd';
            $row = $this->u->INIT();
            $row['func'] = $func;
            $this->_d['row'] = $row;
            $this->load->view($this->_d['cfg']['tpl_admin'] . 'user/muladd', $this->_d);
        } else {
            $postdatas = $this->input->post();
            $postdata_arr = explode("\n", $postdatas['users']);
            foreach ($postdata_arr as $k => $postdata_user) {
                $user = explode('|', $postdata_user);
                $postdata['username'] = $user[0];
                $postdata['passwd'] = $user[1];
                $end = $k == (count($postdata_arr) - 1) ? true : false;
                $this->add_user($postdata, $end);
            }
        }
    }

    public function add_user($postdata, $end = false) {
        $postdata['ctime'] = time();
        if($this->checkUsername($postdata['username'])){
			$postdata['passwd'] = md5($postdata['passwd']);
			if(!$postdata['name']) {
				$postdata['name'] = $postdata['username'];
			}
            if ($this->u->A($postdata) > 0) {
                $admininfo = $this->isAdmin();
                $this->action_log('1', $admininfo['user_id'], "添加会员", $postdata['username']);
                $retmsg['code'] = '1';
                $retmsg['msg'] = '添加会员成功';
                $end && exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '添加会员失败';
                exit(json_encode($retmsg));
            }
        } else {
            $retmsg['code'] = '0';
            $retmsg['msg'] = $postdata['username'] . '用户名已经存在';
            exit(json_encode($retmsg));
        }
    }
    
    public function checkUsername($username) {
        $userinfo = $this->u->O(array('username' => $username));
        if (count($userinfo)) {
            return false;
        } else {
            return true;
        }
    }

	public function modi($id)
	{
		if (!$this->admin_priv('user'))
		{
			show_error("您没有权限进行此操作！");
		}

		if ($this->form_validation->run('user/modi') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}

			$row = $this->u->O(array('userid'=>$id));
			$this->_d['act'] = 'modi';
			$this->_d['row'] = $row;

			$ismaster = $this->config->item('ismaster');
			if(empty($row['ismaster']))
				$level = $this->config->item('level');
			else
				$level = $this->config->item('kflevel');
			$this->_d['ismaster'] = array2radio('ismaster', $ismaster, $row['ismaster']);
			$this->_d['level'] = array2radio('level', $level, $row['level']);
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'user/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();

			$postdata['mtime'] = time();
			
			if ($postdata['newpasswd']!= '')
			{
				if ($postdata['newpasswd'] != ($postdata['repasswd']))
				{
					$retmsg['code'] = '0';
					$retmsg['msg'] = $this->lang->line('passwd_modi_fail');
					exit(json_encode($retmsg));
				}
				else
				{
					$postdata['passwd'] = $postdata['newpasswd'];
				}
			}


			if ($this->u->M($postdata, array('userid'=>$id)) > 0)
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"编辑会员",$postdata['username']);
				$retmsg['code'] = '1';
				$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
                                $this->un->M(array('level' => $postdata['level'], 'name' => $postdata['name']), array('userid'=>$id));
				exit(json_encode($retmsg));
			}
			else
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('comm_fail_tip');
				exit(json_encode($retmsg));
			}
		}

	}

	public function del($id)
	{
		if (!$this->admin_priv('user'))
		{
			show_error("您没有权限进行此操作！");
		}
		if ($id == '') exit($this->lang->line('access_error'));
		$sdata['userid'] = $id;
		$userinfo = $this->u->O($sdata);
		if ($userinfo['ismaster'] != 0)
		{
			$this->load->model('Livecontent_model', 'content');
			$this->content->setLiveHistory($id);
//			$this->room->D(array('roomid'=>$userinfo['ismaster']));
		}

		$this->u->D($sdata);
                $this->un->D($sdata);
		$admininfo = $this->isAdmin();
		$this->action_log('1',$admininfo['user_id'],"删除会员",$userinfo['username']);
		$retmsg['code'] = '1';
		$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
		exit(json_encode($retmsg));
	}


	public function del_user()
	{
		if (!$this->admin_priv('user'))
		{
			show_error("您没有权限进行此操作！");
		}
		$postdata = $this->input->post('userid');
		if(!empty($postdata))
		{
			if(is_array($postdata))
			{
			$user_id = implode(',',$postdata);
			}
			$adinfo = $this->u->L(array('userid in(' . $user_id . ')'=>''));
			foreach ($adinfo as $k => $v)
			{
				$adname[] = $v['username'];
				if ($v['ismaster'] != 0)
				{
					$this->load->model('Livecontent_model', 'content');
					$this->content->setLiveHistory($v['userid']);
//					$this->room->D(array('roomid'=>$v['ismaster']));
				}
			}
			$this->u->D(array('userid in(' . $user_id . ')'=>''));
                        $this->un->D(array('userid in(' . $user_id . ')'=>''));
			$admininfo = $this->isAdmin();
			$this->action_log('1',$admininfo['user_id'],"批量删除用户",implode(',',$adname));
			$retmsg['code'] = '1';
			$retmsg['msg'] = $this->lang->line('success');
			exit(json_encode($retmsg));
		}
		else
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = '请选择会员';
			exit(json_encode($retmsg));
		}
	}

	public function setLevel($id)
	{
		if ($id == '')
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = $this->lang->line('access_error');
			exit(json_encode($retmsg));
		}

		$this->load->model('Live_model','l');
		$this->load->model('Category_model','c');

		if ($this->form_validation->run('user/setLevel') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			

			$userkind = $row = array();
			$row = $this->u->O(array('userid'=>$id), 'userid, kind');
			if ($row['kind'] != '') $userkind = unserialize($row['kind']);
			
			// 取直播室
			$catelist = $catelist_t = $roomlist = $roomlist_t = array();
			$roomlist_t = $this->room->L(array('status'=>1), 'roomid as id, roomname as name,cateid,userid');
			foreach ($roomlist_t as $k => $v) $roomlist[$v['cateid']][] = $v;

			// 获取直播栏目
			$catelist_t = $this->c->getCateData('live','all');
			foreach ($catelist_t as $k => $v)
			{
				$catelist[$k]['id'] = $v['cateid'];
				$catelist[$k]['name'] = $v['catename'];
				if (!empty($roomlist[$v['cateid']]))
				{
					$catelist[$k]['checkbox'] = array2checkbox('roomid', $roomlist[$v['cateid']], $userkind, 3);
				}
			}

			$this->_d['act'] = 'setLevel';
			$this->_d['roomlist'] = $catelist;
			$this->_d['row'] = $row;

			$this->load->view($this->_d['cfg']['tpl_admin'] . 'user/detail_level', $this->_d);
		}
		else
		{
			$this->load->model('Userkind_model','k');
			$postdata = $this->input->post();

			$this->k->delUserVip($postdata['userid']);
			$this->k->setUserVip($postdata);

			$postdata['mtime'] = time();
			if (!empty($postdata['roomid']))
			{
				$postdata['level'] = 1;
				@$postdata['appstatus'] = $postdata['approomvip'] = 0;
				$postdata['kind'] = serialize($postdata['roomid']);
			}
			else
			{
				$postdata['level'] = 0;
			}

			if ($this->u->M($postdata, array('userid'=>$postdata['userid'])) > 0)
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"设置用户等级",$postdata['userid']);
				$retmsg['code'] = '1';
				$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
				exit(json_encode($retmsg));
			}
			else
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('comm_fail_tip');
				exit(json_encode($retmsg));
			}
		}



	}


	public function setMaster($id)
	{
		if ($id == '')
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = $this->lang->line('access_error');
			exit(json_encode($retmsg));
		}

		$this->load->model('Live_model','l');
		$this->load->model('Category_model','c');

		if ($this->form_validation->run('user/setLevel') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			

			$userkind = $row = array();
			$row = $this->u->O(array('userid'=>$id), 'userid, ismaster');
			if ($row['ismaster'] != '') $userkind = array($row['ismaster']);
			
			// 取直播室
			$catelist = $catelist_t = $roomlist = $roomlist_t = array();
			$roomlist_t = $this->room->L(array('status'=>1), 'roomid as id, roomname as name,cateid,userid');
			foreach ($roomlist_t as $k => $v) $roomlist[$v['cateid']][] = $v;

			// 获取直播栏目
			$catelist_t = $this->c->getCateData('live','all');
			foreach ($catelist_t as $k => $v)
			{
				$catelist[$k]['id'] = $v['cateid'];
				$catelist[$k]['name'] = $v['catename'];
				if (!empty($roomlist[$v['cateid']]))
				{
					$catelist[$k]['checkbox'] = array2checkbox('roomid', $roomlist[$v['cateid']], $userkind, 3);
				}
			}

			$this->_d['act'] = 'setMaster';
			$this->_d['roomlist'] = $catelist;
			$this->_d['row'] = $row;

			$this->load->view($this->_d['cfg']['tpl_admin'] . 'user/detail_master', $this->_d);
		}
		else
		{
			/*$this->load->model('Userkind_model','k');
			

			$this->k->delUserVip($postdata['userid']);
			$this->k->setUserVip($postdata);*/
			$postdata = $this->input->post();
			$postdata['mtime'] = time();
			/*if (!empty($postdata['roomid']))
			{
				$postdata['roomkind'] = serialize($postdata['roomid']);
			}
			else
			{
				$postdata['roomkind'] = '';
			}*/

			if (!empty($postdata['roomid']))
			{
				$postdata['ismaster'] = $postdata['roomid'][0];
			}
			else
			{
				$postdata['ismaster'] = '';
			}

			if ($this->u->M($postdata, array('userid'=>$postdata['userid'])) > 0)
			{
				$admininfo = $this->isAdmin();
				$this->action_log('1',$admininfo['user_id'],"设置用户身份",$postdata['userid']);
				$retmsg['code'] = '1';
				$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
				exit(json_encode($retmsg));
			}
			else
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = $this->lang->line('comm_fail_tip');
				exit(json_encode($retmsg));
			}
		}



	}

	public function getUsers()
	{
		$sdata['cannotchat']='1';
		$userlist = $this->us->L($sdata, '*', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');

		foreach ($userlist as $k => $v)
		{
			$username = $this->u->O(array('userid'=>$v['userid']));
			$userlist[$k]['username'] = $username['username'];
		}
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->us->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['userlist'] = $userlist;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'user/disallowed_list', $this->_d);
	}

	public function canChat($id)
	{
		if($this->us->M(array('cannotchat'=>'0','mtime'=>time()),array('id'=>$id)))
		{
			$admininfo = $this->isAdmin();
			$this->action_log('1',$admininfo['user_id'],"激活用户聊天权限",$id);
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


	public function login_log()
	{
		if (!$this->admin_priv('login_log'))
		{
			show_error("您没有权限进行此操作！");
		}
		$sdata = array();
		$username = '';
		$s_btime='';
		$s_etime='';
		$postdata = $this->input->post();
		if (!empty($postdata['username']))
		{
			$username = $postdata['username'];
			$sdata['username like '.'\'' . $username . '%\''] = '';
		}
		if (!empty($postdata['s_btime']))
		{
			$s_btime = $postdata['s_btime'];
			$sdata['ctime >='.strtotime($s_btime." 00:00:00")] = '';
		}
		if (!empty($postdata['s_etime']))
		{
			$s_etime = $postdata['s_etime'];
			$sdata['ctime <='.strtotime($s_etime." 23:59:59")] = '';
		}
		$list = $this->l->L($sdata,'*',$this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'],'ctime','desc');
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->l->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['list'] = $list;
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['username'] = $username;
		$this->_d['s_btime'] = $s_btime;
		$this->_d['s_etime'] = $s_etime;
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'user/login_log', $this->_d);
	}


}

?>
