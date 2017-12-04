<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ============================================================================
 * ��Ȩ���� 2013-2018 ��Ҧ��һ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.163.com;
 * QQ: 57790081
 * ----------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�
 * ʹ�ã�������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ============================================================================
*/

/**
*/

class Livemaster extends MY_Controller{

	public function __construct() {
		parent::__construct();
		$this->load->model('Livemaster_model','l');		
		$this->load->model('Live_model','room');		
		$this->load->model('Category_model','cate');		
		$this->load->library('form_validation');
		if ($this->isAdmin() == false) redirect("admin/login"); 
	}
	
	public function index()
	{
		$this->tlist();
	}

	public function tlist()
	{
		if (!$this->admin_priv('live_master'))
		{
			show_error("��û��Ȩ�޽��д˲�����");
		}

		$sdata = array();
		$sdata['status'] = '1';
		$catename = $this->room->L($sdata, 'roomid,roomname,cateid');
		foreach ($catename as $k => $v) 
			$room[$v['roomid']] = $v['roomname'];

		$list = $this->l->L(array(), '*', $this->_p['pagenumb'], ($this->_p['pagecur'] == 0) ? 0 : ($this->_p['pagecur']-1) * $this->_p['pagenumb']);
		foreach ($list as $k => $v)
		{
			if (!empty($room[$v['roomid']]))
				$list[$k]['roomname'] = $room[$v['roomid']];
			else
				$list[$k]['roomname'] = '';
		}

		$this->_p['pagecount'] = $this->input->post('pagecount');
		if (empty($this->_p['pagecount'])) 
		{
			$this->_p['pagecount'] = $this->l->C($sdata);
		}
		$this->_d['page'] = eyPage($this->_p,$sdata);
		$this->_d['list'] = $list;
		$this->_d['pagecount'] = $this->_p['pagecount'];
		$this->load->view($this->_d['cfg']['tpl_admin'] . 'livemaster/list', $this->_d);

	}

	public function edit($masterid = '')
	{
		if (empty($masterid))
		{
			$retmsg['code'] = '0';
			$retmsg['msg'] = $this->lang->line('admin_page_lostcateid');
			exit(json_encode($retmsg));		
		}

		$this->_d['row'] = $this->l->O(array('masterid'=>$masterid));
		if ($this->form_validation->run('live/setMaster') == false)
		{
			if (validation_errors() != '')
			{
				$retmsg['code'] = '0';
				$retmsg['msg'] = validation_errors();
				exit(json_encode($retmsg));
			}
			
			if (empty($this->_data['row']))
			{
				$this->_data['row'] = $this->l->INIT();
				$this->_data['row']['roomid'] = '';
			}

			$this->_d['act'] = 'edit';
			$this->load->view($this->_d['cfg']['tpl_admin'] . 'livemaster/detail', $this->_d);
		}
		else
		{
			$postdata = $this->input->post();
			if (empty($this->_d['row']))
			{
				$postdata['ctime'] = time();
				$postdata['cateid'] = $cateid;
				if ($this->l->A($postdata) > 0)
				{
					$retmsg['code'] = '1';
					$retmsg['msg'] =  $this->lang->line('comm_sucess_tip');
					exit(json_encode($retmsg));
				}
				else
				{
					$retmsg['code'] = '0';
					$retmsg['msg'] = $this->lang->line('comm_fail_tip');
					exit(json_encode($retmsg));
				}				
			}
			else
			{
				$postdata['mtime'] = time();
				if ($this->l->M($postdata, array('masterid'=>$masterid)) === true)
				{
					$retmsg['code'] = '1';
					$retmsg['msg'] = $this->lang->line('comm_sucess_tip');
					exit(json_encode($retmsg));
				}
				else
				{
					$retmsg['code'] = '0';
					$retmsg['msg'] = $this->lang->line('comm_fail_tip');
					exit(json_encode($retmsg));
				}			
			}
		}
	}

}

?>
