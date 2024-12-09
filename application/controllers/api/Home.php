<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_api_model');
        $this->lang->load('english_lang', 'english');
    }

    public function get_category() {
        $category = $this->Common_api_model->get('', 'category');
        $result = array();
        foreach ($category as $row) {
            $row['image'] = get_image_path($row['image'], 'category');
            $result[] = $row;
        }

        if (sizeof($result) > 0) {
            $response = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $result);
        } else {
            $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
        }
        echo json_encode($response);
    }

    public function get_packages() {
        $category = $this->Common_api_model->get('', 'plan_subscription');
        $result = array();
        foreach ($category as $row) {
            $row['image'] = get_image_path($row['image'], 'subplan');
            $result[] = $row;
        }

        if (sizeof($result) > 0) {
            $response = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $result);
        } else {
            $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
        }
        echo json_encode($response);
    }

     public function add_transaction(){
        try {
            $this->form_validation->set_rules('coin', 'coin', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('plan_subscription_id', 'plan_subscription_id', 'required');
            
            $this->form_validation->set_rules('transaction_amount', 'transaction_amount', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {

                    $data['transaction_amount'] = $_POST['transaction_amount'];
                    $data['user_id'] = $_POST['user_id'];
                    $data['coin'] = $_POST['coin'];
                    $data['plan_subscription_id'] = $_POST['plan_subscription_id'];
                    
                    $result = $this->Common_api_model->insert($data, 'transaction');
                   
                    $this->Common_api_model->updateByIdWithcount($_REQUEST['user_id'], 'total_points', $_POST['coin'], 'users');
                    if (isset($result) && $result > 0) {
                        $response = array('status' => 200, 'message' => "You transaction successfully.");
                    } else {
                        $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                    }
                    echo json_encode($response);
               
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }    
    }

    public function get_package_transaction(){
        try {
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
               
                $userId = trim($_REQUEST['user_id']);
                $whereUserId = 'user_id="' . $userId . '"';
                $earn_transaction = $this->Common_api_model->get($whereUserId, 'transaction');
                $datas = [];
                foreach ($earn_transaction as $key => $value) {
                    $contest_name = '';
                    if($value['plan_subscription_id'] > 0)
                    {
                        $whereContest = 'id='.$value['plan_subscription_id'];
                        $contest_master = $this->Common_api_model->getById($whereContest, 'plan_subscription');                        
                        
                        if(isset($contest_master['name'])){
                            $contest_name =$contest_master['name'];
                        }
                    }
                    $value['package_name'] = $contest_name;

                    $datas[] = $value;

                }
                
                if(count($datas) > 0){
                    $response = array('status' => 200, 'result' => $datas, 'message' => $this->lang->line('successfully_get'));
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
               
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            return true;
        }
    }

    public function genaral_setting() {

        $setting = $this->Common_api_model->get('', 'general_setting', '', '', '500');

        $where = 'type=3';
        $earnpoint_setting = $this->Common_api_model->getById($where, 'earnpoint_setting');
      
        if (isset($earnpoint_setting['id'])) {
            $data[0]['id'] = "101";
            $data[0]['key'] = 'refer_user';
            $data[0]['value'] = $earnpoint_setting['value'];
            $setting = (array) $setting;
            $rows = array_merge($setting, $data);
        }


        if (!empty($rows)) {
            $response = array('status' => 200, 'result' => $rows, 'message' => $this->lang->line('successfully_get'));
        } else {
            $rows = array();
            $response = array('status' => 400, 'result' => $rows, 'message' => $this->lang->line('record_not_found'));
        }
        echo json_encode($response);
    }
  
    public function saveQuestionReport() {
        try {
            $this->form_validation->set_rules('level_id', 'level_id', 'required');
            $this->form_validation->set_rules('questions_attended', 'questions_attended', 'required');
            $this->form_validation->set_rules('total_questions', 'total_questions', 'required');
            $this->form_validation->set_rules('correct_answers', 'correct_answers', 'required');
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');

            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);

                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $levelId = trim($_REQUEST['level_id']);
                $where = 'id=' . $levelId;
                $result = $this->Common_api_model->getById($where, 'level');
                $question_level_master_id = isset($_REQUEST['question_level_master_id']) ? $_REQUEST['question_level_master_id'] : 0;

                if (isset($result['id'])) {
                    $score = (int) round($result['score']);

                    $totalQuestions = $_POST['total_questions'];
                    $per =  $score / $totalQuestions;

                    $finalScore =  $per * $_POST['correct_answers'];
                  
                    if ($result['win_question_count'] > $_POST['correct_answers']) {
                        $isUnlock = 0;
                    } else {

                        $isUnlock = 1;
                    }

                    $data['level_id'] = $levelId;
                    $data['question_level_master_id'] = $question_level_master_id;
                    $data['questions_attended'] = $_POST['questions_attended'];
                    $data['total_questions'] = $_POST['total_questions'];
                    $data['correct_answers'] = $_POST['correct_answers'];
                    $data['user_id'] = $_POST['user_id'];
                    $data['category_id'] = $_POST['category_id'];
                    $data['score'] = (int) round($finalScore);
                    $data['is_unlock'] = $isUnlock;
                    $data['date'] = date('Y-m-d');
                    $result = $this->Common_api_model->insert($data, 'contest_leaderboard');

                    if($isUnlock == 1){

                        $setting = $this->Common_api_model->settings_data();
                        foreach ($setting as $set) {
                            $setn[$set->key] = $set->value;
                        }

                        $total_score = (int) round($setn['total_score']);
                        $total_score_point = $setn['total_score_point'];
                        $totalPointArray = ($finalScore * $total_score_point) / $total_score;
                        $total_points = (int) round($totalPointArray);

                        $earn_transaction['user_id'] = $_POST['user_id'];
                        $earn_transaction['contest_id'] = 0;
                        $earn_transaction['point'] = $total_points;
                        $earn_transaction['type'] = 2;
                        $result = $this->Common_api_model->insert($earn_transaction, 'earn_transaction');

                        $this->Common_api_model->updateByIdWithcount($_REQUEST['user_id'], 'total_points', $total_points, 'users');
                        $this->Common_api_model->updateByIdWithcount($_REQUEST['user_id'], 'total_score', $finalScore, 'users');
                    }

                    if (isset($result) && $result > 0) {
                        $response = array('status' => 200, 'message' => "Record add Successfully");
                    } else {
                        $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                    }
                    echo json_encode($response);
                } else {
                    $response = array('status' => 400, 'message' => 'Level not found');
                    echo json_encode($response);
                }
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function getTodayLeaderBoard() {
        try {
            $this->form_validation->set_rules('level_id', 'level_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $date = date('Y-m-d');
                $levelId = $_REQUEST['level_id'];
                $where = 'date="' . $date . '" AND level_id=' . $levelId;
                $resultTodayRank = $this->Common_api_model->getTodayTenRankByDate($where);

                $data = [];
                foreach ($resultTodayRank as $key => $value) {

                    $where = 'id=' . $value['user_id'];
                    $user = $this->Common_api_model->getById($where, 'users');
                    $value['score'] = (int) round($value['score']);

                    $value['profile_img'] = '';
                    if (isset($user['id'])) {
                        $value['profile_img'] = get_image_path($user['profile_img'], 'users');
                        $value['name'] = $user['fullname'];
                        $value['user_total_score'] = (int) round($user['total_score']);
                    }
                    $data[] = $value;
                }

                $currentUser = (object) [];
                if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
                    $whereContestLeaderboard = 'date="' . $date . '" AND user_id=' . $_REQUEST['user_id'];
                    $orderByField = 'id';
                    $result = $this->Common_api_model->get($whereContestLeaderboard, 'contest_leaderboard', $orderByField, 'DESC', '1');


                    $score = 0;
                    if (isset($result[0]['id'])) {
                        $score = (int) round($result[0]['score']);
                    }

                    $isUnlock = 0;
                    if (isset($result[0]['is_unlock'])) {
                        $isUnlock = $result[0]['is_unlock'];
                    }

                    $whereTodayRank = 'date="' . $date . '" AND level_id=' . $levelId;
                    $currentUser = $this->Common_api_model->getTodayOwnRankByDate($whereTodayRank, $_REQUEST['user_id']);
                     

                     if (isset($currentUser->id)) {
                        $whereUsers = 'id=' . $_REQUEST['user_id'];
                        $user = $this->Common_api_model->getById($whereUsers, 'users');

                        $currentUser->is_unlock = (int)$currentUser->is_unlock;
                        $currentUser->score = (int)$currentUser->score;
                        unset($currentUser->user_id);
                        unset($currentUser->id);
                        $currentUser->id = $_REQUEST['user_id'];
                        if (isset($user['profile_img'])) {
                            $currentUser->total_score = (int)$currentUser->score;
                            $currentUser->profile_img = get_image_path($user['profile_img'], 'users');
                            $currentUser->fullname = $user['fullname'];
                        } else {
                            $currentUser->profile_img = '';
                            $currentUser->fullname = '';
                        }
                    }
                        
                    // if (isset($currentUser->id)) {
                    //     // $currentUser->profile_img = get_image_path($currentUser->profile_img, 'users');
                    //     $currentUser->total_score = (int) round($currentUser->total_score);
                    //     $currentUser->score = $score;
                    //     $currentUser->is_unlock = $isUnlock;
                    // } else {
                    //     $currentUser = (object) array();
                    // }
                }

                $response = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $data, 'user' => $currentUser);
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function getLeaderBoard() {
        try {
            $type = isset($_POST['type']) ? $_POST['type'] : '';
           
            if ($type == 'today') {
                $date = date('Y-m-d');
                
                $levelId = isset($_REQUEST['level_id']) ? $_REQUEST['level_id'] : 0;
                $levelId = isset($_REQUEST['level_id']) ? $_REQUEST['level_id'] : 0;

                if($levelId >0){

                    $where = 'date="' . $date . '" AND level_id=' . $levelId.' AND question_level_master_id != 0';
                }else
                {
                    $where = 'date="' . $date . '" AND question_level_master_id = 0';
                }     

                $result = $this->Common_api_model->getTodayTenRankByDate($where, 'contest_leaderboard');
                $data = [];
                foreach ($result as $key => $value) {
                    $whereUsersById = 'id=' . $value['user_id'];
                    $user = $this->Common_api_model->getById($whereUsersById, 'users');
                    $value['score'] = (int) round($value['score']);
                    $value['is_unlock'] = (int)$value['is_unlock'];
                    $value['profile_img'] = '';
                    $value['rank'] = $key + 1;
                    if (isset($user['id'])) {
                        $value['profile_img'] = get_image_path($user['profile_img'], 'users');
                        $value['name'] = $user['fullname'];
                        $value['user_total_score'] = round($user['total_score']);
                    }
                    $data[] = $value;
                }

                $currentUser = (object) [];
                if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
                    $date = date('Y-m-d');
                    $whereTodayRank = 'date="' . $date . '"';
                    $currentUser = $this->Common_api_model->getTodayOwnRankByDate($whereTodayRank, $_REQUEST['user_id']);
                  
                    if (isset($currentUser->id)) {
                        $whereUsers = 'id=' . $_REQUEST['user_id'];
                        $user = $this->Common_api_model->getById($whereUsers, 'users');

                        $currentUser->is_unlock = (int)$currentUser->is_unlock;
                        $currentUser->score = (int)$currentUser->score;
                        unset($currentUser->user_id);
                        unset($currentUser->id);
                        $currentUser->id = $_REQUEST['user_id'];
                        if (isset($user['profile_img'])) {
                            $currentUser->profile_img = get_image_path($user['profile_img'], 'users');
                            $currentUser->fullname = $user['fullname'];
                        } else {
                            $currentUser->profile_img = '';
                            $currentUser->fullname = '';
                        }
                    }


                }
            } elseif ($type == 'month') {

                $first_day = date('Y-m-01'); // hard-coded '01' for first day
                $last_day = date('Y-m-t');
                
                $levelId = isset($_REQUEST['level_id']) ? $_REQUEST['level_id'] : 0;

                if($levelId > 0){
                    $where = 'date >="' . $first_day . '" AND date <= "' . $last_day . '" AND level_id=' . $levelId.' AND question_level_master_id != 0';
                }else
                {
                    $where = 'date >="' . $first_day . '" AND date <= "' . $last_day . '" AND question_level_master_id = 0';
                }
                
                $order_by_field = 'max_score';
                $result = $this->Common_api_model->getTodayTenRankByDate($where, 'contest_leaderboard');

                $data = [];
                foreach ($result as $key => $value) {
                    $whereUsersById = 'id=' . $value['user_id'];
                    $user = $this->Common_api_model->getById($whereUsersById, 'users');
                    $value['score'] = (int) round($value['score']);
                    $value['is_unlock'] = (int)$value['is_unlock'];
                    unset($value['max_score']);
                    $value['profile_img'] = '';
                    if (isset($user['id'])) {
                        $value['profile_img'] = get_image_path($user['profile_img'], 'users');
                        $value['name'] = $user['fullname'];
                        $value['user_total_score'] = round($user['total_score']);
                    }
                    $data[] = $value;
                }

                $currentUser = (object) [];
                if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
                    $first_day = date('Y-m-01'); // hard-coded '01' for first day
                    $last_day = date('Y-m-t');
                    $wheredfgdg = 'date >="' . $first_day . '" AND date <= "' . $last_day . '"';

                    $currentUser = $this->Common_api_model->getTodayOwnRankByDate($wheredfgdg, $_REQUEST['user_id']);
                    $whereGetById = 'id=' . $_REQUEST['user_id'];
                    $user = $this->Common_api_model->getById($whereGetById, 'users');

                    $currentUser->score = (int)$currentUser->score;
                    unset($currentUser->user_id);
                    unset($currentUser->id);
                    $currentUser->id = $_REQUEST['user_id'];
                    $currentUser->profile_img = get_image_path($user['profile_img'], 'users');
                    $currentUser->fullname = $user['fullname'];
                }
            } else {

                $where = '';
                $result = $this->Common_api_model->getAllRankByUserId($where);

                $data = [];
                foreach ($result as $key => $value) {
                    $where = 'id=' . $value['id'];
                    $user = $this->Common_api_model->getById($where, 'users');
                    $value['score'] = (int) round($value['total_score']);
                    
                    $value['profile_img'] = '';
                    if (isset($user['id'])) {
                        $value['profile_img'] = get_image_path($user['profile_img'], 'users');
                        $value['name'] = $user['fullname'];
                        $value['user_total_score'] = round($user['total_score']);
                    }
                    $data[] = $value;
                }

                $currentUser = (object) [];
                if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
                    $currentUser = $this->getCurrentRankByUserId($_REQUEST['user_id']);

                }
            }

            $res = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $data, 'user' => $currentUser);
            echo json_encode($res);
            exit;
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function getPractiseLeaderBoard() {
        try {

            $where = '';
            $result = $this->Common_api_model->getAllPractiseRankByUserId($where);

            $data = [];
            foreach ($result as $key => $value) {
                $where = 'id=' . $value['id'];
                $user = $this->Common_api_model->getById($where, 'users');
                $value['score'] = (int) round($value['pratice_quiz_score']);
                
                $value['profile_img'] = '';
                if (isset($user['id'])) {
                    $value['profile_img'] = get_image_path($user['profile_img'], 'users');
                    $value['name'] = $user['fullname'];
                    $value['user_total_score'] = round($user['pratice_quiz_score']);
                }
                $data[] = $value;
            }

            $currentUser = (object) [];
            if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
                $currentUser = $this->Common_api_model->getCurrentPractiseRankByUserId($_REQUEST['user_id']);
                $currentUser->profile_img = get_image_path($currentUser->profile_img, 'users');
                $currentUser->total_score = (int) round($currentUser->total_score);

            }
            
            $res = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $data, 'user' => $currentUser);
            echo json_encode($res);
            exit;
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function RecentQuizByUser() {
        try {
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

            if ($user_id) {
                $result = $this->Common_api_model->RecentQuizByUser($user_id);

                $data = [];
                foreach ($result as $key => $value) {

                    $win_status = 'lose';
                    if ($value->correct_answers >= $value->win_question_count) {
                        $win_status = 'win';
                    }

                    $value->profile_img = get_image_path($value->profile_img, 'users');
                    $value->win_status = $win_status;
                    $data[] = $value;
                }

                $res = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $data);
                echo json_encode($res);
                exit;
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function getCurrentRankByUserId($user_id) {
        if ($user_id) {
            $result = $this->Common_api_model->getCurrentRankByUserId($user_id);
            $result->profile_img = get_image_path($result->profile_img, 'users');
            return $result;
        } else {
            return false;
        }
    }
    public function getContest() {
        date_default_timezone_set('Asia/Kolkata');
        try {
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $response = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($response);
                exit;
            } else {

            	$user_id = isset($_REQUEST['user_id']) ? trim($_REQUEST['user_id']) : 0;

                $where = "";
                $listType = isset($_POST['list_type']) ? trim($_POST['list_type']) : 'all';

                $date = date('Y-m-d H:i:s');
                if ($listType == 'current') {
                    $where .= ' `start_date` <= "' . $date . '" AND `end_date` >= "' . $date . '" AND wallet_transaction.user_id='.$user_id;
                } elseif ($listType == 'past') {
                    $where .= ' `end_date` <= "' . $date . '" AND wallet_transaction.user_id='.$user_id;
                  
                } elseif ($listType == 'upcoming') {
                    $where .= ' `start_date` >= "' . $date . '"';
                }

            	if($listType != 'upcoming'){
	                $table = 'contest_master';
	                $data['page_limit'] = '1000';
	                $data['page_no'] = isset($_REQUEST['page_no']) ? trim($_REQUEST['page_no']) : 1;
	                $data['order_by'] = 'DESC';
	                $data['order_by_field'] = $table . '.id';

	                // Join data
	               	$joinArray[] = ['join' => 'contest_master.id=wallet_transaction.contest_id', 'table' => 'wallet_transaction'];
	                $where = array($where);
	                $data['field'] = $table . '.*';
	                $data['table'] = $table;
	                $data['joins'] = $joinArray;
	                $data['where'] = $where;
	                $contest = $this->Common_api_model->get_join($data);

	            }else
	            {
					$contest = $this->Common_api_model->get($where, 'contest_master');

					$contest = json_decode(json_encode($contest));
	            }
                
                $result = array();
                foreach ($contest as $row) {
                    $row->is_buy = 0;
                    $row->is_played = 0;
                    if (isset($_POST['user_id']) && $_POST['user_id'] != '') {
                        $whereWallet = 'user_id="' . $_POST['user_id'] . '" AND contest_id="' . $row->id . '"';

                        $contest = $this->Common_api_model->getById($whereWallet, 'wallet_transaction');
                        if (isset($contest['id'])) {
                            $row->is_buy = 1;
                        }

                        $contest_save_report = $this->Common_api_model->getById($whereWallet, 'contest_save_report');
                        if (isset($contest_save_report['id'])) {
                            $row->is_played = 1;
                        }
                    }

                    $row->image = get_image_path($row->image, 'contest');
                    $result[] = $row;
                }
                if (sizeof($result) > 0) {
                    $response = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $result);
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function  UpcomingContest() {
        date_default_timezone_set('Asia/Kolkata');
        try {
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $response = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($response);
                exit;
            } else {
                $where = "";
                $date = date('Y-m-d H:i:s');
                $where .= ' `start_date` >= "' . $date . '"';
               
                $contest = $this->Common_api_model->get($where, 'contest_master');
                $result = array();
                foreach ($contest as $row) {
                    $row['is_buy'] = 0;
                    $row['is_played'] = 0;
                    if (isset($_POST['user_id']) && $_POST['user_id'] != '') {
                        $whereWallet = 'user_id="' . $_POST['user_id'] . '" AND contest_id="' . $row['id'] . '"';

                        $contest = $this->Common_api_model->getById($whereWallet, 'wallet_transaction');
                        if (isset($contest['id'])) {
                            $row['is_buy'] = 1;
                            $row['image'] = get_image_path($row['image'], 'contest');
                            $result[] = $row;
                        }                      
                    }                   
                }
                if (sizeof($result) > 0) {
                    $response = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $result);
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function getQuestionByContest() {
        try {
            $this->form_validation->set_rules('contest_id', 'contest_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $response = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($response);
                exit;
            } else {
                ///echo "<pre>";print_r($_REQUEST);die;
                $contestId = trim($_REQUEST['contest_id']);

                $table = 'question';
                $user_id = isset($_REQUEST['user_id']) ? trim($_REQUEST['user_id']) : 0;
                $data['page_limit'] = '10';
                $data['page_no'] = isset($_REQUEST['page_no']) ? trim($_REQUEST['page_no']) : 1;
                $data['order_by'] = 'RANDOM';
                $data['order_by_field'] = $table . '.id';

                // Join data
                $joinArray = [];
                $where = array($table . '.contest_id="' . $contestId . '"');
                $data['field'] = $table . '.*';
                $data['table'] = $table;
                $data['joins'] = $joinArray;
                $data['where'] = $where;

                $result = $this->Common_api_model->get_join($data);
                //echo "<pre>";print_r($result);die;
                if (count($result) > 0) {
                    $dataResult = [];
                    foreach ($result as $key => $value) {
                        if ($value->image) {
                            $value->image = base_url() . 'assets/images/question/' . $value->image;
                        }
                        $dataResult[] = $value;
                    }

                    $response = array('status' => 200, 'result' => $dataResult, 'message' => $this->lang->line('successfully_get'));
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function saveContestQuestionReport() {
        try {
            $this->form_validation->set_rules('contest_id', 'contest_id', 'required');
            $this->form_validation->set_rules('questions_attended', 'questions_attended', 'required');
            $this->form_validation->set_rules('total_questions', 'total_questions', 'required');
            $this->form_validation->set_rules('correct_answers', 'correct_answers', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('question_json', 'question_json', 'required');

            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                //echo "<pre>";print_r($_POST);die;
                $contestId = trim($_REQUEST['contest_id']);
                $where = 'id=' . $contestId;
                $result = $this->Common_api_model->getById($where, 'contest_master');
                if (isset($result['id'])) {
                    $levelId = $result['level_id'];
                    $where = 'id=' . $levelId;
                    $levelData = $this->Common_api_model->getById($where, 'level');

                    $score = $levelData['score'];
                    $totalQuestions = trim($_POST['total_questions']);

                    // $per = (100 * trim($_POST['correct_answers'])) / $totalQuestions;
                    // $finalScore = (100 * $per) / $score;


                   
                    $per=  $score / $totalQuestions;                    
                    $finalScore =  $per * $_POST['correct_answers'];



                    if ($levelData['win_question_count'] > trim($_POST['correct_answers'])) {
                        $isUnlock = 0;
                    } else {
                        $isUnlock = 1;
                    }
                    $data['contest_id'] = $contestId;
                    $data['questions_attended'] = trim($_POST['questions_attended']);
                    $data['total_questions'] = trim($_POST['total_questions']);
                    $data['correct_answers'] = trim($_POST['correct_answers']);
                    $data['user_id'] = trim($_POST['user_id']);
                    $data['score'] = (int) round($finalScore);
                    $data['is_unlock'] = $isUnlock;
                    $data['question_json'] = $_POST['question_json'];
                    $data['date'] = date('Y-m-d');
                    //echo "<pre>";print_r($data);die;

                    if( $isUnlock == 1){                        
                        $result = $this->Common_api_model->insert($data, 'contest_save_report');
                        $setting = $this->Common_api_model->settings_data();
                        foreach ($setting as $set) {
                            $setn[$set->key] = $set->value;
                        }
                        $total_score = (int) round($setn['total_score']);
                        $total_score_point = (int) round($setn['total_score_point']);
                        $totalPointArray = ($finalScore * $total_score_point) / $total_score;
                        $total_points = (int) $totalPointArray;

                        $earn_transaction['user_id'] = $_POST['user_id'];
                        $earn_transaction['contest_id'] = $contestId;
                        $earn_transaction['point'] = $total_points;
                        $earn_transaction['type'] = 1;

                        $result = $this->Common_api_model->insert($earn_transaction, 'earn_transaction');

                        $this->Common_api_model->updateByIdWithcount($_REQUEST['user_id'], 'total_points', $total_points, 'users');
                        $this->Common_api_model->updateByIdWithcount($_REQUEST['user_id'], 'total_score', $finalScore, 'users');
                    }
                    if (isset($result) && $result > 0) {
                        $response = array('status' => 200, 'message' => "Record add Successfully");
                    } else {
                        $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                    }
                    echo json_encode($response);
                } else {
                    $response = array('status' => 400, 'message' => 'Level not found');
                    echo json_encode($response);
                }
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function get_review_question_by_contest_id() {
        try {
            $this->form_validation->set_rules('contest_id', 'contest_id', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');

            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $table = 'contest_save_report';
                $data['page_limit'] = $this->config->item('page_limit');
                $data['page_no'] = isset($_REQUEST['page_no']) ? $_REQUEST['page_no'] : 1;
                $data['order_by'] = 'DESC';
                $data['group_by'] = 'contest_save_report.contest_id';
                $data['order_by_field'] = $table . '.id';

                // Join data
                $joinArray[] = ['join' => 'contest_master.id=contest_save_report.contest_id', 'table' => 'contest_master'];
                $joinArray[] = ['join' => 'level.id=contest_master.level_id', 'table' => 'level'];
              
                $date = date('Y-m-d');
                $where = array($table . '.user_id="' . $_POST['user_id'] . '" AND `contest_id` = "' . $_POST['contest_id'] . '"');
                $data['field'] = 'contest_save_report.*,contest_master.name,level.name as level_name,level.level_order';
                $data['table'] = $table;
                $data['joins'] = $joinArray;
                $data['where'] = $where;
                $result = $this->Common_api_model->get_join($data);

                $datas = [];
                foreach ($result as $row) {
                    // $row->image = get_image_path($row->image, 'tournament');
                    $questions = json_decode($row->question_json);
                    $question_json = [];
                        

                    foreach ($questions as $questionRow) {
                            
                    	
	                        $whereQuestion = "id=" . $questionRow->id;
	                        $questionResult = $this->Common_api_model->getById($whereQuestion, 'question');
                            
	                        if(isset($questionResult['id'])){
    	                        $questionResult['image'] = get_image_path($questionResult['image'], 'question');
    	                        $questionResult['user_answer'] = $questionRow->user_answer;
    	                        $question_json[] = $questionResult;
                    		}
                    }

                    $row->question_list = $question_json;

                    unset($row->question_json);

                    $datas[] = $row;
                }
                if (count($result) > 0) {
                    $response = array('status' => 200, 'message' => 'Record get success', 'result' => $result);
                } else {
                    $response = array('status' => 400, 'message' => 'Record not found');
                }
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function joinContest(){
        try {
            $this->form_validation->set_rules('contest_id', 'contest_id', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {

                    $where = 'id=' . $_REQUEST['user_id'];
                    $user = $this->Common_api_model->getById($where, 'users');
                    
                    $coin = isset($_POST['coin']) ? $_POST['coin'] : '0';

                    if($coin > $user['total_points']){
                        $array = array('status' => 400, 'message' => 'Please recharge your wallet');
                        echo json_encode($array);exit;                   
                    }

                    $data['contest_id'] = $_POST['contest_id'];
                    $data['user_id'] = $_POST['user_id'];
                    $data['coin'] = $coin;
                    $result = $this->Common_api_model->insert($data, 'wallet_transaction');
                   
                    $this->Common_api_model->subByIdWithcount($_REQUEST['user_id'], 'total_points', $coin, 'users');
                    if (isset($result) && $result > 0) {
                        $response = array('status' => 200, 'message' => "You have successfully joined.");
                    } else {
                        $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                    }
                    echo json_encode($response);
               
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }    
    }

    public function getContestLeaderBoard() {
        try {
            $this->form_validation->set_rules('contest_id', 'contest_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $date = date('Y-m-d');
                $contestId = $_REQUEST['contest_id'];
                $type = isset($_POST['type']) ? $_POST['type'] : '';
                if ($type == "today") {
                    $where = 'date="' . $date . '" AND contest_id=' . $contestId;
                } else {
                    $where = 'contest_id=' . $contestId;
                }
                $resultTodayRank = $this->Common_api_model->getContestTenRankByDate($where);
                //echo "<pre>";print_r($resultTodayRank);die;
                $data = [];
                foreach ($resultTodayRank as $key => $value) {

                    $where = 'id=' . $value['user_id'];
                    $user = $this->Common_api_model->getById($where, 'users');
                    $value['score'] = (int) round($value['score']);

                    $value['profile_img'] = '';
                    if (isset($user['id'])) {
                        $value['profile_img'] = get_image_path($user['profile_img'], 'users');
                        $value['name'] = $user['fullname'];
                        $value['user_total_score'] = (int) round($user['total_score']);
                    }
                    $data[] = $value;
                }

                $currentUser = (object) [];
                if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
                    $whereContestLeaderboard = 'date="' . $date . '" AND user_id=' . $_REQUEST['user_id'];
                    $orderByField = 'id';
                    $result = $this->Common_api_model->get($whereContestLeaderboard, 'contest_leaderboard', $orderByField, 'DESC', '1');

                    $score = 0;
                    if (isset($result[0]['id'])) {
                        $score = (int) round($result[0]['score']);
                    }

                    $isUnlock = 0;
                    if (isset($result[0]['is_unlock'])) {
                        $isUnlock = $result[0]['is_unlock'];
                    }

                    $currentUser = $this->Common_api_model->getCurrentRankByUserId($_REQUEST['user_id']);
                    if (isset($currentUser->id)) {
                        $currentUser->profile_img = get_image_path($currentUser->profile_img, 'users');
                        $currentUser->total_score = (int) round($currentUser->total_score);
                        $currentUser->score = $score;
                        $currentUser->is_unlock = $isUnlock;
                    } else {
                        $currentUser = (object) array();
                    }
                }

                $response = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $data, 'user' => $currentUser);
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function get_winner_by_contest() {
        try {
            $this->form_validation->set_rules('contest_id', 'contest_id', 'required');

            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $table = 'winners';
                $data['page_limit'] = $this->config->item('page_limit');
                $data['page_no'] = isset($_REQUEST['page_no']) ? $_REQUEST['page_no'] : 1;
                $data['order_by'] = 'ASC';
                $data['order_by_field'] = $table . '.rank';

                // Join data
                $joinData = ['users'];
                $joinArray[] = ['join' => 'users.id=' . $table . '.user_id', 'table' => 'users'];

                $date = date('Y-m-d');
                $where = array('`contest_id` = "' . $_POST['contest_id'] . '"');
                $data['field'] = 'winners.*,users.fullname';
                $data['table'] = $table;
                $data['joins'] = $joinArray;
                $data['where'] = $where;
                $result = $this->Common_api_model->get_join($data);

                $datas = [];
                foreach ($result as $row) {
                    $datas[] = $row;
                }
                if (count($datas) > 0) {
                    $response = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $datas);
                } else {
                    $response = array('status' => 400, 'message' => 'Record not found');
                }
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function get_pratice_level() {
        try {
            $whereConditions = '';
            $getPraticeLevel = $this->Common_model->get($whereConditions, 'pratice_question');
            $categoryIdArr =$newData= array();
            for ($g = 0; $g < count($getPraticeLevel); $g++) {
                $categoryIdArr[] = $getPraticeLevel[$g]->category_id;
            }
            if (count($categoryIdArr) > 0) {
                $whereConditions = '';
                $getCategory = $this->Common_model->get($whereConditions, 'category');
                for($f=0;$f<count($getCategory);$f++){
                    if(in_array($getCategory[$f]->id,$categoryIdArr)){
                        $newData[] = $getCategory[$f];
                    }
                }
                //print_r($newData);die;
                $response = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $getCategory);
                //print_r($getCategory);die;
            } else {
                $response = array('status' => 400, 'message' => 'Record not found');
            }
            echo json_encode($response);
            exit;
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function get_earn_transaction(){
        try {
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
               
                $userId = trim($_REQUEST['user_id']);
                $whereUserId = 'user_id="' . $userId . '"';
                $earn_transaction = $this->Common_api_model->get($whereUserId, 'earn_transaction');
                $datas = [];
                foreach ($earn_transaction as $key => $value) {
                    $contest_name = '';
                    if($value['contest_id'] > 0)
                    {
                        $whereContest = 'id='.$value['contest_id'];
                        $contest_master = $this->Common_api_model->getById($whereContest, 'contest_master');                        
                        
                        if(isset($contest_master['name'])){
                            $contest_name =$contest_master['name'];
                        }
                    }
                    $value['contest_name'] = $contest_name;

                    $datas[] = $value;

                }
                
                if(count($datas) > 0){
                    $response = array('status' => 200, 'result' => $datas, 'message' => $this->lang->line('successfully_get'));
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
               
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            return true;
        }
    }

    // Practice match API
   

    public function getCategoryByLevelMaster()
    {
        try {

            $this->form_validation->set_rules('question_level_master_id', 'question_level_master_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {

                $table = 'question';
                $data['page_limit'] = $this->config->item('page_limit');
                $data['page_no'] = isset($_REQUEST['page_no']) ? $_REQUEST['page_no'] : 1;
                $data['order_by'] = 'DESC';
                $data['group_by'] = 'category_id';
                $data['order_by_field'] = 'category.id';

                // Join data
                $joinData = ['category'];
                foreach ($joinData as $value) {
                    $joinArray[] = ['join' => $value . '.id=' . $table . '.' . $value . '_id', 'table' => $value];
                }

                $where = array($table . '.contest_id=0 AND question_level_master_id='.$_POST['question_level_master_id']);
                $data['field'] = 'category.*';
                $data['table'] = $table;
                $data['joins'] = $joinArray;
                $data['where'] = $where;
                $result = $this->Common_api_model->get_join($data);

                 $datas = array();
                foreach ($result as $key => $value) {
                    $value->image = get_image_path($value->image, 'category');

                    $datas[] = $value;
                }

                $response = array('status' => 200, 'result' => $datas, 'message' => $this->lang->line('successfully_get'));
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function getLavelByCategoryId() {
        try {
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $categoryId = trim($_REQUEST['category_id']);
                $table = 'question';
                $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
                $data['page_limit'] = $this->config->item('page_limit');
                $data['page_no'] = isset($_REQUEST['page_no']) ? $_REQUEST['page_no'] : 1;
                $data['order_by'] = 'ASC';
                $data['group_by'] = 'level_id';
                $data['order_by_field'] = 'level.level_order';

                // Join data
                $joinData = ['level'];
                foreach ($joinData as $value) {
                    $joinArray[] = ['join' => $value . '.id=' . $table . '.' . $value . '_id', 'table' => $value];
                }

                $where = array($table . '.category_id="' . $categoryId . '" AND ' . $table . '.contest_id=0');
                // $data['field'] = 'level.*,count(question.id) as total_question,question.category_id';
                $data['field'] = 'level.*,question.category_id';
                $data['table'] = $table;
                $data['joins'] = $joinArray;
                $data['where'] = $where;
                $result = $this->Common_api_model->get_join($data);

                if (count($result) > 0) {

                    $levelCat = [];
                    foreach ($result as $value) {
                        $levelCat[$value->level_order] = $value;
                    }

                    $i = 0;
                    foreach ($levelCat as $key => $value) {
                        $value->is_unlock = isset($value->is_unlock) ? $value->is_unlock : 0;

                        $whereContestLeaderboard = 'user_id="' . $user_id . '" AND level_id=' . $value->id . ' AND category_id=' . $categoryId . ' AND is_unlock=1';
                        $orderByField = 'id';

                        $resultData = $this->Common_api_model->get($whereContestLeaderboard, 'contest_leaderboard', $orderByField, 'DESC', '1');


                        if (count($resultData) > 0) {

                            $keySearchResult = array_search($key, array_column($result, 'level_order'));

                            if ($keySearchResult) {
                                $result[$keySearchResult]->is_unlock = 1;
                            }
                        } else {
                            if ($i == 0) {
                                $keySearchResult = array_search($key, array_column($result, 'level_order'));

                                if ($keySearchResult) {
                                    $result[$keySearchResult]->is_unlock = 1;
                                }
                                $i++;
                            }
                        }
                    }

                    if ($result[0]->level_order) {
                        $result[0]->is_unlock = 1;
                    }
                }


                if (isset($result) && $result > 0) {
                    $response = array('status' => 200, 'result' => $result, 'message' => $this->lang->line('successfully_get'));
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function getQuestionByLavel() {
        try {
            $this->form_validation->set_rules('level_id', 'level_id', 'required');
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $response = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($response);
                exit;
            } else {
                $levelId = trim($_REQUEST['level_id']);
                $categoryId = trim($_REQUEST['category_id']);

                $table = 'question';
                $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
                $data['page_limit'] = '10';
                $data['page_no'] = isset($_REQUEST['page_no']) ? $_REQUEST['page_no'] : 1;
                $data['order_by'] = 'RANDOM';
                $data['order_by_field'] = $table . '.id';

                // Join data
                $joinArray = [];
                $where = array($table . '.category_id="' . $categoryId . '" AND ' . $table . '.level_id="' . $levelId . '" AND contest_id=0');
                $data['field'] = $table . '.*';
                $data['table'] = $table;
                $data['joins'] = $joinArray;
                $data['where'] = $where;

                $result = $this->Common_api_model->get_join($data);

                if (count($result) > 0) {
                    $dataResult = [];
                    foreach ($result as $key => $value) {
                        if ($value->image) {
                            $value->image = base_url() . 'assets/images/question/' . $value->image;
                        }
                        $dataResult[] = $value;
                    }

                    $response = array('status' => 200, 'result' => $dataResult, 'message' => $this->lang->line('successfully_get'));
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }


    public function get_transaction(){
        try {
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
               
                $userId = trim($_REQUEST['user_id']);
                $whereUserId = 'user_id="' . $userId . '"';
                $earn_transaction = $this->Common_api_model->get($whereUserId, 'wallet_transaction');
                $datas = [];
                foreach ($earn_transaction as $key => $value) {
                    $contest_name = '';
                    if($value['contest_id'] > 0)
                    {
                        $whereContest = 'id='.$value['contest_id'];
                        $contest_master = $this->Common_api_model->getById($whereContest, 'contest_master');                        
                        
                        if(isset($contest_master['name'])){
                            $contest_name =$contest_master['name'];
                        }
                    }
                    $value['contest_name'] = $contest_name;

                    $datas[] = $value;

                }
                
                if(count($datas) > 0){
                    $response = array('status' => 200, 'result' => $datas, 'message' => $this->lang->line('successfully_get'));
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
               
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            return true;
        }
    }
    
    //Practice 

     public function getPraticeCategoryByLevelMaster()
    {
        try {

            $this->form_validation->set_rules('question_level_master_id', 'question_level_master_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {

                $table = 'pratice_question';
                $data['page_limit'] = $this->config->item('page_limit');
                $data['page_no'] = isset($_REQUEST['page_no']) ? $_REQUEST['page_no'] : 1;
                $data['order_by'] = 'DESC';
                $data['group_by'] = 'category_id';
                $data['order_by_field'] = 'category.id';

                // Join data
                $joinData = ['category'];
                foreach ($joinData as $value) {
                    $joinArray[] = ['join' => $value . '.id=' . $table . '.' . $value . '_id', 'table' => $value];
                }

                $where = array('question_level_master_id='.$_POST['question_level_master_id']);
                $data['field'] = 'category.*';
                $data['table'] = $table;
                $data['joins'] = $joinArray;
                $data['where'] = $where;
                $result = $this->Common_api_model->get_join($data);

                 $datas = array();
                foreach ($result as $key => $value) {
                    $value->image = get_image_path($value->image, 'category');

                    $datas[] = $value;
                }

                $response = array('status' => 200, 'result' => $datas, 'message' => $this->lang->line('successfully_get'));
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function getPracticeQuestionByLavel() {
        try {
            $this->form_validation->set_rules('question_level_master_id', 'question_level_master_id', 'required');
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $response = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($response);
                exit;
            } else {
                $levelId = trim($_REQUEST['question_level_master_id']);
                $categoryId = trim($_REQUEST['category_id']);

                $table = 'pratice_question';
                $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
                $data['page_limit'] = '10';
                $data['page_no'] = isset($_REQUEST['page_no']) ? $_REQUEST['page_no'] : 1;
                $data['order_by'] = 'RANDOM';
                $data['order_by_field'] = $table . '.id';

                // Join data
                $joinArray = [];
                $where = array($table . '.category_id="' . $categoryId . '" AND ' . $table . '.question_level_master_id="' . $levelId . '" ');
                $data['field'] = $table . '.*';
                $data['table'] = $table;
                $data['joins'] = $joinArray;
                $data['where'] = $where;

                $result = $this->Common_api_model->get_join($data);

                if (count($result) > 0) {
                    $dataResult = [];
                    foreach ($result as $key => $value) {
                        if ($value->image) {
                            $value->image = base_url() . 'assets/images/question/' . $value->image;
                        }
                        $dataResult[] = $value;
                    }

                    $response = array('status' => 200, 'result' => $dataResult, 'message' => $this->lang->line('successfully_get'));
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function savePracticeQuestionReport() {
        try {
            $this->form_validation->set_rules('level_id', 'level_id', 'required');
            $this->form_validation->set_rules('questions_attended', 'questions_attended', 'required');
            $this->form_validation->set_rules('total_questions', 'total_questions', 'required');
            $this->form_validation->set_rules('correct_answers', 'correct_answers', 'required');
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            $this->form_validation->set_rules('user_id', 'user_id', 'required');

            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);

                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $levelId = trim($_REQUEST['level_id']);
                $where = 'id=' . $levelId;
                $result = $this->Common_api_model->getById($where, 'level');
                $question_level_master_id = isset($_REQUEST['question_level_master_id']) ? $_REQUEST['question_level_master_id'] : 0;

                if (isset($result['id'])) {
                    $score = (int) round($result['score']);

                    $totalQuestions = $_POST['total_questions'];

                    // $per = (100 * $_POST['correct_answers']) / $totalQuestions;
                    // $finalScore =  $per / $score;

                    $per =  $score / $totalQuestions;                    
                    $finalScore =  $per * $_POST['correct_answers'];


                    if ($result['win_question_count'] > $_POST['correct_answers']) {
                        $isUnlock = 0;
                    } else {

                        $isUnlock = 1;
                    }

                    $data['level_id'] = $levelId;
                    $data['question_level_master_id'] = $question_level_master_id;
                    $data['questions_attended'] = $_POST['questions_attended'];
                    $data['total_questions'] = $_POST['total_questions'];
                    $data['correct_answers'] = $_POST['correct_answers'];
                    $data['user_id'] = $_POST['user_id'];
                    $data['category_id'] = $_POST['category_id'];
                    $data['score'] = (int) round($finalScore);
                    $data['is_unlock'] = $isUnlock;
                    $data['date'] = date('Y-m-d');
                    $result = $this->Common_api_model->insert($data, 'pratice_leaderboard');

                    $setting = $this->Common_api_model->settings_data();
                    foreach ($setting as $set) {
                        $setn[$set->key] = $set->value;
                    }

                    $total_score = (int) round($setn['total_score']);
                    $total_score_point = $setn['total_score_point'];
                    $totalPointArray = ($finalScore * $total_score_point) / $total_score;
                    $total_points = (int) round($totalPointArray);

                    $earn_transaction['user_id'] = $_POST['user_id'];
                    $earn_transaction['contest_id'] = 0;
                    $earn_transaction['point'] = $total_points;
                    $earn_transaction['type'] = 2;
                    $result = $this->Common_api_model->insert($earn_transaction, 'earn_transaction');

                    // $this->Common_api_model->updateByIdWithcount($_REQUEST['user_id'], 'total_points', $total_points, 'users');
                    // $this->Common_api_model->updateByIdWithcount($_REQUEST['user_id'], 'total_score', $finalScore, 'users');
                    $this->Common_api_model->updateByIdWithcount($_REQUEST['user_id'], 'pratice_quiz_score', $finalScore, 'users');
                   
                    if (isset($result) && $result > 0) {
                        $response = array('status' => 200, 'message' => "Record add Successfully");
                    } else {
                        $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                    }
                    echo json_encode($response);
                } else {
                    $response = array('status' => 400, 'message' => 'Level not found');
                    echo json_encode($response);
                }
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function getLevelMaster()
    {
        try {
            $table = 'pratice_question';
            $data['page_limit'] = $this->config->item('page_limit');
            $data['page_no'] = isset($_REQUEST['page_no']) ? $_REQUEST['page_no'] : 1;
            $data['order_by'] = 'ASC';
            $data['group_by'] = 'question_level_master_id';
            $data['order_by_field'] = 'question_level_master.level_order';

            // Join data
            $joinData = ['question_level_master'];
            foreach ($joinData as $value) {
                $joinArray[] = ['join' => $value . '.id=' . $table . '.' . $value . '_id', 'table' => $value];
            }

            $where = array();
            $data['field'] = 'question_level_master.*';
            $data['table'] = $table;
            $data['joins'] = $joinArray;
            $data['where'] = $where;
            $result = $this->Common_api_model->get_join($data);

            $response = array('status' => 200, 'result' => $result, 'message' => $this->lang->line('successfully_get'));
            
            echo json_encode($response);
            exit;
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function getPracticeLavelByCategoryId() {
        try {
            $this->form_validation->set_rules('category_id', 'category_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $categoryId = trim($_REQUEST['category_id']);
                $table = 'pratice_question';
                $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
                $data['page_limit'] = $this->config->item('page_limit');
                $data['page_no'] = isset($_REQUEST['page_no']) ? $_REQUEST['page_no'] : 1;
                $data['order_by'] = 'ASC';
                $data['group_by'] = 'level_id';
                $data['order_by_field'] = 'level.level_order';

                // Join data
                $joinData = ['level'];
                foreach ($joinData as $value) {
                    $joinArray[] = ['join' => $value . '.id=' . $table . '.' . $value . '_id', 'table' => $value];
                }

                $where = array($table . '.category_id="' . $categoryId . '"');
                $data['field'] = 'level.*,pratice_question.category_id';
                $data['table'] = $table;
                $data['joins'] = $joinArray;
                $data['where'] = $where;
                $result = $this->Common_api_model->get_join($data);

                if (count($result) > 0) {

                    $levelCat = [];
                    foreach ($result as $value) {
                        $levelCat[$value->level_order] = $value;
                    }

                    $i = 0;
                    foreach ($levelCat as $key => $value) {
                        $value->is_unlock = isset($value->is_unlock) ? $value->is_unlock : 0;

                        $whereContestLeaderboard = 'user_id="' . $user_id . '" AND level_id=' . $value->id . ' AND category_id=' . $categoryId . ' AND is_unlock=1';
                        $orderByField = 'id';

                        $resultData = $this->Common_api_model->get($whereContestLeaderboard, 'contest_leaderboard', $orderByField, 'DESC', '1');


                        if (count($resultData) > 0) {

                            $keySearchResult = array_search($key, array_column($result, 'level_order'));

                            if ($keySearchResult) {
                                $result[$keySearchResult]->is_unlock = 1;
                            }
                        } else {
                            if ($i == 0) {
                                $keySearchResult = array_search($key, array_column($result, 'level_order'));

                                if ($keySearchResult) {
                                    $result[$keySearchResult]->is_unlock = 1;
                                }
                                $i++;
                            }
                        }
                    }
                    
                    $result[0]->is_unlock = 0;
                }


                if (isset($result) && $result > 0) {
                    $response = array('status' => 200, 'result' => $result, 'message' => $this->lang->line('successfully_get'));
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                }
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }


    public function checkStatus()
    {
        if ((isset($_POST['purchase_code']) && $_POST['purchase_code'] != '') and (isset($_POST['package_name']) && $_POST['package_name'] != '')) {
            $url = 'https://divinetechs.com/envato/secureapi/checkStatus.php';
            $envento['purchase_code'] = $_POST['purchase_code'];
            $envento['package_name'] = $_POST['package_name'];
            $envento['base_url'] = $this->config->item('base_url');
            $response = curl($url, $envento);
            
            
            if (isset($response->status) && $response->status == 200) {
                $res = array('status' => 200, 'message' => $response->message);
                echo json_encode($res);exit;
            } else {
                
                if(isset($response->message)){
                    $res = array('status' => 400, 'message' => $response->message);
                    echo json_encode($res);exit;
                }else
                {
                    $res = array('status' => 400, 'message' => "Please check your server your server on something wrong.");
                    echo json_encode($res);exit;
                }
            }
        } else {
            $res = array('status' => 400, 'message' => 'Please enter required field');
            echo json_encode($res);exit;
        }
    }
}