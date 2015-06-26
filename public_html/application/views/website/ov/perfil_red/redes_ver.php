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
<div class="well">
		<fieldset>
											<legend>Red</legend>
											<div class="row">
											<? foreach ($redes as $red ) { ?>
												<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
													<a href="/ov/red/mi_red?id=<?= $red->id ?>">
														<div class="well well-sm txt-color-white text-center link_dashboard" style="background:#60a917">
																<h5><?= $red->nombre;?></h5>
														</div>	
													</a>
												</div>
												<?php } ?>
			</fieldset>
	</div>
</div>
</section>	
</div>	