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
		$q=$this->db->query('select * from cobro where  id_estatus != 4 and id_user='.$id);
		return $q->result();
	}
	function datable($id)
	{
		$q=$this->db->query('select * ,
							(select descripcion from cat_metodo_cobro MP where C.id_metodo=MP.id_metodo) metodo, 
							(select descripcion from cat_estatus CE where CE.id_estatus=C.id_estatus) estado 
							from cobro C where id_user='.$id.' and (id_estatus = 3 or id_estatus = 2) order by fecha');
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
		
		
		if($_POST['cobro'] < $q[0]->monto){
			
			$id_cobro=$q[0]->id_cobro;
			$monto = $q[0]->monto;
			$monto_activo = $monto-$_POST['cobro'];
			
			
			$this->db->query('update cobro set id_estatus= 5 where id_cobro='.$id_cobro);
			
			
			$dato_cobro=array(
		                "id_user"		=>	$id,
		                "id_metodo"		=> 	$_POST['metodo'],
		                "id_estatus"		=> 	"3",
		                "monto"			=> 	$_POST['cobro']
		            );
			$this->db->insert("cobro",$dato_cobro);
			
			
			$dato_cobro=array(
					"id_user"		=>	$id,
					"id_metodo"		=> 	$_POST['metodo'],
					"id_estatus"		=> 	"4",
					"monto"			=> 	$monto_activo
			);
			
			$this->db->insert("cobro",$dato_cobro);
			return true;
		}else{
			return false;
		}
		
	}
	
	function añosCobro($id){
		$q = $this->db->query("select YEAR(fecha) as año from cobro where id_user='$id' group by año");
		return $q->result();
	}
	
	function ValorImpuestos($id, $pais){
		$mes = date("m");
		$q = $this->db->query("select ci.id_impuesto, ci.descripcion, sum(v.costo * (ci.porcentaje/100)) as impuesto 
					from venta v, cross_venta_mercancia cvm, cross_merc_impuesto cmi, cat_impuesto ci, mercancia m 
					where v.id_venta = cvm.id_venta and  cmi.id_mercancia = cvm.id_mercancia and cmi.id_impuesto = ci.id_impuesto and v.id_user = ".$id." and cvm.id_mercancia = m.sku and m.pais = ci.id_pais and ci.estatus = 'ACT' and Month(v.fecha) = '".$mes."' and m.pais = '".$pais."'");
		return $q->result();
	}
	
	function ValorRetenciones(){
		$q = $this->db->query("SELECT * FROM OficinaVirtual.cat_retencion order by duracion");
		$retenciones_regis = $q->result();
		$retenciones = array();
		foreach ($retenciones_regis as $retencion){
			$valor;
			if($retencion->duracion == 'ANO'){
				$valor = $retencion->porcentanje / 12;
			}elseif ($retencion->duracion == 'SEM'){
				$valor = $retencion->porcentaje / 6; 
			}elseif ($retencion->duracion == 'MES'){
				$valor = $retencion->porcentaje ; 
			}elseif ($retencion->duracion == 'DIA'){
				$valor = $retencion->porcentaje * 30;
			}
			$retencion_cobrar = array('id' => $retencion->id_retencion,
									'descripcion' => $retencion->descripcion,
									'valor'   => $valor);
			$retenciones[] = $retencion_cobrar;
		}
		return $retenciones;
	}
	
	
}