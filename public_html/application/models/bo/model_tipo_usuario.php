<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_tipo_usuario extends CI_Model{

	function __construct() {
		parent::__construct();


	}

	function listarTodos(){
		$tipos = $this->db->get('cat_perfil_permiso');
		return $tipos->result();
	}
}