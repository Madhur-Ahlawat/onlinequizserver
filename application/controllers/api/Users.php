<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common_api_model');
        $this->lang->load('english_lang', 'english');
        $this->load->library('email');
    }

    public function login() {
        try {
           
            $this->form_validation->set_rules('email', 'email', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                if (isset($_REQUEST['email'])) {
                    $email = $_REQUEST['email'];
                    $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
                    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
                    
                    if ($type == '2') {
                        $where = 'email="' . $email . '"';
                        $userData = $this->Common_api_model->getById($where, 'users');
                        if (isset($userData['id'])) {

                            // Create a  blank token
                            $deviceToken = $_POST['device_token'];
                            $data = array(
                                'device_token' => '',
                            );
                            $this->Common_api_model->updateById($deviceToken, 'device_token', $data, 'users');

                            // Update a new token
                            $deviceToken = isset($_REQUEST['device_token']) ? $_REQUEST['device_token'] : '';
                            $dataDeviceToken = array(
                                'device_token' => $deviceToken,
                            );
                            $this->Common_api_model->updateById($userData['id'], 'id', $dataDeviceToken, 'users');

                            // Facebook User Login
                            $userData['profile_img'] = base_url() . 'assets/images/users/' . $userData['profile_img'];
                            $userData['user_type'] = 'login'; // login, register

                            if (isset($userData['id'])) {

                                $settinglist = get_setting();
                                foreach ($settinglist as $set) {
                                    $setn[$set->key] = $set->value;
                                }

                                $mail['user'] = $userData;
                                $mail['setn'] = $setn;
                                $user_data = $this->load->view("admin/email/login", $mail, true);
                                $subject = "You have login successfully";
                                // $email ='patelsanjay.it@gmail.com';
                                $email = $userData['email'];
                                $this->send_mail($user_data, $email, $subject);
                            }

                            $response = array('status' => 200, 'message' => $this->lang->line('login_success'), 'result' => array($userData));
                            echo json_encode($response);
                            exit;
                        } else {

                            // Facebook User Register
                            $email = $_REQUEST['email'];
                            $firstName = isset($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '';
                            $lastName = isset($_REQUEST['last_name']) ? $_REQUEST['last_name'] : '';
                            $mobileNumber = isset($_REQUEST['mobile_number']) ? $_REQUEST['mobile_number'] : '';
                            $deviceToken = isset($_REQUEST['device_token']) ? $_REQUEST['device_token'] : '';

                            $profileImg = '';
                            if (isset($_FILES['profile_img']['name'])) {
                                $profileImg = $this->Common_api_model->imageupload($_FILES['profile_img'], 'profile_img', FCPATH . 'assets/images/users');
                            }

                            $data = array(
                                'first_name' => $firstName,
                                'last_name' => $lastName,
                                'fullname' => $firstName . ' ' . $lastName,
                                'username' => user_name($firstName),
                                'email' => $_REQUEST['email'],
                                'type' => $type,
                                'reference_code' => uniqid(),
                                'biodata' => '',
                                'mobile_number' => $mobileNumber,
                                'profile_img' => $profileImg,
                                'device_token' => $deviceToken,
                            );

                            $userId = $this->Common_api_model->insert($data, 'users');
                            unset($data['password']);
                            $data['id'] = $userId;

                            $data['profile_img'] = '';
                            $data['user_type'] = 'register'; // login, register

                            $where = 'id="' . $userId . '"';
                            $userData = $this->Common_api_model->getById($where, 'users');
                            if (isset($userData['id'])) {

                                $settinglist = get_setting();
                                foreach ($settinglist as $set) {
                                    $setn[$set->key] = $set->value;
                                }

                                $mail['user'] = $userData;
                                $mail['setn'] = $setn;
                                $user_data = $this->load->view("admin/email/register", $mail, true);
                                $subject = "You have register successfully";
                                // $email ='patelsanjay.it@gmail.com';
                                $email = $userData['email'];
                                $this->send_mail($user_data, $email, $subject);
                            }

                            $response = array('status' => 200, 'message' => $this->lang->line('login_success'), 'result' => array($data));
                            echo json_encode($response);
                            exit;
                        }
                    } else {

                        $where = 'password="' . md5($password) . '" OR password="' . $password . '" AND email="' . $email . '"';
                       
                        $userData = $this->Common_api_model->getById($where, 'users');
                       
                        if (isset($userData['id'])) {

                            $basePath = $_SERVER['DOCUMENT_ROOT'];
                            $basePath .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

                            $imgURL = base_url() . 'assets/images/users/' . $userData['profile_img'];
                            if (empty($userData['profile_img'])) {
                                $imgURL = base_url() . 'assets/images/no_user.jpg';
                            }
                            if (!file_exists($basePath . '/assets/images/users/' . $userData['profile_img'])) {
                                $imgURL = base_url() . 'assets/images/no_user.jpg';
                            }
                            $userData['profile_img'] = $imgURL;

                            // Create a  blank token
                            $deviceToken = $_POST['device_token'];
                            $data = array(
                                'device_token' => '',
                            );
                            $this->Common_api_model->updateById($deviceToken, 'device_token', $data, 'users');

                            // Update a new token
                            $deviceToken = isset($_REQUEST['device_token']) ? $_REQUEST['device_token'] : '';
                            $dataDeviceToken = array(
                                'device_token' => $deviceToken,
                            );
                            $this->Common_api_model->updateById($userData['id'], 'id', $dataDeviceToken, 'users');

                            if (isset($userData['id'])) {

                                $settinglist = get_setting();
                                foreach ($settinglist as $set) {
                                    $setn[$set->key] = $set->value;
                                }

                                $mail['user'] = $userData;
                                $mail['setn'] = $setn;
                                $user_data = $this->load->view("admin/email/login", $mail, true);
                                $subject = "You have login successfully";
                                // $email ='patelsanjay.it@gmail.com';
                                $email = $userData['email'];
                                $this->send_mail($user_data, $email, $subject);
                            }

                            $response = array('status' => 200, 'message' => $this->lang->line('login_success'), 'result' => array($userData));
                            echo json_encode($response);
                            exit;
                        } else {

                            $response = array('status' => 400, 'message' => $this->lang->line('username_and_pasword_is_wrong'));
                            echo json_encode($response);
                            exit;
                        }
                    }
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('enter_email_and_pasword'));
                }
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function registration() {
        //echo "<pre>";print_r($_REQUEST);die;
        try {
            $this->form_validation->set_rules('email', 'email', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('first_name', 'first_name', 'required');
            $this->form_validation->set_rules('mobile_number', 'mobile_number', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $email = $_REQUEST['email'];
                $password = $_REQUEST['password'];
                $firstName = $_REQUEST['first_name'];
                $lastName = '';
                $mobileNumber = $_REQUEST['mobile_number'];
                $parent_reference_code = isset($_REQUEST['parent_reference_code']) ? $_REQUEST['parent_reference_code'] : '';
                $deviceToken = isset($_REQUEST['device_token']) ? $_REQUEST['device_token'] : '';

                $where = 'email="' . $email . '"';
                $userData = $this->Common_api_model->getById($where, 'users');
                    $validateReferCode = 0;
                if (!empty($parent_reference_code)) {

                    $where = 'reference_code="' . $parent_reference_code . '"';
                    $usersData = $this->Common_api_model->getById($where, 'users');
                    if (isset($usersData['id'])) {
                       $validateReferCode = $parent_reference_code;
                    }
                }

                if (isset($userData['id'])) {
                    $response = array('status' => 400, 'message' => $this->lang->line('email_name_already_exists'));
                    echo json_encode($response);
                } else {
                    $data = array(
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'fullname' => $firstName . ' ' . $lastName,
                        'username' => '',
                        'email' => $email,
                        'password' => md5($password),
                        'mobile_number' => $mobileNumber,
                        'profile_img' => 'user.png',
                        'reference_code' => uniqid(),
                        'parent_reference_code' => $validateReferCode,
                        'device_token' => $deviceToken,
                    );
                    $userId = $this->Common_api_model->insert($data, 'users');
                    $checkUserRefer = $this->checkUserReferCode($parent_reference_code, $userId);
                    unset($data['password']);
                    $data['id'] = (string) $userId;

                    $where = "id=" . $userId;
                    $userData = $this->Common_api_model->getById($where, 'users');
                    if (isset($userData['id'])) {
                        $userData['profile_img'] = base_url() . 'assets/images/users/' . $userData['profile_img'];
                    }

                    if (isset($userData['id'])) {

                        $settinglist = get_setting();
                        foreach ($settinglist as $set) {
                            $setn[$set->key] = $set->value;
                        }

                        $mail['user'] = $userData;
                        $mail['setn'] = $setn;
                        $user_data = $this->load->view("admin/email/register", $mail, true);
                        $subject = "You have register successfully";
                     
                        $email = $userData['email'];
                        $this->send_mail($user_data, $email, $subject);
                    }
                    $response = array('status' => 200, 'message' => $this->lang->line('user_registration_sucessfuly'), 'result' => array($userData));
                    echo json_encode($response);
                }
                
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function forgot_password() {
        $email = $_REQUEST['email'];
        $where = 'email="' . $email . '"';
        $result = $this->Common_api_model->getById($where, 'users');
        if (isset($result['id'])) {
            $pass = rand_password_create('8');
            $id = $result['id'];
            $data = array(
                'password' => md5($pass),
            );
            $this->Common_api_model->update($id, $data, 'users');

            $message = 'Hello ' . $result['first_name'] . ' ' . $result['last_name'] . ', <br>Your new Password is :' . $pass;
            $smtpWhere = 'id="1"';
            $smtpDetail = $this->Common_api_model->getById($smtpWhere, 'smtp_setting');
            $emailconfig = get_smtp_setting();

            $this->email->initialize($emailconfig);
            $this->email->from($smtpDetail['from_email'], $smtpDetail['from_name']);
            $this->email->to($email);
            $this->email->set_mailtype('html');
            $this->email->subject('Reset Password');
            $this->email->message($message);
            $this->email->send();

            //echo $this->email->print_debugger();
            $response = array('status' => 200, 'message' => $this->lang->line('new_password_send'));
        } else {
            $response = array('status' => 400, 'message' => $this->lang->line('email_address_is_not_registered'));
        }
        echo json_encode($response);
    }

    public function profile() {
        try {
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                if (isset($_REQUEST['user_id'])) {
                    $userId = trim($_REQUEST['user_id']);
                    $where = 'id="' . $userId . '"';
                    $user = $this->Common_api_model->getById($where, 'users');
                    if (isset($user['id'])) {


                        $whereLeaderboard = 'user_id="' . $userId . '"';
                        $contestLeaderboard = $this->Common_api_model->get($whereLeaderboard, 'contest_leaderboard', '', '', '', '', 'sum(total_questions) as total_questions,sum(questions_attended) as questions_attended,sum(correct_answers) as correct_answers,');

                        $contest_save_report = $this->Common_api_model->get($whereLeaderboard, 'contest_save_report');
                        $contest_leaderboard = $this->Common_api_model->get($whereLeaderboard, 'contest_leaderboard');

                        $user['total_played_quiz'] = count($contest_leaderboard) + count($contest_save_report);


                        $whereLeaderboard = 'parent_user_id="' . $userId . '"';
                        $parent_user_referred_point = $this->Common_api_model->get($whereLeaderboard, 'refer_earn_transaction','','','','','sum(parent_user_referred_point) as parent_user_referred_point');
                        $user['total_points_earned'] = 0;
                        if(count($parent_user_referred_point) > 0)
                        {
                           
                            $user['total_points_earned'] = isset($parent_user_referred_point[0]['parent_user_referred_point']) ? $parent_user_referred_point[0]['parent_user_referred_point'] : 0;
                        }

                        $user['player_bedge']='Silver';

                        if($user['total_points_earned'] <= '100'){
                                $user['player_bedge']='Silver';                                
                        }elseif ($user['total_points_earned'] > '200' && $user['total_points_earned'] < '500') {
                            $user['player_bedge']='Gold';
                        }elseif ($user['total_points_earned'] > '500') {
                            $user['player_bedge']='Platinum';
                        }


                        $user['total_questions'] = 0;
                        $user['questions_attended'] = 0;
                        $user['correct_answers'] = 0;

                        if ($contestLeaderboard[0]['total_questions'] != '') {
                            $user['total_questions'] = $contestLeaderboard[0]['total_questions'];
                            $user['questions_attended'] = $contestLeaderboard[0]['questions_attended'];
                            $user['correct_answers'] = $contestLeaderboard[0]['correct_answers'];
                        }

                        $user['profile_img'] = get_image_path($user['profile_img'], 'users');
                        unset($user['password']);

                        $currentUser = '';
                        if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '') {
                            $currentUser = $this->Common_api_model->getCurrentRankByUserId($userId);
                            $user['rank'] = $currentUser->rank;
                        }

                        $response = array('status' => 200, 'result' => array($user), 'message' => $this->lang->line('successfully_get'));
                    } else {
                        $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'));
                    }
                    echo json_encode($response);
                } else {
                    $response = array('status' => 400, 'message' => $this->lang->line('required_field'));
                }
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function updateprofile() {
        try {
          
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $data = array();
                $fulltname = '';
                if (isset($_REQUEST['first_name']) && $_REQUEST['first_name'] != '') {
                    $data['first_name'] = $_REQUEST['first_name'];
                    $fulltname .= $_REQUEST['first_name'];
                }

                if (isset($_REQUEST['last_name']) && $_REQUEST['last_name'] != '') {
                    $data['last_name'] = $_REQUEST['last_name'];
                    $fulltname .= ' ' . $_REQUEST['last_name'];
                }

                if ($fulltname) {
                    $data['fullname'] = $fulltname;
                }

                if (isset($_REQUEST['mobile_number']) && $_REQUEST['mobile_number'] != '') {
                    $data['mobile_number'] = $_REQUEST['mobile_number'];
                }

                if (isset($_REQUEST['instagram_url']) && $_REQUEST['instagram_url'] != '') {
                    $data['instagram_url'] = $_REQUEST['instagram_url'];
                }

                if (isset($_REQUEST['twitter_url']) && $_REQUEST['twitter_url'] != '') {
                    $data['twitter_url'] = $_REQUEST['twitter_url'];
                }

                if (isset($_REQUEST['facebook_url']) && $_REQUEST['facebook_url'] != '') {
                    $data['facebook_url'] = $_REQUEST['facebook_url'];
                }

                if (isset($_REQUEST['biodata']) && $_REQUEST['biodata'] != '') {
                    $data['biodata'] = $_REQUEST['biodata'];
                }

                if (isset($_REQUEST['address']) && $_REQUEST['address'] != '') {
                    $data['address'] = $_REQUEST['address'];
                }

                if (isset($_FILES['profile_img']['name'])) {
                    $profile_img = $this->Common_api_model->imageupload($_FILES['profile_img'], 'profile_img', FCPATH . 'assets/images/users');
                    $data['profile_img'] = $profile_img;
                }

                $where = 'id="' . $_REQUEST['user_id'] . '"';
                $user = $this->Common_api_model->getById($where, 'users');
                if (isset($user['type']) && $user['type'] ==3) {
                     if (isset($_REQUEST['email']) && $_REQUEST['email'] != '') {
                        $data['email'] = $_REQUEST['email'];
                    }
                }
                $data['is_updated'] = "1";     
                $userId = $this->Common_api_model->update($_REQUEST['user_id'], $data, 'users');

                unset($data['password']);
                $data['id'] = $userId;
                $response = array('status' => 200, 'message' => $this->lang->line('user_update_sucessfuly'));
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function password_change() {
        try {
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $password = $_REQUEST['password'];
                $data = array(
                    'password' => md5($password),
                );

                $userId = $this->Common_api_model->update($_REQUEST['user_id'], $data, 'users');

                $data['id'] = $userId;
                $response = array('status' => 200, 'message' => $this->lang->line('password_change_successfully'));
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($res);
            exit;
        }
    }

    public function send_mail($message, $email, $subject) {
        try {
            $smtpWhere = 'id="1"';
            $smtp_detail = $this->Common_api_model->getById($smtpWhere, 'smtp_setting');
            $emailconfig = get_smtp_setting();
            $this->load->library('email', $emailconfig);
            $this->email->initialize($emailconfig);
            $this->email->from($smtp_detail['from_email'], $smtp_detail['from_name']);
            $this->email->to($email);
            $this->email->set_mailtype('html');
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();
            return true;
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            return true;
        }
    }

    public function validateUserReferCode($referCode) {
        $status = 1;
        if (!empty($referCode)) {
            $whereReferCode = 'reference_code="' . $referCode . '"';

            $userslist = $this->Common_api_model->getById($whereReferCode, 'users');
            if (isset($userslist['id']) && $userslist['id'] > 0) {
                    $status = $referCode;
            } else {
                $status = 0;
            }
        }
        return $status;
    }

    public function checkUserReferCode($referCode, $userId) {
        $status = 1;
        if (!empty($referCode)) {
            $whereReferCode = 'reference_code="' . $referCode . '"';
            $userslist = $this->Common_api_model->getById($whereReferCode, 'users');
            if (isset($userslist['id']) && $userslist['id'] > 0) {
                $parentUserId = $userslist['id'];
                $whereReferType = 'type=2';
                $getNewUserPoint = $this->Common_api_model->getById($whereReferType, 'earnpoint_setting');
                $newUserPoint = $referUserPoint = 0;
                if (isset($getNewUserPoint['value'])) {
                    $newUserPoint = $getNewUserPoint['value'];
                }
                //echo "<pre>";print_r(count($newUserPoint));die;
                $whereReferType = 'type=3';
                $getReferUserPoint = $this->Common_api_model->getById($whereReferType, 'earnpoint_setting');
                if (isset($getReferUserPoint['value'])) {
                    $referUserPoint = $getReferUserPoint['value'];
                }
                //echo $newUserPoint."===".$referUserPoint;die;
                $transactionArr = $earnedPointArr = $referedPointArr = array();
                $transactionArr['parent_user_id'] = $parentUserId;
                $transactionArr['child_user_id'] = $userId;
                $transactionArr['reference_code'] = $referCode;
                $transactionArr['parent_user_referred_point'] = $referUserPoint;
                $transactionArr['child_user_earned_point'] = $newUserPoint;
                $transactionArr['earn_point_type'] = 2;
                $transactionArr['refered_date'] = date('Y-m-d');
                $transactionArr['created_at'] = date('Y-m-d h:i:s');
                $status = $this->Common_api_model->insert($transactionArr, 'refer_earn_transaction');
                //echo "<pre>";print_r($transactionArr);die;
                $earnedPointArr['total_points'] = '`total_points`+' . $newUserPoint;
                $referedPointArr['total_points'] = '`total_points`+' . $referUserPoint;
                //echo "<pre>";print_r($earnedPointArr);die;
                $this->Common_api_model->updateByIdWithcount($parentUserId, 'total_points', $newUserPoint, 'users');
                $this->Common_api_model->updateByIdWithcount($userId, 'total_points', $referUserPoint, 'users');
            } else {
                $status = 0;
            }
            return $status;
        }
    }

    public function refer_transaction() {
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
                $whereUserId = 'parent_user_id="' . $userId . '"';
                $userTransactions = $this->Common_model->get($whereUserId, 'refer_earn_transaction');

                if (count($userTransactions) > 0) {
                    $transactionArr = array();
                    for ($g = 0; $g < count($userTransactions); $g++) {
                        $childUserId = $userTransactions[$g]->child_user_id;
                        $whereUserId = 'id="' . $childUserId . '"';
                        $userDetails = $this->Common_api_model->getById($whereUserId, 'users');
                        $transactionArr[$g]['refered_point'] = $userTransactions[$g]->parent_user_referred_point;
                        $transactionArr[$g]['refered_date'] = $userTransactions[$g]->refered_date;
                        $transactionArr[$g]['reference_code'] = $userTransactions[$g]->reference_code;
                        $transactionArr[$g]['user_name'] = $userDetails['fullname'];
                        $transactionArr[$g]['email'] = $userDetails['email'];
                        $transactionArr[$g]['profile_img'] = base_url() . 'assets/images/users/' . $userDetails['profile_img'];
                        $transactionArr[$g]['mobile_number'] = $userDetails['mobile_number'];
                    }
                    $response = array('status' => 200, 'result' => $transactionArr, 'message' => $this->lang->line('successfully_get'));
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

    public function reward_points() {
        try {
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('reward_points', 'reward_points', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $userId = trim($_REQUEST['user_id']);
                $reward_points = trim($_REQUEST['reward_points']);
                $type = isset($_REQUEST['type']) ? trim($_REQUEST['type']) : 'daily';
                $typeId = 1;
                if(strtoupper($type) == "DAILY"){
                    $typeId = 0;
                }
                
                $this->Common_api_model->updateByIdWithcount($userId, 'total_points', $reward_points, 'users');
                $rewardTrans = array();
                $rewardTrans['user_id'] = $userId;
                $rewardTrans['reward_points'] = $reward_points;
                $rewardTrans['type'] = $typeId;
                $this->Common_api_model->insert($rewardTrans, 'reward_transaction');
                $response = array('status' => 200, 'message' => $this->lang->line('points_rewarded_successfully'));
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            return true;
        }
    }

    public function get_reward_points(){
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
                $reward_transaction = $this->Common_model->get($whereUserId, 'reward_transaction');

               
                if(count($reward_transaction) > 0){
                    $response = array('status' => 200, 'result' => $reward_transaction, 'message' => $this->lang->line('successfully_get'));
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

    public function get_notification() {
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
                $getReadNotificationId = $this->Common_api_model->get($whereUserId, 'user_notification_tracking');


                $notificationArr = array();
                foreach($getReadNotificationId as $row){
                    array_push($notificationArr, $row['notification_id']);
                }
                
                $wherecond = "";
                if(count($notificationArr)>0){
                    $notificationArr = implode(',', $notificationArr);
                    $wherecond = " id  NOT IN(".$notificationArr.")";
                }

                   
                $getAllNotifications = $this->Common_api_model->get($wherecond, 'notification');

                if(count($getAllNotifications) > 0){
                    $rows = []; 
                    foreach ($getAllNotifications as $key => $value) {
                        
                        if($value['big_picture'] != ''){
                            $value['big_picture']= base_url().'assets/images/notification/'.$value['big_picture'];
                        }
                        $rows[] = $value;
                    }

                    $response = array('status' => 200, 'result' => $rows, 'message' => $this->lang->line('successfully_get'));
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
    
    public function read_notification() {
        try {
            $this->form_validation->set_rules('user_id', 'user_id', 'required');
            $this->form_validation->set_rules('notification_id', 'notification_id', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                //echo "<pre>";print_r($_REQUEST);die;
                $userId = trim($_REQUEST['user_id']);
                $notification_id = trim($_REQUEST['notification_id']);
                $readArr = array();
                $readArr['user_id'] = $userId;
                $readArr['notification_id'] = $notification_id;
                $readArr['created_at'] = date('Y-m-d h:i:s');
                $this->Common_api_model->insert($readArr, 'user_notification_tracking');
                $response = array('status' => 200, 'message' => $this->lang->line('notification_read_successfully'));
                //echo "<pre>";print_r($transactionArr);die;
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $res = array('status' => 400, 'message' => $this->lang->line('error'));
            return true;
        }
    }

    public function loginwithotp() {
        try {
            $this->form_validation->set_rules('mobile', 'mobile', 'required');
            if ($this->form_validation->run() == false) {
                $errors = $this->form_validation->error_array();
                sort($errors);
                $array = array('status' => 400, 'message' => $this->lang->line('required_field'));
                echo json_encode($array);
                exit;
            } else {
                $mobileNumber = isset($_POST['mobile']) ? $_POST['mobile'] : '';
                $where = 'mobile_number="' . $mobileNumber . '"';
                $userData = $this->Common_api_model->getById($where, 'users');
                if (isset($userData['id'])) {
                    $userId = $userData['id'];
                } else {
                    $data = array(
                        'first_name' => '',
                        'last_name' => '',
                        'fullname' => '',
                        'username' => '',
                        'email' => '',
                        'password' => '',
                        'reference_code' =>uniqid(),
                        'type' => '3',
                        'mobile_number' => $mobileNumber,
                        'profile_img' => 'user.png',
                        'device_token' => '',
                    );
                    $userId = $this->Common_api_model->insert($data, 'users');
                }

                $where = "id=" . $userId;
                $userData = $this->Common_api_model->getById($where, 'users');

                // Facebook User Login
                $userData['profile_img'] = base_url() . 'assets/images/users/' . $userData['profile_img'];
                $userData['user_type'] = 'login'; 
                $response = array('status' => 200, 'message' => $this->lang->line('login_success'), 'result' => array($userData));
                echo json_encode($response);
                exit;
            }
        } catch (Exception $e) {
            $response = array('status' => 400, 'message' => $this->lang->line('error'));
            echo json_encode($response);
            exit;
        }
    }

    public function earn_point() {

        $earn_point = $this->Common_api_model->get('', 'earn_point');
        $spin_wheel = $daily_login = $free_coin = [];
        foreach ($earn_point as $key => $value) {
            if($value['point_type'] == 1)
            {   
                $spin_wheel[] = $value;
            }                      
            else if($value['point_type'] == 2){
                $daily_login[] = $value;
            }else{
                $free_coin[] = $value;
            }      
        }  
       
        $response = array('status' => 200, 'spin_wheel' => $spin_wheel,'daily_login'=>$daily_login,'free_coin' =>$free_coin, 'message' => $this->lang->line('successfully_get'));
       
        echo json_encode($response);
    }
}
