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

class Dxtest extends CI_Controller {

	public function index()
	{
		unset($arrPostInfo);

		$username='bjztcf_V2';
		$password='123456';
		$mobile='13906715632';
		$content='短信内容';

		$arrPostInfo = "USERNAME=".$username."&PASSWORD=".$password."&MOBILE=".$mobile."&CONTENT=".$content;

		$url = 'http://wx360.bjfzq.com/NetMessage/http/SendSMS';//请求的url地址

		$ch = curl_init();//打开

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $arrPostInfo);

		$response  = curl_exec($ch);
		curl_close($ch);//关闭

		print_r($response);
		
	}
}

?>