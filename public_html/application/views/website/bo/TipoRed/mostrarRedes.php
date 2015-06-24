<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<legend>Mostrar Redes</legend>
</div>
<table class="table table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Descripcion</th>
			<th>Opciones</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($redes as $red) {?>
			<tr>
				<td><?= $red->id;?></td>
				<td><?= $red->nombre;?></td>
				<td><?= $red->descripcion;?></td>
				<td><a class="txt-color-white" onclick="modificar()" href="#" title="Modificar">

    <i class="fa fa-upload">
    </i>

</a></td>
			</tr>
		<? } ?>
	</tbody>
</table>

<script type="text/javascript">
function eliminar(id)
{
	bootbox.dialog({
			message: "Confirme que <b>eliminará</b> al usuario con el id <b>"+id+"</b>",
			title: "Atención",
			buttons: {
				success: {
				label: "Eliminar!",
				className: "btn-success",
				callback: function() {
						$.ajax({
							type: "POST",
							url: "/bo/comercial/del_user",
							data: {id: id},
						})
						.done(function( msg )
						{
							bootbox.dialog({
								message: msg,
								title: "Atención",
								buttons: {
									success: {
									label: "Cerrar!",
									className: "btn-success",
									callback: function() {
										//location.href="";
										}
									}
								}
							});
						});
					}
				},
				danger: {
				label: "Cancelar!",
				className: "btn-danger",
				callback: function() {
					}
				}
			},
		});
}
</script>
