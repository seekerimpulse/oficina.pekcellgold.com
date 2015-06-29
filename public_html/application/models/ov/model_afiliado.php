<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_afiliado extends CI_Model{

	function __construct() {
		parent::__construct();

		$this->load->library('tank_auth');
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
			$_POST['tipo_plan'] = 1;
		
		if(!isset($_POST['fiscal'])){
			$_POST['fiscal']=1;
		}
		$dato_profile = array(
			"user_id"            => $id,
			"id_sexo"            => $_POST['sexo'],
			"id_edo_civil"       => $_POST['civil'],
			"id_tipo_usuario"    => $_POST['tipo_afiliado'],
			"id_estudio"         => $_POST['estudios'],
			"id_ocupacion"       => $_POST['ocupacion'],
			"id_tiempo_dedicado" => $_POST['tiempo_dedicado'],
			'id_estatus'         => 1,
			"id_fiscal"       	 => $_POST['fiscal'],
			"keyword"            => $_POST['keyword'],
			"paquete"			 => $_POST['tipo_plan'],
			"nombre"             => $_POST['nombre'],
			"apellido"           => $_POST['apellido'],
			"fecha_nacimiento"   => $_POST['nacimiento']
			);
		
		$this->db->insert("user_profiles",$dato_profile);
		
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
	
	function crearUsuario(){
		
		$id = $this->obtenrIdUser($_POST['mail_important']);
		
		$this->db->query('update users set activated="1" where id="'.$id.'"');
		$this->EstiloUsuaio($id);
		$directo=0;
		if(!isset($_POST['afiliados']))
		{
			$_POST['afiliados']=$id;
			$directo=1;
		}
		
		$this->CrearPerfil($id);
		
		$this->CrearCoaplicante($id);
		
		/*################### DATO RED #########################*/
	
		$redes = $this->db->get('tipo_red');
		$redes = $redes->result();
		foreach ($redes as $red){
			$dato_red=array(
					'id_red'        => $red->id,
					"id_usuario"	=> $id,
					"profundidad"	=> "0",
					"estatus"		=> "ACT",
					"premium"			=> '0'
			);
			$this->db->insert("red",$dato_red);
		}
		
		/*################### FIN DATO RED #########################*/
		
		/*################### DATO AFILIAR #########################*/
		
		$directo = 1;
		if(isset($_POST['sponsor']))
		{
			$directo = 0;
		}
		$id_debajo = '1';
		if(isset($_POST['afiliados']) && $_POST['afiliados'] != $id){
			$id_debajo = $_POST['afiliados'];
		}else{
			$id_debajo = $_POST['id'];
		}

		$mi_red=$_POST['red'];
		$lado = 1;
		if(!isset($_POST['lado']))
			$lado = $this->consultarFrontalDisponible($id_debajo, $mi_red);
		else{
			$lado = $_POST['lado'];
		}
		
		$dato_afiliar =array(
			"id_red"      => $mi_red,
			"id_afiliado" => $id,
			"debajo_de"   => $id_debajo,
			"directo"     => $directo,
			"lado"        => $lado
			);
		
		//var_dump($dato_afiliar); exit;
 		$this->db->insert("afiliar",$dato_afiliar);
 		
 		
		/*################### DATO TELEFONOS #########################*/
		//tipo_tel 1=fijo 2=movil
		if($_POST["fijo"])
		{
			foreach ($_POST["fijo"] as $fijo)
			{
				$dato_tel=array(
					"id_user"		=> $id,
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
					"id_user"		=> $id,
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
			"id_user"   => $id,
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
			"id_user"	=> $id,
			"estatus"		=> "DES",
			"activo"		=> "No"
			);
		$this->db->insert("billetera",$dato_billetera);
		/*################### FIN DATO BILLETERA #########################*/
		
		/*################### FIN DATO COBRO #########################*/


		$query = $this->db->query("select * from paquete_inscripcion where id_paquete=".$_POST['tipo_plan']);
		$plan = $query->result();

		$dato_cobro=array(
			"id_user"		=> $id,
			"id_metodo"		=> 1,
			"id_estatus"	=> 1,
			"monto"			=> $plan[0]->precio
			);
		$this->db->insert("cobro",$dato_cobro);
		
		$dato_cobro=array(
			"id_user"		=> $id,
			"id_metodo"		=> 1,
			"id_estatus"	=> 4,
			"monto"			=> 0
			);
		$this->db->insert("cobro",$dato_cobro);
		
		/*################### FIN DATO COBRO #########################*/
		
		/*################### DATO RANGO #########################*/
		$dato_rango=array(
			"id_user"	=> $id,
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

	function consultarFrontalDisponible($id_debajo, $red){
		
		$query = $this->db->query('select * from afiliar where debajo_de = '.$id_debajo.' and id_red = '.$red.' ');
		
		$lados = $query->result();
		$lado_disponible=0;
		
		if(isset($lados[0]->id)){
			foreach ($lados as $filaLado){
				$lado_disponible = ($filaLado->lado) + 1;
				
			}
		}
		return $lado_disponible;
	}
	
	function CambiarFase($id, $red, $fase){
		
		$query = $this->db->query('select * from red where id_usuario = '.$id.' and id_red = '.$red.' ');
		
		$red = $query->result();
		
		if($red[0]->premium == 0){
			$this->db->query("update red set premium = '".$fase."' where id_red =".$red[0]->id_red." and id_usuario=".$id);
			return true;
		}
	}
	
	function crearUsuarioAdmin($id_debajo){
	
		$id = $this->obtenrIdUser($_POST['mail_important']);
		
		$this->db->query('update users set activated="1" where id="'.$id.'"');
		$this->EstiloUsuaio($id);
		$directo=1;
		
		$this->CrearPerfil($id);
	
		$this->CrearCoaplicante($id);
	
		$mi_red=$_POST['red'];
		
		/*################### DATO RED #########################*/
	
		$redes = $this->db->get('tipo_red');
		$redes = $redes->result();
		foreach ($redes as $red){
			$dato_red=array(
					'id_red'        => $red->id,
					"id_usuario"	=> $id,
					"profundidad"	=> "0",
					"estatus"		=> "ACT",
					"premium"			=> '0'
			);
			$this->db->insert("red",$dato_red);
		}
	
		/*################### FIN DATO RED #########################*/
	
		/*################### DATO AFILIAR #########################*/
	
		$directo = 1;
		if(isset($_POST['sponsor']))
		{
			$directo = 0;
		}
		
		$lado = $this->consultarFrontalDisponible($id_debajo, $mi_red);
		
		$dato_afiliar=array(
				"id_red"      => $mi_red,
				"id_afiliado" => $id,
				"debajo_de"   => $id_debajo,
				"directo"     => $directo,
				"lado"        => $lado
		);
	
		
		$this->db->insert("afiliar",$dato_afiliar);
			
			
		/*################### DATO TELEFONOS #########################*/
		//tipo_tel 1=fijo 2=movil
		if($_POST["fijo"])
		{
			foreach ($_POST["fijo"] as $fijo)
			{
				$dato_tel=array(
						"id_user"		=> $id,
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
						"id_user"		=> $id,
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
				"id_user"   => $id,
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
				"id_user"	=> $id,
				"estatus"		=> "DES",
				"activo"		=> "No"
		);
		$this->db->insert("billetera",$dato_billetera);
		/*################### FIN DATO BILLETERA #########################*/
	
		/*################### FIN DATO COBRO #########################*/
		$dato_cobro=array(
				"id_user"		=> $id,
				"id_metodo"		=> 1,
				"id_estatus"	=> 1,
				"monto"			=> 0
		);
		$this->db->insert("cobro",$dato_cobro);
	
		$dato_cobro=array(
				"id_user"		=> $id,
				"id_metodo"		=> 1,
				"id_estatus"	=> 4,
				"monto"			=> 0
		);
		$this->db->insert("cobro",$dato_cobro);
	
		/*################### FIN DATO COBRO #########################*/
	
		/*################### DATO RANGO #########################*/
		$dato_rango=array(
				"id_user"	=> $id,
				"id_rango"		=> 1,
				"entregado"		=> 1,
				"estatus"		=> "ACT"
		);
		$this->db->insert("cross_rango_user",$dato_rango);
		/*################### FIN DATO RANGO #########################*/
		
		return true;
	}

	function crearUsuarioProveedor($id_debajo){
	
		$id = $this->obtenrIdUser($_POST['mail_important']);
		
		$this->db->query('update users set activated="1" where id="'.$id.'"');
		$this->EstiloUsuaio($id);
		$directo=1;
		
		$this->CrearPerfil($id);
	
		$this->CrearCoaplicante($id);
	
		$mi_red=$_POST['red'];
		
		/*################### DATO RED #########################*/
	
		$redes = $this->db->get('tipo_red');
		$redes = $redes->result();
		foreach ($redes as $red){
			$dato_red=array(
					'id_red'        => $red->id,
					"id_usuario"	=> $id,
					"profundidad"	=> "0",
					"estatus"		=> "ACT",
					"premium"			=> '0'
			);
			$this->db->insert("red",$dato_red);
		}
	
		/*################### FIN DATO RED #########################*/
	
		/*################### DATO AFILIAR #########################*/
	
		$directo = 1;
		if(isset($_POST['sponsor']))
		{
			$directo = 0;
		}
		
		$lado = $this->consultarFrontalDisponible($id_debajo, $mi_red);
		
		$dato_afiliar=array(
				"id_red"      => $mi_red,
				"id_afiliado" => $id,
				"debajo_de"   => $id_debajo,
				"directo"     => $directo,
				"lado"        => $lado
		);
	
		
		$this->db->insert("afiliar",$dato_afiliar);
			
			
		/*################### DATO TELEFONOS #########################*/
		//tipo_tel 1=fijo 2=movil
		if($_POST["fijo"])
		{
			foreach ($_POST["fijo"] as $fijo)
			{
				$dato_tel=array(
						"id_user"		=> $id,
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
						"id_user"		=> $id,
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
				"id_user"   => $id,
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
				"id_user"	=> $id,
				"estatus"		=> "DES",
				"activo"		=> "No"
		);
		$this->db->insert("billetera",$dato_billetera);
		/*################### FIN DATO BILLETERA #########################*/
	
		/*################### FIN DATO COBRO #########################*/
		$dato_cobro=array(
				"id_user"		=> $id,
				"id_metodo"		=> 1,
				"id_estatus"	=> 1,
				"monto"			=> 0
		);
		$this->db->insert("cobro",$dato_cobro);
	
		$dato_cobro=array(
				"id_user"		=> $id,
				"id_metodo"		=> 1,
				"id_estatus"	=> 4,
				"monto"			=> 0
		);
		$this->db->insert("cobro",$dato_cobro);
	
		/*################### FIN DATO COBRO #########################*/
	
		/*################### DATO RANGO #########################*/
		$dato_rango=array(
				"id_user"	=> $id,
				"id_rango"		=> 1,
				"entregado"		=> 1,
				"estatus"		=> "ACT"
		);
		$this->db->insert("cross_rango_user",$dato_rango);
		/*################### FIN DATO RANGO #########################*/
		
		return true;
	}

	function RedAfiliado($id, $red){
		$query = $this->db->query('select * from red where id_red = "'.$red.'" and id_usuario = "'.$id.'" ');
		return $query->result();
	}
}