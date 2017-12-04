<?php

class MY_Controller extends CI_Controller {

    // 判断是否登录 
    public $islogin = false;
    public $_d = array();
    // 每页条数
    public $perpages = 20;
    // 分页初始化
    public $_p = array();

    public function __construct() {
        parent::__construct();
        $this->_d['confdisallowed'] = $this->config->item('confdisallowed');
        $this->initComm();
        $this->isLogin();

        $this->_p = array('pagenumb' => $this->perpages,
            'pagecur' => ($this->input->post('pagecur') == 1) ? 0 : $this->input->post('pagecur'),
            'pagecount' => $this->input->post('pagecount'));
    }

    public function isLogin() {
        $user = $this->session->userdata('userinfo');
        if (empty($user)) {
            $user = $this->setVisitor();
            $user = $this->setAuthor($user);
        }

        $this->_d['userinfo'] = $user;
        $this->islogin = ($user == false) ? false : true;
    }

    public function setAuthor($userdata) {
        if (empty($userdata['role']))
            $userdata['role'] = 0;
        $this->session->set_userdata('userinfo', $userdata);
        return $userdata;
    }

    // 设置游客的用户ID
    public function setUserId() {
        return intval(substr(time() . rand(), -8));
    }

    // 设置游客身份
    public function setVisitor() {
        $userinfo['userid'] = $this->setUserId();
        $userinfo['name'] = $userinfo['name'] = '游客' . $userinfo['userid'];
        $userinfo['level'] = -1;
        $userinfo['role'] = -1;
        $userinfo['ismaster'] = -1;
        $userinfo['ctime'] = time();
        return $userinfo;
    }

    public function initComm() {
        $f = FCPATH . APPPATH . 'cache/config';
        if (file_exists($f)) {
            $retdata = json_decode(file_get_contents($f, FILE_BINARY, NULL, 0, 12048), true);
        } else {
            $this->load->model('admin/Config_model', 'conf');
            $_retdata = $this->conf->L(array(), '*', 0);
            foreach ($_retdata as $k => $v)
                $retdata[$v['confkey']] = $v['confval'];
            file_put_contents($f, json_encode($retdata), LOCK_EX);
        }

        $this->_d['cfg'] = $retdata;

        $nativedata = array();

        $f = FCPATH . APPPATH . 'cache/menu';
        $this->load->model('Category_model', 'c');
        if (file_exists($f)) {
            $nativedata = json_decode(file_get_contents($f, FILE_BINARY, NULL, 0, 8192), true);
        } else {
            // 导航栏
            $this->load->model('Category_model', 'ddddd');
            $this->load->model('Advertising_model', 'adddd');
            $this->_d['ad'] = $this->adddd->L(array('cateid in(49,50)' => ''), 'title,link,imgthumb', 2, 0, 'advertid', 'desc');
            $this->_d['native'] = $this->ddddd->L(array('cateid in(29,30,31)' => '', 'status' => '1'), '*', '', 0, 'sort');
            $dddd = $this->ddddd->getCateData('menu');

            foreach ($dddd as $k => $v) {
                if ($v['parentid'] == 0) {
                    $parentcateid = $v['cateid'];
                    $nativedata[$v['cateid']] = $dddd[$k];
                }
            }

            foreach ($dddd as $k => $v) {
                if ($v['parentid'] != 0) {
                    if (!empty($nativedata[$v['parentid']]))
                        $nativedata[$v['parentid']]['subcate'][$k] = $dddd[$k];
                }
            }
            file_put_contents($f, json_encode($nativedata), LOCK_EX);
        }

        $this->_d['nativedata'] = $nativedata;

        // 首页公告
        $this->load->model('Notice_model', 'notice');
        $this->_d['notice'] = $this->notice->L(array('status' => '1'), 'noticeid,title,content,link', 0, 0, 'ctime', 'desc');
    }

    public function logout() {
        $this->session->unset_userdata('userinfo');
    }

    public function setAdminAuth($userdata) {
        $this->session->set_userdata('adminfo', $userdata);
    }

    public function isAdmin() {
        return $this->session->userdata('adminfo');
    }

    public function adminLogout() {
        $this->session->unset_userdata('adminfo');
    }

    /**
     * 判断管理员对某一个操作是否有权限。
     *
     * 根据当前对应的action_code，然后再和用户session里面的action_list做匹配，以此来决定是否可以继续执行。
     * @param     string    $priv_str    操作对应的priv_str
     * @param     string    $msg_type       返回的类型
     * @return true/false
     */
    public function admin_priv($priv_str) {
        $adminfo = $this->isAdmin();
        return CheckPriv($adminfo, $priv_str);
    }

    public function action_log($isadmin, $action_userid, $action, $key = '') {
        $this->load->model('Actionlog_model', 'aclog');
        $adata = array();
        $adata['userid'] = $action_userid;
        $adata['ctime'] = time();
        $adata['info'] = $action;
        $adata['ip'] = $this->input->ip_address();
        $adata['isadmin'] = $isadmin;
        if ($key != '') {
            $adata['info'] = $adata['info'] . "：" . $key;
        }

        if ($this->aclog->A($adata)) {
            return true;
        } else {
            return false;
        }
    }

//取得附件
    public function getAttach($id = '', $action = '') {
        $this->load->model('Attachedcate_model', 'ac');
        $this->load->model('Attacheddetail_model', 'attach');
        if (is_array($id)) {
            $id = implode(",", $id);
        }

        $attachcateid = $this->ac->L(array('detailid in (' . $id . ')' => '', 'action' => $action), '*', 0, 0);

        if (!empty($attachcateid)) {
            foreach ($attachcateid as $k => $v)
                $cateid[] = $v['attachcateid'];
            return $this->attach->L(array('attachcateid in (' . implode(",", $cateid) . ')' => ''), '*', 0, 0);
        } else {
            return false;
        }
    }

}
