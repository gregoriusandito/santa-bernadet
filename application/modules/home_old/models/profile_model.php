<?php
	class Profile_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getProfile($id)
	{
		$this->db->where('profile_id', $id); 
        $this->db->select("*");
        $this->db->from("profile");
        
        return $this->db->get();
	}

	
}