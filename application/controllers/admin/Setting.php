<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $CI->load->library('session');
        $this->load->helper('delpha_helper');
        frontendcheck();
        $this->settings = get_setting();
    }

    public function purchase_code()
    {
        $data['settinglist'] = $this->settings;
        $this->load->view("admin/setting/purchase_code_setting", $data);
    }


    public function adssetting()
    {
        $data['settinglist'] = $this->settings;
        $this->load->view("admin/setting/adssetting", $data);
    }

    public function index()
    {
        $smtpWhere = 'id="1"';
        $smtpDetail = $this->Common_model->getById($smtpWhere, 'smtp_setting');

        $data['settinglist'] = $this->settings;
        $data['smtp_setting'] = $smtpDetail;
        // echo json_encode($data);
        $this->load->view("admin/setting/addsettingside", $data);
    }

    public function general_setting()
    {
        $data['earnpoint_setting'] = $this->Common_model->get('', 'earnpoint_setting');

        $getSetting = get_setting();
        $data['settinglist'] = $getSetting;
        $this->load->view("admin/setting/earning", $data);
    }

    public function save_smtp_setting()
    {
        if ($_POST) {
            $data = $_POST;
            $id = 1;
            $addedId = $this->Common_model->update($id, 'id', $data, 'smtp_setting');
            if ($addedId) {
                $res = array('status' => '200', 'msg' => 'Update setting Sucessfully', 'id' => $addedId);

            } else {
                $res = array('status' => '400', 'msg' => 'Please try again');
            }
        } else {
            $res = array('status' => '400', 'msg' => 'The password and confirmation password do not match.');
        }

        echo json_encode($res);
        exit;
    }

    public function save()
    {
        $data = $_POST;

        // p($data);
        if (isset($_FILES['app_image']) && !empty($_FILES['app_image']['name'])) {
            $logo = $this->Common_model->imageupload($_FILES['app_image'], 'app_image',
                FCPATH . 'assets/images/app');
            $data['app_logo'] = $logo;
        }

        if ((isset($data['purchase_code']) && $data['purchase_code'] != '') and (isset($data['package_name']) && $data['package_name'] != '')) {
            $url = 'https://divinetechs.com/envato/secureapi/checkPurchaseCode.php';
            $envento['purchase_code'] = $data['purchase_code'];
            $envento['package_name'] = $data['package_name'];
            $envento['base_url'] = $this->config->item('base_url');
            $response = curl($url, $envento);
     
            if ($response->status == 400) {
                $res = array('status' => '400', 'message' => $response->message);
                echo json_encode($res);exit;
            }
        }

        foreach ($data as $key => $value) {
            if ($value) {

                $array['value'] = $value;
                $result = $this->Common_model->updateById($key, 'key', $array, 'general_setting');
            } elseif ($value == 0) {
                $array['value'] = $value;
                $result = $this->Common_model->updateById($key, 'key', $array, 'general_setting');
            }
        }

        $res = array('status' => '200', 'message' => 'Sucessfully updated');
        echo json_encode($res);
    }

    public function change_password()
    {
        if((isset($_POST['password']) && $_POST['password'] != '') || (isset($_POST['email'])))
        {
            if($_POST['password'] == $_POST['confirm_password']) {
                $id = $_POST['admin_id'];
                            $id = $_POST['admin_id'];

                $data = array('password' => $_POST['password'],'email_address' => $_POST['email']);
                $resId = $this->Common_model->updateById($id, 'id', $data, 'admin');
                if ($resId) {
                    $this->session->set_userdata('admin_email',$_POST['email']);

                    $result = array('status' => '200', 'msg' => 'Update password Sucessfully', 'id' => $resId);
                    echo json_encode($result);
                    exit;
                } else {
                    $result = array('status' => '400', 'msg' => 'Please try again');
                    echo json_encode($result);
                    exit;
                }
            } else {
                $result = array('status' => '400', 'msg' => 'The password and confirmation password do not match.');
                echo json_encode($result);
                exit;
            }
        }else
        {
            $result = array('status' => '400', 'msg' => 'Enter required field.');
            echo json_encode($result);
            exit;

        }
    }
}