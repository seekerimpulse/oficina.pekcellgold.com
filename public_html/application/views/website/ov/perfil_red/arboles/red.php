
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
					<a href="/ov/dashboard"><i class="fa fa-home"></i> Inicio</a>
				<span> 
				> <a href="/ov/red/index">Redes</a>
				> Arbol
				</span>
			</h1>
		</div>
	</div>
	<section id="widget-grid" class="">
		<div class="row"
			style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-bottom: 2rem;">
			<div class="well">
				<fieldset>
					<legend>Red</legend>
					<div class="row">
						
						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
							<a href="/ov/red/red_genealogico?id=<?php echo $_GET['id']; ?>">
								<div
									class="well well-sm txt-color-white text-center link_dashboard"
									style="background: #60a917">
									<i class="fa fa-sitemap fa-3x"></i>
									<h5>Genealogico</h5>
								</div>
							</a>
						</div>
						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
							<a href="/ov/red/red_arbol1?id=<?php echo $_GET['id']; ?>">
								<div
									class="well well-sm txt-color-white text-center link_dashboard"
									style="background: #60a917">
									<i class="fa fa-sitemap fa-3x"></i>
									<h5>Arbol 1</h5>
								</div>
							</a>
						</div>
						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
							<a href="/ov/red/red_arbol2?id=<?php echo $_GET['id']; ?>">
								<div
									class="well well-sm txt-color-white text-center link_dashboard"
									style="background: #60a917">
									<i class="fa fa-sitemap fa-3x"></i>
									<h5>Arbol 2</h5>
								</div>
							</a>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</section>
</div>
