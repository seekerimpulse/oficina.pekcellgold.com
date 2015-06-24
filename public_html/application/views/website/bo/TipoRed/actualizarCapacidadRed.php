<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<form action="/bo/capacidadRed/actualizar_capacidad_de_la_red" method="POST" role="form">

		<legend>Capacidad de la Red </legend>
	
		<div class="form-group">
			<label for="">Frontales</label>
			<input type="text" class="form-control" name="frontal" value = '<?= $capacidadRed[0]->frontal;
			?>'>

			<label for="">Profundidad</label>
			<input type="text" class="form-control" name="profundidad" value = '<?= $capacidadRed[0]->profundidad;
			?>'>
		</div>
		<button type="submit" class="btn btn-primary">Actualizar</button>
	</form>
</div>