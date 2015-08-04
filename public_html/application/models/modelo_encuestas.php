<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class modelo_encuestas extends CI_Model
{
	function CrearEncuesta($nombre, $descripcion, $id){
		$data = array(
				'nombre' => $nombre,
				'descripcion' => $descripcion,
				'id_usuario' => $id,
				'estatus'	=> 'ACT'
		);
		$this->db->insert('encuesta', $data);
	}	
	
	function BorarEncuesta($id){
		$q=$this->db->query('SELECT id_pregunta FROM encuesta_pregunta WHERE id_encuesta='.$id);
		$preg=$q->result();
		for($i=0;$i<sizeof($preg);$i++)
		{
			$this->db->query('delete from encuesta_respuesta where id_pregunta='.$preg[$i]->id_pregunta);
		}
		$this->db->query('delete from encuesta where id_encuesta='.$id);
		$this->db->query('delete from encuesta_pregunta where id_encuesta='.$id);
		$n=$this->db->query('SELECT id_encuesta_contestada FROM encuesta_contestada WHERE id_encuesta='.$id);
		$cont=$n->result();
		for($j=0;$j<sizeof($cont);$j++)
		{
			$this->db->query('delete from encuesta_resultado where id_encuesta_contestada='.$cont[$j]->id_encuesta_contestada);
		}
		$this->db->query('delete from encuesta_contestada where id_encuesta='.$id);
	}
	
	function encuesta($id){
		$q=$this->db->query('SELECT * FROM encuesta WHERE id_encuesta='.$id);
		$encuesta=$q->result();
		return $encuesta;
	}
	
	function preguntas_encuesta($id){
		$q=$this->db->query('SELECT * FROM encuesta_pregunta WHERE id_encuesta='.$id);
		$encuesta=$q->result();
		return $encuesta;
	}
	
	function opciones_pregunta($id){
		$q=$this->db->query('SELECT * FROM encuesta_respuesta WHERE id_pregunta='.$id);
		$opciones=$q->result();
		return $opciones;
	}
}