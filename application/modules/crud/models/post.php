<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Model {

	/**
	 * aLL Select Query
	 * @return [type] [description]
	 */
	function get_all()
	{
		$this->db->select('*')
				->from('posts')
				->join('users', 'users.id = posts.post_author');
		return $this->db->get()->result();
	}
	
	function get_one($id = null)
	{
		$this->db->from('posts')
				->join('users', 'users.id = posts.post_author')->where('post_id', $id);
		return $this->db->get()->row();
	}

	/**
	 * [get_all description]
	 * @return [type] [description]
	 */
	function delete_by_id($id = null)
	{

		$this->db->from('posts');
		$this->db->where('post_id', $id);
		$data = $this->db->get()->row();
		// print_r($data);

		$path_to_file = './uploads/'.$data->post_image;
		// echo $path_to_file;die;

		if(unlink($path_to_file)) {
			$this->db->from('posts');
			$this->db->where('post_id', $id);
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
		$_POST['post_status'] = $param;

        $this->form_validation->set_rules('post_status', 'Status', 'trim|numeric|xss_clean');
		
		if ($this->form_validation->run() == TRUE) 
		{
			$this->db->set('post_status', $param);
			$this->db->where('post_id', $id);
			$this->db->update('posts');
			return true;
		} 
		echo validation_errors();die;
	}


	function validation()
	{
		// $this->form_validation->set_data($data);
        $this->form_validation->set_rules('post_status', 'Status', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('post_profil', 'Judul', 'trim|required|unique|xss_clean');
        $this->form_validation->set_rules('post_isi', 'Isi', 'trim|required|xss_clean');

       	return $run = $this->form_validation->run();

	}



}

/* End of file konten.php */
/* Location: ./application/models/konten.php */
