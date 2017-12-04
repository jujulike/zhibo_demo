<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 文件上传
 */
class Upload_Upload_Module extends CI_Module{
    
    private $uploadPath = 'data/upload/';
    private $allowedTypes = 'gif|jpg|png|doc|docx|ppt|pptx|xls|xlsx|pot|pps|rtf|pdf|txt';
    private $maxSize = '2048';    //2M ci的upload以K为单位（千字节）
    private $maxWidth = 1024;
    private $maxHeight = 1024;
    private $dirType = 1;
    private $responseType = 'json';
    
    public function __construct() {
        parent::__construct();
    }
    
    public static function setOption($uploadPath= './data/upload/',$allowedType = 'gif|jpg|png',$maxSize = '2048',$maxWidth = '1024',$maxHeight = '1024',$dirType = 1,$responseType = 'json'){
        $this->uploadPath = $uploadPath;
        $this->allowedTypes = $allowedType;
        $this->maxSize = $maxSize;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
        $this->dirType = $dirType;
        $this->responseType = $responseType;
    }
    //文件上传
    public function upload(){
        $uploadModel = $this->input->post('upload_model');
        $uploadPath = $this->uploadPath.$this->createDir($this->uploadPath, $this->dirType,$uploadModel);
        $config['upload_path'] = $uploadPath;
        $config['allowed_types'] = $this->allowedTypes;
        $config['max_size'] = $this->maxSize;
        $config['max_width']  = $this->maxWidth;
        $config['max_height']  = $this->maxHeight;
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload()){
             $data = array('error' => $this->upload->display_errors());
        }else{
             $tempData = $this->upload->data();
             $tempData['upload_dir'] = $uploadPath;
             $data = array('upload_data' => $tempData);
        }
       
        if($this->responseType == 'json'){
            echo json_encode($data);
        }else{
            return $data;
        } 
    }
    //显示上传插件
    public function showUpload($uploadModel = 'papers', $successCallback = 'uploadSuccess', $uploadname = ''){
        $data['upload'] = array(
            'allowedTypes'  =>$this->getAllowedType(),
            'maxSize'       =>$this->maxSize,
            'upload_model'  =>$uploadModel,
            'uploadSuccess' =>$successCallback
        );
	
		$data['upload_name'] = $uploadname;

        $this->load->view('upload',$data);
    }
    
    
    
    //上传类型的转换
    private function getAllowedType(){
        $types = '';
        $temp = explode('|', $this->allowedTypes);
        if($temp){
            foreach($temp as $item){
                $types .= '*.'.$item.';';
            }
        }
        return $types;
    }
    
    

    /**
	 * 创建文件夹
	 */
	private function createDir($uploadDir,$dirType = 1,$uplaodModel = 'papers'){
		switch($dirType)
		{
			case 1: $subdir = $uplaodModel.'/'.date('Y') . "/".date('m').'/'.date('d').'/'; break;
			case 2: $subdir = $uplaodModel.'/'.date('Y') . "/".date('m').'/';  break;
			default : 
                show_app_error('不支持的类型');
                break;
		}
        $dirArray = explode('/', $subdir);
        if($dirArray){
            foreach($dirArray as $dir){
                $uploadDir .=  '/'.$dir;
                if(!is_dir($uploadDir)){
                    @mkdir($uploadDir);
                }
            }
        }
       
		return $subdir;
	}
}
?>
