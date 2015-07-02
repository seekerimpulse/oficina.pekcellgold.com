
			<!-- MAIN CONTENT -->
			<div id="content">
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h1 class="page-title txt-color-blueDark">
							<a href="/ov"><i class="fa fa-home"></i> Menu</a>
							<a href="/ov/billetera2/index"> > Billetera</a>
							<span> > Pedir Plata</span>
							
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
													<?php $total = $ganancias; ?>
															<form action="send_mail" method="post" id="contact-form1"  class="smart-form">
																<header>Comiciones: $<?=number_format($ganancias,2)?></header>
																<fieldset>
																	<header>Impuestos</header>
																	<?php foreach ($impuestos as $impuesto) {?>
																	<section class="col col-10">
																		<label class="label">Impuesto <?php echo $impuesto->descripcion; ?></label>
																		<label class="input">
																			<input name="impuestos" type="text" readonly class="from-control" value="<?php echo $impuesto->impuesto; ?>"/>
																		</label>
																	</section>
																
																	<?php 
																		$total-=$impuesto->impuesto;
																		} ?>
																</fieldset>
																<fieldset>
																	<header>Retenciones</header>
																	<?php foreach ($retenciones as $retencion) {?>
																	<section class="col col-10">
																		<label class="label"><?php echo $retencion['descripcion']; ?></label>
																		<label class="input">
																			<input type="text" class="from-control" name="retenciones" value="<?php echo $retencion['valor']; ?>" readonly />
																		</label>
																	</section>
																	<?php 
																		$total-=$retencion['valor'];
																		} ?>
																</fieldset>
																<fieldset>
																	<section class="col col-10">
																		<label class="label">Saldo</label>
																		<label class="input">
																			<input type="number" name="saldo" class="from-control" id="saldo" value="<?php echo $total; ?>" readonly />
																		</label>
																	</section>
																	<section class="col col-10">
																		<label class="label">Pedir Dinero </label>
																		<label class="input">
																			<input name="cobro" type="number" class="from-control" id="cobro"/>
																		</label>
																	</section>
																	<section class="col col-10">
																		<label class="label">Método de pago</label>
																		<label class="select">
																			<select required name="metodo">
																			<?foreach ($metodo_cobro as $key)
																			{
																				echo '<option value="'.$key->id_metodo.'">'.$key->descripcion.'</option>';
																			}?>
																			</select>
																		</label>
																	</section>
																	<section class="col col-10">
																		<label class="label">Saldo Final</label>
																		<label class="input">
																			<input value="" type="number" name="neto" id="neto" class="from-control" readonly />
																		</label>
																	</section>
																</fieldset>	
																
																<footer>
																	<button type="button" onclick="cobrar()" class="btn btn-primary" id="enviar">
																		Cobrar
																	</button>
																</footer>
															</form>
														
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
		url: "/ov/billetera2/cobrar",
		data: $('#contact-form1').serialize()
		})
		.done(function( msg ) {
			
			bootbox.dialog({
			message: msg,
			title: "Transacion",
			buttons: {
				success: {
				label: "Ok!",
				className: "btn-success",
				callback: function() {
					location.href='historial';
					}
				}
			}
		});

		});
	}
	</script>