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
class Say_manage extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->isAdmin() == false)
            redirect("admin/login");
        if (!$this->admin_priv('moni_manage')) {
            show_error("您没有权限进行此操作！");
        }
        $this->load->model('admin/say_model','s');
        $this->load->model('Userstatus_model', 'us');	
        $this->load->model('Userinfo_model','u');
//        $this->load->model('admin/Admin_model','a');		
        $this->load->model('Useronline_model','un');
//        $this->load->model('Live_model','room');
//        $this->load->library('form_validation');
//        $this->load->model('admin/Login_log_model','l');
    }

    public function index() {
        $this->tlist();
    }

    public function tlist() {
        if (!$this->admin_priv('user')) {
            show_error("您没有权限进行此操作！");
        }
        $sdata = array();
        $list = $this->s->L('', '*', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur'] - 1) * $this->_p['pagenumb'], 'id');
        $this->_p['pagecount'] = $this->input->post('pagecount');
        if (empty($this->_p['pagecount'])) {
            $this->_p['pagecount'] = $this->s->C($sdata);
        }
//print_r($this->_p);exit;
        $this->_d['page'] = eyPage($this->_p, $sdata);
        $this->_d['list'] = $list;
        $this->_d['pagecount'] = $this->_p['pagecount'];
        $this->_d['username'] = $username;
        $this->_d['s_btime'] = $s_btime;
        $this->_d['s_etime'] = $s_etime;
        $this->load->view($this->_d['cfg']['tpl_admin'] . 'say_manage/list', $this->_d);
    }
    
    public function modi() {
        if (!$this->admin_priv('say_manage')) {
            show_error("您没有权限进行此操作！");
        }
        if ($this->form_validation->run() == false) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $id = $this->uri->segment(4, 0);
            if($id) {
                $res = $this->s->O(array('id' => $id), 'id,content, status');
                $this->_d['act'] = 'edit';
            } else {
                $res = $this->s->INIT();
                $this->_d['act'] = 'add';
            }
            $row['func'] = $func;
            $this->_d['row'] = $res;
            $this->load->view($this->_d['cfg']['tpl_admin'] . 'say_manage/detail', $this->_d);
        } else {
            $id = $this->input->post('id');
            $postdata = $this->input->post();
            unset($postdata['id']);
            if($id) {
                $res = $this->s->M($postdata, array('id' => $id));
            } else {
                $res = $this->s->A($postdata);
            }
            if ($res > 0) {
                $retmsg['code'] = '1';
                $retmsg['msg'] = $this->lang->line('success');
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('fail');
                exit(json_encode($retmsg));
            }
        }
    }

    public function del($id) {
        $this->s->D(array('id' => $id));
        $retmsg['code'] = '1';
        $retmsg['msg'] = $this->lang->line('success');
        exit(json_encode($retmsg));
    }
    
    public function say() {
        if (!$this->admin_priv('say_manage')) {
            show_error("您没有权限进行此操作！");
        }
        if ($this->form_validation->run() == false) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $userid = $this->uri->segment(4, 0);
            $this->_d['row'] = $this->un->O(array('userid' => $userid), 'userid, gap');
            if(empty($this->_d['row'])) {
                $this->_d['row']['userid'] = $userid;
            }
//            print_r($this->_d['row']);exit;
            $this->load->view($this->_d['cfg']['tpl_admin'] . 'say_manage/say_setting', $this->_d);
        } else {
            $userid = $this->input->post('userid');
            $gap = $this->input->post('gap');
            $userinfo = $this->u->O(array('userid' => $userid), 'userid,name,level,ismaster,ctime');
            $userinfo['role'] = 0;
            $userinfo['gap'] = $gap;
            $this->us->upUserOnline(26, $userinfo, $this->_d['cfg']['status_offline_time'] / 2, time() + 3600000);
            $retmsg['code'] = '1';
            $retmsg['msg'] = $this->lang->line('success');
            exit(json_encode($retmsg));
        }
    }
    
    public function nosay($userid) {
        $this->un->D(array('userid' => $userid));
    }
    
    public function del_say($userid) {
        $this->db->empty_table('live_say');
        $retmsg['code'] = '1';
        $retmsg['msg'] = $this->lang->line('success');
        exit(json_encode($retmsg));
    }
}

?>