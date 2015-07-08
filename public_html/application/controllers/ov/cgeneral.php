<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cgeneral extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('ov/modelo_general');
		$this->load->model('ov/general');
		$this->load->model('model_tipo_red');
	}
	function soporte_tecnico()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$style=$this->general->get_style($id);
		$redes = $this->model_tipo_red->listarTodos();
		
		$this->template->set("style",$style);
		$this->template->set("redes",$redes);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/general/soporte_tecnico');
	}
	
	function chat()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$style=$this->general->get_style($id);

		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/general/menu_chat');
	}

	function chat_red()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$style=$this->general->get_style($id);

		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/general/chat_red');
	}

	function chat_social()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$style=$this->general->get_style($id);

		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/general/chat_social');
	}
	
	function videollamada()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$style=$this->general->get_style($id);

		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/general/videollamada');
	}

	function encuestas()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$style=$this->general->get_style($id);

		$this->template->set("style",$style);
		$encuestas=$this->modelo_general->get_encuestas();
		$data['encuestas']=$encuestas;
		$contestadas=$this->modelo_general->get_encuestas_contestadas($id);
		$data['contestadas']=$contestadas;
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/general/encuestas',$data);
	}
	function contestar_encuesta()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$style=$this->general->get_style($id);

		$this->template->set("style",$style);
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		if(isset($_GET['id']))
		{
			$id_encuesta=urldecode($_GET['id']);
			$encuesta=$this->modelo_general->get_encuesta($id_encuesta);
			$data['encuesta']=$encuesta;
			$preguntas=$this->modelo_general->get_preguntas($id_encuesta);
			$data['pregunta']=$preguntas;
			$respuestas=$this->modelo_general->get_respuestas($id_encuesta);
			$data['respuesta']=$respuestas;
			$this->template->build('website/ov/general/contestar_encuesta',$data);
		}
		else
		{
			$this->template->build('website/ov/general/contestar_encuesta');
		}
		
	}
	function guardar_encuesta()
	{
		$data=$_GET["info"];
		$data=json_decode($data,true);
		$id=$this->tank_auth->get_user_id();
		$this->db->query("insert into encuesta_contestada (id_encuesta,id_usuario) values (".$data['id'].",".$id.")");
		$encuesta_contestada=mysql_insert_id();
		array_pop($data);
		foreach($data as $respuesta)
		{
			$pregunta=$this->modelo_general->get_pregunta($respuesta);
			$this->db->query("insert into encuesta_resultado (id_encuesta_contestada,id_pregunta,id_respuesta) 
			values (".$encuesta_contestada.",".$pregunta[0]->id_pregunta.",".$respuesta.")");

		}
	}
	function ver_resultados()
	{
		$respuestas=$this->modelo_general->get_resultados_encuesta($_GET['id']);
		for($j=0;$j<sizeof($respuestas);$j++)
		{
			echo '<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-asterisk fa-2x text-muted"></i></td>
					<td>
						<h4>'
							.$respuestas[$j]->pregunta.
						'</a>
							
						</h4>
					</td>
					<td class="text-center hidden-xs hidden-sm">
						'.$respuestas[$j]->respuesta.'
					</td>
				</tr>';
		}
	}
	function se_contesto()
	{
		$user=$this->tank_auth->get_user_id();
		$contesto=$this->modelo_general->get_se_contesto($_POST["id"],$user);
		if(!isset($contesto[0]))
		{
			echo "no";
		}
		else {
			echo "si";
		}
	}
	function social_network()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$style=$this->general->get_style($id);

		$this->template->set("style",$style);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/general/social');
	}
	function mensajes()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$style=$this->general->get_style($id);
		$mensaje=$this->modelo_general->get_mensaje($id);
		$afiliados=$this->modelo_general->get_afiliados($id);

		$this->template->set("style",$style);
		$this->template->set("mensaje",$mensaje);
		$this->template->set("afiliados",$afiliados);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/general/mensajes');
	}
	function envia_sms()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$this->modelo_general->envia_sms($id);
	}
	function del_sms()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}
		$this->modelo_general->del_sms();
	}
	function get_sms()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}
		$mensaje=$this->modelo_general->get_sms();
		echo $mensaje[0]->mensaje;
	}
	
	
}