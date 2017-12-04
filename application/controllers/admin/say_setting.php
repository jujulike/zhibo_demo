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
class Say_setting extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->isAdmin() == false)
            redirect("admin/login");
        if (!$this->admin_priv('moni_manage')) {
            show_error("您没有权限进行此操作！");
        }
        $this->load->model('admin/say_model','s');
        $this->load->model('livechat_model','chat');
        $this->load->model('Userstatus_model', 'us');	
        $this->load->model('Userinfo_model','u');
//        $this->load->model('admin/Admin_model','a');		
        $this->load->model('Useronline_model','un');
//        $this->load->model('Live_model','room');
//        $this->load->library('form_validation');
//        $this->load->model('admin/Login_log_model','l');
    }

    public function index() {
        $this->load->view($this->_d['cfg']['tpl_admin'] . 'say_setting/index', $this->_d);
    }
    
    public function say_start() {
        set_time_limit(0);
        $content = $this->input->post('content');
        $gap = $this->input->post('gap');
        $content_arr = explode("\n", $content);
        
        //获取虚拟用户
        $sdata = array('type' => '2');
//        $list = $this->u->L($sdata, '*', 150);
        $list = $this->db->query('SELECT * FROM `live_userinfo_base` where type = 2 ORDER BY RAND() LIMIT 150')->result_array();
//print_r($list);exit;        
//        //设置虚拟用户在线状态
//        for($j = 0; $j < count($content_arr) && $j < count($list); $j++) {
//            $userinfo['userid'] = $list[$j]['userid'];
//            $userinfo['name'] = $list[$j]['name'];
//            $userinfo['level'] = $list[$j]['level'];
//            $userinfo['role'] = 0;
//            $userinfo['ismaster'] = $list[$j]['ismaster'];
//            $userinfo['ctime'] = time();
//            $this->us->upUserOnline(26, $userinfo, $this->_d['cfg']['status_offline_time'] / 2, time() + 24 * 3600 * 30 *12);
//        }

        $time = time();
        foreach ($content_arr as $k => $v) {
            if($k >= count($list)) {
                break;
            }
            $this->say($v, $list[$k]['name'], $list[$k]['level'], $list[$k]['userid'], $time);
            $time = $time + $gap + rand(2, 10);
        }
        $retmsg['code'] = '1';
        $retmsg['msg'] = $this->lang->line('success');
        exit(json_encode($retmsg));
    }
    
    public function say($content, $username, $ulevel, $userid, $time) {
        $data = array(
            'masterid' => 29,
            'chatcontent' => $content,
            'chatname' => $username,
            'level' => $ulevel,
            'chatuserid' => $userid,
            'status' => 1,
            'ctime' => $time
        );
        $this->chat->A($data);
    }
    
//    public function moni_say() {
//        $sdata = array('type' => '2');
//        $uns = $this->un->L($sdata, '*', 200);
//        foreach ($uns as $un) {
//            if(time() - ($un['ltime'] - 3600000) > $un['gap']) {
//                $res = $this->db->query('select * from `live_say` where status = 1 order by rand() limit 1')->row_array();
//                $data = array(
//                    'masterid' => 29,
//                    'chatcontent' => $res['content'],
//                    'chatname' => $un['name'],
//                    'level' => $un['level'],
//                    'chatuserid' => $un['userid'],
//                    'status' => 1,
//                    'ctime' => time()
//                );
//
//                $this->chat->A($data);
//                $this->un->M(array('ltime' => time()), array('userid' => $un['userid']));
//            }
//        }
//    }
}

?>