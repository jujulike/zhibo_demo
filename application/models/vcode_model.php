<?php 
if (!defined('BASEPATH')) 
    exit('No direct script access allowed'); 

class Vcode_model extends CI_Model { 

//    private $charset = "abcdefghizklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";   //随机因子   
    private $charset = "abcdefghizklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";   //随机因子   
    private $code;  //验证码文字 
    private $codelen = 4; //验证码显示几个文字 
    private $width = 75;   //验证码宽度 
    private $height = 25;   //验证码高度 
    private $img;    //验证码资源句柄 
    private $font;  //指定的字体 
    private $fontsize = 16;  //指定的字体大小 
    private $fontcolor;  //字体颜色  随机 

    //构造类  编写字体 

    public function __construct() { 
        parent::__construct(); 
        $this->font = APPPATH . 'libraries/LiberationSans-Bold.ttf'; 
    } 

    //创建4个随机码 
    private function createCode() { 
        $_leng = strlen($this->charset) - 1; 
        for ($i = 0; $i < $this->codelen; $i++) { 
            $this->code.=$this->charset[mt_rand(0, $_leng)]; 
        } 
        return $this->code; 
    } 

    //创建背景 
    private function createBg() { 
        //创建画布 给一个资源jubing 
        $this->img = imagecreatetruecolor($this->width, $this->height); 
        //背景颜色 
        $color = imagecolorallocate($this->img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255)); 
        //画出一个矩形 
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color); 
    } 

    //创建字体 
    private function createFont() { 
        $_x = ($this->width / $this->codelen);   //字体长度 
        for ($i = 0; $i < $this->codelen; $i++) { 
            //文字颜色 
            $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156)); 
            //资源句柄 字体大小 倾斜度 字体长度  字体高度  字体颜色  字体  具体文本 
            imagettftext($this->img, $this->fontsize, mt_rand(-18, 18), $_x * $i + mt_rand(1, 5), $this->height/1.2, $color, $this->font, $this->code[$i]); 
        } 
    } 

    //随机线条 
    private function createLine() { 
        //随机线条 
        for ($i = 0; $i < 6; $i++) { 
            $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156)); 
            imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color); 
        } 
//        //随机雪花 
//        for ($i = 0; $i < 45; $i++) { 
//            $color = imagecolorallocate($this->img, mt_rand(220, 255), mt_rand(220, 255), mt_rand(220, 255)); 
//            imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '.', $color); 
//        } 
    } 

    //输出背景 
    private function outPut() { 
        //生成标头 
        header("Expires: -1"); 
        header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE); 
        header("Pragma: no-cache"); 
        header('Content-Type:image/png'); 
        //输出图片 
        imagepng($this->img); 
        //销毁结果集 
        imagedestroy($this->img); 
    } 

    //对外输出 
    public function doimg() { 
        //加载背景 
        $this->createBg(); 
        //加载文件 
        $this->createCode(); 
        //加载线条 
        $this->createLine(); 
        //加载字体 
        $this->createFont(); 
        //加载背景 
        $this->outPut(); 
    } 

    //获取验证码 
    public function getCode() { 
        return strtolower($this->code); 
    } 

}