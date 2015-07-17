<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class compras extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->load->library('cart');
		$this->lang->load('tank_auth');
		$this->load->model('ov/general');
		$this->load->model('ov/modelo_compras');
		$this->load->model('ov/model_perfil_red');
		$this->load->model('ov/model_afiliado');
		$this->load->model('model_tipo_red');
		$this->load->model('model_user_profiles');
	}

function index()
{
	if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$direccion=$this->modelo_compras->get_direccion_comprador($id);
		$pais=$this->modelo_compras->get_pais();
		$info_compras=Array();
		$producto=0;
		if($this->cart->contents())
		{ 
			foreach ($this->cart->contents() as $items) 
			{	
				$imgn=$this->modelo_compras->get_img($items['id']);
				if(isset($imgn[0]->url))
				{
					$imagen=$imgn[0]->url;
				}
				else
				{
					$imagen="";
				}
				switch($items['name'])
				{
					case 1:
						$detalles=$this->modelo_compras->detalles_productos($items['id']);
						break;
					case 2:
						$detalles=$this->modelo_compras->detalles_servicios($items['id']);
						break;
					case 3:
						$detalles=$this->modelo_compras->comb_espec($items['id']);
						break;
					case 4:
						$detalles=$this->modelo_compras->detalles_prom_prod($items['id']);
						break;
					case 5:
						$detalles=$this->modelo_compras->detalles_prom_serv($items['id']);
						break;
					case 6:
						$detalles=$this->modelo_compras->detalles_prom_comb($items['id']);
						break;
				}
				$info_compras[$producto]=Array(
					"imagen" => $imagen,
					"nombre" => $detalles[0]->nombre
				);
				$producto++;
			} 
		} 
		$data=array();
		$data["direccion"]=$direccion;
		$data["compras"]=$info_compras;
		$data["pais"]=$pais;
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/compra_reporte/iniciar_transacion',$data);
}

	
	function carrito()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$productos=$this->modelo_compras->get_productos();
		$redes = $this->model_tipo_red->listarTodos();
		
		for($i=0;$i<sizeof($productos);$i++)
		{
			$imagen=$this->modelo_compras->get_img($productos[$i]->id);
			if(isset($imagen[0]))
			{
				$productos[$i]->img=$imagen[0]->url;
			}
			else 
			{
				$productos[$i]->img="";
			}
			$impuestos=$this->modelo_compras->get_impuestos_merca($productos[$i]->id);
			$costo_ini=$productos[$i]->costo;
			$costo_total=$costo_ini;
			foreach($impuestos as $imp)
			{
				$mas=($imp*$costo_ini)/100;
				$costo_total=$costo_total+$mas;
			}
			$productos[$i]->costo=$costo_total;
		}
		$servicios=$this->modelo_compras->get_servicios();
		for($j=0;$j<sizeof($servicios);$j++)
		{
			$imagen=$this->modelo_compras->get_img($servicios[$j]->id);
			if(isset($imagen[0]))
			{
				$servicios[$j]->img=$imagen[0]->url;
			}
			else 
			{
				$servicios[$j]->img="";
			}
			$impuestos=$this->modelo_compras->get_impuestos_merca($servicios[$j]->id);
			$costo_ini=$servicios[$j]->costo;
			$costo_total=$costo_ini;
			foreach($impuestos as $imp)
			{
				$mas=($imp*$costo_ini)/100;
				$costo_total=$costo_total+$mas;
			}
			$servicios[$j]->costo=$costo_total;
		}
		$combinados=$this->modelo_compras->get_combinados();
		for($k=0;$k<sizeof($combinados);$k++)
		{
			$imagen=$this->modelo_compras->get_img($combinados[$k]->id);
			if(isset($imagen[0]))
			{
				$combinados[$k]->img=$imagen[0]->url;
			}
			else 
			{
				$combinados[$k]->img="";
			}
			$impuestos=$this->modelo_compras->get_impuestos_merca($combinados[$k]->id);
			$costo_ini=$combinados[$k]->costo;
			$costo_total=$costo_ini;
			foreach($impuestos as $imp)
			{
				$mas=($imp*$costo_ini)/100;
				$costo_total=$costo_total+$mas;
			}
			$combinados[$k]->costo=$costo_total;
		}
		$promocion_p=$this->modelo_compras->get_promocion_prod();
		for($n=0;$n<sizeof($promocion_p);$n++)
		{
			$imagen=$this->modelo_compras->get_img_prom($promocion_p[$n]->id_promocion);
			if(isset($imagen[0]))
			{
				$promocion_p[$n]->img=$imagen[0]->url;
			}
			else 
			{
				$promocion_p[$n]->img="";
			}
			$impuestos=$this->modelo_compras->get_impuestos_merca($promocion_p[$n]->id);
			$costo_ini=$promocion_p[$n]->costo*(1-($promocion_p[$n]->prom_costo/100));
			$costo_total=$costo_ini;
			foreach($impuestos as $imp)
			{
				$mas=($imp*$costo_ini)/100;
				$costo_total=$costo_total+$mas;
			}
			$promocion_p[$n]->costo=$costo_total;
		}
		$promocion_s=$this->modelo_compras->get_promocion_serv();
		for($m=0;$m<sizeof($promocion_s);$m++)
		{
			$imagen=$this->modelo_compras->get_img_prom($promocion_s[$m]->id_promocion);
			if(isset($imagen[0]))
			{
				$promocion_s[$m]->img=$imagen[0]->url;
			}
			else 
			{
				$promocion_s[$m]->img="";
			}
			$impuestos=$this->modelo_compras->get_impuestos_merca($promocion_s[$m]->id);
			$costo_ini=$promocion_s[$m]->costo*(1-($promocion_s[$m]->prom_costo/100));
			$costo_total=$costo_ini;
			foreach($impuestos as $imp)
			{
				$mas=($imp*$costo_ini)/100;
				$costo_total=$costo_total+$mas;
			}
			$promocion_s[$m]->costo=$costo_total;
		}
		$promocion_c=$this->modelo_compras->get_promocion_comb();
		for($l=0;$l<sizeof($promocion_c);$l++)
		{
			$imagen=$this->modelo_compras->get_img_prom($promocion_c[$l]->id_promocion);
			if(isset($imagen[0]))
			{
				$promocion_c[$l]->img=$imagen[0]->url;
			}
			else
			{
				$promocion_c[$l]->img="";
			}
			$impuestos=$this->modelo_compras->get_impuestos_merca($promocion_c[$l]->id);
			$costo_ini=$promocion_c[$l]->costo*(1-($promocion_c[$l]->prom_costo/100));
			$costo_total=$costo_ini;
			foreach($impuestos as $imp)
			{
				$mas=($imp*$costo_ini)/100;
				$costo_total=$costo_total+$mas;
			}
			$promocion_c[$l]->costo=$costo_total;
		}
		$info_compras=Array();
		$producto=0;
		if($this->cart->contents())
		{
			 
			foreach ($this->cart->contents() as $items) 
			{	
				$imgn=$this->modelo_compras->get_img($items['id']);
				if(isset($imgn[0]->url))
				{
					$imagen=$imgn[0]->url;
				}
				else
				{
					$imagen="";
				}
				switch($items['name'])
				{
					case 1:
						$detalles=$this->modelo_compras->detalles_productos($items['id']);
						break;
					case 2:
						$detalles=$this->modelo_compras->detalles_servicios($items['id']);
						break;
					case 3:
						$detalles=$this->modelo_compras->comb_espec($items['id']);
						break;
					case 4:
						$detalles=$this->modelo_compras->detalles_prom_prod($items['id']);
						break;
					case 5:
						$detalles=$this->modelo_compras->detalles_prom_serv($items['id']);
						break;
					case 6:
						$detalles=$this->modelo_compras->detalles_prom_comb($items['id']);
						break;
				}
				$info_compras[$producto]=Array(
					"imagen" => $imagen,
					"nombre" => $detalles[0]->nombre
				);
				$producto++;
			} 
		} 
		$data=array();
		$data['prod']=$productos;
		$data['serv']=$servicios;
		$data['comb']=$combinados;
		$data['prom_p']=$promocion_p;
		$data['prom_s']=$promocion_s;
		$data['prom_c']=$promocion_c;
		$data['compras']=$info_compras;
		$this->template->set("redes", $redes);
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/compra_reporte/carrito',$data);
	}
	function comprar()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$direccion=$this->modelo_compras->get_direccion_comprador($id);
		$pais=$this->modelo_compras->get_pais();
		$info_compras=Array();
		$producto=0;
		if($this->cart->contents())
		{ 
			foreach ($this->cart->contents() as $items) 
			{	
				$imgn=$this->modelo_compras->get_img($items['id']);
				if(isset($imgn[0]->url))
				{
					$imagen=$imgn[0]->url;
				}
				else
				{
					$imagen="";
				}
				switch($items['name'])
				{
					case 1:
						$detalles=$this->modelo_compras->detalles_productos($items['id']);
						break;
					case 2:
						$detalles=$this->modelo_compras->detalles_servicios($items['id']);
						break;
					case 3:
						$detalles=$this->modelo_compras->comb_espec($items['id']);
						break;
					case 4:
						$detalles=$this->modelo_compras->detalles_prom_prod($items['id']);
						break;
					case 5:
						$detalles=$this->modelo_compras->detalles_prom_serv($items['id']);
						break;
					case 6:
						$detalles=$this->modelo_compras->detalles_prom_comb($items['id']);
						break;
				}
				$info_compras[$producto]=Array(
					"imagen" => $imagen,
					"nombre" => $detalles[0]->nombre
				);
				$producto++;
			} 
		} 
		$data=array();
		$data["direccion"]=$direccion;
		$data["compras"]=$info_compras;
		$data["pais"]=$pais;
		$data['id'] = $id;
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/compra_reporte/comprar',$data);
	}
	
	function billetera()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);

		$estatus=$this->modelo_compras->get_estatus($id);

		$estatus=$estatus[0]->estatus;

		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$this->template->set("estatus",$estatus);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/compra_reporte/billetera');
	}
	function crea_pswd()
	{
		$id=$this->tank_auth->get_user_id();
		if($_POST['password']==$_POST['confirm_password'])
		{
			$this->modelo_compras->crea_pswd($id);
			echo "Tu contraseña ha sido creada con exito";
		}
		else
		echo "Error tu contraseña contiene errores, por favor verificalo";
	}
	function estadistica()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);

		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/compra_reporte/estadisticas');
	}
	
	function reportes()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}

		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/compra_reporte/reportes');
		
		
		if($_GET['compra']=true)
		{
			
		}
	}
	function carrito_menu()
	{
		if (!$this->tank_auth->is_logged_in()) 
		{																		// logged in
			redirect('/auth');
		}
		if(isset($_GET['transactionState'])){
			if($_GET['transactionState'] == '4'){
				$exito = "La transacion se a realizado con exito.";
				$this->session->set_flashdata('exito', $exito);
			}elseif($_GET['transactionState'] == '5'){
				$error = "La transacion ha sido rezhazada(Declinada).";
				$this->session->set_flashdata('error', $error);
			}else{
				$error = "La transacion expiro.";
				$this->session->set_flashdata('error', $error);
			}
			$extra1 = explode("-", $_GET['extra1']);
			$id_mercancia = $extra1[0];
			$producto_continua = array();
			foreach ($this->cart->contents() as $producto){
					
				if($producto['id'] != $id_mercancia){
					$add_cart = array(
							'id'      => $producto['id'],
							'qty'     => $producto['qty'],
							'price'   => $producto['price'],
							'name'    => $producto['name'],
							'options' => $producto['options']
					);
					$producto_continua[] = $add_cart;
				}
			}
			$this->cart->destroy();
			$this->cart->insert($producto_continua);
		}
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
		$afiliados=$this->modelo_compras->get_afiliados($id);
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$data['afiliados']=$afiliados;
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/ov/header');
        $this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/compra_reporte/menu_carro',$data);
	}
	function reporte_afiliados()
	{
		$id=$this->tank_auth->get_user_id();
		$red=$this->modelo_compras->get_red($id);
		$afiliados=$this->modelo_compras->reporte_afiliados($red[0]->id_red);
		echo 
			"<table id='datatable_fixed_column1' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th>ID</th>
					<th>Fecha de Registro</th>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Fecha de Nacimiento</th>
					<th>Sexo</th>
					<th>Estado Civil</th>
				</thead>
				<tbody>";
			for($i=0;$i<sizeof($afiliados);$i++)
			{
					echo "<tr>
					<td class='sorting_1'>".($i+1)."</td>
					<td>".$afiliados[$i]->creacion."</td>
					<td>".$afiliados[$i]->usuario."</td>
					<td>".$afiliados[$i]->nombre."</td>
					<td>".$afiliados[$i]->apellido."</td>
					<td>".$afiliados[$i]->nacimiento."</td>
					<td>".$afiliados[$i]->sexo."</td>
					<td>".$afiliados[$i]->edo_civil."</td>
				</tr>";
			}
				
			
			echo "</tbody>
			</table><tr class='odd' role='row'>";
		
		
	}
	function reporte_afiliados_excel()
	{
		//load our new PHPExcel library
		$this->load->library('excel');
		$this->excel=PHPExcel_IOFactory::load(FCPATH."/application/third_party/templates/reporte-af.xls");
		$id=$this->tank_auth->get_user_id();
		$red=$this->modelo_compras->get_red($id);
		$afiliados=$this->modelo_compras->reporte_afiliados($red[0]->id_red);
		for($i=0;$i<sizeof($afiliados);$i++)
		{
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, ($i+8), ($i+1));
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, ($i+8), $afiliados[$i]->creacion);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, ($i+8), $afiliados[$i]->usuario);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, ($i+8), $afiliados[$i]->nombre);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, ($i+8), $afiliados[$i]->apellido);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, ($i+8), $afiliados[$i]->nacimiento);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, ($i+8), $afiliados[$i]->sexo);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, ($i+8), $afiliados[$i]->edo_civil);
		}
		
		$filename='afiliados_nuevos.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
	function reporte_compras_usr()
	{
		$id=$this->tank_auth->get_user_id();
		$data=$_GET["info"];
		$data=json_decode($data,true);
		$fecha_ini=str_replace('.', '-', $data['inicio']);
		$fecha_fin=str_replace('.', '-', $data['fin']);
		$ano_ini=substr($fecha_ini, 6);
		$mes_ini=substr($fecha_ini, 3,2);
		$dia_ini=substr($fecha_ini, 0,2);
		$ano_fin=substr($fecha_fin, 6);
		$mes_fin=substr($fecha_fin, 3,2);
		$dia_fin=substr($fecha_fin, 0,2);
		$inicio=$ano_ini.'-'.$mes_ini.'-'.$dia_ini;
		$fin=$ano_fin.'-'.$mes_fin.'-'.$dia_fin;
		$ventas=$this->modelo_compras->get_compras_usr($inicio,$fin,$id);
			echo 
			"<table id='datatable_fixed_column2' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th>ID</th>
					<th>Fecha</th>
					<th>Costo</th>
					<th>Estatus</th>
					<th>Usuario</th>
					<th>Mas...</th>
				</thead>
				<tbody>";
				
			for($i=0;$i<sizeof($ventas);$i++)
			{
					echo "<tr>
					<td class='sorting_1'>".($i+1)."</td>
					<td>".$ventas[$i]->fecha."</td>
					<td>".$ventas[$i]->costo."</td>
					<td>".$ventas[$i]->descripcion."</td>
					<td>".$ventas[$i]->username."</td>
					<td>
					</td>
					
				</tr>";
			}
			echo "</tbody>
			</table><tr class='odd' role='row'>";
		
		
	}
	function reporte_compras_usr_well()
	{
		$data=$_GET["info"];
		$data=json_decode($data,true);
		$fecha_ini=str_replace('.', '-', $data['inicio']);
		$fecha_fin=str_replace('.', '-', $data['fin']);
		$ano_ini=substr($fecha_ini, 6);
		$mes_ini=substr($fecha_ini, 3,2);
		$dia_ini=substr($fecha_ini, 0,2);
		$ano_fin=substr($fecha_fin, 6);
		$mes_fin=substr($fecha_fin, 3,2);
		$dia_fin=substr($fecha_fin, 0,2);
		$inicio=$ano_ini.'-'.$mes_ini.'-'.$dia_ini;
		$fin=$ano_fin.'-'.$mes_fin.'-'.$dia_fin;
		echo '<div class="row">
				<form class="smart-form" id="reporte-form" method="post">
					
					<div class="row" >
						<section class="col col-lg-6 col-md-6 hidden-sm hidden-xs">
							
						</section>
						<section class="col col-lg-3 col-md-3 col-sm-6 col-xs-12">
							
							<label class="input">
								<a id="imprimir-2" href="reporte_compras_usr_excel?inicio='.$inicio.'&fin='.$fin.'" class="btn btn-primary col-xs-12 col-lg-12 col-md-12 col-sm-12"><i class="fa fa-print"></i>&nbsp;Crear excel</a>
							</label>
						</section>
						<section class="col col-lg-3 col-md-3 col-sm-6 col-xs-12">
							
							<label class="input">
								<a id="imprimir-2" onclick="window.print()" class="btn btn-success col-xs-12 col-lg-12 col-md-12 col-sm-12"><i class="fa fa-print"></i>&nbsp;Imprimir</a>
							</label>
						</section>
						
					</div>
				</form>
			</div>';
	}
	function reporte_compras_red_well()
	{
		$data=$_GET["info"];
		$data=json_decode($data,true);
		$fecha_ini=str_replace('.', '-', $data['inicio']);
		$fecha_fin=str_replace('.', '-', $data['fin']);
		$ano_ini=substr($fecha_ini, 6);
		$mes_ini=substr($fecha_ini, 3,2);
		$dia_ini=substr($fecha_ini, 0,2);
		$ano_fin=substr($fecha_fin, 6);
		$mes_fin=substr($fecha_fin, 3,2);
		$dia_fin=substr($fecha_fin, 0,2);
		$inicio=$ano_ini.'-'.$mes_ini.'-'.$dia_ini;
		$fin=$ano_fin.'-'.$mes_fin.'-'.$dia_fin;
		echo '<div class="row">
				<form class="smart-form" id="reporte-form" method="post">
					
					<div class="row" >
						<section class="col col-lg-6 col-md-6 hidden-sm hidden-xs">
							
						</section>
						<section class="col col-lg-3 col-md-3 col-sm-6 col-xs-12">
							
							<label class="input">
								<a id="imprimir-2" href="reporte_compras_red_excel?inicio='.$inicio.'&fin='.$fin.'" class="btn btn-primary col-xs-12 col-lg-12 col-md-12 col-sm-12"><i class="fa fa-print"></i>&nbsp;Crear excel</a>
							</label>
						</section>
						<section class="col col-lg-3 col-md-3 col-sm-6 col-xs-12">
							
							<label class="input">
								<a id="imprimir-2" onclick="window.print()" class="btn btn-success col-xs-12 col-lg-12 col-md-12 col-sm-12"><i class="fa fa-print"></i>&nbsp;Imprimir</a>
							</label>
						</section>
						
					</div>
				</form>
			</div>';
	}
	function reporte_compras_usr_excel()
	{
		$id=$this->tank_auth->get_user_id();
		//load our new PHPExcel library
		$this->load->library('excel');
		$this->excel=PHPExcel_IOFactory::load(FCPATH."/application/third_party/templates/reporte_usr.xls");
		$ventas=$this->modelo_compras->get_compras_usr($_GET['inicio'],$_GET['fin'],$id);
		for($i=0;$i<sizeof($ventas);$i++)
		{
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, ($i+8), ($i+1));
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, ($i+8), $ventas[$i]->fecha);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, ($i+8), $ventas[$i]->costo);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, ($i+8), $ventas[$i]->descripcion);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, ($i+8), $ventas[$i]->username);
		}
		
		$filename='compras_usuario.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');	
	}
	function reporte_compras()
	{
		$data=$_GET["info"];
		$data=json_decode($data,true);
		$fecha_ini=str_replace('.', '-', $data['inicio']);
		$fecha_fin=str_replace('.', '-', $data['fin']);
		$ano_ini=substr($fecha_ini, 6);
		$mes_ini=substr($fecha_ini, 3,2);
		$dia_ini=substr($fecha_ini, 0,2);
		$ano_fin=substr($fecha_fin, 6);
		$mes_fin=substr($fecha_fin, 3,2);
		$dia_fin=substr($fecha_fin, 0,2);
		$inicio=$ano_ini.'-'.$mes_ini.'-'.$dia_ini;
		$fin=$ano_fin.'-'.$mes_fin.'-'.$dia_fin;
		$id=$this->tank_auth->get_user_id();
		$red=$this->modelo_compras->get_red($id);
		$ventas=$this->modelo_compras->get_compras($inicio,$fin,$red[0]->id_red);
			echo 
			"<table id='datatable_fixed_column3' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th>ID</th>
					<th>Fecha</th>
					<th>Costo</th>
					<th>Estatus</th>
					<th>Usuario</th>
					<th>Mas...</th>
				</thead>
				<tbody>";
				
			for($i=0;$i<sizeof($ventas);$i++)
			{
					echo "<tr>
					<td class='sorting_1'>".($i+1)."</td>
					<td>".$ventas[$i]->fecha."</td>
					<td>".$ventas[$i]->costo."</td>
					<td>".$ventas[$i]->descripcion."</td>
					<td>".$ventas[$i]->username."</td>
					<td>
					</td>
					
				</tr>";
			}
			echo "</tbody>
			</table><tr class='odd' role='row'>";
		
		
	}
	function reporte_compras_red_excel()
	{
		//load our new PHPExcel library
		$this->load->library('excel');
		$this->excel=PHPExcel_IOFactory::load(FCPATH."/application/third_party/templates/reporte_red.xls");
		$id=$this->tank_auth->get_user_id();
		$red=$this->modelo_compras->get_red($id);
		$ventas=$this->modelo_compras->get_compras($_GET['inicio'],$_GET['fin'],$red[0]->id_red);
		for($i=0;$i<sizeof($ventas);$i++)
		{
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, ($i+8), ($i+1));
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, ($i+8), $ventas[$i]->fecha);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, ($i+8), $ventas[$i]->costo);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, ($i+8), $ventas[$i]->descripcion);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, ($i+8), $ventas[$i]->username);
		}
		
		$filename='compras_red.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');	
	}
	function muestra_mercancia()
	{
		$data=$_GET["info"];
		$data=json_decode($data,true);
		$id=$data['id'];
		$imagenes=$this->modelo_compras->get_imagenes($id);
		echo'<div class="row">';
		echo '<div class="col-lg-6 col-md-6 col-xs-6 col-sm-6" style="text-align:center;">';
		for($m=0;$m<sizeof($imagenes);$m++)
			{
				echo"
					<p><img class='col-lg-12 col-md-12 col-xs-12 col-sm-12' src='".$imagenes[$m]->url."'></p><br></br>";
			}
		echo '</div>';
		switch($data['tipo'])
		{
			case 1:
				$detalles=$this->modelo_compras->detalles_productos_red($id);
				echo "	<div class='col-lg-6 col-md-6 col-xs-6 col-sm-6'>
							<h3 class='text-primary'>".$detalles[0]->nombre."</h3>
					";
							if($detalles[0]->costo_publico)
							{
								echo"
									<p class='font-sm'>Precio Publico: ".$detalles[0]->costo_publico."</p>";
							}
							if($detalles[0]->costo)
							{
								echo"
									<p class='font-sm'>Precio Afiliado: ".$detalles[0]->costo."</p>";
							}
							if($detalles[0]->puntos_comisionables)
							{
								echo"
									<p class='font-sm'>Puntos: ".$detalles[0]->puntos_comisionables."</p>";
							}
							if($detalles[0]->descripcion)
							{
								echo"
									<textarea style='margin-top: 2rem;margin-left: -24rem;' class='font-sm' readonly>".$detalles[0]->descripcion."</textarea>";
							}

				break;
			case 2:
				$detalles=$this->modelo_compras->detalles_servicios_red($id);
				
						echo "	<div class='col-lg-6 col-md-6 col-xs-6 col-sm-6'>
							<h3 class='text-primary'>".$detalles[0]->nombre."</h3>
					";
							if($detalles[0]->costo_publico)
							{
								echo"
									<p class='font-sm'>Precio Publico: ".$detalles[0]->costo_publico."</p>";
							}
							if($detalles[0]->costo)
							{
								echo"
									<p class='font-sm'>Precio Afiliado: ".$detalles[0]->costo."</p>";
							}
							if($detalles[0]->puntos_comisionables)
							{
								echo"
									<p class='font-sm'>Puntos: ".$detalles[0]->puntos_comisionables."</p>";
							}
							if($detalles[0]->descripcion)
							{
								echo"
									<textarea style='margin-top: 2rem;margin-left: -24rem;' class='font-sm' readonly>".$detalles[0]->descripcion."</textarea>";
							}
				break;
			case 3:
				$detalles=$this->modelo_compras->detalles_combinados($id);
				$comb=$this->modelo_compras->comb_espec($id);
				echo "	<div class='col-lg-6 col-md-6 col-xs-6 col-sm-6'>
							<h3 class='text-primary'>".$comb[0]->nombre."</h3>
							
							<p class='font-sm'>".$comb[0]->descripcion."</p><br>";
				foreach($detalles as $det)
				{
				echo "		<p class='font-sm'><strong>".$det["merc"]."(".$det["qty"].")</strong></p>";
				}
				break;
			case 4:
				$detalles=$this->modelo_compras->detalles_prom_prod($id);
				echo "	<div class='col-lg-6 col-md-6 col-xs-6 col-sm-6'>
							<h3 class='text-primary'>".$detalles[0]->nombre."</h3>
							
							<p class='font-sm'>".$detalles[0]->descripcion."</p></br>
							<p class='font-sm'>".$detalles[0]->producto."</p>";
							if($detalles[0]->peso)
							{
								echo"
									<p class='font-sm'>Peso: ".$detalles[0]->peso."</p>";
							}
							if($detalles[0]->alto)
							{
								echo"
									<p class='font-sm'>Alto: ".$detalles[0]->alto."</p>";
							}
							if($detalles[0]->ancho)
							{
								echo"
									<p class='font-sm'>Ancho: ".$detalles[0]->ancho."</p>";
							}
							if($detalles[0]->profundidad)
							{
								echo"
									<p class='font-sm'>Profundiad: ".$detalles[0]->profundidad."</p>";
							}
							if($detalles[0]->diametro)
							{
								echo"
									<p class='font-sm'>Diametro: ".$detalles[0]->diametro."</p><br>";
							}
				break;
			case 5:
				$detalles=$this->modelo_compras->detalles_prom_serv($id);
				echo "	<div class='col-lg-6 col-md-6 col-xs-6 col-sm-6'>
							<h3 class='text-primary'>".$detalles[0]->nombre."</h3>
							
							<p class='font-sm'>".$detalles[0]->descripcion."</p></br>
							<p class='font-sm'>".$detalles[0]->servicio."</p>";
							if($detalles[0]->fecha_inicio)
							{
								echo"
									<p class='font-sm'>Fecha Inicio: ".$detalles[0]->fecha_inicio."</p>";
							}
							if($detalles[0]->fecha_fin)
							{
								echo"
									<p class='font-sm'>Fecha Fin: ".$detalles[0]->fecha_fin."</p><br>";
							}
				break;
			case 6:
				$detalles=$this->modelo_compras->detalles_prom_comb($id);
				echo "	<div class='col-lg-6 col-md-6 col-xs-6 col-sm-6'>
							<h3 class='text-primary'>".$detalles[0]->nombre."</h3>
							
							<p class='font-sm'>".$detalles[0]->descripcion."</p></br>
							<p class='font-sm'><strong>".$detalles[0]->combinado."</strong></p></br>
							<p class='font-sm'>".$detalles[0]->producto."</p><p>+</p>
							<p class='font-sm'>".$detalles[0]->servicio."</p>";
							
				break;
			default:
				echo 'EL REGISTRO HA SIDO BORRADO';
				break;
		}
			echo"
			</div> 
		</div>";
	}
	function add_carrito()
	{
		$carrito_item=0;
		foreach ($this->cart->contents() as $items) 
		{
			$carrito_item++;
		}
		if($carrito_item>=6)
		{
			echo "Ha alcanzado el limite de productos por compra";
		}
		else
		{
			$data=$_GET["info"];
			$data=json_decode($data,true);
			$id=$data['id'];	
			if($data['tipo']=='1')
					{
						$limites=$this->modelo_compras->get_limite_prod($id);
						$min=$limites[0]->min_venta;
						$max=$limites[0]->max_venta;
					}
					else
					{
						$min=0;
						$max=10;
					}
			echo "<form id='comprar'  method='post' action=''>
				<div class='row'>
					<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
						<p class='font-md'><strong>Cantidad</strong></p><br><input type='number' id='cantidad' name='cantidad' min='".$min."' max='".$max."'><br><br>
					</div>
				</div>";
			echo "<div class='row'><br><a class='btn btn-success' onclick='comprar(".$id.",".$data['tipo'].",".$data['desc'].",".$min.",".$max.")'><i class='fa fa-shopping-cart'></i> A&ntilde;adir al carrito</a></div>
			</form>";
		}
	}
	function add_merc()
	{
		$data=$_GET["info"];
		$data=json_decode($data,true);
		$id=$data['id'];
		
		$cantidad_disp=$this->modelo_compras->get_cantidad_almacen($id);
	
		if(!isset($cantidad_disp[0]->cantidad)  && ($data['tipo'] == '1') && $cantidad_disp[0]->cantidad*1<$data['qty']*1)
		{
			echo "Error";
		}
		else 
		{
				switch($data['tipo'])
				{
					case 1:
						$detalles=$this->modelo_compras->detalles_productos($id);
						$costo_ini=$detalles[0]->costo*(1-$data['desc']);
						$costo_total=$costo_ini;
						
						$add_cart = array(
				           'id'      => $id,
				           'qty'     => $data['qty'],
				           'price'   => $costo_total,
				           'name'    => $data['tipo'],
				           'options' => array(	'prom_id' => 0, 'time' => time())
			        		);
						break;
						
					case 2:
						$detalles=$this->modelo_compras->detalles_servicios($id);
						$costo_ini=$detalles[0]->costo*(1-$data['desc']);
						$costo_total=$costo_ini;
						
						$add_cart = array(
				           'id'      => $id,
				           'qty'     => $data['qty'],
				           'price'   => $costo_total,
				           'name'    => $data['tipo'],
				           'options' => array(	'prom_id' => 0, 'time' => time())
			        		);
						break;
						
					case 3:
						$detalles=$this->modelo_compras->detalles_combinados($id);
						$comb=$this->modelo_compras->comb_espec($id);
						$costo_q=$this->modelo_compras->costo_merc($id);
						$costo_ini=$costo_q[0]->costo*(1-$data['desc']);
						$costo_total=$costo_ini;
						
						$add_cart = array(
				           'id'      => $id,
				           'qty'     => $data['qty'],
				           'price'   => $costo_total,
				           'name'    => $data['tipo'],
				           'options' => array(	'prom_id' => 0, 'time' => time())
			        		);
						break;
					case 4:
						$detalles=$this->modelo_compras->detalles_prom_prod($id);
						$costo_ini=$detalles[0]->costo*(1-($detalles[0]->prom_costo/100));
						$costo_total=$costo_ini;
						
						$add_cart = array(
				           'id'      => $detalles[0]->id,
				           'qty'     => $data['qty'],
				           'price'   => $costo_total,
				           'name'    => $data['tipo'],
				           'options' => array(	'prom_id' => $detalles[0]->id_promocion, 'time' => time())
			        		);
						break;
					case 5:
						$detalles=$this->modelo_compras->detalles_prom_serv($id);
						$costo_ini=$detalles[0]->costo*(1-($detalles[0]->prom_costo/100));
						$costo_total=$costo_ini;
						
						$add_cart = array(
				           'id'      => $detalles[0]->id,
				           'qty'     => $data['qty'],
				           'price'   => $costo_total,
				           'name'    =>	$data['tipo'],
				           'options' => array(	'prom_id' => $detalles[0]->id_promocion, 'time' => time())
			        		);
						break;
					case 6:
						$detalles=$this->modelo_compras->detalles_prom_comb($id);
						$costo_ini=$detalles[0]->costo*(1-($detalles[0]->prom_costo/100));
						$costo_total=$costo_ini;
						
						$add_cart = array(
				           'id'      => $detalles[0]->id,
				           'qty'     => $data['qty'],
				           'price'   => $costo_total,
				           'name'    => $data['tipo'],
				           'options' => array(	'prom_id' => $detalles[0]->id_promocion, 'time' => time())
			        		);
						break;
					default:
						echo 'LA MERCANCIA YA NO ESTA DISPONIBLE';
						break;
				}
				$this->cart->insert($add_cart);
				echo ' <div class="navbar-header">
					      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only"> Toggle navigation </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> </button>
					      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cart"> <i class="fa fa-shopping-cart colorWhite"> </i> <span class="cartRespons colorWhite"> Cart ('.$this->cart->total_items().') </span> </button>
					      <a class="navbar-brand titulo_carrito" href="/ov/dashboard"> Dashboard &nbsp;</a> 
					      
					      <!-- this part for mobile -->
					      <div class="search-box pull-right hidden-lg hidden-md hidden-sm">
					        <div class="input-group">
					          <button class="btn btn-nobg getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
					        </div>
					        <!-- /input-group --> 
					        
					      </div>
					    </div>';
				echo '<div class="cartMenu  hidden-lg col-xs-12 hidden-md hidden-sm ">
		        <div class="w100 miniCartTable scroll-pane">
		          <table  >
		            <tbody>';
		            	 
		                  	if($this->cart->contents())
							{ 
								foreach ($this->cart->contents() as $items) 
								{
									$total=$items['qty']*$items['price'];	
									$imgn=$this->modelo_compras->get_img($items['id']);
									switch($items['name'])
									{
										case 1:
											$detalles=$this->modelo_compras->detalles_productos($items['id']);
											break;
										case 2:
											$detalles=$this->modelo_compras->detalles_servicios($items['id']);
											break;
										case 3:
											$detalles=$this->modelo_compras->comb_espec($items['id']);
											break;
										case 4:
											$detalles=$this->modelo_compras->detalles_prom_prod($items['id']);
											break;
										case 5:
											$detalles=$this->modelo_compras->detalles_prom_serv($items['id']);
											break;
										case 6:
											$detalles=$this->modelo_compras->detalles_prom_comb($items['id']);
											break;
									}
									echo '<tr class="miniCartProduct"> 
											<td style="width:20%" class="miniCartProductThumb"><div> <a href="#"> <img src="'.$imgn[0]->url.'" alt="img"> </a> </div></td>
											<td style="width:40%"><div class="miniCartDescription">
						                        <h4> <a href="product-details.html"> '.$detalles[0]->nombre.'</a> </h4>
						                        <div class="price"> <span>$ '.$items['price'].' </span> </div>
						                      </div></td>
						                    <td  style="width:10%" class="miniCartQuantity"><a > X '.$items['qty'].' </a></td>
						                    <td  style="width:15%" class="miniCartSubtotal"><span>'.$total.'</span></td>
						                    <td  style="width:5%" class="delete"><a onclick="quitar_producto(\''.$items['rowid'].'\')"> x </a></td>
										</tr>'; 
								} 
							}            
		         echo   '</tbody>
		          </table>
		        </div>
		        <!--/.miniCartTable-->
		        
		        <div class="miniCartFooter  miniCartFooterInMobile text-right">
		          <h3 class="text-right subtotal"> Subtotal: $'.$this->cart->total().' </h3>
		          <a class="btn btn-sm btn-danger" onclick="ver_cart()"> <i class="fa fa-shopping-cart"> </i> VER CARRITO </a> <a class="btn btn-sm btn-primary" onclick="a_comprar()"> COMPRAR! </a> </div>
		        <!--/.miniCartFooter--> 
		        
		      </div>';
				echo '</div>
		    <!--/.navbar-cart-->
		    
		    <div class="navbar-collapse collapse">
		      <ul class="nav navbar-nav">
		        <li class="active"> <a onclick="show_todos()"> Todos </a> </li>
		        <li class="dropdown megamenu-fullwidth"> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_prod()"> Productos </a></li>
		        
		        <!-- change width of megamenu = use class > megamenu-fullwidth, megamenu-60width, megamenu-40width -->
		        <li class="dropdown megamenu-80width "> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_serv()"> Servicios </a></li>
		        <li class="dropdown megamenu-fullwidth"> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_comb()"> Combinados </a></li>
		        <li class="dropdown megamenu-fullwidth"> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_prom()"> Promociones </a></li>
		      </ul>
		      
		      <!--- this part will be hidden for mobile version -->
		      <div class="nav navbar-nav navbar-right hidden-xs" >
		        <div class="dropdown  cartMenu "> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
		        	<i class="fa fa-shopping-cart"> </i> 
		        	<span class="cartRespons"> Cart ('.$this->cart->total_items().') 
		        	</span> <b class="caret"> </b> </a>
		          	<div class="dropdown-menu col-lg-4 col-xs-12 col-md-4 ">
		            	<div class="w100 miniCartTable scroll-pane">
			              	<table>
			                	<tbody>';
			                  
			                 	foreach ($this->cart->contents() as $items) 
								{
									$total=$items['qty']*$items['price'];	
									$imgn=$this->modelo_compras->get_img($items['id']);
									if(isset($imgn[0]->url))
									{
										$imagen=$imgn[0]->url;
									}
									else
									{
										$imagen="";
									}
									switch($items['name'])
									{
										case 1:
											$detalles=$this->modelo_compras->detalles_productos($items['id']);
											break;
										case 2:
											$detalles=$this->modelo_compras->detalles_servicios($items['id']);
											break;
										case 3:
											$detalles=$this->modelo_compras->comb_espec($items['id']);
											break;
										case 4:
											$detalles=$this->modelo_compras->detalles_prom_prod($items['id']);
											break;
										case 5:
											$detalles=$this->modelo_compras->detalles_prom_serv($items['id']);
											break;
										case 6:
											$detalles=$this->modelo_compras->detalles_prom_comb($items['id']);
											break;
									}
									echo '<tr class="miniCartProduct"> 
											<td style="width:20%" class="miniCartProductThumb"><div> <a href="#"> <img src="'.$imagen.'" alt="img"> </a> </div></td>
											<td style="width:40%"><div class="miniCartDescription">
						                        <h4> <a href="product-details.html"> '.$detalles[0]->nombre.'</a> </h4>
						                        <div class="price"> <span> '.$items['price'].' </span> </div>
						                      </div></td>
						                    <td  style="width:10%" class="miniCartQuantity"><a > X '.$items['qty'].' </a></td>
						                    <td  style="width:15%" class="miniCartSubtotal"><span>'.$total.'</span></td>
						                    <td  style="width:5%" class="delete"><a onclick="quitar_producto(\''.$items['rowid'].'\')"> x </a></td>
										</tr>'; 
								} 
			                  
			                echo '</tbody>
			              </table>
		            	</div>
		            <!--/.miniCartTable-->
		            
			            <div class="miniCartFooter text-right">
			              <h3 class="text-right subtotal"> Subtotal: $ '.$this->cart->total().' </h3>
			              <a class="btn btn-sm btn-danger" onclick="ver_cart()"> <i class="fa fa-shopping-cart"> </i> VER CARRITO </a> <a class="btn btn-sm btn-primary" onclick="a_comprar()"> COMPRAR! </a> </div>
			            <!--/.miniCartFooter--> 
		            
		          		</div>
		          <!--/.dropdown-menu--> 
		        	</div> 
		        <!--/.cartMenu--> 
		        
		        <div class="search-box">
		          <div class="input-group"> 
		            <button class="btn btn-nobg getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
		          </div>
		          <!-- /input-group --> 
		          
		        </div>
		        <!--/.search-box --> ';
			
		}
		
	} 
	
	function ver_carrito()
	{
		if($this->cart->contents())
		{
			echo '<div class="row" id="contenido_carro">
					<div class="col-lg-12 col-md-12 col-sm-12">
				      <div class="row userInfo">
				        <div class="col-xs-12 col-sm-12">
				          <div class="cartContent w100">
				            <table class="cartTable table-responsive" style="width:100%">
				              <tbody>
				              
				                <tr class="CartProduct cartTableHeader">
				                  <td style="width:15%"  > Product </td>
				                  <td style="width:40%"  >Details</td>
				                  <td style="width:10%"  class="delete">&nbsp;</td>
				                  <td style="width:10%" >QNT</td>
				                  <td style="width:10%" >Discount</td>
				                  <td style="width:15%" >Total</td>
				                </tr>';
				               foreach ($this->cart->contents() as $items) 
								{
									
									$total=$items['qty']*$items['price'];	
									$imgn=$this->modelo_compras->get_img($items['id']);
									if(isset($imgn[0]->url))
									{
										$imagen=$imgn[0]->url;
									}
									else
									{
										$imagen="";
									}
									switch($items['name'])
									{
										case 1:
											$detalles=$this->modelo_compras->detalles_productos($items['id']);
											break;
										case 2:
											$detalles=$this->modelo_compras->detalles_servicios($items['id']);
											break;
										case 3:
											$detalles=$this->modelo_compras->comb_espec($items['id']);
											break;
										case 4:
											$detalles=$this->modelo_compras->detalles_prom_prod($items['id']);
											break;
										case 5:
											$detalles=$this->modelo_compras->detalles_prom_serv($items['id']);
											break;
										case 6:
											$detalles=$this->modelo_compras->detalles_prom_comb($items['id']);
											break;
									}
									echo '<tr class="CartProduct">
											<td  class="CartProductThumb">
												<div> 
													<a href="#"><img src="'.$imagen.'" alt="img"></a> 
												</div>
											</td>
											<td >
												<div class="CartDescription">
							                      <h4> <a href="product-details.html">'.$detalles[0]->nombre.'</a> </h4>
							                   
							                      <div class="price"> <span>$'.$items['price'].'</span></div>
							                    </div>
							                </td>
							                <td class="delete"><a title="Delete" onclick="quitar_producto(\''.$items['rowid'].'\')"> <i class="glyphicon glyphicon-trash fa-2x"></i></a></td>
							                <td >'.$items['qty'].'</td>
							                <td >0</td>
							                <td class="price">$'.$total.'</td>
											
										</tr>';
								}
				                
				               echo ' </tbody>
						            </table>
						          </div>
						          <!--cartContent-->
						          
						        </div>
						      </div>
						      <!--/row end--> 
						      
						    </div>
						   </div>';
				
			}						
		else
		{
			echo 'NO HAY PRODUCTOS EN EL CARRITO';	
		}
		//print_r($this->cart->contents());
	}
	function show_productos()
	{
		
		$prod=$this->modelo_compras->get_productos();
		for($i=0;$i<sizeof($prod);$i++)
		{
			$imagen=$this->modelo_compras->get_img($prod[$i]->id);
			if(isset($imagen[0]))
			{
				$prod[$i]->img=$imagen[0]->url;
			}
			else 
			{
				$prod[$i]->img="";
			}
		}
		//$prom=$this->modelo_compras->get_promocion();
		$grupos=$this->modelo_compras->get_grupo_prod();
		echo '<div class="row">
				<div class="well" style="background-color:transparent;border:none;">
					<article>
						<section class="pull-right">
							<label class="select">
								<select class="input-sm" id="grupo_prod" onchange="show_grupo_prod()">
									<option value="0">Seleccione un grupo</option>';
									for($k=0;$k<sizeof($grupos);$k++)
									{
										echo '	<option value="'.$grupos[$k]->id_grupo.'">'.$grupos[$k]->descripcion.'</option>';
									}
									
								echo '</select>
							</label>
						</section>
					</article>
				</div>
			</div>';
		for($productos=0;$productos<sizeof($prod);$productos++)
		{

				echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$prod[$productos]->id.',1)"><img src="'.$prod[$productos]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">   </div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$prod[$productos]->nombre.'</a></h4>
				              		<p>'.$prod[$productos]->grupo.' </br></br>
				              		'.$prod[$productos]->descripcion.'. </p>
				              		
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$prod[$productos]->costo.'</span></div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prod[$productos]->id.',1,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';

							
		}
	}
	function show_prod_grup()
	{
		$prod=$this->modelo_compras->get_grupo_productos($_GET['grupo']);
		for($i=0;$i<sizeof($prod);$i++)
		{
			$imagen=$this->modelo_compras->get_img($prod[$i]->id);
			if(isset($imagen[0]))
			{
				$prod[$i]->img=$imagen[0]->url;
			}
			else 
			{
				$prod[$i]->img="";
			}
		}
		//$prom=$this->modelo_compras->get_promocion();
		$grupos=$this->modelo_compras->get_grupo_prod();
		echo '<div class="row">
				<div class="well" style="background-color:transparent;border:none;">
					<article>
						<section class="pull-right">
							<label class="select">
								<select class="input-sm" id="grupo_prod" onchange="show_grupo_prod()">
									<option value="0">Seleccione un grupo</option>';
									for($k=0;$k<sizeof($grupos);$k++)
									{
										echo '	<option value="'.$grupos[$k]->id_grupo.'">'.$grupos[$k]->descripcion.'</option>';
									}
									
								echo '</select>
							</label>
						</section>
					</article>
				</div>
			</div>';
		for($productos=0;$productos<sizeof($prod);$productos++)
		{

				echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$prod[$productos]->id.',1)"><img src="'.$prod[$productos]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">   </div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$prod[$productos]->nombre.'</a></h4>
				              		<p>'.$prod[$productos]->grupo.' </br></br>
				              		'.$prod[$productos]->descripcion.'. </p>
				              		
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$prod[$productos]->costo.'</span></div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prod[$productos]->id.',1,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';

							
		}
	}
	function show_servicios()
	{
		$serv=$this->modelo_compras->get_servicios();
		for($j=0;$j<sizeof($serv);$j++)
		{
			$imagen=$this->modelo_compras->get_img($serv[$j]->id);
			if(isset($imagen[0]))
			{
				$serv[$j]->img=$imagen[0]->url;
			}
			else 
			{
				$serv[$j]->img="";
			}
		}
		//$prom=$this->modelo_compras->get_promocion();
		for($servicios=0;$servicios<sizeof($serv);$servicios++)
		{
			$impuesto = $this->modelo_compras->ImpuestoMercancia($serv[$servicios]->id, $serv[$servicios]->costo);
			echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$serv[$servicios]->id.',2)"><img src="'.$serv[$servicios]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">  </div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$serv[$servicios]->nombre.'</a></h4>
				              		<p>'.$serv[$servicios]->descripcion.'.</p>
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$serv[$servicios]->costo+$impuesto.'</span> </div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$serv[$servicios]->id.',2,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';
		}
	}
	function show_promocion()
	{
		$prom_p=$this->modelo_compras->get_promocion_prod();
		for($n=0;$n<sizeof($prom_p);$n++)
		{
			$imagen=$this->modelo_compras->get_img_prom($prom_p[$n]->id_promocion);
			if(isset($imagen[0]))
			{
				$prom_p[$n]->img=$imagen[0]->url;
			}
			else 
			{
				$prom_p[$n]->img="";
			}
		}
		$prom_s=$this->modelo_compras->get_promocion_serv();
		for($m=0;$m<sizeof($prom_s);$m++)
		{
			$imagen=$this->modelo_compras->get_img_prom($prom_s[$m]->id_promocion);
			if(isset($imagen[0]))
			{
				$prom_s[$m]->img=$imagen[0]->url;
			}
			else 
			{
				$prom_s[$m]->img="";
			}
		}
		$prom_c=$this->modelo_compras->get_promocion_comb();
		for($l=0;$l<sizeof($prom_c);$l++)
		{
			$imagen=$this->modelo_compras->get_img_prom($prom_c[$l]->id_promocion);
			if(isset($imagen[0]))
			{
				$prom_c[$l]->img=$imagen[0]->url;
			}
			else 
			{
				$prom_c[$l]->img="";
			}
		}
		for($promocion_p=0;$promocion_p<sizeof($prom_p);$promocion_p++)
		{
			echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$prom_p[$promocion_p]->id_promocion.',4)"><img src="'.$prom_p[$promocion_p]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">  </div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$prom_p[$promocion_p]->nombre.'</a></h4>
				              		<p>'.$prom_p[$promocion_p]->descripcion.'.
				              		</br></br>Producto</br>'.$prom_p[$promocion_p]->producto.'</p>
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$prom_p[$promocion_p]->costo*(1-($prom_p[$promocion_p]->prom_costo/100)).'</span> </div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prom_p[$promocion_p]->id_promocion.',4,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';
		}
		for($promocion_s=0;$promocion_s<sizeof($prom_s);$promocion_s++)
		{
			echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$prom_s[$promocion_s]->id_promocion.',5)"><img src="'.$prom_s[$promocion_s]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">  </div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$prom_s[$promocion_s]->nombre.'</a></h4>
				              		<p>'.$prom_s[$promocion_s]->descripcion.'.
				              		</br></br>Servicio</br>'.$prom_s[$promocion_s]->producto.'</p>
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$prom_s[$promocion_s]->costo*(1-($prom_s[$promocion_s]->prom_costo/100)).'</span> </div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prom_s[$promocion_s]->id_promocion.',5,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';
		}
		for($promocion_c=0;$promocion_c<sizeof($prom_c);$promocion_c++)
		{
			echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$prom_c[$promocion_c]->id_promocion.',6)"><img src="'.$prom_c[$promocion_c]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">  </div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$prom_c[$promocion_c]->nombre.'</a></h4>
				              		<p>'.$prom_c[$promocion_c]->descripcion.'.
				              		</br></br>Combinado</br>'.$prom_c[$promocion_c]->combinado.'</p>
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$prom_c[$promocion_c]->costo*(1-($prom_c[$promocion_c]->prom_costo/100)).'</span> </div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prom_c[$promocion_c]->id_promocion.',6,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';
		}
	}
	function show_combinados()
	{
		$comb=$this->modelo_compras->get_combinados();
		for($k=0;$k<sizeof($comb);$k++)
		{
			$imagen=$this->modelo_compras->get_img($comb[$k]->id);
			if(isset($imagen[0]))
			{
				$comb[$k]->img=$imagen[0]->url;
			}
			else 
			{
				$comb[$k]->img="";
			}
		}
		for($combinados=0;$combinados<sizeof($comb);$combinados++)
		{
			echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$comb[$combinados]->id.',3)"><img src="'.$comb[$combinados]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">  <span class="discount">'.$comb[$combinados]->descuento.'% DESCUENTO</span></div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$comb[$combinados]->nombre.'</a></h4>
				              		<p>'.$comb[$combinados]->descripcion.'
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$comb[$combinados]->costo.'</span> </div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$comb[$combinados]->id.',3,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';
		}
	}
	function show_todos()
	{
	$idRed=$_GET['id'];

		$prod=$this->modelo_compras->get_productos_red($idRed);
		for($i=0;$i<sizeof($prod);$i++)
		{
			$imagen=$this->modelo_compras->get_img($prod[$i]->id);
			if(isset($imagen[0]))
			{
				$prod[$i]->img=$imagen[0]->url;
			}
			else 
			{
				$prod[$i]->img="";
			}
		}
		$serv=$this->modelo_compras->get_servicios_red($idRed);
		for($j=0;$j<sizeof($serv);$j++)
		{
			$imagen=$this->modelo_compras->get_img($serv[$j]->id);
			if(isset($imagen[0]))
			{
				$serv[$j]->img=$imagen[0]->url;
			}
			else 
			{
				$serv[$j]->img="";
			}
		}
		$comb=$this->modelo_compras->get_combinados_red($idRed);
		for($k=0;$k<sizeof($comb);$k++)
		{
			$imagen=$this->modelo_compras->get_img($comb[$k]->id);
			if(isset($imagen[0]))
			{
				$comb[$k]->img=$imagen[0]->url;
			}
			else 
			{
				$comb[$k]->img="";
			}
		}/*
		$prom_p=$this->modelo_compras->get_promocion_prod();
		for($n=0;$n<sizeof($prom_p);$n++)
		{
			$imagen=$this->modelo_compras->get_img_prom($prom_p[$n]->id_promocion);
			if(isset($imagen[0]))
			{
				$prom_p[$n]->img=$imagen[0]->url;
			}
			else 
			{
				$prom_p[$n]->img="";
			}
		}
		$prom_s=$this->modelo_compras->get_promocion_serv();
		for($m=0;$m<sizeof($prom_s);$m++)
		{
			$imagen=$this->modelo_compras->get_img_prom($prom_s[$m]->id_promocion);
			if(isset($imagen[0]))
			{
				$prom_s[$m]->img=$imagen[0]->url;
			}
			else 
			{
				$prom_s[$m]->img="";
			}
		}
		$prom_c=$this->modelo_compras->get_promocion_comb();
		for($l=0;$l<sizeof($prom_c);$l++)
		{
			$imagen=$this->modelo_compras->get_img_prom($prom_c[$l]->id_promocion);
			if(isset($imagen[0]))
			{
				$prom_c[$l]->img=$imagen[0]->url;
			}
			else 
			{
				$prom_c[$l]->img="";
			}
		}*/
		//$prom=$this->modelo_compras->get_promocion();
		for($productos=0;$productos<sizeof($prod);$productos++)
		{
			
									echo '	<div class="item col-lg-3 col-md-3 col-sm-3 col-xs-3">
									    	<div class="producto">
										    	<a class="" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
										        	<i class=""></i>
										        </a>
									          
									          		<div class="image"> <a onclick="detalles('.$prod[$productos]->id.',1)"><img src="'.$prod[$productos]->img.'" alt="img" class="img-responsive"></a>
									              		<div class="promotion">   </div>
									            	</div>
									            	<div class="description">
									              		<h4><a href="">'.$prod[$productos]->nombre.'</a></h4>
     						              			</div>
									            	<div class="price"> <span>$ '.$prod[$productos]->costo.'</span></div>
									            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prod[$productos]->id.',1,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
									       </div>
								       </div>
								';

		}
		for($servicios=0;$servicios<sizeof($serv);$servicios++)
		{
				
								echo '	<div class="item col-lg-3 col-md-3 col-sm-3 col-xs-3">
									    	<div class="producto">
										    	<a class="" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
										        	<i class=""></i>
										        </a>
									          
									          		<div class="image"> <a onclick="detalles('.$serv[$servicios]->id.',2)"><img src="'.$serv[$servicios]->img.'" alt="img" class="img-responsive"></a>
									              		<div class="promotion">  </div>
									            	</div>
									            	<div class="description">
									              		<h4><a href="">'.$serv[$servicios]->nombre.'</a></h4>
									              	</div>
									            	<div class="price"> <span>$ '.($serv[$servicios]->costo).'</span> </div>
									            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$serv[$servicios]->id.',2,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
									       </div>
								       </div>
								';
		}
		for($combinados=0;$combinados<sizeof($comb);$combinados++)
		{
			
								echo '	<div class="item col-lg-3 col-md-3 col-sm-3 col-xs-3">
									    	<div class="producto">
										    	<a class="" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
										        	<i class=""></i>
										        </a>
									          
									          		<div class="image"> <a onclick="detalles('.$comb[$combinados]->id.',3)"><img src="'.$comb[$combinados]->img.'" alt="img" class="img-responsive"></a>
									              		<div class="promotion">  <span class="discount">'.$comb[$combinados]->descuento.'% DESCUENTO</span></div>
									            	</div>
									            	<div class="description">
									              		<h4><a href="">'.$comb[$combinados]->nombre.'</a></h4>
									              	</div>
									            	<div class="price"> <span>$ '.$comb[$combinados]->costo.'</span> </div>
									            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$comb[$combinados]->id.',3,'.$comb[$combinados]->descuento.')"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
									       </div>
								       </div> 
								';
		}/*
		for($promocion_p=0;$promocion_p<sizeof($prom_p);$promocion_p++)
		{
			echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$prom_p[$promocion_p]->id_promocion.',4)"><img src="'.$prom_p[$promocion_p]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">  </div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$prom_p[$promocion_p]->nombre.'</a></h4>
				              		<p>'.$prom_p[$promocion_p]->descripcion.'.
				              		</br></br>Producto</br>'.$prom_p[$promocion_p]->producto.'</p>
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$prom_p[$promocion_p]->costo*(1-($prom_p[$promocion_p]->prom_costo/100)).'</span> </div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prom_p[$promocion_p]->id_promocion.',4,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';
		}
		for($promocion_s=0;$promocion_s<sizeof($prom_s);$promocion_s++)
		{
			echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$prom_s[$promocion_s]->id_promocion.',5)"><img src="'.$prom_s[$promocion_s]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">  </div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$prom_s[$promocion_s]->nombre.'</a></h4>
				              		<p>'.$prom_s[$promocion_s]->descripcion.'.
				              		</br></br>Servicio</br>'.$prom_s[$promocion_s]->producto.'</p>
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$prom_s[$promocion_s]->costo*(1-($prom_s[$promocion_s]->prom_costo/100)).'</span> </div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prom_s[$promocion_s]->id_promocion.',5,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';
		}
		for($promocion_c=0;$promocion_c<sizeof($prom_c);$promocion_c++)
		{
			echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
				    	<div class="product">
					    	<a class="add-fav tooltipHere" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
					        	<i class="glyphicon glyphicon-heart"></i>
					        </a>
				          
				          		<div class="image"> <a onclick="detalles('.$prom_c[$promocion_c]->id_promocion.',6)"><img src="'.$prom_c[$promocion_c]->img.'" alt="img" class="img-responsive"></a>
				              		<div class="promotion">  </div>
				            	</div>
				            	<div class="description">
				              		<h4><a href="product-details.html">'.$prom_c[$promocion_c]->nombre.'</a></h4>
				              		<p>'.$prom_c[$promocion_c]->descripcion.'.
				              		</br></br>Combinado</br>'.$prom_c[$promocion_c]->combinado.'</p>
				              		
				              	</div>
				            	<div class="price"> <span>$ '.$prom_c[$promocion_c]->costo*(1-($prom_c[$promocion_c]->prom_costo/100)).'</span> </div>
				            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prom_c[$promocion_c]->id_promocion.',6,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
				       </div>
			       </div>
			';
		}*/
	}
	function buscar_servicio()
	{
		$buscar=$_GET['buscar'];
		$serv=$this->modelo_compras->get_servicio_espec($buscar);
		if($serv)
		{
			$fila=0;
			for($servicios=0;$servicios<sizeof($serv);$servicios++)
			{
				if($fila%4==0)
				{
					echo '<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">';
				}
				echo'<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 well div_merca" style="text-align:center; height:10%; ">
						<div class="row">
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="height:30%;">
								<img class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:30%;" src="'.$serv[$servicios]->ruta.'">
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
						</div>
						<p><h1><strong>'.$serv[$servicios]->nombre.'</strong></h1></p>
						
						<p><h3>$ '.$serv[$servicios]->costo.'</h3></p>
				
						<p><a class="btn btn-success btn-lg" href="javascript:void(0);" onclick="detalles('.$serv[$servicios]->id.',2)"><i class="fa fa-shopping-cart"></i>Añadir al carrito</a></p>
					</div>';
				$fila++;
				if($fila%4==0)
				{
					echo '</div>';
				}
				
			}
			if($fila%4!=0)
			{
				echo '</div>';
			}
		}
		else
		{
			echo'<p>NO HAY DATOS EN LA BUSQUEDA</p>';
		}
	}
	function buscar_producto()
	{
		$buscar=$_GET['buscar'];
		$prod=$this->modelo_compras->get_producto_espec($buscar);
		if($prod)
		{
			$fila=0;
			for($productos=0;$productos<sizeof($prod);$productos++)
			{
				if($fila%4==0)
				{
					echo '<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">';
				}
				echo'<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 well div_merca" style="text-align:center; height:20%;">
						<div class"row">
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="height:30%;">
								<img class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:30%;" src="'.$prod[$productos]->ruta.'">
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
						</div>
						<p><h1><strong>'.$prod[$productos]->nombre.'</strong></h1></p>
						
						<p><h3>$ '.$prod[$productos]->costo.'</h3></p>
						
						<p><a class="btn btn-success btn-lg" href="javascript:void(0);" onclick="detalles('.$prod[$productos]->id.',1)"><i class="fa fa-shopping-cart"></i>Añadir al carrito</a></p>
					</div>';
					$fila++;
				if($fila%4==0)
				{
					echo '</div>';
				}
				
			}
			if($fila%4!=0)
			{
				echo '</div>';
			}
		}
		else
		{
			echo'<p>NO HAY DATOS EN LA BUSQUEDA</p>';
		}
	}
	function buscar_combinado()
	{
		$buscar=$_GET['buscar'];
		$comb=$this->modelo_compras->get_combinado_espec($buscar);
		if($comb)
		{
			$fila=0;
			for($combinados=0;$combinados<sizeof($comb);$combinados++)
			{
				if($fila%4==0)
				{
					echo '<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">';
				}
				echo'<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 well div_merca" style="text-align:center; height:20%; ">
						<div class="row">
							<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1"></div>
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="height:30%;">
								<img class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:30%;" src="'.$comb[$combinados]->ruta.'">
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
						</div>
						<p><h1><strong>'.$comb[$combinados]->nombre.'</strong></h1></p>
						
						<p><h2>'.$comb[$combinados]->n_prod.' + '.$comb[$combinados]->n_serv.'</h2></p>
						
						<p><h3>$ '.$comb[$combinados]->costo.'</h3></p>
						
						<p><a class="btn btn-success btn-lg" href="javascript:void(0);" onclick="detalles('.$comb[$combinados]->id.',3)"><i class="fa fa-shopping-cart"></i>Añadir al carrito</a></p>
					</div>';
					$fila++;
				if($fila%4==0)
				{
					echo '</div>';
				}
			}
			if($fila%4!=0)
			{
				echo '</div>';
			}
		}
		else
		{
			echo'<p>NO HAY DATOS EN LA BUSQUEDA</p>';
		}
	}
	function buscar_todo()
	{
		$buscar=$_GET['buscar'];
		$serv=$this->modelo_compras->get_producto_espec($buscar);
		$prod=$this->modelo_compras->get_servicio_espec($buscar);
		$comb=$this->modelo_compras->get_combinado_espec($buscar);
		if($prod or $serv or $comb)
		{
			$fila=0;
			for($productos=0;$productos<sizeof($prod);$productos++)
			{
				if($fila%4==0)
				{
					echo '<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">';
				}
				echo'<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 well div_merca" style="text-align:center; height:20%;">
						<div class"row">
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="height:30%;">
								<img class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:30%;" src="'.$prod[$productos]->ruta.'">
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
						</div>
						<p><h1><strong>'.$prod[$productos]->nombre.'</strong></h1></p>
						
						<p><h3>$ '.$prod[$productos]->costo.'</h3></p>
						
						<p><a class="btn btn-success btn-lg" href="javascript:void(0);" onclick="detalles('.$prod[$productos]->id.',1)"><i class="fa fa-shopping-cart"></i>Añadir al carrito</a></p>
					</div>';
					$fila++;
				if($fila%4==0)
				{
					echo '</div>';
				}
				
			}
					
			for($servicios=0;$servicios<sizeof($serv);$servicios++)
			{
				if($fila%4==0)
				{
					echo '<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">';
				}
				echo'<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 well div_merca" style="text-align:center; height:10%; ">
						<div class="row">
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="height:30%;">
								<img class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:30%;" src="'.$serv[$servicios]->ruta.'">
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
						</div>
						<p><h1><strong>'.$serv[$servicios]->nombre.'</strong></h1></p>
						
						<p><h3>$ '.$serv[$servicios]->costo.'</h3></p>
						
						<p><a class="btn btn-success btn-lg" href="javascript:void(0);" onclick="detalles('.$serv[$servicios]->id.',2)"><i class="fa fa-shopping-cart"></i>Añadir al carrito</a></p>
					</div>';
				$fila++;
				if($fila%4==0)
				{
					echo '</div>';
				}
				
			}
		
			for($combinados=0;$combinados<sizeof($comb);$combinados++)
			{
				if($fila%4==0)
				{
					echo '<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">';
				}
				echo'<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 well div_merca" style="text-align:center; height:20%; ">
						<div class="row">
							<div class="col-lg-1 col-md-1 col-sm-2 col-xs-1"></div>
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="height:30%;">
								<img class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:30%;" src="'.$comb[$combinados]->ruta.'">
							</div>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
						</div>
						<p><h1><strong>'.$comb[$combinados]->nombre.'</strong></h1></p>
						
						<p><h2>'.$comb[$combinados]->n_prod.' + '.$comb[$combinados]->n_serv.'</h2></p>
						
						<p><h3>$ '.$comb[$combinados]->costo.'</h3></p>
						
						<p><a class="btn btn-success btn-lg" href="javascript:void(0);" onclick="detalles('.$comb[$combinados]->id.',3)"><i class="fa fa-shopping-cart"></i>Añadir al carrito</a></p>
					</div>';
					$fila++;
				if($fila%4==0)
				{
					echo '</div>';
				}
					
			}
			if($fila%4!=0)
			{
				echo'</div>';
			}
		}
		else
		{
			echo'<p>NO HAY DATOS EN LA BUSQUEDA</p>';
		}
	}
	function por_comprar()
	{
		echo '<div class="row userInfo">';
				if($_GET['tipo']==3)
			  	{
			  		echo '<form id="wizard-1" novalidate="novalidate">
							<div id="bootstrap-wizard-1" class="col-sm-12">
								<div class="form-bootstrapWizard">
									<ul class="bootstrapWizard form-wizard">
										<li class="active" data-target="#step1">
											<a href="#tab1" data-toggle="tab"> <span class="step">1</span> <span class="title">Fecha de venta</span> </a>
										</li>
										<li data-target="#step2">
											<a href="#tab2" data-toggle="tab"> <span class="step">2</span> <span class="title">Información de la tarjeta</span> </a>
										</li>
										<li data-target="#step3">
											<a href="#tab3" data-toggle="tab"> <span class="step">3</span> <span class="title">Fin</span> </a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="tab-content">
									<div class="tab-pane active" id="tab1">
										<br>
										<h3><strong>Paso 1 </strong> - Fecha de Venta</h3>
	
										<div class="row">
	
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
								  				<section class="col col-lg-12 col-sm-12 col-xs-12 col-md-12">
								  				<p><strong>Selecciona la fecha de la siguente compra</strong></p>
													<label class="input"> <i class="icon-append fa fa-calendar"></i>
														<input type="text" name="startdate" id="startdate" placeholder="Fecha de compra">
													</label>
												</section>
								  			</div>
	
										</div>
	
													
									</div>
									<div class="tab-pane" id="tab2">
										<br>
										<h3><strong>Paso 2</strong> - Infomaciond de la tarjeta</h3>
	
										<div class="row">
											<div class="panel-body">
					                        	<p>Todas las transacciones son seguras y encriptadas. Para saber mas, por favor ve nuestra politica de privacidad.</p>
					                          	<br>
					                          	<div class="panel open">
					                            	<div class="creditCard">
					                              		<div class="cartBottomInnerRight paymentCard"> 
					                              		</div>
					                              		<span>Tarjetas</span> <span>Admitidas</span>
					                              		<div class="paymentInput">
					                                		<div class="form-group">
					                  						<br>
						                              			<div class="col-lg-4 col-md-4 col-sm-4 no-margin-left no-padding">
						                                			<select required aria-required="true" id="banco_taj" name="expire">
						                                  				<option value="">Banco</option>
						                                  				<option value="1">01 - VISA</option>
						                                  				<option value="2">02 - Master Card</option>
						                                  				<option value="3">03 - American Express</option>
						                                			</select>
						                              			</div>
						                             	 		<div class="col-lg-4 col-md-4 col-sm-4 ">
						                                			<select required aria-required="true" id="tipo_taj" name="expire">
						                                  				<option value="">Tipo</option>
						                                  				<option value="1">01 - Credito</option>
						                                  				<option value="2">02 - Debito</option>
						                                			</select>
						                              			</div>
						                            		</div>
					                              		</div>
						                              	<div class="paymentInput">
						                                	<label for="CardNumber">Número de Tarjeta de Crédito*</label>
						                                	<br>
						                                	<input id="numero_taj" type="text" name="Number">
						                              	</div>
						                              	<!--paymentInput-->
						                              	<div class="paymentInput">
						                                	<label for="CardNumber2">Titular de la Tarjeda de Credito *</label>
						                                	<br>
						                                	<input type="text" name="CardNumber2" id="titular_taj">
						                              	</div>
						                              	<!--paymentInput-->
						                              	<div class="paymentInput">
						                                	<div class="form-group">
						                                  	<label>Fecha de Vencimiento *</label>
						                                  	<br>
						                                  	<div class="col-lg-4 col-md-4 col-sm-4 no-margin-left no-padding">
						                                    	<select required aria-required="true" name="expire" id="mes_taj">
						                                      		<option value="">Month</option>
							                                      	<option value="1">01 - Enero</option>
							                                      	<option value="2">02 - Febrero</option>
							                                      	<option value="3">03 - Marzo</option>
							                                      	<option value="4">04 - Abril</option>
							                                      	<option value="5">05 - Mayo</option>
							                                      	<option value="6">06 - Junio</option>
							                                      	<option value="7">07 - Julio</option>
							                                      	<option value="8">08 - Agosto</option>
							                                      	<option value="9">09 - Septiembre</option>
							                                      	<option value="10">10 - Octubre</option>
							                                      	<option value="11">11 - Noviembre</option>
							                                      	<option value="12">12 - Diciembre</option>
							                                    </select>
						                                  	</div>
						                                  	<div class="col-lg-4 col-md-4 col-sm-4">
						                                    	<select required aria-required="true" name="year" id="ano_taj">
							                                      	<option value="">Año</option>
							                                      	<option value="2013">2013</option>
							                                      	<option value="2014">2014</option>
						                                      		<option value="2015">2015</option>
						                                      		<option value="2016">2016</option>
						                                      		<option value="2017">2017</option>
						                                      		<option value="2018">2018</option>
						                                      		<option value="2019">2019</option>
						                                      		<option value="2020">2020</option>
						                                      		<option value="2021">2021</option>
						                                      		<option value="2022">2022</option>
						                                      		<option value="2023">2023</option>
						                                    	</select>
						                                  	</div>
						                                  
						                                </div>
						                             </div>
						                             <!--paymentInput-->
							                         <div style="clear:both"></div>
						                             	<div class="paymentInput clearfix">
						                                	<label for="VerificationCode">Codigo de Verificación *</label>
						                                	<br>
						                                	<input type="text" name="VerificationCode" id="code_taj" style="width:90px;">
						                                	<br> 
						                              	</div>
						                              	<!--paymentInput-->
							                            <div> 
						                                	<input type="checkbox" name="saveInfo" id="saveInfoid" id="salvar_taj">
						                                	<label for="saveInfoid">&nbsp;Guardar la información de mi tarjeta de Crédito</label>
						                              	</div> 
						                            </div>
						                            <!--creditCard-->
						                            
						                          	</div>
												</div>
											</div>
										</div>
									
									
										<div class="tab-pane" id="tab3">
											<br>
											<h3><strong>Paso 4</strong> - Programar Compra</h3>
											<br>
											<h1 class="text-center text-success"><strong><i class="fa fa-check fa-lg"></i> Cmpletado</strong></h1>
											<h4 class="text-center">Pulsa aceptar para guardar la compra</h4>
											<br>
											<br>
											<div class="pull-right"> <a  class="btn btn-primary btn-small" onclick="completar_compra(5)" > Guardar Compra &nbsp; <i class="fa fa-arrow-circle-right"></i> </a> </div>
										</div>
	
										<div class="form-actions">
											<div class="row">
												<div class="col-sm-12">
													<ul class="pager wizard no-margin">
														<!--<li class="previous first disabled">
														<a href="javascript:void(0);" class="btn btn-lg btn-default"> First </a>
														</li>-->
														<li class="previous disabled">
															<a href="javascript:void(0);" class="btn btn-lg btn-default"> Previous </a>
														</li>
														<!--<li class="next last">
														<a href="javascript:void(0);" class="btn btn-lg btn-primary"> Last </a>
														</li>-->
														<li class="next">
															<a href="javascript:void(0);" class="btn btn-lg txt-color-darken"> Next </a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>';
						/*echo "$('#bootstrap-wizard-1').bootstrapWizard({
						    'tabClass': 'form-wizard',
						    'onNext': function (tab, navigation, index) {
						      var $valid = $('#wizard-1').valid();
						      if (!$valid) {
						        $validator.focusInvalid();
						        return false;
						      } else {
						        $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass(
						          'complete');
						        $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step')
						        .html('<i class='fa fa-check'></i>');
						      }
						    }
						  });
						</script>";*/
											
			  		
						
			  		
			  	}
				else
				{
              echo '<div class="col-lg-12">
			  	
               <p>Seleccione el metodo para pagar su orden.</p>
                <hr>
              </div>
              <div class="col-xs-12 col-sm-12">
                <div class="paymentBox">
                  <div class="panel-group paymentMethod" id="accordion">
                  	<div class="panel panel-default">
                      <div class="panel-heading panel-heading-custom">
                        <h4 class="panel-title"> <a class="masterCard" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> <span class="numberCircuil">Opcion 1</span> <strong> Efectivo</strong> </a> </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                          <p>Todas las transacciones son seguras y encriptadas. Para saber mas, por favor ve nuestra politica de privacidad.</p>
                          <br>
                          <div class="panel open">
                            
                              
                           </div>
                         </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading panel-heading-custom">
                        <h4 class="panel-title"> <a class="masterCard" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> <span class="numberCircuil">Opcion 2</span> <strong> Deposito</strong> </a> </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
                         <div class="panel-body">
                           <p>Todas las transacciones son seguras y encriptadas. Para saber mas, por favor ve nuestra politica de privacidad.</p>
                           <br>
                           <div class="panel open">
                           		
                              
                           </div>
                         </div>
                      </div>
                    </div>
                    <div class="panel panel-default">
                      <div class="panel-heading panel-heading-custom">
                        <h4 class="panel-title"> <a class="masterCard" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"> <span class="numberCircuil">Opcion 3</span> <strong> Tarjeta</strong> </a> </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                          <p>Todas las transacciones son seguras y encriptadas. Para saber mas, por favor ve nuestra politica de privacidad.</p>
                          <br>
                          <div class="panel open">
                            <div class="creditCard">
                              <div class="cartBottomInnerRight paymentCard"> 
                              </div>
                              <span>Tarjetas</span> <span>Admitidas</span>
                              <div class="paymentInput">
                                <div class="form-group">
                  
                                  <br>
	                              <div class="col-lg-4 col-md-4 col-sm-4 no-margin-left no-padding">
	                                <select required aria-required="true" id="banco_taj" name="expire">
	                                  <option value="">Banco</option>
	                                  <option value="1">01 - VISA</option>
	                                  <option value="2">02 - Master Card</option>
	                                  <option value="3">03 - American Express</option>
	                                  
	                                </select>
	                              </div>
	                              
	                              <div class="col-lg-4 col-md-4 col-sm-4 ">
	                                <select required aria-required="true" id="tipo_taj" name="expire">
	                                  <option value="">Tipo</option>
	                                  <option value="1">01 - Credito</option>
	                                  <option value="2">02 - Debito</option>
	                                 
	                                </select>
	                              </div>
	                            </div>
                              </div>
                              <div class="paymentInput">
                                <label for="CardNumber">Número de Tarjeta de Crédito*</label>
                                <br>
                                <input id="numero_taj" type="text" name="Number">
                              </div>
                              <!--paymentInput-->
                              <div class="paymentInput">
                                <label for="CardNumber2">Titular de la Tarjeda de Credito *</label>
                                <br>
                                <input type="text" name="CardNumber2" id="titular_taj">
                              </div>
                              <!--paymentInput-->
                              <div class="paymentInput">
                                <div class="form-group">
                                  <label>Fecha de Vencimiento *</label>
                                  <br>
                                  <div class="col-lg-4 col-md-4 col-sm-4 no-margin-left no-padding">
                                    <select required aria-required="true" name="expire" id="mes_taj">
                                      <option value="">Month</option>
                                      <option value="1">01 - Enero</option>
                                      <option value="2">02 - Febrero</option>
                                      <option value="3">03 - Marzo</option>
                                      <option value="4">04 - Abril</option>
                                      <option value="5">05 - Mayo</option>
                                      <option value="6">06 - Junio</option>
                                      <option value="7">07 - Julio</option>
                                      <option value="8">08 - Agosto</option>
                                      <option value="9">09 - Septiembre</option>
                                      <option value="10">10 - Octubre</option>
                                      <option value="11">11 - Noviembre</option>
                                      <option value="12">12 - Diciembre</option>
                                    </select>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <select required aria-required="true" name="year" id="ano_taj">
                                      <option value="">Año</option>
                                      <option value="2013">2013</option>
                                      <option value="2014">2014</option>
                                      <option value="2015">2015</option>
                                      <option value="2016">2016</option>
                                      <option value="2017">2017</option>
                                      <option value="2018">2018</option>
                                      <option value="2019">2019</option>
                                      <option value="2020">2020</option>
                                      <option value="2021">2021</option>
                                      <option value="2022">2022</option>
                                      <option value="2023">2023</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <!--paymentInput-->
                               
                              <div style="clear:both"></div>
                              <div class="paymentInput clearfix">
                                <label for="VerificationCode">Codigo de Verificación *</label>
                                <br>
                                <input type="text" name="VerificationCode" id="code_taj" style="width:90px;">
                                <br> 
                              </div>
                              <!--paymentInput-->
                              
                              <div> 
                                <input type="checkbox" name="saveInfo" id="saveInfoid" id="salvar_taj">
                                <label for="saveInfoid">&nbsp;Guardar la información de mi tarjeta de Crédito</label>
                              </div> 
                            </div>
                            <!--creditCard-->
                            
                            <div class="pull-right"> <a  class="btn btn-primary btn-small" onclick="completar_compra(1)" > Procesar pago &nbsp; <i class="fa fa-arrow-circle-right"></i> </a> </div>
                          </div>
                         </div>
                      </div>
                    </div>
					
                    <div class="panel panel-default">
                      <div class="panel-heading panel-heading-custom">
                        <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"> <span class="numberCircuil">Opcion 4</span><strong> PayPal</strong> </a> </h4>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                          <p> Todas las transacciones son seguras y encriptadas. Para saber mas, por favor ve nuestra politica de privacidad.</p>
                          <br>
                          <label class="radio-inline" for="radios-3">
                            <input name="radios" id="radios-3" value="4" type="radio">
                            <img src="images/site/payment/paypal-small.png" height="18" alt="paypal"> Comprar con Paypal </label>
                          <div class="form-group">
                            <label for="CommentsOrder2">Agrega comentarios acerca de tu orden</label>
                            <textarea id="CommentsOrder2" class="form-control" name="CommentsOrder2" cols="26" rows="3"></textarea>
                          </div>
                          <div class="form-group clearfix">
                            <label class="checkbox-inline" for="checkboxes-0">
                              <input name="checkboxes" id="checkboxes-0" value="1" type="checkbox">
                              He leído y acepto los <a href="terms-conditions.html">Terminos y Condiciones</a> </label>
                          </div>
                          <div class="pull-right"> <a href="" class="btn btn-primary btn-small " > Procesar pago &nbsp; <i class="fa fa-arrow-circle-right"></i> </a> </div>
                        </div>
                       </div>
                    </div>
                    
                    
                    
                  </div>
                </div>
                
                <!--/row--> 
                
              </div>
            </div>';
            }
	}
	function completar_compra()
	{
		$data=$_GET["info"];
		$data=json_decode($data,true);
		$tipo_venta=$data["id"];
		$id_user=$this->tank_auth->get_user_id();
		
		
		switch($tipo_venta)
		{
			case 1: //credito o debito
				
				$fecha=$data['ano']."-".$data['mes']."-10";
				$fecha=date("Y-m-t", strtotime($fecha));
				if($data['salvar']=='1')
				{
					$status='ACT'; 
				}
				else
				{	 
					$status='DES';
				}
				if($data['comprador']!='0')
				{
					$id_user=$data['comprador'];
				}
				$this->db->query("insert into tarjeta (tipo_tarjeta,id_usuario,id_banco,cuenta,fecha_vencimiento,titular,
						codigo_seguridad,estatus) values (".$data['tipo'].",".$id_user.",".$data['banco'].",'".$data['numero']."',
						'".$fecha."','".$data['titular']."','".$data['codigo']."','".$status."')");
				$this->db->query("insert into venta (id_user,id_estatus,costo,id_metodo_pago) values (".$id_user.",2,".$this->cart->total().",1)");
				$venta=mysql_insert_id();
				$puntos=0;
				foreach ($this->cart->contents() as $items) 
				{
					$this->db->query("insert into cross_venta_mercancia values (".$items['id'].",".$venta.",".$items['qty'].",".$items['options']['prom_id'].")");
					$puntos_q=$this->modelo_compras->get_puntos_comisionables($items['id']);
					$puntos=$puntos+($puntos_q[0]->puntos_comisionables*$items['qty']);
					$this->modelo_compras->update_inventario($items['id'],$items['qty']);
					$this->modelo_compras->salida_por_venta($items['id'],$items['qty'],$id_user,$venta);
				}
				$this->modelo_compras->insert_comision($venta,$puntos);
				$this->cart->destroy();
				break;
			case 5://compra programada
				$fecha=$data['ano']."-".$data['mes']."-10";
				$fecha=date("Y-m-t", strtotime($fecha));
				if($data['salvar']=='1')
				{
					$status='ACT'; 
				}
				else
				{	 
					$status='DES';
				}
				if($data['comprador']!='0')
				{
					$id_user=$data['comprador'];
				}
				$this->db->query("insert into tarjeta (tipo_tarjeta,id_usuario,id_banco,cuenta,fecha_vencimiento,titular,
						codigo_seguridad,estatus) values (".$data['tipo'].",".$id_user.",".$data['banco'].",'".$data['numero']."',
						'".$fecha."','".$data['titular']."','".$data['codigo']."','".$status."')");
				$this->db->query("insert into autocompra (fecha,id_usuario) values ('".$data['fecha']."',".$id_user.")");
				$autocompra=mysql_insert_id();
				foreach ($this->cart->contents() as $items) 
				{
					$this->db->query("insert into cross_autocompra_mercancia values (".$autocompra.",".$items['id'].",".$items['qty'].")");
					
				}
				$this->cart->destroy();
				break;
			default:  
				break;
		}
		
	}
	function quitar_producto()
	{
		$id=$_GET['id'];
		$data = array(
           'rowid' => $id,
           'qty'   => 0
        );
		$this->cart->update($data);
		if($this->cart->contents())
		{
			echo '
					<div class="col-lg-12 col-md-12 col-sm-12">
				      <div class="row userInfo">
				        <div class="col-xs-12 col-sm-12">
				          <div class="cartContent w100">
				            <table class="cartTable table-responsive" style="width:100%">
				              <tbody>
				              
				                <tr class="CartProduct cartTableHeader">
				                  <td style="width:15%"  > Product </td>
				                  <td style="width:40%"  >Details</td>
				                  <td style="width:10%"  class="delete">&nbsp;</td>
				                  <td style="width:10%" >QNT</td>
				                  <td style="width:10%" >Discount</td>
				                  <td style="width:15%" >Total</td>
				                </tr>';
				               foreach ($this->cart->contents() as $items) 
								{
									
									$total=$items['qty']*$items['price'];	
									$imgn=$this->modelo_compras->get_img($items['id']);
									if(isset($imgn[0]->url))
									{
										$imagen=$imgn[0]->url;
									}
									else
									{
										$imagen="";
									}
									switch($items['name'])
									{
										case 1:
											$detalles=$this->modelo_compras->detalles_productos($items['id']);
											break;
										case 2:
											$detalles=$this->modelo_compras->detalles_servicios($items['id']);
											break;
										case 3:
											$detalles=$this->modelo_compras->comb_espec($items['id']);
											break;
										case 4:
											$detalles=$this->modelo_compras->detalles_prom_prod($items['id']);
											break;
										case 5:
											$detalles=$this->modelo_compras->detalles_prom_serv($items['id']);
											break;
										case 6:
											$detalles=$this->modelo_compras->detalles_prom_comb($items['id']);
											break;
									}
									echo '<tr class="CartProduct">
											<td  class="CartProductThumb">
												<div> 
													<a href="#"><img src="'.$imagen.'" alt="img"></a> 
												</div>
											</td>
											<td >
												<div class="CartDescription">
							                      <h4> <a href="product-details.html">'.$detalles[0]->nombre.'</a> </h4>
							                   
							                      <div class="price"> <span>$'.$items['price'].'</span></div>
							                    </div>
							                </td>
							                <td class="delete"><a title="Delete" onclick="quitar_producto(\''.$items['rowid'].'\')"> <i class="glyphicon glyphicon-trash fa-2x"></i></a></td>
							                <td >'.$items['qty'].'</td>
							                <td >0</td>
							                <td class="price">$'.$total.'</td>
											
										</tr>';
								}
				                
				               echo ' </tbody>
						            </table>
						          </div>
						          <!--cartContent-->
						          
						        </div>
						      </div>
						      <!--/row end--> 
						      
						    </div>
						   ';
				
			}						
		else
		{
			echo 'NO HAY PRODUCTOS EN EL CARRITO';	
		}
	}
	function actualizar_nav()
	{
		echo ' <div class="navbar-header">
			      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only"> Toggle navigation </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> </button>
			      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cart"> <i class="fa fa-shopping-cart colorWhite"> </i> <span class="cartRespons colorWhite"> Cart ('.$this->cart->total_items().') </span> </button>
			      <a class="navbar-brand titulo_carrito" href="/ov/dashboard"> Dashboard &nbsp;</a>  
			      
			      <!-- this part for mobile -->
			      <div class="search-box pull-right hidden-lg hidden-md hidden-sm">
			        <div class="input-group">
			          <button class="btn btn-nobg getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
			        </div>
			        <!-- /input-group --> 
			        
			      </div>
			    </div>';
		echo '<div class="cartMenu  hidden-lg col-xs-12 hidden-md hidden-sm ">
        <div class="w100 miniCartTable scroll-pane">
          <table  >
            <tbody>';
            	 
                  	if($this->cart->contents())
					{ 
						foreach ($this->cart->contents() as $items) 
						{
							$total=$items['qty']*$items['price'];	
							$imgn=$this->modelo_compras->get_img($items['id']);
							if(isset($imgn[0]->url))
							{
								$imagen=$imgn[0]->url;
							}
							else
							{
								$imagen="";
							}
							switch($items['name'])
							{
								case 1:
									$detalles=$this->modelo_compras->detalles_productos($items['id']);
									break;
								case 2:
									$detalles=$this->modelo_compras->detalles_servicios($items['id']);
									break;
								case 3:
									$detalles=$this->modelo_compras->comb_espec($items['id']);
									break;
								case 4:
									$detalles=$this->modelo_compras->detalles_prom_prod($items['id']);
									break;
								case 5:
									$detalles=$this->modelo_compras->detalles_prom_serv($items['id']);
									break;
								case 6:
									$detalles=$this->modelo_compras->detalles_prom_comb($items['id']);
									break;
							}
							echo '<tr class="miniCartProduct"> 
									<td style="width:20%" class="miniCartProductThumb"><div> <a href="#"> <img src="'.$imgn[0]->url.'" alt="img"> </a> </div></td>
									<td style="width:40%"><div class="miniCartDescription">
				                        <h4> <a href="product-details.html"> '.$detalles[0]->nombre.'</a> </h4>
				                        <div class="price"> <span> '.$items['price'].' </span> </div>
				                      </div></td>
				                    <td  style="width:10%" class="miniCartQuantity"><a > X '.$items['qty'].' </a></td>
				                    <td  style="width:15%" class="miniCartSubtotal"><span>'.$total.'</span></td>
				                    <td  style="width:5%" class="delete"><a onclick="quitar_producto(\''.$items['rowid'].'\')"> x </a></td>
								</tr>'; 
						} 
					}            
         echo   '</tbody>
          </table>
        </div>
        <!--/.miniCartTable-->
        
        <div class="miniCartFooter  miniCartFooterInMobile text-right">
          <h3 class="text-right subtotal"> Subtotal: $'.$this->cart->total().' </h3>
          <a class="btn btn-sm btn-danger" onclick="ver_cart()"> <i class="fa fa-shopping-cart"> </i> VER CARRITO </a> <a class="btn btn-sm btn-primary" onclick="a_comprar()"> COMPRAR! </a> </div>
        <!--/.miniCartFooter--> 
        
      </div>';
		echo '</div>
    <!--/.navbar-cart-->
    
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"> <a onclick="show_todos()"> Todos </a> </li>
        <li class="dropdown megamenu-fullwidth"> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_prod()"> Productos </a></li>
        
        <!-- change width of megamenu = use class > megamenu-fullwidth, megamenu-60width, megamenu-40width -->
        <li class="dropdown megamenu-80width "> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_serv()"> Servicios </a></li>
        <li class="dropdown megamenu-fullwidth"> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_comb()"> Combinados </a></li>
        <li class="dropdown megamenu-fullwidth"> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_prom()"> Promociones </a></li>
      </ul>
      
      <!--- this part will be hidden for mobile version -->
      <div class="nav navbar-nav navbar-right hidden-xs" >
        <div class="dropdown  cartMenu "> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
        	<i class="fa fa-shopping-cart"> </i> 
        	<span class="cartRespons"> Cart ('.$this->cart->total_items().') 
        	</span> <b class="caret"> </b> </a>
          	<div class="dropdown-menu col-lg-4 col-xs-12 col-md-4 ">
            	<div class="w100 miniCartTable scroll-pane">
	              	<table>
	                	<tbody>';
	                  
	                 	foreach ($this->cart->contents() as $items) 
						{
							$total=$items['qty']*$items['price'];	
							$imgn=$this->modelo_compras->get_img($items['id']);
							if(isset($imgn[0]->url))
							{
								$imagen=$imgn[0]->url;
							}
							else
							{
								$imagen="";
							}
							switch($items['name'])
							{
								case 1:
									$detalles=$this->modelo_compras->detalles_productos($items['id']);
									break;
								case 2:
									$detalles=$this->modelo_compras->detalles_servicios($items['id']);
									break;
								case 3:
									$detalles=$this->modelo_compras->comb_espec($items['id']);
									break;
								case 4:
									$detalles=$this->modelo_compras->detalles_prom_prod($items['id']);
									break;
								case 5:
									$detalles=$this->modelo_compras->detalles_prom_serv($items['id']);
									break;
								case 6:
									$detalles=$this->modelo_compras->detalles_prom_comb($items['id']);
									break;
							}
							echo '<tr class="miniCartProduct"> 
									<td style="width:20%" class="miniCartProductThumb"><div> <a href="#"> <img src="'.$imgn[0]->url.'" alt="img"> </a> </div></td>
									<td style="width:40%"><div class="miniCartDescription">
				                        <h4> <a href="product-details.html"> '.$detalles[0]->nombre.'</a> </h4>
				                        <div class="price"> <span> '.$items['price'].' </span> </div>
				                      </div></td>
				                    <td  style="width:10%" class="miniCartQuantity"><a > X '.$items['qty'].' </a></td>
				                    <td  style="width:15%" class="miniCartSubtotal"><span>'.$total.'</span></td>
				                    <td  style="width:5%" class="delete"><a onclick="quitar_producto(\''.$items['rowid'].'\')"> x </a></td>
								</tr>'; 
						} 
	                  
	                echo '</tbody>
	              </table>
            	</div>
            <!--/.miniCartTable-->
            
	            <div class="miniCartFooter text-right">
	              <h3 class="text-right subtotal"> Subtotal: $ '.$this->cart->total().' </h3>
	              <a class="btn btn-sm btn-danger" onclick="ver_cart()"> <i class="fa fa-shopping-cart"> </i> VER CARRITO </a> <a class="btn btn-sm btn-primary" onclick="a_comprar()"> COMPRAR! </a> </div>
	            <!--/.miniCartFooter--> 
            
          		</div>
          <!--/.dropdown-menu--> 
        	</div> 
        <!--/.cartMenu--> 
        
        <div class="search-box">
          <div class="input-group"> 
            <button class="btn btn-nobg getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
          </div>
          <!-- /input-group --> 
          
        </div>
        <!--/.search-box --> ';
	}
	function select_af()
	{
		$user=$this->tank_auth->get_user_id();
		$afiliados=$this->modelo_compras->get_afiliados($user);
		echo '<div class="row">
	              <div class="col-lg-12">
	                <div class="row" style="text-align:center;">
						
						<section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
							<label class="select" id="afiliados">
								<select id="afiliado_id">
									<option value="0">Escoge a tu afiliado</option>';
										foreach($afiliados as $afiliado)
										{
											echo '<option value="'.$afiliado->id_afiliado.'">'.$afiliado->afiliado.' '.$afiliado->afiliado_p.'</option>';
										}								
									
								echo '</select> <i></i> </label>
						</section>
					</div> <br>
					<a class="btn btn-success btn-lg" href="javascript:void(0);" onclick="enviar_carro()"><i class="fa fa-shopping-cart"></i>Ir al carrito</a>
				</div>
			</div>';
	}
	function hacer_compra()
	{
		$this->modelo_compras->hacer_compra();
		redirect('/ov/dashboard');
	}
	
	function verificar_carro()
	{
		$prod=0;
		foreach($this->cart->contents() as $items)
		{
			$prod++;
		}
		if($prod>0)		
		{
			echo "si";
		}
		else {
			echo "no";
		}
	}

	function EnviarPayuLatam(){
		
		$this->template->set_theme('desktop');
		
		$this->template->build('website/ov/compra_reporte/prueba');
	}
	function registrarVenta(){
		$estado = $_POST['state_pol'];
		$productos = $this->cart->contents();
		$referencia = $_POST['reference_sale'];
		$id_usuario = $_POST['extra2'];
		$extra1 = explode("-", $_POST['extra1']);
		$id_mercancia = $extra1[0];
		$cantidad = $extra1[1];
		$metodo_pago = $_POST['payment_method_id'];
		$respuesta = $_POST['response_code_pol'];
		$fecha = $_POST['transaction_date'];
		$moneda = $_POST['currency'];
		$email = $_POST['email_buyer'];
		$direcion_envio = $_POST['shipping_address'];
		$telefono = $_POST['phone'];
		$identificado_transacion = $_POST['transaction_id'];
		$medio_pago = $_POST['payment_method_name'];
		
		$id_transacion = $_POST['transaction_id'];
		$firma = $_POST['sign'];
		
		$costo = $cantidad*$this->modelo_compras->CostoMercancia($id_mercancia);
		
		$impuestos = $this->modelo_compras->ImpuestoMercancia($id_mercancia, $costo);
		
		if($estado == 4){
			
			$venta = $this->modelo_compras->registrar_venta($id_usuario, $costo, $metodo_pago, $id_transacion, $firma, $fecha, $impuestos);
			
			$this->modelo_compras->registrar_envio("1".$venta, $id_usuario, $direcion_envio , $telefono, $email);
			$this->modelo_compras->registrar_factura($venta, $id_usuario, $direcion_envio , $telefono, $email);
			
			$puntos = $this->modelo_compras->registrar_venta_mercancia($id_mercancia, $venta, $cantidad);
			$total = $this->modelo_compras->registrar_impuestos($id_mercancia);
			$this->modelo_compras->registrar_movimiento($id_usuario, $id_mercancia, $cantidad, $costo+$impuestos, $total, $venta, $puntos);
			$producto_continua = array();
			foreach ($productos as $producto){
				if($producto['id'] == $id_mercancia){
					
					$this->cart->destroy();
				}else{
					$add_cart = array(
							'id'      => $producto['id'],
							'qty'     => $producto['qty'],
							'price'   => $producto['price'],
							'name'    => $producto['name'],
							'options' => $producto['options']
					);
					$producto_continua[] = $add_cart;
				}
			}
			$this->cart->insert($producto_continua);
			
			$id_red_mercancia = $this->modelo_compras->ObtenerRedMercancia($id_mercancia);
			$red = $this->modelo_compras->Red($id_red_mercancia);
			
			$valor_puntos = $puntos * $red[0]->valor_punto;
			
			$costo_comision = $this->modelo_compras->ValorComision();
			
			$this->CalcularComisiones($id_usuario, $id_red_mercancia, $venta, $puntos, $valor_puntos, $costo_comision);
			
			return "Regsitro Corecto";
		}	
	}
	
	private function CalcularComisiones($id_afiliado, $id_red_mercancia, $venta, $puntos, $valor_puntos, $costo_comision) {
		$id_red_padre = $this->model_perfil_red->ConsultarIdRedPadre ( $id_afiliado );
		$id_padre = $this->model_perfil_red->ConsultarIdPadre ( $id_afiliado, $id_red_padre );
		$red2 = $this->model_afiliado->RedAfiliado ( $id_padre, $id_red_padre );
		$estado = $this->model_user_profiles->EstadoUsuario ( $id_padre );
		if ($red2 [0]->premium == 2) {
			$valor_comision = ($costo_comision [0]->valor * $valor_puntos) / 100;
			$this->modelo_compras->CalcularComisionVenta ( $venta, $id_padre, $costo_comision [0]->valor, $valor_comision, $id_red_mercancia );
			
			$id_afiliado = $id_padre;
			$id_padre = $this->model_perfil_red->ConsultarIdPadre ( $id_afiliado, $id_red_padre );
			
			$valor_comision = ($valor_puntos) / 100;
			$this->modelo_compras->CalcularComisionVenta ( $venta, $id_padre, 1, $valor_comision, $id_red_mercancia );
		} else {
			
			$valor_comision = ($costo_comision [2]->valor * $valor_puntos) / 100;
			$this->modelo_compras->CalcularComisionVenta ( $venta, $id_padre, $costo_comision [2]->valor, $valor_comision, $id_red_mercancia );
			
			$id_afiliado = $id_padre;
			
			$id_padre = $this->model_perfil_red->ConsultarIdPadre ( $id_afiliado, $id_red_padre );
			
			if(!$id_padre){
				exit;
			}
			$estado = $this->model_user_profiles->EstadoUsuario ( $id_padre );
			$red2 = $this->model_afiliado->RedAfiliado ( $id_padre, $id_red_padre );
			if ($red2 [0]->premium == 2) {
				$valor_comision = ($costo_comision [1]->valor * $valor_puntos) / 100;
				$this->modelo_compras->CalcularComisionVenta ( $venta, $id_padre, $costo_comision [1]->valor, $valor_comision, $id_red_mercancia );
				
				$id_afiliado = $id_padre;
				$id_padre = $this->model_perfil_red->ConsultarIdPadre ( $id_afiliado, $id_red_padre );
				
				$valor_comision = ($valor_puntos) / 100;
				$this->modelo_compras->CalcularComisionVenta ( $venta, $id_padre, 1, $valor_comision, $id_red_mercancia );
			} else {
				
				$valor_comision = ($costo_comision [2]->valor * $valor_puntos) / 100;
				$this->modelo_compras->CalcularComisionVenta ( $venta, $id_padre, $costo_comision [2]->valor, $valor_comision, $id_red_mercancia );
				
				$id_afiliado = $id_padre;
				$id_padre = $this->model_perfil_red->ConsultarIdPadre ( $id_afiliado, $id_red_padre );
				
				if(!$id_padre){
					return 0;
				}
				$estado = $this->model_user_profiles->EstadoUsuario ( $id_padre );
				$red2 = $this->model_afiliado->RedAfiliado ( $id_padre, $id_red_padre );
				
				while ( isset ( $id_padre ) || $id_padre != 0 ) {
					
					$id_afiliado = $id_padre;
					$id_padre = $this->model_perfil_red->ConsultarIdPadre ( $id_afiliado, $id_red_padre );
					if(!$id_padre){
						exit;
					}
					$estado = $this->model_user_profiles->EstadoUsuario ( $id_padre );
					$red2 = $this->model_afiliado->RedAfiliado ( $id_padre, $id_red_padre );
					if ($red2 [0]->premium == 2) {
						
						$valor_comision = ($costo_comision [2]->valor * $valor_puntos) / 100;
						$this->modelo_compras->CalcularComisionVenta ( $venta, $id_padre, $costo_comision [2]->valor, $valor_comision, $id_red_mercancia );
						
						$id_afiliado = $id_padre;
						$id_padre = $this->model_perfil_red->ConsultarIdPadre ( $id_afiliado, $id_red_padre );
						$valor_comision = ($valor_puntos) / 100;
						$this->modelo_compras->CalcularComisionVenta ( $venta, $id_padre, 1, $valor_comision, $id_red_mercancia );
						exit ();
					}
				}
			}
		}
	}
}