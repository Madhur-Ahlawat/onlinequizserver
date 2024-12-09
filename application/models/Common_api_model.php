<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class : Login_model (Login Model)
 * Login model class to get to authenticate user credentials 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Common_api_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getCount($where, $tablename) {
        $this->db->select('*');
        $this->db->from($tablename);
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    public function getLikeCount($user_id) {
        $this->db->select('count(id) as total_like');
        $this->db->from('v_like');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }

    public function get_join($data) {
        $where = isset($data['where']) ? $data['where'] : '';
        $group_by = isset($data['group_by']) ? $data['group_by'] : '';
        $order_by_field = isset($data['order_by_field']) ? $data['order_by_field'] : '';
        $order_by = isset($data['order_by']) ? $data['order_by'] : '';
        $page_no = isset($data['page_no']) ? $data['page_no'] : '';
        $page_limit = isset($data['page_limit']) ? $data['page_limit'] : '';
        $offset = isset($data['offset']) ? $data['offset'] : '';

        $this->db->select($data['field']);
        $this->db->from($data['table']);

        foreach ($data['joins'] as $joins) {
            $this->db->join($joins['table'], $joins['join']);
        }

        if ($where) {
            foreach ($where as $value) {
                $this->db->where($value);
            }
        }

        if ($order_by_field) {
            $this->db->order_by($order_by_field, $order_by);
        }

        if ($group_by) {
            $this->db->group_by($group_by);
        }

        if ($page_no) {
            $offset = ($page_limit * $page_no) - $page_limit;
            $this->db->limit($page_limit, $offset);
        }
        $query = $this->db->get();


        $row = $query->result();
        return $row;
    }

    public function getWinner($where, $limit, $order_by, $field) {
        $this->db->select('winners.*,user.fullname,user.profile_img,contest.name  as contest_name');
        $this->db->from('winners');
        $this->db->join('user', 'user.id = winners.user_id');
        $this->db->join('contest', 'contest.id = winners.contest_id');
        $this->db->where($where);
        $this->db->limit($limit);
        $this->db->order_by($field, $order_by);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    public function updateByIdWithcount($id, $field_name, $value, $tablename) {

        $this->db->set($field_name, $field_name . '+' . $value, FALSE);
        $this->db->where('id', $id);
        $this->db->update($tablename);
        return $id;
    }

     public function subByIdWithcount($id, $field_name, $value, $tablename) {

        $this->db->set($field_name, $field_name . '-' . $value, FALSE);
        $this->db->where('id', $id);
        $this->db->update($tablename);
        return $id;
    }

    public function get_join_allrecord($table1, $table2, $joinid, $field, $where = "") {
        $this->db->select($field);
        $this->db->from($table1);
        if ($where) {
            $this->db->where($where);
        }
        $this->db->join($table2, $joinid);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    public function get($where, $tablename, $order_by_field = '', $order_by = 'desc', $limit = '', $group_by = '', $field = '*') {
        $this->db->select($field);
        $this->db->from($tablename);

        if (!empty($where)) {
            $this->db->where($where);
        }

        if ($order_by_field) {
            $this->db->order_by($order_by_field, $order_by);
        }

        if ($limit) {
            $this->db->limit($limit);
        }

        if ($group_by) {
            $this->db->group_by($group_by);
        }

        $query = $this->db->get();
        // p($this->db->last_query());
        $row = $query->result_array();
        return $row;
    }

    public function getWithLike($where = null, $tablename, $field, $value) {
        $this->db->select('*');
        $this->db->from($tablename);
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->like($field, $value, 'both');
        $query = $this->db->get();
        $row = $query->result();
        return $row;
    }

    public function getById($where, $tablename) {
        $this->db->select('*');
        $this->db->from($tablename);
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }

    public function getLastRecord($where, $tablename) {
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($where);
        $this->db->limit(1);
        $this->db->order_by('id', "desc");
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }

    public function insert($data, $tablename) {

        $query = $this->db->insert($tablename, $data);

        return $this->db->insert_id();
    }

    public function update($id, $data, $tablename) {
        $this->db->where('id', $id);
        $this->db->update($tablename, $data);
        return $id;
    }

    public function updateById($id, $field_name, $data, $tablename) {
        $this->db->where($field_name, $id);
        $this->db->update($tablename, $data);
        return $id;
    }

    public function delete($where, $tablename) {
        $this->db->where($where);
        $this->db->delete($tablename);
        return true;
    }

    public function delete_all($id, $field_name, $tablename) {
        $this->db->where($field_name, $id);
        $this->db->delete($tablename);
        return true;
    }

    public function imageupload($imageName, $imgname, $uploadpath) {
        if (!file_exists($uploadpath)) {
            mkdir($uploadpath, 0777, true);
        }

        if (empty($imageName['name'])) {
            $res = array('status' => '400', 'message' => 'Please Upload Image first.');
            echo json_encode($res);
            exit;
        }
        if (!empty($imageName['name']) && ($imageName['error'] == 1 || $imageName['size'] > 15728640)) {
            $res = array('status' => '202', 'message' => 'Max 15MB file is allowed for image.');
            echo json_encode($res);
            exit;
        } else {
            list($width, $height) = getimagesize($imageName['tmp_name']);
            if ($width > 5000 || $height > 5000) {
                $res = array('status' => '201', 'message' => 'Image height and width must be less than 1000px.');
                echo json_encode($res);
                exit;
            } else {

                $catImg = $imageName['name'];
                $ext = pathinfo($catImg);
                $catImages = str_replace(array(' ', '.', '-', '`'), '_', $ext['filename']);
                $category_image = time() . '.' . $ext['extension'];
                $config = array(
                    'allowed_types' => 'jpg|jpeg|gif|png',
                    'upload_path' => $uploadpath,
                    'file_name' => $category_image
                );

                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload($imgname);
                return $category_image;
            }
        }
    }

    public function videoupload($imageName, $imgname, $uploadpath) {

        if (empty($imageName['name'])) {
            $res = array('status' => '400', 'message' => 'Please Upload Image first.');
            echo json_encode($res);
            exit;
        }

        $catImg = $imageName['name'];
        $ext = pathinfo($catImg);
        $catImages = str_replace(array(' ', '.', '-', '`'), '_', $ext['filename']);
        $category_image = time() . '.' . $ext['extension'];
        $config = array(
            'allowed_types' => '*',
            'upload_path' => $uploadpath,
            'file_name' => $category_image
        );
        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->upload->do_upload($imgname);
        return $category_image;
    }

    public function settings_data() {
        $this->db->select("*");
        $this->db->from("general_setting");
        $q = $this->db->get();
        return $q->result();
    }

    public function getRating($id) {
        $this->db->select("count(id) as toitla_rating, avg(rating) as rating_avg");
        $this->db->from("ratings");
        $this->db->where('doctor_id', $id);
        $query = $this->db->get();
        $ratings = $query->row();
        return $ratings;
    }

    public function RecentQuizByUser($id) {
        $this->db->select("contest_leaderboard.*,level.name as level_name,win_question_count,users.profile_img");
        $this->db->join('level', 'level.id = contest_leaderboard.level_id');
        $this->db->join('users', 'users.id = contest_leaderboard.user_id');
        $this->db->from("contest_leaderboard");
        $this->db->where('user_id', $id);
        $this->db->limit('10');
        $this->db->order_by('contest_leaderboard.id', 'DESC');
        $query = $this->db->get();
        $ratings = $query->result();
        return $ratings;
    }

    public function getCurrentRankByUserId($id) {
        $query = $this->db->query("select * from (select @rn:= @rn+1 as rank,id,total_score,fullname,profile_img from users join (select @rn:=0) tmp order by total_score desc ) tmp  where id='" . $id . "'  order by rank ASC ");
        $row = $query->row();
        return $row;
    }

    public function getTodayOwnRankByDate($where = '', $user_id = '') {
        $query = $this->db->query("select * from (select @rn:= @rn+1 as rank,id,score,is_unlock, score as total_score,user_id from contest_leaderboard join (select @rn:=0) tmp where " . $where . "   order by score desc ) tmp WHERE user_id=" . $user_id." GROUP BY (user_id) order by rank ASC");


         $query = $this->db->query("SELECT * FROM (SELECT s.*, @rank := @rank + 1 rank FROM (SELECT user_id, max(score) as score, max(score) as max_scors, id, is_unlock FROM contest_leaderboard where " . $where . "  GROUP by user_id ORDER by score DESC ) s, (SELECT @rank := 0) init ORDER BY max_scors DESC) r where user_id=" . $user_id."");

        // p( $this->db->last_query());

        $row = $query->row();
        return $row;
    }

    public function getTodayTenRankByDate($where) {
        // $query = $this->db->query("select * from (select @rn:= @rn+1 as rank,id,score,user_id,is_unlock from contest_leaderboard join (select @rn:=0) tmp where " . $where . " order by score desc limit 10 ) tmp  GROUP BY (user_id) order by rank ASC ");


        $query = $this->db->query("SELECT * FROM (SELECT s.*, @rank := @rank + 1 rank FROM (SELECT user_id, max(score) as score, max(score) as max_scors, id, is_unlock FROM contest_leaderboard where " . $where . " GROUP by user_id ORDER by score DESC ) s, (SELECT @rank := 0) init ORDER BY max_scors DESC) r");


        // p( $this->db->last_query());
        $row = $query->result_array();
        return $row;
    }

    public function getAllRankByUserId($where) {
        $query = $this->db->query("select * from (select @rn:= @rn+1 as rank,id,total_score,fullname,profile_img from users join (select @rn:=0) tmp order by total_score desc  limit 10) tmp order by rank ASC ");
        $row = $query->result_array();
        return $row;
    }

    public function getContestTenRankByDate($where) {
        $query = $this->db->query("select * from (select @rn:= @rn+1 as rank,id,score,user_id from contest_save_report join (select @rn:=0) tmp where " . $where . " order by score desc limit 10 ) tmp  GROUP BY (user_id) order by rank ASC ");
        $row = $query->result_array();
        return $row;
    }


    public function getAllPractiseRankByUserId($where){
        $query = $this->db->query("select * from (select @rn:= @rn+1 as rank,id,total_score,fullname,profile_img,pratice_quiz_score from users join (select @rn:=0) tmp order by pratice_quiz_score desc  limit 10) tmp order by rank ASC ");
        $row = $query->result_array();
        return $row;
    }

    public function getCurrentPractiseRankByUserId($id) {
        $query = $this->db->query("select * from (select @rn:= @rn+1 as rank,id,total_score,fullname,profile_img,pratice_quiz_score from users join (select @rn:=0) tmp order by pratice_quiz_score desc ) tmp  where id='" . $id . "'  order by rank ASC ");
        $row = $query->row();
        return $row;
    }

    public function getTodayPractiseTenRankByDate($where) {
        $query = $this->db->query("select * from (select @rn:= @rn+1 as rank,id,score,user_id,is_unlock from pratice_leaderboard join (select @rn:=0) tmp where " . $where . " order by score desc limit 10 ) tmp  GROUP BY (user_id) order by rank ASC ");
        $row = $query->result_array();
        return $row;
    }

}

?>
