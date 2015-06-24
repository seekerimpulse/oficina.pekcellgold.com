<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_afiliado extends CI_Model{

	function __construct() {
		parent::__construct();
		$this->load->library('Tank_auth');
	}

	function crear_user(){
		$this->Tank_auth->create_user($username, $email, $password, $email_activation);
		
	}

}