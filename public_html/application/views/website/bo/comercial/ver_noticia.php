			<!-- MAIN CONTENT -->
			<div id="content">

				<!-- row -->
				<div class="row">
				
					<!-- col -->
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<h1 class="page-title txt-color-blueDark">
							
							<!-- PAGE HEADER -->
							<i class="fa-fw fa fa-home"></i> 
								<a href="/bo/dashboard"> Menu</a> 
							<span>>
								<a href="/bo/oficinaVirtual/"> Oficina Virtual</a> > <a href="/bo/oficinaVirtual/noticias"> Noticias</a> > Listar
							</span>
						</h1>
					
					</div>
					<!-- end col -->
				
				<!-- right side of the page with the sparkline graphs -->
				
				</div>
				<!-- end row -->
				
				<!-- row -->
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="well well-noticia">
							<div class="row">
								<blockquote>
								
										<h1><p class="text-left font-lg"><strong><?=$noticia[0]->nombre?></strong></p></h1>
										
									
									</br></br>
									<p class="text-center" style="text-align: justify;">
										
											<img src="<?=$noticia[0]->imagen?>" class="noticia-imagen">
										
									</p>
									</br>
									
											<p>
												<?=html_entity_decode($noticia[0]->contenido); ?>
											</p>
										
									
								</blockquote>
								
							</div>
						</div>	
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

		<!-- PAGE RELATED PLUGIN(S) -->
			<script type="text/javascript">
		
		$(document).ready(function() {
			
			pageSetUp();
		
		})

		</script>