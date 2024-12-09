<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contestquestion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        frontendcheck();
    }

    public function index()
    {
        $this->load->view("admin/contest_question/list");
    }
    
    public function add() {
        $data['level'] = $this->Common_model->get('', 'level');
        $data['category'] = $this->Common_model->get('', 'category');
        $data['contest'] = $this->Common_model->get('', 'contest_master');
        $data['questionlevel'] = $this->Common_model->get('', 'question_level_master');
        $this->load->view("admin/contest_question/add", $data);
    }

    public function save() {
        try {
            $this->form_validation->set_rules('category_id', 'category', 'required');
            $this->form_validation->set_rules('contest_id', 'contest', 'required');
            $this->form_validation->set_rules('question', 'question', 'required');
            $this->form_validation->set_rules('answer', 'answer', 'required');
           
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $errors);
                echo json_encode($array);
                exit;
            } else {
                //echo "<pre>";print_r($_POST);die;
                $category_id = trim($_POST['category_id']);
                $contest_id = trim($_POST['contest_id']);
                $question = trim($_POST['question']);
                $question_type = trim($_POST['question_type']);
                $option_a = trim($_POST['option_a']);
                $option_b = trim($_POST['option_b']);
                $option_c = trim($_POST['option_c']);
                $option_d = trim($_POST['option_d']);
                $answer = trim($_POST['answer']);
                $note = trim($_POST['note']);
                
                $level_id = isset($_POST['level_id']) ? $_POST['level_id'] : 0 ;
                $question_level_master_id = isset($_POST['question_level_master_id']) ? $_POST['question_level_master_id'] : 0;

                $question_image = '';
                if ($_FILES['image']['name'] != '') {
                    $question_image = $this->Common_model->imageupload($_FILES['image'], 'image', FCPATH . 'assets/images/question');
                }

                $data = array(
                    'category_id' => $category_id,
                    'contest_id' => $contest_id,
                    'question' => $question,
                    'question_type' => $question_type,
                    'option_a' => $option_a,
                    'option_b' => $option_b,
                    'option_c' => $option_c,
                    'option_d' => $option_d,
                    'answer' => $answer,
                    'note' => $note,
                    'level_id' => $level_id,
                    'question_level_master_id' => $question_level_master_id,
                    'image' => $question_image,
                );

                $cat_id = $this->Common_model->insert($data, 'question');

                if ($cat_id) {
                    $res = array('status' => '200', 'message' => 'New question Create.', 'id' => $cat_id);
                    echo json_encode($res);
                    exit;
                } else {
                    $res = array('status' => '400', 'message' => 'fail');
                    echo json_encode($res);
                    exit;
                }
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function edit() {
        $data['level'] = $this->Common_model->get('', 'level');
        $data['category'] = $this->Common_model->get('', 'category');
        $data['contest'] = $this->Common_model->get('', 'contest_master');
        $id = $_GET['id'];
        $where = 'id="' . $id . '"';
        $data['question'] = (object) $this->Common_model->getById($where, 'question');
        $data['questionlevel'] = $this->Common_model->get('', 'question_level_master');
        $this->load->view("admin/contest_question/edit", $data);
    }

    public function update() {

        try {
            $this->form_validation->set_rules('category_id', 'category', 'required');
            $this->form_validation->set_rules('contest_id', 'contest', 'required');
            $this->form_validation->set_rules('question', 'question', 'required');
            $this->form_validation->set_rules('answer', 'answer', 'required');
          
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $category_id = trim($_POST['category_id']);
                $contest_id = trim($_POST['contest_id']);
                $id = trim($_POST['id']);
                $question = trim($_POST['question']);
                $question_type = trim($_POST['question_type']);
                $option_a = trim($_POST['option_a']);
                $option_b = trim($_POST['option_b']);
                $option_c = trim($_POST['option_c']);
                $option_d = trim($_POST['option_d']);
                $answer = trim($_POST['answer']);
                $note = trim($_POST['note']);
                $level_id = isset($_POST['level_id']) ? $_POST['level_id'] : 0 ;
                $question_level_master_id = isset($_POST['question_level_master_id']) ? $_POST['question_level_master_id'] : 0;


                if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                    $question_image = $this->Common_model->imageupload($_FILES['image'], 'image', FCPATH . 'assets/images/question');
                } else {
                    $question_image = $_POST['question_image'];
                }

                $data = array(
                    'category_id' => $category_id,
                    'contest_id' => $contest_id,
                    'level_id' => $level_id,
                    'question_level_master_id' => $question_level_master_id,
                    'question' => $question,
                    'question_type' => $question_type,
                    'option_a' => $option_a,
                    'option_b' => $option_b,
                    'option_c' => $option_c,
                    'option_d' => $option_d,
                    'answer' => $answer,
                    'note' => $note,
                    'image' => $question_image,
                );

                $questionId = $this->Common_model->update($id, 'id', $data, 'question');

                if ($questionId) {
                    $res = array('status' => '200', 'message' => 'Update question Sucessfully.');
                    echo json_encode($res);
                    exit;
                } else {
                    $res = array('status' => '400', 'message' => 'fail');
                    echo json_encode($res);
                    exit;
                }
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function fetch_data()
    {
        $table = "question";
        $select_column = array("id", "question", "option_a", "option_b", "option_c", "option_d","answer","image","level_id","category_id");
        $order_column = array(null, "question",  "option_a", "option_b", "option_c", "option_d","answer","image","level_id","category_id");
        $search = array("question",  "option_a", "option_b", "option_c", "option_d","answer");

        $where = 'contest_id != 0';

        $fetch_data = $this->Common_model->make_datatables($table, $select_column, $order_column, $search, $where);


        $data = array();

        foreach ($fetch_data as $key => $row) {

            $wherecategory = 'id=' . $row->category_id;
            $category = $this->Common_model->getById($wherecategory, 'category');
            $category_name = '';
            $category_name = isset($category['name']) ? $category['name'] : '';
          
            if ($row->answer == 1) {
                $answer = 'A';
            } elseif ($row->answer == 2) {
                $answer = 'B';
            } elseif ($row->answer == 3) {
                $answer = 'C';
            } elseif ($row->answer == 4) {
                $answer = 'D';
            }

            $sub_array = array();

            $sub_array[] = "<input type='checkbox'  class='deleteRow' value='". $row->id ."' />";
            $sub_array[] = $key+1;
            $sub_array[] = $row->question;
            $sub_array[] = '<img src="' . get_question_image_path($row->image, "question") . '" width="50" height="50" />';
            $sub_array[] = $category_name;        
            $sub_array[] = $row->option_a;
            $sub_array[] = $row->option_b;
            $sub_array[] = $row->option_c;
            $sub_array[] = $row->option_d;
            $sub_array[] = $answer;
            $sub_array[] = ' <a href="' . base_url() . 'admin/contestquestion/edit?id=' . $row->id . '" class="btn btn-xs btn-primary p-1" ><i  class="fa fa-edit p-1"></i></a> <a href="javaScript:void(0)" class="btn btn-xs btn-danger p-1" onclick="delete_record(' . $row->id . ',\'question\')"><i class="fa fa-trash p-1"></i></a>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->Common_model->get_all_data($table),
            "recordsFiltered" => $this->Common_model->get_filtered_data($table, $select_column, $order_column, $search, $where),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function delete_data()
    {
        $id=$_POST['ids'];
        $tablename= 'question';
        $where = 'id IN('.$id.')';    
        $this->Common_model->delete($where,$tablename);
        return true;
    }

}