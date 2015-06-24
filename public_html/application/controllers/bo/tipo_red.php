<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tipo_red extends CI_Controller{
	
	var $id_red;
	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('ov/general');
		$this->load->model('model_tipo_red');
	}

	public function crear_red()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}

		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/bo/TipoRed/nuevo');	


	}

	public function actualizar_red()
	{
		$id_red = $_POST['id'];
		redirect("/bo/tipo_red/mostrar_redes");
	}
	
	public function guardar_red(){
			$capacidadRed = $this->model_tipo_red->traerCapacidadRed();
			if($capacidadRed[0]->frontal == null){
				$capacidadRed[0]->frontal = 3;
				$capacidadRed[0]->profundidad = 2;
			}
			$this->model_tipo_red->insertar($_POST['nombre'],$_POST['descripcion'],$capacidadRed[0]->frontal,$capacidadRed[0]->profundidad);
			redirect("/bo/tipo_red/mostrar_redes");
	}

	public function mostrar_redes()
	{
		
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$redes = $this->model_tipo_red->listarTodos();
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
			
		$this->template->set("redes", $redes);
		$this->template->set("style",$style);
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
        $this->template->build('website/bo/TipoRed/mostrarRedes');
	}

}