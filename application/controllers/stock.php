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
class Stock extends MY_Controller {

	public function __construct() {
        parent::__construct();

		$this->load->model('Livemaster_model','master');		
		$this->load->model('Live_model','room');		
		$this->load->model('Category_model','cate');		
		$this->load->model('Article_model','article');		
		$this->load->model('Advertising_model','ad');		

    }


	public function index()
	{
		// ���չ�ע
		$this->_d['jrgz'] = $this->article->L(array('cateid'=>132), 'title,url', 4, 0, 'sort', 'asc');
		// ���ղ���
		$this->_d['jrcl'] = $this->article->L(array('cateid'=>133), 'title,url', 4, 0, 'sort', 'asc');

		// ����ͼƬ���
		$this->_d['tpgg'] = $this->ad->O(array('cateid'=>135), 'title,link,imgthumb');

		// �м�ͨ��ͼƬ���
		$this->_d['tlgg'] = $this->ad->O(array('cateid'=>134), 'title,link,imgthumb');

		// ֱ���ҹ��
		$this->_d['zbsgg'] = $this->ad->O(array('cateid'=>34), 'title,link,desc');
		$this->load->view($this->_d['cfg']['tpl'] . "stock/index", $this->_d);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */