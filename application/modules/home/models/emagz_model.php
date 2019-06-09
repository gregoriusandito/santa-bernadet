<?php
	class Emagz_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getEmagz($id) {
		$this->db->select('emagz.*, users.first_name AS first_name, users.last_name AS last_name');
		$this->db->from('emagz');
		$this->db->join('users','users.id = emagz.post_author','LEFT');
		// $this->db->join('categories','categories.category_id = posts.category_id');
		$this->db->where('post_id', $id);
		$this->db->where('post_status', 1);
        
        return $this->db->get();
	}
	
	function getEmagzDate($id) {
		$this->db->select('emagz.post_created');
		$this->db->from('emagz');
		$this->db->join('users','users.id = emagz.post_author','LEFT');
		// $this->db->join('categories','categories.category_id = posts.category_id');
		$this->db->where('post_id', $id);
		$this->db->where('post_status', 1);
        
        foreach ( $this->db->get()->result() as $value ) :
        	$data = $value;
        endforeach;	
        
        return $data;
	}
	
	function getEmagzDetailForOG($id) {
		$this->db->select('emagz.post_title, emagz.post_image, emagz.post_content');
		$this->db->from('emagz');
		$this->db->join('users','users.id = emagz.post_author','LEFT');
		// $this->db->join('categories','categories.category_id = posts.category_id');
		$this->db->where('post_id', $id);
		$this->db->where('post_status', 1);
        
        foreach ( $this->db->get()->result() as $value ) :
        	$data[] = $value;
        endforeach;	
        
        return $data;
	}	
	
}