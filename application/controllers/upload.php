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
 * 文件上传
 */
class Upload extends MY_Controller{
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 编辑器上传图片（编辑器专用）
	 */
	public function doUploadImg($dir = 'temp'){
		$uploadDir = 'upload/' . $dir . '/';
		$uploadPath = $this->createDir($uploadDir,1);
		$config['upload_path'] = $uploadDir.$uploadPath.'/';
		$config['allowed_types'] = 'gif|png|jpg|swf';
		$config['max_size'] = '1048576';				//2m
		$config['max_width']  = '2048';
		$config['max_height']  = '1024';
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;					//是否重命名
		$config['remove_spaces'] = true;				//文件名中的空格将被替换为下划线
		$this->load->library('upload', $config);
		$fieldName = 'imgFile';

		if($this->upload->do_upload($fieldName)){		//上传成功
			$data = $this->upload->data();
		}else{											//上传失败
			$error = strip_tags($this->upload->display_errors());
		}
		header('Content-type: text/html; charset=UTF-8');
		if(!isset($error)){
			$url = base_url($config['upload_path']).'/'.$data['raw_name'].$data['file_ext'];
			echo json_encode(array('error'=>0,'url'=>$url));
			exit;
		}else{
			echo json_encode(array('error'=>1,'message'=>$error));
			exit;
		}
	}
	
	
	/**
	 * 上传文件测试
	 */
	public function doUpload(){
		$uploadDir = getcwd().'/upload/test/';
		$uploadPath = $this->createDir($uploadDir,1);
		$config['upload_path'] = $uploadDir.$uploadPath.'/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '1048576';				//2m

		$config['overwrite'] = false;
		$config['encrypt_name'] = true;					//是否重命名
		$config['remove_spaces'] = true;				//文件名中的空格将被替换为下划线
		$this->load->library('upload', $config);
		$fieldName = 'filedata';
		if($this->upload->do_upload($fieldName)){		//上传成功
			$data = $this->upload->data();
		}else{											//上传失败
			$data = $this->upload->display_errors();
		}
		echo "<pre>";
		print_r($data);
	}
	
	public function index(){
		$this->load->helper(array('form'));
		$this->load->view('admin/article/upload');
	}

	
	/**
	 * 资源文件上传
	 */
	public function doUploadFile(){
		$uploadDir = 'upload/video/';
		$uploadPath = $this->createDir($uploadDir,1);
		$config['upload_path'] = $uploadDir.$uploadPath.'/';
		$config['allowed_types'] = 'swf|flv';
		$config['max_size'] = '1048576';				//2m

		$config['overwrite'] = false;
		$config['encrypt_name'] = true;					//是否重命名
		$config['remove_spaces'] = true;				//文件名中的空格将被替换为下划线
		$this->load->library('upload', $config);
		$fieldName = 'filedata';
		if($this->upload->do_upload($fieldName)){		//上传成功
			$data = $this->upload->data();
		}else{											//上传失败
			$error = strip_tags($this->upload->display_errors());
		}
		if(!isset($error)){
			echo json_encode(array(
				'status'=>1,
				'file_size'=>$data['file_size'],
				'file_ext'=>$data['file_ext'],
				'client_name'=>$data['client_name'],			//上传的文件在客户端的文件名。
				'file_name'=>$data['file_name'],				//已上传的文件名（包括扩展名）
				'file_path'=>$data['file_path'],				//不包括文件名的文件绝对路径
				'full_path'=>$data['full_path'],				//包括文件名在内的文件绝对路径
				'raw_name'=>$data['raw_name'],					//不包括扩展名在内的文件名部分
				'upload_path'=>$config['upload_path']				//不包括文件名的文件相对路径
			));
		}else{
			echo json_encode(array('status'=>0,'message'=>$error));
		}
	}
	
	
	/**
	 * 头像剪切文件上传
	 */
	public function doUploadCropImage(){
		$uploadDir = getcwd().'/upload/photo/';
		$uploadPath = $this->createDir($uploadDir,1);
		$config['upload_path'] = $uploadDir.$uploadPath.'/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '1048576';				//2m
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite'] = false;
		$config['encrypt_name'] = true;					//是否重命名
		$config['remove_spaces'] = true;				//文件名中的空格将被替换为下划线
		$this->load->library('upload', $config);
		$fieldName = 'filedata';
		if($this->upload->do_upload($fieldName)){		//上传成功
			$data = $this->upload->data();
		}else{											//上传失败
			$error = strip_tags($this->upload->display_errors());
		}
		header('Content-type: text/html; charset=UTF-8');
		if(!isset($error)){
			$url = base_url($config['upload_path']).'/'.$data['raw_name'].$data['file_ext'];
			
			echo json_encode(array('error'=>0,'url'=>$url,'upload_path'=>$config['upload_path'],'file_name'=>$data['file_name']));
			exit;
		}else{
			echo json_encode(array('error'=>1,'message'=>$error));
			exit;
			
		}
		
	}

	/**
	 * 创建文件夹
	 */
	private function createDir($uploadDir,$dirType = 1){
		switch($dirType)
		{
			case 1: $subdir = date('Ymd'); break;
			case 2: $subdir = date('Ym'); break;
			default : $subdir = date('Ymd');break;
		}
		$attachDir = $uploadDir.'/'.$subdir.'/';
		
		if(!is_dir($uploadDir))
		{
			@mkdir($uploadDir, 0777);
			@fclose(fopen($uploadDir.'index.htm', 'w'));
		}

		if(!is_dir($attachDir))
		{
			@mkdir($attachDir, 0777);
			@fclose(fopen($attachDir.'index.htm', 'w'));
		}
		return $subdir;
	}


	public function multiupload($dir = 'temp',$width='100',$height='100')
	{
		$this->load->library('image');
		$_uppath = getcwd().'/upload/' . $dir . '/';
		$_datepath = $this->createDir($_uppath);
		
		$_sourcefullpath = $_uppath . $_datepath . '/source_img';
		if(!is_dir($_sourcefullpath))
		{
			mkdir($_sourcefullpath, 0777);
		}
		

		$_thumbfullpath = $_uppath . $_datepath . '/thumb_img';
		if(!is_dir($_thumbfullpath))
		{			
			mkdir($_thumbfullpath, 0777);
		}

		//定义允许上传的文件扩展名
		$ext_arr = array(
			$dir => array('gif', 'jpg', 'jpeg', 'png', 'bmp')
		);
		//最大文件大小
		$max_size = 1000000;

		//$save_path = realpath($save_path) . '/';

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
			echo json_encode(array('error' => 1, 'message' => $error));
			exit;
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
				echo json_encode(array('error' => 1, 'message' => "请选择文件。"));
				exit;
			}
			//检查目录
//			if (@is_dir($save_path) === false) {
				
//			}
			//检查目录写权限
			if (@is_writable($_sourcefullpath) === false) {
				echo json_encode(array('error' => 1, 'message' => "上传目录没有写权限。"));
				exit;
			}
			//检查是否已上传
			if (@is_uploaded_file($tmp_name) === false) {
				echo json_encode(array('error' => 1, 'message' => "上传失败。"));
				exit;
			}
			//检查文件大小
			if ($file_size > $max_size) {
				echo json_encode(array('error' => 1, 'message' => "上传文件大小超过限制。"));
				exit;
			}
			//检查目录名
			if (empty($ext_arr[$dir])) {
				echo json_encode(array('error' => 1, 'message' => "目录名不正确。"));
				exit;
			}
			//获得文件扩展名
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			//检查扩展名
			if (in_array($file_ext, $ext_arr[$dir]) === false) {
				echo json_encode(array('error' => 1, 'message' => "上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir]) . "格式。"));
				exit;
			}

			//新文件名
			$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
			//移动文件
			$file_path = $_sourcefullpath .'/'. $new_file_name;
			if (move_uploaded_file($tmp_name, $file_path) === false) {
				echo json_encode(array('error' => 1, 'message' => "上传文件失败。"));
				exit;
			}
			@chmod($file_path, 0644);
			//$file_url = base_url('/upload/' . $dir . '/' . $_datepath .'/source_img'.'/'. $new_file_name);
			$file_url = ('/upload/' . $dir . '/' . $_datepath .'/source_img'.'/'. $new_file_name);
			
			$thumb_url = '';
			if ($this->_d['cfg']['make_thumb'] == '1')
			{
				// 生成缩略图
				$gallery_thumb = $this->image->make_thumb($file_path,$width,$height,$_thumbfullpath.'/');
				if ($gallery_thum === false)
				{
					echo json_encode(array('error' => 1, 'message' => "上传文件生成缩略图失败。"));
					exit;
				}

				//$thumb_url = base_url(substr($gallery_thumb,strpos($gallery_thumb,'upload')));
				$thumb_url = ('/'.substr($gallery_thumb,strpos($gallery_thumb,'upload')));
			}

	header('Content-type: text/html; charset=UTF-8');

			
			//echo json_encode(array('error' => 0, 'url' => $file_url,'thumb_url'=>$thumb_url, 'message'=>''));
			echo '<script>window.parent.InsertMsgPic("'.$thumb_url.'","'.$file_url.'");</script>';
			exit;
		}
	}
	
	
}
?>
