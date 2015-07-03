<h1>   Solo puedes tener <?php echo $red_frontales[0]->frontal ?>, pero puedes afiliar en red"</h1>
		<div id="faseuno" class="col-xs-12 col-sm-6 col-md-3">
			<div class="panel panel-success pricing-big">
				<div class="panel-heading">
					<h3 class="panel-title">
					<i class="fa fa-plane"></i> Fase 1</h3>
				</div>
				<div class="panel-body no-padding text-align-center">
					<div class="price-features">
						<h2>Si eliges fase 1 no podras elegir fase 2</h2>
					</div>
				</div>
				<div class="panel-footer text-align-center">
					<a id="fase1" href="javascript:void(0);" class="btn btn-primary btn-block" role="button">Seleccionar</a>
				</div>
			</div>
		</div>
		
		<div id="faseuno" class="col-xs-12 col-sm-6 col-md-3">
			<div class="panel panel-success pricing-big">
				<div class="panel-heading">
					<h3 class="panel-title">
					<i class="fa fa-plane"></i> Fase 2</h3>
				</div>
				<div class="panel-body no-padding text-align-center">
					<div class="price-features">
						<h2>Cargo unico de $ 10 dolares</h2>
					</div>
				</div>
				<div class="panel-footer text-align-center">
					<a id="fase1" onclick="fase(2)" class="btn btn-primary btn-block" role="button">Seleccionar</a>
				</div>
			</div>
		</div>
		
<script type="text/javascript">
function fase(fase){
	$.ajax({
			type: "POST",
			url: "/ov/perfil_red/CambioFase",
			data: {
				id: <?php echo $id ?>,
				red: <?php echo $red; ?>,
				fase: fase
					},
		})
		.done(function(msg)
		{
			alert('Has Cambiado de fase'+msg);
			location.reload();
		})
	});
}
</script>
													        
											