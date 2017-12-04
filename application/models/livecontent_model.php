<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ============================================================================
 * 版权所有 2013-2018 余姚市一洋网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.163.cn;
 * QQ: 57790081
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/


/**
 */
class Livecontent_model extends MY_Model{
	
	public function __construct() {
		parent::__construct();
		$this->tbl = 'live_livecontent';
		$this->tbl_key = 'contentid';
		$this->tbl_ext = '';
		$this->tbl2 = 'live_livecontent_history';
		$this->tbl5 = 'live_chatcontent_history';
		$this->tbl3 = 'live_chatcontent';
		$this->tbl4 = 'live_livemaster';

	}

	public function setLiveHistory($userid)
	{
		$data = $this->L(array('userid'=>$userid));
		$masterid = '';
		foreach ($data as $k => $v)
		{
			$this->db->query("insert into " . $this->tbl2 . " (content, masterid, userid, author, type, actime, ctime)
						values('" . addslashes($v['content']) . "','" . $v['masterid'] . "','" . $v['userid'] . "','" . $v['author'] . "','" . $v['type'] . "','" . $v['ctime'] . "','" . time() . "')");
			$masterid = $v['masterid'];

		}

		$this->db->query("update " . $this->tbl4 . " set status=2 where masterid='" . $masterid . "'");

		$this->D(array('userid'=>$userid));

		$query = $this->db->query("select * from " . $this->tbl3 . " where masterid='" . $masterid . "'");

		if ($query->num_rows() > 0)
		{
		   foreach ($query->result() as $row)
		   {
			   $this->db->query("insert into " . $this->tbl5 . " (masterid, chatcontent, chatname, chatuserid, mtime, ctime)
						values('" . $row->masterid . "','" . addslashes($row->chatcontent) . "','" . $row->chatname . "','" . $row->chatuserid . "','" .  "','" . time() . "')");
		   }
		}

		
		$this->db->query("delete from " . $this->tbl3 . " where masterid='" . $masterid . "'");
	}

	public function getLastid($masterid,$ctype)
	{
		$sql = "select max(contentid) as lastcontentid from " .$this->tbl. " where type=".$ctype." and masterid=" . $masterid;
		$query = $this->db->query($sql);
		return $query->row_array();
	}

}