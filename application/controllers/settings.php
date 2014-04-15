<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends TN_AuthenticatedController
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('file');
		$this->load->model('Tundra_model', 'model');
	}
	
	public function index()
	{
		if($this->input->post('submit'))
		{
			$this->tundra->save_new_theme($this->_data['user_id'], $this->input->post('theme'));
			redirect('settings');
		}
	
		$this->_data['themes'] = $this->tundra->get_all_themes();
				
		// Get the tabs for a page
		$this->_data['tabs'] = $this->model->get_tabs_for_user($this->session->userdata('user_id'));
				
		$this->template->load('settings/_template', 'settings/index', $this->_data);
	}
}