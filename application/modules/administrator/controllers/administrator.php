<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth'));
		$this->load->helper(array('url','language', 'form'));

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
			$email = '';
			$remember = '';
			
			$email_raw		=	$this->input->post('identity', TRUE);
			$password		=	$this->input->post('password', TRUE);
			$remember_raw	=	(bool) $this->input->post('remember', TRUE);
			
			//filter email
			if (!filter_var($email_raw, FILTER_VALIDATE_EMAIL) === false) {
				$email = $email_raw;
			} else {
				return false;
			}
			
			//filter remember
			$remember = filter_var($remember_raw, FILTER_VALIDATE_BOOLEAN);
			
			// $remember = (bool) $this->input->post('remember', TRUE);
			if ($this->ion_auth->login($email, $password, $remember)){
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect(base_url().'administrator', 'refresh');
			}else{
				$this->ion_auth->increase_login_attempts($this->input->post('identity', TRUE));
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




			$email    = strtolower($this->input->post('email'), TRUE);
            $identity = ($identity_column==='identity') ? $email : $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            $additional_data = array(
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name'  => $this->input->post('last_name', TRUE),
                'alamat'  => $this->input->post('alamat', TRUE),
                'phone'  => $this->input->post('phone', TRUE),
                'hp'  => $this->input->post('hp', TRUE),
                'foto' => ($statUpload)? $upload_data['file_name'] : NULL ,
            );

			$groups = array($this->input->post('groups_id', TRUE));

			if ($id = $this->ion_auth->register($identity, $password, $email, $additional_data, $groups)){
				// Set dph user
				$this->dph->add_to_dph($this->input->post('dph_id', TRUE), $id);

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
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name'  => $this->input->post('last_name', TRUE),
                'alamat'  => $this->input->post('alamat', TRUE),
                'phone'  => $this->input->post('phone', TRUE),
                'hp'  => $this->input->post('hp', TRUE),
                'foto' => ($statUpload)? $upload_data['file_name'] : NULL ,

            );

            $groups = $this->ion_auth->get_users_groups($user->id)->row();
			$groupsid = ($groups) ? $groups->id : '';

            $dph = $this->dph->get_users_dph($user->id)->row();
			// $dphid = ($dph) ? $dph->id : '';
			$dphid = ($dph) ? $dph->id : 0;


			if ($groupsid !== $this->input->post('groups_id', TRUE) && $this->ion_auth->is_admin() ) {
				$this->ion_auth->add_to_group($this->input->post('groups_id', TRUE), $user->id);
				if ($groupsid !== '') {
					$this->ion_auth->remove_from_group($groupsid, $user->id);
				}
			}

			if ($dphid !== $this->input->post('dph_id', TRUE) && $this->ion_auth->is_admin() ) {
				$this->dph->add_to_dph($this->input->post('dph_id', TRUE), $user->id);
				if ($dphid !== 0) {
					$this->dph->remove_from_dph($dphid, $user->id);
				}
			}

			if ($this->input->post('password')){
				$data['password'] = $this->input->post('password', TRUE);
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

		if($this->input->post('sitename', TRUE)){
			$update = $this->m_crud->update_data('1', 'option_id', Array('option_value'=>$this->input->post('sitename', TRUE)), 'options');
		}

		if($this->input->post('sitedescription', TRUE)){
			$update = $this->m_crud->update_data('2', 'option_id', Array('option_value'=>nl2br($this->input->post('sitedescription', TRUE))), 'options');
		}

		if($this->input->post('office', TRUE)){
			$update = $this->m_crud->update_data('3', 'option_id', Array('option_value'=>$this->input->post('office', TRUE)), 'options');
		}

		if($this->input->post('about', TRUE)){
			$update = $this->m_crud->update_data('4', 'option_id', Array('option_value'=>nl2br($this->input->post('about', TRUE))), 'options');
		}

		if($this->input->post('contact', TRUE)){
			$update = $this->m_crud->update_data('9', 'option_id', Array('option_value'=>nl2br($this->input->post('contact', TRUE))), 'options');
		}

		if($this->input->post('facebook', TRUE)){
			$update = $this->m_crud->update_data('5', 'option_id', Array('option_value'=>nl2br($this->input->post('facebook', TRUE))), 'options');
		}

		if($this->input->post('twitter', TRUE)){
			$update = $this->m_crud->update_data('6', 'option_id', Array('option_value'=>nl2br($this->input->post('twitter', TRUE))), 'options');
		}

		if($this->input->post('instagram', TRUE)){
			$update = $this->m_crud->update_data('7', 'option_id', Array('option_value'=>nl2br($this->input->post('instagram', TRUE))), 'options');
		}

		if($this->input->post('youtube', TRUE)){
			$update = $this->m_crud->update_data('8', 'option_id', Array('option_value'=>nl2br($this->input->post('youtube', TRUE))), 'options');
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
			$this->form_validation->set_rules('post_content', 'Post Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('post_slug', 'Post Slug Title', 'trim|required|xss_clean|is_unique[posts.post_slug]');
			$this->form_validation->set_rules('post_tags', 'Post Tags', 'xss_clean');

			if ($this->form_validation->run() == TRUE)
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|pptx|ppt';
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
						'category_id' => $this->input->post('category_id', TRUE),
						'post_slug' => strtolower(url_title($this->input->post('post_title', TRUE))),
						'post_title' => $this->input->post('post_title', TRUE),
						'post_content' => $this->input->post('post_content', TRUE),
						'post_image' => $upload_data['file_name'],
						'post_title' => $this->input->post('post_title', TRUE),
						'post_created' => date('Y-m-d H:i:s'),
						'post_author' => $this->ion_auth->user()->row()->id,
					);
					$save = $this->m_crud->save_data($data, 'posts');
					if($save == TRUE){

    					//additional tags
    					$tags = $this->input->post('post_tags', TRUE);

    					$idPost = $this->db->insert_id();
    					$dataTags = Array();

                        if (!empty($tags)) {
        					foreach ($tags as $tag) {
        						$dataTags[] = Array(
        							'post_id' => $idPost,
        							'tag' => $tag,
        							'post_asal' => 'post',
        							);
        					}
        					$this->db->insert_batch('posts_tag', $dataTags);
                        }
    					//additional tags

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
			$this->form_validation->set_rules('post_content', 'Post Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('post_slug', 'Post Slug Title', 'trim|required|xss_clean|is_unique[posts.post_slug]');
            $this->form_validation->set_rules('post_tags', 'Post Tags', 'xss_clean');

			if ($this->form_validation->run() == TRUE)
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|pptx|ppt';
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
					'category_id' => $this->input->post('category_id', TRUE),
					'post_slug' => strtolower(url_title($this->input->post('post_title', TRUE))),
					'post_title' => $this->input->post('post_title', TRUE),
					'post_content' => $this->input->post('post_content', TRUE),
					'post_image' => $statUpload ? $upload_data['file_name'] : $dataPosts->post_image,
					'post_modified' => date('Y-m-d H:i:s'),
					'post_modifiedby' => $this->ion_auth->user()->row()->id,
				);
				$save = $this->m_crud->update_data($id, 'post_id', $data, 'posts');
				if($save == TRUE){

    				//additional tags
    				$tags = $this->input->post('post_tags', TRUE);
    				// $deleteTags = $this->post->delete_all_posts_tag($id);
    				$dataTags = Array();

                    if (!empty($tags)) {
                    	foreach ($tags as $tag) {
        				    $dataTags[] = Array(
        				        'post_id' => $id,
        				        'tag' => $tag,
        				        'post_asal' => 'post',
        				        );
        				}
    				    $this->db->insert_batch('posts_tag', $dataTags);
                    }
    				//additional tags 

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
			$this->form_validation->set_rules('profile_content', 'Profile Content', 'trim|required|xss_clean');
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
						'profile_slug' => strtolower(url_title($this->input->post('profile_title', TRUE))),
						'profile_title' => $this->input->post('profile_title', TRUE),
						'profile_content' => $this->input->post('profile_content', TRUE),
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
			$this->form_validation->set_rules('profile_content', 'Profile Content', 'trim|required|xss_clean');
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
					'profile_slug' => strtolower(url_title($this->input->post('profile_title', TRUE))),
					'profile_title' => $this->input->post('profile_title', TRUE),
					'profile_content' => $this->input->post('profile_content', TRUE),
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
				'dph_title' => $this->input->post('dph_title', TRUE),
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
				'wilayah_title' => $this->input->post('wilayah_title', TRUE),
				'wilayah_parent' => $this->input->post('wilayah_parent', TRUE),
				'user_id' => ($this->input->post('user_id')) ? $this->input->post('user_id'): NULL ,
			);

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
				'wilayah_title' => $this->input->post('wilayah_title', TRUE),
				'wilayah_parent' => $this->input->post('wilayah_parent', TRUE),
				'user_id' => ($this->input->post('user_id', TRUE)) ? $this->input->post('user_id', TRUE): NULL ,
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
	function all_seksi() {
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}

		$data['cat'] = $this->m_crud->get_data('seksi.*','seksi')->result();
		$data['users'] = $this->ion_auth->user()->row();
		// $data['value'] = $cat;
		$data['page'] = 'administrator/all_seksi';
		$this->load->view('administrator/index', $data);

	}

	function new_seksi() {
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}
		
		if ( $this->input->post() ) {

			$_POST['seksi_slug'] = strtolower(url_title($this->input->post('seksi_title', TRUE)));
			$this->form_validation->set_rules('seksi_title', 'Seksi Title', 'trim|required|xss_clean|is_unique[seksi.seksi_title]');
			$this->form_validation->set_rules('seksi_content', 'Seksi Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('seksi_slug', 'Seksi Slug Title', 'trim|required|xss_clean|is_unique[seksi.seksi_slug]');

			if ($this->form_validation->run() == TRUE) {
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|pptx|ppt';
				$new_name = time().'_'.$_FILES["seksi_file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('seksi_file')) {
					redirect(base_url().'administrator/new_seksi');
				}
				else {
					$upload_data = $this->upload->data();
					$this->_createThumbnail($upload_data['file_name']);
					$data = Array(
						'seksi_title' => $this->input->post('seksi_title', TRUE),
						'seksi_content' => $this->input->post('seksi_content', TRUE),
						'seksi_slug' => strtolower(url_title($this->input->post('seksi_title', TRUE))),
						'seksi_image' => $upload_data['file_name'],
						'user_id' => ($this->input->post('user_id', TRUE)) ? $this->input->post('user_id', TRUE): NULL ,
					);

					$save = $this->m_crud->save_data($data, 'seksi');
					if($save == TRUE){
						redirect(base_url().'administrator/all_seksi');
					}else{
						redirect(base_url().'administrator/all_seksi');
					}
				}
			}
			else {
				echo "<script>alert('Gagal menyimpan');
				</script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/new_seksi';
				$this->load->view('administrator/index', $data);
			}
		} else {
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/new_seksi';
			$this->load->view('administrator/index', $data);
		}

	}

	function edit_seksi( $id=null ) {
		if ( !$this->ion_auth->logged_in() ) {
			redirect('administrator/login', 'refresh');
		}
		
		elseif ( !$this->ion_auth->is_admin() ) {
			return show_error('You must be an administrator to view this page.');
		}

		$dataSeksi = $this->m_crud->get_data('*','seksi','WHERE seksi_id = '.$id)->row();

		if ( $this->input->post() ) {

			$_POST['seksi_slug'] = strtolower(url_title($this->input->post('seksi_title', TRUE)));

			$this->form_validation->set_rules('seksi_title', 'seksi Title', 'trim|required|xss_clean|is_unique[seksi.seksi_title]');
			$this->form_validation->set_rules('seksi_content', 'seksi Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('seksi_slug', 'seksi Slug Title', 'trim|required|xss_clean|is_unique[seksi.seksi_slug]');

			if ($this->form_validation->run() == TRUE)
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|pptx|ppt';
				$new_name = time().'_'.$_FILES["seksi_file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				$statUpload = false;
				if ($this->upload->do_upload('seksi_file')) {
					$upload_data = $this->upload->data();
					$this->_createThumbnail($upload_data['file_name']);
					$statUpload = true;

					$path_to_file = './uploads/'.$dataSeksi->seksi_image;

					$hapus = unlink($path_to_file);
					if (!$hapus) {
						echo "<script>alert('Gagal mengahpus file lama'); </script>";
					}

				}
				$data = Array(
					'seksi_slug' => strtolower(url_title($this->input->post('seksi_title', TRUE))),
					'seksi_title' => $this->input->post('seksi_title', TRUE),
					'seksi_content' => $this->input->post('seksi_content', TRUE),
					'seksi_image' => $statUpload ? $upload_data['file_name'] : $dataSeksi->seksi_image,
				);
				$save = $this->m_crud->update_data($id, 'seksi_id', $data, 'seksi');
				if($save == TRUE){
					redirect(base_url().'administrator/all_seksi'); 
				}else{
					redirect(base_url().'administrator/edit_seksi/'.$id);
				}

			}
			else {
				echo "<script>alert('Gagal menyimpan'); </script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/edit_seksi';
				$data['data_seksi'] = $dataSeksi;
				$this->load->view('administrator/index', $data);
				return;
			}
		} else {
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/edit_seksi';
			$data['data_seksi'] = $dataSeksi;
			$this->load->view('administrator/index', $data);
			return;
		}
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

		$data['cat'] = $this->m_crud->get_data('kategorial.*','kategorial')->result();
		$data['users'] = $this->ion_auth->user()->row();
		// $data['value'] = $cat;
		$data['page'] = 'administrator/all_kategorial';
		$this->load->view('administrator/index', $data);

	}

	function new_kategorial() {
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}
		
		if($this->input->post()){

			$_POST['kategorial_slug'] = strtolower(url_title($this->input->post('kategorial_title', TRUE)));
			$this->form_validation->set_rules('kategorial_title', 'Kategorial Title', 'trim|required|xss_clean|is_unique[kategorial.kategorial_title]');
			$this->form_validation->set_rules('kategorial_content', 'kategorial Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('kategorial_slug', 'kategorial Slug Title', 'trim|required|xss_clean|is_unique[kategorial.kategorial_slug]');

			if ($this->form_validation->run() == TRUE)
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|pptx|ppt';
				$new_name = time().'_'.$_FILES["kategorial_file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('kategorial_file')){
					redirect(base_url().'administrator/new_kategorial');
				}
				else
				{
					$upload_data = $this->upload->data();
					$this->_createThumbnail($upload_data['file_name']);
					$data = Array(
						'kategorial_title' => $this->input->post('kategorial_title', TRUE),
						'kategorial_content' => $this->input->post('kategorial_content', TRUE),
						'kategorial_slug' => strtolower(url_title($this->input->post('kategorial_title', TRUE))),
						'kategorial_image' => $upload_data['file_name'],
						'user_id' => ($this->input->post('user_id', TRUE)) ? $this->input->post('user_id', TRUE): NULL ,
					);

					$save = $this->m_crud->save_data($data, 'kategorial');
					if($save == TRUE){
						redirect(base_url().'administrator/all_kategorial');
					}else{
						redirect(base_url().'administrator/all_kategorial');
					}
				}
			}
			else
			{
				echo "<script>alert('Gagal menyimpan');
				</script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/new_kategorial';
				$this->load->view('administrator/index', $data);
			}
		}else{
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/new_kategorial';
			$this->load->view('administrator/index', $data);
		}

	}

	function edit_kategorial($id=null)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}

		$dataKategorial = $this->m_crud->get_data('*','kategorial','WHERE kategorial_id = '.$id)->row();

		if($this->input->post()){

			$_POST['kategorial_slug'] = strtolower(url_title($this->input->post('kategorial_title', TRUE)));

			$this->form_validation->set_rules('kategorial_title', 'kategorial Title', 'trim|required|xss_clean|is_unique[kategorial.kategorial_title]');
			$this->form_validation->set_rules('kategorial_content', 'kategorial Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('kategorial_slug', 'kategorial Slug Title', 'trim|required|xss_clean|is_unique[kategorial.kategorial_slug]');
            $this->form_validation->set_rules('kategorial_tags', 'kategorial Tags', 'xss_clean');

			if ( $this->form_validation->run() == TRUE ) {
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|pptx|ppt';
				$new_name = time().'_'.$_FILES["kategorial_file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				$statUpload = false;
				if ($this->upload->do_upload('kategorial_file')) {
					$upload_data = $this->upload->data();
					$this->_createThumbnail($upload_data['file_name']);
					$statUpload = true;

					$path_to_file = './uploads/'.$dataKategorial->kategorial_image;

					$hapus = unlink($path_to_file);
					if (!$hapus) {
						echo "<script>alert('Gagal mengahpus file lama'); </script>";
					}

				}
				$data = Array(
					'kategorial_slug' => strtolower(url_title($this->input->post('kategorial_title', TRUE))),
					'kategorial_title' => $this->input->post('kategorial_title', TRUE),
					'kategorial_content' => $this->input->post('kategorial_content', TRUE),
					'kategorial_image' => $statUpload ? $upload_data['file_name'] : $dataKategorial->kategorial_image,
				);
				$save = $this->m_crud->update_data($id, 'kategorial_id', $data, 'kategorial');
				if($save == TRUE){
					redirect(base_url().'administrator/all_kategorial'); 
				}else{
					redirect(base_url().'administrator/edit_kategorial/'.$id);
				}

			}
			else
			{
				echo "<script>alert('Gagal menyimpan'); </script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/edit_kategorial';
				$data['data_kategorial'] = $dataKategorial;
				$this->load->view('administrator/index', $data);
				return;
			}
		}else{
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/edit_kategorial';
			$data['data_kategorial'] = $dataKategorial;
			$this->load->view('administrator/index', $data);
			return;
		}
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

	/**
	 * [all_pelayanan description]
	 * @return [type] [description]
	 */
	function all_pelayanan() {
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}

		$data['cat'] = $this->m_crud->get_data('pelayanan.*','pelayanan')->result();
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/all_pelayanan';
		$this->load->view('administrator/index', $data);

	}

	function new_pelayanan() {
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}
		
		if ( $this->input->post() ) {

			$_POST['pelayanan_slug'] = strtolower(url_title($this->input->post('pelayanan_title')));
			$this->form_validation->set_rules('pelayanan_title', 'Pelayanan Title', 'trim|required|xss_clean|is_unique[pelayanan.pelayanan_title]');
			$this->form_validation->set_rules('pelayanan_slug', 'Pelayanan Slug Title', 'trim|required|xss_clean|is_unique[pelayanan.pelayanan_slug]');

			if ($this->form_validation->run() == TRUE) {
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|pptx|ppt|pdf';
				$new_name = time().'_'.$_FILES["pelayanan_file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);
				$statUpload = false;

				if ($this->upload->do_upload('pelayanan_file')) {
					$upload_data	=	$this->upload->data();
					$statUpload		=	true;
				}

				$data = Array(
					'pelayanan_title' => $this->input->post('pelayanan_title', TRUE),
					'pelayanan_content' => $this->input->post('pelayanan_content', TRUE),
					'pelayanan_slug' => strtolower(url_title($this->input->post('pelayanan_title', TRUE))),
					'pelayanan_image' => $statUpload ? $upload_data['file_name'] : '',
					'user_id' => ($this->input->post('user_id', TRUE)) ? $this->input->post('user_id', TRUE): NULL ,
				);

				$save = $this->m_crud->save_data($data, 'pelayanan');
				if($save == TRUE){
					redirect(base_url().'administrator/all_pelayanan');
				}else{
					redirect(base_url().'administrator/all_pelayanan');
				}

			}
			else {
				echo "<script>alert('Gagal menyimpan');
				</script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/new_pelayanan';
				$this->load->view('administrator/index', $data);
			}
		} else {
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/new_pelayanan';
			$this->load->view('administrator/index', $data);
		}

	}

	function edit_pelayanan( $id=null ) {
		if ( !$this->ion_auth->logged_in() ) {
			redirect('administrator/login', 'refresh');
		}
		
		elseif ( !$this->ion_auth->is_admin() ) {
			return show_error('You must be an administrator to view this page.');
		}

		$dataPelayanan = $this->m_crud->get_data('*','pelayanan','WHERE pelayanan_id = '.$id)->row();

		if ( $this->input->post() ) {

			$_POST['pelayanan_slug'] = strtolower(url_title($this->input->post('pelayanan_title')));

			$this->form_validation->set_rules('pelayanan_title', 'pelayanan Title', 'trim|required|xss_clean|is_unique[pelayanan.pelayanan_title]');
			$this->form_validation->set_rules('pelayanan_slug', 'pelayanan Slug Title', 'trim|required|xss_clean|is_unique[pelayanan.pelayanan_slug]');

			if ($this->form_validation->run() == TRUE)
			{
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|pptx|ppt|pdf';
				$new_name = time().'_'.$_FILES["pelayanan_file"]['name'];
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config);

				$statUpload = false;
				if ($this->upload->do_upload('pelayanan_file')) {
					$upload_data = $this->upload->data();
					$statUpload = true;

					$path_to_file = './uploads/'.$dataPelayanan->pelayanan_image;

					$hapus = unlink($path_to_file);
					if (!$hapus) {
						echo "<script>alert('Gagal mengahpus file lama'); </script>";
					}

				}
				$data = array(
					'pelayanan_slug' => strtolower(url_title($this->input->post('pelayanan_title', TRUE))),
					'pelayanan_title' => $this->input->post('pelayanan_title', TRUE),
					'pelayanan_content' => $this->input->post('pelayanan_content', TRUE),
					'pelayanan_image' => $statUpload ? $upload_data['file_name'] : $dataPelayanan->pelayanan_image,
				);
				$save = $this->m_crud->update_data($id, 'pelayanan_id', $data, 'pelayanan');
				if($save == TRUE){
					redirect(base_url().'administrator/all_pelayanan'); 
				}else{
					redirect(base_url().'administrator/edit_pelayanan/'.$id);
				}

			}
			else {
				echo "<script>alert('Gagal menyimpan'); </script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/edit_pelayanan';
				$data['data_pelayanan'] = $dataPelayanan;
				$this->load->view('administrator/index', $data);
				return;
			}
		} else {
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/edit_pelayanan';
			$data['data_pelayanan'] = $dataPelayanan;
			$this->load->view('administrator/index', $data);
			return;
		}
	}

	function delete_pelayanan($id){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$delete = $this->m_crud->delete_data($id, 'pelayanan_id', 'pelayanan');
		if($delete == TRUE){
			redirect(base_url().'administrator/all_pelayanan');
		}else{
			redirect(base_url().'administrator/all_pelayanan');
		}

	}

	/**
	 * [all_kaj description]
	 * @return [type] [description]
	 */
	function all_kaj(){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$data['cat'] = $this->m_crud->get_data('kaj.*, users.first_name, users.last_name','kaj','LEFT JOIN users ON users.id = kaj.create_by')->result();
		$data['users'] = $this->ion_auth->user()->row();
		// $data['value'] = $cat;
		$data['page'] = 'administrator/all_kaj';
		$this->load->view('administrator/index', $data);

	}

	function new_kaj()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		if($this->input->post())
		{
			echo'<pre>';print_r($this->input->post());

			$data = Array(
				'judul_folder'  => $this->input->post('judul_folder', TRUE),
				'judul_parent' 	=> $this->input->post('judul_parent', TRUE),
				'isi_content'  	=> $this->input->post('isi_content', TRUE),
				'create_by'		 	=> $this->ion_auth->user()->row()->id,
				'create_date'  	=> date('Y-m-d H:i:s') ,
			);

			// $tag = $this->input->post('cek');
			// // $kaj_id = $data['id_kaj'];
			// print_r($data);
			// foreach ($tag as $value) {
			// 	print_r($value);die;
			// }
			// echo'<pre>';print_r($tag);
			// die;

			// if($act == 'edit'){
			// 	$this->m_crud->update_data($id, 'wilayah_id', $data, 'master_wilayah');
			// 	redirect(base_url().'administrator/all_wilayah');
			// }

			$save = $this->m_crud->save_data($data, 'kaj');
			if($save == TRUE){

				$tags = $this->input->post('post_tags');

				$idPost = $this->db->insert_id();
				$dataTags = Array();

									if (!empty($tags)) {
						foreach ($tags as $tag) {
							$dataTags[] = Array(
								'post_id' => $idPost,
								'tag' => $tag,
								'post_asal' => 'kaj',
								);
						}
						$this->db->insert_batch('posts_tag', $dataTags);
									}
				//additional tags

			redirect(base_url().'administrator/all_kaj');

				// $cek = $this->m_crud->get_data('id_kaj', 'kaj', 'WHERE judul_folder = "'.$data['judul_folder'].'"')->result();
				// // print_r($cek[0]->id_kaj);die;
				// $tag = $this->input->post('cek');
				// foreach ($tag as $value) {
				// 	$dataTag = Array(
				// 		'post_id'		=> $cek[0]->id_kaj,
				// 		'tag'				=> $value,
				// 		'post_asal'	=> 'kaj',
				// 	);
				// 	$saveRuas = $this->m_crud->save_data($dataTag, 'posts_tag');
				// }
				// // print_r($cek);die;
				// redirect(base_url().'administrator/all_kaj');
			}else{
				redirect(base_url().'administrator/all_kaj');
			}
		}

		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/new_kaj';
		$this->load->view('administrator/index', $data);
	}

	function edit_kaj($id=null)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$kaj = $this->db->where('id_kaj',$id)->get('kaj')->row();
		if (!$kaj) {
			return show_error('Data tidak ditemukan.');
		}

		if($this->input->post())
		{
			$data = Array(
				'judul_folder' => $this->input->post('judul_folder', TRUE),
				'judul_parent' => $this->input->post('judul_parent', TRUE),
				'isi_content'  => $this->input->post('isi_content', TRUE),
				'update_by'		 => $this->ion_auth->user()->row()->id,
				'update_date'  => date('Y-m-d H:i:s') ,
			);

			// if($act == 'edit'){
			// 	$this->m_crud->update_data($id, 'wilayah_id', $data, 'master_wilayah');
			// 	redirect(base_url().'administrator/all_wilayah');
			// }

			$save = $this->m_crud->update_data($id, 'id_kaj', $data, 'kaj');
			if($save == TRUE){

					//additional tags
					$tags = $this->input->post('post_tags', TRUE);
					$deleteTags = $this->post->delete_all_posts_tag($id);
					$dataTags = Array();

									if (!empty($tags)) {
										foreach ($tags as $tag) {
									$dataTags[] = Array(
											'post_id' => $id,
											'tag' => $tag,
											'post_asal' => 'kaj',
											);
							}
							$this->db->insert_batch('posts_tag', $dataTags);
									}
					//additional tags

				redirect(base_url().'administrator/all_kaj');
			}else{
				redirect(base_url().'administrator/edit_post/'.$id);
			}
		}

		$data['kaj'] = $kaj;
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/edit_kaj';
		$this->load->view('administrator/index', $data);
	}

	function delete_kaj($id){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$delete = $this->m_crud->delete_data($id, 'id_kaj', 'kaj');
		if($delete == TRUE){
			redirect(base_url().'administrator/all_kaj');
		}else{
			redirect(base_url().'administrator/all_kaj');
		}

	}

	/**
	 * [all_new_wilayah description]
	 * @return [type] [description]
	 */
	function all_new_wilayah() {
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}

		$data['cat'] = $this->m_crud->get_data('new_wilayah.*','new_wilayah')->result();
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/all_new_wilayah';
		$this->load->view('administrator/index', $data);

	}

	function new_new_wilayah() {
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}
		
		if ( $this->input->post() ) {

			$_POST['wilayah_slug'] = strtolower(url_title($this->input->post('wilayah_title', TRUE)));
			$this->form_validation->set_rules('wilayah_title', 'Wilayah Title', 'trim|required|xss_clean|is_unique[new_wilayah.wilayah_title]');
			$this->form_validation->set_rules('wilayah_content', 'Wilayah Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('wilayah_slug', 'Wilayah Slug Title', 'trim|required|xss_clean|is_unique[new_wilayah.wilayah_slug]');

			if ($this->form_validation->run() == TRUE) {
				$data = Array(
					'wilayah_title' => $this->input->post('wilayah_title', TRUE),
					'wilayah_content' => $this->input->post('wilayah_content', TRUE),
					'wilayah_slug' => strtolower(url_title($this->input->post('wilayah_title', TRUE))),
					'user_id' => ($this->input->post('user_id', TRUE)) ? $this->input->post('user_id', TRUE): NULL,
				);

				$save = $this->m_crud->save_data($data, 'new_wilayah');
				if ($save == TRUE) {
					redirect(base_url().'administrator/all_new_wilayah');
				} else {
					redirect(base_url().'administrator/all_new_wilayah');
				}
			}
			else {
				echo "<script>alert('Gagal menyimpan');
				</script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/new_new_wilayah';
				$this->load->view('administrator/index', $data);
			}
		} else {
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/new_new_wilayah';
			$this->load->view('administrator/index', $data);
		}

	}

	function edit_new_wilayah( $id=null ) {
		if ( !$this->ion_auth->logged_in() ) {
			redirect('administrator/login', 'refresh');
		}
		
		elseif ( !$this->ion_auth->is_admin() ) {
			return show_error('You must be an administrator to view this page.');
		}

		$dataWilayah = $this->m_crud->get_data('*','new_wilayah','WHERE wilayah_id = '.$id)->row();

		if ( $this->input->post() ) {

			$_POST['wilayah_slug'] = strtolower(url_title($this->input->post('wilayah_title', TRUE)));

			$this->form_validation->set_rules('wilayah_title', 'wilayah Title', 'trim|required|xss_clean|is_unique[new_wilayah.wilayah_title]');
			$this->form_validation->set_rules('wilayah_content', 'wilayah Content', 'trim|required');
			$this->form_validation->set_rules('wilayah_slug', 'wilayah Slug Title', 'trim|required|xss_clean|is_unique[new_wilayah.wilayah_slug]');

			if ($this->form_validation->run() == TRUE) {
				$data = array(
					'wilayah_slug' => strtolower(url_title($this->input->post('wilayah_title', TRUE))),
					'wilayah_title' => $this->input->post('wilayah_title', TRUE),
					'wilayah_content' => $this->input->post('wilayah_content', TRUE),
				);
				$save = $this->m_crud->update_data($id, 'wilayah_id', $data, 'new_wilayah');
				if($save == TRUE){
					redirect(base_url().'administrator/all_new_wilayah'); 
				}else{
					redirect(base_url().'administrator/edit_new_wilayah/'.$id);
				}

			}
			else {
				echo "<script>alert('Gagal menyimpan'); </script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/edit_new_wilayah';
				$data['data_wilayah'] = $dataWilayah;
				$this->load->view('administrator/index', $data);
				return;
			}
		} else {
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/edit_new_wilayah';
			$data['data_wilayah'] = $dataWilayah;
			$this->load->view('administrator/index', $data);
			return;
		}
	}

	function delete_new_wilayah($id){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$delete = $this->m_crud->delete_data($id, 'wilayah_id', 'new_wilayah');
		if($delete == TRUE){
			redirect(base_url().'administrator/all_new_wilayah');
		}else{
			redirect(base_url().'administrator/all_new_wilayah');
		}

	}

	/**
	 * [all_page description]
	 * @return [type] [description]
	 */
	function all_page() {
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}

		$data['cat'] = $this->m_crud->get_data('page.*','page')->result();
		$data['users'] = $this->ion_auth->user()->row();
		$data['page'] = 'administrator/all_page';
		$this->load->view('administrator/index', $data);

	}

	function new_page() {
		if (!$this->ion_auth->logged_in()) {
			redirect('administrator/login', 'refresh');
		}
		elseif(!$this->ion_auth->is_admin()) {
			return show_error('You must be an administrator to view this page.');
		}
		
		if ( $this->input->post() ) {

			$_POST['page_slug'] = strtolower(url_title($this->input->post('page_title', TRUE)));
			$this->form_validation->set_rules('page_title', 'Page Title', 'trim|required|xss_clean|is_unique[page.page_title]');
			$this->form_validation->set_rules('page_content', 'Page Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('page_slug', 'Page Slug Title', 'trim|required|xss_clean|is_unique[page.page_slug]');

			if ($this->form_validation->run() == TRUE) {
				$data = Array(
					'page_title' => $this->input->post('page_title', TRUE),
					'page_content' => $this->input->post('page_content', TRUE),
					'page_slug' => strtolower(url_title($this->input->post('page_title', TRUE))),
					'user_id' => ($this->input->post('user_id', TRUE)) ? $this->input->post('user_id', TRUE): NULL,
				);

				$save = $this->m_crud->save_data($data, 'page');
				if ($save == TRUE) {
					redirect(base_url().'administrator/all_page');
				} else {
					redirect(base_url().'administrator/all_page');
				}
			}
			else {
				echo "<script>alert('Gagal menyimpan');
				</script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/new_page';
				$this->load->view('administrator/index', $data);
			}
		} else {
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/new_page';
			$this->load->view('administrator/index', $data);
		}

	}

	function edit_page( $id=null ) {
		if ( !$this->ion_auth->logged_in() ) {
			redirect('administrator/login', 'refresh');
		}
		
		elseif ( !$this->ion_auth->is_admin() ) {
			return show_error('You must be an administrator to view this page.');
		}

		$dataPage = $this->m_crud->get_data('*','page','WHERE page_id = '.$id)->row();

		if ( $this->input->post() ) {

			$this->form_validation->set_rules('page_title', 'Page Title', 'trim|required|xss_clean|is_unique[page.page_title]');
			$this->form_validation->set_rules('page_content', 'Page Content', 'trim|required|xss_clean');

			if ($this->form_validation->run() == TRUE) {
				$data = array(
					'page_title' => $this->input->post('page_title', TRUE),
					'page_content' => $this->input->post('page_content', TRUE),
				);
				$save = $this->m_crud->update_data($id, 'page_id', $data, 'page');
				if($save == TRUE){
					redirect(base_url().'administrator/all_page'); 
				}else{
					redirect(base_url().'administrator/edit_page/'.$id);
				}

			}
			else {
				echo "<script>alert('Gagal menyimpan'); </script>";
				$data['users'] = $this->ion_auth->user()->row();
				$data['page'] = 'administrator/edit_page';
				$data['data_page'] = $dataPage;
				$this->load->view('administrator/index', $data);
				return;
			}
		} else {
			$data['users'] = $this->ion_auth->user()->row();
			$data['page'] = 'administrator/edit_page';
			$data['data_page'] = $dataPage;
			$this->load->view('administrator/index', $data);
			return;
		}
	}

	function delete_page($id){
		if (!$this->ion_auth->logged_in()){
			redirect('administrator/login', 'refresh');
		}elseif(!$this->ion_auth->is_admin()){
			return show_error('You must be an administrator to view this page.');
		}

		$delete = $this->m_crud->delete_data($id, 'page_id', 'page');
		if($delete == TRUE){
			redirect(base_url().'administrator/all_page');
		}else{
			redirect(base_url().'administrator/all_page');
		}

	}

}
