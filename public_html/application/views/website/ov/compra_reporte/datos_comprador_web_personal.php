
<!-- MAIN CONTENT -->
<div id="content">
	
	<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
									<!-- widget div-->
					<div>
						<div class="widget-body">
							<form method="POST" enctype="multipart/form-data"   action="" class="smart-form">
							
									
								<fieldset>
									<legend>Datos del producto</legend>
									<div id="form_mercancia">
										<div class="row">
											<fieldset>
											
												<section class="col-sm-12 col-md-12 col-lg-12" >
													<label class="input">
														DNI: 
														<input required type="text" value='' id="concepto" name="concepto">
													</label>
												</section>
												
												<section class="col-sm-12 col-md-12 col-lg-12">
													<label class="input">
														Nombre: 
														<input required type="text" value='' id="nombre_p" name="nombre">
													</label>
												</section>
												
												<section class="col-sm-12 col-md-12 col-lg-12">
													<label class="input">
														Apellido: 
														<input required type="text" value='' id="nombre_p" name="nombre">
													</label>
												</section>
												
												<section class="col-sm-12 col-md-12 col-lg-12">País de residencia
														<label class="select">
															<select id="pais" required name="pais" >
																<option value="-" selected>-- Seleciona un pais --</option>
																<?foreach ($pais as $key)
																{?>
																<option value="<?=$key->Code?>">
																	<?=$key->Name?>
																</option>
																<?}?>
															</select>
														</label>
												</section>
												
												<section class="col-sm-12 col-md-12 col-lg-12">
													<label class="input">
														Estado: 
														<input required type="text" value='' id="nombre_p" name="nombre">
													</label>
												</section>
												
												<section class="col-sm-12 col-md-12 col-lg-12">
													<label class="input">
														Municipio: 
														<input required type="text" value='' id="nombre_p" name="nombre">
													</label>
												</section>
												
												<section class="col-sm-12 col-md-12 col-lg-12" >
													<label class="input">
														Colonia: 
														<input required type="text" value='' id="concepto" name="concepto">
													</label>
												</section>
												
												<section class="col-sm-12 col-md-12 col-lg-12" >
													<label class="input">
														Dirección: 
														<input required type="text" value='' id="concepto" name="concepto">
													</label>
												</section>
												
												<section class="col-sm-12 col-md-12 col-lg-12" >
													<label class="input">
														e-mail: 
														<input required type="email" value='' id="concepto" name="concepto">
													</label>
												</section>
												
												<section class="col-sm-12 col-md-12 col-lg-12" >
													<label class="input">
														Telefono: 
														<input required type="number" value='' id="concepto" name="concepto">
													</label>
												</section>
												
												
											</fieldset>
											
											
													
										</div>
								</div>
							</fieldset>
							<section class="col col-12 pull-right" >
								<button type="submit" class="btn btn-success">
									Agregar
								</button>
							</section>
						</form>
					</div>
				</div>
																<!-- end widget div -->
			</article>
														<!-- END COL -->
		</div>

	</section>
												<!-- end widget grid -->
</div>
											<!-- END MAIN CONTENT -->
							
<script type="text/javascript">


</script>
	</html>