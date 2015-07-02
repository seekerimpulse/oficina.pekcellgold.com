<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class modelo_billetera extends CI_Model
{
	function get_estatus($id)
	{
		$q=$this->db->query('SELECT * from billetera where id_user='.$id);
		return $q->result();
	}
	function crea_pswd($id)
	{
		$pswd=strlen($_POST['password']).strrev($_POST['password']);
		$pswd=md5($pswd).$pswd;
		$pswd=md5(strrev($pswd));
		$this->db->query('update billetera set pswd="'.$pswd.'", estatus="ACT" where id_user='.$id);
	}
	function iniciar($id)
	{
		$pswd=strlen($_POST['password']).strrev($_POST['password']);
		$pswd=md5($pswd).$pswd;
		$pswd=md5(strrev($pswd));

		$q=$this->db->query('select * from billetera where pswd="'.$pswd.'" and id_user='.$id);
		return $q->result();
	}
	function sesion($id)
	{
		$q=$this->db->query('select activo from billetera where id_user='.$id);
		return $q->result();
	}
	function activar($id)
	{
		$q=$this->db->query('update billetera set activo="Si" where id_user='.$id);
	}
	function desactivar($id)
	{
		$q=$this->db->query('update billetera set activo="No" where id_user='.$id);
	}
	function get_historial($id)
	{
		$q=$this->db->query('select * from cobro where id_user='.$id.'  and (id_estatus=4 or id_estatus=5)  order by fecha');
		return $q->result();
	}
	function get_monto($id)
	{
		$q=$this->db->query('select sum(monto) as monto from cobro where id_user='.$id.' and id_estatus=4');
		return $q->result();
	}
	function get_cobro($id)
	{
		$q=$this->db->query('select * from cobro where id_user='.$id);
		return $q->result();
	}
	function datable($id)
	{
		$q=$this->db->query('select * ,(select descripcion from cat_metodo_cobro MP where C.id_metodo=MP.id_metodo) metodo, (select descripcion from cat_estatus CE where CE.id_estatus=C.id_estatus) estado from cobro C where id_user='.$id.' order by fecha');
		return $q->result();
	}
	function get_metodo()
	{
		$q=$this->db->query('select * from cat_metodo_cobro');
		return $q->result();
	}
	function cobrar($id)
	{
		$q=$this->db->query('select * from cobro where id_user='.$id.' and id_estatus=4 ');
		$q=$q->result();
		$id_cobro=$q[0]->id_cobro;

		$this->db->query('update cobro set id_estatus=5 where id_cobro='.$id_cobro);

		$dato_cobro=array(
	                "id_user"		=>	$id,
	                "id_metodo"		=> 	$_POST['metodo'],
	                "id_estatus"		=> 	"3",
	                "monto"			=> 	$_POST['cobro']
	            );
		$this->db->insert("cobro",$dato_cobro);

		$monto=$q[0]->monto;
		$monto_activo=$monto-$_POST['cobro'];
		$dato_cobro=array(
	                "id_user"		=>	$id,
	                "id_metodo"		=> 	$_POST['metodo'],
	                "id_estatus"		=> 	"4",
	                "monto"			=> 	$monto_activo
	            );
		$this->db->insert("cobro",$dato_cobro);
	}
	
	function añosCobro($id){
		$q = $this->db->query("select YEAR(fecha) as año from cobro where id_user='$id' group by año");
		return $q->result();
	}
}