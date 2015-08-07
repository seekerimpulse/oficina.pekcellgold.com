<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class model_soporte_tecnico extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	function consultar_asignacion_de_soporte($id){
        $consultar_asignacion = $this->db->query("SELECT id from user_soporte where id_user=".$id."");
		return $consultar_asignacion->result();
	}
	function asignar_red_de_soporte($id) {
			$red_temporal = array (
				"id_user" => $id,
				"id_red_temporal" => $_GET ['id_red']
		    );
		$this->db->insert ( "user_soporte", $red_temporal );
	}
	function actualizar_asignacion_de_red($id){
		
		$datos=array(
				"id_user"=> $id,
				"id_red_temporal" => $_GET['id_red']
		);
		$this->db->where('id_user', $id);
		$this->db->update('user_soporte', $datos);
	}
	
	
	function consultar_asignacion_de_soporte_a_usuario($id){
		$consultar_asignacion_red= $this->db->query("SELECT id from user_red_temporal where id_user=".$id."");
		return $consultar_asignacion_red->result();
	}
	function asignar_red_de_soporte_a_usuario($id) {
		$red_temporal = array (
				"id_user" => $id,
				"id_red_temporal" => $_GET ['id_red']
		);
		$this->db->insert ( "user_red_temporal", $red_temporal );
	}
	function actualizar_asignacion_de_red_a_usuario($id){
	
		$datos=array(
				"id_user"=> $id,
				"id_red_temporal" => $_GET['id_red']
		);
		$this->db->where('id_user', $id);
		$this->db->update('user_red_temporal', $datos);
	}
	
	/*
	function ingresar_chat($id){
		$chat_temporal = array (
				"id_user" => $id,
				"registro_chat" => "1"
		);
		$this->db->insert ( "user_registro_chat", $chat_temporal );
	}
	
	function actualizar_chat($id){

		$datos=array(
				"id_user"=> $id,
				"registro_chat" => "1"
		);
		$this->db->where('id_user', $id);
		$this->db->update('user_registro_chat', $datos);
	}

	function consultar_chat($id){
		$consultar_chat = $this->db->query("SELECT registro_chat from user_registro_chat where id_user=".$id."");
		return $consultar_chat->result();
	}
	*/
	}