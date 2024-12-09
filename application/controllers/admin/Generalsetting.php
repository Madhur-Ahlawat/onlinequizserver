<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Generalsetting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $CI = & get_instance();
        $CI->load->library('session');
        frontendcheck();
    }

    public function index() {
        $data['earnpoint_setting'] = $this->Common_model->get('', 'earnpoint_setting');
        $data['earn_point'] = $this->Common_model->get('', 'earn_point');
        
        $getSetting = get_setting();
        $data['settinglist'] = $getSetting;
        $this->load->view("admin/setting/earning", $data);
    }

    public function general_setting() {
        $data['earnpoint_setting'] = $this->Common_model->get('', 'earnpoint_setting');

        $getSetting = get_setting();
        $data['settinglist'] = $getSetting;
        $this->load->view("admin/setting/earning", $data);
    }

    public function earnpoint_setting() {
        $data = $_POST;

        foreach ($data as $key => $value) {
            if ($value) {
                $array['value'] = $value;
                $result = $this->Common_model->updateById($key, 'key', $array, 'earnpoint_setting');
            }
        }
        return true;
    }

    public function earn_point(){
        $data = $_POST;
        foreach ($data as $key => $value) {
            if ($value) {
                $array['value'] = $value;
                $result = $this->Common_model->updateById($key, 'key', $array, 'earn_point');
            }
        }
        return true;
    }

    public function save() {
        //echo "<pre>";print_r($_POST);die;
        $data = $_POST;
        if (isset($_FILES['app_image']) && !empty($_FILES['app_image']['name'])) {
            $logo = $this->Common_model->imageupload($_FILES['app_image'], 'app_image', FCPATH . 'assets/images/app');
            $data['app_logo'] = $logo;
        }

        foreach ($data as $key => $value) {
            if ($value) {
                $array['value'] = $value;
                $result = $this->Common_model->updateById($key, 'key', $array, 'general_setting');
            }
        }
        return true;
    }

}
