<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rating extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Common_api_model');
        $this->lang->load('english_lang', 'english');
        $this->load->model('api/rating/Rating_model');
        $this->load->library('email');
    }

    public function get_earnpoint_setting()
    {
        $ratings_result = $this->Common_api_model->get('', 'earnpoint_setting');
        foreach ($ratings_result as $key => $value) {
            $setting[$value['type']] = $value['value'];
        }
        return $setting;
    }

    public function withdrawal_request()
    {
        if (isset($_REQUEST['user_id']) && isset($_REQUEST['payment_detail']) && isset($_REQUEST['payment_type'])) {
            $data['user_id'] = $_REQUEST['user_id'];
            $data['payment_detail'] = $_REQUEST['payment_detail'];
            $data['payment_type'] = $_REQUEST['payment_type']; // 1. paypal , 2.paytm , 3.bank detail

            $get_point = $this->Rating_model->get_pointByUserId($_REQUEST['user_id']);
            $setting = $this->Common_api_model->settings_data();

            foreach ($setting as $set) {
                $setn[$set->key] = $set->value;
            }

            $min_earning_point = $setn['min_earning_point'];

            if ($get_point->total_points > $min_earning_point) {
                $data['point'] = $get_point->total_points;
                $earning_point = $setn['earning_point'];
                $earning_amount = $setn['earning_amount'];
                $amount = ($data['point'] * $earning_amount) / $earning_point;
                $data['total_amount'] = $amount;
                $id = $this->Common_api_model->insert($data, 'withdrawal_request');
                if ($id) {
                    $total_points['total_points'] = 0;
                    $this->Common_api_model->updateById($_REQUEST['user_id'], 'id', $total_points, 'users');
                }

                $where = 'id="' . $_REQUEST['user_id'] . '"';
                $userData = $this->Common_api_model->getById($where, 'users');

                if (isset($userData['id'])) {
                    $settinglist = get_setting();
                    foreach ($settinglist as $set) {
                        $setn[$set->key] = $set->value;
                    }

                    $mail['user'] = $userData;
                    $mail['setn'] = $setn;
                    $user_data = $this->load->view("admin/email/withdrawal_request", $mail, true);
                    $subject = "You have withdrawal request";
                    $email = $userData['email'];
                    $this->send_mail($user_data, $email, $subject);
                }

                $response = array('status' => 200, 'message' => $this->lang->line('withdrawal_request_successfully'));
            } else {
                $response = array('status' => 201, 'message' => $this->lang->line('your_earning_less') . $min_earning_point);
            }
        } else {
            $response = array('status' => 400, 'message' => $this->lang->line('required_field'));
        }
        echo json_encode($response);exit;
    }

    public function withdrawal_list()
    {
        if (isset($_REQUEST['user_id'])) {
            $data['user_id'] = $_REQUEST['user_id'];

            $where = 'user_id="' . $_REQUEST['user_id'] . '"';
            $result = $this->Common_api_model->get($where, 'withdrawal_request');
            if (count($result) > 0) {
                $response = array('status' => 200, 'message' => $this->lang->line('successfully_get'), 'result' => $result);
            } else {
                $response = array('status' => 400, 'message' => $this->lang->line('record_not_found'), 'result' => array());
            }
        } else {
            $response = array('status' => 400, 'message' => $this->lang->line('required_field'));
        }
        echo json_encode($response);exit;
    }

    public function send_mail($message, $email, $subject)
    {
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
}