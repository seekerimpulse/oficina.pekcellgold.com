<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
					<a href="/ov/dashboard"><i class="fa fa-home"></i> Inicio</a>
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
							<ul id="myTab1" class="nav nav-tabs bordered">
								<li class="active">
									<a href="#s1" data-toggle="tab">Contacto</a>
								</li>
								<li>
									<a href="#s2" data-toggle="tab">Invitacion</a>
								</li>
							</ul>
							<div id="myTabContent1" class="tab-content padding-10">
								<div class="tab-pane fade in active" id="s1">
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
															<option value="general@general.com">Dirección general</option>
															<option value="comercial@comercial.com">Dirección comercial</option>
															<option value="soporte@soporte.com">Soporte técnico</option>
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
								<div class="tab-pane fade" id="s2">
									<form action="send_mail" method="post" id="contact-form1" class="smart-form">
									<header>Invitar a un conocido</header>
									<fieldset>
										<div class="row">
											<section class="col col-8">
												<label class="label" >Correo</label>
												<label class="input">
													<i class="icon-append fa fa-tag"></i>
													<input type="email" name="correo" required>
												</label>
											</section>
										</div>
									</fieldset>	
										<footer>
											<button type="button" onclick="invitar()" class="btn btn-primary">
												Invitar
											</button>
										</footer>
									</form>
								</div>
							</div>
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