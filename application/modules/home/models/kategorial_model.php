<?php
	class Kategorial_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getKategorial($id)
	{
		$this->db->where('kategorial_id', $id); 
        $this->db->select("*");
        $this->db->from("kategorial");
        
        return $this->db->get();
	}

	
}