<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		
		parent::__construct();
		$this->load->model('UtilityMethods');
		$this->UtilityMethods->loginAuthentication();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('homemodel');
		


	}


	public function index()
	{
		if (isset($this->session->userdata['logged_in'])) { 
			$this->load->view('home');
		}else{
			$this->load->view('login');
		}
	}
}
