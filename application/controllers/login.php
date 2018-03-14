<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('UtilityMethods');
		$this->load->model('loginmodel');

		
	}

// Show login page
	public function index() {
		
		if(isset($this->session->userdata['logged_in']['user_id'])){
			redirect(base_url('home'));
		}

		$this->load->view('login');

	}


// Check for user login process
	public function login_process() { 

		$login_error_data = '';
		if(isset($this->session->userdata['logged_in']['user_id'])){
			redirect(base_url('home'));
		} else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			); 
			$result = $this->loginmodel->userAuthentication($data);
				if ($result == TRUE) {

					$username = $this->input->post('username');
					$password = $this->input->post('password');

					$pswd = md5($password);

					$result = $this->loginmodel->read_user_information($username);

					$user_pswd = $this->UtilityMethods->getRealPassword($result[0]->user_password); 
						
						if ($user_pswd == $pswd) {
							$session_data = array(	
													'user_id' => $result[0]->user_id,
													'username' => $result[0]->user_username,
													'caption_name' => $result[0]->user_name,
							);
							// Add user data in session
							$this->session->set_userdata('logged_in', $session_data);
							$this->session->set_flashdata('login_success', 'Logged in Successfully..');
								redirect(base_url('home'));
						}else{
								$this->session->set_flashdata('login_error', 'Invalid Password...!');
								redirect(base_url());
						}
						
				} else {	
					
					
					$this->session->set_flashdata('login_error', 'Invalid Username...!');
					redirect(base_url());
				}
		}
	}

	// Logout from admin page
	public function logout() {

			$sess_array = array(
					'username' => '','caption_name' => '','user_id' => ''
			);
		$this->session->sess_destroy();
		$this->session->set_flashdata('login_error', 'Successfully Logged out..');

		redirect(base_url());
		
		}


}
