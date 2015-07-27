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
	
	function traerRed($idRed)
	{
		$q=$this->db->query('select nombre, descripcion from tipo_red where id = '.$idRed);
		return $q->result();
	}
	
	function traer_nombre_red($idRed)
	{
		$q=$this->db->query('select nombre from tipo_red where id = '.$idRed);
		return $q->result();
	}
	
	function ObtenerFrontales()
	{
		$q=$this->db->query('select frontal from tipo_red where id=1');
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
	function actualizar($id, $nombre, $descripcion, $profundidad, $frontal){
		$datos = array(
				'nombre' => $nombre,
				'descripcion' => $descripcion,
				'frontal' => $frontal,
				'profundidad' => $profundidad);
		$this->db->update("tipo_red",$datos,"id = ".$id);
	}
	
}