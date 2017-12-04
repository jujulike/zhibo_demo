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
 * 静态页面
 */
class Nav extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view($this->_d['cfg']['tpl'] . "live", $this->_d);
    }
    
    public function caijing() {
        //$caijingrili = $this->get_web('http://www.dailyfx.com.hk/calendar/index.html');
        //$source = $this->pet_str('<div id="container">', '<div id="footer">', $caijingrili['buffer'], 'block');
        //$source = str_replace('/ext', 'http://www.dailyfx.com.hk/ext', $source);
        //$source = str_replace('src="/img/', 'src="http://www.dailyfx.com.hk/img/', $source);
        //$source = str_replace('href="', 'target="_blank" href="http://www.dailyfx.com.hk/img', $source);
        //echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        //<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
        //<head>
        //<title></title>
        //<meta http-equiv="Refresh" content="1800" />
        //<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        //<link rel="canonical" href="http://www.dailyfx.com.hk/calendar/index.html" />
        //<script type="text/javascript" src="http://redirect.fxcorporate.com/geo.js"></script>
        //<script type="text/javascript" src="http://www.dailyfx.com.hk/ext/jquery.min.js"></script>
        /*<script type="text/javascript" src="http://www.dailyfx.com.hk/ext/language.js"></script>
        <script type="text/javascript" src="http://www.dailyfx.com.hk/ext/initialize.js"></script>
        <script type="text/javascript" src="http://www.dailyfx.com.hk/ext/swfobject.js"></script>
        <link rel="stylesheet" type="text/css" href="http://www.dailyfx.com.hk/ext/dfx.css" />
        <script src="http://www.dailyfx.com.hk/ext/dfx.js" type="text/javascript"></script>
        <script type="text/javascript" src="http://www.dailyfx.com.hk/ext/jquery-ui-1.8.15.custom.min.js"></script>
        <script type="text/javascript" src="http://www.dailyfx.com.hk/ext/jquery.ui.datepicker-zh-cn.js"></script>
        <script type="text/javascript" src="http://www.dailyfx.com.hk/ext/jquery.validate.min.js"></script>
        <script type="text/javascript" src="http://www.dailyfx.com.hk/ext/calendar3.js"></script>
        <style>
            #content{overflow: visible;}
        </style>
        </head><body><div id="container">';*/
        //echo $source;
        //echo '</div></body></html>';
		echo '<link href="http://www.fx9k.com/default/style/public.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="http://www.fx9k.com/default/script/jquery-1.6.2.min.js" ></script>
		<script type="text/javascript" src="http://www.fx9k.com/default/script/indexlogin.js"></script>';
		$s = file_get_contents('http://www.fx9k.com/caijingrili');
		$s = str_replace(array('href="/', 'src="/'), array('href="http://www.fx9k.com/', 'src="http://www.fx9k.com/'), $s);
		$s = '<div class="main">' . $this->pet_str('<div class="main">', '<div class="main padding_t20', $s, 'block');
		echo $s;
    }
    
    public function baiyin() {
        $html_source = $this->get_web('http://www.dyhjw.com/html/hangqing/etf/slv_etf.php');
        $source = $html_source['buffer'];
        $source = preg_replace('/<iframe([^>]*?)>([^<]*?)<\/iframe>/i', '', $source);
        $source = preg_replace('/<tr><td height="40" colspan="6" align="center">(.*?)<\/tr>/i', '', $source);
        echo $source;
    }
    
    public function huangjin() {
        $html_source = $this->get_web('http://www.dyhjw.com/html/hangqing/etf/etf.php');
        $source = $html_source['buffer'];
        $source = preg_replace('/<iframe([^>]*?)>([^<]*?)<\/iframe>/i', '', $source);
        $source = preg_replace('/<tr><td height="40" colspan="6" align="center">(.*?)<\/tr>/i', '', $source);
        echo $source;
    }
    
    /**
     * 获取HTML源码
     * @param url $string URL路径
     * @param postData $string  特定的POST数据[URL形式]
     * @param cookie $string 特定的COOKIE
     * @param referer_url $string 来源/引用URL
     * @param proxy $string 代理IP
     * @param httpHeader $aray 设置CURLOPT_HTTPHEADER信息 array('X-FORWARDED-FOR:8.8.8.8', 'CLIENT-IP:8.8.8.8')
     */
    function get_web($url='', $postData='', $cookie='', $referer_url='', $proxy='', $httpHeader='') {
        if (!isset($url) || (!strstr($url, 'http://') and !strstr($url, 'https://') )) {
            echo "URL Empty or [http://] or [https://] Not Exist!!! Error (1)\n";
            exit;
        }
        $ch = curl_init(); //初始化curl
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求链接
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //使用自动跳转
        curl_setopt($ch, CURLOPT_MAXREDIRS, 15); //指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的。
        curl_setopt($ch, CURLOPT_HEADER, 0); // 如果你想把一个头包含在输出中，设置这个选项为一个非零值
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)"); //模拟用户使用的浏览器
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); //在发起连接前等待的时间，如果设置为0，则无限等待
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置超时限制防止死循环

        $parseUrl = parse_url($url); //解析URL

        if (empty($httpHeader) || !is_array($httpHeader)) {
            if (!isset($parseUrl['port']) || $parseUrl['port'] == "80" || empty($parseUrl['port'])) {
                $host_str = $parseUrl['host'];
            } else {
                $host_str = $parseUrl['host'] . ":" . $parseUrl['port'];
            }
            $httpHeader[] = "Host: " . $host_str;
            $httpHeader[] = "Cache-Control: no-cache";
            $httpHeader[] = "Connection: Keep-Alive";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader); //设置一个header中传输内容的数组

        if ($proxy) {//设置代理
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }

        if (!$referer_url) {//自动获取来源URL
            $referer_url = "http://" . $parseUrl['host'];
        }
        curl_setopt($ch, CURLOPT_REFERER, $referer_url);

        if ($cookie) {//设置Cookie
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }

        if ($postData) {//设置Post数据
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        $buffer = curl_exec($ch); //执行一个curl会话
        $header = curl_getinfo($ch); //获取一个curl连接资源句柄的信息
        // 检查是否有错误发生
        if (curl_errno($ch)) {
            echo '<font color="red"> Curl error: ' . curl_errno($ch) . ' => ' . curl_error($ch) . '</font><br/>';
        }
        curl_close($ch); // 关闭句柄

        unset($url, $parseUrl, $httpHeader, $host_str, $proxy, $referer_url, $cookie, $postData, $ch);
        return array("buffer" => $buffer, "header" => $header);
    }

    /**
     * 截取字符串值
     * @param pstr $string 定位起始位置
     * @param nstr $string 定位结束位置
     * @param objHTML $string 需要查找字符串源
     * @param tag  $string 是否去Html标签 默认为none去标签
     * @return string 返回字符串
     */
    function pet_str($pstr, $nstr, $objHTML, $tag='none') {
        $pstrlen = strlen($pstr);
        $str = strstr($objHTML, $pstr);
        $str = substr($str, $pstrlen);
        if ($tag === 'none')
            $str = trim(strip_tags(substr($str, 0, strpos($str, $nstr))));
        else
            $str = trim((substr($str, 0, strpos($str, $nstr))));

        //check_str_exists($str, array($pstr, $nstr));
        return $str;
    }
}
