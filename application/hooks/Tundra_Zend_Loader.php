<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tundra_Zend_Loader
{

	/**
	 * Function includes 
	 */
	public function load()
	{
		ini_set('include_path', ini_get('include_path') . ':' . BASEPATH);
	}
}