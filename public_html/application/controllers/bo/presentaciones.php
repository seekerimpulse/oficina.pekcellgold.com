<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class presentaciones extends CI_Controller
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
		$this->load->model('bo/modelo_comercial');
		$this->load->library('upload');
	}
	function index()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);

		$style=$this->modelo_dashboard->get_style($id);

		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/bo/header');
        $this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/oficinaVirtual/presentaciones/index');
	}

	function alta()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		
		$grupos=$this->modelo_comercial->get_groups();
		$this->template->set("grupos",$grupos);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/oficinaVirtual/presentaciones/alta');
	}
	function listar()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		
		$presentaciones = $this->modelo_comercial->get_presentaciones();
		$this->template->set("presentaciones",$presentaciones);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/oficinaVirtual/presentaciones/listar');
	}
	
function sube_presentacion()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();

		//Checamos si el directorio del usuario existe, si no, se crea
		if(!is_dir(getcwd()."/media/".$id))
		{
			mkdir(getcwd()."/media/".$id, 0777);
		}

		$ruta="/media/".$id."/";
		//definimos la ruta para subir la imagen
		$config['upload_path'] 		= getcwd().$ruta;
		$config['allowed_types'] 	= 'ppt|pptx|odp|.odp|.ppt';

		//Cargamos la libreria con las configuraciones de arriba
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if ($_POST['grupo_frm']=="0"){
			$error = "Debe seleccionar un grupo para la presentacion.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/presentaciones/alta');
		}
		else if ($_POST['nombre_publico']==""){
			$error = "Debe escribir un nombre para la presentacion.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/presentaciones/alta');
		}
		else if ($_POST['desc_frm']==""){
			$error = "Debe escribir una descripcion para la presentacion.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/presentaciones/alta');
		}
		
		
			//exit();
		//Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (!$this->upload->do_upload('userfile'))
		{
			//echo 'Holis';
			//echo $ruta;
			//$error = array('error' => $this->upload->display_errors());
			
			$error = "El tipo de archivo que esta cargando no esta permitido.";
			
			
			$this->session->set_flashdata('error', $error);
			redirect('/bo/presentaciones/alta');
			//var_dump($this->upload->data() , "									",$error);
			//exit();
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$nombre=$data['upload_data']['file_name'];
			$filename=strrev($nombre);
			$explode=explode(".",$filename);
			$nombre=strrev($explode[1]);
			$extencion=strrev($explode[0]);
			$ext=strtolower($extencion);
			//var_dump($this->upload->data(), "									bien");
			//exit();
			if($ext=="pptx") 
			{
				$this->db->query('insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values ('.$id.','.$_POST['grupo_frm'].',4,"'.$_POST['desc_frm'].'","'.$ruta.$data['upload_data']['file_name'].'","ACT","'.$_POST["nombre_publico"].'")');
			}
			elseif ($ext=="ppt") 
			{ 
				$this->db->query('insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico) 
				values ('.$id.','.$_POST['grupo_frm'].',3,"'.$_POST['desc_frm'].'","'.$ruta.$data['upload_data']['file_name'].'","ACT","'.$_POST["nombre_publico"].'")');
			}
			elseif ($ext=="odp")
			{
				$this->db->query('insert into archivo (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico)
				values ('.$id.','.$_POST['grupo_frm'].',8,"'.$_POST['desc_frm'].'","'.$ruta.$data['upload_data']['file_name'].'","ACT","'.$_POST["nombre_publico"].'")');
			}
			//echo 'ptm';
			redirect('/bo/presentaciones/listar');
			
		}  
		
	}
}
