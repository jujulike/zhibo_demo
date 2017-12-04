<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 信息基本模型
*
*/

class MY_model extends CI_Model {

	public $tbl = '';
	public $tbl_key = '';
	public $tbl_ext = '';


	function __construct()
    {
        parent::__construct();
    }
    
	function TN()
	{
		return $this->tbl;
	}

	/**
	* 撮合数据表数据
	*
	* @param string $table 要操作的表名
	* @param array $data 要写入的数组
	*/

	private function g($table, $data = array())
	{
		$rs = $this->db->list_fields($table);

		if (count($data))
		{
			$retrs = array();		
			foreach ($rs as $field => $v) if(isset($data[$v])) $retrs[$v] = $data[$v];
			return $retrs;
		}
		else
		{
			return $rs;	
		}
	}

	function INIT()
	{
		$retary = array();
		$t = $this->g($this->tbl);
		foreach ($t as $k => $v) $retary[$v] = '';
		return $retary;
	}

    function A($data, $primary_field = '')
    {
		if (empty($primary_field)) $primary_field = $this->tbl_key;
		$validata = $this->g($this->tbl, $data);
		$this->db->insert($this->tbl, $validata); 
		if ($this->db->affected_rows() == 1)
		{
			if ($this->tbl_ext != '')
			{
				$data[$primary_field] = $this->db->insert_id(); 
				$validata2 = $this->g($this->tbl_ext, $data);
				$this->db->insert($this->tbl_ext, $validata2);
			}
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
    }


	/**
	* 更新信息表
	*
	* @param array $data 需要更新的属性数组
	* @param string $cdata 条件数组
	*/

    function M($data, $cdata)
    {
		if (!is_array($cdata)) return false;
		$validata = $this->g($this->tbl, $data);
		foreach ($cdata as $k => $v)
			{
				if ($v === '')
						$this->db->where($this->tbl . "." . $k);
					else
						$this->db->where($this->tbl . "." . $k, $v);
					}
		return $this->db->update($this->tbl, $validata);
    }

	/**
	* 删除
	*
	* @param array $sdata 删除数组条件
	* @param string $userid_field 数据表-关键字段名
	*/

	function D($sdata)
	{
		if (empty($sdata)) return false;
		if (is_array($sdata))
			foreach ($sdata as $k => $v)
				if ($v === '')
					$this->db->where($this->tbl . "." . $k);
				else
					$this->db->where($this->tbl . "." . $k, $v);
		$this->db->delete($this->tbl);

//		$tables = array($this->tbl_ext, $this->tbl);
//		$this->db->where($userid_field, $userid);
//		$this->db->delete($tables);
	}

	/**
	 * 列表
	 * @param int $offset 偏移量
	 * @param int $limit 显示条数
	 */

	public function L($searchdata=array(), $selectField = "*",  $limit = 15, $offset = 0, $sort_field = '', $asc = 'asc', $relation = '')
	{
		if (empty($sort_field)) $sort_field = $this->tbl . "." . $this->tbl_key;
		if (empty($relation)) $relation = $this->tbl_key;
		$this->db->select($selectField);
		//$this->db->from($this->tbl);
		if ($this->tbl_ext != '')
		$this->db->join($this->tbl_ext, $this->tbl . ".{$relation}=" . $this->tbl_ext . ".{$relation}", 'left');
		if (is_array($searchdata))
			foreach ($searchdata as $k => $v)
				if ($v === '')
					$this->db->where($this->tbl . "." . $k,'',false);
				else if ($v ===false)
					$this->db->where($k,'',false);
				else
					$this->db->where($this->tbl . "." . $k, $v);
		$this->db->order_by($sort_field, $asc);
		if ($limit == 0)
			$query = $this->db->get($this->tbl);
		else
			$query = $this->db->get($this->tbl, $limit, $offset);
		return  $query->result_array();
	}


	/**
	* 获取单条信息
	*
	* @param string $masterid ID
	* @param string $relation 数据表-ID字段名
	*/

	public function O($searchdata, $selectField = '*', $sort_field = '', $asc = 'desc', $relation = '')
	{
		if (empty($sort_field)) $sort_field = $this->tbl . "." . $this->tbl_key;
		if (empty($relation)) $relation = $this->tbl_key;

		$this->db->select($selectField);
		$this->db->from($this->tbl);
		if ($this->tbl_ext != '')
		$this->db->join($this->tbl_ext, $this->tbl . ".{$relation}=" . $this->tbl_ext . ".{$relation}", 'left');
		if (is_array($searchdata))
			foreach ($searchdata as $k => $v)
				if (($v ===false) || ($v === ''))
					$this->db->where($this->tbl . "." . $k);
				else
					$this->db->where($this->tbl . "." . $k, $v);
		$this->db->order_by($sort_field, $asc);
		$this->db->limit(1);
        $query = $this->db->get();
		return $query->row_array(); 
	}
	
	/**
	* 统计总数
	* @param string $searchdata 要检索的条件数组字符串
	*/

	public function C($searchdata=array()){
		$this->db->from($this->tbl);
		if (is_array($searchdata))
			foreach ($searchdata as $k => $v)
				if (($v ===false) || ($v === ''))
					$this->db->where($this->tbl . "." . $k);
				else
					$this->db->where($this->tbl . "." . $k, $v);
		return $this->db->count_all_results();
	}
}
?>