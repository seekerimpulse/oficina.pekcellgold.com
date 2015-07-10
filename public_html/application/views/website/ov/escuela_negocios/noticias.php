			<!-- MAIN CONTENT -->
			<div id="content">

				<!-- row -->
				<div class="row">
				
					<!-- col -->
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title txt-color-blueDark"><!-- PAGE HEADER --><a href="/ov/dashboard"><i class="fa fa-home"></i> Inicio </a><span>>
							Noticias </span></h1>
					</div>
					<!-- end col -->
				
				<!-- right side of the page with the sparkline graphs -->
				
				</div>
				<!-- end row -->
				
				<!-- row -->
				<div class="row">
				
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
						
							<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="jarviswidget jarviswidget-color-darken" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
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
										
										<h2 class="font-md"><strong>Noticias</strong> <i></i></h2>				
										
									</header>
	
									<!-- widget div-->
									<div>
										
										<!-- widget edit box -->
										<div class="smart-timeline">
											<ul class="smart-timeline-list">
												<?php 
													for($i=0;$i<sizeof($noticias);$i++)
													{
														$texto=json_encode(html_entity_decode($noticias[$i]->contenido));
														$texto=trim($texto);
														echo
														"<li>	
															<div class='smart-timeline-icon' style='cursor:pointer;' onclick='window.location.href=\"ver_noticia?idnw=".$noticias[$i]->id_noticia."\"'>
																<img src='".$noticias[$i]->imagen."'>
															</div>
															<div class='smart-timeline-time'>
																<small>".$noticias[$i]->fecha."</small>
															</div>
															<div class='smart-timeline-content'>
																<p style='font-size:15px;'>
																	<a href='ver_noticia?idnw=".$noticias[$i]->id_noticia."'><strong>".$noticias[$i]->nombre."</strong></a>
																</p>
																<p style='text-align:justify; padding-right:3%;'>"
																	.substr($noticias[$i]->contenido, 0, 100).
																"... <a href='ver_noticia?idnw=".$noticias[$i]->id_noticia."'>ver mas</a></p>
																<p><strong>"
																	.$noticias[$i]->usuario.
																"</strong></p>									
																	
															</div>
														</li>";
													}
												?>
												
											</ul>
										</div>
										<!-- end widget content -->
										
									</div>
									<!-- end widget div -->
									
								</div>
							<!-- Timeline Content -->
							</article>
							<!-- END Timeline Content -->
				
					
					</div>
				
				</div>
				
				<!-- end row -->

			</div>
		<div class="row">         
         <!-- a blank row to get started -->
	    	<div class="col-sm-12">
	        	<br />
	        	<br />
	        </div>
        </div>
        <script src="/template/js/plugin/bootbox/bootbox.min.js"></script>
		<script type="text/javascript">
			function vermas(texto,autor,img,titulo)
			{
				bootbox.dialog({
					message: '<div style="text-align:justify;"><p>'+texto+'</p><p><strong>'+autor+'</strong></p><br><img src="'+img+'" width="150"></div>',
					title: ""+titulo+"",
					
				});
			}
		</script>
		<!-- PAGE RELATED PLUGIN(S) -->
			<script type="text/javascript">
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
		$(document).ready(function() {
			
			pageSetUp();
		
		})

		</script>