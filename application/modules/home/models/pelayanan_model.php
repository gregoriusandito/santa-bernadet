<?php
	class Pelayanan_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getPelayanan($id)
	{
		$this->db->where('pelayanan_id', $id); 
        $this->db->select("*");
        $this->db->from("pelayanan");
        
        return $this->db->get();
	}

	
}