<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

	public function __construct() {
		parent::__construct();
		frontendcheck();
		$this->load->model('Common_model');						
		
	}

	public function delete_record(){
		$id=$_POST['id'];
		$tablename=$_POST['tablename'];
		$where = 'id="'.$id.'"';	
		$this->Common_model->delete($where,$tablename);
		return true;
	}

}
