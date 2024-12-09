<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $CI = & get_instance();
        $this->load->model('Common_api_model');
        $CI->load->library('session');
        frontendcheck();
        $this->settings = get_setting();
    }

    public function index() {
        $data['settinglist'] = $this->settings;
        $this->load->view("admin/notification/notification", $data);
    }

    public function save() {
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('message', 'message', 'required');
        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();
            sort($errors);
            $array = array('status' => 400, 'message' => $errors);
            echo json_encode($array);
            exit;
        }


        $setting = $this->settings;

        foreach ($setting as $set) {
            $setn[$set->key] = $set->value;
        }

        $ONESIGNAL_APP_ID = $setn['onesignal_apid'];
        $ONESIGNAL_REST_KEY = $setn['onesignal_rest_key'];


        $content = array(
            "en" => $_POST['message']
        );

        $bigPicture ='';           

        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {

            $bigPicture = $this->Common_model->imageupload($_FILES['image'], 'image', FCPATH . 'assets/images/notification');
            $filePath = base_url() . '/assets/images/notification/' . $bigPicture;
            $fields = array(
                'app_id' => $ONESIGNAL_APP_ID,
                'included_segments' => array('All'),
                'data' => array("foo" => "bar"),
                'headings' => array("en" => $_POST['title']),
                'contents' => $content,
                'big_picture' => $filePath
            );
            
        } else {
            $filePath = '';
            $fields = array(
                'app_id' => $ONESIGNAL_APP_ID,
                'included_segments' => array('All'),
                'data' => array("foo" => "bar"),
                'headings' => array("en" => $_POST['title']),
                'contents' => $content,
            );
        }




        $notification = array();
        $notification['app_id'] = $ONESIGNAL_APP_ID;
        $notification['included_segments'] = $fields['included_segments'][0];
        $notification['data'] = $fields['data']['foo'];
        $notification['headings'] = $_POST['title'];
        $notification['contents'] = $_POST['message'];
        $notification['big_picture'] = $bigPicture;
        $notification['created_at'] = date('Y-m-d h:i:s');
        $notificationId = $this->Common_api_model->insert($notification, 'notification');
       
        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $ONESIGNAL_REST_KEY));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);

        curl_close($ch);
        $res = array('status' => '200', 'message' => 'Notification send sucessfully');
        echo json_encode($res);
    }

    public function setting()
    {
        $smtpWhere = 'id="1"';
        $smtpDetail = $this->Common_model->getById($smtpWhere, 'smtp_setting');
        $data['settinglist'] = $this->settings;
        $this->load->view("admin/notification/setting", $data);
    }

    public function setting_save()
    {
        $data = $_POST;

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

    public function list()
    {
        $this->load->view("admin/notification/list");
    }

    public function fetch_data()
    {
        $table = "notification";
        $select_column = array("id", "headings", "contents", "big_picture",'created_at');
        $order_column = array(null, "headings", "contents", "big_picture",'created_at');
        $search = array("headings", "contents");

        $where = '';
        $fetch_data = $this->Common_model->make_datatables($table, $select_column, $order_column, $search, $where);

        $data = array();

        foreach ($fetch_data as $key => $row) {
          
            $sub_array = array();
            $sub_array[] = $key+1;
            $sub_array[] = '<img src="' . get_question_image_path($row->big_picture, "notification") . '" width="50" height="50" />';
            $sub_array[] = $row->headings;
            $sub_array[] = $row->contents;
            $sub_array[] = date('Y-m-d',strtotime($row->created_at));

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
