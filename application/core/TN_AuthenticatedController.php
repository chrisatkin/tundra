<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TN_AuthenticatedController extends CI_Controller
{
	protected $_data;

	// --------------------------------------------------------------------------
	
	public function __construct()
	{
		parent::__construct();
		
		// Ensure logged in
		if (!$this->tank_auth->is_logged_in())
			redirect('welcome');
			
		$this->load->model('tundra_model', 'tundra');

		$this->_data['user_id'] = $this->tank_auth->get_user_id();
		$this->_data['username']= $this->tank_auth->get_username();
		$this->_data['profile']['theme'] = $this->tundra->get_theme($this->_data['user_id']);
		$this->_data['profile']['search_engine'] = $this->tundra->get_search_engine($this->_data['user_id']);
		
		//var_dump(isset($_GET['edit']));
	}
}