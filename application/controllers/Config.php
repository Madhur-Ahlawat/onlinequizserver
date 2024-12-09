<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$CI =& get_instance();
		$CI->load->library('session');
		$this->load->model('Common_model');
		$this->load->helper('url');
	}
	
	public function index()
	{

		$dbobject1 = $this->load->database('default',TRUE);

		if(FALSE === $dbobject1->conn_id)
		{
		   $is_database_connect= 0;
		}else
		{
			$is_database_connect = 1;
		}

		$data['is_database_connect'] = $is_database_connect;

		$this->load->view("config",$data);
	}
}
