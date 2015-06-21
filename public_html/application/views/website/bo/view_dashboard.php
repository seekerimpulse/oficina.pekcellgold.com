<?$ci = &get_instance();
$ci->load->model("model_permissions");?>
			<!-- MAIN CONTENT -->
			<div id="content" >
				<div>
					<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<!--Inica la secciion de la perfil y red-->
									<div class="well">
										<div class="row">
											<div class="col-sm-1">
											</div>
											<?$permiso=$ci->model_permissions->check($id,'altas');
											if($permiso){
											?>
											<div class="col-sm-3 link">
												<a href="/bo/admin/altas">
													<div class="minh well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_2_color?>">
														<i class="fa fa-edit fa-4x"></i>
														<h1>Altas</h1>
													</div>
												</a>
											</div>
											<?}
												$permiso=$ci->model_permissions->check($id,'comisiones');
											if($permiso){
											?>
											<div class="col-sm-3 link">
												<a href="/bo/comisiones">
													<div class="minh well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>;">
														<i class="fa fa-money fa-4x"></i>
														<h1>Comisiones</h1>
													</div>
												</a>
											</div>
											<?}
												$permiso=$ci->model_permissions->check($id,'oficina_virtual');
											if($permiso){
											?>
											<div class="col-sm-3 link">
												<a href="/bo/comercial/oficina_virtual">
													<div class="minh well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>;">
														<i class="fa fa-desktop fa-4x"></i>
														<h1>Oficina virtual</h1>
													</div>
												</a>
											</div>
											<?}?>
										</div>
										<div class="row">
											<div class="col-sm-1">
											</div>
											<?
											$permiso=$ci->model_permissions->check($id,'red');
											if($permiso){
											?>
											<div class="col-sm-3 link">
												<a href="/bo/comercial/red">
													<div class="minh well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>;">
														<i class="fa fa-sitemap fa-4x"></i>
														<h1>Red</h1>
													</div>
												</a>
											</div>
											<?}
												$permiso=$ci->model_permissions->check($id,'reportes');
											if($permiso){
											?>
											<div class="col-sm-3 link">
												<a href="/bo/reportes">
													<div class="minh well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_2_color?>">
														<i class="fa fa-file-excel-o fa-4x"></i>
														<h1>Reportes</h1>
													</div>
												</a>
											</div>
											<?}?>
											<?
											$permiso=$ci->model_permissions->check($id,'red');
											if($permiso){
											?>
											<div class="col-sm-3 link">
												<a href="/bo/logistico">
													<div class="minh well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>;">
														<i class="fa fa-truck fa-4x"></i>
														<h1>Log&iacute;stico</h1>
													</div>
												</a>
											</div>
											<?}?>
										</div>
									</div>
									<!--Termina la secciion de perfil y red-->
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">         
			        <!-- a blank row to get started -->
			        <div class="col-sm-12">
			            <br />
			            <br />
			        </div>
		        </div>
			</div>
			<!-- END MAIN CONTENT -->
<style>
.minh
{
	padding: 50px;
}
.link a:hover
{
	text-decoration: none !important;
}
</style>