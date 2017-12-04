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
class Moni_manage extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->isAdmin() == false)
            redirect("admin/login");
        if (!$this->admin_priv('moni_manage')) {
            show_error("您没有权限进行此操作！");
        }
        $this->load->model('admin/Admin_model','a');		
        $this->load->model('Userinfo_model','u');
        $this->load->model('Live_model','room');
        $this->load->library('form_validation');
        $this->load->model('Userstatus_model', 'us');
        $this->load->model('Useronline_model', 'un');
        $this->load->model('admin/Login_log_model','l');
    }

    public function index() {
        $this->tlist();
    }

    public function tlist() {
        if (!$this->admin_priv('user')) {
            show_error("您没有权限进行此操作！");
        }
        $sdata = array('type' => '2');
        $username = '';
        $s_btime = '';
        $s_etime = '';
        $postdata = $this->input->post();
        if (!empty($postdata['username'])) {
            $username = $postdata['username'];
            $sdata['username like ' . '\'' . $username . '%\''] = '';
        }
        if (!empty($postdata['s_btime'])) {
            $s_btime = $postdata['s_btime'];
            $sdata['ctime >=' . strtotime($s_btime . " 00:00:00")] = '';
        }
        if (!empty($postdata['s_etime'])) {
            $s_etime = $postdata['s_etime'];
            $sdata['ctime <=' . strtotime($s_etime . " 23:59:59")] = '';
        }
        $list = $this->u->L($sdata, '*', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur'] - 1) * $this->_p['pagenumb'], 'ctime', 'desc');
        foreach($list as $k => $v) {
            $res = $this->un->O(array('userid' => $v['userid']));
            if($res) {
                $list[$k]['is_say'] = 1;
            } else {
                $list[$k]['is_say'] = 0;
            }
        }
        $this->_p['pagecount'] = $this->input->post('pagecount');
        if (empty($this->_p['pagecount'])) {
            $this->_p['pagecount'] = $this->u->C($sdata);
        }
        $this->_d['page'] = eyPage($this->_p, $sdata);
        $this->_d['list'] = $list;
        $this->_d['pagecount'] = $this->_p['pagecount'];
        $this->_d['username'] = $username;
        $this->_d['s_btime'] = $s_btime;
        $this->_d['s_etime'] = $s_etime;
        $this->load->view($this->_d['cfg']['tpl_admin'] . 'moni_manage/list', $this->_d);
    }
    
    public function create_user($moni_count) {
        $moni_count = intval($moni_count);
        if(is_numeric($moni_count)) {
            for ($i = 0; $i < $moni_count; $i++) {
                $youke = intval(rand(11111111, 99999999));
                $postdata = array(
                    'userid' => rand(10000, 100000),
                    'username' => $youke,
                    'name' => $youke,
                    'kind' => serialize('26'),
                    'level' => '0',
                    'status' => '1',
                    'ctime' => time(),
                    'type' => 2
                );
                $this->u->A($postdata);
        
                //设置虚拟用户在线状态
                unset($postdata['username'], $postdata['kind'], $postdata['status'], $postdata['type']);
                $postdata['role'] = 0;
                $postdata['ismaster'] = 0;
                $this->us->upUserOnline(26, $postdata, $this->_d['cfg']['status_offline_time'] / 2, time() + 24 * 3600 * 30 *12);
            }
            $retmsg['code'] = '1';
            $retmsg['msg'] = $this->lang->line('comm_sucess_tip');
            exit(json_encode($retmsg));
        }
        $retmsg['code'] = '0';
        $retmsg['msg'] = $this->lang->line('comm_fail_tip');
        exit(json_encode($retmsg));
    }

}

?>