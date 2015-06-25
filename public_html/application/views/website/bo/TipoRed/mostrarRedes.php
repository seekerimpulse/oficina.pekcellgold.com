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
				<td><a class="txt-color-white" onclick="modificar(<?= $red->id;?>)" href="#" title="Modificar">

    <i class="fa fa-upload">
    </i>

</a></td>
			</tr>
		<? } ?>
	</tbody>
</table>

<script type="text/javascript">
function modificar(id_red)
{

$.ajax({
	type: "POST",
	url: "/bo/tipo_red/modificar_red",
	data: {id: id_red},
})
.done(function( msg )
{
	bootbox.dialog({
	message: msg,
	title: 'Modificar Red',
})//fin done ajax
});//Fin callback bootbox
}
</script>
