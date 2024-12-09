<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Level extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        frontendcheck();
    }

    public function index()
    {
        $data['level'] = $this->Common_model->get('', 'level', 'level_order', 'ASC');
        $this->load->view("admin/level/list", $data);
    }

    public function add()
    {
        $this->load->view("admin/level/add");
    }

    public function save()
    {
        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            sort($errors);
            $array = array('status' => 400, 'message' => $errors);
            echo json_encode($array);
            exit;
        } 

        $level_name = $_POST['name'];
        $total_question = $_POST['total_question'];
        $win_question_count = $_POST['win_question_count'];
        $level_order = $_POST['level_order'];

        $score = $_POST['score'];

        if ($level_name == '') {
            $result = array("status" => '400', "message" => 'Please enter level name');
            echo json_encode($result);exit;
        }

        $data = array(
            'name' => $level_name,
            'total_question' => $total_question,
            'win_question_count' => $win_question_count,
            'score' => $score,
            'level_order' => $level_order,
        );

        $levelId = $this->Common_model->insert($data, 'level');

        if ($levelId) {
            $res = array('status' => '200', 'message' => 'New level Create.');
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
        $data['level'] = (object) $this->Common_model->getById($where, 'level');
        $this->load->view("admin/level/edit", $data);
    }

    public function update()
    {
        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            sort($errors);
            $array = array('status' => 400, 'message' => $errors);
            echo json_encode($array);
            exit;
        }

        $level_name = $_POST['name'];
        $total_question = $_POST['total_question'];
        $win_question_count = $_POST['win_question_count'];
        $score = $_POST['score'];
        $level_order = isset($_POST['level_order']) ? $_POST['level_order'] : '0';

        $id = $_POST['id'];
        $data = array(
            'name' => $level_name,
            'total_question' => $total_question,
            'win_question_count' => $win_question_count,
            'score' => $score,
            'level_order' => $level_order,
        );

        $levelId = $this->Common_model->update($id, 'id', $data, 'level');
        if ($levelId) {
            $res = array('status' => '200', 'message' => 'Update level Sucessfully.');
            echo json_encode($res);exit;
        } else {
            $res = array('status' => '400', 'message' => 'fail');
            echo json_encode($res);exit;
        }
    }
}