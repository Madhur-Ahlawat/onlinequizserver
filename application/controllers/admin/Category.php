<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        frontendcheck();
    }

    public function index() {
        $data['category'] = $this->Common_model->get('', 'category', 'id', 'DESC');
        $this->load->view("admin/category/list", $data);
    }

    public function add() {
        $this->load->view("admin/category/add");
    }

    public function save() {

        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            sort($errors);
            $array = array('status' => 400, 'message' => $errors);
            echo json_encode($array);
            exit;
        } 

        $category_name = $_POST['name'];
        if ($category_name == '') {
            $result = array("status" => '400', "message" => 'Please enter category name');
            echo json_encode($result);
            exit;
        }
        $category_image = $this->Common_model->imageupload($_FILES['image'], 'image', FCPATH . 'assets/images/category');

        $data = array(
            'name' => $category_name,
            'image' => $category_image
        );

        $catId = $this->Common_model->insert($data, 'category');

        if ($catId) {
            $res = array('status' => '200', 'message' => 'New category Create.');
            echo json_encode($res);
            exit;
        } else {
            $res = array('status' => '400', 'message' => 'fail');
            echo json_encode($res);
            exit;
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $where = 'id="' . $id . '"';
        $data['category'] = (object) $this->Common_model->getById($where, 'category');

        $this->load->view("admin/category/edit", $data);
    }

    public function update() {

        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            sort($errors);
            $array = array('status' => 400, 'message' => $errors);
            echo json_encode($array);
            exit;
        } 
        
        $category_name = $_POST['name'];

        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $CatImage = $this->Common_model->imageupload($_FILES['image'], 'image', FCPATH . 'assets/images/category');
        } else {
            $CatImage = $_POST['categoryimage'];
        }

        $id = $_POST['id'];

        $data = array(
            'name' => $category_name,
            'image' => $CatImage
        );

        $catId = $this->Common_model->update($id, 'id', $data, 'category');

        if ($catId) {
            $res = array('status' => '200', 'message' => 'Update category Sucessfully.');
            echo json_encode($res);
            exit;
        } else {
            $res = array('status' => '400', 'message' => 'fail');
            echo json_encode($res);
            exit;
        }
    }

}
