<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Userstatus_model extends MY_Model {

	function __construct()
    {
        parent::__construct();
		$this->tbl		= 'live_user_status';
		$this->tbl_key	= 'userid';
		$this->t_online = 'live_user_online';		
    }

	function getUserOnline($roomid, $offtime)
	{
		if (empty($roomid) || empty($offtime)) return false;

		$f = FCPATH . APPPATH . 'cache/room/' . $roomid ."_useronline";
		if (file_exists($f) && (filemtime($f) + $this->_d['cfg']['status_offline_time']/2) > time())
		{
			$retdata = json_decode(file_get_contents($f, FILE_BINARY, NULL, 0, 11440), true);
		}
		else
		{
			$sql = "select userid, name, role,ltime,level from " . $this->t_online . " where roomid=" . $roomid . " and ltime >= (UNIX_TIMESTAMP()-" . $offtime . ") order by level desc";
			//echo $sql;exit;
			$query = $this->db->query($sql);
			$retdata = $query->result_array();
			file_put_contents($f, json_encode($retdata), LOCK_EX);
		}
//print_r($retdata);exit;
		return $retdata;
	}

	function upUserOnline($roomid, $userinfo, $offtime, $ctime = '')
	{
		if (empty($roomid) || empty($userinfo) || empty($offtime)) return false;

		if($ctime == '') {
			$sql = "REPLACE into " . $this->t_online . "(userid,name,roomid,role,level,ltime) values(" . $userinfo['userid'] . ",'" . $userinfo['name'] . "'," . $roomid . ", " . $userinfo['role'] . "," . $userinfo['level'] . ",UNIX_TIMESTAMP())";
		} else {
			$sql = "REPLACE into " . $this->t_online . "(userid,name,roomid,role,level,ltime) values(" . $userinfo['userid'] . ",'" . $userinfo['name'] . "'," . $roomid . ", " . $userinfo['role'] . "," . $userinfo['level'] . "," . $ctime .  ")";
		}
		$this->db->query($sql);
	
		$res = preg_match('/[0-9]{5}/i', $s, $match);
		if(!$res) {
			$sql = "delete from " . $this->t_online . " where roomid=" . $roomid . " and ltime < (UNIX_TIMESTAMP()-" . $offtime . "-5)";		
		}
		$this->db->query($sql);
	}

	function setStop($roomid, $userid)
	{
		if (empty($roomid) || empty($userid)) return false;
		$f = FCPATH . APPPATH . 'cache/room/' . $roomid ."_userstatus";
		$sql = "REPLACE into " . $this->tbl . "(userid,roomid,vtime, atime) values(" . $userid . ",'" . $roomid . "',UNIX_TIMESTAMP()+" . $this->_d['cfg']['status_saystop_time'] . ",UNIX_TIMESTAMP())";
		$this->db->query($sql);
		$sql = "select userid, status, vtime from " . $this->tbl . " where roomid=" . $roomid; 
		$query = $this->db->query($sql);
		$_retdata = $query->result_array();
		$retdata = cate2array($_retdata, 'userid');
		file_put_contents($f, json_encode($retdata), LOCK_EX);
		return true;
		/*

		$f = FCPATH . APPPATH . 'cache/room/' . date('ymd') . '/' . $roomid . '/stop_' . $userid;
		touch($f, time() + $this->_d['cfg']['status_roomout_time']);
		return true;
		*/

	}

	function setCancelStop($roomid, $userid)
	{
		if (empty($roomid) || empty($userid)) return false;
		$f = FCPATH . APPPATH . 'cache/room/' . $roomid ."_userstatus";
		$this->D(array('roomid'=>$roomid, 'userid'=>$userid));

		$sql = "select userid, status, vtime from " . $this->tbl . " where roomid=" . $roomid; 
		$query = $this->db->query($sql);
		$_retdata = $query->result_array();

		if (count($_retdata) > 0)
		{
			$retdata = cate2array($_retdata, 'userid');
			file_put_contents($f, json_encode($retdata), LOCK_EX);
		}
		else
		{
			@unlink($f);
		}

		return true;
	}
	
	
	function setOut($roomid, $userid)
	{
		if (empty($roomid) || empty($userid)) return false;
		$f = FCPATH . APPPATH . 'cache/room/' . $roomid ."_userstatus";
		$sql = "REPLACE into " . $this->tbl . "(userid,roomid,status,vtime, atime) values(" . $userid . ",'" . $roomid . "',1,UNIX_TIMESTAMP()+" . $this->_d['cfg']['status_roomout_time'] . ",UNIX_TIMESTAMP())";
		$this->db->query($sql);
		$sql = "select userid, status, vtime from " . $this->tbl . " where roomid=" . $roomid; 
		$query = $this->db->query($sql);
		$_retdata = $query->result_array();
		$retdata = cate2array($_retdata, 'userid');
		file_put_contents($f, json_encode($retdata), LOCK_EX);
		return true;		
		/*
		$f = FCPATH . APPPATH . 'cache/room/' . date('ymd') . '/' . $roomid . '/out_' . $userid;
		touch($f, time() + $this->_d['cfg']['status_roomout_time']);
		return true;
		*/
	}

	function getStatus($roomid)
	{
		$f = FCPATH . APPPATH . 'cache/room/' . $roomid ."_userstatus";
		if (file_exists($f) && (filemtime($f) + 30 > time()))
		{
			$retdata = json_decode(file_get_contents($f, FILE_BINARY, NULL, 0, 4096), true);
		}
		else
		{
			$sql = "delete from " . $this->tbl . " where roomid=" . $roomid . " and vtime < UNIX_TIMESTAMP()";
			$this->db->query($sql);
			$sql = "select userid, status, vtime from " . $this->tbl . " where roomid=" . $roomid; 
			$query = $this->db->query($sql);
			$_retdata = $query->result_array();

			if (count($_retdata) > 0)
			{
				$retdata = cate2array($_retdata, 'userid');
				file_put_contents($f, json_encode($retdata), LOCK_EX);
			}
			else
			{
				$retdata = $_retdata;
				@unlink($f);
			}
		}

		return $retdata;
	}
}
?>