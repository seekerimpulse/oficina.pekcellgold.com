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
	
	function RedesUsuario($id)
	{
		$q=$this->db->query('select tr.id, tr.nombre, tr.descripcion from tipo_red tr, afiliar a where tr.id = a.id_red and a.id_afiliado = '.$id);
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
	
	function CapacidadRed($id_red)
	{
		$q = $this->db->query('select id,frontal,profundidad from tipo_red where id = '.$id_red);
	
		return $q->result();
	}
}