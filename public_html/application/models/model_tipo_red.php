<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_tipo_red extends CI_Model{

	function __construct() {
		parent::__construct();


	}

	function insertar($nombre, $descripcion, $profundidad, $frontal){
		$datos = array('id' => 0,
						'nombre' => $nombre,
						'descripcion' => $descripcion,
						'frontal' => $frontal,
						'profundidad' => $profundidad);
		$this->db->insert("tipo_red",$datos);
	}

	function listarTodos()
	{
		$q=$this->db->query('select id, nombre, descripcion from tipo_red');
		return $q->result();
	}
	
	function traerCapacidadRed()
	{
		$q = $this->db->query('select frontal,profundidad from tipo_red where id = 1');
		
		return $q->result();
	}
	function actualizarCapacidadRed($frontal, $profundidad){
		$datos = array(	'frontal' => $frontal,
						'profundidad' => $profundidad);
		
		$this->db->update('tipo_red', $datos);
	}
}