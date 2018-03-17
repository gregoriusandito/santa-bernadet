<?php
	class Kaj_model extends CI_Model  {
	function __construct() {
		parent::__construct();
	}

	function getKaj($id)
	{
		$this->db->select('kaj.*, users.first_name AS first_name, users.last_name AS last_name');
		$this->db->from('kaj');
		$this->db->join('users','users.id = kaj.create_by','LEFT');
		// $this->db->where('category_id', 10);
		$this->db->where('id_kaj', $id);

        return $this->db->get();
	}


}
