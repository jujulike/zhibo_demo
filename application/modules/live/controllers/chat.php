<?php

class Live_Chat_Module extends CI_Module {

    private $_data = array();
    private $_tpl = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('Userinfo_model', 'u');
        $this->load->model('Livemaster_model', 'm');
        $this->load->model('Livechat_model', 'chat');
        $this->load->model('Userinfo_model', 'user');
        $this->load->model('Userstatus_model', 'us');
        $this->load->model('Useronline_model', 'un');
        $this->load->model('admin/Config_model', 'conf');
        $this->load->model('admin/Say_model', 's');
        if ($this->session->userdata('userinfo'))
            $this->_data['u'] = $this->session->userdata('userinfo');
        $_temp = $this->conf->O(array('confkey' => 'tpl'), 'confval', 0);
        $_arr_temp = explode("/", $_temp['confval']);
        $this->_tpl = $_arr_temp[1];
    }

    public function room($cateid, $roominfo, $hostinfo) {
        // 初始化聊天主题o
        $masterinfo = $this->m->O(array('roomid' => $roominfo[0]['roomid']));
        $this->_data['masterinfo'] = $masterinfo;
        //print_r($masterinfo);
        $sdata['masterid'] = $masterinfo['masterid'];
        $retdata = $this->conf->O(array('confkey' => 'isaudit'), 'confval', 0);
        $this->_data['confdisallowed'] = $this->config->item('confdisallowed');
        $this->_data['hostinfo'] = $hostinfo;
        $this->_data['isaudit'] = $retdata['confval'];
        $this->_data['masterinfo'] = $masterinfo;

        $this->load->view($this->_tpl . '/chat_room', $this->_data);
    }

    // 实时请求聊天内容
    public function getitem($masterid, $chatid = 0) {
//        print_r($this->_data['u']);exit;
        $masterinfo = $this->m->O(array('masterid' => $masterid));

        // 禁言处理begin
        $f = FCPATH . APPPATH . 'cache/room/' . $masterinfo['roomid'] . "_userstatus";
        if (file_exists($f)) {
            $retdata = json_decode(file_get_contents($f, FILE_BINARY, NULL, 0, 2096), true);
            if (!empty($retdata[$this->_data['u']['userid']])) {
                if ($retdata[$this->_data['u']['userid']]['status'] == '1') {
                    echo "<script>alert('你已被踢出,请过一段时间再来!');top.location.href='" . site_url('home') . "';</script>";
                    exit;
                }
            }
        }


        $sdata['masterid'] = $masterid;
        $sdata['chatid >' . $chatid] = '';
		$sdata['ctime < '] = time();

        $retdata = $this->conf->O(array('confkey' => 'isaudit'), 'confval', 0);
        if ($retdata['confval'] == '1') {
            if (!empty($this->_data['u']['ismaster']) && ($masterinfo['roomid'] == $this->_data['u']['ismaster'])) {
                $contentlist = $this->chat->L($sdata, '*', 30, 0, 'chatid', 'desc');
                asort($contentlist);
            } else {
                $sdata['status'] = '1';
                //	$contentlist = $this->chat->L($sdata, '*', 20, 0, 'chatid', 'desc');
                $contentlist = $this->chat->getChat($this->_data['u']['userid'], $masterid, $chatid);
                $newcontent = array();
                $nextid = 0;
                foreach ($contentlist as $v) {
                    if ($v['chatuserid'] == $this->_data['u']['userid'] && $v['status'] == 1 && ((time() - $v['mtime']) < 20)) {
                        if ($v['chatid'] > $nextid)
                            $nextid = $v['chatid'];
                        continue;
                    }
                    $newcontent[] = $v;
                }
                asort($newcontent);
                $contentlist = $newcontent;
            }
        } else {
            // 初始化,取条数
            if ($chatid == 0) {
                $contentlist = $this->chat->L($sdata, '*', 20, 0, 'chatid', 'desc');
                asort($contentlist);
            } else {
                $contentlist = $this->chat->L($sdata, '*', 30, 0, 'chatid', 'desc');
                asort($contentlist);
            }
        }

        $this->_data['chatlist'] = $contentlist;
        $this->_data['nextid'] = $nextid;

        $this->_data['masterinfo'] = $masterinfo;
        $this->_data['isaudit'] = $retdata['confval'];
        $this->load->view($this->_tpl . '/chat_item', $this->_data);
    }

    public function chataudit($chatid = '', $audit = '', $masterid = '', $chatuserid = '') {
        if ($audit == '1') {//放行
            $chatinfo = $this->chat->O(array('chatid' => $chatid, 'status' => '0'), 'masterid,chatcontent,chatname,chatuserid,touname,ctime,level,sourceimg,imgthumb');
            if (empty($chatinfo)) {
                $retmsg['code'] = '1';
                $retmsg['msg'] = '已通过！';
                $retmsg['chatid'] = $chatid;
                exit(json_encode($retmsg));
            }
            
            $chatinfo['mtime'] = time();
            $chatinfo['status'] = '1';
            if ($this->chat->A($chatinfo)) {
                $this->chat->D(array('chatid' => $chatid));
                $retmsg['code'] = '1';
                $retmsg['msg'] = '已通过！';
                $retmsg['chatid'] = $chatid;
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                exit(json_encode($retmsg));
            }
        }

        if ($audit == '2') { //禁言
            $mdata['status'] = '2';
            $mdata['mtime'] = time();

            $this->chat->M($mdata, array('chatid' => $chatid));

            $adata['userid'] = $chatuserid;
            //$adata['masterid'] = $masterid;
            //$adata['masteruserid'] = $this->_data['u']['userid'];
            $adata['cannotchat'] = '1';
            $adata['ctime'] = time();
            $userstatus = $this->us->O(array('userid' => $chatuserid));

            if (!empty($userstatus)) {
                $this->us->M(array('cannotchat' => 1, 'mtime' => time()), array('userid' => $chatuserid));
            } else {
                $this->us->A($adata);
            }

            $retmsg['code'] = '1';
            $retmsg['msg'] = '已禁言！';
            exit(json_encode($retmsg));
        }

        if ($audit == '3') { //删除
            $this->chat->D(array('chatid' => $chatid));

            $retmsg['code'] = '1';
            $retmsg['msg'] = '已删除！';
            $retmsg['chatid'] = $chatid;
            exit(json_encode($retmsg));
        }
    }

    public function getUsers($masterid) {
        $userlist = $this->us->L(array('cannotchat' => 1), '*', 0, 0, 'ctime', 'desc');
        foreach ($userlist as $k => $v) {
            $username = $this->user->O(array('userid' => $v['userid']));
            $userlist[$k]['username'] = $username['username'];
        }
        $this->_data['userlist'] = $userlist;
        $this->load->view('user_item', $this->_data);
    }

    public function canChat($id) {
        if ($this->us->M(array('cannotchat' => '0', 'mtime' => time()), array('id' => $id))) {
            $retmsg['code'] = '1';
            $retmsg['msg'] = '该用户被激活！';
            exit(json_encode($retmsg));
        } else {
            $retmsg['code'] = '0';
            $retmsg['msg'] = '激活失败！';
            exit(json_encode($retmsg));
        }
    }

}
