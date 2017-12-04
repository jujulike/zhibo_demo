<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');
class Verify {
	static $title;
	function __construct() {
		return;

		$this -> title = '未授权用户！';
		$f = FCPATH . APPPATH . 'controllers/admin/verify';
		if (!file_exists($f)) {
			$this -> out();
		}
		if (strpos($_SERVER["REQUEST_URI"], 'admin') !== false) {
			$_c = file_get_contents($f, FILE_BINARY, null, 0, 1024);
			$_urlinfo = $this -> getHeaders();
			if ($_c != '') {
				if ($_urlinfo['Host'] != $this -> code2str($_c)) {
					$this -> out();
				}
			} else {
				if (($_urlinfo['Host'] != '127.0.0.1') && ($_urlinfo['Host'] != 'localhost')) $this -> out();
			}
		}
	}
	function out() {
		header("Content-Type:text/html;charset=utf-8");
		exit($this -> title);
	}
	function str2code($code, $seed = 'verify') {
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
	function code2str($code, $seed = 'verify') {
		$code = strtoupper($code);
		$clen = strlen($code);
		if (($clen % 2 ) != 0) {
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
		for ($i = 0; $i < $size; $i ++) {
			$j = intval(fmod($i, $hlen));
			$s = intval(hexdec($unit[$i])) - ord($hash{$j});
			$return .= chr($s);
		}
		return strtolower($return);
	}
	function getHeaders() {
		foreach ($_SERVER as $name => $value) {
			if (substr($name, 0, 5) == 'HTTP_') {
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
}
