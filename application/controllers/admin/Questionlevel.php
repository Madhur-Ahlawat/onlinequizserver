<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Questionlevel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        frontendcheck();
    }

    public function index()
    {
        $data['level_master'] = $this->Common_model->get('', 'question_level_master', 'level_order', 'ASC');
        $this->load->view("admin/level_master/list", $data);
    }

    public function add()
    {
        $this->load->view("admin/level_master/add");
    }

    public function save()
    {
        try {
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('level_order', 'level_order', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $level_master_name = $_POST['name'];
                $level_order = $_POST['level_order'];
                
                $data = array(
                    'level_name' => $level_master_name,
                    'level_order' => $level_order
                );

                $level_masterId = $this->Common_model->insert($data, 'question_level_master');

                if ($level_masterId) {
                    $res = array('status' => '200', 'message' => 'New level master Create.');
                    echo json_encode($res);exit;
                } else {
                    $res = array('status' => '400', 'message' => 'fail');
                    echo json_encode($res);exit;
                }
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            return true;
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $where = 'id="' . $id . '"';
        $data['level'] = (object) $this->Common_model->getById($where, 'question_level_master');
        $this->load->view("admin/level_master/edit", $data);
    }

    public function update()
    {
        try {
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('level_order', 'level_order', 'required');
            $this->form_validation->set_rules('id', 'id', 'required');
            
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $level_master_name = $_POST['name'];
                $level_order = $_POST['level_order'];
               
                $id = $_POST['id'];
                $data = array(
                    'level_name' => $level_master_name,
                    'level_order' => $level_order
                );

                $level_masterId = $this->Common_model->update($id, 'id', $data, 'question_level_master');
                if ($level_masterId) {
                    $res = array('status' => '200', 'message' => 'Update level master Sucessfully.');
                    echo json_encode($res);exit;
                } else {
                    $res = array('status' => '400', 'message' => 'fail');
                    echo json_encode($res);exit;
                }
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            return true;
        }
    }
}