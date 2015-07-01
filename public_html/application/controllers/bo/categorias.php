<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class categorias extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('ov/general');
		$this->load->model('bo/model_grupo_producto');
		$this->load->model('model_tipo_red');
	}
	
	function index(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
		$categorias 	 = $this->model_grupo_producto->Categorias();
		
		$this->template->set("style",$style);
		$this->template->set("categorias",$categorias);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/bo/categorias/index');
	}
	
	function nueva_categoria(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
		$redes 	 		 = $this->model_tipo_red->listarTodos();
		
		$this->template->set("style",$style);
		$this->template->set("redes",$redes);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/bo/categorias/nueva');
	}
	
	function crear_categoria(){
		$correcto = $this->model_grupo_producto->CrearCategoria();
		if($correcto){
			echo "Categoria Creada";
		}
		else{
			echo "NO se logro crear la categoria";
		}
	}
	
	function editar(){
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
		$redes 	 		 = $this->model_tipo_red->listarTodos();
		$categoria	 	 = $this->model_grupo_producto->ConsultarCategoria($_POST['id']);
		
		$this->template->set("redes",$redes);
		$this->template->set("categoria",$categoria);
		$this->template->build('website/bo/categorias/editar');
	}
	
	function actualizar_categoria(){
		$correcto = $this->model_grupo_producto->actualizar_categoria();
		if($correcto){
			echo "Categoria Actualizada";
		}
		else{
			echo "No se logro actualizar la categoria";
		}
		
	}
	
	function eliminar_categoria(){
		$correcto = $this->model_grupo_producto->eliminar_categoria();
		if($correcto){
			echo "Categoria Eliminada";
		}
		else{
			echo "No se logro eliminada la categoria";
		}
	
	}
	
	function cambiar_estado_categoria(){
		$correcto = $this->model_grupo_producto->cambiar_estatus_categoria();
		echo "";
	}
}