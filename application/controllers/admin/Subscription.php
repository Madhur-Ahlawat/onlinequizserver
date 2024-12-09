<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {

    public function __construct() {
        parent::__construct();
        frontendcheck();
    }

    public function index() {
        $setting = get_setting();
        foreach($setting as $set){
            $setn[$set->key]=$set->value;
        }
        $data['setting'] = $setn;
        
        $data['subscription'] = $this->Common_model->get('', 'plan_subscription', 'id', 'desc');
        $this->load->view("admin/subscription/list", $data);
    }

    public function add() {
    	$setting = get_setting();
    	foreach($setting as $set){
			$setn[$set->key]=$set->value;
		}
    	$data['setting'] = $setn;
    	
        $this->load->view("admin/subscription/add",$data);
    }

    public function save() {
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('price', 'price', 'required');
        $this->form_validation->set_rules('coin', 'coin', 'required');

        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] == "") {
            $this->form_validation->set_rules('image', 'image', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            //echo "<pre>";print_r($_FILES);die;
            $errors = $this->form_validation->error_array();
            sort($errors);
            $array = array('status' => 400, 'message' => $errors);
            echo json_encode($array);
            exit;
        } else {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $price = isset($_POST['price']) ? trim($_POST['price']) : '';
            $currency_type = isset($_POST['currency_type']) ? trim($_POST['currency_type']) : '';
            $coin = isset($_POST['coin']) ? trim($_POST['coin']) : '';
           
            $image = $this->Common_model->imageupload($_FILES['image'], 'image', FCPATH . 'assets/images/subplan');
            $data = array(
                'name' => $name,
                'price' => $price,
                'currency_type' => $currency_type,
                'coin' => $coin,
                'product_package' => isset($_POST['product_package']) ? $_POST['product_package'] : '',
                'image' => $image
            );

            $id = $this->Common_model->insert($data, 'plan_subscription');
            $res = array('status' => '200', 'message' => 'Sucessfully updated');
            echo json_encode($res);
        }
    }

    public function edit() {

    	$setting = get_setting();
    	foreach($setting as $set){
			$setn[$set->key]=$set->value;
		}
    	$data['setting'] = $setn;

        $id = $_GET['id'];
        $where = 'id="' . $id . '"';
        $data['subplan'] = $this->Common_model->getById($where, 'plan_subscription');
        //echo "<pre>";print_r($data);die;
        $this->load->view("admin/subscription/edit", $data);
    }

    public function update() {
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('price', 'price', 'required');
        $this->form_validation->set_rules('coin', 'coin', 'required');
      

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            sort($errors);
            $array = array('status' => 400, 'message' => $errors);
            echo json_encode($array);
            exit;
        } else {
            //echo "<pre>";print_r($_POST);die;
            $id = isset($_POST['id']) ? trim($_POST['id']) : '';
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $price = isset($_POST['price']) ? trim($_POST['price']) : '';
            $currency_type = isset($_POST['currency_type']) ? trim($_POST['currency_type']) : '';
            $coin = isset($_POST['coin']) ? trim($_POST['coin']) : '';
            
            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                $image = $this->Common_model->imageupload($_FILES['image'], 'image', FCPATH . 'assets/images/subplan');
            } else {
                $image = $_POST['subplanimage'];
            }
            $data = array(
                'name' => $name,
                'price' => $price,
                'currency_type' => $currency_type,
                'coin' => $coin,
                'product_package' => isset($_POST['product_package']) ? $_POST['product_package'] : '',
                'image' => $image
            );
      
            $id = $this->Common_model->update($id, 'id', $data, 'plan_subscription');
            $res = array('status' => '200', 'message' => 'Sucessfully updated');
            echo json_encode($res);
        }
    }
}