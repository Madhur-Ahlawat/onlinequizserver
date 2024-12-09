<?php defined('BASEPATH') OR exit('No direct script access allowed');

class admin_modal extends CI_Model
{
	public function __construct(){
		$this->load->database();
	}

	public function verify_admin($where){
		
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where($where);
		$query = $this->db->get();
		$row = $query->row_array();
		return $row;
	}

	/*=================Category=====================*/

	public function get_category($where){
		$this->db->select("*");
		$this->db->from("category");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	public function getCategoryBivideoId()
	{
		$this->db->select("category.*");
	    $this->db->from("video");
	    $this->db->join('category', 'category.id = video.cat_id');
	    $this->db->group_by("cat_id");
	    $this->db->order_by("category.category_name", "asc");
	    $query = $this->db->get();
		$result =  $query->result();
		return $result;
	}
	public function get_categoryList(){
		$this->db->select('*');
		$this->db->from('category');
		$this->db->order_by("m_date", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function insert_ctegory($data){
		$query = $this->db->insert('category',$data);
		return $this->db->insert_id();
	}

	public function delete_category($id){
		$this->db->delete('category', array('id' => $id)); 
		return true;
	}


	public function update_status_category($id,$status){
		$this->db->where('id', $id);
		return $this->db->update('category', $status);
	}

	public function delete_sound($id){
		$this->db->delete('sound', array('id' => $id));
		return true; 
	}
	/*=================End Category=====================*/


	/*=================User====================*/

	public function get_userList(){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->order_by("c_date", "DESC");
		$query = $this->db->get();
		return $query->result_array();
	}

	public function insert_user($data){
		$query = $this->db->insert('user',$data);
		return $this->db->insert_id();
	}

	public function userlist_by_where($where){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function update_user($id,$data){
		$this->db->where('id', $id);
		return $this->db->update('user', $data);
	}

	public function delete_user($id){
		$this->db->delete('user', array('id' => $id));
		return true; 
	}

	/*=================End User====================*/

	
	public function get_video($where){
		$this->db->select("*");
		$this->db->from("video");
		$this->db->order_by("m_date", "desc");
		$this->db->where($where);
		$q = $this->db->get();
		return $q->result();
	}

	


	public function insert_video($data){
		$query = $this->db->insert('video',$data);
		return $this->db->insert_id();
	}

	public function delete_video($id){
		$this->db->delete('video', array('id' => $id)); 
		return true;
	}


	public function update_status_video($id,$data){
		$this->db->where('id', $id);
		$this->db->update('video', $data);
		return true;
	}

	public function update_general_setting($data,$where){
		$this->db->where('key', $where);
		$this->db->update('general_setting', $data);
		return true;
	}

	/*==================Banner=====================*/

	public function bannerlist(){
		$this->db->select('*');
		$this->db->from('banner');
		$this->db->order_by("c_date", "desc");
		$query = $this->db->get();
		return $query->result_array();
	}

	/*=================End Banner====================*/
	public function get_witdrawal_requrst(){
		$this->db->select("withdrawal_request.*,user.first_name,user.last_name");
		$this->db->from("withdrawal_request");
		$this->db->join('user', 'user.id = withdrawal_request.user_id');
		$this->db->order_by("created_at", "desc");
		$q = $this->db->get();
		return $q->result_array();
	}

	public function imageupload($imageName,$imgname, $uploadpath){

		if(empty($imageName['name'])){
			$res=array('status'=>'400','msg'=>'Please Upload Image first.');
			echo json_encode($res);exit;
		}
		if(!empty($imageName['name']) && ($imageName['error']==1 || $imageName['size']>2215000)){
			$res=array('status'=>'400','msg'=>'Max 2MB file is allowed for image.');
			echo json_encode($res);exit;
		}else{
			list($width, $height) = getimagesize($imageName['tmp_name']);
			if($width>1000 || $height >1000){
				$res=array('status'=>'400','msg'=>'Image height and width must be less than 1000px.');
				echo json_encode($res);exit;
			}else{

				$catImg = $imageName['name'];
				$ext = pathinfo($catImg);
				$catImages = str_replace(array(' ', '.', '-', '`'), '_', $ext['filename']);
				$category_image =$catImages.time().'.'.$ext['extension'];				
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
}