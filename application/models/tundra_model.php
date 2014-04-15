<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tundra_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_tabs_for_user($user)
	{
		return $this->db->get_where('tab', array('user' => $user))->result_array();
	}
	
	public function get_widgets_in_tab($tab, $user)
	{	
		return $this->db->query('
			SELECT widget.id, widget.title, widget.type, widget.config, widget.column, widget_type.name AS type, widget.refresh, widget.order
			FROM widget, widget_type, section, tab
			WHERE tab.name = ' . $this->db->escape($tab) . '
			AND tab.user = ' . $this->db->escape($user) . '
			AND section.tab = tab.id
			AND widget.column = section.id
			AND widget.type = widget_type.id
			ORDER BY widget.column, widget.order
		')->result_array();
	}
	
	public function get_search_engine($user)
	{
		$t = $this->db->query('
			SELECT search_engine.name, search_engine.action, search_engine.modifier
			FROM user_profile, search_engine
			WHERE user_profile.search_engine = search_engine.id
			AND user_profile.user_id = ' . $this->db->escape($user))->result_array();
			
		return $t[0];
	}
	
	public function get_theme($user)
	{
		$t = $this->db->query('
			SELECT theme.name, theme.directory, user.username
			FROM user_profile, theme, user
			WHERE user_profile.theme = theme.id
			AND theme.creator = user.id
			AND user_profile.user_id = ' . $this->db->escape($user))->result_array();
			
		return $t[0];
	}
	
	public function get_all_themes()
	{
		return $this->db->query('
			SELECT theme.id, theme.name, theme.description, theme.directory, user.username AS creator
			FROM theme, user
			WHERE theme.creator = user.id
			ORDER BY theme.id
		')->result_array();
	}
	
	public function get_widget_configuration($id)
	{
		$t = $this->db->query('
			SELECT *
			FROM widget
			WHERE widget.id = ' . $this->db->escape($id)
		)->result_array();
		
		return $t[0];
	}
	
	public function get_widget_type_data($id)
	{
		$t = $this->db->query('
			SELECT widget_type.*
			FROM widget, widget_type
			WHERE widget.id = ' . $this->db->escape($id) . '
			AND widget.type = widget_type.id
		')->result_array();
		
		return $t[0];
	}
	
	public function save_new_theme($user, $new)
	{
		$this->db->where('id', $user);
		$this->db->update('user_profile', array('theme' => $new));
	}
	
	public function save_widget_configuration($id, $new_config, $refresh)
	{
		 $this->db->where('id', $id);
		 $this->db->update('widget', array('config' => $new_config, 'refresh' => $refresh));
	}
	
	public function save_widget_order($widget_id, $new_order, $new_column)
	{
		$this->db->where('id', $widget_id);
		$this->db->update('widget', array('order' => $new_order, 'column' => $new_column));
	}
	
	public function get_unique_columns_in_tab($tab, $user)
	{
		$t = $this->db->query('
			SELECT DISTINCT widget.column
			FROM widget, section, tab
			WHERE widget.column = section.id
			AND section.tab = tab.id
			AND tab.user = ' . $this->db->escape($user) . '
			AND tab.name = ' . $this->db->escape($tab))->result_array();
			
		foreach($t as $item)
			$result[] = (int) $item['column'];
			
		return $result;
	}
}