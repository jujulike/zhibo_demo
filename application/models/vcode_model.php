<?php 
if (!defined('BASEPATH')) 
    exit('No direct script access allowed'); 

class Vcode_model extends CI_Model { 

//    private $charset = "abcdefghizklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";   //�������   
    private $charset = "abcdefghizklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";   //�������   
    private $code;  //��֤������ 
    private $codelen = 4; //��֤����ʾ�������� 
    private $width = 75;   //��֤���� 
    private $height = 25;   //��֤��߶� 
    private $img;    //��֤����Դ��� 
    private $font;  //ָ�������� 
    private $fontsize = 16;  //ָ���������С 
    private $fontcolor;  //������ɫ  ��� 

    //������  ��д���� 

    public function __construct() { 
        parent::__construct(); 
        $this->font = APPPATH . 'libraries/LiberationSans-Bold.ttf'; 
    } 

    //����4������� 
    private function createCode() { 
        $_leng = strlen($this->charset) - 1; 
        for ($i = 0; $i < $this->codelen; $i++) { 
            $this->code.=$this->charset[mt_rand(0, $_leng)]; 
        } 
        return $this->code; 
    } 

    //�������� 
    private function createBg() { 
        //�������� ��һ����Դjubing 
        $this->img = imagecreatetruecolor($this->width, $this->height); 
        //������ɫ 
        $color = imagecolorallocate($this->img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255)); 
        //����һ������ 
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color); 
    } 

    //�������� 
    private function createFont() { 
        $_x = ($this->width / $this->codelen);   //���峤�� 
        for ($i = 0; $i < $this->codelen; $i++) { 
            //������ɫ 
            $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156)); 
            //��Դ��� �����С ��б�� ���峤��  ����߶�  ������ɫ  ����  �����ı� 
            imagettftext($this->img, $this->fontsize, mt_rand(-18, 18), $_x * $i + mt_rand(1, 5), $this->height/1.2, $color, $this->font, $this->code[$i]); 
        } 
    } 

    //������� 
    private function createLine() { 
        //������� 
        for ($i = 0; $i < 6; $i++) { 
            $color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156)); 
            imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color); 
        } 
//        //���ѩ�� 
//        for ($i = 0; $i < 45; $i++) { 
//            $color = imagecolorallocate($this->img, mt_rand(220, 255), mt_rand(220, 255), mt_rand(220, 255)); 
//            imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '.', $color); 
//        } 
    } 

    //������� 
    private function outPut() { 
        //���ɱ�ͷ 
        header("Expires: -1"); 
        header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE); 
        header("Pragma: no-cache"); 
        header('Content-Type:image/png'); 
        //���ͼƬ 
        imagepng($this->img); 
        //���ٽ���� 
        imagedestroy($this->img); 
    } 

    //������� 
    public function doimg() { 
        //���ر��� 
        $this->createBg(); 
        //�����ļ� 
        $this->createCode(); 
        //�������� 
        $this->createLine(); 
        //�������� 
        $this->createFont(); 
        //���ر��� 
        $this->outPut(); 
    } 

    //��ȡ��֤�� 
    public function getCode() { 
        return strtolower($this->code); 
    } 

}