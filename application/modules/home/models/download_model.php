<?php
	class Download_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getDownload($id)
	{
		$this->db->where('post_id', $id); 
		$this->db->where('post_status', 1); 
        $this->db->select("*");
        $this->db->from("posts");
        
        return $this->db->get();
	}

	
}