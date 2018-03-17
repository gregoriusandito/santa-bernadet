<?php
	class Pelayanan_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getPelayanan($id)
	{
		$this->db->where('post_id', $id); 
        $this->db->select("*");
        $this->db->from("posts");
        
        return $this->db->get();
	}

	
}