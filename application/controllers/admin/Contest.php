<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Contest extends CI_Controller {
    public function __construct() {
        parent::__construct();
        frontendcheck();
    }
    
    public function index()
    {
        $this->load->view("admin/contest/list");
    }

    public function add() {
        $data = array();
        $data['category'] = $this->Common_model->get('', 'category');
        $this->load->view("admin/contest/add", $data);
    }
    public function save() {
        //echo "<pre>";print_r($_POST);die;
        try {
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('start_date', 'start_date', 'required');
            $this->form_validation->set_rules('end_date', 'end_date', 'required');
        
            $this->form_validation->set_rules('price', 'price', 'required');
            $this->form_validation->set_rules('no_of_user', 'no_of_user', 'required');
            $this->form_validation->set_rules('no_of_user_prize', 'no_of_user_prize', 'required');
            $this->form_validation->set_rules('total_prize', 'total_prize', 'required');
            $this->form_validation->set_rules('no_of_rank', 'no_of_rank', 'required');
            if (isset($_FILES['image']['name']) && empty($_FILES['image']['name'])) {
                $this->form_validation->set_rules('image', 'image', 'required');
            }
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $errors);
                echo json_encode($array);
                exit;
            } else {
                if (isset($_POST['no_of_rank']) && $_POST['no_of_rank'] > 10) {
                    $array = array('status' => 400, 'message' => 'Rank max value is 10');
                    echo json_encode($array);
                    exit;
                }else if($_POST['no_of_rank'] <= 0){
                    $array = array('status' => 400, 'message' => 'Rank must be greater than value is 0');
                    echo json_encode($array);
                    exit;
                }
                $name = $_POST['name'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $price = $_POST['price'];
                $levelId = isset($_POST['level_id']) ? $_POST['level_id'] : 0;
                $no_of_user_limit = $_POST['no_of_user'];
                $no_of_user = $_POST['no_of_user_prize'];
                $no_of_rank = $_POST['no_of_rank'];
                $total_prize = $_POST['total_prize'];
                if ($total_prize) {
                    $prize_json = $this->get_prize_list($no_of_rank, $no_of_user, $total_prize);
                } else {
                    $array = array('status' => 400, 'message' => 'Please enter total prize');
                    echo json_encode($array);
                    exit;
                }
                $contest_image = $this->Common_model->imageupload($_FILES['image'], 'image', FCPATH . 'assets/images/contest');
                $data = array(
                    'name' => $name,
                    'start_date' => date('Y-m-d H:i:s', strtotime($start_date)),
                    'end_date' => date('Y-m-d H:i:s', strtotime($end_date)),
                    'price' => $price,
                    'image' => $contest_image,
                    'level_id' => $levelId,
                    'no_of_user' => $no_of_user_limit,
                    'no_of_user_prize' => $no_of_user,
                    'total_prize' => $total_prize,
                    'prize_json' => $prize_json,
                    'no_of_rank' => $no_of_rank,
                );
                $id = $this->Common_model->insert($data, 'contest_master');
                if ($id) {
                    $res = array('status' => '200', 'message' => 'Add contest successfully.');
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
        $id = $_GET['id'];
        $where = 'id="' . $id . '"';
        $data['contest'] = $this->Common_model->getById($where, 'contest_master');
        $data['level'] = $this->Common_model->get('', 'level');
        //echo "<pre>";print_r($data);die;
        $this->load->view("admin/contest/edit", $data);
    }
    public function update() {
        try {
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('start_date', 'start_date', 'required');
            $this->form_validation->set_rules('end_date', 'end_date', 'required');
            $this->form_validation->set_rules('price', 'price', 'required');
            $this->form_validation->set_rules('no_of_user', 'no_of_user', 'required');
            $this->form_validation->set_rules('no_of_user_prize', 'no_of_user_prize', 'required');
            $this->form_validation->set_rules('no_of_rank', 'no_of_rank', 'required');
            $this->form_validation->set_rules('total_prize', 'total_prize', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $errors);
                echo json_encode($array);
                exit;
            } else {
                if ($_POST['no_of_rank'] > 10) {
                    $array = array('status' => 400, 'message' => 'Rank max value is 10');
                    echo json_encode($array);
                    exit;
                }else if($_POST['no_of_rank'] <= 0){
                    $array = array('status' => 400, 'message' => 'Rank must be greater than value is 0');
                    echo json_encode($array);
                    exit;
                }
                $name = $_POST['name'];
                $no_of_user_limit = $_POST['no_of_user'];
                $no_of_user = $_POST['no_of_user_prize'];
                $no_of_rank = $_POST['no_of_rank'];
                $total_prize = $_POST['total_prize'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $id = $_POST['id'];
                $levelId = isset($_POST['level_id']) ? $_POST['level_id'] : 0;
                $price = $_POST['price'];
                if ($total_prize) {
                    $prize_json = $this->get_prize_list($no_of_rank, $no_of_user, $total_prize);
                } else {
                    $array = array('status' => 400, 'message' => 'Please enter total prize');
                    echo json_encode($array);
                    exit;
                }
                if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                    $contestImage = $this->Common_model->imageupload($_FILES['image'], 'image', FCPATH . 'assets/images/contest');
                } else {
                    $contestImage = $_POST['contestimage'];
                }
                $data = array(
                    'name' => $name,
                    'start_date' => date('Y-m-d H:i:s', strtotime($start_date)),
                    'end_date' => date('Y-m-d H:i:s', strtotime($end_date)),
                    'price' => $price,
                    'image' => $contestImage,
                    'level_id' => $levelId,
                    'no_of_rank' => $no_of_rank,
                    'no_of_user' => $no_of_user_limit,
                    'no_of_user_prize' => $no_of_user,
                    'total_prize' => $total_prize,
                    'prize_json' => $prize_json,
                );

                $contestId = $this->Common_model->update($id, 'id', $data, 'contest_master');

                if ($contestId) {
                    $res = array('status' => '200', 'message' => 'Update contest Sucessfully.');
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

    public function get_prize_list($no_of_rank = '10', $no_user_user = null, $total_amount = null) {
        
        if($no_user_user <= 10 && $no_user_user ==$no_of_rank)
        {
            $new_rank = $no_of_rank;
            $new_user_user = $no_user_user;
            $range_new = round($new_user_user / $new_rank);
        }
        else if ($no_of_rank > 3) {
            $new_rank = $no_of_rank - 3;
            $new_user_user = $no_user_user - 3;
            $range_new = round($new_user_user / $new_rank);
        }


        $pecent = 100;
        $ranges = [100, 75, 70, 65, 60, 55, 50, 45, 40, 35];
        $range = $ranges[$no_of_rank - 1];
        $sum = 0;

        $row = [];
        $range_new1 = 0;
        $is_stop = 0;
        for ($i = 0; $i < $no_of_rank; $i++) {
            $per = ($pecent * $range) / 100;
            $pecent -= round($per);
            $sum += round($per);
            $data = [];
            $data['percentage'] = number_format($per, 2);
            $data['winning_amount'] = ($total_amount * $per) / 100;
            if ($i > 2) {
                if ($i == 3) {
                    $range_new1 = $i + 1;
                }

                if($no_user_user== $new_rank){
                    $data['rank'] = $i + 1;
                } 
                else if ($no_user_user < ($range_new1 + $range_new)) {
                    $data['rank'] = $range_new1 . ' to ' . $no_user_user;
                    $is_stop = 1;
                } else {
                    $data['rank'] = $range_new1 . ' to ' . ($range_new1 + $range_new);
                }
                $range_new1 += $range_new + 1;
            } else {
                $range_new1 = $i + 1;
                $data['rank'] = number_format($i + 1, 0);
            }
            
            $row[] = $data;
            if ($is_stop == 1) {
                break;
            }
        }
       
        $array['win_list'] = $row;
        // p($array);
        return json_encode($array);
    }

    public function make_winner($contestId) {
        try {
            $where = 'id=' . $contestId;
            $contestData = $this->Common_model->getByID($where, 'contest_master');
            if (isset($contestData['id']) && $contestData['id'] != '') {
                $no_of_user_prize = $contestData['no_of_user_prize'];
                $whereGet = 'contest_id=' . $contestId;
                $rank = $this->Common_model->getRankByContestId($whereGet, $no_of_user_prize);
                $winJson = json_decode($contestData['prize_json']);
                $data = [];
                foreach ($winJson->win_list as $row) {
                    $between = explode(' to ', $row->rank);
                    if (count($between) > 1) {
                        $rowData = $row;
                        for ($i = $between[0]; $i <= $between[1]; $i++) {
                            $rowData = [];
                            $rowData['rank'] = $i;
                            $rowData['winning_amount'] = $row->winning_amount;
                            $rowData['percentage'] = $row->percentage;
                            $data[] = $rowData;
                        }
                    } else {
                        $rowData = [];
                        $rowData['rank'] = $between[0];
                        $rowData['winning_amount'] = $row->winning_amount;
                        $rowData['percentage'] = $row->percentage;
                        $data[] = $rowData;
                    }
                }
                $winnList = array();
                foreach ($rank as $key => $usersData) {
                    $data[$key]['score'] = $usersData['score'];
                    $data[$key]['user_id'] = $usersData['user_id'];
                    $data[$key]['contest_id'] = $usersData['contest_id'];
                    $winnList[] = $data[$key];
                }
                $whereDelete = 'contest_id=' . $contestId;
                $this->Common_model->delete($whereDelete, 'winners');
                foreach ($winnList as $win) {
                    $winInsert['price'] = $win['winning_amount'];
                    $winInsert['percentage'] = $win['percentage'];
                    $winInsert['rank'] = $win['rank'];
                    $winInsert['score'] = $win['score'];
                    $winInsert['user_id'] = $win['user_id'];
                    $winInsert['contest_id'] = $win['contest_id'];
                    $contestId = $this->Common_model->insert($winInsert, 'winners');
                }
                redirect(base_url() . 'admin/contest', 'refresh');
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function winner_list($contestId) {
        try {
            $where = 'contest_id="' . $contestId . '"';
            $winners = $this->Common_model->get($where, 'winners', 'rank', 'ASC');
            $datas = array();
            foreach ($winners as $row) {

                $whereUser = 'id=' . $row->user_id;
                $userName = $this->Common_model->getById($whereUser, 'users');
                $row->user_name = '';
                if(isset($userName['id'])){
                    $row->user_name = $userName['fullname'];
                }
                $datas[] = $row;
            }
            $data['winners'] = $datas;
            $this->load->view("admin/contest/winner_list", $data);
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }


    public function fetch_data()
    {
        $table = "contest_master";
        $select_column = array("id", "name", "start_date", "end_date", "price", "level_id");
        $order_column = array(null, "name",  "start_date", "end_date", "price", "level_id");
        $search = array("name",  "start_date", "end_date", "price", "level_id");

        $where = '';
        $fetch_data = $this->Common_model->make_datatables($table, $select_column, $order_column, $search, $where);

        $data = array();

        foreach ($fetch_data as $key => $row) {

            // $wherelevel = 'id=' . $row->level_id;
            // $level = $this->Common_model->getById($wherelevel, 'level');
            // $level_name = '';
            // $level_name = isset($level['name']) ? $level['name'] : '';


            $whereContest = 'contest_id=' . $row->id;
            $contestWiner = $this->Common_model->getById($whereContest, 'winners');

            if ($row->end_date < date('Y-m-d')) {
                if (isset($contestWiner['id'])) {
                    $text = '<a href="'.base_url().'admin/contest/winner_list/'.$row->id.'" class="btn btn-sm btn-success"> Winner List</a>';
                } else {
                    $text = '<a href="'.base_url().'admin/contest/make_winner/'.$row->id.'" class="btn btn-sm btn-info"> Make Winner</a>';
                }
            } else {
                $text = '<label class="btn btn-sm btn-warning">not ended</label>';
            }


            $sub_array = array();
            $sub_array[] = $row->id;
            $sub_array[] = $row->name;
            // $sub_array[] = $level_name;
            $sub_array[] = date('Y-m-d',strtotime($row->start_date));
            $sub_array[] = date('Y-m-d',strtotime($row->end_date));
            $sub_array[] = $row->price;
            $sub_array[] = $text;

            $sub_array[] = ' <a href="' . base_url() . 'admin/contest/edit?id=' . $row->id . '" class="btn btn-xs btn-primary p-1" ><i  class="fa fa-edit p-1"></i></a> <a href="javaScript:void(0)" class="btn btn-xs btn-danger p-1" onclick="delete_record(' . $row->id . ',\'contest_master\')"><i class="fa fa-trash p-1"></i></a>';
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
}
?>