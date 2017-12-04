<?php

	function getTime($time)
	{
		$now = $_SERVER['REQUEST_TIME'];
		$subtime = $now - $time;
                if($subtime < 0) return "0秒";
		if($subtime < 60 && $subtime >= 0) return $subtime."秒前";
		elseif($subtime < 60*60) return ceil($subtime/60)."分前";
		elseif($subtime < 24*60*60) return ceil($subtime/3600)."小时前";
		elseif($subtime < 24*60*60*3) return ceil($subtime/(24*3600))."天前";
		else return date('Y-m-d H:i', $time);
	}

	function getTimehome($time)
	{
		$now = $_SERVER['REQUEST_TIME'];
		$subtime = $now - $time;
		if($subtime < 60) return $subtime."秒前";
                if($subtime < 60 && $subtime >= 0) return $subtime."秒前";
		elseif($subtime < 60*60) return ceil($subtime/60)."分前";
		elseif($subtime < 24*60*60) return ceil($subtime/3600)."小时前";
		elseif($subtime < 24*60*60*30) return ceil($subtime/(24*3600))."天前";
		elseif($subtime < 24*60*60*30*12) return ceil($subtime/(12*30*24*3600))."月前";
		else return "1年前";
	}

	function getTimeOver($time)
	{
		$now = $_SERVER['REQUEST_TIME'];
		$subtime = $time - $now;
                if($subtime < 0) return "0秒";
		elseif($subtime < 60 && $subtime >= 0) return $subtime."秒";
		elseif($subtime < 60*60) return ceil($subtime/60)."分钟";
		elseif($subtime < 24*60*60) return ceil($subtime/3600)."小时";
		elseif($subtime > 24*60*60) return ceil($subtime/(24*3600))."天";
	}

	/**
		获取随机数

		@param int $length
		@return string $hash
   */
	function getRandom($length=6,$type=0)
	{
		$hash = '';
		$chararr =array(
			'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz',
			'0123456789',
			'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
			'0123456789abcdefghijklmnopqrstuvwxyz'
		);
		$chars=$chararr[$type];
		$max = strlen($chars) - 1;
		PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}

		return $hash;
	}


	//加解密函数
	function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

		$ckey_length = 4;

		$key = md5($key ? $key : API_KEY);	//API_KEY为通讯密钥
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}

	}

	/*
	-----------------------------------------------------------
	函数名称：isNumber
	简要描述：检查输入的是否为数字
	输入：string
	输出：boolean
	修改日志：------
	-----------------------------------------------------------
	*/
	function isNumber($val)
	{
		if (ereg("^[0-9]+$", $val))
			return true;
		return false;
	}
 
	/*
	-----------------------------------------------------------
	函数名称：isPhone
	简要描述：检查输入的是否为电话
	输入：string
	输出：boolean
	修改日志：------
	-----------------------------------------------------------
	*/
	function isPhone($val)
	{
		//eg: xxx-xxxxxxxx-xxx | xxxx-xxxxxxx-xxx ...
		if (preg_match("/(^(86)\-(\d{3,4})\-(\d{7,8})\-(\d{1,4})$)"
."|(^(\d{3,4})\-(\d{7,8})$)"
."|(^(\d{3,4})\-(\d{7,8})\-(\d{1,4})$)"
."|(^(86)\-(\d{3,4})\-(\d{7,8})$)"
."|(^(\d{7,8})$)/",$val))
			return true;
		return false;
	}
 
	/*
	-----------------------------------------------------------
	函数名称：isMobile
	简要描述：检查输入的是否为手机号
	输入：string
	输出：boolean
	修改日志：------
	-----------------------------------------------------------
	*/
	function isMobile($val)
	{
		if (ereg("^[0-9]{11}$",$val))
			return true;
		return false;
	}

	/*
	-----------------------------------------------------------
	函数名称：isPostcode
	简要描述：检查输入的是否为邮编
	输入：string
	输出：boolean
	修改日志：------
	-----------------------------------------------------------
	*/
	function isPostcode($val)
	{
		if (ereg("^[0-9]{4,6}$",$val))
			return true;
		return false;
	}
 
	/*
	-----------------------------------------------------------
	函数名称：isEmail
	简要描述：邮箱地址合法性检查
	输入：string
	输出：boolean
	修改日志：------
	-----------------------------------------------------------
	*/
	function isEmail($val,$domain="")
	{
		if(!$domain)
		{
			if( preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $val) )
			{
				return true;
			}
			else
				return false;
		}
		else
		{
			if( preg_match("/^[a-z0-9-_.]+@".$domain."$/i", $val) )
			{
				return true;
			}
			else
				return false;
		}
	}//end func
 
	/*
	-----------------------------------------------------------
	函数名称：isName
	简要描述：姓名昵称合法性检查，只能输入中文英文
	输入：string
	输出：boolean
	修改日志：------
	-----------------------------------------------------------
	*/
	function isName($val)
	{
		if( preg_match("/^[\x80-\xffa-zA-Z0-9]{3,60}$/", $val) )//2008-7-24
		{
			return true;
		}
		return false;
	}//end func
 
	/*
	-----------------------------------------------------------
	函数名称:isDomain($Domain)
	简要描述:检查一个（英文）域名是否合法
	输入:string 域名
	输出:boolean
	修改日志:------
	-----------------------------------------------------------
	*/
	function isDomain($Domain)
	{
		$Domain = prep_url($Domain);
		$pre = "http://[^\s]*";

		if(eregi($pre, $Domain))
			return true;
		else
			return false;
	}
 
	/*
	-----------------------------------------------------------
	函数名称:isNumberLength($theelement, $min, $max)
	简要描述:检查字符串长度是否符合要求
	输入:mixed (字符串，最小长度，最大长度)
	输出:boolean
	修改日志:------
	-----------------------------------------------------------
	*/
	function isNumLength($val, $min, $max)
	{
		$theelement = trim($val);
		if (ereg("^[0-9]{".$min.",".$max."}$",$val))
			return true;
		return false;
	}
 
	/*
	-----------------------------------------------------------
	函数名称:isNumberLength($theelement, $min, $max)
	简要描述:检查字符串长度是否符合要求
	输入:mixed (字符串，最小长度，最大长度)
	输出:boolean
	修改日志:------
	-----------------------------------------------------------
	*/
	function isEngLength($val, $min, $max)
	{
		$theelement = trim($val);
		if (ereg("^[a-zA-Z]{".$min.",".$max."}$",$val))
			return true;
		return false;
	}
 
	/*
	-----------------------------------------------------------
	函数名称：isEnglish
	简要描述：检查输入是否为英文
	输入：string
	输出：boolean
	作者：------
	修改日志：------
	-----------------------------------------------------------
	*/
	function isEnglish($theelement)
	{
		if( ereg("[\x80-\xff].",$theelement) )
		{
			Return false;
		}
		Return true;
	}
 
	/*
	-----------------------------------------------------------
	函数名称：isChinese
	简要描述：检查是否输入为汉字
	输入：string
	输出：boolean
	修改日志：------
	-----------------------------------------------------------
	*/

	function isChinese($str)
	{
		if(!eregi("[^\x80-\xff]","$str")){
			return true;
		}else{
			return false;
		}
	}
 
	/*
	-----------------------------------------------------------
	函数名称：isDate
	简要描述：检查日期是否符合0000-00-00
	输入：string
	输出：boolean
	修改日志：------
	-----------------------------------------------------------
	*/
	function isDate($sDate)
	{
		if( ereg("^[0-9]{4}\-[][0-9]{2}\-[0-9]{2}$",$sDate) )
		{
			Return true;
		}
		else
		{
			Return false;
		}
	}
	/*
	-----------------------------------------------------------
	函数名称：isTime
	简要描述：检查日期是否符合0000-00-00 00:00:00
	输入：string
	输出：boolean
	修改日志：------
	-----------------------------------------------------------
	*/
	function isTime($sTime)
	{
		if( ereg("^[0-9]{4}\-[][0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$",$sTime) )
		{
			Return true;
		}
		else
		{
			Return false;
		}
	}
 
	/*
	-----------------------------------------------------------
	函数名称:isMoney($val)
	简要描述:检查输入值是否为合法人民币格式
	输入:string
	输出:boolean
	修改日志:------
	-----------------------------------------------------------
	*/
	function isMoney($val)
	{
		if (ereg("^[0-9]{1,}$", $val))
			return true;
		if( ereg("^[0-9]{1,}\.[0-9]{1,2}$", $val) )
			return true;
		return false;
	}
 
	/*
	-----------------------------------------------------------
	函数名称:isIp($val)
	简要描述:检查输入IP是否符合要求
	输入:string
	输出:boolean
	修改日志:------
	-----------------------------------------------------------
	*/
	function isIp($val)
	{
		return (bool) ip2long($val);
	}


	/*
	-----------------------------------------------------------
	* 函数名称:getTimeRange($type, $now, $mktime)
	* 简要描述:根据当前时间得到上周、本周、上月、本月、上季度、本季度的时间范围
	* @param $type => 控制返回的时间段（周、月、季度）//1：周//2：月//3：季度
	* @param $now => 控制返回时间//1：本（周、月、季度）//-1：上一（周、月、季度）
	* @param $mktime => 控制返回时间还是时间戳//1：时间//0：时间戳
	-----------------------------------------------------------
	*/
	function getTimeRange($type = 1, $now = 1, $mktime = 0)
	{
		if($type == 1 && $now == 1) {	//本周
			$start = mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"));
			$end = mktime(23, 59, 59,date("m"),date("d")-date("w")+7,date("Y"));
		} elseif($type ==1 && $now == -1) {	//上周
			$start = mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"));
			$end = mktime(23, 59, 59,date("m"),date("d")-date("w")+7-7,date("Y"));
		} elseif($type == 2 && $now == 1) {	//本月
			$start = mktime(0, 0 , 0,date("m"),1,date("Y"));
			$end = mktime(23, 59, 59,date("m"),date("t"),date("Y"));
		} elseif($type == 2 && $now == -1) {	//上月
			$start = mktime(0, 0 , 0,date("m")-1,1,date("Y"));
			$end = mktime(23, 59, 59,date("m") ,0,date("Y"));
		} elseif($type == 3 && $now == 1) {	//本季度
			$season = ceil((date('n'))/3);//当月是第几季度
			$start = mktime(0, 0, 0,$season*3-3+1,1,date('Y'));
			$end = mktime(23, 59, 59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y'));
		} elseif($type == 3 && $now == -1) {	//上季度
			$season = ceil((date('n'))/3)-1;//上季度是第几季度
			$start = mktime(0, 0, 0,$season*3-3+1,1,date('Y'));
			$end = mktime(23,59,59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y'));
		}

		if($mktime) {	//时间
			$start = date("Y-m-d H:i:s", $start);
			$end = date("Y-m-d H:i:s", $end);
		}
		return array($start, $end);
	}


	/*
	-----------------------------------------------------------
	* 函数名称:getLastTime($type, $mktime)
	* 简要描述:根据当前时间得到本周五、本月底的时间
	* @param $type => 控制返回的时间（周、月）//1：周（周五17:00）//2：月（30/31号17:00）
	* @param $mktime => 控制返回时间还是时间戳//1：时间//0：时间戳
	-----------------------------------------------------------
	*/
	function getLastTime($type = 1, $mktime = 0)
	{
		if($type == 1) {	//本周
			$time = mktime(17, 00, 00,date("m"),date("d")-date("w")+5,date("Y"));
		} elseif($type == 2) {	//本月
			$time = mktime(17, 00, 00,date("m"),date("t"),date("Y"));
		}

		if($mktime) {	//时间
			$time = date("Y-m-d H:i:s", $time);
		}
		return $time;
	}


	/**头像处理
	* @param $filename => 头像地址
	* @param $size => 头像尺寸
	* @param $water => 是否需要有水印的头像
	*/
	function avatar($filename = '', $size = 's', $water = 1)
	{
		$filepath = './upload/';
		if(!empty($filename) && !in_array($filename, array('2', '3', '4', '8'))) {
			$photo = explode('/', $filename);
			$num = count($photo);
			for($i=0; $i<$num-1; $i++) {
				$filepath .= '/'.$photo[$i];
			}
			switch ($size)
			{
			case 'b':
				$filepath .= '/b_'.$photo[$num-1];
				if(!file_exists($filepath)) {
					$filepath = './themes/v1.0/images/avatar/avatar_b.gif';
				}
			  break;
			case 'm':
				if($water) {
					$filepath .= '/m_water_'.$photo[$num-1];
				} else {
					$filepath .= '/m_'.$photo[$num-1];
				}
				if(!file_exists($filepath)) {
					$filepath = './themes/v1.0/images/avatar/avatar_m.gif';
				}
			  break;
			case 's':
				if($water) {
					$filepath .= '/s_water_'.$photo[$num-1];
				} else {
					$filepath .= '/s_'.$photo[$num-1];
				}
				if(!file_exists($filepath)) {
					$filepath = './themes/v1.0/images/avatar/avatar.gif';
				}
			  break;
			case 'micro':
				$filepath .= '/micro_'.$photo[$num-1];
				if(!file_exists($filepath)) {
					$filepath = './themes/v1.0/images/avatar/avatar_s.gif';
				}
			  break;
			}
		} elseif(in_array($filename, array('2', '3', '4', '8', '100'))) {
			switch ($size)
			{
			case 'b':
				$filepath = './themes/v1.0/images/avatar/avatar_b.gif';
				break;
			case 'm':
				if($water) {
					switch ($filename)
					{
						case '2':
							$filepath = './themes/v1.0/images/avatar/avatar_m_2.gif';
							break;
						case '3':
							$filepath = './themes/v1.0/images/avatar/avatar_m_3.gif';
							break;
						case '4':
							$filepath = './themes/v1.0/images/avatar/avatar_m_4.gif';
							break;
						case '8':
							$filepath = './themes/v1.0/images/avatar/avatar_m_8.gif';
							break;
						case '100':
							$filepath = './themes/v1.0/images/avatar/avatar_m_100.gif';
							break;
					}
				} else {
					$filepath = './themes/v1.0/images/avatar/avatar_m.gif';
				}
				break;
			case 's':
				if($water) {
					switch ($filename)
					{
						case '2':
							$filepath = './themes/v1.0/images/avatar/avatar_2.gif';
							break;
						case '3':
							$filepath = './themes/v1.0/images/avatar/avatar_3.gif';
							break;
						case '4':
							$filepath = './themes/v1.0/images/avatar/avatar_4.gif';
							break;
						case '8':
							$filepath = './themes/v1.0/images/avatar/avatar_8.gif';
							break;
						case '100':
							$filepath = './themes/v1.0/images/avatar/avatar_100.gif';
							break;
					}
				} else {
					$filepath = './themes/v1.0/images/avatar/avatar.gif';
				}
				break;
			case 'micro':
				$filepath = './themes/v1.0/images/avatar/avatar_s.gif';
				break;
			}
		} else {
			switch ($size)
			{
			case 'b':
				$filepath = './themes/v1.0/images/avatar/avatar_b.gif';
				break;
			case 'm':
				$filepath = './themes/v1.0/images/avatar/avatar_m.gif';
				break;
			case 's':
				$filepath = './themes/v1.0/images/avatar/avatar.gif';
				break;
			case 'micro':
				$filepath = './themes/v1.0/images/avatar/avatar_s.gif';
				break;
			}
		}
		return str_replace('//', '/', $filepath);
	}