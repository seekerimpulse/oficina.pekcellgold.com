<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modelo_cobros extends CI_Model{

	function __construct() {
		parent::__construct();


	}

	function listarTodos(){
		$cobros = $this->db->query('select c.id_cobro, CONCAT( c.id_user,". ",up.nombre," ", up.apellido) usuario, cm.descripcion metodo_pago, cs.descripcion estado, c.monto, c.fecha, c.fecha_pago
from cobro c, user_profiles up, cat_metodo_cobro cm, cat_estatus cs
where c.id_user = up.user_id and c.id_metodo = cm.id_metodo and c.id_estatus = cs.id_estatus');
		return $cobros->result();
	}
	
	function añosCobros(){
		$q = $this->db->query("select YEAR(fecha) as año from cobro group by año");
		return $q->result();
	}
	
	function ConsultarCobrosFecha($fecha_inicio, $fecha_final){
		$cobros = $this->db->query('select c.id_cobro, CONCAT( c.id_user,". ",up.nombre," ", up.apellido) usuario, cm.descripcion metodo_pago, cs.descripcion estado, c.monto, c.fecha, c.fecha_pago
from cobro c, user_profiles up, cat_metodo_cobro cm, cat_estatus cs
where c.id_user = up.user_id and c.id_metodo = cm.id_metodo and c.id_estatus = cs.id_estatus and c.fecha BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_final.'";');
		return $cobros->result();
	}
	
}