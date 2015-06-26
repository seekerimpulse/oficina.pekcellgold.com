  <div id="myTabContent1" class="tab-content padding-10" style="margin-bottom: 6rem;">

		<div class="row">
			<div class="col-xs-12 col-md-6 col-sm-4 col-lg-3 pull-right">
				Editar <a title="Editar" href="#" class="txt-color-blue"><i class="fa fa-eye"></i></a>
				Eliminar <a title="Eliminar" href="#" class="txt-color-red"><i class="fa fa-trash-o"></i></a> 
			</div>
		</div>
		<div class="row">&nbsp;</div>
		<table  class="table table-striped table-bordered" width="100%">
			<thead>
				<tr>
					<th>ID</th>
	                <th>Imagen</th>
	                <th>Usuario</th>
		            <th>Nombre</th>
		            <th>Apellido</th>
			        <th>e-mail</th>
			        <th>Tipo usuario</th>
			        <th>Accion</th>
		        </tr>
		    </thead>
		    <tbody>
			     <?foreach ($afiliados as $afiliado) {
			          									        	?>
			      <tr>
			        <th><?php echo $afiliado->id;?></th>
	                <th><?php echo $afiliado?></th>
	                <th><?php echo $afiliado->username?></th>
		            <th><?php echo $afiliado->nombre?></th>
		            <th><?php echo $afiliado->apellido?></th>
			        <th><?php echo $afiliado->email?></th>
			        <th><?php echo $afiliado->descripcion?></th>
			        <th>
				        <a title="Editar" href="#" onclick="modificar_afiliado('<?php $afiliado->id;?>')" class="txt-color-blue"><i class="fa fa-eye"></i></a>
						<a title="Eliminar" href="#" onclick="eliminar('<?php $afiliado->id;?>')" class="txt-color-red"><i class="fa fa-trash-o"></i></a>
					</th>
			        
			    </tr>
			 <?} ?>
		</tbody>
		</table>
</div>

<script type="text/javascript">
function modificar_afiliado(id)
{

$.ajax({
	type: "POST",
	url: "/bo/comercial/get_detalle_usuario",
	data: {id:id},
})
.done(function( msg )
{
	bootbox.dialog({
	message: msg,
	title: 'Modificar Afiliado',
})//fin done ajax
});//Fin callback bootbox
}
</script>