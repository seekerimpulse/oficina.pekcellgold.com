<div class="tab-pane fade in active" id="s1" style="margin-bottom: 6rem">
	<div class="row">
		<h5 class="col-xs-12 col-sm-12 col-md-8 col-lg-8">De click en la bandera del país para editar</h5>
		<a onclick="dato_pais_multiple()" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 pull-right text-blue" href="#"><h5>Edicion multiple <i class="fa fa-check-square-o"></i></h5></a>
	</div>
	<div class="row">
		<form id="multiple_pais" action="/bo/admin/dato_pais_multiple" method="POST">
			<?foreach ($pais as $key)
			{?>
				<div class="col-xs-6 col-md-3 col-sm-4 smart-form">
					<label style="margin-top: 2px !important;" class="checkbox col col-2 pull-right">
					<input class="pais_check" type="checkbox" value="<?=$key->Code?>" name="pais_check[]">
					<i></i></label>
						<div onclick="dato_pais('<?=$key->Code?>','<?=$key->Name?>')" class="col-xs-9 col-md-9 col-sm-9 demo-icon-font">
							<img class="flag flag-<? echo strtolower($key->Code2)?>" src="/template/img/blank.gif"> <?=$key->Name?>
						</div>
				</div>
			<?}?>
		</form>
	</div>
</div>

<script type="text/javascript">
function dato_pais(codigo,nombre)
{
	$.ajax({
		type: "POST",
		url: "/bo/admin/dato_pais",
		data: {pais: codigo},
	})
	.done(function( msg )
	{
		bootbox.dialog({
		message: msg,
		title: nombre,
		buttons: {
			success: {
			label: "Aceptar",
			className: "btn-success",
			callback: function() {

					$.ajax({
						type: "POST",
						url: "/bo/admin/actualiza_pais",
						data: $("#"+codigo).serialize(),
					})
					.done(function( msg )
					{
						bootbox.dialog({
						message: "Se han actualizado los cambios",
						title: nombre,
						buttons: {
							success: {
							label: "Aceptar",
							className: "btn-success",
							callback: function() {
								}
							}
						}
					})//fin done ajax
					});//Fin callback bootbox

				}
			},
				danger: {
				label: "Cancelar!",
				className: "btn-danger",
				callback: function() {

					}
			}
		}
	})
	});
}
function dato_pais_multiple(){
	/*bootbox.dialog({
		message: "Espere mientras se procesan los datos",
		title: "Espere",
		timeOut : 1000,
	})//fin done ajax*/

	$.ajax({
		type: "POST",
		url: "/bo/admin/dato_pais_multiple",
		data: $("#multiple_pais").serialize(),
	})
	.done(function( msg )
	{
		bootbox.dialog({
		message: msg,
		title: "Editar",
		buttons: {
			success: {
			label: "Aceptar",
			className: "btn-success",
			callback: function() {
				/*bootbox.dialog({
					message: "Espere mientras se procesan los datos",
					title: "Espere",
				})//fin done ajax*/
				$.each( $('.pais_check:checked'), function( i, val ) {

				  	//alert($(val).val());
				  	$.ajax({
						type: "POST",
						url: "/bo/admin/actualiza_pais",
						data: $("#"+$(val).val()).serialize(),
					})
					.done(function( msg )
					{
					});//Fin callback bootbox

				});
					bootbox.dialog({
						message: "Se han realizado los cambios con exito",
						title: "Prueba",
						buttons: {
							success: {
							label: "Aceptar",
							className: "btn-success",
							callback: function() {
								}
							}
						}
					})//fin done ajax
				}
			},
				danger: {
				label: "Cancelar!",
				className: "btn-danger",
				callback: function() {

					}
			}
		}
	})
	});
}
</script>