<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Useronline_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->tbl = 'live_user_online';
        $this->tbl_key = 'userid';
    }

}

?>