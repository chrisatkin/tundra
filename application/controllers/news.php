<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends TN_AuthenticatedController
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Tundra_model', 'model');
	}
	
	public function index()
	{
		// Get the tabs for a page
		$this->_data['tabs'] = $this->model->get_tabs_for_user($this->session->userdata('user_id'));
	
		$this->load->view('news/latest', $this->_data);
	}
	
}