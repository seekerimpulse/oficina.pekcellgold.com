<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class modelo_compras extends CI_Model
{
	function get_red($id)
	{
		$q=$this->db->query("SELECT id_red FROM red WHERE estatus like 'ACT' and id_usuario=".$id);
		return $q->result();
	}
	function reporte_afiliados($red)
	{
		$q=$this->db->query('SELECT a.id, a.username usuario, a.created creacion, b.nombre nombre, b.apellido apellido, b.fecha_nacimiento nacimiento, 
		c.descripcion sexo, d.descripcion edo_civil FROM users a, user_profiles b, cat_sexo c, cat_edo_civil d , afiliar e WHERE a.created>=NOW() - INTERVAL 1 WEEK 
		and a.id=b.user_id and b.id_sexo=c.id_sexo and b.id_edo_civil=d.id_edo_civil and b.id_tipo_usuario=2 and e.id_afiliado=a.id and e.id_red='.$red);
		return $q->result();
	}
	function get_productos()
	{
		$q=$this->db->query('Select a.nombre, a.descripcion, b.id, b.costo, b.costo_publico, b.fecha_alta, d.descripcion grupo, d.id_grupo, a.nombre img from producto a, 
		mercancia b, cat_grupo_producto d where a.id=b.sku and d.id_grupo=a.id_grupo and b.id_tipo_mercancia=1 
		and b.estatus like "ACT" order by d.descripcion');
		return $q->result();
	}
	function get_productos_red($idRed)
	{
		$q=$this->db->query('Select a.nombre, a.descripcion, b.id, b.costo, b.costo_publico, b.fecha_alta, d.descripcion grupo, d.id_grupo, a.nombre img,d.id_red from producto a,
		mercancia b, cat_grupo_producto d where a.id=b.sku and d.id_grupo=a.id_grupo and b.id_tipo_mercancia=1
		and b.estatus like "ACT" and d.id_red='.$idRed.' order by d.descripcion');
		return $q->result();
	}
	function get_grupo_prod()
	{
		$q=$this->db->query("SELECT id_grupo, descripcion from cat_grupo_producto");
		return $q->result();
	}
	function get_grupo_productos($id)
	{
		$q=$this->db->query('Select a.nombre, a.descripcion, b.id, b.costo, b.costo_publico, b.fecha_alta, d.descripcion grupo, d.id_grupo from producto a, 
		mercancia b, cat_grupo_producto d where a.id=b.sku and d.id_grupo=a.id_grupo and b.id_tipo_mercancia=1 
		and b.estatus like "ACT" and d.id_grupo='.$id.' order by d.descripcion');
		return $q->result();
	}
	function get_promocion_prod()
	{
		$q=$this->db->query('Select a.nombre producto, f.nombre, f.descripcion, b.id id_merc, f.id_promocion, f.costo prom_costo,b.costo, b.costo_publico, b.fecha_alta, 
		a.nombre img from producto a, mercancia b, promocion f where a.id=b.sku and b.id_tipo_mercancia=1 
		and f.id_mercancia=b.id and f.inicio<NOW() and f.fin>NOW() and b.estatus like "ACT" and f.estatus like "ACT"');
		return $q->result();
	}
	function get_promocion_serv()
	{
		$q=$this->db->query('Select a.nombre servicio,f.nombre, f.descripcion, b.id id_merc, f.id_promocion, f.costo prom_costo,b.costo, b.costo_publico, b.fecha_alta, 
		a.nombre img from servicio a, mercancia b, promocion f where a.id=b.sku and b.id_tipo_mercancia=2 
		and f.id_mercancia=b.id and f.inicio<NOW() and f.fin>NOW() and b.estatus like "ACT" and f.estatus like "ACT"');
		return $q->result();
	}
	function get_promocion_comb()
	{
		$q=$this->db->query('SELECT d.id, a.nombre combinado, a.descuento, d.costo, d.fecha_alta, h.nombre, 
		h.descripcion, h.id_promocion, h.costo prom_costo, a.nombre img from combinado a, mercancia d, cross_combinado e, 
		promocion h where a.id=e.id_combinado and d.sku=a.id and d.estatus="ACT" and a.estatus="ACT" 
		and h.estatus="ACT" and d.id_tipo_mercancia=3 and h.id_mercancia=d.id and h.inicio<NOW() and h.fin>NOW()');
		return $q->result();
	}
	function get_producto_espec($busqueda)
	{
		$q=$this->db->query('SELECT d.id, a.nombre, a.descripcion, b.tipo_producto, c.username, d.costo, e.comision, d.fecha_alta, f.ruta from producto a, users c, 
		cat_tipo_producto b, mercancia d, cat_proveedor e, archivo f where a.id=d.sku and d.id_tipo_mercancia=1 and d.id_proveedor=e.id and a.concepto=b.id 
		and d.estatus like "ACT" and e.id_usuario=c.id and a.img=f.id_archivo and (a.nombre like "'.$busqueda.'%" or a.nombre like "%'.$busqueda.'" 
		or a.nombre like "%'.$busqueda.'%")');
		return $q->result();
	}
	function get_servicios()
	{
		$q=$this->db->query('Select a.nombre, a.descripcion, b.id, b.costo, b.costo_publico, b.fecha_alta, a.nombre img from servicio a, mercancia b 
		where a.id=b.sku and b.id_tipo_mercancia=2 and b.estatus like "ACT"');
		return $q->result();
	}
	
	function get_servicios_red($idRed)
	{
		$q=$this->db->query('Select a.nombre, a.descripcion, b.id, b.costo, b.costo_publico, b.fecha_alta, a.nombre img,a.id_red from servicio a, mercancia b
		where a.id=b.sku and b.id_tipo_mercancia=2 and b.estatus like "ACT" and a.id_red='.$idRed.'');
		return $q->result();
	}
	function get_servicio_espec($busqueda)
	{
		$q=$this->db->query('SELECT d.id, a.nombre, a.descripcion, b.tipo_servicio, c.username, d.costo, e.comision, d.fecha_alta, f.ruta from servicio a, users c, 
		cat_tipo_servicio b, mercancia d, cat_proveedor e, archivo f where a.id=d.sku and d.id_tipo_mercancia=2 and d.id_proveedor=e.id and a.concepto=b.id 
		and d.estatus like "ACT" and e.id_usuario=c.id and a.img=f.id_archivo and (a.nombre like "'.$busqueda.'%" or a.nombre like "%'.$busqueda.'" 
		or a.nombre like "%'.$busqueda.'%")');
		return $q->result();
	}	
	function get_combinados()
	{
		$q=$this->db->query('SELECT d.id, a.nombre, a.descripcion, a.descuento, a.id id_combinado, d.costo, d.fecha_alta, a.nombre img from combinado a, mercancia d, cross_combinado 
		e where a.id=e.id_combinado and d.sku=a.id and d.estatus="ACT" and d.id_tipo_mercancia=3');
		return $q->result();
	}
	function get_combinados_red($idRed)
	{
		$q=$this->db->query('SELECT d.id, a.nombre, a.descripcion, a.descuento, a.id id_combinado, d.costo, d.fecha_alta, a.nombre img, e.id_red from combinado a, mercancia d, cross_combinado
		e where a.id=e.id_combinado and d.sku=a.id and d.estatus="ACT" and d.id_tipo_mercancia=3 and e.id_red='.$idRed.'');
		return $q->result();
	}
	function get_combinado_espec($busqueda)
	{
		$q=$this->db->query('SELECT e.id, a.nombre, b.descripcion d_prod, b.nombre n_prod, c.descripcion d_serv, c.nombre n_serv, d.username, e.costo, e.fecha_alta, 
		f.comision, g.ruta from combinado a, producto b, servicio c, users d, mercancia e, cat_proveedor f, archivo g where a.id=e.sku and e.id_tipo_mercancia=3 and 
		e.id_proveedor=f.id and f.id_usuario=d.id and a.id_servicio=c.id and a.id_producto=b.id and e.estatus like "ACT" and a.img=g.id_archivo and 
		(a.nombre like "'.$busqueda.'%" or a.nombre like "%'.$busqueda.'" or a.nombre like "%'.$busqueda.'%")');
		return $q->result();
	}
	function detalles_productos($i)
	{
		$q=$this->db->query('SELECT a.nombre, a.descripcion, a.peso, a.alto, a.ancho, a.profundidad, a.diametro, b.costo 
		FROM producto a, mercancia b WHERE a.id=b.sku and b.id='.$i);
		return $q->result();
	}
	
	function detalles_productos_red($i)
	{
		$q=$this->db->query('SELECT a.nombre,a.descripcion,b.costo_publico,b.costo,b.puntos_comisionables
		FROM producto a, mercancia b WHERE a.id=b.sku and b.id='.$i);
		return $q->result();
	}
	
	function detalles_servicios($i)
	{
		$q=$this->db->query('SELECT a.nombre, a.descripcion, a.fecha_inicio, a.fecha_fin, b.costo from servicio a, mercancia b where a.id=b.sku and b.id='.$i);
		return $q->result();
	}
	
	function detalles_servicios_red($i)
	{
		$q=$this->db->query('SELECT a.nombre,a.descripcion,b.costo_publico,b.costo,b.puntos_comisionables from servicio a, mercancia b where a.id=b.sku and b.id='.$i);
		return $q->result();
	}
	
	function comb_espec($i)
	{
		$q_sku=$this->db->query('SELECT sku FROM mercancia where id='.$i);
		$sku_res=$q_sku->result();
		$sku=$sku_res[0]->sku;
		$q=$this->db->query('SELECT * from combinado where id='.$sku);
		return $q->result();
	}
	function detalles_combinados($i)
	{
		$q_sku=$this->db->query('SELECT sku FROM mercancia where id='.$i);
		$sku_res=$q_sku->result();
		$sku=$sku_res[0]->sku;
		$q1=$this->db->query('SELECT * FROM cross_combinado where id_combinado='.$sku);
		$combinados=$q1->result();
		$combinado=array();
		$arr_el=array("merc"=> "","qty"=>"");
		$j=0;
		foreach($combinados as $comb)
		{
			if($comb->id_producto!=0)
			{
				$qp=$this->db->query('SELECT nombre FROM producto where id='.$comb->id_producto);
				$prod=$qp->result();
				$arr_el["merc"]=$prod[0]->nombre;
				$arr_el["qty"]=$comb->cantidad_producto;
				$combinado[$j]=$arr_el;
				$j++;
			}
			if($comb->id_servicio!=0)
			{
				$qp=$this->db->query('SELECT nombre FROM servicio where id='.$comb->id_servicio);
				$serv=$qp->result();
				$arr_el["merc"]=$serv[0]->nombre;
				$arr_el["qty"]=$comb->cantidad_servicio;
				$combinado[$j]=$arr_el;
				$j++;
			}
		}
		return $combinado;
	}

	function costo_merc($id)
	{
		$q=$this->db->query('Select costo from mercancia where id='.$id);
		return $q->result();	
	}
	function detalles_prom_prod($i)
	{
		$q=$this->db->query('Select a.nombre producto, a.peso, a.alto, a.ancho, a.profundidad, a.diametro, f.nombre, f.descripcion, f.costo prom_costo, 
		b.costo, b.id, f.id_promocion from producto a, mercancia b, promocion f where a.id=b.sku and f.id_mercancia=b.id and f.id_promocion='.$i);
		return $q->result();
	}
	function detalles_prom_serv($i)
	{
		$q=$this->db->query('Select a.nombre servicio, a.fecha_inicio, a.fecha_fin, f.nombre, f.descripcion, f.costo prom_costo,b.costo, b.id, f.id_promocion
		from servicio a, mercancia b, promocion f where a.id=b.sku and f.id_mercancia=b.id and f.id_promocion='.$i);
		return $q->result();
	}
	function detalles_prom_comb($i)
	{
		$q=$this->db->query('Select a.nombre combinado, b.nombre servicio, c.nombre producto, d.nombre, d.descripcion, f.id, d.id_promocion, f.costo, d.costo prom_costo 
		from combinado a, servicio b, producto c, promocion d, cross_combinado e, mercancia f where a.id=e.id_combinado and b.id=e.id_servicio and c.id=e.id_producto 
		and f.sku=a.id and d.id_mercancia=f.id and d.id_promocion='.$i);
		return $q->result();
		
	}
	function prom_espec($i)
	{
		$q=$this->db->query('SELECT a.*, b.nombre promo, b.descripcion promo_des from combinado a, promocion b, mercancia c 
		where a.id=b.sku and c.id_mercancia=b.id and c.id_promocion='.$i);
		return $q->result();
	}
	function get_distribuidores($i)
	{
		$q=$this->db->query('SELECT a.id, a.costo, a.comision, a.impuesto, b.username from cat_distribuidor a, users b, mercancia c, cross_merc_dist e where e.id_mercancia=c.id 
		and e.id_distribuidor=a.id and b.id=a.id_usuario and c.id='.$i);
		return $q->result();
	}
	function get_imagenes($i)
	{
		$q=$this->db->query('Select a.url from cat_img a, mercancia b, cross_merc_img c where a.id_img=c.id_cat_imagen and b.id=c.id_mercancia and b.id='.$i);
		return $q->result();
	}
	function get_img($i)
	{
		$q=$this->db->query('Select a.url from cat_img a, mercancia b, cross_merc_img c where a.id_img=c.id_cat_imagen and b.id=c.id_mercancia and b.id='.$i.' limit 1');
		return $q->result();
	}
	function get_img_prom($i)
	{
		$q=$this->db->query('SELECT a.url FROM cat_img a, promocion b, cross_img_promo c WHERE c.id_promo=b.id_promocion and a.id_img=c.id_img 
		and b.id_promocion='.$i.' limit 1');
		return $q->result();
	}
	function get_limite_prod($i)
	{
		$q=$this->db->query("select a.min_venta, a.max_venta from producto a, mercancia b where a.id=b.sku and b.id=".$i);
		return $q->result();
	}
	function get_costo($i)
	{
		$q=$this->db->query('SELECT costo from cat_distribuidor where id='.$i);
		return $q->result();
	}
	function get_comision($i)
	{
		$q=$this->db->query('SELECT a.id_usuario from compras_reportes where id='.$i);
	}



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
	function get_afiliados($id)
	{
		/*$q=$this->db->query("select *,(select nombre from user_profiles where user_id=id_afiliado) afiliado,
		(select apellido from user_profiles where user_id=id_afiliado) afiliado_p from afiliar where id_afiliador=".$id);
		return $q->result();*/
		$q=$this->db->query("select *,(select nombre from user_profiles where user_id=id_afiliado) afiliado,
			(select apellido from user_profiles where user_id=id_afiliado) afiliado_p
			,(select nombre from user_profiles where user_id=debajo_de) debajo_de_n,
			(select apellido from user_profiles where user_id=debajo_de) debajo_de_p 
			from afiliar where id_red=".$id);
		return $q->result();
	}
	function get_compras_usr($start,$end,$usr)
	{
		$q=$this->db->query("select a.id_venta, a.costo, a.fecha, b.descripcion, c.username from venta a, cat_estatus b, users c where a.id_user=".$usr." and a.id_user=c.id 
		and a.id_estatus=b.id_estatus and a.fecha>'".$start."' and a.fecha<'".$end."' order by a.fecha ASC");
		return $q->result();
	}
	function get_compras($start,$end,$id_red)
	{
		$q=$this->db->query("select a.id_venta, a.costo, a.fecha, b.descripcion, c.username from venta a, cat_estatus b, users c , afiliar d where a.id_user=c.id 
		and a.id_estatus=b.id_estatus and a.fecha>'".$start."' and a.fecha<'".$end."' and c.id=d.id_afiliado and d.id_red=".$id_red." order by a.fecha ASC ");
		return $q->result();
	}
    function estadistica_sex($i)
    {
        $q=$this->db->query("SELECT id_sexo, COUNT( id_sexo ) 
        FROM user_profiles
        GROUP BY id_sexo");
	}
   	function get_puntos_comisionables($id)
   	{
   		$q=$this->db->query("select puntos_comisionables from mercancia where id=".$id);
		return $q->result();
   	}
	function insert_comision($venta,$puntos)
	{
		$q=$this->db->query("insert into comision values (".$venta.",".$puntos.")");
	}
	function get_cantidad_almacen($id)
	{
		$q=$this->db->query("SELECT a.cantidad FROM inventario a, almacen b WHERE a.id_almacen=b.id_almacen and b.web=1 and a.id_mercancia=".$id);
		return $q->result();
	}
	function update_inventario($id,$qty)
	{
		$inventario_q=$this->db->query("SELECT a.id_inventario, a.cantidad FROM inventario a, almacen b WHERE a.id_mercancia=".$id." and a.id_almacen=b.id_almacen and b.web=1");
		$inventario_res=$inventario_q->result();
		$id_inventario=$inventario_res[0]->id_inventario;
		$actual=($inventario_res[0]->cantidad)*1;
		$restantes=$actual-$qty;
		$this->db->query("update inventario set cantidad=".$restantes." where id_inventario=".$id_inventario);
	}
	function new_movimiento($id,$qty)
	{
		$inventario_q=$this->db->query("SELECT a.id_inventario, a.cantidad FROM inventario a, almacen b WHERE a.id_mercancia=".$id." and a.id_almacen=b.id_almacen and b.web=1");
		$inventario_res=$inventario_q->result();
		$id_inventario=$inventario_res[0]->id_inventario;
	}
	function get_impuestos_merca($id)
	{
		$q=$this->db->query("Select id_impuesto from cross_merc_impuesto where id_mercancia=".$id);
		$res_imp=$q->result();
		$impuestos=Array();
		$i=0;
		foreach($res_imp as $imp)
		{
			$q2=$this->db->query("Select porcentaje from cat_impuesto where id_impuesto=".$imp->id_impuesto);
			$res2=$q2->result();
			$impuestos[$i]=$res2[0]->porcentaje;
			$i++;
		}
		return $impuestos;
	}
	function salida_por_venta($id,$qty,$user,$venta)
	{
		$q=$this->db->query("SELECT costo from mercancia where id=".$id);
		$res_q=$q->result();
		$costo=$res_q[0]->costo;
		$importe=$costo;
		$total=$costo;
		$subtotal=$costo*$qty;
		$q=$this->db->query("Select id_impuesto from cross_merc_impuesto where id_mercancia=".$id);
		$res_imp=$q->result();
		foreach($res_imp as $imp)
		{
			$q2=$this->db->query("Select porcentaje from cat_impuesto where id_impuesto=".$imp->id_impuesto);
			$res2=$q2->result();
			$impuestos[$i]=$res2[0]->porcentaje;
			$i++;
		}
		foreach($impuestos as $desc)
		{
			$mas=($desc*$costo)/100;
			$total=$total+$mas;
		}
		$q_alm=$this->db->query("SELECT id_almacen from almacen where web=1");
		$alm_res=$q_alm->result();
		$origen=$alm_res[0]->id_almacen;
		$q_user=$this->db->query("SELECT username from users where id=".$user);
		$user_res=$q_user->result();
		$usuario=$user_res[0]->username;
		$clave="VENTA".$user.$usuario;
		$dato_mov=array(
			"id_tipo"		=> 2,
			"entrada"		=> 0,
			"keyword"		=> $clave,
			"origen"		=> $origen,
			"destino"		=> $usuario,
			"id_mercancia"	=> $id,
			"cantidad"		=> $qty,
			"id_impuesto"	=> 1,
			"subtotal"		=> $subtotal,
			"importe"		=> $importe,
			"total"			=> $total,
			"id_estatus"	=> 1
		);
		$this->db->insert("movimiento",$dato_mov);
		$insert_mov=mysql_insert_id();
		$dato_surtido=array(
			"id_almacen_origen"	=> $origen,
			"id_movimiento"		=> $insert_mov,
			"estatus"			=> 1,
			"id_venta"			=> $venta
		);
		$this->db->insert("surtido",$dato_surtido);
	}
	function get_pais()
	{
		/*7= español 3=inglés*/
		$q=$this->db->query("select Code, Name, Code2 from Country ");
		return $q->result();
	}
	function get_direccion_comprador($id)
	{
		$q=$this->db->query("SELECT a.*,b.nombre, b.apellido, b.keyword, c.email FROM cross_dir_user a, user_profiles b, users c 
		WHERE c.id=a.id_user and c.id=b.user_id and c.id=".$id);
		return $q->result();
	}
	function hacer_compra()
	{
		if(!isset($_GET["usr"]))
		{
			$id_user=$this->tank_auth->get_user_id();
		}
		else
		{
			$id_user=$_GET["usr"];
		}
		$dato_venta=array(
			"id_user" 			=> $id_user,
			"id_estatus"		=> 2,
			"costo" 			=> $this->cart->total(),
			"id_metodo_pago" 	=> $_POST["pago"]
		);
		$this->db->insert("venta",$dato_venta);
		$venta = mysql_insert_id();
		if($_GET["tipo"]==3)
		{
			$this->db->query("insert into autocompra (fecha,id_usuario) values ('".$_POST['startdate']."',".$id_user.")");
		}

		$dato_envio=array(
			"id_venta"	=> $venta,
			"nombre" 	=> $_POST["nombre_envio"],
			"apellido" 	=> $_POST["apellido_envio"],
			"cp" 		=> $_POST["cp_envio"],
			"id_pais" 	=> $_POST["pais_envio"],
			"estado" 	=> $_POST["estado_envio"],
			"municipio"	=> $_POST["municipio_envio"],
			"colonia" 	=> $_POST["colonia_envio"],
			"calle" 	=> $_POST["calle_envio"],
			"correo" 	=> $_POST["correo_envio"],
			"compania" 	=> $_POST["compania_envio"],
			"celular" 	=> $_POST["celular_envio"],
			"info_ad"	=> $_POST["info_envio"]
		);
		
		$this->db->insert("cross_venta_envio",$dato_envio);
		
		$dato_fact=array(
			"id_venta"	=> $venta,
			"nombre" 	=> $_POST["nombre_fac"],
			"apellido" 	=> $_POST["apellido_fac"],
			"rfc"		=> $_POST["rfc_fac"],
			"cp" 		=> $_POST["cp_fac"],
			"id_pais" 	=> $_POST["pais_fac"],
			"estado" 	=> $_POST["estado_fac"],
			"municipio"	=> $_POST["municipio_fac"],
			"colonia" 	=> $_POST["colonia_fac"],
			"calle" 	=> $_POST["calle_fac"],
			"correo" 	=> $_POST["correo_fac"],
			"compania" 	=> $_POST["compania_fac"],
			"celular" 	=> $_POST["celular_fac"]
		);
		$this->db->insert("cross_venta_factura",$dato_fact);
		$puntos=0;
		foreach($this->cart->contents() as $items)
		{
			$dato_cross_venta=array(
				"id_mercancia" 	=> $items['id'],
				"id_venta"		=> $venta,
				"cantidad"		=> $items['qty'],
				"id_promocion"	=> $items['options']['prom_id']
			);
			$this->db->insert("cross_venta_mercancia",$dato_cross_venta);
			$puntos_q=$this->db->query("select puntos_comisionables from mercancia where id=".$items['id']);
			$puntos_res=$puntos_q->result();
			$puntos=$puntos+($puntos_res[0]->puntos_comisionables*$items['qty']);
			$inventario_q=$this->db->query("SELECT a.id_inventario, a.cantidad FROM inventario a, almacen b 
			WHERE a.id_mercancia=".$items['id']." and a.id_almacen=b.id_almacen and b.web=1");
			$inventario_res=$inventario_q->result();
			$id_inventario=$inventario_res[0]->id_inventario;
			$actual=($inventario_res[0]->cantidad)*1;
			$restantes=$actual-$items['qty'];
			$this->db->query("update inventario set cantidad=".$restantes." where id_inventario=".$id_inventario);
			$q=$this->db->query("SELECT costo from mercancia where id=".$items['id']);
			$res_q=$q->result();
			$costo=$res_q[0]->costo;
			$importe=$costo;
			$total=$costo;
			$subtotal=$costo*$items['qty'];
			$q=$this->db->query("Select id_impuesto from cross_merc_impuesto where id_mercancia=".$items['id']);
			$res_imp=$q->result();
			$i=0;
			foreach($res_imp as $imp)
			{
				$q2=$this->db->query("Select porcentaje from cat_impuesto where id_impuesto=".$imp->id_impuesto);
				$res2=$q2->result();
				$impuestos[$i]=$res2[0]->porcentaje;
				$i++;
			}
			foreach($impuestos as $desc)
			{
				$mas=($desc*$costo)/100;
				$total=$total+$mas;
			}
			$q_alm=$this->db->query("SELECT id_almacen from almacen where web=1");
			$alm_res=$q_alm->result();
			$origen=$alm_res[0]->id_almacen;
			$q_user=$this->db->query("SELECT username from users where id=".$id_user);
			$user_res=$q_user->result();
			$usuario=$user_res[0]->username;
			$clave="VENTA".$id_user.$usuario;
			$dato_mov=array(
				"id_tipo"		=> 2,
				"entrada"		=> 0,
				"keyword"		=> $clave,
				"origen"		=> $origen,
				"destino"		=> $usuario,
				"id_mercancia"	=> $items['id'],
				"cantidad"		=> $items['qty'],
				"id_impuesto"	=> 1,
				"subtotal"		=> $subtotal,
				"importe"		=> $importe,
				"total"			=> $total,
				"id_estatus"	=> 1
			);
		
			$this->db->insert("movimiento",$dato_mov);
			$insert_mov=mysql_insert_id();
			$dato_surtido=array(
				"id_almacen_origen"	=> $origen,
				"id_movimiento"		=> $insert_mov,
				"estatus"			=> 1,
				"id_venta"			=> $venta
			);
			$this->db->insert("surtido",$dato_surtido);
		}
		$dato_comision=array(
			"id_venta"	=> $venta,
			"puntos"	=> $puntos
		);
		$this->db->insert("comision",$dato_comision);
		switch($_POST["pago"])
		{
			case "5":
				break;
			case "1":
				$fecha=$_POST['ano_taj_c']."-".$_POST['mes_taj_c']."-10";
				$fecha=date("Y-m-t", strtotime($fecha));
				if(isset($_POST["salvar_taj_c"]))
				{
					$status="ACT";
				}
				else 
				{
					$status="DES";
				}
				
				$dato_taj=array(
					"tipo_tarjeta"		=> $_POST["pago"],
					"id_usuario"		=> $id_user,
					"id_banco"			=> $_POST["banco_taj_c"],
					"cuenta"			=> $_POST["numero_taj_c"],
					"fecha_vencimiento"	=> $fecha,
					"titular"			=> $_POST["titular_taj_c"],
					"codigo_seguridad"	=> $_POST["code_taj_c"],
					"estatus"			=> $status
				);
				$this->db->insert("tarjeta",$dato_taj);
				break;
			case "2":
				$fecha=$_POST['ano_taj']."-".$_POST['mes_taj']."-10";
				$fecha=date("Y-m-t", strtotime($fecha));
				if(isset($_POST["salvar_taj"]))
				{
					$status="ACT";
				}
				else 
				{
					$status="DES";
				}
				
				$dato_taj=array(
					"tipo_tarjeta"		=> $_POST["pago"],
					"id_usuario"		=> $id_user,
					"id_banco"			=> $_POST["banco_taj"],
					"cuenta"			=> $_POST["numero_taj"],
					"fecha_vencimiento"	=> $fecha,
					"titular"			=> $_POST["titular_taj"],
					"codigo_seguridad"	=> $_POST["code_taj"],
					"estatus"			=> $status
				);
				$this->db->insert("tarjeta",$dato_taj);
				break;
			case "3":
				break;
		}
		$this->cart->destroy();
		
	}
}