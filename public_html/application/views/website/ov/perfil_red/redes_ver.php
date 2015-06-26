
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