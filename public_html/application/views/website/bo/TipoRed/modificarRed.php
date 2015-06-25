<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<form action="/bo/tipo_red/actualizar_red" method="POST" role="form">
	
		<div class="form-group">
			
			<input type="text" class="hide" name="id" value = '<?= $id_red;?>' >
			
			<label for="">Nombre</label>
			<input type="text" class="form-control" name="nombre" >

			<label for="">Descripcion</label>
			<input type="text" class="form-control" name="descripcion" >
		</div>
		<button type="submit" class="btn btn-primary" >Actualizar</button>
	</form>
</div>
