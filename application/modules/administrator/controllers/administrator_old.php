<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth'));
		$this->load->helper(array('url','language'));

		$this->lang->load('auth');
		date_default_timezone_set('Asia/Jakarta');

		$this->load->model('crud/profile');
		$this->load->model('crud/dph');
		$this->load->model('crud/post');
	}

	// redirect if needed, otherwise display the user list
	function index(){

		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		// elseif (!$this->ion_auth->is_admin()){
		// 	return show_error('You must be an administrator to view this page.');
		// }
		else
		{
			$this->data['users'] = $this->ion_auth->user()->row();
			$this->data['page'] = 'administrator/dashboard';
			$this->load->view('administrator/index', $this->data);
		}
	}
	
	function login(){
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
		}else{
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->load->view('administrator/login');
		}
	}
	
	function logout(){
		$this->data['title'] = "Logout";

		$logout = $this->ion_auth->logout();

		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('administrator/login', 'refresh');
	}

	function all_users(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}

		$this->data['all_users'] = $this->ion_auth->users()->result();
		foreach ($this->data['all_users'] as $k => $user){
			$this->data['all_users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
		}
		// echo'<pre>';
		// print_r($this->data['all_users']);die;
		$this->data['users'] = $this->ion_auth->user()->row();
		$this->data['page'] = 'administrator/all_users';
		$this->load->view('administrator/index', $this->data);
	}
	
	function new_user(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		$tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;
		
		if($this->input->post()){
            
			////////////////////////////////////////////////////////
			$config['upload_path'] = './uploads/user/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$new_name = time().'_'.$_FILES["file"]['name'];
			$config['file_name'] = $new_name;
			$this->load->library('upload', $config);

			$statUpload = false;
			if ($this->upload->do_upload('file')) 
			{
				$upload_data = $this->upload->data();
				// $this->_createThumbnail($upload_data['file_name']);
				$statUpload = true;

				// $path_to_file = './uploads/user/'.$dataProfiles->profile_image;

				// $hapus = unlink($path_to_file);
				// if (!$hapus) 
				// {
				// 	echo "<script>alert('Gagal mengahpus file lama'); </script>";
				// }
			}
			////////////////////////////////////////////////////////




			$email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='identity') ? $email : $this->input->post('email');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'alamat'  => $this->input->post('alamat'),
                'phone'  => $this->input->post('phone'),
                'hp'  => $this->input->post('hp'),
                'foto' => ($statUpload)? $upload_data['file_name'] : NULL ,
            );
			
			$groups = array($this->input->post('groups_id'));
			
			if ($id = $this->ion_auth->register($identity, $password, $email, $additional_data, $groups)){
				// Set dph user
				$this->dph->add_to_dph($this->input->post('dph_id'), $id);
				
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("administrator/all_users", 'refresh');
			}else{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("administrator/new_user", 'refresh');
			}
		}else{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['users'] = $this->ion_auth->user()->row();
			$this->data['page'] = 'administrator/new_user';
			$this->load->view('administrator/index', $this->data);
		}
	}
	
	function activate($id = NULL){
		$id = (int) $id;
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()){
			$this->ion_auth->activate($id);
		}
		redirect(base_url().'administrator/all_users', 'refresh');
	}
	
	function deactivate($id = NULL){
		$id = (int) $id;
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()){
			$this->ion_auth->deactivate($id);
		}
		redirect(base_url().'administrator/all_users', 'refresh');
	}
	
	function edit_user($id){
		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))){
			redirect(base_url().'administrator/all_users', 'refresh');
		}
		
		$user = $this->ion_auth->user($id)->row();
		
		if($this->input->post()){

			////////////////////////////////////////////////////////
			$statUpload = false;
			if (!empty($_FILES)) {
				$config['upload_path'] = './uploads/user/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$new_name = time().'_'.$_FILES["file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				if ($this->upload->do_upload('file')) 
				{
					$upload_data = $this->upload->data();
				// $this->_createThumbnail($upload_data['file_name']);
					$statUpload = true;

					$path_to_file = './uploads/user/'.$user->foto;

					$hapus = true;
					if ($user->foto) {
						$hapus = unlink($path_to_file);
					}
					if (!$hapus) 
					{
						echo "<script>alert('Gagal mengahpus file lama'); </script>";
					}
				}
			}
			////////////////////////////////////////////////////////



            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'alamat'  => $this->input->post('alamat'),
                'phone'  => $this->input->post('phone'),
                'hp'  => $this->input->post('hp'),
                'foto' => ($statUpload)? $upload_data['file_name'] : NULL ,
                
            );

            $groups = $this->ion_auth->get_users_groups($user->id)->row();
			$groupsid = ($groups) ? $groups->id : '';

            $dph = $this->dph->get_users_dph($user->id)->row();
			// $dphid = ($dph) ? $dph->id : '';
			$dphid = ($dph) ? $dph->id : 0;


			if ($groupsid !== $this->input->post('groups_id') && $this->ion_auth->is_admin() ) {
				$this->ion_auth->add_to_group($this->input->post('groups_id'), $user->id);
				if ($groupsid !== '') {
					$this->ion_auth->remove_from_group($groupsid, $user->id);
				}
			}

			if ($dphid !== $this->input->post('dph_id') && $this->ion_auth->is_admin() ) {
				$this->dph->add_to_dph($this->input->post('dph_id'), $user->id);
				if ($dphid !== 0) {
					$this->dph->remove_from_dph($dphid, $user->id);
				}
			}

			if ($this->input->post('password')){
				$data['password'] = $this->input->post('password');
			}
			
			if ($this->ion_auth->update($user->id, $data)){
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("administrator/all_users", 'refresh');
			}else{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("administrator/edit_user/".$id, 'refresh');
			}
		}else{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['users'] = $this->ion_auth->user()->row();
			$this->data['user'] = $user;
			$this->data['page'] = 'administrator/new_user';
			$this->load->view('administrator/index', $this->data);
		}
	}
	
	function all_slider(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		$data['slider'] = $this->db->get('slider')->result();
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/all_slider';
		$this->load->view('administrator/index', $data);
	}
	
	function new_slider(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/new_slider';
		$this->load->view('administrator/index', $data);
	}
	
	function upload_slider(){
		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$fileName = time().'_'.$_FILES['file']['name'];
			$targetPath = getcwd() . '/uploads/slider/';
			$targetFile = $targetPath . $fileName ;
			move_uploaded_file($tempFile, $targetFile);
			// if you want to save in db,where here
			// with out model just for example
			// $this->load->database(); // load database
			$query = $this->db->insert('slider',array('img_slider' => $fileName, 'active' => 1));
        }
	}
	
	function delete_slider($id){
		$this->load->helper("file");
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		$slider = $this->db->where('id_slider', $id)->get('slider')->row();
		
		$path_to_file = './uploads/slider/'.$slider->img_slider;
		
		if(unlink($path_to_file)) {
			$delete = $this->m_crud->delete_data($id, 'id_slider', 'slider');
			if($delete == TRUE){
				redirect(base_url().'administrator/all_slider');
			}else{
				redirect(base_url().'administrator/all_slider');
			}
		}else{
			redirect(base_url().'administrator/all_slider');
		}
	}
	
	function options(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		$data['options'] = $this->db->get('options')->result();
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/options';
		$this->load->view('administrator/index', $data);
	}
	
	function update_website_option(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		if($this->input->post('sitename')){
			$update = $this->m_crud->update_data('1', 'option_id', Array('option_value'=>$this->input->post('sitename')), 'options');
		}
		
		if($this->input->post('sitedescription')){
			$update = $this->m_crud->update_data('2', 'option_id', Array('option_value'=>nl2br($this->input->post('sitedescription'))), 'options');
		}
		
		if($this->input->post('office')){
			$update = $this->m_crud->update_data('3', 'option_id', Array('option_value'=>$this->input->post('office')), 'options');
		}
		
		if($this->input->post('about')){
			$update = $this->m_crud->update_data('4', 'option_id', Array('option_value'=>nl2br($this->input->post('about'))), 'options');
		}
		
		if($this->input->post('contact')){
			$update = $this->m_crud->update_data('9', 'option_id', Array('option_value'=>nl2br($this->input->post('contact'))), 'options');
		}
		
		if($this->input->post('facebook')){
			$update = $this->m_crud->update_data('5', 'option_id', Array('option_value'=>nl2br($this->input->post('facebook'))), 'options');
		}
		
		if($this->input->post('twitter')){
			$update = $this->m_crud->update_data('6', 'option_id', Array('option_value'=>nl2br($this->input->post('twitter'))), 'options');
		}
		
		if($this->input->post('instagram')){
			$update = $this->m_crud->update_data('7', 'option_id', Array('option_value'=>nl2br($this->input->post('instagram'))), 'options');
		}
		
		if($this->input->post('youtube')){
			$update = $this->m_crud->update_data('8', 'option_id', Array('option_value'=>nl2br($this->input->post('youtube'))), 'options');
		}
		
		redirect(base_url().'administrator/options');
	}
	
	function upload_logo(){
		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$file_p = explode('.', $_FILES['file']['name']);
			$ext = end($file_p);
			$fileName = 'logo.png';
			$targetPath = getcwd() . '/uploads/company/';
			$targetFile = $targetPath . $fileName ;
			if($ext == 'png' || $ext == 'jpg'){
				if(move_uploaded_file($tempFile, $targetFile)){
					redirect(base_url().'administrator/options','refresh');
				}
			}else{
				$this->session->set_flashdata('msg_upload','Extention Not Supported');
			}
        }
	}
	
	function all_category(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		$act = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$cat = '';
		
		if($id){
			$query = $this->db->where('category_id', $id)->get('categories')->row();
			$cat = $query->category_title;
		}
		
		if($act == 'del'){
			$this->m_crud->delete_data($id, 'category_id', 'categories');
			redirect(base_url().'administrator/all_category');
		}
		
		if($this->input->post()){
			$data = Array(
				'category_title' => $this->input->post('category_title'),
			);
			
			if($act == 'edit'){
				$this->m_crud->update_data($id, 'category_id', $data, 'categories');
				redirect(base_url().'administrator/all_category');
			}
			
			$save = $this->m_crud->save_data($data, 'categories');
			if($save == TRUE){
				redirect(base_url().'administrator/all_category');
			}else{
				redirect(base_url().'administrator/all_category');
			}
		}else{
			$data['cat'] = $this->m_crud->get_data('*','categories','')->result();
			$data['users'] = $this->ion_auth->user()->row();
			$data['value'] = $cat;
			$data['page'] = 'administrator/all_category';
			$this->load->view('administrator/index', $data);
		}
	}



	function set_category($id = NULL,$param = NULL){
		$id = (int) $id;
		$param = (int) $param;

		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}

		$update = $this->m_crud->update_data($id, 'category_id', ['category_type' => $param], 'categories'); 
		if($update)
		{
			redirect(base_url().'administrator/all_category', 'refresh');
		}
		echo "<script>
		alert('Activate failed');
		window.location='".base_url()."administrator/all_post'; 
		</script>";
	}




	
	function all_post(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		else if ($this->ion_auth->is_admin()) {
			$where = '';
		}
		else {
			$where = 'WHERE post_author = "'.$this->ion_auth->user()->row()->id.'"';
		}


		$data['post'] = $this->m_crud->get_data('*','posts',' INNER JOIN users ON users.id = posts.post_author LEFT JOIN categories ON categories.category_id = posts.category_id '.$where)->result();
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/all_post';
		$this->load->view('administrator/index', $data);
	}
	
	function new_post(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		// elseif(!$this->ion_auth->is_admin()){
		// 	return show_error('You must be an administrator to view this page.');
		// }
		
		if($this->input->post()){

			$_POST['post_slug'] = strtolower(url_title($this->input->post('post_title')));

			$this->form_validation->set_rules('post_title', 'Post Title', 'trim|required|xss_clean|is_unique[posts.post_title]');
			$this->form_validation->set_rules('post_content', 'Post Content', 'trim|required');
			$this->form_validation->set_rules('post_slug', 'Post Slug Title', 'trim|required|xss_clean|is_unique[posts.post_slug]');
			
			if ($this->form_validation->run() == TRUE) 
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$new_name = time().'_'.$_FILES["file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('file')){
					redirect(base_url().'administrator/new_post');
				}
				else
				{
					$upload_data = $this->upload->data();
					$this->_createThumbnail($upload_data['file_name']);
					$data = Array(
						'category_id' => $this->input->post('category_id'),
						'post_slug' => strtolower(url_title($this->input->post('post_title'))),
						'post_title' => $this->input->post('post_title'),
						'post_content' => $this->input->post('post_content'),
						'post_image' => $upload_data['file_name'],
						'post_title' => $this->input->post('post_title'),
						'post_created' => date('Y-m-d H:i:s'),
						'post_author' => $this->ion_auth->user()->row()->id,
					);
					$save = $this->m_crud->save_data($data, 'posts');
					if($save == TRUE){
						redirect(base_url().'administrator/all_post');
					}else{
						redirect(base_url().'administrator/all_post');
					}
				}
			}
			else
			{
				echo "<script>alert('Gagal menyimpan'); 
				</script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/new_post';
				$this->load->view('administrator/index', $data);
			}
		}else{
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/new_post';
			$this->load->view('administrator/index', $data);
		}
	}


	function delete_post($id){
		$this->load->helper("file");
		$dataPost = $this->post->get_one($id);

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin() && $this->ion_auth->user()->row()->id !== $dataPost->post_author){
			redirect(base_url().'administrator/all_post', 'refresh');
		}


		if($this->post->delete_by_id($id))
		{
			redirect(base_url().'administrator/all_post', 'refresh');
		}
		else
		{
			echo "<script>
			alert('Gagal Menghapus');
			// window.location='".base_url()."administrator/all_post'; 
			</script>";
		}
		
	}




	function activate_post($id = NULL,$param = NULL){
		$id = (int) $id;
		$param = (int) $param;

		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}

		$update = $this->m_crud->update_data($id, 'post_id', ['post_status' => $param], 'posts'); 
		if($update)
		{
			redirect(base_url().'administrator/all_post', 'refresh');
		}
		echo "<script>
		alert('Activate failed');
		window.location='".base_url()."administrator/all_post'; 
		</script>";
	}



	function edit_post($id = null)
	{
		$dataPosts = $this->m_crud->get_data('*','posts',' INNER JOIN users ON users.id = posts.post_author '.'WHERE post_id = '.$id)->row();;

		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		// } else if(!($this->ion_auth->user()->row()->id == $dataPosts->post_author)|| !$this->ion_auth->is_admin() ){
		// 	redirect('administrator/all_post', 'refresh');
		
		} else if(!($this->ion_auth->is_admin() || ($this->ion_auth->user()->row()->id == $dataPosts->post_author))){
			redirect('administrator/all_post', 'refresh');
		}


		if($this->input->post()){

			$_POST['post_slug'] = strtolower(url_title($this->input->post('post_title')));

			$this->form_validation->set_rules('post_title', 'Post Title', 'trim|required|xss_clean|is_unique[posts.post_title]');
			$this->form_validation->set_rules('post_content', 'Post Content', 'trim|required');
			$this->form_validation->set_rules('post_slug', 'Post Slug Title', 'trim|required|xss_clean|is_unique[posts.post_slug]');

			if ($this->form_validation->run() == TRUE) 
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$new_name = time().'_'.$_FILES["file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				$statUpload = false;
				if ($this->upload->do_upload('file')) {
					$upload_data = $this->upload->data();
					$this->_createThumbnail($upload_data['file_name']);
					$statUpload = true;

					$path_to_file = './uploads/'.$dataPosts->post_image;

					$hapus = unlink($path_to_file);
					if (!$hapus) {
						echo "<script>alert('Gagal mengahpus file lama'); </script>";
					}

				}
				$data = Array(
					'category_id' => $this->input->post('category_id'),
					'post_slug' => strtolower(url_title($this->input->post('post_title'))),
					'post_title' => $this->input->post('post_title'),
					'post_content' => $this->input->post('post_content'),
					'post_image' => $statUpload ? $upload_data['file_name'] : $dataPosts->post_image,
					'post_modified' => date('Y-m-d H:i:s'),
					'post_modifiedby' => $this->ion_auth->user()->row()->id,
				);
				$save = $this->m_crud->update_data($id, 'post_id', $data, 'posts');
				if($save == TRUE){
					redirect(base_url().'administrator/all_post');
				}else{
					redirect(base_url().'administrator/edit_post/'.$id);
				}
				
			}
			else
			{
				echo "<script>alert('Gagal menyimpan'); </script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/edit_post';
				$data['data_post'] = $dataPosts;
				$this->load->view('administrator/index', $data);
				return;
			}
		}else{
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/edit_post';
			$data['data_post'] = $dataPosts;
			$this->load->view('administrator/index', $data);
			return;
		}
	}




	
	function _createThumbnail($filename){
		$config['image_library'] = 'gd2';
        $config['source_image']     = "./uploads/" .$filename;
		$config['new_image'] = './uploads/thumbs/'.$filename;
        $config['maintain_ratio']   = TRUE;
        $config['width'] = "100";      
        $config['height'] = "100";
        $this->load->library('image_lib',$config);
        if($this->image_lib->resize()){
            //print_r($this->image_lib->resize());die();
        }
    }

	function new_menu(){
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/new_menu';
		$this->load->view('administrator/index', $data);
	}
	

	/**
	 * [profile description]
	 * @return [type] [description]
	 */
	function all_profiles(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		} else if(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		$data['content'] = $this->profile->get_all();
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/all_profiles';
		$this->load->view('administrator/index', $data);
	}

	function activate_profiles($id = NULL,$param = NULL){
		$id = (int) $id;
		$param = (int) $param;

		if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		if($this->profile->set_status($id,$param))
		{
			redirect(base_url().'administrator/all_profiles', 'refresh');
		}
		echo "salah";
	}

	function delete_profiles($id){
		$this->load->helper("file");
		$dataProfiles = $this->profile->get_one($id);

		if (!$this->ion_auth->logged_in() || !($this->ion_auth->is_admin() && $this->ion_auth->user()->row()->id == $dataProfiles->profile_author)){
			redirect(base_url().'administrator/all_profiles', 'refresh');
		}
		
		if($this->profile->delete_by_id($id))
		{
			redirect(base_url().'administrator/all_profiles', 'refresh');
		}
		else
		{
			echo "<script>
			alert('Gagal Menghapus');
			// window.location='".base_url()."administrator/all_profiles'; 
			</script>";
		}
		
	}

	function new_profiles(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		if($this->input->post()){

			$_POST['profile_slug'] = strtolower(url_title($this->input->post('profile_title')));

			$this->form_validation->set_rules('profile_title', 'Profile Title', 'trim|required|xss_clean|is_unique[profile.profile_title]');
			$this->form_validation->set_rules('profile_content', 'Profile Content', 'trim|required');
			$this->form_validation->set_rules('profile_slug', 'Profile Slug Title', 'trim|required|xss_clean|is_unique[profile.profile_slug]');

			if ($this->form_validation->run() == TRUE) 
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$new_name = time().'_'.$_FILES["file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('file')){
					redirect(base_url().'administrator/new_profiles');
				}else{
					$upload_data = $this->upload->data();
					$this->_createThumbnail($upload_data['file_name']);
					$data = Array(
						'profile_slug' => strtolower(url_title($this->input->post('profile_title'))),
						'profile_title' => $this->input->post('profile_title'),
						'profile_content' => $this->input->post('profile_content'),
						'profile_image' => $upload_data['file_name'],
						'profile_created' => date('Y-m-d H:i:s'),
						'profile_author' => $this->ion_auth->user()->row()->id,
					);
					$save = $this->m_crud->save_data($data, 'profile');
					if($save == TRUE){
						redirect(base_url().'administrator/all_profiles');
					}else{
						redirect(base_url().'administrator/all_profiles');
					}
				}
			}
			else
			{
				echo "<script>alert('Gagal menyimpan'); 
				</script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/new_profiles';
				$this->load->view('administrator/index', $data);
			}
		}else{
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/new_profiles';
			$this->load->view('administrator/index', $data);
		}
	}

	function edit_profiles($id = null)
	{
		$dataProfiles = $this->profile->get_one($id);

		if (!$this->ion_auth->logged_in() || !($this->ion_auth->is_admin() && $this->ion_auth->user()->row()->id == $dataProfiles->profile_author)){
			redirect(base_url().'administrator/all_profiles', 'refresh');
		}


		if($this->input->post()){

			$_POST['profile_slug'] = strtolower(url_title($this->input->post('profile_title')));

			$this->form_validation->set_rules('profile_title', 'Profile Title', 'trim|required|xss_clean|is_unique[profile.profile_title]');
			$this->form_validation->set_rules('profile_content', 'Profile Content', 'trim|required');
			$this->form_validation->set_rules('profile_slug', 'Profile Slug Title', 'trim|required|xss_clean|is_unique[profile.profile_slug]');

			if ($this->form_validation->run() == TRUE) 
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$new_name = time().'_'.$_FILES["file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				$statUpload = false;
				if ($this->upload->do_upload('file')) {
					$upload_data = $this->upload->data();
					$this->_createThumbnail($upload_data['file_name']);
					$statUpload = true;

					$path_to_file = './uploads/'.$dataProfiles->profile_image;

					$hapus = unlink($path_to_file);
					if (!$hapus) {
						echo "<script>alert('Gagal mengahpus file lama'); </script>";
					}

				}
				$data = Array(
					'profile_slug' => strtolower(url_title($this->input->post('profile_title'))),
					'profile_title' => $this->input->post('profile_title'),
					'profile_content' => $this->input->post('profile_content'),
					'profile_image' => $statUpload ? $upload_data['file_name'] : $dataProfiles->profile_image,
					'profile_modified' => date('Y-m-d H:i:s'),
					'profile_modifiedby' => $this->ion_auth->user()->row()->id,
				);
				$save = $this->m_crud->update_data($id, 'profile_id', $data, 'profile');
				if($save == TRUE){
					redirect(base_url().'administrator/all_profiles');
				}else{
					redirect(base_url().'administrator/edit_profiles/'.$id);
				}
				
			}
			else
			{
				echo "<script>alert('Gagal menyimpan'); </script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/edit_profiles';
				$data['data_profiles'] = $dataProfiles;
				$this->load->view('administrator/index', $data);
				return;
			}
		}else{
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/edit_profiles';
			$data['data_profiles'] = $dataProfiles;
			$this->load->view('administrator/index', $data);
			return;
		}
	}


	function all_dph(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}
		
		$act = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$cat = '';
		
		if($id){
			$query = $this->db->where('dph_id', $id)->get('master_dph')->row();
			$cat = $query->dph_title;
		}
		
		if($act == 'del'){
			$this->m_crud->delete_data($id, 'dph_id', 'master_dph');
			redirect(base_url().'administrator/all_dph');
		}
		
		if($this->input->post()){
			$data = Array(
				'dph_title' => $this->input->post('dph_title'),
			);
			
			if($act == 'edit'){
				$this->m_crud->update_data($id, 'dph_id', $data, 'master_dph');
				redirect(base_url().'administrator/all_dph');
			}
			
			$save = $this->m_crud->save_data($data, 'master_dph');
			if($save == TRUE){
				redirect(base_url().'administrator/all_dph');
			}else{
				redirect(base_url().'administrator/all_dph');
			}
		}else{
			$data['cat'] = $this->m_crud->get_data('*','master_dph','')->result();
			$data['users'] = $this->ion_auth->user()->row();
			$data['value'] = $cat;
			$data['page'] = 'administrator/all_dph';
			$this->load->view('administrator/index', $data);
		}
	}



	/**
	 * [all_dph description]
	 * @return [type] [description]
	 */
	// function all_wilayah(){
	// 	if (!$this->ion_auth->logged_in()){
	// 		redirect('administrator/login', 'refresh');
	// 	}
	// 	elseif(!$this->ion_auth->is_admin()){
	// 		return show_error('You must be an administrator to view this page.');
	// 	}
		
	// 	$act = $this->uri->segment(3);
	// 	$id = $this->uri->segment(4);
	// 	$cat = '';
		
	// 	if($id){
	// 		$query = $this->db->where('wilayah_id', $id)->get('master_wilayah')->row();
	// 		$cat = $query->wilayah_name;
	// 	}
		
	// 	if($act == 'del'){
	// 		$this->m_crud->delete_data($id, 'wilayah_id', 'master_wilayah');
	// 		redirect(base_url().'administrator/all_wilayah');
	// 	}
		
	// 	if($this->input->post()){
	// 		$data = Array(
	// 			'wilayah_name' => $this->input->post('wilayah_name'),
	// 		);
			
	// 		if($act == 'edit'){
	// 			$this->m_crud->update_data($id, 'wilayah_id', $data, 'master_wilayah');
	// 			redirect(base_url().'administrator/all_wilayah');
	// 		}
			
	// 		$save = $this->m_crud->save_data($data, 'master_wilayah');
	// 		if($save == TRUE){
	// 			redirect(base_url().'administrator/all_wilayah');
	// 		}else{
	// 			redirect(base_url().'administrator/all_wilayah');
	// 		}
	// 	}else{
	// 		$data['cat'] = $this->m_crud->get_data('*','master_wilayah','')->result();
	// 		$data['users'] = $this->ion_auth->user()->row();
	// 		$data['value'] = $cat;
	// 		$data['page'] = 'administrator/all_wilayah';
	// 		$this->load->view('administrator/index', $data);
	// 	}
	// }


	/**
	 * [all_wilayah description]
	 * @return [type] [description]
	 */
	function all_wilayah(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$data['cat'] = $this->m_crud->get_data('wilayah.*, users.first_name, users.last_name, wil.wilayah_title as parentname','wilayah','LEFT JOIN users ON users.id = wilayah.user_id LEFT JOIN wilayah wil ON wilayah.wilayah_parent = wil.wilayah_id')->result();
		$data['users'] = $this->ion_auth->user()->row();
		// $data['value'] = $cat;
		$data['page'] = 'administrator/all_wilayah';
		$this->load->view('administrator/index', $data);

	}

	function new_wilayah()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		if($this->input->post())
		{
			$data = Array(
				'wilayah_title' => $this->input->post('wilayah_title'),
				'wilayah_parent' => $this->input->post('wilayah_parent'),
				'user_id' => ($this->input->post('user_id')) ? $this->input->post('user_id'): NULL ,
			);
			
			// if($act == 'edit'){
			// 	$this->m_crud->update_data($id, 'wilayah_id', $data, 'master_wilayah');
			// 	redirect(base_url().'administrator/all_wilayah');
			// }
			
			$save = $this->m_crud->save_data($data, 'wilayah');
			if($save == TRUE){
				redirect(base_url().'administrator/all_wilayah');
			}else{
				redirect(base_url().'administrator/all_wilayah');
			}
		}

		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/new_wilayah';
		$this->load->view('administrator/index', $data);
	}

	function edit_wilayah($id=null)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$wilayah = $this->db->where('wilayah_id',$id)->get('wilayah')->row();
		if (!$wilayah) {
			return show_error('Data tidak ditemukan.');
		}

		if($this->input->post())
		{
			$data = Array(
				'wilayah_title' => $this->input->post('wilayah_title'),
				'wilayah_parent' => $this->input->post('wilayah_parent'),
				'user_id' => ($this->input->post('user_id')) ? $this->input->post('user_id'): NULL ,
			);
			
			// if($act == 'edit'){
			// 	$this->m_crud->update_data($id, 'wilayah_id', $data, 'master_wilayah');
			// 	redirect(base_url().'administrator/all_wilayah');
			// }
			
			$save = $this->m_crud->update_data($id, 'wilayah_id', $data, 'wilayah');
			if($save == TRUE){
				redirect(base_url().'administrator/all_wilayah');
			}else{
				redirect(base_url().'administrator/all_wilayah');
			}
		}

		$data['wilayah'] = $wilayah;
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/edit_wilayah';
		$this->load->view('administrator/index', $data);
	}

	function delete_wilayah($id){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$delete = $this->m_crud->delete_data($id, 'wilayah_id', 'wilayah');
		if($delete == TRUE){
			redirect(base_url().'administrator/all_wilayah');
		}else{
			redirect(base_url().'administrator/all_wilayah');
		}

	}






	/**
	 * [all_seksi description]
	 * @return [type] [description]
	 */
	function all_seksi(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$data['cat'] = $this->m_crud->get_data('seksi.*, users.first_name, users.last_name','seksi','LEFT JOIN users ON users.id = seksi.user_id')->result();
		$data['users'] = $this->ion_auth->user()->row();
		// $data['value'] = $cat;
		$data['page'] = 'administrator/all_seksi';
		$this->load->view('administrator/index', $data);

	}

	function new_seksi()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		if($this->input->post())
		{
			$data = Array(
				'seksi_title' => $this->input->post('seksi_title'),
				'user_id' => ($this->input->post('user_id')) ? $this->input->post('user_id'): NULL ,
			);
			
			
			$save = $this->m_crud->save_data($data, 'seksi');
			if($save == TRUE){
				redirect(base_url().'administrator/all_seksi');
			}else{
				redirect(base_url().'administrator/all_seksi');
			}
		}

		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/new_seksi';
		$this->load->view('administrator/index', $data);
	}

	function edit_seksi($id=null)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$seksi = $this->db->where('seksi_id',$id)->get('seksi')->row();
		if (!$seksi) {
			return show_error('Data tidak ditemukan.');
		}

		if($this->input->post())
		{
			$data = Array(
				'seksi_title' => $this->input->post('seksi_title'),
				'user_id' => ($this->input->post('user_id')) ? $this->input->post('user_id'): NULL ,
			);
			
			$save = $this->m_crud->update_data($id, 'seksi_id', $data, 'seksi');
			if($save == TRUE){
				redirect(base_url().'administrator/all_seksi');
			}else{
				redirect(base_url().'administrator/all_seksi');
			}
		}

		$data['seksi'] = $seksi;
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/edit_seksi';
		$this->load->view('administrator/index', $data);
	}

	function delete_seksi($id){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$delete = $this->m_crud->delete_data($id, 'seksi_id', 'seksi');
		if($delete == TRUE){
			redirect(base_url().'administrator/all_seksi');
		}else{
			redirect(base_url().'administrator/all_seksi');
		}

	}





	/**
	 * [all_kelompok description]
	 * @return [type] [description]
	 */
	function all_kategorial(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$data['cat'] = $this->m_crud->get_data('kategorial.*, users.first_name, users.last_name','kategorial','LEFT JOIN users ON users.id = kategorial.user_id')->result();
		$data['users'] = $this->ion_auth->user()->row();
		// $data['value'] = $cat;
		$data['page'] = 'administrator/all_kategorial';
		$this->load->view('administrator/index', $data);

	}

	function new_kategorial()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		if($this->input->post())
		{
			$data = Array(
				'kategorial_title' => $this->input->post('kategorial_title'),
				'user_id' => ($this->input->post('user_id')) ? $this->input->post('user_id'): NULL ,
			);
			
			
			$save = $this->m_crud->save_data($data, 'kategorial');
			if($save == TRUE){
				redirect(base_url().'administrator/all_kategorial');
			}else{
				redirect(base_url().'administrator/all_kategorial');
			}
		}

		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/new_kategorial';
		$this->load->view('administrator/index', $data);
	}

	function edit_kategorial($id=null)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$kategorial = $this->db->where('kategorial_id',$id)->get('kategorial')->row();
		if (!$kategorial) {
			return show_error('Data tidak ditemukan.');
		}

		if($this->input->post())
		{
			$data = Array(
				'kategorial_title' => $this->input->post('kategorial_title'),
				'user_id' => ($this->input->post('user_id')) ? $this->input->post('user_id'): NULL ,
			);
			
			$save = $this->m_crud->update_data($id, 'kategorial_id', $data, 'kategorial');
			if($save == TRUE){
				redirect(base_url().'administrator/all_kategorial');
			}else{
				redirect(base_url().'administrator/all_kategorial');
			}
		}

		$data['kategorial'] = $kategorial;
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/edit_kategorial';
		$this->load->view('administrator/index', $data);
	}

	function delete_kategorial($id){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$delete = $this->m_crud->delete_data($id, 'kategorial_id', 'kategorial');
		if($delete == TRUE){
			redirect(base_url().'administrator/all_kategorial');
		}else{
			redirect(base_url().'administrator/all_kategorial');
		}

	}










	

}
