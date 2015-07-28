<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class configuracion extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('bo/modelo_dashboard');
		$this->load->model('bo/model_admin');
		$this->load->model('bo/general');
<<<<<<< HEAD
		$this->load->model('bo/model_mercancia');
=======
		$this->load->model('model_datos_generales_soporte_tecnico');
		$this->load->model('model_cat_grupo_soporte_tecnico');
>>>>>>> d7f4fb078b7c939050fcf8abecc9fbb41e21e18f
	}
	function index()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

			$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}

		$style=$this->modelo_dashboard->get_style($id);

		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/bo/header');
        $this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/index');
	}
	
	function comisiones()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		
		$categorias  = $this->model_mercancia->CategoriasMercancia();

		$this->template->set("categorias",$categorias);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/comisiones');
	}

	function actualizar_comisiones(){
		
		$this->model_admin->new_profundidad();
		redirect('bo/configuracion/comisiones');
	}
	
	function tipoRed()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

			$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}

		$style=$this->modelo_dashboard->get_style($id);

		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/bo/header');
        $this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/tipo_red');
	}
	
	function soporte_tecnico()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/soporte_tecnico');
	}
	
	function datos_generales()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
		$datos_generales = $this->model_datos_generales_soporte_tecnico->listar();
		$vacio = 0;
		
		$this->template->set("style",$style);
		$this->template->set("datos_generales",$datos_generales);
		$this->template->set("vacio",$vacio);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/datos_generales');
	}
	
	function actualizar_datos_generales()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
		
		if ($_POST['vacio']==3){
			$this->model_datos_generales_soporte_tecnico->insertar($_POST['skype'], $_POST['pekey'], $_POST['pinkost']);
		}
		else $this->model_datos_generales_soporte_tecnico->actualizar($_POST['skype'], $_POST['pekey'], $_POST['pinkost']);
		
		$success = "El cambio se ha efectuado satisfactoriamente.";
		$this->session->set_flashdata('success', $success);
		
		redirect('/bo/configuracion/datos_generales');
	}
	
	function grupos_soporte_tecnico()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/grupos/index');
	}
	
	function alta_grupos_soporte_tecnico()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/grupos/alta');
	}
	
	function listar_grupos_soporte_tecnico()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$grupos  = $this->model_cat_grupo_soporte_tecnico->listar();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("grupos",$grupos);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/grupos/listar');
	}
	
	function add_grupo_soporte_tecnico()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$this->db->query("insert into cat_grupo_soporte_tecnico (descripcion,estatus,tipo) values ('".$_POST['grupo']."','ACT','".$_POST['tipo']."')");
	}
	
	function categorias()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
			$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/categorias');
	}
	
	function retenciones()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
			$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/retenciones');
	}
	
	function nueva_retencion()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
			$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/nueva_retencion');
	}
	
	function listar_retenciones()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
			$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		};
		
		$retenciones 	 = $this->model_admin->get_retencion();
		
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("retenciones",$retenciones);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/retenciones/index');
	}
	function cambiar_estado_retencion(){
		$correcto = $this->model_admin->cambiar_estatus_retencion();
		echo "";
	}
	function editar_retencion(){
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
		$retencion	 	 = $this->model_admin->get_retencion_id($_POST['id']);
	
		$this->template->set("retencion",$retencion);
		$this->template->build('website/bo/retenciones/editar');
	}
	
	function actualizar_retencion(){
		$correcto = $this->model_admin->actualizar_retencion();
		if($correcto){
			echo "Retencion Actualizada";
		}
		else{
			echo "No se logro actualizar la Retencion";
		}
	
	}
	
	function eliminar_retencion(){
		echo "Retencion Eliminada";
	
	}
	
	function impuestos()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
			$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/impuestos');
	}
	
	function nuevo_impuesto()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
			$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
		
		
		$paises            = $this->model_admin->get_pais_activo();
		
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("paises",$paises);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/configuracion/nuevo_impuesto');
	}
	
	function listar_impuestos()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
			$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
		
		
		$impuestos 	 = $this->model_admin->get_impuestos();
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("impuestos",$impuestos);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/impuestos/index');
	}
	function cambiar_estado_impuesto(){
		$correcto = $this->model_admin->cambiar_estatus_impuesto();
	}
	function editar_impuesto(){
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
		$impuesto	 	 = $this->model_admin->get_impuesto_id($_POST['id']);
	
		$paises            = $this->model_admin->get_pais_activo();
		$this->template->set("paises",$paises);
		$this->template->set("impuesto",$impuesto);
		$this->template->build('website/bo/impuestos/editar');
	}
	
	function actualizar_impuesto(){
		$correcto = $this->model_admin->actualizar_impuesto();
		if($correcto){
			echo "Impuesto Actualizado";
		}
		else{
			echo "No se logro actualizar el impuesto";
		}
	
	}
	
	function eliminar_impuesto(){
		echo "Impuesto Eliminado";
	}
}
