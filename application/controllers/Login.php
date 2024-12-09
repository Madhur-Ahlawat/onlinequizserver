<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$CI =& get_instance();
		$CI->load->library('session');
		$this->load->model('Common_model');
		$this->load->helper('url');
	}

	public function index(){
		if($this->session->userdata('admin_id')) {
			$data['settinglist'] = $this->Common_model->settings_data();
			redirect(base_url().'admin/dashboard');
		}
		else{
			$this->load->view("admin/login");
		}
		
	}
	public function login_admin() {
        	
		$email = $this->input->post('email');
		$password = $this->input->post('password');		
		$where = 'email_address = "'.$email.'" AND password = "'.$password.'"';
		
		$result = $this->Common_model->getById($where,'admin');
	    
		if(isset($result['id'])) {
			$this->session->set_userdata('admin_email',$result['email_address']);
			$this->session->set_userdata('admin_id',$result['id']);	
			$this->session->set_userdata('admin_name',$result['username']);	
		
			$response=array('status'=>200,'message'=>'Login Successfully');		
			
		} else {
			$response=array('status'=>400,'message'=>'Please enter valid email adress and password.');
		}
		echo json_encode($response);exit;
	}
}
