
<form id="nueva" class="smart-form"  novalidate="novalidate" >
							<fieldset>
								<input type="text" class="hide" value="<?php echo $_POST['id']; ?>" name="id">
								<label class="input"> Nombre
											<input type="text" name="nombre" placeholder="Nombre"class="form-control" value="<?php echo $categoria[0]->descripcion; ?>" required>
										</label>
										<label class="select"> Selecione Red
											<select name="red"">
												<?php foreach ($redes as $red){
												
													if( $categoria[0]->id_red == $red->id ) {?>
														<option value="<?php echo $red->id; ?>" selected="selected"><?php echo $red->nombre; ?></option>
													<?php }else { ?> 
														<option value="<?php echo $red->id; ?>"><?php echo $red->nombre; ?></option>
													<?php }
													}?>
											</select> <i></i> </label>
										<label class="select" > Estatus
											<select name="estado" required value="<?php echo $categoria[0]->estatus; ?>">
												<?php if($categoria[0]->estatus == 'ACT'){ ?>
													<option value="ACT" selected="selected">Activado</option>
													<option value="DES">Desactivado</option>
												<?php } else {?>
													<option value="ACT" >Activado</option>
													<option value="DES" selected="selected">Desactivado</option>
												<?php }?>
											</select> <i></i> </label>
									
							</fieldset>
							<footer>
								<a class="btn btn-primary" onclick="enviar()">
									Guardar
								</a>
							</footer>
						</form>

<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<script type="text/javascript">
function enviar() {
	
	 $.ajax({
							type: "POST",
							url: "/bo/categorias/actualizar_categoria",
							data: $('#nueva').serialize()
						})
						.done(function( msg ) {
							
									bootbox.dialog({
										message: msg,
										title: "Atención",
										buttons: {
											success: {
											label: "Ok!",
											className: "btn-success",
											callback: function() {
												location.href="/bo/categorias/index";
												}
											}
										}
									});
						});//fin Done ajax
		
}
</script>