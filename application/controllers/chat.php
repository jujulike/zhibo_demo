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
 */
class Chat extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Userinfo_model', 'u');
        $this->load->model('Category_model', 'cate');
        $this->load->model('Livechat_model', 'chat');
        $this->load->model('Livemaster_model', 'm');
        $this->load->model('Userstatus_model', 'us');
    }

    public function index() {

        /*
          $patterns = explode("\n", $this->_data['cfg']['word_filter']);
          print_r($patterns);
          exit;
          foreach ($patterns as $k => $v) if (!empty($v)) $patterns[$k] = '/' . $v . '/i';
          $replaces = array_fill(0, count($patterns), '*****');
          print_r($patterns);
          print_r($replaces);
         */
    }

    public function setContent() {
        header("Access-Control-Allow-Origin:*");
        if ($this->_d['cfg']['visitor_active'] == '0') {
            if (empty($this->_d['userinfo']) || $this->_d['userinfo']['level'] == '-1') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '只有登录用户才可以发言';
                exit(json_encode($retmsg));
            }
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }
        } else {
            $postdata = $this->input->post();
            if (($postdata['imgthumb'] != '') && ($this->_d['userinfo']['ismaster'] != $postdata['roomid'])) {
                //	$retmsg['code'] = '0';
                //	$retmsg['msg'] = '只有播主才能发图片';
                //	exit(json_encode($retmsg));
            }

            $postdata['chatcontent'] = trim(html2text($postdata['chatcontent']));
			
			preg_match('/@([^:]*):/i', $postdata['chatcontent'], $matches);
			$postdata['touname'] = $matches[1];
			$postdata['chatcontent'] = preg_replace('/@([^:]*):/i', '', $postdata['chatcontent']);

            if (($postdata['chatcontent'] == '') && ($postdata['imgthumb'] == '')) {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '内容不能为空';
                exit(json_encode($retmsg));
            }


            // 禁言处理begin
            $f = FCPATH . APPPATH . 'cache/room/' . $postdata['roomid'] . "_userstatus";
            if (file_exists($f)) {
                $retdata = json_decode(file_get_contents($f, FILE_BINARY, NULL, 0, 2096), true);
                if (!empty($retdata[$this->_d['userinfo']['userid']])) {
                    if ($retdata[$this->_d['userinfo']['userid']]['status'] == '0') {
                        $retmsg['code'] = '0';
                        $retmsg['msg'] = '您已被禁言！';
                        exit(json_encode($retmsg));
                    } else if ($retdata[$this->_d['userinfo']['userid']]['status'] == '1') {
                        $retmsg['code'] = '-1';
                        $retmsg['msg'] = '你已被踢出,请过一段时间再来!';
                        exit(json_encode($retmsg));
                    }
                }
            }
            // end;


            $wordcount = strlen($postdata['chatcontent']);
            if ($wordcount > 500) {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '最大只能输入200个字';
                exit(json_encode($retmsg));
            }

            $patterns = explode("\n", $this->_d['cfg']['word_filter']);
            foreach ($patterns as $k => $v)
                if (!empty($v))
                    $patterns[$k] = '/' . $v . '/i';
            $replaces = array_fill(0, count($patterns), '*****');
            $postdata['chatcontent'] = preg_replace($patterns, $replaces, $postdata['chatcontent']);

            $postdata['ctime'] = time();

            $postdata['status'] = '1';
            $this->load->model('admin/Config_model', 'conf');
            $retdata = $this->conf->O(array('confkey' => 'isaudit'), 'confval', 0);
            if ($retdata['confval'] == '1') {
                if (!empty($this->_d['userinfo']['ismaster']) && ($postdata['roomid'] == $this->_d['userinfo']['ismaster'])) {
                    $postdata['status'] = '1';
                } else {
                    $postdata['status'] = '0';
                }
            }

            if ($this->chat->A($postdata) > 0) {
                $retmsg['code'] = '1';
                if ($this->_d['cfg']['isaudit'] == '1') {
                    if ($this->_d['userinfo']['ismaster'] != $postdata['roomid']) {
                        $retmsg['msg'] = '内容已经成功发布，由于网络延迟，过会才会显示信息！'; //$this->lang->line('reg_content_success');
                    } else {
                        $retmsg['msg'] = '内容已经成功发布.';
                    }
                } else {
                    $retmsg['msg'] = '内容已经成功发布.';
                }

                // 开启消息即时返回
                $retmsg['content'] = $this->load->module('live/chat/getitem', array($postdata['masterid'], $postdata['lastchatid']), true);

                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['lasttime'] = time();
                $retmsg['msg'] = $this->lang->line('reg_content_fail');
                exit(json_encode($retmsg));
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */