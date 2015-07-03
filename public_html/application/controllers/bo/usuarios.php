<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class usuarios extends CI_Controller
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
		$this->load->model('ov/model_perfil_red');
		$this->load->model('ov/model_afiliado');
		$this->load->model('model_tipo_red');
		$this->load->model('bo/model_tipo_usuario');
	}
	
	function alta(){
		if (!$this->tank_auth->is_logged_in()){																		// logged in
		redirect('/auth');
		}
		
		$id              =  2;
		$sexo            = $this->model_perfil_red->sexo();
		$pais            = $this->model_perfil_red->get_pais();
		$style           = $this->general->get_style($id);
		$civil           = $this->model_perfil_red->edo_civil();
		$tipo_fiscal     = $this->model_perfil_red->tipo_fiscal();
		$estudios        = $this->model_perfil_red->get_estudios();
		$ocupacion       = $this->model_perfil_red->get_ocupacion();
		$tiempo_dedicado = $this->model_perfil_red->get_tiempo_dedicado();
		$redes 			 = $this->model_tipo_red->listarTodos();
		$tipos 			 = $this->model_tipo_usuario->listarTodos();
		
		$image 			 = $this->model_perfil_red->get_images($id);
		$red_forntales 	 = $this->model_tipo_red->ObtenerFrontales();
		
		
		
		$img_perfil="/template/img/empresario.jpg";
		foreach ($image as $img)
		{
			$cadena=explode(".", $img->img);
			if($cadena[0]=="user")
			{
				$img_perfil=$img->url;
			}
		}
		
		$this->template->set("sexo",$sexo);
		$this->template->set("civil",$civil);
		$this->template->set("pais",$pais);
		$this->template->set("tipo_fiscal",$tipo_fiscal);
		$this->template->set("estudios",$estudios);
		$this->template->set("ocupacion",$ocupacion);
		$this->template->set("tiempo_dedicado",$tiempo_dedicado);
		$this->template->set("redes",$redes);
		$this->template->set("tipos",$tipos);
		
		$this->template->set_theme('desktop');
		$this->template->set("style",$style);
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/bo/comercial/red/NuevoUsuario');
	}
	
	function afiliar_nuevo()
	{
	
		$resultado = $this->model_afiliado->crearUsuarioAdmin(2);
		
		if($resultado)
		{
			$id_afiliado=$this->model_perfil_red->get_id();
			echo "El usuario <b>".$_POST['nombre']."&nbsp; ".$_POST['apellido']."</b> ha quedado afiliado con el id <b>".$id_afiliado[0]->id."</b>";
		}
		else
		{
			echo "!UPS¡ lo sentimos parece que algo fallo";
		}
	}
	
	function geneologico(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		
		$id              = 2;
		$usuario         = $this->model_perfil_red->datos_perfil($id);
		$telefonos       = $this->model_perfil_red->telefonos($id);
		$sexo            = $this->model_perfil_red->sexo();
		$pais            = $this->model_perfil_red->get_pais();
		$style           = $this->general->get_style($id);
		$dir             = $this->model_perfil_red->dir($id);
		$civil           = $this->model_perfil_red->edo_civil();
		$tipo_fiscal     = $this->model_perfil_red->tipo_fiscal();
		$estudios        = $this->model_perfil_red->get_estudios();
		$ocupacion       = $this->model_perfil_red->get_ocupacion();
		$tiempo_dedicado = $this->model_perfil_red->get_tiempo_dedicado();
		$red          = $this->model_tipo_red->listarTodos();
		
		foreach ($red as $reds){
			$afiliadostree[$reds->id] = $this->model_perfil_red->get_afiliados($reds->id, $id);
		}
		
		$image 			 = $this->model_perfil_red->get_images($id);
		$red_forntales 	 = $this->model_tipo_red->ObtenerFrontales();
		
		
		
		$img_perfil="/template/img/empresario.jpg";
		foreach ($image as $img)
		{
			$cadena=explode(".", $img->img);
			if($cadena[0]=="user")
			{
				$img_perfil=$img->url;
			}
		}
		
		$this->template->set("id",$id);
		$this->template->set("redes",$red);
		$this->template->set("style",$style);
		$this->template->set("afiliadostree",$afiliadostree);
		$this->template->set("sexo",$sexo);
		$this->template->set("civil",$civil);
		$this->template->set("pais",$pais);
		$this->template->set("tipo_fiscal",$tipo_fiscal);
		$this->template->set("estudios",$estudios);
		$this->template->set("ocupacion",$ocupacion);
		$this->template->set("tiempo_dedicado",$tiempo_dedicado);
		$this->template->set("img_perfil",$img_perfil);
		$this->template->set("red_frontales",$red_forntales);
		$this->template->set("premium",$premium);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/bo/comercial/red/geneologico');
	}
	
	function grafico1(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id              = 2;
		$usuario         = $this->model_perfil_red->datos_perfil($id);
		$telefonos       = $this->model_perfil_red->telefonos($id);
		$sexo            = $this->model_perfil_red->sexo();
		$pais            = $this->model_perfil_red->get_pais();
		$style           = $this->general->get_style($id);
		$dir             = $this->model_perfil_red->dir($id);
		$civil           = $this->model_perfil_red->edo_civil();
		$tipo_fiscal     = $this->model_perfil_red->tipo_fiscal();
		$estudios        = $this->model_perfil_red->get_estudios();
		$ocupacion       = $this->model_perfil_red->get_ocupacion();
		$tiempo_dedicado = $this->model_perfil_red->get_tiempo_dedicado();
		$red          = $this->model_tipo_red->listarTodos();
	
		foreach ($red as $reds){
			$afiliados[$reds->id] = $this->model_perfil_red->get_afiliados($reds->id, $id);
		}
	
		$image 			 = $this->model_perfil_red->get_images($id);
		$red_forntales 	 = $this->model_tipo_red->ObtenerFrontales();
	
	
	
		$img_perfil="/template/img/empresario.jpg";
		foreach ($image as $img)
		{
			$cadena=explode(".", $img->img);
			if($cadena[0]=="user")
			{
				$img_perfil=$img->url;
			}
		}
	
		$this->template->set("id",$id);
		$this->template->set("redes",$red);
		$this->template->set("style",$style);
		$this->template->set("afiliados",$afiliados);
		$this->template->set("sexo",$sexo);
		$this->template->set("civil",$civil);
		$this->template->set("pais",$pais);
		$this->template->set("tipo_fiscal",$tipo_fiscal);
		$this->template->set("estudios",$estudios);
		$this->template->set("ocupacion",$ocupacion);
		$this->template->set("tiempo_dedicado",$tiempo_dedicado);
		$this->template->set("img_perfil",$img_perfil);
		$this->template->set("red_frontales",$red_forntales);
		$this->template->set("premium",$premium);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/bo/comercial/red/grafico1');
	}
	
	function grafico2(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
	
		$id              = 2;
		$usuario         = $this->model_perfil_red->datos_perfil($id);
		$telefonos       = $this->model_perfil_red->telefonos($id);
		$sexo            = $this->model_perfil_red->sexo();
		$pais            = $this->model_perfil_red->get_pais();
		$style           = $this->general->get_style($id);
		$dir             = $this->model_perfil_red->dir($id);
		$civil           = $this->model_perfil_red->edo_civil();
		$tipo_fiscal     = $this->model_perfil_red->tipo_fiscal();
		$estudios        = $this->model_perfil_red->get_estudios();
		$ocupacion       = $this->model_perfil_red->get_ocupacion();
		$tiempo_dedicado = $this->model_perfil_red->get_tiempo_dedicado();
		$red          = $this->model_tipo_red->listarTodos();
	
		foreach ($red as $reds){
			$afiliadostree[$reds->id] = $this->model_perfil_red->get_afiliados($reds->id, $id);
		}
	
		$image 			 = $this->model_perfil_red->get_images($id);
		$red_forntales 	 = $this->model_tipo_red->ObtenerFrontales();
	
	
	
		$img_perfil="/template/img/empresario.jpg";
		foreach ($image as $img)
		{
			$cadena=explode(".", $img->img);
			if($cadena[0]=="user")
			{
				$img_perfil=$img->url;
			}
		}
	
		$this->template->set("id",$id);
		$this->template->set("redes",$red);
		$this->template->set("style",$style);
		$this->template->set("afiliadostree",$afiliadostree);
		$this->template->set("sexo",$sexo);
		$this->template->set("civil",$civil);
		$this->template->set("pais",$pais);
		$this->template->set("tipo_fiscal",$tipo_fiscal);
		$this->template->set("estudios",$estudios);
		$this->template->set("ocupacion",$ocupacion);
		$this->template->set("tiempo_dedicado",$tiempo_dedicado);
		$this->template->set("img_perfil",$img_perfil);
		$this->template->set("red_frontales",$red_forntales);
		$this->template->set("premium",$premium);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/bo/comercial/red/genealogico2');
	}
	
	function subred()
	{
		$id = $_POST['id'];
		$id_red = $_POST['red'];
	
		$afiliados = $this->model_perfil_red->get_afiliados($id_red, $id);
		if($afiliados)
		{
			$usuario=array();
			foreach ($afiliados as $id_afiliado)
			{
				$usuario[]=$this->model_perfil_red->datos_perfil($id_afiliado->id_afiliado);
			}
			echo "<ul role='group'>";
			foreach ($usuario as $afiliado)
			{
				echo "
				<li class='parent_li' style='display: list-item;' role='treeitem' id='".$afiliado[0]->user_id."'>
	            	<span class='quitar'  onclick='subred(".$afiliado[0]->user_id.",".$_POST['red'].")'><i class='fa fa-lg fa-plus-circle'></i> ".$afiliado[0]->nombre." ".$afiliado[0]->apellido."</span>
	            </li>";
			}
			echo "</ul>";
		}
		else
		{
			echo "<ul  role='group'>
				<li  class='parent_li' style='display: list-item;' role='treeitem'>
					No tiene afiliados
	            </li>";
			echo "</ul>";
		}
	}
	
function subtree()
	{
		$id_red=$_POST['red'];
		$frontales 	 = $this->model_tipo_red->ObtenerFrontales();
		$frontales= $frontales[0]->frontal;
		$afiliados = $this->model_perfil_red->get_afiliados($id_red, $_POST['id']);
		
		$nombre=$this->model_perfil_red->get_name($_POST['id']);
		$nombre='"'.$nombre[0]->nombre." ".$nombre[0]->apellido.'"';
		
		if($afiliados)
		{
				
			$usuario=array();
			foreach ($afiliados as $id_afiliado)
			{
				$usuario[]=$this->model_perfil_red->datos_perfil($id_afiliado->id_afiliado);
			}
				
				
			foreach ($usuario as $afiliado)
			{
		
				$image 			 = $this->model_perfil_red->get_images($afiliado[0]->user_id);
				$img_perfil='/template/img/empresario.jpg';
				foreach ($image as $img)
				{
					$cadena=explode(".", $img->img);
					if($cadena[0]=="user")
					{
						$img_perfil=$img->url;
					}
				}
		
				if(sizeof($afiliados) == 0)
				{
		
					($afiliados[0]->directo==0) ? $todo='todo' : $todo='todo1';
		
					for($i=$aux; $i < $frontales; $i++){
						echo "
						<li>
							<a href='javascript:void(0)'>No tiene afiliado</a>
			            </li>";
					}
					 
				}
				else
				{
					$aux++;
					($afiliados[0]->directo==0) ? $todo='todo' : $todo='todo1';
					echo "
					<li id='t".$afiliado[0]->user_id."'>
		            	<a class='quitar' onclick='subtree(".$afiliado[0]->user_id.",".$id_red." )' style='background: url(".$img_perfil."); background-size: cover; background-position: center;' href='javascript:void(0)'></a>
		            	<div onclick='detalles(".$afiliado[0]->user_id.")' class='".$todo."'>".$afiliado[0]->nombre." ".$afiliado[0]->apellido."<br />Detalles</div>
		            </li>";
						
				}
		
			}
			if($aux > 0){
				for($i=$aux; $i < $frontales; $i++){
					echo "
						<li>
							<a href='javascript:void(0)'>No tiene afiliado</a>
			            </li>";
				}
			}
			echo "</ul>";
		}
		else
		{
			$nombre=$this->model_perfil_red->get_name($_POST['id']);
			$nombre='"'.$nombre[0]->nombre." ".$nombre[0]->apellido.'"';
			echo "<ul>";
			for($i=0; $i < $frontales; $i++){
				echo "
						<li>
							<a href='javascript:void(0)'>No tiene afiliado</a>
			            </li>";
			}
			echo "</ul>";
		}
		
	}
}