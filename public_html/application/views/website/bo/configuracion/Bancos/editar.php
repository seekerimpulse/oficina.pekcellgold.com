
												<form id="add-event-form" class="smart-form col-sm-6 col-md-6 col-lg-6">
													<fieldset>
														<div class="form-group">
															<b>Nombre de Banco</b>
															<input class="form-control"  id="banco" name="banco" type="text" placeholder="Nombre del banco">
														</div><br>
														<div class="form-group">
															<label class="label">Pais</label> 
															<label class="select">
																<select name="pais" id="pais" required>
																	<option value="0">Selecciona el pais</option>
																	<?php foreach ($paices as $pais) {?>
																		<option value="<?php echo $pais->Code; ?>"><?php echo $pais->Name; ?></option>
																	<?php } ?>
																</select>
															</label>
														</div>
														<br>
														<div class="form-group">
															<b>N° de Cuenta</b>
															<input class="form-control"  id="cuenta" name="cuenta"  type="number" placeholder="Numero de cuenta" onChange="validarSiNumero(this.value);">
														</div><br>
														<div class="form-group">
															<b>CLABE</b>
															<input class="form-control"  id="clabe" name="clabe" type="number" onChange="validarSiNumero(this.value);">
														</div><br>
													</fieldset>
													
													<button style="margin-left: 3rem;" class="btn btn-success" type="button" id="new_evento" onclick="agregar_banco()" >
														Agregar Banco
													</button>
												</form>
						
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
<script type="text/javascript">
function validarSiNumero(numero){
    if (!/^([0-9])*$/.test(numero)){
      alert("El valor " + numero + " no es un número");
      
    }
  }
</script>			
