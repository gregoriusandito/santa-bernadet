<?php
	class Seksi_model extends CI_Model  {
	function __construct() {
		parent::__construct();
	}

	function getSeksi($id)
	{
		$this->db->where('seksi_id', $id);
        $this->db->select("*");
        $this->db->from("seksi");

        return $this->db->get();
	}


}
