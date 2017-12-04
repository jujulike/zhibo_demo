<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
session_start();

class Code extends CI_Controller {

	function __construct(){		
		parent::__construct();
	}


public function create_vcode() { 
    $this->load->model('Vcode_model','vcode'); 
    echo $this->vcode->doimg(); 
    //$session = array( 
     //   'name' => 'vcode', 
     //   'value' => $this->common->authCode($this->vcode->getCode(), 'ENCODE', _KEY), 
   //     'expire' => '1800', 
   // ); 
	$code = $this->vcode->getCode();
	//echo "ok";
	//print_r($session);
   // $this->input->set_cookie($cookie); 
   $this->session->unset_userdata("vcode");
  $this->session->set_userdata("vcode",$code);
  // print_r($_SESSION['code_session']);
   // die; 
}


}
?>