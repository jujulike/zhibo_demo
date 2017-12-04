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
class Region_model extends MY_Model{
	
	public function __construct() {
		parent::__construct();
		$this->tbl = 'live_commdata_region';
		$this->tbl_key = 'regionid';
		$this->tbl_ext = '';
	}

	public function getProvince()
	{
		return $this->L(array('regiontype'=>'1'), 'regionid as id, name, parentid', '50');
	}

	public function getCity($provinceid)
	{
		return $this->L(array('regiontype'=>'2', 'parentid'=>$provinceid), 'regionid as id, name, parentid', '50');
	}

	public function getRegion($cityid)
	{
		return $this->L(array('regiontype'=>'3', 'parentid'=>$cityid), 'regionid as id, name, parentid', '50');
	}

}
