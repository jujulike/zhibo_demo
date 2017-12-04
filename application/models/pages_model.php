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
class Pages_model extends MY_Model{
	
	public function __construct() {
		parent::__construct();
		$this->tbl = 'live_pages';
		$this->tbl_key = 'pageid';
		$this->tbl_ext = '';
	}

	/**
	* 返回所有分类的前N条记录，方便首页调用；
	*/

	public function getAllBlock($fields='*', $maxlimit='10')
	{
		$fields = str_replace(',',',A1.', 'A1.'.$fields);
		$sql = "SELECT " . $fields ."
				FROM live_pages AS A1
					INNER JOIN (SELECT A.cateid,A.pageid
								FROM live_pages AS A
									 LEFT JOIN live_pages AS B
									 ON A.cateid = B.cateid
										AND A.pageid <= B.pageid
								GROUP BY A.cateid,A.pageid
								HAVING COUNT(B.pageid) <= " . $maxlimit . "
					) AS B1
				ON A1.cateid = B1.cateid
				   AND A1.pageid = B1.pageid
				Where A1.status=1
				ORDER BY A1.cateid,A1.ctime DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}
