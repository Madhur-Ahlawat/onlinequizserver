<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $CI = & get_instance();
        frontendcheck();
    }

    public function index() {
        $data['userslist'] = $this->Common_model->get('', 'users', 'id', 'DESC');
        $this->load->view("admin/users/list", $data);
    }

    public function add() {
        $this->load->view("admin/users/add");
    }

    public function save() {
        $this->form_validation->set_rules('fullname', 'fullname', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('mobile_number', 'mobile', 'required');

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            sort($errors);
            $array = array('status' => 400, 'msg' => $errors);
            echo json_encode($array);
            exit;
        } else {
            if (isset($_POST['username']) && $_POST['username'] != '') {
                $whereusername = 'username="' . $_POST['username'] . '"';
                $userslist = $this->Common_model->getById($whereusername, 'users');

                if (isset($userslist['id']) && $userslist['id'] != '') {
                    $res = array('status' => '400', 'msg' => 'Username already added please try again.');
                    echo json_encode($res);
                    exit;
                }
            }
            $data = $_POST;

            $data['first_name'] = $_POST['fullname'];
            $where = 'mobile_number="' . $data['mobile_number'] . '" OR email="' . $data['email'] . '"';
            $userslist = $this->Common_model->getById($where, 'users');

            if (isset($userslist['id'])) {
                $res = array('status' => '400', 'msg' => 'users already exits');
                echo json_encode($res);
                exit;
            } else {
                $userReferCode = $this->Common_model->generateUserReferCode('users','reference_code');
                $data['reference_code'] = $userReferCode;
                $data['created_at'] = date('Y-m-d h:i:s');
                $res_id = $this->Common_model->insert($data, 'users');
                if ($res_id) {
                    //$this->qrcodeGenerator($res_id);
                    $res = array('status' => '200', 'msg' => 'New users added Sucessfully',
                        'id' => $res_id);
                    echo json_encode($res);
                } else {
                    $res = array('status' => '400', 'msg' => 'Please try again');
                    echo json_encode($res);
                }
            }
        }
    }

    function qrcodeGenerator($patient_id = null) {
        $this->load->library('ciqrcode');
        $image_base_url = $this->config->item('image_base_path');
        $qr_image = $patient_id . '.png';
        $params['data'] = $patient_id;
        $params['level'] = 'H';
        $params['size'] = 8;
        $params['savename'] = $image_base_url . "users_qrcode/" . $qr_image;
        if ($this->ciqrcode->generate($params)) {
            $img_url = $qr_image;
        }
        return $img_url;
    }

    public function edit() {
        $id = $_GET['id'];
        $where = 'id="' . $id . '"';
        $data['userslist'] = $this->Common_model->getById($where, 'users');
        $this->load->view("admin/users/edit", $data);
    }

    public function update() {
        $this->form_validation->set_rules('fullname', 'fullname', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
      
        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            sort($errors);
            $array = array('status' => 400, 'msg' => $errors);
            echo json_encode($array);
            exit;
        } else {
            $id = $_POST['id'];

            if (isset($_POST['username']) && $_POST['username'] != '') {
                $whereusername = 'username="' . $_POST['username'] . '" AND id !=' . $id;
                $userslist = $this->Common_model->getById($whereusername, 'users');

                if (isset($userslist['id']) && $userslist['id'] != '') {
                    $res = array('status' => '400', 'msg' => 'Username already added please try again.');
                    echo json_encode($res);
                    exit;
                }
            }

            $password = $_POST['password'];

            unset($_POST['id']);
            unset($_POST['password']);
            $data = $_POST;

            if ($password) {
                $data['password'] = $password;
            }

            $data['first_name'] = $_POST['fullname'];

            if (isset($_FILES['users_profile']) && !empty($_FILES['users_profile']['name'])) {
                $users_profile = $this->Common_model->imageupload($_FILES['users_profile'], 'users_profile', FCPATH . 'assets/images/users');
                $data['profile_img'] = $users_profile;
            }

            $res_id = $this->Common_model->update($id, 'id', $data, 'users');

            if ($res_id) {
                $res = array('status' => '200', 'msg' => 'Update users Sucessfully',
                    'id' => $res_id);
                echo json_encode($res);
                exit;
            } else {
                $res = array('status' => '400', 'msg' => 'Please try again');
                echo json_encode($res);
                exit;
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata('admin_email');
        $this->session->unset_userdata('admin_id');
        redirect(base_url() . 'login');
    }

    public function status_change() {
        $id = $_POST['id'];
        $tablename = $_POST['tablename'];
        $status = $_POST['status'];
        if ($status == 'enable') {
            $status1 = 'disable';
        } else {
            $status1 = 'enable';
        }
        $data1 = array('status' => $status1);
        $this->Common_model->update($id, 'id', $data1, 'users');
        return true;
    }

}
