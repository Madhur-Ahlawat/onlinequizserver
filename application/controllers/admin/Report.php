<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller{

	public function __construct() {
		parent::__construct();
		$CI =& get_instance();
		$this->load->model('Common_api_model');	
		frontendcheck();
	}

	public function leaderboard()
	{
		try{ 
			$type = isset($_GET['type']) ? $_GET['type'] : 'all';
				
			if($type== 'today')
			{
				$date = date('Y-m-d');
				$where = 'date="'.$date.'"';				
				$result = $this->Common_api_model->getTodayTenRankByDate($where, 'contest_leaderboard');
				$datas=[];
				foreach ($result as $key => $value) {	
					$where = 'id='.$value['user_id'];	
					$user = $this->Common_api_model->getById($where, 'users');
					$value['score'] = $value['score'];
					$value['profile_img'] ='';
					$value['rank'] = $key+1;
					if(isset($user['id']))
					{
						$value['profile_img']  = 	 get_image_path($user['profile_img'], 'users');
						$value['name']  = $user['fullname'];
						$value['user_total_score']  =  round($user['total_score']);
					}
					else
					{
						$value['profile_img']  ='';
						$value['name']  ='';
						$value['user_total_score']  =  '';
					}
					$datas[] = $value;
				}

				
				$currentUser = (object)[];
				if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
				{
					$date = date('Y-m-d'); 
					$whereTodayOwn = 'date="'.$date.'"';
					$currentUser = $this->Common_api_model->getTodayOwnRankByDate($whereTodayOwn,$_REQUEST['user_id']);

					if(isset($currentUser->id)){
						$whereUsers = 'id='.$_REQUEST['user_id'];	
						$user = $this->Common_api_model->getById($whereUsers, 'users');
						unset($currentUser->user_id);
						unset($currentUser->id);
						$currentUser->id = $_REQUEST['user_id'];
						$currentUser->profile_img  = get_image_path($user['profile_img'], 'users'); 
						$currentUser->fullname  = $user['fullname'];	
					}
				}
			}elseif($type== 'month')
			{

				$first_day = date('Y-m-01'); // hard-coded '01' for first day
				$last_day  = date('Y-m-t');
				$where = 'date >="'.$first_day.'" AND date <= "'.$last_day.'"';				
				$order_by_field = 'max_score';
				$result = $this->Common_api_model->getTodayTenRankByDate($where, 'contest_leaderboard');		
				
				$datas=[];
				foreach ($result as $key => $value) {					
					$whereGetById = 'id='.$value['user_id'];	
					$user = $this->Common_api_model->getById($whereGetById, 'users');
					$value['score'] = $value['score'];
					unset($value['max_score']);
					$value['profile_img'] ='';
					if(isset($user['id']))
					{
						$value['profile_img']  = get_image_path($user['profile_img'], 'users'); 
						$value['name']  = $user['fullname'];
						$value['user_total_score']  = round($user['total_score']);
					}else
					{
						$value['profile_img']  ='';
						$value['name']  ='';
						$value['user_total_score']  =  '';
					}
					$datas[] = $value;
				}

				$currentUser = (object)[];
				if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
				{
					$firstDay = date('Y-m-01'); // hard-coded '01' for first day
					$lastDay  = date('Y-m-t');
					$whereTodayOwnRank = 'date >="'.$firstDay.'" AND date <= "'.$lastDay.'"';

					$currentUser = $this->Common_api_model->getTodayOwnRankByDate($whereTodayOwnRank, $_REQUEST['user_id']);
					$whereUserById = 'id='.$_REQUEST['user_id'];
					$user = $this->Common_api_model->getById($whereUserById, 'users');
					unset($currentUser->user_id);
					unset($currentUser->id);
					$currentUser->id = $_REQUEST['user_id'];
					$currentUser->profile_img  = get_image_path($user['profile_img'], 'users'); 
					$currentUser->fullname  = $user['fullname'];
				}

			}else{
				
				$where = '';
				$result = $this->Common_api_model->getAllRankByUserId($where);		
			
				$datas=[];
				foreach ($result as $key => $value) {					
					$where = 'id='.$value['id'];	
					$user = $this->Common_api_model->getById($where, 'users');
					$value['score'] = $value['total_score'];
					$value['profile_img'] ='';					
					if(isset($user['id']))
					{
						$value['profile_img']  = get_image_path($user['profile_img'], 'users'); 
						$value['name']  = $user['fullname'];
						$value['user_total_score']  =  round($user['total_score']);
					}
					$datas[] = $value;
				}

				$currentUser = (object)[];
				if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
				{
					$currentUser = $this->getCurrentRankByUserId($_REQUEST['user_id']);
				}
			}
			
			$data['result'] = $datas;	
			$this->load->view("admin/report/leaderboard",$data);
			
		}
		catch(Exception $e) {

		}
		
	}

	public function praticeleaderboard()
	{
		try{ 
			$type = isset($_GET['type']) ? $_GET['type'] : 'all';
				
			if($type== 'today')
			{
				$date = date('Y-m-d');

				$where = 'date="'.$date.'"';				
				$result = $this->Common_api_model->getTodayPractiseTenRankByDate($where, 'pratice_leaderboard');
				$datas=[];
				foreach ($result as $key => $value) {	
					$where = 'id='.$value['user_id'];	
					$user = $this->Common_api_model->getById($where, 'users');
					$value['score'] = $value['score'];
					$value['profile_img'] ='';
					$value['rank'] = $key+1;
					if(isset($user['id']))
					{
						$value['profile_img']  = 	 get_image_path($user['profile_img'], 'users');
						$value['name']  = $user['fullname'];
						$value['user_total_score']  =  round($user['total_score']);
					}
					else
					{
						$value['profile_img']  ='';
						$value['name']  ='';
						$value['user_total_score']  =  '';
					}
					$datas[] = $value;
				}

				
				$currentUser = (object)[];
				if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
				{
					$date = date('Y-m-d'); 
					$whereTodayOwn = 'date="'.$date.'"';
					$currentUser = $this->Common_api_model->getTodayPractiseTenRankByDate($whereTodayOwn,$_REQUEST['user_id']);

					if(isset($currentUser->id)){
						$whereUsers = 'id='.$_REQUEST['user_id'];	
						$user = $this->Common_api_model->getById($whereUsers, 'users');
						unset($currentUser->user_id);
						unset($currentUser->id);
						$currentUser->id = $_REQUEST['user_id'];
						$currentUser->profile_img  = get_image_path($user['profile_img'], 'users'); 
						$currentUser->fullname  = $user['fullname'];	
					}
				}
			}elseif($type== 'month')
			{

				$first_day = date('Y-m-01'); // hard-coded '01' for first day
				$last_day  = date('Y-m-t');
				$where = 'date >="'.$first_day.'" AND date <= "'.$last_day.'"';				
				$order_by_field = 'max_score';
				$result = $this->Common_api_model->getTodayPractiseTenRankByDate($where, 'pratice_leaderboard');		
				
				$datas=[];
				foreach ($result as $key => $value) {					
					$whereGetById = 'id='.$value['user_id'];	
					$user = $this->Common_api_model->getById($whereGetById, 'users');
					$value['score'] = $value['score'];
					unset($value['max_score']);
					$value['profile_img'] ='';
					if(isset($user['id']))
					{
						$value['profile_img']  = get_image_path($user['profile_img'], 'users'); 
						$value['name']  = $user['fullname'];
						$value['user_total_score']  = round($user['total_score']);
					}else
					{
						$value['profile_img']  ='';
						$value['name']  ='';
						$value['user_total_score']  =  '';
					}
					$datas[] = $value;
				}

				$currentUser = (object)[];
				if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
				{
					$firstDay = date('Y-m-01'); // hard-coded '01' for first day
					$lastDay  = date('Y-m-t');
					$whereTodayOwnRank = 'date >="'.$firstDay.'" AND date <= "'.$lastDay.'"';

					$currentUser = $this->Common_api_model->getTodayPractiseTenRankByDate($whereTodayOwnRank, $_REQUEST['user_id']);
					$whereUserById = 'id='.$_REQUEST['user_id'];
					$user = $this->Common_api_model->getById($whereUserById, 'users');
					unset($currentUser->user_id);
					unset($currentUser->id);
					$currentUser->id = $_REQUEST['user_id'];
					$currentUser->profile_img  = get_image_path($user['profile_img'], 'users'); 
					$currentUser->fullname  = $user['fullname'];
				}

			}else{
			
				$where = '';
				$result = $this->Common_api_model->getAllPractiseRankByUserId($where);		
			
				$datas=[];
				foreach ($result as $key => $value) {					
					$where = 'id='.$value['id'];	
					$user = $this->Common_api_model->getById($where, 'users');
					$value['score'] = $value['pratice_quiz_score'];
					$value['user_total_score'] = round($user['pratice_quiz_score']);
					$value['profile_img'] ='';					
					if(isset($user['id']))
					{
						$value['profile_img']  = get_image_path($user['profile_img'], 'users'); 
						$value['name']  = $user['fullname'];
						$value['user_total_score']  =  round($user['pratice_quiz_score']);
						$value['user_total_score'] = round($user['pratice_quiz_score']);
					}
					$datas[] = $value;
				}

				$currentUser = (object)[];
				if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
				{
					$currentUser = $this->getCurrentPractiseRankByUserId($_REQUEST['user_id']);
				}
			}
			
			$data['result'] = $datas;	
			$this->load->view("admin/report/praticeleaderboard",$data);
			
		}
		catch(Exception $e) {

		}
	}
}
