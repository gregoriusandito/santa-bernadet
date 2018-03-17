<?php
	class Pengalaman_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getPengalaman($id)
	{
		$this->db->select('posts.*, users.first_name AS first_name, users.last_name AS last_name');
		$this->db->from('posts');
		$this->db->join('users','users.id = posts.post_author','LEFT'); 
		$this->db->where('category_id', 11); 
		$this->db->where('post_id', $id);
        
        return $this->db->get();
	}

	
}