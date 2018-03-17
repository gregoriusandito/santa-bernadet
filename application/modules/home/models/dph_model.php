<?php
	class Dph_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getDph($id)
	{
		$this->db->where('id', $id); 
        $this->db->select("*");
        $this->db->from("users");
        
        return $this->db->get();
	}
	
	function getPage($id)
	{
		$this->db->where('page_id', $id); 
        $this->db->select("*");
        $this->db->from("page");
        
        return $this->db->get();
	}	

	
}