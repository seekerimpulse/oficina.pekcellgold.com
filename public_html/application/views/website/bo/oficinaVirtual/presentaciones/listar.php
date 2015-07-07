			<!-- MAIN CONTENT -->
			<div id="content" >
				<div class="row">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<h1 class="page-title txt-color-blueDark">
							
							<!-- PAGE HEADER -->
							<i class="fa-fw fa fa-home"></i> 
								<a href="/bo/dashboard"> Menu</a> 
							<span>>
								<a href="/bo/oficinaVirtual/"> Oficina Virtual</a> > <a href="/bo/oficinaVirtual/presentaciones"> Presentaciones</a> > Listar
							</span>
						</h1>
					</div>
				</div>
	<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false"
          data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-sortable="false"
          data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-collapsed="false">
					<div>

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->

						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body no-padding smart-form">
                <fieldset>
                  <div class="contenidoBotones">
										<div class="row">
								<div class="tab-pane fade in active" id="s1">
									<section id="widget-grid" class="">
				
										<!-- row -->
										<div class="row">
									
											<!-- NEW WIDGET START -->
											<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												
												<!-- Widget ID (each widget will need unique ID)-->
												<div   data-widget-editbutton="false" style="padding-left: 50px; padding-right: 70px;">
													
													<header>
														<h2>Presentaciones</h2>
													</header>
													
															<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%" >
																<thead>
																	<tr>
																		<th data-hide="phone">ID</th>
																		<th data-class="expand">Nombre</th>
																		<th>Usuario</th>
																		<th data-hide="phone">Grupo</th>
																		<th data-hide="phone,tablet">Fecha</th>
																		<th data-hide="phone,tablet">Descripci&oacute;n</th>
																		<th>Acciones</th>
																		
																	</tr>
																</thead>
																<tbody>
																	
																	<?php foreach ($presentaciones as $presentacion)
																	{
																		echo 
																		"<tr>
																			<td>".$presentacion->id."</td>
																			<td>".$presentacion->n_publico."</td>
																			<td>".$presentacion->nombreUsuario." ".$presentacion->apellidoUsuario."</td>
																			<td>".$presentacion->grupo."</td>
																			<td>".$presentacion->fecha."</td>
																			<td>".$presentacion->descripcion."</td>
																			
																			<td class='text-center'>
																				<a class='txt-color-blue' onclick='' href='".$presentacion->ruta."' title='Descargar'><i class='fa fa-download fa-3x'></i></a>
																				<a class='txt-color-red' style='cursor: pointer;' onclick='delete_file(".$presentacion->id.",\"".$presentacion->ruta."\")' title='Eliminar'><i class='fa fa-trash-o fa-3x'></i></a>
																				<a class='txt-color-green' style='cursor: pointer;' onclick='editar(1,".$presentacion->id.")'  title='Editar'><i class='fa fa-edit fa-3x'></i></a>
																			</td>
																		</tr>";
																	} ?>
																	
																</tbody>
															</table>
									
														
														<!-- end widget content -->
									
													
													<!-- end widget div -->
												</div>
												<!-- end widget -->
									
											</article>
									
										</div>
									
									</section>
								</div>
										 </div>
									</div>
								</fieldset>
						</div>
						<!-- end widget content -->

					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			</article>
			<!-- END COL -->
		</div>
				<div class="row">         
			        <!-- a blank row to get started -->
			        <div class="col-sm-12">
			            <br />
			            <br />
			        </div>
		        </div>
			</div>
			<!-- END MAIN CONTENT -->
<style>
.link
{
	margin: 0.5rem;
}
.minh
{
	padding: 50px;
}
.link a:hover
{
	text-decoration: none !important;
}
</style>

		<script src="/template/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="/template/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
		<script src="/template/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>
		<script src="/template/js/plugin/bootbox/bootbox.min.js"></script>
		<script src="/template/js/plugin/dropzone/dropzone.min.js"></script>
		<script src="/template/js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
		<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
		<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
		
<script type="text/javascript">

																	
		$(document).ready(function() {

			/* BASIC ;*/
				var responsiveHelper_dt_basic = undefined;
				var responsiveHelper_datatable_fixed_column = undefined;
				var responsiveHelper_datatable_col_reorder = undefined;
				var responsiveHelper_datatable_tabletools = undefined;
				
				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};

				$('#dt_basic').dataTable({
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			/* END BASIC */

			/* BASIC ;*/
				var responsiveHelper_dt_basic = undefined;
				var responsiveHelper_datatable_fixed_column = undefined;
				var responsiveHelper_datatable_col_reorder = undefined;
				var responsiveHelper_datatable_tabletools = undefined;
				
				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};

				$('#dt_basic_paquete').dataTable({
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			/* END BASIC */
			
				
			pageSetUp();

		})
</script>