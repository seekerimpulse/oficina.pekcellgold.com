<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_perfil_red extends CI_Model
{
	function datos_perfil($id)
	{
		$q=$this->db->query('
			SELECT profile.keyword keyword, (select email from users where id=profile.user_id) email, profile.id_edo_civil, profile.user_id, profile.nombre nombre, profile.apellido apellido,
			profile.fecha_nacimiento nacimiento, profile.id_estudio id_estudio,
			profile.id_ocupacion id_ocupacion,
			profile.id_tiempo_dedicado id_tiempo_dedicado,
			profile.id_fiscal id_fiscal,
			sexo.descripcion sexo,
			edo_civil.descripcion edo_civil,
			estilos.bg_color, estilos.btn_1_color, estilos.btn_2_color
			from user_profiles profile
			left join cat_sexo sexo
			on profile.id_sexo=sexo.id_sexo
			left join estilo_usuario estilos on
			profile.user_id=estilos.id_usuario
			left join cat_edo_civil edo_civil on
			profile.id_edo_civil=edo_civil.id_edo_civil
			where profile.user_id='.$id);
		return $q->result();
	}
	function tipo_fiscal()
	{
		$q=$this->db->query('select * from cat_usuario_fiscal');
		return $q->result();
	}
	function get_images($id)
	{
		$q=$this->db->query('select (select nombre_completo from cat_img b where a.id_img=b.id_img) img, (select url from cat_img b where a.id_img=b.id_img) url from cross_img_user a where id_user = '.$id);
		return $q->result();
	}
	function get_estudios()
	{
		$q=$this->db->query('select * from cat_estudios');
		return $q->result();
	}
	function get_ocupacion()
	{
		$q=$this->db->query('select * from cat_ocupacion');
		return $q->result();
	}
	function get_tiempo_dedicado()
	{
		$q=$this->db->query('select * from cat_tiempo_dedicado');
		return $q->result();
	}
	function get_id()
	{
		$q=$this->db->query('select id from users where email like "'.$_POST['mail_important'].'"');
		return $q->result();
	}
	function get_name($id)
	{
		$q=$this->db->query('select nombre, apellido from user_profiles where user_id='.$id);
		return $q->result();
	}
	function afiliar_nuevo($id)
	{

		$id_afiliador=$this->db->query('select id from users where email like "'.$_POST['mail_important'].'"');

		$id_afiliador=$id_afiliador->result();

			if($id_afiliador[0]->id)
			$id_nuevo=$id_afiliador[0]->id;
			else
			$id_nuevo=$id_afiliador->id;

		$existe_mail=$this->db->query('select id from user_profiles where id='.$id_nuevo);
		$existe_mail=$existe_mail->result();

		if(!$existe_mail)
		{
			$directo=0;
			if(!isset($_POST['afiliados']))
			{
				$_POST['afiliados']=$id;
				$directo=1;
			}
			$dato_style=array(
		                "id_usuario"		=> $id_nuevo,
		                "bg_color"			=> "#EEEEEE",
		                "btn_1_color"		=> "#93C83F",
		                "btn_2_color"		=> "#3DB2E5"
		            );
			$this->db->insert("estilo_usuario",$dato_style);

			if(!isset($_POST['tipo_afiliado']))
			{
				$_POST['tipo_afiliado']=2;
			}

			/*################ PERFIL DEL USUARIO #########################*/
			if(!isset($_POST['tipo_plan']))
				$_POST['tipo_plan']=0;

			($_POST['tipo_plan']==0) ? $estatus=3 : $estatus=1;

			$dato_profile=array(
						"user_id"            => $id_nuevo,
						"id_sexo"            => $_POST['sexo'],
						"id_edo_civil"       => $_POST['civil'],
						"id_tipo_usuario"    => $_POST['tipo_afiliado'],
						"nombre"             => $_POST['nombre'],
						"apellido"           => $_POST['apellido'],
						"fecha_nacimiento"   => $_POST['nacimiento'],
						"id_estudio"         => $_POST['estudios'],
						"id_ocupacion"       => $_POST['ocupacion'],
						"id_fiscal"       	 => $_POST['fiscal'],
						"id_tiempo_dedicado" => $_POST['tiempo_dedicado'],
						"paquete"			 => $_POST['tipo_plan'],
						"keyword"            => $_POST['keyword'],
						'id_estatus'         => $estatus

		            );
			$this->db->insert("user_profiles",$dato_profile);
			/*############# FIN PERFIL DEL USUARIO #########################*/

			/*################### DATO PERMISO #########################*/
			($_POST['tipo_plan']==0) ? $perfil=3 : $perfil=2;
			$dato_permiso=array(
						"id_user"   => $id_nuevo,
						"id_perfil" => $perfil
		            );
		    $this->db->insert("cross_perfil_usuario",$dato_permiso);
		    /*################### FIN DATO PERMISO #########################*/

		    /*################### DATO COPALICANTE #########################*/
			$dato_coaplicante=array(
						"id_user"   => $id_nuevo,
						"nombre" => $_POST['nombre_co'],
						"apellido"   => $_POST['apellido_co'],
						"keyword"   => $_POST['keyword_co']
		            );
		    $this->db->insert("coaplicante",$dato_coaplicante);
		    /*################### FIN DATO COPALICANTE #########################*/

			/*################### DATO RED #########################*/
			$dato_red=array(
		                "id_usuario"	=> $id_nuevo,
		                "profundidad"	=> "0",
		                "estatus"		=> "ACT"
		            );
		    $this->db->insert("red",$dato_red);
		    /*################### FIN DATO RED #########################*/

		     /*################### DATO AFILIAR #########################*/
		    $mi_red=$this->db->query('select id_red from red where id_usuario='.$id);
		    $mi_red=$mi_red->result();
		    $mi_red=$mi_red[0]->id_red;

		    if(isset($_POST['sponsor']))
		    {
		    	$directo=0;
		    }
		    if(!isset($_POST['lado']))
		    	$lado=0;
		    else
		    	$lado=$_POST['lado'];

			$dato_afiliar=array(
						"id_red"      => $mi_red,
						"id_afiliado" => $id_nuevo,
						"debajo_de"   => $_POST['afiliados'],
						"directo"     => $directo,
						"lado"        => $lado
		            );
			$this->db->insert("afiliar",$dato_afiliar);

			$ids=array();
			$id_=$id;
			for($i=0;$i<=99999990;$i++)
			{
				if($i>0)
					$id_=$ids[$i-1];
				$query=$this->db->query('select id_red from afiliar where id_afiliado='.$id_);
				$query=$query->result();
				if(isset($query[0]->id_red))
				{
					foreach ($query as $key)
					$ids[]=$key->id_red;
				}

				else
					$i=99999991;

			}
		    foreach ($ids as $key)
		    {
		    	$query2=$this->db->query('select * from afiliar where debajo_de='.$id.' and id_red='.$key.' and id_afiliado='.$id_nuevo);
		    	$query2=$query2->result();
		    	if($query2)
				{
				}
				else
				{
					$dato_afiliar=array(
						"id_red"		=> $key,
		                "id_afiliado"	=> $id_nuevo,
		                "debajo_de"		=> $id,
		                "directo"		=> 0,
		                "lado"        => $lado
		            );
					$this->db->insert("afiliar",$dato_afiliar);
				}
			}

		    /*################### FIN DATO AFILIAR #########################*/

		    /*################### DATO TELEFONOS #########################*/
			//tipo_tel 1=fijo 2=movil
			if($_POST["fijo"])
			{
				foreach ($_POST["fijo"] as $fijo)
				{
					$dato_tel=array(
		                "id_user"		=> $id_nuevo,
		                "id_tipo_tel"	=> 1,
		                "numero"		=> $fijo,
		                "estatus"		=> "ACT"
		            );
		            $this->db->insert("cross_tel_user",$dato_tel);
				}
			}
			if($_POST["movil"])
			{
				foreach ($_POST["movil"] as $movil)
				{
					$dato_tel=array(
			            "id_user"		=> $id_nuevo,
			            "id_tipo_tel"	=> 2,
			            "numero"		=> $movil,
			            "estatus"		=> "ACT"
			        );
			        $this->db->insert("cross_tel_user",$dato_tel);
				}
			}

			/*################### FIN DATO TELEFONOS #########################*/

			/*################### DATO DIRECCION #########################*/
			$dato_dir=array(
					"id_user"   => $id_nuevo,
					"cp"        => $_POST['cp'],
					"calle"     => $_POST['calle'],
					"colonia"   => $_POST['colonia'],
					"municipio" => $_POST['municipio'],
					"estado"    => $_POST['municipio'],
					"pais"      =>$_POST['pais']
	            );
	            $this->db->insert("cross_dir_user",$dato_dir);
	        /*################### FIN DATO DIRECCION #########################*/

	        /*################### DATO BILLETERA #########################*/
	            $dato_billetera=array(
		                "id_user"	=> $id_nuevo,
		                "estatus"		=> "DES",
		                "activo"		=> "No"
		            );
		    $this->db->insert("billetera",$dato_billetera);
		    /*################### FIN DATO BILLETERA #########################*/

		    /*################### FIN DATO COBRO #########################*/
		    $dato_cobro=array(
		                "id_user"		=> $id_nuevo,
		                "id_metodo"		=> 1,
		                "id_estatus"	=> 1,
		                "monto"			=> 0
		            );
		    $this->db->insert("cobro",$dato_cobro);

		    $dato_cobro=array(
		                "id_user"		=> $id_nuevo,
		                "id_metodo"		=> 1,
		                "id_estatus"	=> 4,
		                "monto"			=> 0
		            );
		    $this->db->insert("cobro",$dato_cobro);

		     /*################### FIN DATO COBRO #########################*/

		     /*################### DATO RANGO #########################*/
	            $dato_rango=array(
		                "id_user"	=> $id_nuevo,
		                "id_rango"		=> 1,
		                "entregado"		=> 1,
		                "estatus"		=> "ACT"
		            );
		    $this->db->insert("cross_rango_user",$dato_rango);
		    /*################### FIN DATO RANGO #########################*/

		    return true;
		}//FIN EXISTE MAIL
		else
		{
			return false;
		}

	}
	
	function actualiza_directo($id_,$id)
	{
		$q=$this->db->query("select id_red from red where id_usuario=".$id_);
		$q=$q->result();
		$mi_red=$q[0]->id_red;

		$q=$this->db->query("update afiliar set directo=1 where id_red=".$mi_red." and debajo_de=".$id);
	}
	function get_red($id)
	{
		$q=$this->db->query("select * from red where id_usuario=".$id);
		return $q->result();
	}
	function get_pais()
	{
		/*7= español 3=inglés*/
		$q=$this->db->query("select Code, Name, Code2 from Country ");
		return $q->result();
	}
	function get_afiliados_($id)
	{
		$q=$this->db->query("select *,(select nombre from user_profiles where user_id=id_afiliado) afiliado,
			(select apellido from user_profiles where user_id=id_afiliado) afiliado_p,
			(select nombre from user_profiles where user_id=debajo_de) debajo_de_n,
			(select apellido from user_profiles where user_id=debajo_de) debajo_de_p,
			(select (select url from cat_img b where a.id_img=b.id_img) url from cross_img_user a where id_user = id_afiliado) img
			from afiliar where id_red=".$id." order by lado");
		return $q->result();
	}
	function get_afiliados($id)
	{
		$debajo_de=$this->db->query("select id_usuario from red where id_red=".$id);
		$debajo_de=$debajo_de->result();
		$q=$this->db->query("select *,(select nombre from user_profiles where user_id=id_afiliado) afiliado,
			(select apellido from user_profiles where user_id=id_afiliado) afiliado_p,
			(select nombre from user_profiles where user_id=debajo_de) debajo_de_n,
			(select apellido from user_profiles where user_id=debajo_de) debajo_de_p,
			(select (select url from cat_img b where a.id_img=b.id_img) url from cross_img_user a where id_user = id_afiliado) img
			from afiliar where id_red=".$id." and debajo_de=".$debajo_de[0]->id_usuario." order by lado");
		return $q->result();
	}
	function use_mail()
	{
		$q=$this->db->query("select * from users where email like '".$_POST['mail']."'");
		return $q->result();
	}
	function use_username()
	{
		$q=$this->db->query("select * from users where username like '".$_POST['username']."'");
		return $q->result();
	}
	function use_keyword()
	{
		$q=$this->db->query("select * from user_profiles where keyword like '".$_POST['keyword']."'");
		return $q->result();
	}
	function telefonos($id)
	{
		$q=$this->db->query("select (select descripcion from cat_tipo_tel A where A.id_tipo_tel=B.id_tipo_tel) tipo, numero from cross_tel_user B where id_user=".$id);
		return $q->result();
	}
	function edad($id)
	{
		$q=$this->db->query("select (YEAR(CURDATE())-YEAR(fecha_nacimiento)) - (RIGHT(CURDATE(),5)<RIGHT(fecha_nacimiento,5)) edad from user_profiles where user_id=".$id);
		return $q->result();
	}
	function sexo()
	{
		$q=$this->db->query("select * from cat_sexo");
		return $q->result();
	}
	function edo_civil()
	{
		$q=$this->db->query("select * from cat_edo_civil");
		return $q->result();
	}
	function actualizar($id)
	{
		$this->db->query("delete from cross_tel_user where id_user=".$id);
		$this->db->query("delete from cross_dir_user where id_user=".$id);
		//tipo_tel 1=fijo 2=movil
		if($_POST["fijo"])
		{
			foreach ($_POST["fijo"] as $fijo)
			{
				$dato_tel=array(
					"id_user"     =>$id,
					"id_tipo_tel" =>1,
					"numero"      =>$fijo,
					"estatus"     =>"ACT"
	            );
	            $this->db->insert("cross_tel_user",$dato_tel);
			}
		}
		if($_POST["movil"])
		{
			foreach ($_POST["movil"] as $movil)
			{
				$dato_tel=array(
					"id_user"     =>$id,
					"id_tipo_tel" =>2,
					"numero"      =>$movil,
					"estatus"     =>"ACT"
		        );
		        $this->db->insert("cross_tel_user",$dato_tel);
			}
		}
		$dato_dir=array(
				"id_user"   =>$id,
				"cp"        =>$_POST['cp'],
				"calle"     =>$_POST['calle'],
				"colonia"   =>$_POST['colonia'],
				"municipio" =>$_POST['municipio'],
				"estado"    =>$_POST['estado'],
				"pais"      =>$_POST['pais']
            );
            $this->db->insert("cross_dir_user",$dato_dir);

        $this->db->query('update users set email="'.$_POST['email'].'" where id='.$id);
		$this->db->query("update user_profiles set id_sexo=".$_POST['sexo'].", id_fiscal='".$_POST['tipo_fiscal']."', keyword='".$_POST['rfc']."' ,id_edo_civil='".$_POST['civil']."', id_estudio=".$_POST['estudios'].", id_ocupacion=".$_POST['ocupacion']." , id_tiempo_dedicado=".$_POST['tiempo_dedicado']." ,nombre='".$_POST['nombre']."',apellido='".$_POST['apellido']."',fecha_nacimiento='".$_POST['nacimiento']."' where user_id=".$id);
		$this->db->query("update estilo_usuario set bg_color='".$_POST['bg_color']."', btn_1_color='".$_POST['color_1']."', btn_2_color='".$_POST['color_2']."' where id_usuario=".$id);
	}
	function cp()
	{
		$q=$this->db->query("select colonia, municipio, id_estado from sepomex where cp like '%".$_POST['cp']."%'");
		return $q->result();
	}
	function estado($id)
	{
		$q=$this->db->query("select descripcion from cat_estado where id_estado =".$id);
		return $q->result();
	}
	function dir($id)
	{
		$q=$this->db->query("select * from cross_dir_user where id_user=".$id);
		return $q->result();
	}
	function img_user($id,$data)
	{
		$explode=explode(".",$data["file_name"]);
		$nombre=$explode[0];
		$extencion=$explode[1];
		$dato_img=array(
                "url"				=>	"/media/".$id."/".$data["file_name"],
                "nombre_completo"	=>	$data["file_name"],
                "nombre"			=>	$nombre,
                "extencion"			=>	$extencion,
                "estatus"			=>	"ACT"
            );
		$this->db->insert("cat_img",$dato_img);
		$id_foto=mysql_insert_id();

		$dato_cross_img=array(
                "id_user"		=>	$id,
                "id_img"	=>	$id_foto
            );
		$this->db->insert("cross_img_user",$dato_cross_img);

	}

  	function img_user_tomar($id)
	{

		$dato_img=array(
                "url"				=>	"/media/".$id."/user.png",
                "nombre_completo"	=> "user.png",
                "nombre"			=>	"user",
                "extencion"			=>	"png",
                "estatus"			=>	"ACT"
            );
		$this->db->insert("cat_img",$dato_img);
		$id_foto=mysql_insert_id();

		$dato_cross_img=array(
                "id_user"		=>	$id,
                "id_img"	=>	$id_foto
            );
		$this->db->insert("cross_img_user",$dato_cross_img);

	}
	function del($id,$tipo)
	{
		if($tipo==0)
		{
			$q=$this->db->query("select id_img from cat_img where nombre='user'");
			$q=$q->result();
			foreach ($q as $id_img)
			{
				$this->db->query("delete from cross_img_user where id_img=".$id_img->id_img." and id_user=".$id);
			}
		}
		if($tipo==1)
		{
			$q=$this->db->query("select id_img from cat_img where nombre='fondo'");
			$q=$q->result();
			foreach ($q as $id_img)
			{
				$this->db->query("delete from cross_img_user where id_img=".$$id_img->id_img." and id_user=".$id);
			}
		}
	}
	function get_coaplicante($id)
	{
		$q=$this->db->query("select * from coaplicante where id_usuario=".$id);
		return $q->result();
	}

}
