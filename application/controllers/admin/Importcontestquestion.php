<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importcontestquestion extends CI_Controller {

	public function __construct() {
		parent::__construct();
		frontendcheck();
	}

	public function index(){
		$this->load->view("admin/contest_question/import_question");
	}

	public function save(){

		$filename=$_FILES["question"]["tmp_name"];    
	    if($filename)
	    {	
	        $file = fopen($filename, "r");
	        
	        $arrResult = []; 
	    	while (($row = fgetcsv($file, 10000, ",")) !== FALSE)
	        {
	        	$arrResult[] = $row;
	        }
	      	fclose($file);

	      	unset($arrResult[0]);

	      	if(count($arrResult) > 0)
	      	{
	      		foreach ($arrResult as $key => $value) {

	      			$question_img = '';
                    if (isset($value[9]) && $value[9] != '') {
                        $url = $value[9];
                        $ext = pathinfo($url);
                        if(isset($ext['extension'])){
                            $image_name = time() . '_question' . '.' . $ext['extension'];
                            $path = FCPATH . 'assets/images/question/';
                            file_put_contents($path . $image_name, file_get_contents($url));
                            $question_img = $image_name;
                        }else
                        {
                            $question_img = '';
                        }
                    }	


	      			$contest_id = isset($value[10]) ? $value[10] : 0;
	      			if($contest_id == 0)
	      			{
	      				$array  = array('status'=>400,'message'=>'please enter contest id on csv');
         				echo json_encode($array);exit;
	      			}


	      			$question = [];
	      			$question['category_id'] = $value[0];
	      			$question['question_type'] = $value[1];
	      			$question['question'] = $value[2];
	      			$question['option_a'] = $value[3];
	      			$question['option_b'] = $value[4];
	      			$question['option_c'] = $value[5];
	      			$question['option_d'] = $value[6];
	      			$question['answer'] = $value[7];
	      			$question['note'] = $value[8];
	      			$question['image'] = $question_img;
	      			$question['contest_id'] = $contest_id;
					$this->Common_model->insert($question,'question');
	      		}
      		
				$res=array('status'=>'200','message'=>'Import  question is successful.');
				echo json_encode($res);exit;
	      	}
	  	}else{
	  		$errors = ["Please select CSV"];
            sort($errors); 	
            $array  = array('status'=>400,'message'=>$errors);
         	echo json_encode($array);exit;
	  	}   
	}

	function download()
	{
		$myFile = $this->config->item('image_base_path').'csv_format/data-contest-format.csv';
		
        header('HTTP/1.1 200 OK');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=data-contest-format.csv");
        readfile($myFile);
        exit;
	}

}
