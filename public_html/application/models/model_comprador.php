<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_comprador extends CI_Model{

	function __construct() {
		parent::__construct();
	}
	
	function get_comprador($dni){
		$q=$this->db->query('select * from comprador where dni='.$dni);
		return $q->result();
	}
	
	function actualizar($username, $clave){
		$datos = array(
				'clave' => $clave);
		$this->db->where("username",$username);
		$this->db->update("user_webs_personales",$datos);
	}
	
	function insertar($username, $clave){
		$datos = array(
				'username' => $username,
				'clave' => $clave
		);
		$this->db->insert("user_webs_personales",$datos);
	}
}