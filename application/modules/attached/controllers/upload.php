<?php

class Attached_Upload_Module extends CI_Module {

	private $_d = array();

	public function __construct() {
		parent::__construct();
		$this->load->model('Attachedcate_model', 'ac');
		$this->load->model('Attacheddetail_model', 'ad');
	}

	// 单图片上传
	public function single()
	{
		$this->load->view("single", $this->_d);
	}


	// 多图片上传
	public function multi()
	{
		$this->load->view("multi", $this->_d);
	}

	// 限定图片数上传
	public function multilimit($limit=0,$id='')
	{
		if ($id != '') $attached = $this->ac->LL($id);
		$imgthumb_t = array();
		$imgthumb = array();
		if (!empty($attached))
		{
			foreach ($attached as $k => $v) $imgthumb_t[] = $v['attachpath'];
		}
		for ($i=0;$i<$limit;$i++)
		{
			if (!empty($imgthumb_t[$i]))
			{
				$imgthumb[] = $imgthumb_t[$i];
			}
			else
			{
				$imgthumb[] = '';
			}
		}
		$this->_d['limit'] = $limit;
		$this->_d['imgthumb'] = $imgthumb;
		$this->load->view("multilimit", $this->_d);
	}


	//图片入库
	public function addAttach($id='',$action='',$imgthumb = array(),$source_imgthumb=array())
	{

		$attachcate = $this->ac->O(array('detailid'=>$id,'action'=>$action));

		// 删除已有数据
		if (!empty($attachcate))
		{
			$attachcateid = $attachcate['attachcateid'];
			$this->ad->D(array('attachcateid'=>$attachcate['attachcateid']));
		}
		else
		{
			// 入数据库
			$acdata['detailid']=$id;
			$acdata['action']=$action;
			$acdata['ctime'] = time();
			$attachcateid = $this->ac->A($acdata);
		}
		
		foreach ($imgthumb as $k => $v)
		{
			$addata[$k]['attachcateid'] = $attachcateid;
			$addata[$k]['attachpath'] = $v;
			$addata[$k]['ctime'] = time();
		}

		foreach ($source_imgthumb as $k => $v)
		{
			$addata[$k]['attachsourcepath'] = $v;
		}

		$this->db->insert_batch($this->ad->tbl, $addata);
		
	}


	//附件删除
	public function delAttach($id='',$action='')
	{
		if (is_array($id))
		{
			$id = implode(",",$id);
		}

		$attachcateid = $this->ac->L(array('detailid in (' . $id . ')' =>'','action'=>$action),'*',0,0);

		// 删除已有数据
		if (!empty($attachcateid))
		{
			foreach ($attachcateid as $k => $v) $cateid[] = $v['attachcateid'];
			$this->ad->D(array('attachcateid in (' . implode(",",$cateid) . ')' =>''));
			$this->ac->D(array('detailid in (' . $id . ')' =>'','action'=>$action));
		}
		
	}


	// 附件上传
	public function attach()
	{
		$this->load->view("attach", $this->_d);
	}


/*

require_once 'JSON.php';

$php_path = dirname(__FILE__) . '/';
$php_url = dirname($_SERVER['PHP_SELF']) . '/';

//文件保存目录路径
$save_path = $php_path . '../attached/';
//文件保存目录URL
$save_url = $php_url . '../attached/';
//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 1000000;

$save_path = realpath($save_path) . '/';

//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '超过php.ini允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("上传失败。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//检查目录名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	if (empty($ext_arr[$dir_name])) {
		alert("目录名不正确。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
	}
	//创建文件夹
	if ($dir_name !== '') {
		$save_path .= $dir_name . "/";
		$save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
	}
	$ymd = date("Ymd");
	$save_path .= $ymd . "/";
	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;

	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
*/

}