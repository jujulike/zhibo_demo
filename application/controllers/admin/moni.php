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
class Moni extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->isAdmin() == false)
            redirect("admin/login");
        if (!$this->admin_priv('moni')) {
            show_error("您没有权限进行此操作！");
        }	
        $this->load->model('Userinfo_model','u');
    }

    public function index() {
        $this->setting('26');
    }

    public function setting($roomid) {
        $postdata = $this->input->post();
        $this->_d['list'] = $this->config->item('moni_setdate');

        $setpath = FCPATH . APPPATH . 'cache/moni/';
        if (!file_exists($setpath . $roomid))
            mkdir($setpath . $roomid, 0777);

        $setfile = $setpath . $roomid . '/setting';

        if (empty($postdata)) {
            if (file_exists($setfile)) {
                $_postdata = unserialize(file_get_contents($setfile, FILE_BINARY, NULL, 0, 4096));
                foreach ($this->_d['list'] as $k => $v) {
                    $this->_d['list'][$k]['btime'] = (!empty($_postdata['btime_' . $k]) === true) ? $_postdata['btime_' . $k] : '';
                    $this->_d['list'][$k]['etime'] = (!empty($_postdata['etime_' . $k]) === true) ? $_postdata['etime_' . $k] : '';
                    $this->_d['list'][$k]['moninumber'] = (!empty($_postdata['moninumber_' . $k]) === true) ? $_postdata['moninumber_' . $k] : '';
                    $this->_d['list'][$k]['open'] = (isset($_postdata['id_' . $k])) ? 1 : 0;
                }
            }
        } else {
            file_put_contents($setfile, serialize($postdata), LOCK_EX);
            foreach ($this->_d['list'] as $k => $v) {
                if (isset($postdata['id_' . $k])) {
                    $f = $setpath . $roomid . "/" . $k;
                    $userdata = $this->createVisitor($postdata['moninumber_' . $k]);
                    file_put_contents($f, serialize($userdata), LOCK_EX);
                } else {
                    @unlink($setpath . $roomid . '/' . $k);
                }
            }

            $ret['code'] = 1;
            $ret['msg'] = '修改成功';
            exit(json_encode($ret));
        }

        $this->_d['roomid'] = $roomid;
        $this->load->view($this->_d['cfg']['tpl_admin'] . 'moni/setting', $this->_d);
    }

    private function createVisitor($number) {
        for ($i = 0; $i < $number; $i++) {
            $data[] = intval(rand(11111111, 99999999));
        }

        return $data;
    }

}

?>