 <!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
					<a href="/bo"><i class="fa fa-home"></i> Menu</a>
				<span>> <a href="/bo/configuracion/"> Configuracion </a>
				> <a href="/bo/configuracion/tipoRed"> Tipo De Red </a>
				>	Listar
				</span>
			</h1>
		</div>
	</div>
<section id="widget-grid" class="">
<div class="row" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;margin-bottom:2rem;">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<legend>Mostrar Redes</legend>
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
					<td><a onclick="modificar(<?= $red->id;?>)" href="#" title="Modificar">
	
	    <i class="fa fa-pencil-square fa-3x">
	    </i>
	
	</a></td>
				</tr>
			<? } ?>
		</tbody>
	</table>
	</div>
</section>
</div>
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
