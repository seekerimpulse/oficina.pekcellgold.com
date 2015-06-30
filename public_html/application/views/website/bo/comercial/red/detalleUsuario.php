<div style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-right: 0px; margin-left: 0px; padding-bottom: 3rem;" class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<form action="/bo/comercial/actualizar_afiliado" method="POST" role="form">
			<legend>Modificar Datos del Afiliado</legend>


			<div class="form-group">

				<input type="text" class="hide" name="id" id="id" value = '<?= $detalle[0]->id; ?>' >

				<label for="">Nombre</label>
				<input type="text" class="form-control" name="nombre" id="nombre"  value = '<?= $detalle[0]->nombre; ?>'>

				<label for="">Apellido</label>
				<input type="text" class="form-control" name="apellido" id="apellido" value = '<?= $detalle[0]->apellido; ?>'>

				<label for="">Usuario</label>
				<input type="text" class="form-control" name="username" id="username" value = '<?= $detalle[0]->username; ?>'>
				
				<label for="">e-mail</label>
				<input type="text" class="form-control" name="email" id="email" value = '<?= $detalle[0]->email; ?>'>
				
				<section class="col col-2">
					Sexo

					<label class="select">
						<select id="sexo" required name="sexo">
							
							<?	foreach ($tiposDeSexo as $key)
								{
									if ($key->descripcion == $detalle[0]->sexo) {

									?>
									
										<option value="<?=$key->id_sexo?>"  selected="selected">
											<?= $key->descripcion;?>	
										</option>
															
								<?	}

									else {
										?>

										<option value="<?=$key->id_sexo?>" >
											<?= $key->descripcion;?>	
										</option>
								<?  }
								}
							?>

						</select>
					</label>
				</section>

				<section class="col col-3">
					<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
						<input required id="datepicker" type="text" name="nacimiento" value="<?=$detalle[0]->fecha_nacimiento?>" >
					</label>
																</section>

				<section class="col col-2">
					Estado Civil

					<label class="select">
						<select id="estadoCivil" required name="estadoCivil">

							<?	foreach ($tiposDeEstadoCivil as $key)
								{
									if ($key->descripcion == $detalle[0]->estado_civil) {

									?>
									
										<option value="<?=$key->id_edo_civil?>"  selected="selected">
											<?= $key->descripcion;?>	
										</option>
															
								<?	}

									else {
										?>

										<option value="<?=$key->id_edo_civil?>" >
											<?= $key->descripcion;?>	
										</option>
								<?  }
								}
							?>

						</select>
					</label>
				</section>

				<section class="col col-2">
					Tipo de Usuario
				
					<label class="select">
						<select id="tipoUsuario" required name="tipoUsuario">
							
							<?	foreach ($tiposDeUsuario as $key)
								{
									if ($key->descripcion == $detalle[0]->tipo_usuario) {

									?>
									
										<option value="<?=$key->id_tipo_usuario?>"  selected="selected">
											<?= $key->descripcion;?>	
										</option>
															
								<?	}

									else {
										?>

										<option value="<?=$key->id_tipo_usuario?>" >
											<?= $key->descripcion;?>	
										</option>
								<?  }
								}
							?>

						</select>
					</label>
				</section>


				<section class="col col-2">
					Nivel de Estudios
				
					<label class="select">
						<select id="estudio" required name="estudio">
							
							<?	foreach ($tiposDeEstudio as $key)
								{
									if ($key->descripcion == $detalle[0]->estudio) {

									?>
									
										<option value="<?=$key->id_estudio?>"  selected="selected">
											<?= $key->descripcion;?>	
										</option>
															
								<?	}

									else {
										?>

										<option value="<?=$key->id_estudio?>" >
											<?= $key->descripcion;?>	
										</option>
								<?  }
								}
							?>

						</select>
					</label>
				</section>

				<section class="col col-2">
					Ocupación
				
					<label class="select">
						<select id="ocupacion" required name="ocupacion">
							
							<?	foreach ($tiposDeOcupacion as $key)
								{
									if ($key->descripcion == $detalle[0]->ocupacion) {

									?>
									
										<option value="<?=$key->id_ocupacion?>"  selected="selected">
											<?= $key->descripcion;?>	
										</option>
															
								<?	}

									else {
										?>

										<option value="<?=$key->id_ocupacion?>" >
											<?= $key->descripcion;?>	
										</option>
								<?  }
								}
							?>

						</select>
					</label>
				</section>

				<section class="col col-2">
					Tiempo de Dedicación
				
					<label class="select">
						<select id="tiempoDedicado" required name="tiempoDedicado">
							
							<?	foreach ($tiposDeTiempoDedicacion as $key)
								{
									if ($key->descripcion == $detalle[0]->tiempo_dedicado) {

									?>
									
										<option value="<?=$key->id_tiempo_dedicado?>"  selected="selected">
											<?= $key->descripcion;?>	
										</option>
															
								<?	}

									else {
										?>

										<option value="<?=$key->id_tiempo_dedicado?>" >
											<?= $key->descripcion;?>	
										</option>
								<?  }
								}
							?>

						</select>
					</label>
				</section>

				<section class="col col-2">
					Estado de Afiliado
				
					<label class="select">
						<select id="estadoAfiliado" required name="estadoAfiliado">
							
							<?	foreach ($tiposDeEstadosAfiliado as $key)
								{
									if ($key->descripcion == $detalle[0]->estatus_afiliado) {

									?>
									
										<option value="<?=$key->id_estatus?>"  selected="selected">
											<?= $key->descripcion;?>	
										</option>
															
								<?	}

									else {
										?>

										<option value="<?=$key->id_estatus?>" >
											<?= $key->descripcion;?>	
										</option>
								<?  }
								}
							?>

						</select>
					</label>
				</section>

				<label for="">Nombre del Co-aplicante</label>
				<input type="text" class="form-control" name="nombreCo" id="nombreCo"  value = '<?= $detalle[0]->nombre_co; ?>'>

				<label for="">Apellido del Co-aplicante</label>
				<input type="text" class="form-control" name="apellidoCo" id="apellidoCo" value = '<?= $detalle[0]->apellido_co; ?>'>

			</div>
			<button type="submit" class="btn btn-primary">Actualizar</button>
		</form>
		
	</div>
</div>

<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>

<script type="text/javascript">


$(function()
{
	var a = new Date();
 	año = a.getFullYear()-19;
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat:"yy-mm-dd",
		maxDate: año+"-12-31",
		changeYear: true
	});
});

</script>
<!-- 
select U.id, UP.nombre, UP.apellido, U.username, U.email, CS.descripcion as sexo,
CEC.descripcion as estado_civil, CTU.descripcion as tipo_usuario, CE.descripcion as estudio,
CO.descripcion as ocupacion, CTD.descripcion as tiempo_dedicado, CEA.descripcion

from users U, user_profiles UP, cat_sexo CS, cat_edo_civil CEC, cat_tipo_usuario CTU,
cat_estudios CE, cat_ocupacion CO, cat_tiempo_dedicado CTD, cat_estatus_afiliado CEA
 
where UP.id_sexo = CS.id_sexo and UP.id_edo_civil = CEC.id_edo_civil and UP.id_tipo_usuario = CTU.id_tipo_usuario
and UP.id_estudio = CE.id_estudio and UP.id_ocupacion = CO.id_ocupacion and U.id = UP.user_id 
and UP.id_tiempo_dedicado = CTD.id_tiempo_dedicado and UP.id_estatus = CEA.id_estatus

 group by (U.id);
 -->
