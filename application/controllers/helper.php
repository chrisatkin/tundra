<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper extends TN_AuthenticatedController
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		redirect();
	}
	
	public function script($which)
	{
		$this->output->set_content_type('text/javascript');
		$this->load->view('helper/script/' . $which);
	}
	
	public function get_page_configuration($tab_name)
	{
		$data['tab_name'] = $tab_name;
		$data['config'] = $this->tundra->get_widgets_in_tab(ucfirst($tab_name), $this->session->userdata('user_id'));
	
		$this->output->set_content_type('application/json');
		$this->load->view('helper/page_configuration', $data);
	}
	
	public function set_widget_order()
	{
		// Get POST data
		$tab = $this->input->post('tab');
		$new_order = $this->input->post('order');
		
		// Combine the new ordering with the column IDs
		$current_tabs = $this->tundra->get_unique_columns_in_tab($tab, $this->session->userdata('user_id'));
		$ordering = array_combine($current_tabs, $new_order);
		
		// Update the database with the new orders
		foreach($ordering as $new_column => $value)
		{
			foreach($value as $new_order => $widget)
			{
				$id = explode('-', $widget);
				$id = (int) $id[1];
				
				$this->tundra->save_widget_order($id, $new_order + 1, $new_column);
			}
		}
	}
	
	public function get_widget_html($widget)
	{
		$this->load->view('helper/widget/' . $widget, $this->_data);
	}
	
	public function widget_configuration()
	{	
		if(isset($_POST['widget']))
		{
			$new_config = $this->input->post();
			
			// To save into the database
			// First, remove the 'special' values, i.e., one's that aren't to be serialized
			foreach(array('widget', 'submit', 'refresh') as $to_remove)
				unset($new_config[$to_remove]);

			// Update the database
			$this->tundra->save_widget_configuration($this->input->post('widget'), serialize($new_config), $this->input->post('refresh'));
			
			$data['message'] = "Widget configuration saved";
		}
		
		$id = $this->uri->rsegment(3);
		
		$data['widget_info'] = $this->tundra->get_widget_type_data($id); 
		$data['config'] = $this->tundra->get_widget_configuration($id);
				
		$this->load->view('helper/widget_configuration', $data);
	}
	
	public function rss_proxy()
	{
		// Ensure we have a url and a number to parse
		if(!$this->input->get('url') || !$this->input->get('display'))
			return;
	
		// Load helpers
		$this->load->helper('text');
		require_once('Zend/Feed/Reader.php');
		
		try
		{
			$data['feed'] = Zend_Feed_Reader::import($this->input->get('url'));
			$this->load->view('helper/rss_proxy', $data);
		}
		catch(Exception $e)
		{
			$this->load->view('helper/rss_error');
		}
	}
	
	public function json_proxy()
	{
		$this->load->view('helper/json_proxy', array('content' => file_get_contents($this->input->get('url'))));
	}
	
	// --------------------------------------------------------------------------
	
	
}