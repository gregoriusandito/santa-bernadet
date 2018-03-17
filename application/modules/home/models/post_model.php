<?php
	class Post_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getPost($id) {
		$this->db->select('posts.*, users.first_name AS first_name, users.last_name AS last_name');
		$this->db->from('posts');
		$this->db->join('users','users.id = posts.post_author','LEFT');
		$this->db->join('categories','categories.category_id = posts.category_id');
		$this->db->where('post_id', $id);
		$this->db->where('post_status', 1);
        
        return $this->db->get();
	}
	
	function getPostDate($id) {
		$this->db->select('posts.post_created');
		$this->db->from('posts');
		$this->db->join('users','users.id = posts.post_author','LEFT');
		$this->db->join('categories','categories.category_id = posts.category_id');
		$this->db->where('post_id', $id);
		$this->db->where('post_status', 1);
        
        foreach ( $this->db->get()->result() as $value ) :
        	$data = $value;
        endforeach;	
        
        return $data;
	}
	
	function getPostDetailForOG($id) {
		$this->db->select('posts.post_title, posts.post_image, posts.post_content');
		$this->db->from('posts');
		$this->db->join('users','users.id = posts.post_author','LEFT');
		$this->db->join('categories','categories.category_id = posts.category_id');
		$this->db->where('post_id', $id);
		$this->db->where('post_status', 1);
        
        foreach ( $this->db->get()->result() as $value ) :
        	$data[] = $value;
        endforeach;	
        
        return $data;
	}	
	
}