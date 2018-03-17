<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		
		$this->load->helper(array('url','download'));
		
		$this->load->model("profile_model");
		$this->load->model("kategorial_model");
		$this->load->model("pelayanan_model");
		$this->load->model("download_model");
	}

	// redirect if needed, otherwise display the user list
	function index(){
		$data['posts'] = $this->db->query('SELECT * FROM posts WHERE post_id = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM posts WHERE category_id = 4');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7');
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1 LIMIT 8');
		$data['page'] = 'page/home';
		$this->load->view('core', $data); 
	}
	
	function profile($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM posts WHERE category_id = 4');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7');
		$data['get_profile'] = $this->profile_model->getProfile($id);
		$data['page'] = 'page/profile';
		$this->load->view('core', $data);
	}
	
	function kategorial($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM posts WHERE category_id = 4');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7');
		$data['get_kategorial'] = $this->kategorial_model->getKategorial($id);
		$data['page'] = 'page/kategorial';
		$this->load->view('core', $data);
	}
	
	function pelayanan($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM posts WHERE category_id = 4');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7');
		$data['get_pelayanan'] = $this->pelayanan_model->getPelayanan($id);
		$data['page'] = 'page/pelayanan';
		$this->load->view('core', $data);
	}
	
	function download($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM posts WHERE category_id = 4');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7');
		$data['get_download'] = $this->download_model->getDownload($id);
		$data['page'] = 'page/download';
		$this->load->view('core', $data);
	}
	
	public function lakukan_download($id){
		$url = site_url().'uploads/';
		// print_r($url);die;
		$query = $this->db->get_where('posts', array('post_id' => $id));
		
		foreach ($query->result() as $row)
		{
			// $isi = $url.$row->post_image;
			$isi = file_get_contents(base_url().'uploads/'.$row->post_image);
			// print_r($isi);die;
			$nama = $row->post_image;
			force_download($nama,$isi);
		}
			
		
		
	}	
	
}
