<?php
/**
 * 图片剪切
 */
class ImageCrop{
    private $targetW;   //目标图像的
    private $targetH;   
    private $targetX = 0;    //目标图像的X坐标
    private $targetY = 0;    //目标图像的Y坐标
    private $sourceX;
    private $sourceY;
    private $sourceW;
    private $sourceH;
    private $imageFile;
    private $imageType;
    
//    public function __construct($soruceImage, $targetW = 150, $targetH = 150) {
//        $this->imageFile = $soruceImage;
//        $this->targetH = $targetH;
//        $this->targetW = $targetW;
//    }
    
    public function setTargetSize($targetW,$targetH){
        $this->targetW = $targetW;
        $this->targetH = $targetH;
    }
    public function setSourceSize($sourceW, $sourceH){
        $this->sourceW = $sourceW;
        $this->sourceH = $sourceH;
    }
    public function setSourceCoord($sourceX,$sourceY){
        $this->sourceX = $sourceX;
        $this->sourceY = $sourceY;
    }
    public function setImageType($imageType){
        $this->imageType = $imageType;
    }
    public function setImageFile($imageFile){
        $this->imageFile = $imageFile;
    }

    /**
     * 新建一个真彩色图像
     * @param int $width
     * @param int $height 
     * @param string $imageType 
     * @return resource 返回一个图像标识符
     */
    protected function createImage($width, $height, $imageType){
        if(strtolower($imageType) == 'image/gif'){
            $resource = imagecreate($width, $height);
        }else{
            $resource = imagecreatetruecolor($width, $height);
        }
        return $resource;
    }
    
    
    /**
     * 文件或 URL 新建一图像
     * @param sting $fileName 文件名
     * @param string $imageType 文件类型
     * @return source 返回一图像标识符
     */
    protected function loadSourceImage($fileName, $imageType){
        $im = false;
        switch (strtolower($imageType)){
            case 'image/gif':
                $im = imagecreatefromgif($fileName);
                break;
            case 'image/jpeg':
                $im = imagecreatefromjpeg($fileName);
                break;
            case 'image/jpg':
                $im = imagecreatefromjpeg($fileName);
                break;
            case 'image/png':
                $im = imagecreatefrompng($fileName);
                break;
            default :
                $im = imagecreatefromgif($fileName);
                break;
        }
        if($im){
            return $im;
        }else{
            throw new Exception('新建图像失败'.$fileName);
        }
        
            
    }
    
    /**
     * 保存图片
     * @param $resource $image image 参数是 imagecreatetruecolor() 函数的返回值。
     * @param string $fileName 新图片的文件名
     * @param int $quality 为可选项，范围从 0（最差质量，文件更小）到 100（最佳质量，文件最大）。默认为 IJG 默认的质量值（大约 75）。
     * @param string 
     */
    protected function saveImage($image, $imageType, $fileName = '',$quality = 75){
        $flag = true;
        if(!$fileName){
            header("Content-type:".$imageType); 
        }
        switch (strtolower($imageType)){
            case 'image/gif':
                $flag = imagegif($image, $fileName);
                break;
            case 'image/jpeg':
                $flag = imagejpeg($image, $fileName, $quality);
                break;
            case 'image/jpg':
                $flag = imagejpeg($image, $fileName, $quality);
                break;
            case 'imge/png':
                $flag = imagepng($image, $fileName, $quality);
                break;
            default :
               $flag = imagejpeg($image, $fileName, $quality);
               break; 
           exit;
        }
        return $flag;
    }
    
    /**
     * 剪切图像
     * @param string $fileName 新图片的文件名
     * @return boolean 成功返回true,失败返回fasle
     */
    public function corpImage($fileName = ''){
        $sourceImage = $this->loadSourceImage($this->imageFile, $this->imageType);
        $targetImage = $this->createImage($this->targetW, $this->targetH, $this->imageType);
        $flag1 = imagecopyresampled($targetImage, $sourceImage, $this->targetX, $this->targetY, $this->sourceX, $this->sourceY, $this->targetW, $this->targetH, $this->sourceW, $this->sourceH);
        $flag2 = $this->saveImage($targetImage, $this->imageType, $fileName);
        if($flag1 && $flag2){
            return true;
        }else{
            return false;
        }
    }

	/**
	 * 获取图片类型
	 * @param string $ext
	 * @return 
	 */
	public function getImageType($type){
		switch ($type) {
			case 'jpg':
				$imageType = 'image/jpg';
				break;
			case 'jpeg':
				$imageType = 'image/jpeg';
				break;
			case 'gif':
				$imageType = 'image/gif';
				break;
			case 'png':
				$imageType = 'image/png';
				break;
			default:
				$imageType = 'image/jpg';
				break;
		}
		return $imageType;
	}
}

class Upload_Cutting_Module extends CI_Module {

	private $_data = array();

	private $imagecrop;
	public function __construct() {
		parent::__construct();
//		$userinfo = $this->session->userdata('userinfo');
//		if (!$userinfo) redirect("user"); 
//		$this->_data['userinfo'] = $userinfo;
		$this->imagecrop = new imagecrop();
    }

	// 默认的弹出裁剪页
	public function showpage($element='',$source='',$width='',$height='',$sourceimage='')
	{
		$this->_data['width'] = $width;
		$this->_data['height'] = $height;
		$this->_data['haspath'] = 1;
		$this->_data['element'] = $element;
		$this->_data['source'] = $source;
		$this->_data['sourceimage'] = base64_decode($sourceimage);
		$this->load->view('cutting', $this->_data);		
	}


	// 默认的弹出裁剪页
	public function showpage2($element='',$source='',$width='',$height='',$sourceimage='')
	{
		$this->_data['width'] = $width;
		$this->_data['height'] = $height;
		$this->_data['haspath'] = 1;
		$this->_data['element'] = $element;
		$this->_data['source'] = $source;
		$this->_data['flag'] = 1;
		$this->_data['sourceimage'] = $this->uri->segment(9) . '/' . $this->uri->segment(10) . '/' . $this->uri->segment(11)  . '/' . $this->uri->segment(12);
		$this->load->view('cutting', $this->_data);		
	}

	// 默认的弹出裁剪页，并把地址回写给父页面
	// $element为需要回写控件ID
	public function hasPath($element)
	{
		if (empty($element)) return '';
		$this->_data['haspath'] = 1;
		$this->_data['element'] = $element;
		$this->load->view('cutting', $this->_data);		
	}



	/**
	 * 编辑器上传图片（编辑器专用）
	 */
	public function doUploadImg($dir = 'temp'){
		$uploadDir = 'data/upload/' . $dir . '/';
		$uploadPath = $this->createDir($uploadDir,1);
		$config['upload_path'] = $uploadDir.$uploadPath.'/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '4194304';				//2m
		$config['max_width']  = '2048';
		$config['max_height']  = '2048';
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
	 * 资源文件上传
	 */
	public function doUploadFile(){
		$uploadDir = 'data/upload/video/';
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
	
	public function cutting()
	{		
		extract($this->input->post());

		$fileInfo = pathinfo($attach_name);
		$fileExt = $fileInfo['extension'];	
		$t = explode('/', $attach_name);
		$fileName = end($t);
		array_pop($t);
		$uploadPath = implode('/', $t);
		
		try{
			//获取文件的类型
			$fileType = $this->imagecrop->getImageType($fileExt);
			$this->imagecrop->setImageFile(base_url($attach_name));
			$this->imagecrop->setImageType($fileType);
			$this->imagecrop->setSourceCoord($x, $y);
			
			$imageSize = array($aimw . '_' . $aimh);
			if($imageSize){
				foreach($imageSize as $item){
					$subDir = 'pic_'.$item . "/";
					$newImage = $uploadPath.'/'.$subDir.$fileName;
					$this->createDir($uploadPath. '/' . $subDir, '');
					$guige = explode('_', $item);
					$this->imagecrop->setTargetSize($guige[0], $guige[1]);
					$this->imagecrop->setSourceSize($w, $h);
					$retmsg = $this->imagecrop->corpImage($newImage);
				}
			}

			if ($retmsg)
			{
				$retdata['code'] = 1;
				$retdata['msg'] = $uploadPath.'/'.$fileName;
				foreach ($imageSize as $k)
				$retdata['pic_' . $k] = $uploadPath.'/pic_' . $k . '/' . $fileName;
				echo json_encode($retdata);
				exit;
			}
			else
			{
				echo json_encode(array('code'=>0, 'msg'=>$uploadPath.'/'.$fileName));
				exit;
			}

		}catch (Exception $e){
			
		}		

	}
	
	/**
	 * 头像剪切文件上传
	 */
	public function doUploadCropImage(){
		$uploadDir = 'data/upload/photo/';
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
}