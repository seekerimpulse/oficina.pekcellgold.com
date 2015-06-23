<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tipo_red extends CI_Controller{

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

	public function guardar_red(){
			$this->model_tipo_red->insertar($_POST['nombre'],$_POST['descripcion'],3,2);
			redirect("/bo/tipo_red/mostrar_redes");
	}

	public function mostrar_redes()
	{
		$redes = $this->model_tipo_red->listarTodos();
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}

		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
			
		$this->template->set("redes", $redes);
		$this->template->set("style",$style);
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
        $this->template->build('website/bo/TipoRed/index');
	}

}