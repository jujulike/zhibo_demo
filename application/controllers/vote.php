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
class Vote extends MY_Controller {

	public function __construct() {
        parent::__construct();

		$this->load->model('Vote_model','v');	
    }

	public function index()
	{
		if ($this->input->post())
		{
			if ($this->_d['cfg']['open_vote'] != '1')
			{
				echo json_encode(array('code'=>'0','msg'=>'未开启投票功能!'));
				exit;
			}
			
			if ($this->_d['cfg']['visitor_vote'] == '0')
			{
				if (!empty($this->_d['userinfo']['role']) && ($this->_d['userinfo']['role'] < 0))
				{
					echo json_encode(array('code'=>'0','msg'=>'请先登录再操作!'));
					exit;
				}
			}

			$pdata['ip'] = ip2long($this->input->ip_address());
			$pdata['userid'] = $this->_d['userinfo']['userid'];
			$pdata['vote_id'] = $this->input->post('vote_id');
			$pdata['votedate'] = date("Y-m-d");
			$_c = $this->v->C($pdata);
			if ($_c == '0')
			{
				$pdata['votetype'] = $this->input->post('vote');
				$pdata['vote_id'] = $this->input->post('vote_id');
				if ($this->v->A($pdata))
				{
						$_vdata = $this->v->getRate('' , $pdata['vote_id']);
						$data = array();
						$data[0]['c'] = $data[0]['v'] = 0;
						$data[1]['c'] = $data[1]['v'] = 0;
						$data[2]['c'] = $data[2]['v'] = 0;

						if (!empty($_vdata))
						{
							$data = cate2array($_vdata, 'votetype');
							$sumtotal = 0;
							foreach ($data as $k => $v) $sumtotal +=  $v['c'];
							
							if (empty($data[0]['c'])) $data[0]['c'] = 0;
							if (empty($data[1]['c'])) $data[1]['c'] = 0;
							if (empty($data[2]['c'])) $data[2]['c'] = 0;
							
							$data[0]['v'] = round($data[0]['c']/$sumtotal, 1)*100;
							$data[1]['v'] = round($data[1]['c']/$sumtotal, 1)*100;
							$data[2]['v'] = round($data[2]['c']/$sumtotal, 1)*100;
						}

					echo json_encode(array('code'=>'1','msg'=>'投票成功!','kz'=>$data[2]['v'].'%','pz'=>$data[1]['v'].'%','kk'=>$data[0]['v'].'%'));
					exit;
				}
			}

			echo json_encode(array('code'=>'0','msg'=>'您今天已经投过票了!'));
			exit;
		}
	}

	public function jsvote($act){
		$this->load->model('Jsvote_model', 'jv');
		if('index'==$act){
			$sql = "SELECT u.name,u.userid,COUNT(*) as cc FROM `live_userinfo_base`as u , `live_jsvote` as v WHERE u.`level` = 4 AND u.`ismaster` = 26 AND v.`votedate` <= '".date('Y-m-d', strtotime(date('Y-m-01')." +1 month -1 day"))."'AND v.`votedate` >= '".date('Y-m-01')."' AND u.userid = v.vote_user GROUP BY v.vote_user ORDER BY cc desc";

			$sql1 = "SELECT *,COUNT(*) as cc FROM `live_jsvote` as v WHERE v.`votedate` <= '".date('Y-m-d', strtotime(date('Y-m-01')." +1 month -1 day"))."'AND v.`votedate` >= '".date('Y-m-01')."' GROUP BY v.vote_user ORDER BY cc desc";
			$sql2 = "SELECT u.name,u.userid FROM `live_userinfo_base`as u WHERE u.`level` = 4 AND u.`ismaster` = 26";

			$this->_d['sum'] = 0;
			$jsvote = $this->jv->db->query($sql1);
			$jsvote = $jsvote->result_array();
			$user = $this->jv->db->query($sql2);
			$user = $user->result_array();
			foreach ($jsvote as $k => $v) {
				$tmp=array();
				$find = false;
				foreach ($user as $kf=>$f) {
					if($f['userid']==$v['vote_user']){
						$user[$kf]['a']=true;
						$find=$kf; break;
					}
				}
				if($find===false)
					continue;
				$tmp['userid']=$v['vote_user'];
				$tmp['name']=$user[$find]['name'];

				$query=$this->jv->db->query("SELECT COUNT(*) as cc FROM `live_jsvote` WHERE `votedate` = '".date('Y-m-d')."' AND `vote_user` = ".$v['vote_user']);
				$cc=$query->result_array();
				$tmp['day']=$cc[0]['cc'];
				$tmp['cc']=$v['cc'];
				$this->_d['sum'] += $v['cc'];

				$pdata['ip'] = ip2long($this->input->ip_address());
				$pdata['userid'] = $this->_d['userinfo']['userid'];
				$pdata['vote_user'] = $v['vote_user'];
				$pdata['votedate'] = date("Y-m-d");
				$_c = $this->jv->C($pdata);
				$tmp['daypost']=0;
				if ($_c != '0'){
					$tmp['daypost']=1;
				}

				$votejss[]=$tmp;
			}
			foreach ($user as  $v) {
				$tmp=array();
				if(!isset($v['a'])){
					$tmp['userid']=$v['userid'];
					$tmp['name']=$v['name'];
					$tmp['cc']=0;
					$tmp['day']=0;
					$tmp['daypost']=0;
					$votejss[]=$tmp;
				}
			}
			$this->load->model("Advertisement_model","ad");
			$adlist = $this->ad->getChannelAds('room');
			$this->_d['adlist'] = $adlist;
			$this->_d['votejss']=$votejss;
			$this->load->view("themes/vote/jsvote", $this->_d);	
		}elseif ('post' == $act) {
			if ($this->input->post()){
				$pdata['ip'] = ip2long($this->input->ip_address());
				$pdata['userid'] = $this->_d['userinfo']['userid'];
				$pdata['vote_user'] = $this->input->post('vote_user');
				if($pdata['vote_user']==0)
					exit;
				$pdata['votedate'] = date("Y-m-d");

				if ($this->jv->A($pdata)){
					echo json_encode(array('status'=>'1'));
					exit;
				}
				echo json_encode(array('status'=>'2','msg'=>'投票失败'));
				exit;
			}
		}
	}


	public function result($date = '')
	{
		if ($date =='') $date = date("Y-m-d");
		$_data = $this->v->getRate($date);
		if (empty($_data)) show_error('当前还没有人参与投票');

		$data = cate2array($_data, 'votetype');
		$sumtotal = 0;
		foreach ($data as $k => $v) $sumtotal +=  $v['c'];
		
		if (empty($data[0]['c'])) $data[0]['c'] = 0;
		if (empty($data[1]['c'])) $data[1]['c'] = 0;
		if (empty($data[2]['c'])) $data[2]['c'] = 0;

		$this->_d['votedata'][0]['name'] = $data[0]['c'] . '人选择看空';
		$this->_d['votedata'][0]['v'] = round($data[0]['c']/$sumtotal, 1);
		$this->_d['votedata'][1]['name'] = $data[1]['c'] . '人选择震荡';
		$this->_d['votedata'][1]['v'] = round($data[1]['c']/$sumtotal, 1);
		$this->_d['votedata'][2]['name'] = $data[2]['c'] . '人选择看多';
		$this->_d['votedata'][2]['v'] = round($data[2]['c']/$sumtotal, 1);
		$this->load->view($this->_d['cfg']['tpl'] . "vote/result", $this->_d);		
	}

}