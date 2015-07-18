<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reportes extends CI_Controller
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
		$this->load->model('model_tipo_red');
		$this->load->model('model_servicio');
		$this->load->model('bo/modelo_reportes');
		$this->load->model('general');
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

		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		
		$this->template->set_theme('desktop');
        $this->template->set_layout('website/main');
        $this->template->set_partial('header', 'website/bo/header');
        $this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/reportes/main_dashboard');
	}
	
	function index_actualizado_ventas_ov()
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
		
		$total_costo = 0;
		$total_impuesto = 0;
		$total_comision = 0;
		$total_neto = 0;
		$redes = $this->model_tipo_red->listarTodos();
	
		$style=$this->modelo_dashboard->get_style($id);
		
		
		
		$servicios = $this->model_servicio->listar_todos_por_venta_y_fecha($_GET['startdate'], $_GET['finishdate'] );
	
		foreach ($servicios as $servicio){
			$total_costo = $total_costo + $servicio->costo;
			$total_impuesto = $total_impuesto + $servicio->impuesto;
			$total_comision = $total_comision + $servicio->comision;
			$total_neto = $total_neto + (($servicio->costo)-($servicio->impuesto+$servicio->comision));
		}
	
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		$this->template->set("redes",$redes);
		$this->template->set("servicios",$servicios);
		$this->template->set("total_costo",$total_costo);
		$this->template->set("total_impuesto",$total_impuesto);
		$this->template->set("total_comision",$total_comision);
		$this->template->set("total_neto",$total_neto);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/reportes/main_dashboard_actualizada_ventas_ov');
	}
	
	function index_actualizado_()
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
	
		$total_costo = 0;
		$total_impuesto = 0;
		$total_comision = 0;
		$total_neto = 0;
		$redes = $this->model_tipo_red->listarTodos();
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$servicios = $this->model_servicio->listar_todos_por_venta_y_fecha($_POST['startdate'], $_POST['finishdate'] );
	
		foreach ($servicios as $servicio){
			$total_costo = $total_costo + $servicio->costo;
			$total_impuesto = $total_impuesto + $servicio->impuesto;
			$total_comision = $total_comision + $servicio->comision;
			$total_neto = $total_neto + (($servicio->costo)-($servicio->impuesto+$servicio->comision));
		}
	
		$this->template->set("usuario",$usuario);
		$this->template->set("style",$style);
		$this->template->set("redes",$redes);
		$this->template->set("servicios",$servicios);
		$this->template->set("total_costo",$total_costo);
		$this->template->set("total_impuesto",$total_impuesto);
		$this->template->set("total_comision",$total_comision);
		$this->template->set("total_neto",$total_neto);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/reportes/main_dashboard');
	}
	
	function reporte_afiliados()
	{
		$id=$this->tank_auth->get_user_id();
		$afiliados=$this->modelo_reportes->reporte_afiliados($_POST['startdate'],$_POST['finishdate']);
		echo 
			"<table id='datatable_fixed_column1' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th>ID</th>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Email</th>
				</thead>
				<tbody>";
			for($i=0;$i<sizeof($afiliados);$i++)
			{
					echo "<tr>
					<td class='sorting_1'>".$afiliados[$i]->id."</td>
					<td>".$afiliados[$i]->usuario."</td>
					<td>".$afiliados[$i]->nombre."</td>
					<td>".$afiliados[$i]->apellido."</td>
					<td>".$afiliados[$i]->email."</td>
				</tr>";
			}
				
			
			echo "</tbody>
			</table><tr class='odd' role='row'>";
		
		
	}
	function reporte_afiliados_mes()
	{
		$id=$this->tank_auth->get_user_id();
		$afiliados=$this->modelo_reportes->reporte_afiliados_mes();
		echo 
			"<table id='datatable_fixed_column1' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th>ID</th>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Email</th>
				</thead>
				<tbody>";
			for($i=0;$i<sizeof($afiliados);$i++)
			{
					echo "<tr>
					<td class='sorting_1'>".$afiliados[$i]->id."</td>
					<td>".$afiliados[$i]->usuario."</td>
					<td>".$afiliados[$i]->nombre."</td>
					<td>".$afiliados[$i]->apellido."</td>
					<td>".$afiliados[$i]->email."</td>
				</tr>";
			}
				
			
			echo "</tbody>
			</table><tr class='odd' role='row'>";
		
		
	}
	function reporte_proveedores()
	{
		$proveedor_p=$this->modelo_reportes->proveedores_prod();
		$proveedor_s=$this->modelo_reportes->proveedores_serv();
		$proveedor_c=$this->modelo_reportes->proveedores_comb();
		echo 
			"<table id='datatable_fixed_column1' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th>ID</th>
					<th>Empresa</th>
					<th>Regimen</th>
					<th>Zona</th>
					<th>Mercancia</th>
					<th>Razon Social</th>
					<th>CURP</th>
					<th>RFC</th>
					<th>Impuesto</th>
					<th>Condicion Pago</th>
					<th>Promedio Pago</th>
					<th>Plazo Pago</th>
					<th>Plazo Suspension</th>
					<th>Interes Moratorio</th>
					<th>Dia Corte</th>
					<th>Dia Pago</th>
				</thead>
				<tbody>";
				$j=0;
			for($i=0;$i<sizeof($proveedor_p);$i++)
			{
					echo "<tr>
					<td class='sorting_1'>".($j+1)."</td>
					<td>".$proveedor_p[$i]->emp."</td>
					<td>".$proveedor_p[$i]->abreviatura." (".$proveedor_p[$i]->reg.")</td>
					<td>".$proveedor_p[$i]->zona."</td>
					<td>".$proveedor_p[$i]->merc."</td>
					<td>".$proveedor_p[$i]->razon_social."</td>
					<td>".$proveedor_p[$i]->curp."</td>
					<td>".$proveedor_p[$i]->rfc."</td>
					<td>".$proveedor_p[$i]->imp."</td>
					<td>".$proveedor_p[$i]->condicion_pago."</td>
					<td>".$proveedor_p[$i]->promedio_pago."</td>
					<td>".$proveedor_p[$i]->plazo_pago."</td>
					<td>".$proveedor_p[$i]->plazo_suspencion."</td>
					<td>".$proveedor_p[$i]->interes_moratorio."</td>
					<td>".$proveedor_p[$i]->dia_corte."</td>
					<td>".$proveedor_p[$i]->dia_pago."</td>
				</tr>";
				$j++;
			}
			for($i=0;$i<sizeof($proveedor_s);$i++)
			{
					echo "<tr>
					<td class='sorting_1'>".($j+1)."</td>
					<td>".$proveedor_s[$i]->emp."</td>
					<td>".$proveedor_s[$i]->abreviatura." (".$proveedor_p[$i]->reg.")</td>
					<td>".$proveedor_s[$i]->zona."</td>
					<td>".$proveedor_s[$i]->merc."</td>
					<td>".$proveedor_s[$i]->razon_social."</td>
					<td>".$proveedor_s[$i]->curp."</td>
					<td>".$proveedor_s[$i]->rfc."</td>
					<td>".$proveedor_s[$i]->imp."</td>
					<td>".$proveedor_s[$i]->condicion_pago."</td>
					<td>".$proveedor_s[$i]->promedio_pago."</td>
					<td>".$proveedor_s[$i]->plazo_pago."</td>
					<td>".$proveedor_s[$i]->plazo_suspencion."</td>
					<td>".$proveedor_s[$i]->interes_moratorio."</td>
					<td>".$proveedor_s[$i]->dia_corte."</td>
					<td>".$proveedor_s[$i]->dia_pago."</td>
				</tr>";
				$j++;
			}
			for($i=0;$i<sizeof($proveedor_c);$i++)
			{
					echo "<tr>
					<td class='sorting_1'>".($j+1)."</td>
					<td>".$proveedor_c[$i]->emp."</td>
					<td>".$proveedor_c[$i]->abreviatura." (".$proveedor_p[$i]->reg.")</td>
					<td>".$proveedor_c[$i]->zona."</td>
					<td>".$proveedor_c[$i]->merc."</td>
					<td>".$proveedor_c[$i]->razon_social."</td>
					<td>".$proveedor_c[$i]->curp."</td>
					<td>".$proveedor_c[$i]->rfc."</td>
					<td>".$proveedor_c[$i]->imp."</td>
					<td>".$proveedor_c[$i]->condicion_pago."</td>
					<td>".$proveedor_c[$i]->promedio_pago."</td>
					<td>".$proveedor_c[$i]->plazo_pago."</td>
					<td>".$proveedor_c[$i]->plazo_suspencion."</td>
					<td>".$proveedor_c[$i]->interes_moratorio."</td>
					<td>".$proveedor_c[$i]->dia_corte."</td>
					<td>".$proveedor_c[$i]->dia_pago."</td>
				</tr>";
				$j++;
				$j++;
			}
				
			
			echo "</tbody>
			</table><tr class='odd' role='row'>";
		
	}
	function reporte_usuarios()
	{
		$usuarios=$this->modelo_reportes->reporte_usuarios();
		echo 
			"<table id='datatable_fixed_column1' class='table table-striped table-bordered table-hover' width='100%'>
				<thead id='tablacabeza'>
					<th>ID</th>
					<th>Username</th>
					<th>Nombre</th>
					<th>Correo</th>
					<th>Sexo</th>
					<th>Estado Civil</th>
					<th>Tipo Usuario</th>
					<th>Estudio</th>
					<th>Ocupacion</th>
					<th>Tiempo Dedicado</th>
					<th>Tipo Fiscal</th>
					<th>Fecha Nacimiento</th>
					<th>Ultima Sesion</th>
				</thead>
				<tbody>";
			for($i=0;$i<sizeof($usuarios);$i++)
			{
					echo "<tr>
					<td class='sorting_1'>".$usuarios[$i]->id."</td>
					<td>".$usuarios[$i]->username."</td>
					<td>".$usuarios[$i]->nombre." ".$usuarios[$i]->apellido."</td>
					<td>".$usuarios[$i]->email."</td>
					<td>".$usuarios[$i]->sexo."</td>
					<td>".$usuarios[$i]->estado_civil."</td>
					<td>".$usuarios[$i]->tipo_usuario."</td>
					<td>".$usuarios[$i]->estudio."</td>
					<td>".$usuarios[$i]->ocupacion."</td>
					<td>".$usuarios[$i]->tiempo_dedicado."</td>
					<td>".$usuarios[$i]->fiscal."</td>
					<td>".$usuarios[$i]->fecha_nacimiento."</td>
					<td>".$usuarios[$i]->ultima_sesion."</td>
				</tr>";
			}
				
			
			echo "</tbody>
			</table><tr class='odd' role='row'>";
	}
}