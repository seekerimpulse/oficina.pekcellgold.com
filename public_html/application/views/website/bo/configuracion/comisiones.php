			<!-- MAIN CONTENT -->
			<div id="content" >
				<div class="row">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<h1 class="page-title txt-color-blueDark">
					<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
					<span>> <a href="/bo/configuracion/"> Configuracion </a>
					> Comisiones
				</span>
						</h1>
					</div>
				</div>
	<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-md-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false"
          data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-sortable="false"
          data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-collapsed="false">
					<div>

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->

						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body no-padding smart-form">
							<form class="smart-form" style="width: 30rem;" action="/bo/configuracion/actualizar_comisiones" method="POST" role="form">
							<header>
								Configuracion Comisiones Profundidad y Puntos
							</header>
							<fieldset>
								<section>
								<?php 
								$contador=1;
								if($configuracion_profundidad){

									foreach($configuracion_profundidad as $pro){ 
										if($profundidad[0]->profundidad>=$contador){ ?>
								  		<label class="label">Profundidad <?php echo $pro->profundidad?></label>
										<label class="input"> <i class="icon-append"></i>
										<input placeholder="% de Comision" type="number" name="profundidad[]" required value="<?php echo $pro->valor?>">
										<b class="tooltip tooltip-top-right">
										<i class="fa fa-warning txt-color-teal"></i>
										Comision en profundidad <?php echo $pro->profundidad?></b>
										</label> 
																			
										<?php $contador++;
										} 
									}
									
								}else {

									while($profundidad[0]->profundidad>=$contador){ ?>
										<label class="label">Profundidad <?php echo $contador?></label>
										<label class="input"> <i class="icon-append"></i>
										<input placeholder="% de Comision" type="number" name="profundidad[]" required>
										<b class="tooltip tooltip-top-right">
										<i class="fa fa-warning txt-color-teal"></i>
										Comision en profundidad <?php echo $contador?></b>
										</label>
										
								<?php $contador++;
									}
								}
								?>
								<label class="label">Valor punto comisionable</label>
								<label class="input"> <i class="icon-append"></i>
								<input placeholder="$ de 1 punto" type="text" name="valorPunto" value="<?php echo $valor_punto[0]->valor_punto;?>">
								<b class="tooltip tooltip-top-right">
								<i class="fa fa-warning txt-color-teal"></i>
								Valor de 1 punto comisionable</b>
								</label>
								<br>
								<button style="margin: 1rem;margin-bottom: 4rem;" type="submit" class="btn btn-success">Guardar</button>
								</section>
							</fieldset>	
							</form>						
						</div>
						<!-- end widget content -->

					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			</article>
			<!-- END COL -->
		</div>
				<div class="row">         
			        <!-- a blank row to get started -->
			        <div class="col-md-4">
			            <br />
			            <br />
			        </div>
		        </div>
			</div>
			<!-- END MAIN CONTENT -->
<style>
.link
{
	margin: 0.5rem;
}
.minh
{
	padding: 50px;
}
.link a:hover
{
	text-decoration: none !important;
}
</style>
