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

class Update extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->db->db_debug = 0;			
	}

	// 升级推荐人注册
	public function RegCommend()
	{
		$sql = "select count(*) as c from live_system_config where confkey='open_recommend' limit 1";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if ($row['c'] == '0')
		{
			$data = array(
               'confkey' => 'open_recommend' ,
               'confval' => '0' ,
               'confnote' => '开启推荐人注册',
               'fieldtype' => 'radio',
               'status' => '1',
               'cfgcate' => '2'
            );

			if ($this->db->insert('live_system_config', $data))
			{
				echo "配置表更新成功！.............ok<br/>";
			}
		}
		else
		{
				echo "配置表已有过更新！<br/>";
		}

		
		$sql = "ALTER TABLE live_userinfo_base  ADD COLUMN recommid int(11) COMMENT '推荐人ID';";
		if ($this->db->query($sql))
		{
			echo "用户表字段更新成功！..............ok<br/>";
		}else
		{
			echo "用户表字段已存在！<br/>";			
		}

		echo "升级推荐人注册功能的表结构升级完成！...............ok<br/>";
		echo "请到后台管理-》全局配置处设置相关参数!.........OVER!";

	}
}

