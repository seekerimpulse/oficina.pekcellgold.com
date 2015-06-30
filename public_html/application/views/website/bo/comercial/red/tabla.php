  <div id="myTabContent1" class="tab-content padding-10" style="margin-bottom: 6rem;">

		<div class="row">
			<div class="col-xs-12 col-md-6 col-sm-4 col-lg-3 pull-right">
				Editar <a title="Editar" href="#" class="txt-color-blue"><i class="fa fa-eye"></i></a>
				Desbloqueado<a title="Bloquear" href="#" class="txt-color-gray"><i class="fa fa-unlock"></i></a>
				Bloqueado<a title="Desbloquear" href="#" class="txt-color-gray"><i class="fa fa-lock"></i></a>
			</div>
		</div>
		
		<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
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
			        	
			        	<?if($afiliado->estatus=='Desactivado'){?>
			        	<a title="Desbloquear" href="#" onclick="estatus(2,<?=$afiliado->id?>)" class="txt-color-gray"><i class="fa fa-lock"></i></a>
						<?}else{?>
						<a title="Bloquear" href="#" onclick="estatus(1,<?=$afiliado->id?>)" class="txt-color-gray"><i class="fa fa-unlock"></i></a>
						<?}?>
						
				        <a title="Editar" href="#" onclick="modificar_afiliado(<?php echo $afiliado->id;?>)" class="txt-color-blue"><i class="fa fa-pencil"></i></a>
					</th>
			        
			    </tr>
			 <?} ?>
		</tbody>
		</table>
</div>

<script src="/template/js/plugin/morris/raphael.min.js"></script>
		<script src="/template/js/plugin/morris/morris.min.js"></script>
		<script src="/template/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="/template/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript">

var responsiveHelper_dt_basic = undefined;
			          									        	
function modificar_afiliado(id_afiliado)
{
		
$.ajax({
	type: "POST",
	url: "/bo/comercial/get_detalle_usuario",
	data: {id:id_afiliado},
})
.done(function( msg )
{
	bootbox.dialog({
	message: msg,
	title: 'Modificar Afiliado',
})//fin done ajax
});//Fin callback bootbox
}

function bloquear_afiliado(id_afiliado)
{
		
$.ajax({
	type: "POST",
	url: "/bo/comercial/bloquear_afiliado",
	data: {id:id_afiliado
	},
})
.done(function( msg )
{
	bootbox.dialog({
		message: msg,
	title: 'Modificar Afiliado',

})//fin done ajax
});//Fin callback bootbox
}

$('#dt_basic').dataTable({
	"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
	"autoWidth" : true,
	"preDrawCallback" : function() {
		// Initialize the responsive datatables helper once.
		if (!responsiveHelper_dt_basic) {
			responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
		}
	},
	"rowCallback" : function(nRow) {
		responsiveHelper_dt_basic.createExpandIcon(nRow);
	},
	"drawCallback" : function(oSettings) {
		responsiveHelper_dt_basic.respond();
	}
});

</script>