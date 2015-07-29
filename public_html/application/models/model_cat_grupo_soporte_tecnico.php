<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_cat_grupo_soporte_tecnico extends CI_Model{

	function __construct() {
		parent::__construct();


	}

	function listar()
	{
		$q=$this->db->query('select * from cat_grupo_soporte_tecnico');
		return $q->result();
	}
	
	function traer_grupo($id)
	{
		$q=$this->db->query('select * from cat_grupo_soporte_tecnico where id="'.$id.'"');
		return $q->result();
	}
	
	function actualizar_grupo(){
		$this->db->query('UPDATE cat_grupo_soporte_tecnico SET descripcion="'.$_POST['descripcion'].'",tipo="'.$_POST['tipo'].'",id_red="'.$_POST['red'].'" WHERE id="'.$_POST['id'].'"');
		return true;
	}
	
	function get_groups($tipo, $id_red)
	{
		$q=$this->db->query('select * from cat_grupo_soporte_tecnico where estatus="ACT" and tipo="'.$tipo.'" and id_red='.$id_red);
		return $q->result();
	}
	
}