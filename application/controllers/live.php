<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
 * 静态页面
 */
class Live extends MY_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->load->model('Live_model', 'l');
        $this->load->model('Userinfo_model', 'u');
        $this->load->model('Category_model', 'c');
        $this->load->model('Livemaster_model', 'm');
        $this->load->model('Livecontent_model', 'mc');
        $this->load->model('Livecontentold_model', 'mc_old');
        $this->load->model('Livechatold_model', 'ch_old');
        $this->load->model('Livechat_model', 'ch');
    }

    public function index() {
        $this->load->view($this->_d['cfg']['tpl'] . "live", $this->_d);
    }

    public function roomapp() {
        if ((empty($this->_d['userinfo'])) || ($this->_d['userinfo']['level'] == '-1')) {
            show_error('只有登录用户才可以申请直播室');
        }

        $roominfo = $this->l->O(array('userid' => $this->_d['userinfo']['userid']));

        if (count($roominfo) > 0) {
            if ($roominfo['status'] == '1') {
                show_error('恭喜！成功开通了<B>' . $roominfo['roomname'] . "！</B><br/>请重新登录后可正常使用！</B>");
            } else {
                show_error('你已经申请了<B>' . $roominfo['roomname'] . "！</B><br/>目前正等待管理员申核中...</B>");
            }
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $this->_d['row'] = $this->session->userdata('userinfo');
            $this->load->view($this->_d['cfg']['tpl'] . "live/room_app", $this->_d);
        } else {
            $postdata = $this->input->post();
            $postdata['ctime'] = time();
            if ($this->l->A($postdata) > 0) {
                $retmsg['code'] = '1';
                $retmsg['msg'] = $this->lang->line('reg_roomapp_success');
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('reg_roomapp_fail');
                exit(json_encode($retmsg));
            }
        }
    }

    // 申请VIP
    public function appVip($roomid) {
        if ((empty($this->_d['userinfo'])) || ($this->_d['userinfo']['level'] == '-1')) {
            show_error('只有登录用户才可以申请VIP！');
        }

        if (empty($roomid))
            show_error('请到相映的直播室进行VIP申请!');


        if ($this->form_validation->run('live/appVip') == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $this->_d['userinfo'] = $this->u->O(array('userid' => $this->_d['userinfo']['userid']));
            $this->_d['approomvip'] = $roomid;
            $this->load->view($this->_d['cfg']['tpl'] . "live/vip_app", $this->_d);
        } else {
            $postdata = $this->input->post();
            $postdata['ctime'] = time();
            if ($this->u->M($postdata, array('userid' => $this->_d['userinfo']['userid'])) > 0) {
                $retmsg['code'] = '1';
                $retmsg['msg'] = $this->lang->line('reg_vipapp_success');
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('reg_vipapp_fail');
                exit(json_encode($retmsg));
            }
        }
    }

    public function pass_room($roomid = '', $flag = '') {
        if (empty($roomid))
            $roomid = 26;
        $roominfo = $this->l->O(array('status' => 1, 'roomid' => $roomid));

        if ($flag == '') {
            if (count($roominfo) == 0) {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '找不到这个直播室或者直播室已关闭';
                exit(json_encode($retmsg));
            }

            // 直播室设置了密码
            if ($roominfo['roompass'] != '') {
                $retmsg['code'] = '2';
                $retmsg['msg'] = '';
                $retmsg['roomid'] = $roomid;
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '1';
                $retmsg['msg'] = '';
                exit(json_encode($retmsg));
            }
        } else {
            $postdata = $this->input->post();
            if (empty($postdata['roompass'])) {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '请输入直播室密码';
                exit(json_encode($retmsg));
            }

            if ($postdata['roompass'] != $roominfo['roompass']) {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '请输入正确的直播室密码';
                exit(json_encode($retmsg));
            } else {

                $this->session->set_userdata('roomkey', $roominfo['roompass']);
                $retmsg['code'] = '1';
                $retmsg['msg'] = '欢迎进入直播室';
                exit(json_encode($retmsg));
            }
        }
    }

    // 进入直播室
    public function room($roomid = '') {
			if (empty($roomid))
				redirect(site_url('live/room/26'));

			$roominfo = $this->l->O(array('status' => 1, 'roomid' => $roomid));

			if ($this->_d['cfg']['open_roomkey'] == '1') {
				if ($this->session->userdata('roomkey') != $roominfo['roompass']) {
					header("Content-Type:text/html;charset=utf-8");
					echo "<script>alert('请输入房间密码');this.location.href='/enter.html';</script>";
					exit;
				}
			}


			if (count($roominfo) == 0) //redirect(site_url(''));
				show_error('找不到这个直播室或者直播室已关闭');

			// 判断是否被踢出
			$f = FCPATH . APPPATH . 'cache/room/' . $roomid . "_userstatus";
			if (file_exists($f)) {
				$retdata = json_decode(file_get_contents($f, FILE_BINARY, NULL, 0, 4096), true);
				if (!empty($retdata[$this->_d['userinfo']['userid']])) {
					if ($retdata[$this->_d['userinfo']['userid']]['status'] == '1') {
						header("Content-Type:text/html;charset=utf-8");
						exit('你已被踢出,请过一段时间再来!');
					}
				}
			}

			$catedata = $this->c->getCateData('live');
			foreach ($catedata as $k => $v) {
				if ($roominfo['cateid'] == $v['cateid']) {
					$roominfo['catename'] = $v['catename'];
					$roominfo['catealias'] = $v['alias'];
				}
			}

			$hostinfo = $this->u->O(array('userid' => $roominfo['userid']));

			$masterinfo = $this->m->O(array('roomid' => $roominfo['roomid']));
			$this->_d['roominfo'] = $roominfo;
			$this->_d['hostinfo'] = $hostinfo;
			$this->_d['masterinfo'] = $masterinfo;
			$this->_d['userinfo'];
			$this->_d['login_view'] = $this->config->item('login_view');


			// 投票结果
			$this->load->model('Vote_model', 'v');
			for ($i = 3; $i < 6; $i++) {

				$_vdata = $this->v->getRate('', $i);

				$data = array();
				$data[0]['c'] = $data[0]['v'] = 0;
				$data[1]['c'] = $data[1]['v'] = 0;
				$data[2]['c'] = $data[2]['v'] = 0;

				if (!empty($_vdata)) {
					$data = cate2array($_vdata, 'votetype');
					$sumtotal = 0;
					foreach ($data as $k => $v)
						$sumtotal += $v['c'];

					if (empty($data[0]['c']))
						$data[0]['c'] = 0;
					if (empty($data[1]['c']))
						$data[1]['c'] = 0;
					if (empty($data[2]['c']))
						$data[2]['c'] = 0;

					$data[0]['v'] = round($data[0]['c'] / $sumtotal, 1) * 100;
					$data[1]['v'] = round($data[1]['c'] / $sumtotal, 1) * 100;
					$data[2]['v'] = round($data[2]['c'] / $sumtotal, 1) * 100;
				}
				$this->_d['vote_result'][$i] = $data;
			}

			$this->l->setHits($roomid);


			$this->load->model("Advertisement_model", "ad");
//print_r($this->_d['userinfo']);exit;
			$adlist = $this->ad->getChannelAds('room');
			$adlist['kefu'] = array_slice($adlist[130], 0, 4);
			$adlist['kefu_more'] = array_slice($adlist[130], 5);
			$this->_d['adlist'] = $adlist;
			$this->load->view($this->_d['cfg']['tpl'] . "live/room", $this->_d);
		
    }

    // 开设主题
    public function setMaster() {
        if (empty($this->_d['userinfo']['ismaster']))
            show_error('没有权限开设主题!');
        $roominfo = $this->l->O(array('status' => 1, 'roomid' => $this->_d['userinfo']['ismaster']));
        if (count($roominfo) == 0) //redirect(site_url(''));
            show_error('不能开设主题因为找不到这个直播室或者直播室已关闭');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $this->load->view($this->_d['cfg']['tpl'] . "live/set_master", $this->_d);
        } else {
            // 清空之前的直播数据
            $this->mc->setLiveHistory($this->_d['userinfo']['userid']);

            $postdata = $this->input->post();
            $postdata['author'] = $this->_d['userinfo']['name'];
            $postdata['contentcate'] = '72';
            $postdata['etime'] = time();
            $postdata['ctime'] = time();
            if ($this->m->A($postdata) > 0) {

                $postdata['content'] = $postdata['mastertitle'] . "<BR/>" . $postdata['masterinfo'];
                $postdata['masterid'] = $this->db->insert_id();
                // 写入第一条直播主题数据
                $this->mc->A($postdata);

                $retmsg['code'] = '1';
                $retmsg['msg'] = $this->lang->line('reg_setmaster_success');
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('reg_setmaster_fail');
                exit(json_encode($retmsg));
            }
        }
    }

    // 发布直播内容
    public function setLiveContent() {
        if (empty($this->_d['userinfo']['ismaster']))
            show_error('没有权限发布内容!');

        if ($this->form_validation->run('contentsubmit') == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }
        } else {
            $postdata = $this->input->post();

            // 删除初始化数据缓存
            $this->db->cache_delete('/live', 'room', $postdata['masterid'], '', '');
            $this->db->cache_delete('/module', 'live', 'content', 'appLiveContent', $postdata['masterid']);

            $postdata['author'] = $postdata['name'];
            $postdata['ctime'] = time();
            if ($this->mc->A($postdata) > 0) {
                $sdata['masterid'] = $postdata['masterid'];
                $sdata['userid'] = $postdata['userid'];
                $this->m->M(array('etime' => time()), $sdata);
                $retmsg['code'] = '1';
                $retmsg['msg'] = $this->lang->line('reg_content_success');
                $retmsg['lasttime'] = time();
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('reg_content_fail');
                exit(json_encode($retmsg));
            }
        }
    }

    // 提问处理
    public function setQuestion() {
        $this->load->model('Livequestion_model', 'qa');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }
        } else {
            $postdata = $this->input->post();

            $postdata['questionname'] = $postdata['name'];
            $postdata['questioncontent'] = $postdata['content'];
            $postdata['questionuserid'] = $postdata['userid'];
            $postdata['ctime'] = time();
            if ($this->qa->A($postdata) > 0) {
                $retmsg['code'] = '1';
                $retmsg['msg'] = $this->lang->line('reg_setquestion_success');
                $retmsg['lasttime'] = time();
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('reg_setquestion_fail');
                exit(json_encode($retmsg));
            }
        }
    }

    // 回答提问
    public function setAnswer($questionid) {

        if (empty($this->_d['userinfo']['ismaster']))
            show_error('没有权限发布内容!');
        if (empty($questionid))
            show_error('问题编辑丢失!');


        $this->load->model('Livequestion_model', 'qa');

        if ($this->form_validation->run('contentsubmit') == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }
            $this->_d['row'] = $this->qa->O(array('questionid' => $questionid));
            $this->load->view($this->_d['cfg']['tpl'] . "live/answer", $this->_d);
        } else {
            $postdata = $this->input->post();

            $postdata['answercontent'] = $postdata['content'];
            $postdata['mtime'] = time();

            $this->qa->D(array('questionid' => $questionid));
            unset($postdata['questionid']);
            if ($this->qa->A($postdata) > 0) {
                if (!empty($postdata['tolive'])) {
                    $adata['userid'] = $postdata['answeruserid'];
                    $adata['author'] = $postdata['answername'];
                    $adata['masterid'] = $postdata['masterid'];
                    $adata['contentcate'] = '71';
                    $adata['content'] = "网友（" . $postdata['questionname'] . "）问：" . $postdata['questioncontent'] . "？<br />播主回答：" . $postdata['answercontent'];
                    $adata['ctime'] = time();
                    if ($this->mc->A($adata) > 0) {
                        $sdata['masterid'] = $postdata['masterid'];
                        $sdata['userid'] = $postdata['answeruserid'];
                        $this->m->M(array('etime' => time()), $sdata);
                    }
                }

                $retmsg['code'] = '1';
                $retmsg['msg'] = $this->lang->line('reg_setanswer_success');
                $retmsg['lasttime'] = time();
                $retmsg['delid'] = $questionid;
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('reg_setanswer_fail');
                exit(json_encode($retmsg));
            }
        }
    }

    // 进入历史直播室
    public function listHistory($roomid = '') {
        if (empty($roomid))
            redirect();

        $this->db->cache_on();

        $roominfo = $this->l->O(array('status' => 1, 'roomid' => $roomid));
        if (count($roominfo) == 0)
            redirect(site_url(''));
//			show_error('找不到这个直播室');

        $catedata = $this->c->getCateData('live');
        foreach ($catedata as $k => $v) {
            if ($roominfo['cateid'] == $v['cateid']) {
                $roominfo['catename'] = $v['catename'];
                $roominfo['catealias'] = $v['alias'];
            }
        }

        $hostinfo = $this->u->O(array('userid' => $roominfo['userid']));
        // 历史直播主题
        $offset = $this->uri->segment(4, 0);

        $this->load->library('pagination');
        $pg['base_url'] = site_url('live/listHistory/' . $roomid);
        $pg['total_rows'] = $this->m->C(array('roomid' => $roominfo['roomid'], 'status' => 2));
        $pg['per_page'] = '20';
        $pg['uri_segment'] = 4;

        $this->pagination->initialize($pg);

        $this->_d['page'] = $this->pagination->create_links();
        $this->_d['count'] = $pg['total_rows'];

        $masterinfo = $this->m->L(array('roomid' => $roominfo['roomid'], 'status' => 2), '*', $pg['per_page'], $offset, 'etime', 'desc');


        $this->_d['masterlist'] = $masterinfo;
        $this->_d['roominfo'] = $roominfo;
        $this->_d['hostinfo'] = $hostinfo;

        $this->l->setHits($roomid);
        $this->load->view($this->_d['cfg']['tpl'] . "live/listhistory", $this->_d);
    }

    // 历史直播详细信息
    public function detailHistory($masterid = '') {
        if (empty($masterid))
            redirect();

        $this->db->cache_on();

        // 取得历史直播详细信息
        $this->_d['masterinfo'] = $this->m->O(array('masterid' => $masterid));
        $this->_d['contentlist'] = $this->mc_old->L(array('masterid' => $masterid));
        $this->_d['chatlist'] = $this->ch_old->L(array('masterid' => $masterid));

        $this->load->view($this->_d['cfg']['tpl'] . "live/detailHistory", $this->_d);
    }

    // 编辑主题
    public function editTitle($roomid = '') {
        if ($this->form_validation->run('live/setMaster') == FALSE) {
            $this->_d['masterinfo'] = $this->m->O(array('roomid' => $roomid, 'status' => '1'));
            $this->load->view($this->_d['cfg']['tpl'] . "live/edit_title", $this->_d);
        } else {
            $postdata = $this->input->post();
            $mdata['mastertitle'] = $postdata['mastertitle'];
            $mdata['masterinfo'] = $postdata['masterinfo'];
            $mdata['mtime'] = time();
            if ($this->m->M($mdata, array('masterid' => $postdata['masterid']))) {
                $retmsg['code'] = '1';
                $retmsg['msg'] = '修改成功！';
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '修改失败！';
                exit(json_encode($retmsg));
            }
        }
    }

    // 编辑简介
    public function editRoominfo($roomid = '', $cate = '', $flag = '') {
        if ($flag == '') {
            $this->_d['roominfo'] = $this->l->O(array('roomid' => $roomid));
            $this->_d['cate'] = $cate;
            $this->load->view($this->_d['cfg']['tpl'] . "live/edit_roominfo", $this->_d);
        } else {
            $postdata = $this->input->post();
            if ($cate == '1')
                $mdata['userinfo'] = $postdata['userinfo'];
            else
                $mdata['roominfo'] = $postdata['roominfo'];
            $mdata['mtime'] = time();
            if ($this->l->M($mdata, array('roomid' => $postdata['roomid']))) {
                $retmsg['code'] = '1';
                $retmsg['msg'] = '修改成功！';
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '修改失败！';
                exit(json_encode($retmsg));
            }
        }
    }

    // 首页显示昨日直播详细信息
    public function lastDetail($masterid = '') {
        if (empty($masterid))
            redirect();

        $this->db->cache_on();

        // 取得昨日直播详细信息
        $this->_d['masterinfo'] = $this->m->O(array('masterid' => $masterid));
        $this->_d['contentlist'] = $this->mc_old->L(array('masterid' => $masterid));
        if (empty($this->_d['contentlist']))
            $this->_d['contentlist'] = $this->mc->L(array('masterid' => $masterid));
        $this->_d['chatlist'] = $this->ch_old->L(array('masterid' => $masterid));
        if (empty($this->_d['chatlist']))
            $this->_d['chatlist'] = $this->ch->L(array('masterid' => $masterid));

        $this->load->view($this->_d['cfg']['tpl'] . "live/detailHistory", $this->_d);
    }

    // 课表
    public function classes($roomid = 26) {
        $this->_d['weekdate'] = $this->config->item('classes_setdate');

        $setpath = FCPATH . APPPATH . 'cache/classes/';
        if (!file_exists($setpath . $roomid))
            show_error('未设置课表');

        $setfile = $setpath . $roomid . '/setting';

        if (file_exists($setfile)) {
            $list = unserialize(file_get_contents($setfile, FILE_BINARY, NULL, 0, 4096));
            $this->_d['class_bime'] = $list['class_btime'];
            $this->_d['class_etime'] = $list['class_etime'];
            $this->_d['class_name'] = $list['class_name'];
        } else {
            show_error('未设置课表');
        }

        $this->load->view($this->_d['cfg']['tpl'] . "live/classes", $this->_d);
    }

}
