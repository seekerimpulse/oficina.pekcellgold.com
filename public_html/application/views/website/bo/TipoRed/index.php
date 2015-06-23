<table class="table table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Descripcion</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($redes as $red) {?>
			<tr>
				<td><?= $red->id;?></td>
				<td><?= $red->nombre;?></td>
				<td><?= $red->descripcion;?></td>
			</tr>
		<? } ?>
	</tbody>
</table>