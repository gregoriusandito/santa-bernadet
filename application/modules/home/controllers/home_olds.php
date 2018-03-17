<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

		$this->load->helper(array('url','download'));
		$this->load->database();
		$this->load->library(array('ion_auth'));

		$this->load->model("profile_model");
		$this->load->model("kategorial_model");
		$this->load->model("pelayanan_model");
		$this->load->model("download_model");
		$this->load->model("dph_model");
		$this->load->model("wilayah_model");
		$this->load->model("liputan_model");
		$this->load->model("serba_serbi_model");
		$this->load->model("pengalaman_model");
		$this->load->model("kaj_model");
		// $this->load->model("loker_model");
	}

	// redirect if needed, otherwise display the user list
	function index(){
		$data['posts'] = $this->db->query('SELECT * FROM posts WHERE post_id = 1 AND post_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['liputan'] = $this->db->query('SELECT p.*, CONCAT(u.first_name," ",u.last_name) AS nama FROM posts p LEFT JOIN users u ON u.id = p.post_author WHERE category_id = 10 AND post_status = 1 ORDER BY p.post_created DESC LIMIT 10');
		$data['serba_serbi'] = $this->db->query('SELECT p.*, CONCAT(u.first_name," ",u.last_name) AS nama FROM posts p LEFT JOIN users u ON u.id = p.post_author WHERE category_id = 12 AND post_status = 1 ORDER BY p.post_created DESC LIMIT 10');
		$data['pengalaman'] = $this->db->query('SELECT p.*, CONCAT(u.first_name," ",u.last_name) AS nama FROM posts p LEFT JOIN users u ON u.id = p.post_author WHERE category_id = 11 AND post_status = 1 ORDER BY p.post_created DESC LIMIT 3');
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kegiatan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 15 AND post_status = 1 LIMIT 8');

		if($this->input->post()){
			$remember = (bool) $this->input->post('remember');
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)){
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect(base_url().'administrator', 'refresh');
			}else{
				$this->ion_auth->increase_login_attempts($this->input->post('identity'));
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('administrator/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}

		$data['page'] = 'page/home';
		$this->load->view('core', $data);
	}

	function register_user(){
		$this->load->library(array('ion_auth'));
		$username = $this->input->post('first_name');
		$password = $this->input->post('password');
		$email = $this->input->post('email');
		$additional_data = array(
								'first_name' => $this->input->post('first_name'),
								'last_name' => $this->input->post('last_name'),
								);
		$group = array('2'); // Sets user to admin.

		if($this->ion_auth->register($username, $password, $email, $additional_data, $group)){
			$this->session->set_flashdata('registered', 1);
			redirect(base_url('home'));
		}else{
			$this->session->set_flashdata('registered', 0);
			redirect(base_url('home'));
		}
	}

	function profile($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_profile'] = $this->profile_model->getProfile($id);
		$data['page'] = 'page/profile';
		$this->load->view('core', $data);
	}

	function dph(){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['dph'] = $this->db->query('SELECT d.*, u.*, md.* FROM dph d LEFT JOIN users u ON u.id = d.`user_id` LEFT JOIN master_dph md ON md.`dph_id` = d.`dph_id`');
		$data['page'] = 'page/dph';
		$this->load->view('core', $data);
	}

	function detail_dph(){
		$id = $_GET['id'];
		$this->db->from('dph');
		$this->db->join('users','users.id = dph.user_id','LEFT');
		$this->db->join('master_dph','master_dph.dph_id = dph.dph_id','LEFT');
		$this->db->where('users.id', $id);

		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$data = $row;
			}
			echo json_encode($data);
		}
	}

	function kategorial($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_kategorial'] = $this->kategorial_model->getKategorial($id);
		$data['page'] = 'page/kategorial';
		$this->load->view('core', $data);
	}

	function liputan($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_liputan'] = $this->liputan_model->getLiputan($id);
		$data['page'] = 'page/liputan';
		$this->load->view('core', $data);
	}

	function serba_serbi($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_serba_serbi'] = $this->serba_serbi_model->getSerbaSerbi($id);
		$data['page'] = 'page/serba_serbi';
		$this->load->view('core', $data);
	}

	function pengalaman($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_pengalaman'] = $this->pengalaman_model->getPengalaman($id);
		$data['page'] = 'page/pengalaman';
		$this->load->view('core', $data);
	}

	function pelayanan($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_pelayanan'] = $this->pelayanan_model->getPelayanan($id);
		$data['page'] = 'page/pelayanan';
		$this->load->view('core', $data);
	}

	function wilayah($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		// $data['kategorial'] = $this->db->query('SELECT * FROM posts WHERE category_id = 4');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['wilayah_child'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 1');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['get_wilayah'] = $this->wilayah_model->getWilayah($id);
		$data['page'] = 'page/wilayah';
		$this->load->view('core', $data);
	}

	function kaj($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		// $data['kategorial'] = $this->db->query('SELECT * FROM posts WHERE category_id = 4');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['wilayah_child'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 1');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['get_kaj'] = $this->kaj_model->getKaj($id);
		$data['page'] = 'page/kaj';
		$this->load->view('core', $data);
	}

	function download($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
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
			$isi = file_get_contents(base_url().'uploads/'.$row->post_image);
			// print_r($isi);die;
			$nama = $row->post_image;
			force_download($nama,$isi);
		}
	}

	public function galery(){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['galery'] = $this->db->query('SELECT * FROM posts WHERE category_id = 13');
		$data['page'] = 'page/galery';
		$this->load->view('core', $data);
	}

	function company(){
		$option_name = $_GET['option_name'];
		$this->db->from('options');
		$this->db->where('option_name', $option_name);

		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$data = $row;
			}
			echo json_encode($data);
		}
	}

	function lowongan_kerja(){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['pelayanan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 6 AND post_status = 1');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['loker'] = $this->db->query('SELECT * FROM posts WHERE category_id = 14 AND post_status = 1');
		$data['page'] = 'page/loker';
		$this->load->view('core', $data);
	}

	function detail_loker(){
		$post_id = $_GET['post_id'];
		$this->db->from('posts');
		// $this->db->join('users','users.id = posts.post_author','LEFT');
		$this->db->where('posts.post_id', $post_id);

		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$data = $row;
			}
			echo json_encode($data);
		}
	}


}
