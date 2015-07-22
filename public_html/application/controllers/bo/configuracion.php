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
		
		$profundidad  = $this->model_admin->get_config_profundidad_tipo_red();
		$countProfundidad  = $this->model_admin->get_config_count_profundidad();
		
		if($profundidad[0]->profundidad!=$countProfundidad[0]->profundidad){
			$configuracion_profundidad  = false;
		}else {
		
		$configuracion_profundidad  = $this->model_admin->get_config_profundidad();
		}
		
		$valor_punto  = $this->model_admin->get_config_valor_punto();

		$this->template->set("profundidad",$profundidad);
		$this->template->set("configuracion_profundidad",$configuracion_profundidad);
		$this->template->set("valor_punto",$valor_punto);
	
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
