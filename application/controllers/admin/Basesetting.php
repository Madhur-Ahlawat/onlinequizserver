<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Basesetting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        frontendcheck();
    }

    public function index()
    {
        $data['base_setting'] = $this->Common_model->get('', 'base_setting', 'id', 'ASC');
        $this->load->view("admin/base_setting/list", $data);
    }

    public function add()
    {
        $this->load->view("admin/base_setting/add");
    }

    public function save()
    {
        $key = $_POST['key'];
        $value = $_POST['value'];
      
        $data = array(
            'key' => $key,
            'value' => $value
        );

        $base_settingId = $this->Common_model->insert($data, 'base_setting');

        if ($base_settingId) {
            $res = array('status' => '200', 'message' => 'New base_setting Create.');
            echo json_encode($res);exit;
        } else {
            $res = array('status' => '400', 'message' => 'fail');
            echo json_encode($res);exit;
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $where = 'id="' . $id . '"';
        $data['base_setting'] = (object)$this->Common_model->getById($where, 'base_setting');
        $this->load->view("admin/base_setting/edit", $data);
    }

    public function update()
    {
        $key = $_POST['key'];
        $value = $_POST['value'];

        $id = $_POST['id'];
        $data = array(
            'key' => $key,
            'value' => $value
        );

        $base_settingId = $this->Common_model->update($id, 'id', $data, 'base_setting');
        if ($base_settingId) {
            $res = array('status' => '200', 'message' => 'Update Base Setting Sucessfully.');
            echo json_encode($res);exit;
        } else {
            $res = array('status' => '400', 'message' => 'fail');
            echo json_encode($res);exit;
        }
    }
}