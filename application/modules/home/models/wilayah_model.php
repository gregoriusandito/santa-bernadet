<?php
	class Wilayah_model extends CI_Model  {
	function __construct() { 
		parent::__construct(); 
	} 

	function getWilayah($id)
	{
		$this->db->from('wilayah');
		$this->db->join('users','users.id = wilayah.user_id','LEFT');
		$this->db->where('wilayah_id', $id);
        
        return $this->db->get();
	}
	
	function get_new_wilayah($id)
	{
		$this->db->from('new_wilayah');
		$this->db->where('wilayah_id', $id);
		$this->db->order_by('wilayah_title', 'ASC');
        return $this->db->get();
	}	

	
}