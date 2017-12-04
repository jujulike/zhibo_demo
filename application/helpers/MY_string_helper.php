<?php
/**
* 字符串处理类
*/

	/**
	* 截取字符串
	*
	* @access   public
	* @param    $str[string]      待截取的字符串
	* @param    $start[number]    开始截取位置      [default]0
	* @param    $length[number]   截取长度          [default]20
	* @param    $suffix[string]   截取后后缀        [default]NULL
	* @param    $charset[string]  字符串编码        [default]utf8
	* @return   string
	*/

if ( ! function_exists('long2short'))
{
	function long2short($str, $start=0, $length=20, $suffix='', $charset="utf8"){
	    if ( '' == $str || is_null($str) || is_bool($str) )
	        return $str;
	    if ( function_exists("mb_substr") ){
	        $str  = (mb_strlen($str) > $length)
	              ? mb_substr($str, $start, $length, $charset) . $suffix
	              : $str;
	        unset($start, $length, $suffix, $charset, $re, $match);
	        return $str;
	    }
	    if ( function_exists('iconv_substr') ) {
	        $str  = (iconv_strlen($str,$charset) > $length)
	              ? iconv_substr($str, $start, $length, $charset) . $suffix
	              : $str;
	        unset($start, $length, $suffix, $charset, $re, $match);
	        return $str;
	    }
	    $re['utf8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	    @preg_match_all($re[$charset], $str, $match);
	    $slice = implode('', array_slice($match[0], $start, $length)) . $suffix;
	    unset($str, $start, $length, $suffix, $charset, $re, $match);
	    return $slice;
	}
}

	/**
		截取简介，处理掉所有附加代码；
	*/
if ( ! function_exists('html2text'))
{

	function html2text($str)
	{
		$str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
		$alltext = "";
		$start = 1;
		for ($i = 0; $i < strlen($str); $i++)
		{
			if($start == 0 && $str[$i] == ">") $start = 1;
			elseif($start == 1)
			{
				if($str[$i] == "<")
				{
					$start = 0;
					$alltext .= " "; 
				}
				elseif(ord($str[$i]) > 31) $alltext .= $str[$i];
			}
		}
		$alltext = str_replace("　", " ", $alltext);
		$alltext = preg_replace("/&([^;&]*)(;|&)/", "", $alltext);
		$alltext = preg_replace("/[ ]+/s", " ", $alltext);
		return $alltext;
	}
}

if ( ! function_exists('str2entity'))
{
	function str2entity($string)
	{
//		return 	htmlentities($string, ENT_QUOTES, "utf-8"); 
		return htmlspecialchars($string);
	}
}
	
if ( ! function_exists('array2option'))
{
	function array2option($arraydata, $selectid = '', $format = '')
	{
		if (!is_array($arraydata)) return $arraydata;

		$retstr = '';
		foreach ($arraydata as $k => $v)
		{
			$select = '';
			if (($selectid != '') && ($selectid == $v['id'])) $select = " selected ";
			if ($format != '') $v['name'] = str_repeat('&nbsp;', $v['level'] * 4) . $v['name'] ;
			$retstr .= "<option value='" . $v['id'] . "'" . $select . ">" . $v['name'] . "</option>";
		}

		return $retstr;
	}
}


if ( ! function_exists('array2checkbox'))
{
	function array2checkbox($name, $arraydata, $checkary = array(0), $format = 0)
	{
		if ($name == '') return false;

		if (!is_array($arraydata)) return $arraydata;

		$retstr = $br = '';
		foreach ($arraydata as $k => $v)
		{
			
			if (@in_array($v['id'], $checkary)) $check = " checked "; else $check = '';
			if ($format != 0) if (($k + 1) % $format == 0) $br = "<br/>"; else $br = '';			
			$retstr = $retstr . "<label><INPUT TYPE='checkbox' name='" . $name . "[]' value='" . $v['id'] . "'" . $check . ">  " . $v['name'] . "</label>  " . $br;
		}

		return $retstr;
	}
}

if ( ! function_exists('array2radio'))
{
	function array2radio($name, $arraydata, $checkid = '')
	{
		if ($name == '') return false;

		if (!is_array($arraydata)) return $arraydata;

		$retstr = '';
		foreach ($arraydata as $k => $v)
		{
			
			if (($checkid != '') && ($checkid == $v['id'])) $check = " checked "; else $check = '';
			$retstr = $retstr . "<label><INPUT TYPE='radio' name='" . $name . "' value='" . $v['id'] . "'" . $check . ">" . $v['name'] . "</label>&nbsp;&nbsp;&nbsp;";
		}

		return $retstr;
	}
}



if ( ! function_exists('cate2array'))
{
	function cate2array($arraydata, $key='id')
	{
		if (!is_array($arraydata)) return $arraydata;

		$retstr = '';
		foreach ($arraydata as $k => $v)
		{
			$retstr[$v[$key]] = $v;
		}

		return $retstr;
	}
}

if ( ! function_exists('cate2arraydata'))
{
	function cate2arraydata($arraydata, $key='id')
	{
		if (!is_array($arraydata)) return $arraydata;

		$retstr = '';
		foreach ($arraydata as $k => $v)
		{
			$retstr[$v[$key]][] = $v;
		}

		return $retstr;
	}
}


if ( ! function_exists('array2group'))
{
	function array2group($arraydata, $key)
	{
		if (empty($key)) return false;

		if (!is_array($arraydata)) return $arraydata;

		$retary = array();

		foreach ($arraydata as $k => $v)
		{
			if (empty($retary[$v[$key]]))
			{
				$retary[$v[$key]][] = $v;
			}
			else
			{
				array_push($retary[$v[$key]], $v);
			}

		}

		return $retary;
	}
}

/**
 * 过滤和排序所有分类，返回一个带有缩进级别的数组
 *
 * @access  private
 * @param   int     $cat_id     上级分类ID
 * @param   array   $arr        含有所有分类的数组
 * @param   int     $level      级别
 * @return  void
 */

if ( ! function_exists('cate2list'))
{

	function cate2list($spec_cat_id, $arr)
	{
		static $cat_options = array();

		if (isset($cat_options[$spec_cat_id]))
		{
			return $cat_options[$spec_cat_id];
		}

		if (!isset($cat_options[0]))
		{
			$level = $last_cat_id = 0;
			$options = $cat_id_array = $level_array = array();
			
				while (!empty($arr))
				{
	
					foreach ($arr AS $key => $value)
					{
						$cat_id = $value['cateid'];
						if ($level == 0 && $last_cat_id == 0)
						{
							if ($value['parentid'] > 0)
							{
								break;
							}

							$options[$cat_id]          = $value;
							$options[$cat_id]['level'] = $level;
							$options[$cat_id]['id']    = $cat_id;
							$options[$cat_id]['name']  = $value['catename'];
							unset($arr[$key]);

							if ($value['children'] == 0)
							{
								continue;
							}
							$last_cat_id  = $cat_id;
							$cat_id_array = array($cat_id);
							$level_array[$last_cat_id] = ++$level;
							continue;
						}

						if ($value['parentid'] == $last_cat_id)
						{
							$options[$cat_id]          = $value;
							$options[$cat_id]['level'] = $level;
							$options[$cat_id]['id']    = $cat_id;
							$options[$cat_id]['name']  = $value['catename'];
							unset($arr[$key]);

							if ($value['children'] > 0)
							{
								if (end($cat_id_array) != $last_cat_id)
								{
									$cat_id_array[] = $last_cat_id;
								}
								$last_cat_id    = $cat_id;
								$cat_id_array[] = $cat_id;
								$level_array[$last_cat_id] = ++$level;
							}
						}
						elseif ($value['parentid'] > $last_cat_id)
						{
							break;
						}
					}

					$count = count($cat_id_array);
					if ($count > 1)
					{
						$last_cat_id = array_pop($cat_id_array);
					}
					elseif ($count == 1)
					{
						if ($last_cat_id != end($cat_id_array))
						{
							$last_cat_id = end($cat_id_array);
						}
						else
						{
							$level = 0;
							$last_cat_id = 0;
							$cat_id_array = array();
							continue;
						}
					}

					if ($last_cat_id && isset($level_array[$last_cat_id]))
					{
						$level = $level_array[$last_cat_id];
					}
					else
					{
						$level = 0;
					}
				}

			$cat_options[0] = $options;
		}
		else
		{
			$options = $cat_options[0];
		}

		if (!$spec_cat_id)
		{
			return $options;
		}
		else
		{
			if (empty($options[$spec_cat_id]))
			{
				return array();
			}

			$spec_cat_id_level = $options[$spec_cat_id]['level'];

			foreach ($options AS $key => $value)
			{
				if ($key != $spec_cat_id)
				{
					unset($options[$key]);
				}
				else
				{
					break;
				}
			}

			$spec_cat_id_array = array();
			foreach ($options AS $key => $value)
			{
				if (($spec_cat_id_level == $value['level'] && $value['cateid'] != $spec_cat_id) ||
					($spec_cat_id_level > $value['level']))
				{
					break;
				}
				else
				{
					$spec_cat_id_array[$key] = $value;
				}
			}
			$cat_options[$spec_cat_id] = $spec_cat_id_array;

			return $spec_cat_id_array;
		}
	}
}


/**
* 加密规则
* 
* @param string $passwd 欲加密密码
* @param string $type 加密类别，默认为md5
*/
if ( ! function_exists('setEncry'))
{
	function setEncry($passwd, $type = 'md5')
	{
		if (($type == '') || ($type == 'md5'))
		{
			return md5($passwd);
		}
	}
}


if ( ! function_exists('getPhoto'))
{
	function getPhoto($photoPath,$width = 80,$height = 80,$type = false){
		if(!empty($photoPath)){
			if (substr($photoPath, 0, 7) == 'http://') return $photoPath;
			$fileInfo = pathinfo($photoPath);
			$img = $fileInfo['dirname'].'/'.'pic_'.$width.'_'.$height.'/'.$fileInfo['basename'];
			if(!file_exists($img)){
				$img = getDefaultPhoto($width, $height, $type);
			}	
		}else{
			$img = getDefaultPhoto($width, $height, $type);
		}
		return base_url($img);
	}
}

/**
 * 获取默认图片
 * @param int $width
 * @param int $height 
 * @param string $type 头像类型
 */
if ( ! function_exists('getDefaultPhoto'))
{
	function getDefaultPhoto($width,$height,$type = false){
		if($type){
			$img = $type.'_'.$width.'_'.$height.'.jpg';
		}else{
			$img = 'default_'.$width.'_'.$height.'.gif';
		}
		return 'themes/images/avatar/'.$img;
	}
}


/**
* AJAX翻页程序
* 
*/

if ( ! function_exists('eyPage'))
{
	function eyPage($paramdata, $search=array()){
		$paramdata['pagenumb']	= $paramdata['pagenumb']?$paramdata['pagenumb']:20;
		$paramdata['pagecur']	= $paramdata['pagecur']?$paramdata['pagecur']:1;
		$paramdata['numlinks']	= isset($paramdata['numlinks'])&&$paramdata['numlinks']>0?$paramdata['numlinks']:5;
	
		if (empty($paramdata['first_page']))	$paramdata['first_page'] = '第一页';
		if (empty($paramdata['pre_page']))		$paramdata['pre_page'] = '<<';
		if (empty($paramdata['next_page']))		$paramdata['next_page'] = '>>';
		if (empty($paramdata['last_page']))		$paramdata['last_page'] = '末页';

		$pagestr = '';
		$totalpage = ceil($paramdata['pagecount']/$paramdata['pagenumb']);
		if($totalpage<2)
		{
			return $pagestr;
		}
		if($paramdata['pagecur'] > $paramdata['numlinks'])
		{
			$pagestr .= '<a href="javascript:gopage(1,' . $paramdata['pagecount'] . ')">'.$paramdata['first_page'].'</a>';
		}
		if($paramdata['pagecur'] > 1)
		{
			$pagestr .= '<a href="javascript:gopage('.($paramdata['pagecur']-1).',' . $paramdata['pagecount'] . ')"  class="up">'.$paramdata['pre_page'].'</a>';
		}
		$prestart = $paramdata['pagecur'] - $paramdata['numlinks'];
		$start = $prestart > 1 ? $prestart : 1;
		$end = $paramdata['pagecur'] + $paramdata['numlinks'];
		$end = $end > $totalpage ? $totalpage : $end;
		for($i = $start; $i < $paramdata['pagecur']; $i++)
		{
			$pagestr .= '<a href="javascript:gopage('.$i.',' . $paramdata['pagecount'] . ')">'.$i.'</a>';
		}
		$pagestr .= '<span class="current">' . $i . '</span>';
		for($i = $paramdata['pagecur']; $i < $end; $i++)
		{
			$pagestr .= '<a href="javascript:gopage('.($i+1).',' . $paramdata['pagecount'] . ')">'.($i+1).'</a>';
		}
		if($paramdata['pagecur']<$totalpage){
			$pagestr .= '<a href="javascript:gopage('.($paramdata['pagecur']+1).',' . $paramdata['pagecount'] . ')"  class="next">'.$paramdata['next_page'].'</a>';
		}
		if($end<$totalpage){
			$pagestr .= '<a href="javascript:gopage('.$totalpage.',' . $paramdata['pagecount'] . ')">'.$paramdata['last_page'].'</a>';
		}
		$pagestr .= '<form name="formpage" id="formpage" action="" method="post">';
		$pagestr .= '<input type="hidden" name="pagecur" id="pagecur" value="'.$paramdata['pagecur'].'">';
		$pagestr .= '<input type="hidden" name="pagecount" id="pagecount" value="'.$paramdata['pagecount'].'">';
		foreach($search as $key => $item){
			$pagestr .= '<input type="hidden" name="'.$key.'" value="'.$item.'">';
		}
		$pagestr .= '</form>';
		return $pagestr;
	}
}


/**
* 加密规则
* 
* @param string $passwd 欲加密密码
* @param string $type 加密类别，默认为md5
*/
if ( ! function_exists('setEncry'))
{
	function setEncry($passwd, $type = 'md5')
	{
		if (($type == '') || ($type == 'md5'))
		{
			return md5($passwd);
		}
	}
}

if ( ! function_exists('str2code'))
{
	function str2code($code, $seed = 'eyoung') { 
		$code = strtoupper($code); 
		$clen = strlen($code); 
		$hash = strtoupper(md5($seed)); 
		$hlen = strlen($hash); 
		$return = ''; 
		for ($i = 0; $i < $clen; $i ++) { 
			$j = intval(fmod($i, $hlen)); 
			$s = ord($code{$i}) + ord($hash{$j}); 
			$s = strtoupper(dechex($s)); 
			$return .= $s; 
		} 
		return $return; 
	} 
}

if ( ! function_exists('code2str'))
{
	function code2str($code, $seed = 'eyoung') { 
		$code = strtoupper($code); 
		$clen = strlen($code); 
		if (($clen % 2) != 0) { 
			return false; 
		} 
		
		$hash = strtoupper(md5($seed)); 
		$hlen = strlen($hash); 
	 
		$unit = array(); 
		for ($i = 0; $i < $clen; $i += 2) { 
			$unit[] = $code{$i} . $code{$i + 1}; 
		} 
		$size = count($unit); 
	 
		$return = ''; 
		for ($i = 0; $i < $size; $i ++ ) { 
			$j = intval(fmod($i, $hlen)); 
			$s = intval(hexdec($unit[$i])) - ord($hash{$j}); 
			$return .= chr($s); 
		} 
		return strtolower($return); 
	}  
}


// 处理微博文本加链接的转换
if ( ! function_exists('wbaddurl'))
{
	function wbaddurl($text, $url = 'http://weibo.com/n') { 
		if (empty($text)) return false;
		$a = array(
			'/http:\/\/(.*?) /',
			'/@(.+?)([\s|:]|$)/is'
		);
		$b = array(
			'<a href="http://$1" target="_blank">$1</a>',
			'<a href="' . $url .'/$1" target="_blank">@$1</a>'
		);

		return preg_replace($a, $b, $text);
	}
}


// 构造post
if (!function_exists('eyOpen'))
{
		function eyOpen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE	, $ip = '', $timeout = 15, $block = TRUE, $encodetype  = 'URLENCODE') {
		//error_log("[uc_client]\r\nurl: $url\r\npost: $post\r\n\r\n", 3, 'c:/log/php_fopen.txt');
		$return = '';
		$matches = parse_url($url);
		//print_r($matches);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].(!empty($matches['query']) ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;

		if($post) {
			$out = "POST $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			//$out .= "Referer: $boardurl\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$boundary = $encodetype == 'URLENCODE' ? '' : ';'.substr($post, 0, trim(strpos($post, "\n")));
			$out .= $encodetype == 'URLENCODE' ? "Content-Type: application/x-www-form-urlencoded\r\n" : "Content-Type: multipart/form-data$boundary\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= 'Content-Length: '.strlen($post)."\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cache-Control: no-cache\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
			$out .= $post;
		} else {
			$out = "GET $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			//$out .= "Referer: $boardurl\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}

		if(function_exists('fsockopen')) {
			$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		} elseif (function_exists('pfsockopen')) {
			$fp = @pfsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		} else {
			$fp = false;
		}

		if(!$fp) {
			return '';
		} else {
			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			@fwrite($fp, $out);
			$status = stream_get_meta_data($fp);
			if(!$status['timed_out']) {
				while (!feof($fp)) {
					if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
						break;
					}
				}

				$stop = false;
				while(!feof($fp) && !$stop) {
					$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
					$return .= $data;
					if($limit) {
						$limit -= strlen($data);
						$stop = $limit <= 0;
					}
				}
			}
			@fclose($fp);
			return $return;
		}
	}
}


// 中文截取
if (!function_exists('cut_str'))
{
	function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
	{
		if($code == 'UTF-8')
		{
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);

			if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
			return join('', array_slice($t_string[0], $start, $sublen));
		}
		else
		{
			$start = $start*2;
			$sublen = $sublen*2;
			$strlen = strlen($string);
			$tmpstr = '';

			for($i=0; $i< $strlen; $i++)
			{
				if($i>=$start && $i< ($start+$sublen))
				{
					if(ord(substr($string, $i, 1))>129)
					{
						$tmpstr.= substr($string, $i, 2);
					}
					else
					{
						$tmpstr.= substr($string, $i, 1);
					}
				}
				if(ord(substr($string, $i, 1))>129) $i++;
			}
			//if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
			return $tmpstr;
		}
	}
}


if (!function_exists('CheckPriv'))
{
	function CheckPriv($adminfo, $priv_str)
	{
		/*
		if (@getenv('SERVER_ADDR') != '42.120.21.219')
		{
			exit('未授权系统');
		}
		*/

		if ($adminfo['action_list'] == 'all')
		{
			return true;
		}
		if (strpos($adminfo['action'], $priv_str) === false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}

?>