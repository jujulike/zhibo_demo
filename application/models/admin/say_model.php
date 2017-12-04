<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 管理员信息基本模型
 *
 */
class Say_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->tbl = 'live_say';
//        $this->tb2 = 'live_role';
        $this->tbl_key = 'id';
    }

}

?>