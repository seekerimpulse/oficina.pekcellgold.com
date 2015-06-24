<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_afiliado extends CI_Model{

	function __construct() {
		parent::__construct();
	}
	
	function EstiloUsuaio($id){
		$dato_style=array(
				"id_usuario"		=> $id,
				"bg_color"			=> "#EEEEEE",
				"btn_1_color"		=> "#93C83F",
				"btn_2_color"		=> "#3DB2E5"
		);
		$this->db->insert("estilo_usuario",$dato_style);
	}
	
	function CrearPerfil($id){
		if(!isset($_POST['tipo_afiliado']))
		{
			$_POST['tipo_afiliado'] = 2;
		}
		
		if(!isset($_POST['tipo_plan']))
			$_POST['tipo_plan'] = 0;
		
		$dato_profile=array(
				"id"                 => '',
				"user_id"            => $id,
				"id_sexo"            => $_POST['sexo'],
				"id_edo_civil"       => $_POST['civil'],
				"id_tipo_usuario"    => $_POST['tipo_afiliado'],
				"id_estudio"         => $_POST['estudios'],
				"id_ocupacion"       => $_POST['ocupacion'],
				"id_tiempo_dedicado" => $_POST['tiempo_dedicado'],
				'id_estatus'         => '1',
				"id_fiscal"       	 => $_POST['fiscal'],
				"keyword"            => $_POST['keyword'],
				"paquete"			 => $_POST['tipo_plan'],
				"nombre"             => $_POST['nombre'],
				"apellido"           => $_POST['apellido'],
				"fecha_nacimiento"   => $_POST['nacimiento'],
				"ultima_session"	 => '0000-00-00'
		);
		
		$this->db->insert("user_profiles",$dato_profile);
		var_dump($dato_profile);exit;
		$perfil=2;
		if($_POST['tipo_plan']==0){
			$perfil=3;
		}
		
		$dato_permiso=array(
				"id_user"   => $id,
				"id_perfil" => $perfil
		);
		$this->db->insert("cross_perfil_usuario",$dato_permiso);
		
	}
	
	function CrearCoaplicante($id){
		if(isset($_POST['nombre_co'])){
		
			$dato_coaplicante=array(
					"id_user"   => $id,
					"nombre" => $_POST['nombre_co'],
					"apellido"   => $_POST['apellido_co'],
					"keyword"   => $_POST['keyword_co']
			);
			$this->db->insert("coaplicante",$dato_coaplicante);
			
		}
	}
	function crearUsuario($id){
		
		$id = $this->obtenrIdUser($_POST['mail_important']);
		
		$this->EstiloUsuaio($id);
		$directo=0;
		if(!isset($_POST['afiliados']))
		{
			$_POST['afiliados']=$id;
			$directo=1;
		}
		
		$this->CrearPerfil($id);
		
		$this->crearUsuario($id);
		
		/*################### DATO RED #########################*/
		$dato_red=array(
				'id_red'        => $_GET['id'],
				"id_usuario"	=> $id,
				"profundidad"	=> "0",
				"estatus"		=> "ACT"
		);
		$this->db->insert("red",$dato_red);
		/*################### FIN DATO RED #########################*/
		
		/*################### DATO AFILIAR #########################*/
		$mi_red=$_GET['id'];
		
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
				"id_afiliado" => $id,
				"debajo_de"   => $_POST['afiliados'],
				"directo"     => $directo,
				"lado"        => $lado
		);
		$this->db->insert("afiliar",$dato_afiliar);
		
		$ids=array();
		$id_n = $id;
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
				    			"id_afiliado"	=> $id_n,
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
	}
	
	function obtenrIdUser($email){
		$id_afiliador= $this->db->query('select id from users where email like "'.$email.'"');
		
		$id_afiliador = $id_afiliador->result();
		return $id_afiliador[0]->id;
	}

}