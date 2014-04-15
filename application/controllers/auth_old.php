<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}
	
	public function index()
	{
		$this->load->view('auth/index');
	}
	
	public function login()
	{
		if($this->form_validation->run() == false)
			$this->load->view('auth/index');
		else
			// Check if the username and password is correct
			$this->quickauth->login($this->input->post('username'), $this->input->post('password'), 'dashboard/home');
	}
	
	public function logout()
	{
		$this->quickauth->logout();
		redirect('welcome');
	}
}