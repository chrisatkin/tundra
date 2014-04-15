<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends TN_AuthenticatedController
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Tundra_model', 'model');
	}
	
	public function index()
	{
		redirect('dashboard/home');
	}
	
	public function tab($tab)
	{
		// Get the tabs for a page
		$this->_data['tabs'] = $this->model->get_tabs_for_user($this->session->userdata('user_id'));
		
		//  Load the view
		$this->load->view('dashboard/index', $this->_data);
	}
}