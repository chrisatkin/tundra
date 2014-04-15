<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
	'auth/login' => array(
		array(
			'field' => 'username',
			'label' => 'username',
			'rules' => 'required'
		),
		array(
			'field' => 'password',
			'label' => 'password',
			'rules' => 'required'
		)
	)
);