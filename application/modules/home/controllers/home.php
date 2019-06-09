<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

		$this->load->helper(array('url','download'));
		$this->load->database();
		$this->load->library(array('ion_auth'));

		$this->load->helper("url");
        $this->load->library("pagination");

		$this->load->model("profile_model");
		$this->load->model("kategorial_model");
		$this->load->model("seksi_model");
		$this->load->model("pelayanan_model");
		$this->load->model("download_model");
		$this->load->model("dph_model");
		$this->load->model("wilayah_model");
		$this->load->model("liputan_model");
		$this->load->model("serba_serbi_model");
		$this->load->model("pengalaman_model");
		$this->load->model("kaj_model");
		$this->load->model("post_model");
		$this->load->model("category_model");
		$this->load->model("emagz_model");
		
	}
	
	function error_404(){
        $this->output->set_status_header('404'); 
        $data['page']			= 'page/404';
        $data['error_state']	= 'error_404';
        $data['home_url']		= base_url();
        $this->load->view('core',$data);
	}

	function offline_mode(){
        $data['page']			= 'page/offline';
        $data['error_state']	= 'offline';
        $data['home_url']		= base_url();
        $this->load->view('core',$data);
	}

	function sanberna_readable_date( $datetime, $type = 'formal-complete' ) {
	    $day_names      =   array( '', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu' );
	    $month_names    =   array( '', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember' );
	    $eng_day_names  =   array( '', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
	    $eng_month_names=   array( '', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
	    $dt_parsed      =   strtotime( $datetime );
	    $str_day        =   $day_names[ date( 'N', $dt_parsed ) ];
	    $str_date       =   date( 'j', $dt_parsed );
	    $str_month      =   $month_names[ date( 'n', $dt_parsed ) ];
	    $str_year       =   date( 'Y', $dt_parsed );
	    $str_time       =   date( "H:i", $dt_parsed );
	    $str_res        =   null;
	    $eng_str_day    =   $eng_day_names[ date( 'N', $dt_parsed ) ];
	    $eng_str_month  =   $eng_month_names[ date( 'n', $dt_parsed ) ];
	
	    switch ($type) :
	        case 'date-month' :
	            $str_res = $str_date . ' ' . $str_month;
	            break;
	
	        case 'date-month-year':
	            $str_res = $str_date . ' ' . $str_month . ' ' . $str_year;
	            break;
	            
	        case 'date-month-year-time' :    
	            $str_res = $str_date . ' ' . $str_month . ' ' . $str_year . ' &middot; ' . $str_time . ' WIB';
	            break;
	
	        case 'date-only' :
	            $str_res = $str_date . ' ' . $str_month . ' ' . $str_year;
	            break;
	
	        case 'eng-date-month-year':
	            $str_res = $eng_str_month . ' ' .$str_date . ', ' .  $str_year;
	            break;
	
	        case 'formal-complete' :
	            $str_res = $str_day . ', ' . $str_date . ' ' . $str_month . ' ' . $str_year;
	            break;
	
	        case 'formal-concise' :
	            $str_res = $str_date . ' ' . substr( $str_month, 0, 3 ) . ' &#39;' . substr( $str_year, -2 );
	            break;
	            
	        default :
	            $str_res = $str_day . ', ' . $str_date . ' ' . $str_month . ' ' . $str_year;
	            break;
	    endswitch;
	
	    return $str_res;
	}

	function sanberna_get_share_url( $social_media = 'facebook', $title) {
		
		$permalink = base_url(uri_string());
		
	    if ( $social_media == 'facebook' ) :
	        $share_url  =   'https://www.facebook.com/sharer/sharer.php?u=' . $permalink;
	    elseif ( $social_media == 'twitter' ) :
	        $share_url  =   'https://twitter.com/intent/tweet?url=' .$permalink. '&amp;via=st_bernadet&amp;related=st_bernadet&amp;text=' . $title;
	    elseif ( $social_media == 'googleplus' ) :
	        $share_url  =   'https://plus.google.com/share?url=' . $permalink;
	    elseif ( $social_media == 'whatsapp' ) :
	        $share_url  =   'whatsapp://send?text=' . $permalink;
	    endif;
	
	    return htmlspecialchars($share_url);
	}
	
	function sanberna_summon_opengraph_protocol( $title, $image, $desc ) {
		
		$permalink = base_url(uri_string());
		
		$str	=	'';	
        $str    =   '<meta property="fb:app_id" content="1952981328318226">';
        $str    .=  '<meta property="og:description" content="' .$desc. '">';
        $str    .=  '<meta property="og:image" content="' . base_url('uploads/'.$image) . '">';
        $str    .=  '<meta property="og:title" content="' . $title . '">';
        $str    .=  '<meta property="og:type" content="article">';
        $str    .=  '<meta property="og:url" content="' . $permalink . '">';

	    return $str;
	}
	
	function sanberna_summon_twitter_card( $title, $image, $desc ) {
		
		$str				=	'';
        $twitter_user       =   '@st_bernadet';

        $str    =   '<meta name="twitter:card" content="summary_large_image">';
        $str    .=  '<meta name="twitter:site" content="' . $twitter_user . '">';
        $str    .=  '<meta name="twitter:creator" content="' . $twitter_user . '">';
        $str    .=  '<meta name="twitter:title" content="' . $title . '">';
        $str    .=  '<meta name="twitter:description" content="' . $desc . '">';
        $str    .=  '<meta name="twitter:image" content="' . base_url('uploads/'.$image) . '">';

	    return $str;
	}	
	
	function sanberna_cut_long_text( $original_text, $length = 140, $strip_tags = true ) {
	    $str    =   null;
	    $input  =   str_replace( '&nbsp;', '', $original_text );
	    $input  =   trim( $input );
	    $input  =   ( $strip_tags ) ? strip_tags( $input ) : $input;
	
	    if ( strlen( $input ) < $length ) :
	        $str = $input;
	    else :
	        // get last space pos within string length
	        $last_space = strrpos( substr( $input, 0, $length ), ' ' );
	        $str = trim( substr( $input, 0, $last_space ) . '...' );
	    endif;
	
	    return $str;
	}	

	// redirect if needed, otherwise display the user list
	function index(){
		$data['posts'] = $this->db->query('SELECT * FROM posts WHERE post_id = 1 AND post_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['liputan'] = $this->db->query('SELECT p.*, CONCAT(u.first_name," ",u.last_name) AS nama FROM posts p LEFT JOIN users u ON u.id = p.post_author WHERE category_id = 10 AND post_status = 1 ORDER BY p.post_created DESC LIMIT 4');
		$data['serba_serbi'] = $this->db->query('SELECT p.*, CONCAT(u.first_name," ",u.last_name) AS nama FROM posts p LEFT JOIN users u ON u.id = p.post_author WHERE category_id = 12 AND post_status = 1 ORDER BY p.post_created DESC LIMIT 4');
		$data['pengalaman'] = $this->db->query('SELECT p.*, CONCAT(u.first_name," ",u.last_name) AS nama FROM posts p LEFT JOIN users u ON u.id = p.post_author WHERE category_id = 11 AND post_status = 1 ORDER BY p.post_created DESC LIMIT 4');
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kegiatan'] = $this->db->query('SELECT * FROM posts WHERE category_id = 15 AND post_status = 1 LIMIT 8');
		$data['latest_post'] = $this->db->query('SELECT * FROM posts p JOIN categories cat ON (p.category_id = cat.category_id) WHERE p.post_status = 1 AND cat.category_id NOT IN (4,6,7) ORDER BY p.post_created DESC LIMIT 5');
		$data['option'] = $this->db->get('options')->result();
		$data['emagz'] = $this->db->query('SELECT * FROM emagz WHERE post_status = 1 ORDER BY post_created DESC LIMIT 1');
		// if($this->input->post()){
		// 	$remember = (bool) $this->input->post('remember', TRUE);
		// 	if ($this->ion_auth->login($this->input->post('identity', TRUE), $this->input->post('password', TRUE), $remember)){
		// 		$this->session->set_flashdata('message', $this->ion_auth->messages());
		// 		redirect(base_url().'administrator', 'refresh');
		// 	}else{
		// 		$this->ion_auth->increase_login_attempts($this->input->post('identity', TRUE));
		// 		$this->session->set_flashdata('message', $this->ion_auth->errors());
		// 		redirect('administrator/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
		// 	}
		// }

		$data['page'] = 'page/home';
		$this->load->view('core', $data);
	}

	// function register_user(){
	// 	$this->load->library(array('ion_auth'));
	// 	$username = $this->input->post('first_name');
	// 	$password = $this->input->post('password');
	// 	$email = $this->input->post('email');
	// 	$additional_data = array(
	// 							'first_name' => $this->input->post('first_name', TRUE),
	// 							'last_name' => $this->input->post('last_name', TRUE),
	// 							);
	// 	$group = array('2'); // Sets user to admin.

	// 	if($this->ion_auth->register($username, $password, $email, $additional_data, $group)){
	// 		$this->session->set_flashdata('registered', 1);
	// 		redirect(base_url('home'));
	// 	}else{
	// 		$this->session->set_flashdata('registered', 0);
	// 		redirect(base_url('home'));
	// 	}
	// }

	function post($id){
		$title		= $this->post_model->getPostDetailForOG($id)[0]->post_title;
		$image		= $this->post_model->getPostDetailForOG($id)[0]->post_image;
		$desc		= $this->sanberna_cut_long_text($this->post_model->getPostDetailForOG($id)[0]->post_content);
		
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_post'] = $this->post_model->getPost($id);
		$data['date'] = $this->sanberna_readable_date( $this->post_model->getPostDate($id)->post_created, 'date-month-year' );
		$data['og']	=	$this->sanberna_summon_opengraph_protocol($title, $image, $desc);
		$data['card']	=	$this->sanberna_summon_twitter_card($title, $image, $desc);
		$data['fb_share']	=	$this->sanberna_get_share_url('facebook', $title);
		$data['twit_share']	=	$this->sanberna_get_share_url('twitter', $title);
		$data['wa_share']	=	$this->sanberna_get_share_url('whatsapp', $title);
		$data['page'] = 'page/post';
		$this->load->view('core', $data);
	}

	function emagz($id){
		$title		= $this->emagz_model->getEmagzDetailForOG($id)[0]->post_title;
		$image		= $this->emagz_model->getEmagzDetailForOG($id)[0]->post_image;
		$desc		= $this->sanberna_cut_long_text($this->emagz_model->getEmagzDetailForOG($id)[0]->post_content);
		
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_emagz'] = $this->emagz_model->getEmagz($id);
		$data['date'] = $this->sanberna_readable_date( $this->emagz_model->getEmagzDate($id)->post_created, 'date-month-year' );
		$data['og']	=	$this->sanberna_summon_opengraph_protocol($title, $image, $desc);
		$data['card']	=	$this->sanberna_summon_twitter_card($title, $image, $desc);
		$data['fb_share']	=	$this->sanberna_get_share_url('facebook', $title);
		$data['twit_share']	=	$this->sanberna_get_share_url('twitter', $title);
		$data['wa_share']	=	$this->sanberna_get_share_url('whatsapp', $title);
		$data['page'] = 'page/emagz';
		$this->load->view('core', $data);
	}

	function category($id){
		
		//begin: pagination
		
		$category = $this->category_model->getCategory($id)->result();
		
		$config = array();
        $config["base_url"] = base_url() . "home/category/".$id;
        $config["total_rows"] = $this->category_model->recordCount($category);
        $config["per_page"] = 9;
        $config["uri_segment"] = 4;
        $config["num_links"] = 3;
        $config["full_tag_open"] = "<ul class='pagination category' role='menubar' aria-label='Pagination'>";
        $config["full_tag_close"] = "</ul>";
        $config["next_link"] = "&gt;";
        $config["next_tag_open"] = "<li>";
        $config["next_tag_close"] = "</li>";
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='current'>";
        $config["cur_tag_close"] = "</li>";
        $config['num_tag_open'] = "<li>";
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["results"] = $this->category_model->fetchCategory($config["per_page"], $page, $id);
        $data["links"] = $this->pagination->create_links();

		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['page'] = 'page/category';
		$this->load->view('core', $data);
	}

	// experimental
	function all_news(){
		
		//begin: pagination
		
		$category = $this->category_model->getAllNews()->result();
		
		$config = array();
        $config["base_url"] = base_url() . "home/all_news";
        $config["total_rows"] = $this->category_model->recordCount($category);
        $config["per_page"] = 9;
        $config["uri_segment"] = 3;
        $config["num_links"] = 3;
        $config["full_tag_open"] = "<ul class='pagination category' role='menubar' aria-label='Pagination'>";
        $config["full_tag_close"] = "</ul>";
        $config["next_link"] = "&gt;";
        $config["next_tag_open"] = "<li>";
        $config["next_tag_close"] = "</li>";
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='current'>";
        $config["cur_tag_close"] = "</li>";
        $config['num_tag_open'] = "<li>";
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->category_model->fetchCategory($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['page'] = 'page/category';
		$data['all_news'] = true;
		$this->load->view('core', $data);
	}
	
	// experimental
	function all_emagz(){
		
		//begin: pagination
		
		$bulk = $this->category_model->getAllEmagz()->result();
		
		$config = array();
        $config["base_url"] = base_url() . "home/all_emagz";
        $config["total_rows"] = $this->category_model->recordCount($bulk);
        $config["per_page"] = 9;
        $config["uri_segment"] = 3;
        $config["num_links"] = 3;
        $config["full_tag_open"] = "<ul class='pagination category' role='menubar' aria-label='Pagination'>";
        $config["full_tag_close"] = "</ul>";
        $config["next_link"] = "&gt;";
        $config["next_tag_open"] = "<li>";
        $config["next_tag_close"] = "</li>";
        $config["prev_link"] = "&lt;";
        $config["prev_tag_open"] = "<li>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='current'>";
        $config["cur_tag_close"] = "</li>";
        $config['num_tag_open'] = "<li>";
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->category_model->fetchAllEmagz($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['page'] = 'page/all_emagz';
		$data['title'] = "Semua Warta Paroki Ciledug";
		$this->load->view('core', $data);
	}

	function profile($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_profile'] = $this->profile_model->getProfile($id);
		$data['page'] = 'page/profile';
		$this->load->view('core', $data);
	}

	function dph(){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
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
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_kategorial'] = $this->kategorial_model->getKategorial($id);
		$data['page'] = 'page/kategorial';
		$this->load->view('core', $data);
	}

	function seksi($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_seksi'] = $this->seksi_model->getSeksi($id);
		$data['page'] = 'page/seksi';
		$this->load->view('core', $data);
	}

	function liputan($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_liputan'] = $this->liputan_model->getLiputan($id);
		$data['page'] = 'page/liputan';
		$this->load->view('core', $data);
	}

	function serba_serbi($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_serba_serbi'] = $this->serba_serbi_model->getSerbaSerbi($id);
		$data['page'] = 'page/serba_serbi';
		$this->load->view('core', $data);
	}

	function pengalaman($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_pengalaman'] = $this->pengalaman_model->getPengalaman($id);
		$data['page'] = 'page/pengalaman';
		$this->load->view('core', $data);
	}

	function pelayanan($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_pelayanan'] = $this->pelayanan_model->getPelayanan($id);
		$data['page'] = 'page/pelayanan';
		$this->load->view('core', $data);
	}

	function wilayah($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['wilayah_child'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 1');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_wilayah'] = $this->wilayah_model->getWilayah($id);
		$data['page'] = 'page/wilayah';
		$this->load->view('core', $data);
	}
	
	function new_wilayah($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['wilayah_child'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 1');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		// $data['get_wilayah'] = $this->wilayah_model->getWilayah($id);
		$data['get_new_wilayah'] = $this->wilayah_model->get_new_wilayah($id);
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['page'] = 'page/new_wilayah';
		$this->load->view('core', $data);
	}	

	function page($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['wilayah_child'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 1');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['get_page'] = $this->dph_model->getPage($id);
		$data['page'] = 'page/page';
		$this->load->view('core', $data);
	}

	function kaj($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['wilayah_child'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 1');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_kaj'] = $this->kaj_model->getKaj($id);
		$data['page'] = 'page/kaj';
		$this->load->view('core', $data);
	}

	function download($id){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['get_download'] = $this->download_model->getDownload($id);
		$data['page'] = 'page/download';
		$this->load->view('core', $data);
	}

	public function lakukan_download($id, $tbl){
		$url = site_url().'uploads/';
		$query = $this->db->get_where($tbl, array($tbl.'_id' => $id));

		foreach ($query->result() as $row)
		{	
			$column = $tbl.'_image';
			$isi = file_get_contents(base_url().'uploads/'.$row->$column);
			$nama = $row->$column;
			force_download($nama,$isi);
		}
	}

	public function galery(){
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['galery'] = $this->db->query('SELECT * FROM posts WHERE category_id = 13');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['page'] = 'page/galery';
		$this->load->view('core', $data);
	}

	// function company(){
	// 	$option_name = $_GET['option_name'];
	// 	$this->db->from('options');
	// 	$this->db->where('option_name', $option_name);

	// 	$query = $this->db->get();
	// 	if($query->num_rows() > 0){
	// 		foreach ($query->result() as $row){
	// 			$data = $row;
	// 		}
	// 		echo json_encode($data);
	// 	}
	// }

	// function lowongan_kerja(){
	// 	$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
	// 	$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
	// 	$data['seksi'] = $this->db->query('SELECT * FROM seksi');
	// 	$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
	// 	$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
	// 	$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
	// 	$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
	// 	$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
	// 	$data['loker'] = $this->db->query('SELECT * FROM posts WHERE category_id = 14 AND post_status = 1');
	// 	$data['page'] = 'page/loker';
	// 	$this->load->view('core', $data);
	// }

	// function detail_loker(){
	// 	$post_id = $_GET['post_id'];
	// 	$this->db->from('posts');
	// 	// $this->db->join('users','users.id = posts.post_author','LEFT');
	// 	$this->db->where('posts.post_id', $post_id);

	// 	$query = $this->db->get();
	// 	if($query->num_rows() > 0){
	// 		foreach ($query->result() as $row){
	// 			$data = $row;
	// 		}
	// 		echo json_encode($data);
	// 	}
	// }

	public function filter($tag){
		// $data['filters_kaj'] = $this->db->query('
		// 	SELECT * FROM kaj INNER JOIN posts_tag ON posts_tag.post_id = kaj.id_kaj WHERE posts_tag.tag = '.$tag.' AND posts_tag.post_asal = "kaj"
		// ')->result();
		$data['filters_post'] = $this->db->query('
			SELECT posts.post_title AS judul, posts_tag.tag, posts_tag.post_asal, categories.category_title, posts.post_id
			FROM posts
			INNER JOIN posts_tag ON posts_tag.post_id = posts.post_id
			INNER JOIN categories ON categories.category_id = posts.category_id
			WHERE posts_tag.tag = "'.$tag.'" AND posts_tag.post_asal = "post"
			UNION ALL
			SELECT kaj.judul_folder AS judul, posts_tag.tag, posts_tag.post_asal, posts_tag.post_id, kaj.isi_content
			FROM kaj
			INNER JOIN posts_tag ON posts_tag.post_id = kaj.id_kaj
			WHERE posts_tag.tag = "'.$tag.'" AND posts_tag.post_asal = "kaj"
		')->result();
		$data['profile'] = $this->db->query('SELECT * FROM profile WHERE profile_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['pelayanan'] = $this->db->query('SELECT * FROM pelayanan');
		$data['wilayah'] = $this->db->query('SELECT * FROM new_wilayah ORDER BY wilayah_title ASC');
		$data['wilayah_parent'] = $this->db->query('SELECT * FROM wilayah WHERE wilayah_parent = 0');
		$data['kaj_parent'] = $this->db->query('SELECT * FROM kaj WHERE judul_parent = 0');
		$data['download'] = $this->db->query('SELECT * FROM posts WHERE category_id = 7 AND post_status = 1');
		$data['loker'] = $this->db->query('SELECT * FROM posts WHERE category_id = 14 AND post_status = 1');
		$data['kategorial'] = $this->db->query('SELECT * FROM kategorial');
		$data['seksi'] = $this->db->query('SELECT * FROM seksi');
		$data['page'] = 'page/filter';
		$this->load->view('core', $data);

	}


}
