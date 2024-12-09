<?php 

    if (!defined('BASEPATH')) exit('No direct script access allowed');

    if ( ! function_exists('frontendcheck'))
    {
        function frontendcheck()
        {	
    		$CI =& get_instance();
    		$CI->load->library('session');
    		$user = $CI->session->userdata('admin_id');
    	   
            if (!isset($user)) { 
                redirect(base_url().'login');             
            }else {
                return TRUE;
            }       		
        }   
    }

    function getWeekDay()
    {
        return [
            "1" =>"Monday",
            "2" =>"Tuesday",
            "3" =>"Wednesday",
            "4" =>"Thursday",
            "5" =>"Friday",
            "6" =>"Saturday",
            "7" =>"Sunday"
        ];
    }
   
    function dateformate($data)
    {
        return date('Y-m-d', strtotime($data));
    }

    function isInsert()
    {
        $base_url = base_url();

        $strpos  = strpos($base_url,'https://divinetechs.com');
        $strpos1  = strpos($base_url,'https://www.divinetechs.com');

        if($strpos === false && $strpos1 === false)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    function get_setting()
    {   
        $CI =& get_instance();
        $CI->load->model('Common_model');
        $data = $CI->Common_model->settings_data();
        return $data;           
    }

    function get_menu()
    {   
        $CI =& get_instance();
        $CI->load->model('Common_model');
        $data = $CI->Common_model->get('','menu',$field_name = 'order_no', $order_by = 'asc');
        return $data;           
    }      

    function p($data)
    {
        echo '<pre>';
        print_r($data);
        exit;
    }    
    
    function no_format($num)
    {
       if($num>1000) {

            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }
        return $num;
    }

    function string_cut($string,$len)
    {
        if(strlen($string) > $len){ 
            $string = '<p title="'.$string.'">'.substr($string, 0,$len). ' ...</p>';
        }
        return $string;
    }

    function user_name($name)
    {
        $name = str_replace(' ', '', $name);
        if(strlen($name) > 5){ 
            $sortname = substr($name, 0,5);
        }else{
            $sortname = $name;
        }
        
        $sortid = substr(uniqid(), 8,4);
        return $sortname.$sortid;
    }

    function get_smtp_setting()
    {   
        $CI =& get_instance();
        $CI->load->model('Common_model');

        $smtpWhere='id="1"';
        $data = $CI->Common_model->getById($smtpWhere,'smtp_setting');

        $smtp_config['protocol']    = $data['protocol'];
        $smtp_config['smtp_host']    = $data['host'];
        $smtp_config['smtp_port']    = $data['port'];
        $smtp_config['smtp_timeout'] = '7';
        $smtp_config['smtp_user']    = $data['user'];
        $smtp_config['smtp_pass']    = $data['pass'];
        $smtp_config['charset']    = 'utf-8';
        $smtp_config['newline']    = "\r\n";
        $smtp_config['mailtype'] = 'text'; // or html
        $smtp_config['validation'] = TRUE; // bool whether to validate email or not
        return $smtp_config;           
    }    

    function rand_password_create($length=8)
    {
        // Password create 
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $passa= array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length ; $i++) {
            $n = rand(0, $alphaLength);
            $passa[] = $alphabet[$n];
        }
        $pass= implode($passa);         
        return $pass;
    }   

    function get_image_path($image = "", $folder = "")
    {
        $ci =& get_instance();
        $image_base_path = $ci->config->item('image_base_path');
        $image_base_url = $ci->config->item('image_base_url');

        // Thumbnail Img Check
        $thumbnail_img = $image_base_url . $folder . '/' . $image;

         
        if (empty($image)) {
            $thumbnail_img = $image_base_url . 'placeholder.png';
        }
        if (!file_exists($image_base_path . $folder . '/' . $image)) {
            $thumbnail_img = $image_base_url . 'placeholder.png';
        }
        return $thumbnail_img;
    }



    function get_question_image_path($image = "", $folder = "")
    {
        $ci =& get_instance();
        $image_base_path = $ci->config->item('image_base_path');
        $image_base_url = $ci->config->item('image_base_url');

        // Thumbnail Img Check
        $thumbnail_img = $image_base_url . $folder . '/' . $image;

         
        if (empty($image)) {
            $thumbnail_img = $image_base_url . 'question-default.png';
        }
        if (!file_exists($image_base_path . $folder . '/' . $image)) {
            $thumbnail_img = $image_base_url . 'question-default.png';
        }
        return $thumbnail_img;
    }

    function save_notification($from_user_id=0,$doctor_id=0,$patient_id=0,$title=Null, $appointment_id=0,$type=0)
    {

        $CI =& get_instance();
        $CI->load->model('Common_api_model');

        $data['title'] = $title;
        $data['from_user_id'] = $from_user_id;
        $data['doctor_id'] = $doctor_id;
        $data['patient_id'] = $patient_id;
        $data['appointment_id'] = $appointment_id;
        $data['type'] = $type;  // 1-appointment,2- comment , 3- following

        $CI->Common_api_model->insert($data,'notification');


        if($doctor_id > 0)
        {
            $userWhere = 'id='.$doctor_id;
            $user = $CI->Common_api_model->getById($userWhere,'doctor');
        } 

        if($patient_id > 0)
        {
            $userWhere = 'id='.$patient_id;
            $user = $CI->Common_api_model->getById($userWhere,'patients');
        }   

    
        if(isset($user['device_token'])){
            $to = $user['device_token']; 
            $setting= get_setting();
            foreach($setting as $set)
            {
                $setn[$set->key]=$set->value;
            }
            
            $ONESIGNAL_APP_ID=$setn['onesignal_apid'];
            $ONESIGNAL_REST_KEY=$setn['onesignal_rest_key'];

            $file_path = '';  
            $fields = array(
                'app_id' => $ONESIGNAL_APP_ID,
                'include_player_ids' => array($to),   
                'data' => array("foo" => "bar"),
                'headings'=> array("en" => $title),
                'contents' => $title,
            );

            $fields = json_encode($fields);    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                'Authorization: Basic '.$ONESIGNAL_REST_KEY));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $response = curl_exec($ch);
            curl_close($ch);
            return true;
        }
    }   

     function curl($url=Null, $data=Null)
    {   
        $some_data = array();  
        if($data)
        {
            $some_data = $data;
        }    

        $curl = curl_init();
        // We POST the data
        curl_setopt($curl, CURLOPT_POST, 1);
        // Set the url path we want to call
        curl_setopt($curl, CURLOPT_URL, $url);  
        // Make it so the data coming back is put into a string
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Insert the data
        curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

        $result = curl_exec($curl);
        // Free up the resources $curl is using
        curl_close($curl);
        
        return  json_decode($result);
    }
?>