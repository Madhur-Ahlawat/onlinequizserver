<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$CI =& get_instance();
		$CI->load->library('session');
		$this->load->helper('delpha_helper');		
		frontendcheck();
		$this->settings = get_setting();		
	}

	public function index(){

		/*Category*/
		$result = $this->Common_model->getCount('','category');
		$data['category']=sizeof($result);
		
		$users = $this->Common_model->getCount('','users');
		$data['users']=sizeof($users);

		$level = $this->Common_model->getCount('','level');
		$data['level']=sizeof($level);

		$question = $this->Common_model->getCount('','question');
		$data['question']=sizeof($question);


		$question = $this->Common_model->getCount('','question');
		$data['question']=sizeof($question);


		$wherePractice = 'contest_id=0';
		$question = $this->Common_model->getCount($wherePractice,'question');
		$data['practice_questions']=sizeof($question);

		$whereContest = 'contest_id != 0';
		$question = $this->Common_model->getCount($whereContest,'question');
		$data['contest_questions']=sizeof($question);

		$question = $this->Common_model->getCount('','contest_leaderboard');
		$data['practice_play']=sizeof($question);

		$question = $this->Common_model->getCount('','contest_save_report');
		$data['contest_play']=sizeof($question);


		$first_day = date("Y-m-d", strtotime('monday this week'));
        $row = [$first_day];
        for ($i = 1; $i <= 6; $i++) {
            $date = date("Y-m-d", strtotime('+' . $i . ' days', strtotime($first_day)));
            $row[$i] = $date;
        }

        $data_count = $dataRegister = $dataAmountMagazine = [];
        foreach ($row as $key => $value) {
            $whereUser = "created_at > '" . $value . " 00:00:00' AND created_at < '" . $value . " 23:59:59'";
            $total_user = $this->Common_model->getCountData($whereUser, 'users', '', 'count(id) as total_user');
            $data_count[] = $total_user->total_user;

            $whereParentReferEarn = "created_at > '" . $value . " 00:00:00' AND created_at < '" . $value . " 23:59:59'";
            $totalParentReferEarn = $this->Common_model->getCountData($whereParentReferEarn, 'refer_earn_transaction', '', 'sum(parent_user_referred_point) as total_amount');
            $dataParentReferEarn[] = $totalParentReferEarn->total_amount;
            
            $whereEarn = "created_at > '" . $value . " 00:00:00' AND created_at < '" . $value . " 23:59:59'";
            $totalEarn = $this->Common_model->getCountData($whereEarn, 'earn_transaction', '', 'sum(point) as total_amount');
            $dataEarn[] = $totalEarn->total_amount;
        }

        $last_week_day = date("Y-m-d", strtotime('monday last week'));
        $rows = [$last_week_day];
        for ($i = 1; $i <= 6; $i++) {
            $new_date = date("Y-m-d", strtotime('+' . $i . ' days', strtotime($last_week_day)));
            $rows[$i] = $new_date;
        }

        $label =  $datas = [];
       
        $whereUser = "contest_leaderboard.created_at > '" . $rows[0]. " 00:00:00' AND contest_leaderboard.created_at < '" . $rows[6] . " 23:59:59'";
        $userResult = $this->Common_model->getCountDataOrderBy($whereUser, 'contest_leaderboard', 'user_id', 'score,users.fullname','desc','score','10');
       	

        foreach ($userResult as $key => $weekData) {
        	$label[] = $weekData->fullname;
        	$datas[] = $weekData->score;
        }


        $data['week_earning_data'] = $datas;
        $data['week_earning_label'] = $label;
        $data['week_parent_earning'] = $dataParentReferEarn;
        $data['week_earning'] = $dataEarn;
        $data['week_user'] = $data_count;
		$data['settinglist'] = $this->settings;
		$this->load->view("admin/dashboard", $data);
	}
	
}
