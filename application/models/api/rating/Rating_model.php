<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Rating_model extends CI_Model
{
	public function __construct(){
		$this->load->database();
	}
	public function get_pointByUserId($user_id){
		$this->db->select("total_points");
		$this->db->from("users");
		$this->db->where('id',$user_id);
		$q = $this->db->get();
		return $q->row();
	}  
}