  <div id="myTabContent1" class="tab-content padding-10" style="margin-bottom: 6rem;">

		<div class="row col-xs-12 col-md-6 col-sm-4 col-lg-3 pull-right">
			<div class="col-xs-4 col-md-4 col-sm-4 col-lg-4">
				<center>
				<a title="Editar" href="#" class="txt-color-blue"><i class="fa fa-eye fa-3x"></i></a>
				<br>Editar
				</center>
			</div>
			<div class="col-xs-4 col-md-4 col-sm-4 col-lg-4">
			<center>	
				<a title="Bloquear" href="#" class="txt-color-gray"><i class="fa fa-unlock fa-3x"></i></a>
				<br>Bloquear
				</center>
			</div>
			<div class="col-xs-4 col-md-4 col-sm-4 col-lg-4">
				<center>
					<a title="Desbloquear" href="#" class="txt-color-gray"><i class="fa fa-lock fa-3x"></i></a>
					<br>Desbloquear
				</center>
			</div>
		</div>
		
		<table id="datatable_tabletools" class="table table-striped table-bordered table-hover" width="100%">
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
			        <td><?php echo $afiliado->id;?></td>
	                <td><?php echo $afiliado?></td>
	                <td><?php echo $afiliado->username?></td>
		            <td><?php echo $afiliado->nombre?></td>
		            <td><?php echo $afiliado->apellido?></td>
			        <td><?php echo $afiliado->email?></td>
			        <td><?php echo $afiliado->descripcion?></td>
			        <td>
			        	
			        	<?if($afiliado->estatus=='Desactivado'){?>
			        	<a title="Desbloquear" href="#" onclick="estado_afiliado(1,<?=$afiliado->id?>)" class="txt-color-gray"><i class="fa fa-lock fa-3x"></i></a>
						<?}else{?>
						<a title="Bloquear" href="#" onclick="estado_afiliado(2,<?=$afiliado->id?>)" class="txt-color-gray"><i class="fa fa-unlock fa-3x"></i></a>
						<?}?>
						
				        <a title="Editar" href="#" onclick="modificar_afiliado(<?php echo $afiliado->id;?>)" class="txt-color-blue"><i class="fa fa-pencil fa-3x"></i></a>
					</td>
			        
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

function estado_afiliado(estatus, id_afiliado)
{
		
$.ajax({
	type: "POST",
	url: "/bo/comercial/cambiar_estado_afiliado",
	data: {id:id_afiliado, 
		estatus: estatus
	},
})
.done(function( msg )
{
	location.href = "/bo/comercial/red_tabla";
	bootbox.dialog({
		message: msg,
	title: 'Modificar Afiliado',

})//fin done ajax
});//Fin callback bootbox
}

$(document).ready(function() {
	
	pageSetUp();
	
	/* // DOM Position key index //

	l - Length changing (dropdown)
	f - Filtering input (search)
	t - The Table! (datatable)
	i - Information (records)
	p - Pagination (paging)
	r - pRocessing 
	< and > - div elements
	<"#id" and > - div with an id
	<"class" and > - div with a class
	<"#id.class" and > - div with an id and class
	
	Also see: http://legacy.datatables.net/usage/features
	*/	

	/* BASIC ;*/
		var responsiveHelper_dt_basic = undefined;
		var responsiveHelper_datatable_fixed_column = undefined;
		var responsiveHelper_datatable_col_reorder = undefined;
		var responsiveHelper_datatable_tabletools = undefined;
		
		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

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

	/* END BASIC */
	
	/* COLUMN FILTER  */
    var otable = $('#datatable_fixed_column').DataTable({
    	//"bFilter": false,
    	//"bInfo": false,
    	//"bLengthChange": false
    	//"bAutoWidth": false,
    	//"bPaginate": false,
    	//"bStateSave": true // saves sort state using localStorage
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_fixed_column) {
				responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_fixed_column.respond();
		}		
	
    });
    
    // custom toolbar
    $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');
    	   
    // Apply the filter
    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {
    	
        otable
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
            
    } );
    /* END COLUMN FILTER */   

	/* COLUMN SHOW - HIDE */
	$('#datatable_col_reorder').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_col_reorder) {
				responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_col_reorder.respond();
		}			
	});
	
	/* END COLUMN SHOW - HIDE */

	/* TABLETOOLS */
	$('#datatable_tabletools').dataTable({
		
		// Tabletools options: 
		//   https://datatables.net/extensions/tabletools/button_options
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "oTableTools": {
        	 "aButtons": [
             "copy",
             "csv",
             "xls",
                {
                    "sExtends": "pdf",
                    "sTitle": "SmartAdmin_PDF",
                    "sPdfMessage": "SmartAdmin PDF Export",
                    "sPdfSize": "letter"
                },
             	{
                	"sExtends": "print",
                	"sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
            	}
             ],
            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
        },
		"autoWidth" : true,
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_tabletools) {
				responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_tabletools.respond();
		}
	});
	
	/* END TABLETOOLS */

})


</script>