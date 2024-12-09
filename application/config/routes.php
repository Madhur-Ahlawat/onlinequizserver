<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Basic setting
$route['api/genaral_setting'] = 'api/Home/genaral_setting';
$route['api/get_category'] = 'api/Home/get_category';
$route['api/get_lavel'] = 'api/Home/getLavelByCategoryId';
$route['api/get_question_by_lavel'] = 'api/Home/getQuestionByLavel';
$route['api/save_question_report'] = 'api/Home/saveQuestionReport';
$route['api/getTodayLeaderBoard'] = 'api/Home/getTodayLeaderBoard';
$route['api/RecentQuizByUser'] = 'api/Home/RecentQuizByUser';
$route['api/get_pratice_level'] = 'api/Home/get_pratice_level';
$route['api/checkStatus'] = 'api/Home/checkStatus';

$route['api/getLeaderBoard'] = 'api/Home/getLeaderBoard';
$route['api/getPractiseLeaderBoard'] = 'api/Home/getPractiseLeaderBoard';
$route['api/getPracticeQuestionByLavel'] = 'api/Home/getPracticeQuestionByLavel';
$route['api/savePracticeQuestionReport'] = 'api/Home/savePracticeQuestionReport';
$route['api/getPracticeLavelByCategoryId'] = 'api/Home/getPracticeLavelByCategoryId';
$route['api/getPraticeCategoryByLevelMaster'] = 'api/Home/getPraticeCategoryByLevelMaster';

//withdrawal_request
$route['api/withdrawal_request'] = 'api/Rating/withdrawal_request';
$route['api/withdrawal_list'] = 'api/Rating/withdrawal_list';
$route['api/add_earnpoint'] = 'api/Rating/add_earnpoint';
$route['api/get_packages'] = 'api/Home/get_packages';
$route['api/add_transaction'] = 'api/Home/add_transaction';
$route['api/get_package_transaction'] = 'api/Home/get_package_transaction';

//End Rating

// User 
$route['api/password_change'] = 'api/Users/password_change';
$route['api/profile'] = 'api/Users/profile';
$route['api/updateprofile'] = 'api/Users/updateprofile';
$route['api/registration'] = 'api/Users/registration';
$route['api/login'] = 'api/Users/login';
$route['api/forgot_password'] = 'api/Users/forgot_password';
$route['api/updatefirebaseid'] = 'api/Users/updatefirebaseid';
$route['api/reward_points'] = 'api/Users/reward_points';
$route['api/get_reward_points'] = 'api/Users/get_reward_points';
$route['api/get_notification'] = 'api/Users/get_notification';
$route['api/read_notification'] = 'api/Users/read_notification';
$route['api/loginwithotp'] = 'api/Users/loginwithotp';
$route['api/earn_point'] = 'api/Users/earn_point';
$route['api/refer_transaction'] = 'api/Users/refer_transaction';
$route['api/get_earn_transaction'] = 'api/Home/get_earn_transaction';
$route['api/get_transaction'] = 'api/Home/get_transaction';

//Contest
$route['api/getContest'] = 'api/Home/getContest';
$route['api/upcomingContest'] = 'api/Home/UpcomingContest';
$route['api/joinContest'] = 'api/Home/joinContest';
$route['api/get_review_question_by_contest_id'] = 'api/Home/get_review_question_by_contest_id';
$route['api/get_question_by_contest'] = 'api/Home/getQuestionByContest';
$route['api/save_contest_question_report'] = 'api/Home/saveContestQuestionReport';
$route['api/getTodayContestLeaderBoard'] = 'api/Home/getContestLeaderBoard';
$route['api/getContestLeaderBoard'] = 'api/Home/getContestLeaderBoard';
$route['api/get_winner_by_contest'] = 'api/Home/get_winner_by_contest';

$route['api/getLevelMaster'] = 'api/Home/getLevelMaster';
$route['api/getCategoryByLevelMaster'] = 'api/Home/getCategoryByLevelMaster';

// END API rought
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;