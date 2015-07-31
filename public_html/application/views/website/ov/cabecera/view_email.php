<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
					<a class="backHome" href="/ov"><i class="fa fa-home"></i> Menu</a> 
				<span>>
					Email
				</span>
			</h1>
		</div>
	</div>
	<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-colorbutton="false"	>
					<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
						
						data-widget-colorbutton="false"	
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true" 
						data-widget-sortable="false"
						
					-->
					<header>
						<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
						<h2>Contacto</h2>				
						
					</header>

					<!-- widget div-->
					<div>
						
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							
						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body">
							
									<form action="send_mail" method="post" id="contact-form" class="smart-form">
										<header>Contacto</header>
										
										<fieldset>
											<div class="row">
												<section class="col col-8">
													<label class="label" >Asunto</label>
													<label class="input">
														<i class="icon-append fa fa-tag"></i>
														<input type="text" name="subject" required>
													</label>
												</section>
												<section class="col col-4">
													<label class="label">Departamento</label>
													<label class="select">
														<select name="departamento">
														<?php foreach ($datos_departamentos as $dato_departamento){
															  	  if ($dato_departamento->nombre==''){}
															  	  else	echo '<option value="'.$dato_departamento->email.'">'.$dato_departamento->nombre.'</option>';
															  }
														?>
														</select>
														
													</label>
												</section>
											</div>
											<section class="col col-12">
												<label class="label" >Mensaje</label>
												<textarea name="mensaje" cols="180" id="mymarkdown" class="custom-scroll" style="width: 100%;max-height:200px;"></textarea>
											</section>
										</fieldset>	
										<footer>
											<button type="button" onclick="enviar()" class="btn btn-primary">
												Enviar
											</button>
										</footer>
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
	        <div class="col-sm-12">
	            <br />
	            <br />
	        </div>
        </div>            
		<!-- END ROW -->
	</section>
	<!-- end widget grid -->
</div>

	<script src="/template/js/plugin/markdown/markdown.min.js"></script>
	<script src="/template/js/plugin/markdown/to-markdown.min.js"></script>
	<script src="/template/js/plugin/markdown/bootstrap-markdown.min.js"></script>
	<script type="text/javascript">
		
			// DO NOT REMOVE : GLOBAL FUNCTIONS!
			
			$(document).ready(function() {
				
				pageSetUp();
			
				/*
				 * MARKDOWN EDITOR
				 */

				$("#mymarkdown").markdown({
					autofocus:false,
					savable:false
				})
							
			
			})
function enviar()
{
	$.ajax({
		type: "POST",
		url: "/ov/cabecera/envia_mail/0",
		data: $('#contact-form').serialize()
	})
	.done(function( msg ) {

		bootbox.dialog({
		message: "Tu mensaje ha sido enviado con exito",
		title: "Contacto",
		buttons: {
			success: {
			label: "Ok!",
			className: "btn-success",
			callback: function() {
				location.href='';
				}
			}
		}
	});

	});
}
function invitar()
{
	$.ajax({
		type: "POST",
		url: "/ov/cabecera/envia_mail/1",
		data: $('#contact-form1').serialize()
	})
	.done(function( msg ) {

		bootbox.dialog({
		message: "Tu Invitación ha sido enviada con exito",
		title: "Invitación",
		buttons: {
			success: {
			label: "Ok!",
			className: "btn-success",
			callback: function() {
				location.href='';
				}
			}
		}
	});

	});
}
		</script>