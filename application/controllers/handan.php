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

/**
 */
class Handan extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Handan_model', 'hd');
    }

	public function tlist($masterid, $type='day')
	{
		if ((empty($this->_d['userinfo'])) || ($this->_d['userinfo']['level'] == '-1'))
		{
//			show_error('只有登录用户才可以查看');
		}

		if (empty($masterid)) show_error("主题参数丢失");


		$date = date("Y-m-d");  //当前日期
		$first=1; //$first =1 表示每周星期一为开始时间 0表示每周日为开始时间
		$w = date("w", strtotime($date));  //获取当前周的第几天 周日是 0 周一 到周六是 1 -6 
		$d = $w ? $w - $first : 6;  //如果是周日 -6天 
		$now_start = date("Y-m-d", strtotime("$date -".$d." days")); //本周开始时间
		$now_end = date("Y-m-d", strtotime("$now_start +6 days"));  //本周结束时间
		$last_start = date('Y-m-d',strtotime("$now_start - 7 days"));  //上周开始时间
		$last_end = date('Y-m-d',strtotime("$now_start - 1 days"));  //上周结束时间

		$sql = ' where 1 ';
		switch ($type)
		{
			case 'day': 
			{
				$sql .= ' and (opentime >\'' . $date . '\')';
				break;
			}
			case 'curweek' : 
			{
				$sql .= ' and (opentime >\'' . $now_start . '\') and (opentime <\'' . $now_end . '\')';
				break;
			}
			case 'lastweek' :
			{
				$sql .= ' and (opentime >\'' . $last_start . '\') and (opentime <\'' . $last_end . '\')';
				break;
			}

			case 'curmonth' :
			{
				$sql .= ' and (opentime >\'' . date("Y-m-01") . '\')';
				break;
			}

			case 'all' :
			{
				break;
			}
		}


		$this->_p['pagenumb'] = 8;
		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$query = $this->db->query("select count(*) as c from " . $this->hd->tbl . $sql);
			$_c = $query->row_array();
			$this->_p['pagecount'] = $_c['c'];
		}

		$limit2 = ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb'];
		$query = $this->db->query("select * from " . $this->hd->tbl . $sql . " limit " . $limit2  . ',' . $this->_p['pagenumb']);
		$this->_d['page'] = eyPage($this->_p);
		$this->_d['masterid'] = $masterid;
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->_d['list'] = $query->result_array();
		$this->load->view($this->_d['cfg']['tpl'] . "handan/list", $this->_d);
	}
}