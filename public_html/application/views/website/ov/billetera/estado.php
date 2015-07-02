
			<!-- MAIN CONTENT -->
			<div id="content">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h1 class="page-title txt-color-blueDark">
							<a href="/ov"><i class="fa fa-home"></i> Menu</a>
							<a href="/ov/billetera2/index"> > Billetera</a>
							<span> > Estado</span>
							
						</h1>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h1 class="page-title txt-color-blueDark">
							Mis ganancias: <span class="txt-color-black"><?=number_format($ganancias,2)?></span>
						</h1>
					</div>
				</div>
				<!-- row -->
				<div class="row">

					
				</div>
				<!-- end row -->

				<!-- row -->
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="well">

							<section id="widget-grid" class="">
							
								<!-- row -->
								<div class="row">
							
									<!-- NEW WIDGET START -->
									<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

										<!-- Widget ID (each widget will need unique ID)-->
										<div class="jarviswidget jarviswidget-color-purity" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="true">
											<!-- widget options:
											usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
							
											data-widget-colorbutton="false"
											data-widget-editbutton="false"
											data-widget-togglebutton="false"
											data-widget-deletebutton="false"
											data-widget-fullscreenbutton="false"
											data-widget-custombutton="false"
											data-widget-collapsed="true"
											data-widget-sortable="false"
							
											-->
											
							
											<!-- widget div-->
											<div>
							
												<!-- widget edit box -->
												<div class="jarviswidget-editbox">
													<!-- This area used as dropdown edit box -->
												</div>
												<!-- end widget edit box -->
							
												<!-- widget content -->
												<div class="widget-body">
													<div id="myTabContent1" class="tab-content padding-10">
													<h1 class="text-center">Estado de Cuenta del mes</h1>
													<?php $total = $ganancias; ?>
													
															<table id="dt_basic" class="table table-striped table-bordered table-hover">
																<?php foreach ($impuestos as $impuesto) {?>
																	<tr>
																		<td>Impuesto <?php echo $impuesto->descripcion; ?></td>
																		<td><?php echo $impuesto->impuesto; ?></td>
																	</tr>
																
																	<?php $total-=$impuesto->impuesto;
																	} ?>
																	
																	<?php foreach ($retenciones as $retencion) {?>
																	<tr>
																		<td><?php echo $retencion['descripcion']; ?></td>
																		<td><?php echo $retencion['valor']; ?></td>
																	</tr>
																	<?php $total-=$retencion['valor'];
																	} ?>
																	
																	<tr>
																		<td>Saldo</td>
																		<td><?php echo $total; ?></td>
																	</tr>
																</table>
															
														
													</div>
												</div>
												<!-- end widget content -->
							
											</div>
											<!-- end widget div -->
										</div>
										<!-- end widget -->
							
									</article>
								</div>
							</section>
						<!-- end widget grid -->
						</div>
					</div>
				<!-- row -->
				</div>
				<div class="row">
			        <div class="col-sm-12">
			            <br />
			            <br />
			        </div>
		        </div>
				<!-- end row -->

			</div>
			<!-- END MAIN CONTENT -->

		<!-- PAGE RELATED PLUGIN(S) 
		<!-- Morris Chart Dependencies -->
		<script src="/template/js/plugin/morris/raphael.min.js"></script>
		<script src="/template/js/plugin/morris/morris.min.js"></script>

		<script src="/template/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="/template/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

		<script type="text/javascript">
			// PAGE RELATED SCRIPTS

			/*
			 * Run all morris chart on this page
			 */
			$(document).ready(function() {
				
				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

				$("#cobro").keypress(CalcularSaldo);
				$('#enviar').attr("disabled", true);
					});

			//setup_flots();
			/* end flot charts */
			
function CalcularSaldo(evt){
				
				var saldo = $("#saldo").val();
				var pago = $("#cobro").val() + String.fromCharCode(evt.charCode);
				var neto = saldo-pago;
				$("#neto").val(neto);
				if(neto > 0){
					$('#enviar').attr("disabled", false);
					}else{
						$('#enviar').attr("disabled", true);
					}
			}
function cobrar()
	{
		$.ajax({
		type: "POST",
		url: "/ov/billetera/cobrar",
		data: $('#contact-form1').serialize()
		})
		.done(function( msg ) {

			bootbox.dialog({
			message: "Tu cobro se esta procesando",
			title: "Cobro",
			buttons: {
				success: {
				label: "Ok!",
				className: "btn-success",
				callback: function() {
					location.href='';
					}
				}
			}
		});

		});
	}
	</script>