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
class Userstatus extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Userstatus_model', 'us');
    }

    public function setUserOnline($roomid) {
        if (empty($roomid) || (!is_numeric($roomid)))
            return '';

        if ($this->_d['userinfo']['ismaster'] == $roomid)
            $this->_d['userinfo']['role'] = 1;

        $this->us->upUserOnline($roomid, $this->_d['userinfo'], $this->_d['cfg']['status_offline_time'] / 2);
        $this->_d['useronline'] = $this->us->getUserOnline($roomid, $this->_d['cfg']['status_offline_time'] / 2);
        $this->_d['roomid'] = $roomid;
        $this->_d['userstatus'] = $this->us->getStatus($roomid);
		//print_r($this->_d['useronline']);exit;
        // moni用户
        $f = FCPATH . APPPATH . 'cache/moni/' . $roomid . '/setting';
        $this->_d['moniuser'] = array();
        if (file_exists($f)) {
            $_setting = unserialize(file_get_contents($f, FILE_BINARY, NULL, 0, 4096));
            $_curday = date('w');
            $_curtime = date("H:i:s");
            if ((isset($_setting['id_' . $_curday])) &&
                    (strtotime($_setting['btime_' . $_curday]) < strtotime($_curtime)) &&
                    (strtotime($_setting['etime_' . $_curday]) > strtotime($_curtime))) {

                $this->_d['moniuser'] = unserialize(file_get_contents(FCPATH . APPPATH . 'cache/moni/' . $roomid . '/' . $_curday, FILE_BINARY, NULL, 0, 4096));
            }
        }

        $this->load->view($this->_d['cfg']['tpl'] . 'userstatus/user_item', $this->_d);
    }

    // 禁言
    public function setStop($roomid, $uid) {
        if ($this->_d['userinfo']['ismaster'] != $roomid)
            return false;

        if ($this->us->setStop($roomid, $uid)) {
            $ret['code'] = 1;
            $ret['msg'] = $uid;
            echo json_encode($ret);
        }
    }

    // 取消禁言
    public function setCancelStop($roomid, $uid) {
        if ($this->_d['userinfo']['ismaster'] != $roomid)
            return false;

        if ($this->us->setCancelStop($roomid, $uid)) {
            $ret['code'] = 1;
            $ret['msg'] = $uid;
            echo json_encode($ret);
        }
    }

    // 踢除
    public function setOut($roomid, $uid) {
        if ($this->_d['userinfo']['ismaster'] != $roomid)
            return false;

        if ($this->us->setOut($roomid, $uid)) {
            $ret['code'] = 1;
            $ret['msg'] = $uid;
            echo json_encode($ret);
        }
    }

}
