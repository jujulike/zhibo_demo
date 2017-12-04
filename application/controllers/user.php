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
class User extends MY_Controller {

    /**
     * Index Page for this controller.
     *
     * Author: dgt <QQ:57790081;EMAIL:57790081@qq.com>
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Userinfo_model', 'u');
        $this->load->model('admin/Login_log_model', 'l');
        include './config.inc.php';
        include './uc_client/client.php';
    }

    public function index() {
        $this->load->view($this->_d['cfg']['tpl'] . 'user/login');
    }

    public function login() {
        $this->_d['retmsg'] = '';
        if ($this->form_validation->run('user/login') == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $retmsg['code'] = '0';
//				$retmsg['msg'] = $this->input->get();
            $retmsg['msg'] = $this->form_validation->run('user/login');
            exit(json_encode($retmsg));
        } else {
            $msg = $this->u->O(array('status' => 1, 'username' => $this->input->post('username')), ' userid, username, passwd, name, imgthumb, level,ismaster,kind,phone,qq');
			
			if($msg && setEncry($this->input->post('passwd')) != $msg['passwd']) {
				$retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('error_login');
                exit(json_encode($retmsg));
			}

            //if(!count($msg)) {
            //    $user = uc_get_user($this->input->post('username'));
            //    if($user) {
            //        $msg = array(
            //            'userid' => $user[0],
            //            'username' => $user[1],
            //            'name' => $user[1],
            //            'imagthumb' => '',
            //            'level' => '0',
            //            'ismaster' => '',
            //            'kind' => '',
            //            'phone' => '',
            //            'qq' => ''
            //        );
            //        $postdata['username'] = $this->input->post('username');
            //        $postdata['name'] = $this->input->post('username');
            //        $postdata['passwd'] = $this->input->post('passwd');
            //        $postdata['ctime'] = time();
            //        $postdata['regip'] = ip2long($this->input->ip_address());
            //        $postdata['userid'] = $user[0];
            //        $this->u->A($postdata);
            //    }
            //}
           
            if (count($msg)) {
                $this->setAuthor($msg);

                // 登陆日志
                $this->l->addLog($msg['userid'], $msg['username'], $this->input->ip_address());
                $retmsg['code'] = '1';
                $retmsg['msg'] = $this->lang->line('success_login');
                $retmsg['tourl'] = site_url('live/room/26');
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('error_login');
                exit(json_encode($retmsg));
            }
        }
    }

    public function logout() {
        parent::logout();
        redirect('');
    }

    public function reg() {

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $this->load->view($this->_d['cfg']['tpl'] . 'user/register', $this->_d);
        } else {
            $postdata = $this->input->post();

            if ($this->_d['cfg']['site_reg_vcode'] == '1') {
                $vcode = $postdata['r_code'];
                if (strtolower($vcode) != strtolower($this->session->userdata("vcode"))) {
                    $retmsg['code'] = '0';
                    $retmsg['msg'] = '请输入正确的验证码';
                    exit(json_encode($retmsg));
                }
            }

            $postdata['ctime'] = time();
            $postdata['regip'] = ip2long($this->input->ip_address());

            //$uid = uc_user_register($postdata['username'], $postdata['repasswd'], rand(10000,100000) . '@yinjinhui.com');
            //if($uid <= 0) {
            //    if($uid == -1) {
            //        $msg = '用户名不合法';
            //    } elseif($uid == -2) {
            //        $msg = '包含要允许注册的词语';
            //    } elseif($uid == -3) {
            //        $msg = '用户名已经存在';
            //    } elseif($uid == -4) {
            //        $msg = 'Email 格式有误';
            //    } elseif($uid == -5) {
            //        $msg = 'Email 不允许注册';
            //    } elseif($uid == -6) {
            //        $msg = '该 Email 已经被注册';
            //    } else {
            //        $msg = '未定义';
            //    }
            //    $retmsg['code'] = '0';
            //    $retmsg['msg'] = $msg;
            //    exit(json_encode($retmsg));
            //} else {
                $postdata['userid'] = $uid;
                if ($this->u->A($postdata) > 0) {
                    $retmsg['code'] = '1';
                    $retmsg['msg'] = $this->lang->line('reg_user_success');
                    exit(json_encode($retmsg));
                } else {
                    $retmsg['code'] = '0';
                    $retmsg['msg'] = $this->lang->line('reg_user_fail');
                    exit(json_encode($retmsg));
                }
            //}
        }
    }

    public function modi() {
        if ((empty($this->_d['userinfo'])) || ($this->_d['userinfo']['level'] == '-1'))
            redirect("user");

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $this->_d['row'] = $this->u->O(array('userid' => $this->_d['userinfo']['userid']));
            $this->load->view($this->_d['cfg']['tpl'] . 'user/modi', $this->_d);
        } else {
            $postdata = $this->input->post();
            $postdata['mtime'] = time();

            if ($postdata['newpasswd'] != '') {
                if ($postdata['newpasswd'] != ($postdata['repasswd'])) {
                    $retmsg['code'] = '0';
                    $retmsg['msg'] = $this->lang->line('passwd_modi_fail');
                    exit(json_encode($retmsg));
                } else {
                    $postdata['passwd'] = $postdata['newpasswd'];
                }
            }



            $sdata['userid'] = $this->_d['userinfo']['userid'];
            if ($this->u->M($postdata, $sdata)) {
                $msg = $this->u->O($sdata, 'userid, username,name, imgthumb, level,ismaster,kind,phone,qq, concat("0") as role');
                $this->setAuthor($msg);
                $retmsg['code'] = '1';
                $retmsg['msg'] = $this->lang->line('modi_userinfo_success');
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('modi_userinfo_fail');
                exit(json_encode($retmsg));
            }
        }
    }

    // 获取密码
    public function getpasswd() {
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

            $this->load->view($this->_d['cfg']['tpl'] . 'user/getpasswd', $this->_d);
        } else {
            $userinfo = $this->u->O(array('username' => $this->input->post('username')));
            if (!count($userinfo)) {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('getpasswd_nouser');
                exit(json_encode($retmsg));
            }

            // 重新设置密码，并发送到该帐号邮箱

            $newpasswd = random_string('nozero', '6');

            $pdata['passwd'] = setEncry($newpasswd);
            $sdata['userid'] = $userinfo['userid'];
            $sdata['status'] = 1;
            if ($this->u->M($pdata, $sdata)) {

                // 发送邮箱

                $this->load->library('email');            //加载CI的email类  
                $emailinfo = $this->config->item('emailinfo');
                $emailinfo['stmp_host'] = $this->cfg['smtp_server'];
                $emailinfo['smtp_user'] = $this->cfg['smtp_username'];
                $emailinfo['stmp_pass'] = $this->cfg['smtp_passwd'];
                $emailinfo['stmp_port'] = $this->cfg['smtp_port'];
                $this->email->initialize($this->config->item('emailinfo'));

                //以下设置Email内容  
                $this->email->from($this->cfg['stmp_email'], $this->cfg['site_title']);
                $this->email->to($userinfo['email']);
                $this->email->subject($this->cfg['site_title'] . '密码取回');
                $this->email->message('<font color=blue>你好:' . $userinfo['name'] . '，系统已经帮你重置了密码，密码为<B>' . $newpasswd . '</B>请登录后即时修改密码。</font>');
                $this->email->send();
                $retmsg['code'] = '1';
                $retmsg['msg'] = '重置密码已经发往您的注册邮箱，该邮件可能会被垃圾邮件处理，请注意查收！';
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = '密码修改失败，请重试!';
                exit(json_encode($retmsg));
            }
        }
    }

    public function checkUsername($username) {

        $userinfo = $this->u->O(array('username' => $username));
        if (count($userinfo)) {
            $this->form_validation->set_message('checkUsername', $this->lang->line('error_username_oc'));
            return false;
        } else {
            return true;
        }
    }

    public function checkOldPasswd($newpasswd) {
        $userinfo = $this->u->O(array('userid' => $this->session->userdata('userinfo')->userid), 'passwd');
        if ($userinfo['passwd'] == $newpasswd) {
            $this->form_validation->set_message('checkOldPasswd', $this->lang->line('passwd_fail_sameold'));
            return false;
        } else {
            return true;
        }
    }

    // 取注册用户的问题
    public function getQuestion() {

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }

//			$this->_d['userinfo'] = $userinfo;
            $this->load->view($this->_d['cfg']['tpl'] . 'user/getPasswd', $this->_d);
        } else {
            $userinfo = $this->u->O(array('username' => $this->input->post('username')), 'safequestion');

            if (isset($userinfo['safequestion'])) {
                $retmsg['code'] = '1';
                $retmsg['msg'] = $userinfo['safequestion'];
                $retmsg['username'] = $this->input->post('username');
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('get_safequestion_error');
                exit(json_encode($retmsg));
            }
        }
    }

    // 验证用户答案
    public function getAnswer() {

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors() != '') {
                $retmsg['code'] = '0';
                $retmsg['msg'] = validation_errors();
                exit(json_encode($retmsg));
            }
        } else {
            $userinfo = $this->u->o(array('username' => $this->input->post('username')), 'username,passwd,safeanswer');

            if (isset($userinfo['username']) && ($userinfo['safeanswer'] == $this->input->post('safeanswer'))) {
                $retmsg['code'] = '1';
                $retmsg['msg'] = $userinfo['passwd'];
                exit(json_encode($retmsg));
            } else {
                $retmsg['code'] = '0';
                $retmsg['msg'] = $this->lang->line('check_safeanswer_error');
                exit(json_encode($retmsg));
            }
        }
    }

    public function manage() {
        if ($this->session->userdata('userinfo')->status < 90)
            redirect("user");
        $this->load->library('pagination');

        $pg['base_url'] = site_url('user/manage');
        $pg['total_rows'] = $this->u->C(array('valid' => 1));
        $pg['per_page'] = 20;

        $currentPage = $this->uri->segment(3, 0);
        $this->pagination->initialize($pg);

        $offset = ($currentPage - 1) * $pg['per_page'];
        $this->_d['page'] = $this->pagination->create_links();
        $this->_d['count'] = $pg['total_rows'];
        $this->_d['items'] = $this->u->L(array('valid' => 1), '*', $pg['per_page'], $currentPage);
        $this->load->view($this->_d['cfg']['tpl'] . 'user/list', $this->_d);
    }

    public function del($userid) {
        if ($this->session->userdata('userinfo')->status < 90)
            redirect("user");
        if ($userid == $this->session->userdata('userinfo')->userid) {
            $retmsg['code'] = '0';
            $retmsg['msg'] = $this->lang->line('fail');
            exit(json_encode($retmsg));
        }
        $sdata['userid'] = $userid;
        $pdata['mtime'] = time();
        $pdata['valid'] = '-1';
        if ($this->u->M($pdata, $sdata)) {
            $retmsg['code'] = '1';
            $retmsg['msg'] = $this->lang->line('success');
            exit(json_encode($retmsg));
        } else {
            $retmsg['code'] = '0';
            $retmsg['msg'] = $this->lang->line('fail');
            exit(json_encode($retmsg));
        }
    }

    public function setHost($userid) {

        if ($this->session->userdata('userinfo')->status < 90)
            redirect("user");
        if ($userid == $this->session->userdata('userinfo')->userid) {
            $retmsg['code'] = '0';
            $retmsg['msg'] = $this->lang->line('fail');
            exit(json_encode($retmsg));
        }

        $sdata['status'] = 20;
        $pdata['status'] = 0;
        if ($this->u->M($pdata, $sdata)) {
            $pdata = $sdata = array();
            $sdata['userid'] = $userid;
            $pdata['mtime'] = time();
            $pdata['status'] = 20;
            if ($this->u->M($pdata, $sdata)) {
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

    // 电话验证
    public function phone_Check($tel) {
        if (!empty($tel)) {

            //eg: xxx-xxxxxxxx-xxx | xxxx-xxxxxxx-xxx ...
            if ($this->isMobile($tel))
                return true;
            else {
                $this->form_validation->set_message('phone_Check', $this->lang->line('error_phone'));
                return false;
            }
        } else {
            return true;
        }
    }

    /*
      验证手机号码
     */

    public function isMobile($mobilephone) {

        if (preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/", $mobilephone)) {

            return true;
        } else {
            return false;
        }
    }

}
