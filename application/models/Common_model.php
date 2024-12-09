<?php 

if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Login_model (Login Model)
 * Login model class to get to authenticate user credentials 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Common_model extends CI_Model
{
    
    public function __construct()
    {
        $this->load->database();
    }

    public function getCount($where,$tablename)
    {
        $this->db->select('*');
        $this->db->from($tablename);
        if(!empty($where)){
          $this->db->where($where);
        }
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    public function updateByIdWithcount($id,$field_name,$value,$tablename){

        $this->db->set($field_name, $field_name.'+'.$value, FALSE);
        $this->db->where('id', $id);
        $this->db->update($tablename);
        return $id; 
    } 

    public function get_video_by_hashtag($hashtagId){
       
        $where12 = 'FIND_IN_SET('.$hashtagId.',video.hashtag_id) !=0';
        $this->db->select("video.id,video.video_url,video.user_id,video.user_id,user.fullname,video.c_date");
        $this->db->from("video");
        $this->db->join('user', 'user.id = video.user_id');
        $this->db->where($where12);
        $this->db->where('contest_id',0);
        $this->db->where('video.status=1');
        $q = $this->db->get();
        return $q->result_array();
    }

    public function get($where, $tablename, $field_name = null, $order_by = 'desc')
    {
        $this->db->select('*');
        $this->db->from($tablename);
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($field_name) {
            $this->db->order_by($field_name, $order_by);
        }
        $query = $this->db->get();
        $row = $query->result();
        return $row;
    }

    public function getCountData($where,$tableName, $groupBy, $count) {
        if($count){
            $this->db->select($count);
        }else{
            $this->db->select($tableName.'.*');
        }
        
        $this->db->from($tableName);        
        if ($where) {
            $this->db->where($where);
        }
        
        if ($groupBy) {
            $this->db->group_by($groupBy);
        }
        $q = $this->db->get();
        $row = $q ->row();
        return $row;
    }

    public function getCountDataOrderBy($where,$tableName, $groupBy, $count,$order_by,$order_by_field,$limit) {
        
        $this->db->select($count);
        
        $this->db->from($tableName);  

        $this->db->join('users', 'users.id = contest_leaderboard.user_id');
  
        if ($where) {
            $this->db->where($where);
        }
        
        if ($groupBy) {
            $this->db->group_by($groupBy);
        }

        if ($order_by_field) {
            $this->db->order_by($order_by_field, $order_by);
        }

        if ($order_by_field) {
            $this->db->limit($limit);
        }

        $q = $this->db->get();
        $row = $q ->result();
        return $row;
    }

    public function getById($where,$tablename)
    {
    	$this->db->select('*');
    	$this->db->from($tablename);
    	if(!empty($where)){
    		$this->db->where($where);
    	}
        $this->db->order_by("id", "desc");
    	$query = $this->db->get();
        $row = $query->row_array();
    	return $row;
    }

    public function get_join_allrecord($table1, $table2, $joinid, $field, $where=null) {
        $this->db->select($field);
        $this->db->from($table1);
        $this->db->join($table2, $joinid);

        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    public function get_join($data)
    {
        $where = isset($data['where']) ? $data['where'] : '';
        $group_by = isset($data['group_by']) ? $data['group_by'] : '';
        $order_by_field = isset($data['order_by_field']) ? $data['order_by_field'] : '';
        $order_by = isset($data['order_by']) ? $data['order_by'] : '';
        $page_no = isset($data['page_no']) ? $data['page_no'] : '';
        $page_limit = isset($data['page_limit']) ? $data['page_limit'] : '';
        
        $this->db->select($data['field']);
        $this->db->from($data['table']);

        foreach ($data['joins'] as $joins) {
            $this->db->join($joins['table'], $joins['join']);
        }

        if($where){
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


    public function getLastRecord($where,$tablename)
    {
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where($where);
        $this->db->limit(1);
        $this->db->order_by('id',"desc");
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }

    public function insert($data,$tablename){
    	$isInsert = isInsert();
        if($isInsert  == 1)
        {
          return true;
        }

        $query = $this->db->insert($tablename,$data);
        return $this->db->insert_id();
    }

    public function update($id, $field_name, $data, $tablename)
    {
        $isInsert = isInsert();
        if ($isInsert == 1) {
            return true;
        }

        $data = $this->security->xss_clean($data);

        $this->db->where($field_name, $id);
        $this->db->update($tablename, $data);
        return $id;
    } 

	public function updateById($id,$field_name,$data,$tablename){
	   $isInsert = isInsert();
		if($isInsert  == 1)
		{
			return true;
		}

        $this->db->where($field_name, $id);
        $this->db->update($tablename, $data);
      	return $id; 
    } 

	public function  delete($where,$tablename)
	{
		$isInsert = isInsert();
		if($isInsert  == 1)
		{
			return true;
		}

		$this->db->where($where);
		$this->db->delete($tablename);
		return true;
    }

	public function delete_all($id,$field_name,$tablename)
	{
		$isInsert = isInsert();
		if($isInsert  == 1)
		{
			return true;
		}
		$this->db->where($field_name, $id);
		$this->db->delete($tablename);
		return true; 
	}

    public function removeItem($ItemPath)
    {
        if($ItemPath)
        {   
            if (file_exists($ItemPath)) {
                unlink($ItemPath);
            }
        }
    }
    
    // Image Upload function
    public function imageupload($imageName,$imgname, $uploadpath){

        if (!file_exists($uploadpath)) {
            mkdir($uploadpath, 0777, true);
        }

        if(empty($imageName['name'])){
            $res=array('status'=>'400','msg'=>'Please Upload Image first.');
            echo json_encode($res);exit;
        }

        if(!empty($imageName['name']) && ($imageName['error']==1 || $imageName['size']>22150000)){
            $res=array('status'=>'202','msg'=>'Max 2MB file is allowed for image.');
            echo json_encode($res);exit;
        }else{
            list($width, $height) = getimagesize($imageName['tmp_name']);
            if($width>5000 || $height >5000){
                $res=array('status'=>'201','msg'=>'Image height and width must be less than 1000px.');
                echo json_encode($res);exit;
            }else{
                $catImg = $imageName['name'];
                $ext = pathinfo($catImg);
                $catImages = str_replace(array(' ', '.', '-', '`'), '_', $ext['filename']);
                $category_image =time().'.'.$ext['extension'];       
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
  
    public function settings_data(){
        $this->db->select("*");
        $this->db->from("general_setting"); 
        $q = $this->db->get();
        return $q->result();
    }

    public function get_appointmentList($doctor_id=Null,$name=Null) {

        $this->db->select('appointment.*');
        $this->db->from('appointment');
        $this->db->join('doctor', 'doctor.id = appointment.doctor_id');
        $this->db->join('patients', 'patients.id = appointment.patient_id');
        $this->db->order_by("c_date", "desc");
        if($name)
        {
            $this->db->like('patients.fullname', $name);
        }
        if($doctor_id > 0)
        {
            $this->db->where('appointment.doctor_id',$doctor_id);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function appointmentList($limit, $start,$doctor_id,$name=Null) {
        $offset = ($limit * $start) - $limit;
        $this->db->limit($limit, $offset);
        $this->db->select('appointment.*,patients.fullname as patient_name,doctor.first_name,doctor.last_name');
        $this->db->from('appointment');
        $this->db->join('doctor', 'doctor.id = appointment.doctor_id');
        $this->db->join('patients', 'patients.id = appointment.patient_id');
        if($name)
        {
            $this->db->like('patients.fullname', $name);
        }
        if($doctor_id > 0)
        {
            $this->db->where('appointment.doctor_id',$doctor_id);
        }
        
        $this->db->order_by("c_date", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }


    public function getBylimit($where,$tablename,$limit,$order_by,$field)
    {
        $this->db->select('participants_rating.*,user.fullname');
        $this->db->from($tablename);
        $this->db->join("user", "participants_rating.user_id = user.id");
        $this->db->where($where);
        $this->db->limit($limit);
        $this->db->order_by($field, $order_by);
        $query = $this->db->get();
        $row = $query->result_array();
        return $row;
    }

    /*=================End Banner====================*/
    public function get_witdrawal_requrst(){
        $this->db->select("withdrawal_request.*,users.first_name,users.last_name");
        $this->db->from("withdrawal_request");
        $this->db->join('users', 'users.id = withdrawal_request.user_id');
        $this->db->order_by("created_at", "desc");
        $q = $this->db->get();
        return $q->result_array();
    }

    public function generateUserReferCode($tableName,$fieldName){
        $referCode = uniqid();
        $where = $fieldName."='".$referCode."'";
        $userslist = $this->getById($where, $tableName);
        if(isset($userslist['id'])){
            $this->generateUserReferCode($tableName,$fieldName);
        }
        return $referCode;
    }

    public function getRankByContestId($where, $limit = '') {
        $limitBy = 'limit ' . $limit;
        $query = $this->db->query("select * from (select @rn:= @rn+1 as rank,id,contest_id,score,user_id from contest_save_report join (select @rn:=0) tmp where " . $where . " order by score desc " . $limitBy . ") tmp  GROUP BY (user_id) order by rank ASC ");

        $row = $query->result_array();
        return $row;
    }

    public function make_query($table, $select_column, $order_column, $searcharray = null, $where = null) {
        $this->db->select($select_column);
        $this->db->from($table);

        $text = 'id >0 ';

        if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
            if ($searcharray) {
                $text .= ' AND (';
                foreach ($searcharray as $key => $value) {
                    if (count($searcharray) == $key + 1) {
                        $text .= $value . ' LIKE "%' . $_POST["search"]["value"] . '%"';
                    } else {
                        $text .= $value . ' LIKE "%' . $_POST["search"]["value"] . '%" OR ';
                    }
                }
                $text .= ')';
            }
        }
        $this->db->where($text);

        if ($where) {
            $this->db->where($where);
        }

        if (isset($_POST["order"])) {
            $this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'DESC');
        }
    }

    public function make_datatables($table, $select_column, $order_column, $search = null, $where = null) {

        $this->make_query($table, $select_column, $order_column, $search, $where);
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data($table, $select_column, $order_column, $search = null, $where = null) {

        $this->make_query($table, $select_column, $order_column, $search, $where);
        $query = $this->db->get();
        if ($where) {
            $this->db->where($where);
        }
        return $query->num_rows();
    }

    public function get_all_data($table, $where = null) {
        $this->db->select("*");
        $this->db->from($table);
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->count_all_results();
    }
}
?>
