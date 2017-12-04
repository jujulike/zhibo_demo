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
class Shangshi extends MY_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->model('Pages_model','pg');
		$this->load->model('Category_model','c');
		$this->_d['menu'] = '78';
    }

	// 上市品种
	public function page()
	{
		$shangshi_cate = cate2array($this->c->L(array('parentid'=>'101','status'=>'1'),'cateid,catename',0,0,'sort'),'cateid');
		foreach ($shangshi_cate as $k => $v)
		{
			$shangshi = $this->pg->L(array('cateid'=>$v['cateid'],'status'=>'1'),'pageid,title,desc',0,0,'sort');
			if (!empty($shangshi))
			{
				foreach ($shangshi as $k2 => $v2)
				{
					$shangshi[$k2]['attachment'] = $this->getAttach($v2['pageid'],'article');
				}
			}
			$shangshi_cate[$v['cateid']]['shangshi'] = $shangshi;

		}
		//print_r($shangshi_cate);
		$this->_d['shangshi'] = $shangshi_cate;
		$this->load->view("themes/feibei/shangshi", $this->_d);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */