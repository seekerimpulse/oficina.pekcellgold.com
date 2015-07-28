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

		$this->load->model('bo/model_mercancia');

		$this->load->model('model_datos_generales_soporte_tecnico');
		$this->load->model('model_cat_grupo_soporte_tecnico');
		$this->load->model('model_tipo_red');
		$this->load->model('model_archivo_soporte_tecnico');

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
	
	function videos_ver_redes()
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
	
		$redes = $this->model_tipo_red->listarTodos();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("redes",$redes);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/videos_ver_redes');
	}
	
	function videos()
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
	
		$id_red = $_GET['id_red'];
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("id_red",$id_red);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/videos/index');
	}
	
	function alta_videos()
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
	
		$id_red = $_GET['id_red'];
		$style=$this->modelo_dashboard->get_style($id);
		$videos=$this->model_archivo_soporte_tecnico->get_video();
		$data=array();
		$data['videos']=$videos;
		$this->template->set("style",$style);
		
		$this->template->set("id_red",$id_red);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/videos/alta',$data);
	}
	
	function alta_normal_videos()
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
		
		$id_red = $_GET['id_red'];
		$this->template->set("id_red",$id_red);
		$style=$this->modelo_dashboard->get_style($id);
		$videos=$this->model_archivo_soporte_tecnico->get_video();
		$grupos = $this->model_cat_grupo_soporte_tecnico->get_groups("VID", $id_red);
		$data=array();
		$data['videos']=$videos;
		$data['grupos']=$grupos;
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/videos/alta_normal',$data);
	}
	
	function sube_video()	{
		
		var_dump($_GET['id_red']);
		exit();
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
	
		//Checamos si el directorio del usuario existe, si no, se crea
		if(!is_dir(getcwd()."/media/".$id))
		{
			mkdir(getcwd()."/media/".$id, 0777);
		}
	
		$ruta="/media/".$id."/";
		//definimos la ruta para subir la imagen
		$config['upload_path'] 		= getcwd().$ruta;
		$config['allowed_types'] 	= 'mp4|jpg|png|jpeg';
	
		//Cargamos la libreria con las configuraciones de arriba
		$this->load->library('upload', $config);
	
		//Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (!$this->upload->do_multi_upload('userfile'))
		{
	
			$error = array('error' => $this->upload->display_errors());
		}
		else
		{
			$data = array('upload_data' => $this->upload->get_multi_upload_data());
				
			$contador=0;
			$extVideo="";
			$extImagen="";
				
			foreach ($data["upload_data"] as $key)
			{
				if($contador==0){
					$filename=strrev($key["file_name"]);
					$explode=explode(".",$filename);
					$nombre=strrev($explode[1]);
					$extencion=strrev($explode[0]);
					$extVideo=strtolower($extencion);
						
				}
				else{
					$filename=strrev($key["file_name"]);
					$explode=explode(".",$filename);
					$nombre=strrev($explode[1]);
					$extencion=strrev($explode[0]);
					$extImagen=strtolower($extencion);
				}
				$contador++;
			}
	
			if($extVideo=="mp4"){
	
			}else {
				$this->session->set_flashdata('error','El tipo de archivo de video que se intenta subir no esta permitido , solo se permiten videos en formato MP4');
				redirect('/bo/configuracion/alta_normal_videos');
			}
				
			if($extImagen=="png"||$extImagen=="jpg"||$extImagen=="jpeg"){
					
			}else {
				$this->session->set_flashdata('error','El tipo de archivo de imagen que se intenta subir no esta permitido');
				redirect('/bo/configuracion/alta_normal_videos');
			}
				
				
				
			foreach ($data["upload_data"] as $key)
			{
				if($contador==0){
					$filename=strrev($key["file_name"]);
					$explode=explode(".",$filename);
					$nombre=strrev($explode[1]);
					$extencion=strrev($explode[0]);
					$extVideo=strtolower($extencion);
	
				}
				else{
					$filename=strrev($key["file_name"]);
					$explode=explode(".",$filename);
					$nombre=strrev($explode[1]);
					$extencion=strrev($explode[0]);
					$extImagen=strtolower($extencion);
				}
				echo $extVideo." - ".$extImagen;
				$contador++;
	
				$filename=strrev($key["file_name"]);
				$explode=explode(".",$filename);
				$nombre=strrev($explode[1]);
				$extencion=strrev($explode[0]);
				$ext=strtolower($extencion);
				if($ext=="mp4")
				{
					$this->db->query('insert into archivo_soporte_tecnico (id_usuario,id_grupo,id_tipo,descripcion,ruta,status,nombre_publico,id_red)
					values ('.$id.','.$_POST['grupo_frm'].',2,"'.$_POST['desc_frm'].'","'.$ruta.$key["file_name"].'","ACT","'.$_POST["nombre_publico"].'","'.$_GET["id_red"].'")');
					$video=mysql_insert_id();
				}
				else
				{
					$this->db->query('insert into cat_img (url,nombre_completo,nombre,extencion,estatus)
					values ("'.$ruta.$key["file_name"].'","'.$key["file_name"].'","'.$nombre.'","'.$extencion.'","ACT")');
					$imgn=mysql_insert_id();
				}
	
			}
			$this->db->query('insert into cross_img_archivo_soporte_tecnico	values ('.$video.','.$imgn.')');
			redirect('/bo/configuracion/listar_videos');
		}
		$this->session->set_flashdata('error','El tipo de archivo de video que se intenta subir no esta permitido , solo se permiten videos en formato MP4');
		redirect('/bo/configuracion/alta_normal_videos');
	}
	
	function informacion_ver_redes()
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
	
		$redes = $this->model_tipo_red->listarTodos();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("redes",$redes);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/informacion_ver_redes');
	}
	
	function informacion()
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
	
		$id_red = $_GET['id_red'];
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("id_red",$id_red);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/informacion/index');
	}
	
	function alta_informacion()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$id_red = $_GET['id_red'];
		$this->template->set("id_red",$id_red);
		
		$grupos = $this->model_cat_grupo_soporte_tecnico->get_groups("INF", $id_red);
		$this->template->set("grupos",$grupos);
		
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/informacion/alta');
	}
	
	function CrearArchivoInformacion(){
		
		$grupo = $_POST['grupo'];
		$nombre_ebook = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$id_red = $_POST['id_red'];
	
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id = $this->tank_auth->get_user_id();
	
		//Checamos si el directorio del usuario existe, si no, se crea
		if(!is_dir(getcwd()."/media/archivos/"))
		{
			mkdir(getcwd()."/media/archivos/", 0777);
		}
	
		$ruta="/media/archivos/";
		//definimos la ruta para subir el archivo
		$config['upload_path'] 		= getcwd().$ruta;
		$config['allowed_types'] 	= '*';
	
		//Cargamos la libreria con las configuraciones de arriba
		$this->load->library('upload', $config);
	
		$this->upload->initialize($config);
	
		if ($grupo == "0"){
			$error = "Debe seleccionar un grupo para el archivo.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/configuracion/alta_informacion?id_red='.$id_red);
		}
	
		if(!isset($nombre) && !isset($descripcion)){
			$error = "Debe darle un nombre y descripcion para el archivo.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/configuracion/alta_informacion?id_red='.$id_red);
		}
	
		$extension =  explode('.', $_FILES['userfile1']['name']);
		$id_archivo = $this->model_archivo_soporte_tecnico-> BuscarTipo(end($extension));
		if($id_archivo == null){
			$error = "El tipo de archivo que esta cargando no esta permitido.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/configuracion/alta_informacion?id_red='.$id_red);
		}
		//Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (!$this->upload->do_upload('userfile1'))
		{
			$error = "El tipo de archivo que esta cargando no esta permitido.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/configuracion/alta_informacion?id_red='.$id_red);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
				
			$nombre = $data['upload_data']['file_name'];
			$filename = strrev($nombre);
			$explode = explode(".",$filename);
			$extencion = strrev($explode[0]);
			$ext=strtolower($extencion);
	
			$this->model_archivo_soporte_tecnico->CrearArchivo($id, $grupo, $ext,$nombre_ebook, $descripcion, $ruta.$nombre, $id_red);
			redirect('/bo/configuracion/listar_informacion?id_red='.$id_red);
		}
	}
	
	function listar_informacion()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id_red = $_GET['id_red'];
		$archivos = $this->model_archivo_soporte_tecnico->Archivos($id_red);
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$style=$this->modelo_dashboard->get_style($id);

		$this->template->set("id_red",$id_red);
		$this->template->set("style",$style);
		$this->template->set("archivos",$archivos);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/informacion/listar');
	}
	
	function cambiar_estado_archivo_soporte_tecnico(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id = $_POST['id'];
		$estado = $_POST['estado'];
		$this->model_archivo_soporte_tecnico->CambiarEstado($id, $estado);
	}
	
	function eliminar_archivo_soporte_tecnico(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id = $_POST['id'];
		$url = $this->model_archivo_soporte_tecnico->EliminarArchivo($id);
		if(unlink($_SERVER['DOCUMENT_ROOT'].$url)){
			echo "File Deleted.";
		}
	}
	
	function editar_archivo_soporte_tecnico(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
	
		$archivo = $this->model_archivo_soporte_tecnico->consultar_archivo($_POST["id"]);
	
	
		$this->template->set("archivo",$archivo);
	
		$grupos = $this->model_cat_grupo_soporte_tecnico->get_groups("INF", $_GET['id_red']);
		$this->template->set("grupos",$grupos);
		$this->template->set("id_red",$_GET['id_red']);
	
		$this->template->build('website/bo/soporteTecnico/informacion/modificar');
	}
	
	function ActualizarArchivo_soporte_tecnico(){
	
		$grupo = $_POST['grupo'];
		$nomre_archivo = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];
		$estado = $_POST['estado'];
		$id_red = $_POST['id_red'];
		
				
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id = $this->tank_auth->get_user_id();
	
		$extension =  explode('.', $_FILES['userfile1']['name']);
	
		$id_archivo = $this->model_archivo_soporte_tecnico-> BuscarTipo(end($extension));
		
		if ($_POST["file_nme"]==''){
				
			$this->model_archivo_soporte_tecnico->ActualizarArchivo2($_POST['id'], $id ,$grupo, $nomre_archivo, $descripcion, $estado);
			redirect('/bo/configuracion/listar_informacion?id_red='.$id_red);
		}
		
		if($id_archivo == null){
			$error = "El cambio de datos no ha sido efectuado.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/configuracion/listar_informacion?id_red='.$id_red);
		}
		//Checamos si el directorio del usuario existe, si no, se crea
		if(!is_dir(getcwd()."/media/archivos/"))
		{
			mkdir(getcwd()."/media/archivos/", 0777);
		}
	
		$ruta="/media/archivos/";
		//definimos la ruta para subir el archivo
		$config['upload_path'] 		= getcwd().$ruta;
		$config['allowed_types'] 	= '*';
	
		//Cargamos la libreria con las configuraciones de arriba
		$this->load->library('upload', $config);
	
		$this->upload->initialize($config);
	
		if ($grupo == "0"){
			$error = "Debe seleccionar un grupo para al archivo.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/configuracion/listar_informacion?id_red='.$id_red);
		}
	
		if(!isset($nombre) && !isset($descripcion)){
				
			$error = "Debe darle un nombre y descripcion al archivo.";
			$this->session->set_flashdata('error', $error);
			redirect('/bo/configuracion/listar_informacion?id_red='.$id_red);
		}
	
		//Preguntamos si se pudo subir el archivo "foto" es el nombre del input del dropzone
		if (!$this->upload->do_upload('userfile1')){
			$extension =  explode('.', $_FILES['userfile1']['name']);
			$error = array('error' => $this->upload->display_errors());
			var_dump($error); exit;
			if(isset($extension[1])){
				
			}
			$this->model_archivo_soporte_tecnico->ActualizarArchivo2($_POST['id'], $id ,$grupo, $nomre_archivo, $descripcion, $estado);
		} else {
			$data = array('upload_data' => $this->upload->data());
	
			$nombre = $data['upload_data']['file_name'];
			$filename = strrev($nombre);
			$explode = explode(".",$filename);
			$extencion = strrev($explode[0]);
			$ext=strtolower($extencion);
				
			$this->model_archivo_soporte_tecnico->ActualizarArchvo($_POST['id'], $id, $grupo, $ext,$nomre_archivo, $descripcion, $ruta.$nombre, $estado);
				
				
		}
		redirect('/bo/configuracion/listar_informacion?id_red='.$id_red);
	}
	
	function datos_generales_ver_redes()
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
		
		$redes = $this->model_tipo_red->listarTodos();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("redes",$redes);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/soporteTecnico/datos_generales_ver_redes');
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
		
		$id_red = $_GET['id_red'];
		$style=$this->modelo_dashboard->get_style($id);
		$datos_generales = $this->model_datos_generales_soporte_tecnico->traer_por_red($id_red);
		$vacio = 0;
		
		$this->template->set("style",$style);
		$this->template->set("datos_generales",$datos_generales);
		$this->template->set("vacio",$vacio);
		$this->template->set("id_red",$id_red);
	
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
			$this->model_datos_generales_soporte_tecnico->insertar($_POST['skype'], $_POST['pekey'], $_POST['pinkost'], $_POST['id_red']);
		}
		else $this->model_datos_generales_soporte_tecnico->actualizar($_POST['skype'], $_POST['pekey'], $_POST['pinkost'], $_POST['id_red']);
		
		$success = "El cambio se ha efectuado satisfactoriamente.";
		$this->session->set_flashdata('success', $success);
		
		redirect('/bo/configuracion/datos_generales?id_red='.$_POST['id_red']);
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
		$redes = $this->model_tipo_red->listarTodos();
		
		$this->template->set("style",$style);
		$this->template->set("redes",$redes);
	
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
		$redes = $this->model_tipo_red->listarTodos();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("grupos",$grupos);
		$this->template->set("redes",$redes);
		
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
	
		$this->db->query("insert into cat_grupo_soporte_tecnico (descripcion,estatus,tipo,id_red) values ('".$_POST['grupo']."','ACT','".$_POST['tipo']."','".$_POST['red']."')");
	}
	
	function editar_grupo(){
		$id              = $this->tank_auth->get_user_id();
		$style           = $this->general->get_style($id);
		
		$redes = $this->model_tipo_red->listarTodos();
		$grupo  = $this->model_cat_grupo_soporte_tecnico->traer_grupo($_POST['id']);
		
		$this->template->set("grupo",$grupo);
		$this->template->set("redes",$redes);
		$this->template->build('website/bo/soporteTecnico/grupos/editar');
	}
	
	function actualizar_grupo(){
		$correcto = $this->model_cat_grupo_soporte_tecnico->actualizar_grupo();
		if($correcto){
			echo "Grupo Actualizado";
		}
		else{
			echo "No se logro actualizar el grupo";
		}
	
	}
	
	function kill_grupo()
	{
		$this->db->query("delete from cat_grupo_soporte_tecnico where id=".$_POST["id"]);
	}
	
	function cambiar_estado_grupo(){
		$this->db->query("update cat_grupo_soporte_tecnico set estatus = '".$_POST['estado']."' where id=".$_POST["id"]);
	
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
