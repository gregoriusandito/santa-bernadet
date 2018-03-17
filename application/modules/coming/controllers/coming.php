<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Coming extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	// redirect if needed, otherwise display the user list
	function index(){
		$this->load->view('coming/coming');
	}
}
