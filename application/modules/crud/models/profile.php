<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Model {

	/**
	 * aLL Select Query
	 * @return [type] [description]
	 */
	function get_all()
	{
		$this->db->select('*')
				->from('profile')
				->join('users', 'users.id = profile.profile_author');
		return $this->db->get()->result();
	}
	
	function get_one($id = null)
	{
		$this->db->from('profile')
				->join('users', 'users.id = profile.profile_author')->where('profile_id', $id);
		return $this->db->get()->row();
	}

	/**
	 * [get_all description]
	 * @return [type] [description]
	 */
	function delete_by_id($id = null)
	{

		$this->db->from('profile');
		$this->db->where('profile_id', $id);
		$data = $this->db->get()->row();
		// print_r($data);

		$path_to_file = './uploads/'.$data->profile_image;
		// echo $path_to_file;die;

		if(unlink($path_to_file)) {
			$this->db->from('profile');
			$this->db->where('profile_id', $id);
			$delete = $this->db->delete(); 
			if($delete == TRUE){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}


	/**
	 * All Update Query
	 * @param string $value [description]
	 */
	function set_status($id = null,$param = null)
	{
		$_POST['profile_status'] = $param;

        $this->form_validation->set_rules('profile_status', 'Status', 'trim|numeric|xss_clean');
		
		if ($this->form_validation->run() == TRUE) 
		{
			$this->db->set('profile_status', $param);
			$this->db->where('profile_id', $id);
			$this->db->update('profile');
			return true;
		} 
		echo validation_errors();die;
	}


	function validation()
	{
		// $this->form_validation->set_data($data);
        $this->form_validation->set_rules('profile_status', 'Status', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('profile_profil', 'Judul', 'trim|required|unique|xss_clean');
        $this->form_validation->set_rules('profile_isi', 'Isi', 'trim|required|xss_clean');

       	return $run = $this->form_validation->run();

	}



}

/* End of file konten.php */
/* Location: ./application/models/konten.php */
