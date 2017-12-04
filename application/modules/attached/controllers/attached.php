<?php 
	class Attached_Attached_Module extends CI_Module {

		private $_data = array();

		public function __construct() {
			parent::__construct();
			$this->load->model('Attacheddetail_model', 'd');
			$this->load->model('Attachedcate_model', 'c');
		}

		public function uploadImages(){
			$this->load->view("uploadimages", $this->_data);
		}
		public function uploadImages2($limit=10){}
		public function uploadImg(){}
		public function uploadFile(){}
}
?>