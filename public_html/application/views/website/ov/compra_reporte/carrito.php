<link href="/cart/HTML/assets/css/style.css" rel="stylesheet">
<link href="/cart/HTML/assets/css/skin-3.css" rel="stylesheet">

<!-- css3 animation effect for this template -->
<link href="/cart/HTML/assets/css/animate.min.css" rel="stylesheet">

<!-- styles needed by carousel slider -->
<link href="/cart/HTML/assets/css/owl.carousel.css" rel="stylesheet">
<link href="/cart/HTML/assets/css/owl.theme.css" rel="stylesheet">

<!-- styles needed by checkRadio -->
<link href="/cart/HTML/assets/css/ion.checkRadio.css" rel="stylesheet">
<link href="/cart/HTML/assets/css/ion.checkRadio.cloudy.css" rel="stylesheet">

<!-- styles needed by mCustomScrollbar -->
<link href="/cart/HTML/assets/css/jquery.mCustomScrollbar.css" rel="stylesheet">

<!-- Just for debugging purposes. -->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<!-- include pace script for automatic web page progress bar  -->

<script>
    paceOptions = {
      elements: true
    };
</script>
<script src="/cart/HTML/assets/js/pace.min.js"></script>
<div class="row">         
         <!-- a blank row to get started -->
    	<div class="col-sm-12">
        	<br />
        	<br />
            <br />
        	<br />
        </div>
        <div class="col-sm-12">
        </div>
</div>

 <div class="navbar navbar-tshop navbar-fixed-top megamenu" role="navigation" id="cart_cont">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only"> Toggle navigation </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> <span class="icon-bar"> </span> </button>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-cart"> <i class="fa fa-shopping-cart colorWhite fa-2x"> </i> <span class="cartRespons colorWhite"> Cart (<?php echo $this->cart->total_items(); ?> ) </span> </button>
      <a style="color :#263569; margin-left:3rem;" class="navbar-brand titulo_carrito" href="/ov/dashboard" > <i class="fa fa-home"></i> Menu &nbsp;</a> 
      
      <!-- this part for mobile -
      <div class="search-box pull-right hidden-lg hidden-md hidden-sm">
        <div class="input-group">
          <button class="btn btn-nobg getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
        </div>
        <!-- /input-group --
        
      </div> -->
    </div>
    
    <!-- this part is duplicate from cartMenu  keep it for mobile -->
    <div class="navbar-cart  collapse">
      <div class="cartMenu  hidden-lg col-xs-12 hidden-md hidden-sm">
        <div class="w100 miniCartTable scroll-pane">
          <table  >
            <tbody>
            	  <?php
                  	if($this->cart->contents())
					{
						$cantidad=0; 
						foreach ($this->cart->contents() as $items) 
						{
							$total=$items['qty']*$items['price'];	
							echo '<tr class="miniCartProduct"> 
									<td style="width:20%" class="miniCartProductThumb"><div> <a href=""> <img src="'.$compras[$cantidad]['imagen'].'" alt="img"> </a> </div></td>
									<td style="width:40%"><div class="miniCartDescription">
				                        <h4> <a href=""> '.$compras[$cantidad]['nombre'].'</a> </h4>
				                        <div class="price"> <span> '.$items['price'].' </span> </div>
				                      </div></td>
				                    <td  style="width:10%" class="miniCartQuantity"><a > X '.$items['qty'].' </a></td>
				                    <td  style="width:15%" class="miniCartSubtotal"><span>'.$total.'</span></td>
				                    <td  style="width:5%" class="delete"><a onclick="quitar_producto(\''.$items['rowid'].'\')"> x </a></td>
								</tr>';
								$cantidad++; 
						} 
					}
				?>
             
            </tbody>
          </table>
        </div>
        <!--/.miniCartTable-->
        
        <div class="miniCartFooter  miniCartFooterInMobile text-right">
          <h3 class="text-right subtotal"> Subtotal: $<?php echo $this->cart->total(); ?> </h3>
          <a class="btn btn-sm btn-danger" onclick="ver_cart()> <i class="fa fa-shopping-cart"> </i> VER CARRITO </a> <a class="btn btn-sm btn-primary" onclick="a_comprar()"> COMPRAR! </a> </div>
        <!--/.miniCartFooter--> 
        
      </div>
      <!--/.cartMenu--> 
    </div>
    <!--/.navbar-cart-->
    
    <div class="navbar-collapse collapse">
   <!--   <ul class="nav navbar-nav">
        <li class="active"> <a onclick="show_todos()"> Todos </a> </li>
        <li class="dropdown megamenu-fullwidth"> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_prod()"> Productos </a></li>
        
        change width of megamenu = use class > megamenu-fullwidth, megamenu-60width, megamenu-40width 
        <li class="dropdown megamenu-80width "> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_serv()"> Servicios </a></li>
        <li class="dropdown megamenu-fullwidth"> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_comb()"> Combinados </a></li>
        <li class="dropdown megamenu-fullwidth"> <a data-toggle="dropdown" class="dropdown-toggle" onclick="show_prom()"> Promociones </a></li>
      </ul>
      -->
      <!--- this part will be hidden for mobile version -->
      <div class="nav navbar-nav navbar-right hidden-xs">
        <div class="dropdown  cartMenu "> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-shopping-cart fa-2x"> </i> <span class="cartRespons"> Cart (<?php echo $this->cart->total_items(); ?> ) </span> <b class="caret"> </b> </a>
          <div class="dropdown-menu col-lg-4 col-xs-12 col-md-4 ">
            <div class="w100 miniCartTable scroll-pane">
              <table> 
                <tbody>
                  <?php
                  	if($this->cart->contents())
					{
						$cantidad=0;
						foreach ($this->cart->contents() as $items) 
						{
							$total=$items['qty']*$items['price'];	
							echo '<tr class="miniCartProduct"> 
									<td style="width:20%" class="miniCartProductThumb"><div> <a href=""> <img src="'.$compras[$cantidad]['imagen'].'" alt="img"> </a> </div></td>
									<td style="width:40%"><div class="miniCartDescription">
				                        <h4> <a href=""> '.$compras[$cantidad]['nombre'].'</a> </h4>
				                        <div class="price"> <span> '.$items['price'].' </span> </div>
				                      </div></td>
				                    <td  style="width:10%" class="miniCartQuantity"><a > X '.$items['qty'].' </a></td>
				                    <td  style="width:15%" class="miniCartSubtotal"><span>'.$total.'</span></td>
				                    <td  style="width:5%" class="delete"><a onclick="quitar_producto(\''.$items['rowid'].'\')"> x </a></td>
								</tr>'; 
								$cantidad++;
						} 
					}
                  
                   ?>
                </tbody>
              </table>
            </div> 
            <!--/.miniCartTable-->
            
            <div class="miniCartFooter text-right">
              <h3 class="text-right subtotal"> Subtotal: $<?php echo $this->cart->total(); ?> </h3>
              <a class="btn btn-sm btn-danger" onclick="ver_cart()"> <i class="fa fa-shopping-cart"> </i> VER CARRITO </a> <a class="btn btn-sm btn-primary" onclick="a_comprar()"> COMPRAR! </a> </div>
            <!--/.miniCartFooter--> 
            
          </div>
          <!--/.dropdown-menu--> 
        </div>
        <!--/.cartMenu-->
        <!--  
        <div class="search-box">
          <div class="input-group">
            <button class="btn btn-nobg getFullSearch" type="button"> <i class="fa fa-search"> </i> </button>
          </div>
          <!-- /input-group 
          
        </div>
        <!--/.search-box -->
        <div class=" transparent pull-right" id="logout">
			<span> <a style="color: rgb(255, 255, 255); background: rgb(206, 53, 44) none repeat scroll 0% 0%;" class="btn btn-default btn-circle btn-lg" href="/index.php/auth/logout" title="Salir" data-action="userLogout" data-logout-msg="¿Realmente desea salir?">
				<i style="font-size: 3rem;" class="fa fa-sign-out"></i>
					</a>
			</span>
		</div>
      </div>
      <!--/.navbar-nav hidden-xs--> 
    </div>
    <!--/.nav-collapse --> 
</div>
<div class="row">
	
	<div class="container main-container" style="background-color: #fff;"> 
	  	
	  <!-- Main component call to action -->
	  <!--<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
	      <div class="panel-group" id="accordionNo"> 
	       
	        <div class="panel panel-default">
	          <div class="panel-heading">
	            <h4 class="panel-title"> <a data-toggle="collapse"  href="#collapseCategory" class="collapseWill"> <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Mas vendidos </a> </h4>
	          </div>
	          <div id="collapseCategory" class="panel-collapse collapse in">
	            <div class="panel-body">
	              
	            </div>
	          </div>
	        </div>
	       
	      </div>
	  </div>-->
	  <article class="col-lg-12 col-sm-4 col-md-3 col-lg-3">
	  			<div class="carousel-inner">
				<!-- Slide 1 -->
				<div class="item active" style="height: 100%; margin-bottom: 2rem;">
					<img src="/template/img/demo/m3.jpg" alt="demo user">
				</div>
			</div>
				<div class="jarviswidget jarviswidget-color-darken" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-arrows-v"></i> </span>
						<h2 class="font-md"><i>Categoria de los productos</i></h2>				
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
							<? foreach ($redes as $red) {?>
								<a class="btn bg-color-blueDark txt-color-white btn-block" 
								onclick="show_serv(<?= $red->id;?>)"><?= $red->nombre;?></a>
							<? } ?>
						</div>
						<!-- end widget content -->
						
					</div>
					<!-- end widget div -->
					
				</div>
				<!-- end widget -->
			</article>
	 	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    	<h3 class="section-title style2 text-center"><span>NUESTROS PRODUCTOS</span></h3>
	    		<div class="">
	      			<div class="row xsResponse" id="mercancias">
	      				<?php
	      					for($productos=0;$productos<sizeof($prod);$productos++)
							{
					
									echo '	<div class="item col-lg-3 col-md-3 col-sm-3 col-xs-3">
									    	<div class="producto">
										    	<a class="" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
										        	<i class=""></i>
										        </a>
									          
									          		<div class="image"> <a onclick="detalles('.$prod[$productos]->id.',1)"><img src="'.$prod[$productos]->img.'" alt="img" class="img-responsive"></a>
									              		<div class="promotion">   </div>
									            	</div>
									            	<div class="description">
									              		<h4><a href="">'.$prod[$productos]->nombre.'</a></h4>
     						              			</div>
									            	<div class="price"> <span>$ '.$prod[$productos]->costo.'</span></div>
									            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prod[$productos]->id.',1,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
									       </div>
								       </div>
								';

							}
							for($servicios=0;$servicios<sizeof($serv);$servicios++)
							{
								echo '	<div class="item col-lg-3 col-md-3 col-sm-3 col-xs-3">
									    	<div class="producto">
										    	<a class="" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
										        	<i class=""></i>
										        </a>
									          
									          		<div class="image"> <a onclick="detalles('.$serv[$servicios]->id.',2)"><img src="'.$serv[$servicios]->img.'" alt="img" class="img-responsive"></a>
									              		<div class="promotion">  </div>
									            	</div>
									            	<div class="description">
									              		<h4><a href="">'.$serv[$servicios]->nombre.'</a></h4>
									              	</div>
									            	<div class="price"> <span>$ '.$serv[$servicios]->costo.'</span> </div>
									            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$serv[$servicios]->id.',2,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
									       </div>
								       </div>
								';
							}
							for($combinados=0;$combinados<sizeof($comb);$combinados++)
							{
								echo '	<div class="item col-lg-3 col-md-3 col-sm-3 col-xs-3">
									    	<div class="producto">
										    	<a class="" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
										        	<i class=""></i>
										        </a>
									          
									          		<div class="image"> <a onclick="detalles('.$comb[$combinados]->id.',3)"><img src="'.$comb[$combinados]->img.'" alt="img" class="img-responsive"></a>
									              		<div class="promotion">  <span class="discount">'.$comb[$combinados]->descuento.'% DESCUENTO</span></div>
									            	</div>
									            	<div class="description">
									              		<h4><a href="">'.$comb[$combinados]->nombre.'</a></h4>
									              	</div>
									            	<div class="price"> <span>$ '.$comb[$combinados]->costo.'</span> </div>
									            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$comb[$combinados]->id.',3,'.$comb[$combinados]->descuento.')"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
									       </div>
								       </div> 
								';
							}
							for($promocion_p=0;$promocion_p<sizeof($prom_p);$promocion_p++)
							{
								echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
									    	<div class="producto">
										    	<a class="" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
										        	<i class=""></i>
										        </a>
									          
									          		<div class="image"> <a onclick="detalles('.$prom_p[$promocion_p]->id_promocion.',4)"><img src="'.$prom_p[$promocion_p]->img.'" alt="img" class="img-responsive"></a>
									              		<div class="promotion">  </div>
									            	</div>
									            	<div class="description">
									              		<h4><a href="">'.$prom_p[$promocion_p]->nombre.'</a></h4>
							              		
									              	</div>
									            	<div class="price"> <span>$ '.$prom_p[$promocion_p]->costo.'</span> </div>
									            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prom_p[$promocion_p]->id_promocion.',4,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
									       </div>
								       </div>
								';
							}
							for($promocion_s=0;$promocion_s<sizeof($prom_s);$promocion_s++)
							{
								echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
									    	<div class="producto">
										    	<a class="" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
										        	<i class=""></i>
										        </a>
									          
									          		<div class="image"> <a onclick="detalles('.$prom_s[$promocion_s]->id_promocion.',5)"><img src="'.$prom_s[$promocion_s]->img.'" alt="img" class="img-responsive"></a>
									              		<div class="promotion">  </div>
									            	</div>
									            	<div class="description">
									              		<h4><a href="">'.$prom_s[$promocion_s]->nombre.'</a></h4>
									              	</div>
									            	<div class="price"> <span>$ '.$prom_s[$promocion_s]->costo.'</span> </div>
									            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prom_s[$promocion_s]->id_promocion.',5,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
									       </div>
								       </div>
								';
							}
							for($promocion_c=0;$promocion_c<sizeof($prom_c);$promocion_c++)
							{
								echo '	<div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
									    	<div class="producto">
										    	<a class="" data-toggle="tooltip" data-original-title="Add to Wishlist"  data-placement="left">
										        	<i class=""></i>
										        </a>
									          
									          		<div class="image"> <a onclick="detalles('.$prom_c[$promocion_c]->id_promocion.',6)"><img src="'.$prom_c[$promocion_c]->img.'" alt="img" class="img-responsive"></a>
									              		<div class="promotion">  </div>
									            	</div>
									            	<div class="description">
									              		<h4><a href="">'.$prom_c[$promocion_c]->nombre.'</a></h4>
									              	</div>
									            	<div class="price"> <span>$ '.$prom_c[$promocion_c]->costo.'</span> </div>
									            	<div class="action-control"> <a class="btn btn-primary" onclick="compra_prev('.$prom_c[$promocion_c]->id_promocion.',6,0)"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Añadir al carrito </span> </a> </div>
									       </div>
								       </div>
								';
							}
	      				 ?>
				        
				        <!--/.item--> 
	      			</div>
	      <!-- /.row -->
	      
	      			
	    		</div>
	    	<!--/.container--> 
	  		</div>
	  <!--/.featuredPostContainer-->
	  
	  
	  <!--/.section-block-->
	  
	  
	  <!--/.section-block--> 
	  
	</div>
</div>
	<div class="row">         
         <!-- a blank row to get started -->
    	<div class="col-sm-12">
        	<br />
        	<br />
        </div>
    </div>
    <script type="text/javascript" src="/cart/HTML/assets/js/smoothproducts.min.js"></script> 
    <script src="js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
	<script type="text/javascript">
			function detalles(id,tipo)
			{
				var datos={'id':id,'tipo':tipo};
				$.ajax({
					data: {info:JSON.stringify(datos)},
					type: "get",
					url: "muestra_mercancia",
					success: function(msg){
				             
				             bootbox.dialog({
								message: msg,
								title: "Descripcion",
								className: "div_info_merc",
								buttons: {
									success: {
										label: "Ok",
										className: "btn-success",
										callback: function() {
											}
									}
								}
							})
				    }
				});
			}
			
			function compra_prev(id,tipo,desc)
			{
				var datos={'id':id,'tipo':tipo,'desc':desc};
				$.ajax({
					data: {info:JSON.stringify(datos)},
					type: "get",
					url: "add_carrito",
					success: function(msg){
				            
				             bootbox.dialog({
								message: msg,
								title: "Descripcion",
								className: "div_info_merc",
								buttons: {
									danger: {
										label: "Cancelar",
										className: "btn-danger",
										callback: function() {
											}
									}
								}
							})
				    }
				});
			}
		</script>
		<script type="text/javascript">
			function show_prod()
			{
				$.ajax({
					type: "get",
					url: "show_productos",
					success:function(msg){
						$("#mercancias").html(msg);
					
					}
				});
			}
			function show_serv(id)
			{
				$.ajax({
					type: "get",
					url: "show_servicios",
					success:function(msg){
						$("#mercancias").html(msg);
						
					}
				});
			}
			function show_prom()
			{
				$.ajax({
					type: "get",
					url: "show_promocion",
					success:function(msg){
						$("#mercancias").html(msg);
						

					}
				});
			}
			function show_comb()
			{
				$.ajax({
					type: "get",
					url: "show_combinados",
					success:function(msg){
						$("#mercancias").html(msg);
						

					}
				});
			}
			function show_todos()
			{
				$.ajax({
					type: "get",
					url: "show_todos",
					success:function(msg){
						$("#mercancias").html(msg);
				
					}
				});
			}
			function busqueda_merc(tipo)
			{
				
				switch(tipo)
				{
					case 1:
						var buscando=$("#busqueda1").val();
						$.ajax({
							data:'buscar='+buscando,
							type:"get",
							url:"buscar_producto",
							success: function(msg){
								$("#mercancias").html(msg);
							}
						});
						break;
					case 2:
						var buscando=$("#busqueda2").val();
						$.ajax({
							data:'buscar='+buscando,
							type:"get",
							url:"buscar_servicio",
							success: function(msg){
								$("#mercancias").html(msg);
							}
						});
						break;
					case 3:
						var buscando=$("#busqueda3").val();
						$.ajax({
							data:'buscar='+buscando,
							type:"get",
							url:"buscar_combinado",
							success: function(msg){
								$("#mercancias").html(msg);
							}
						});
						break;
					case 4:
						var buscando=$("#busqueda4").val();
						$.ajax({
							data:'buscar='+buscando,
							type:"get",
							url:"buscar_todo",
							success: function(msg){
								$("#mercancias").html(msg);
							}
						});
						break;
					default:
						
				}
			}
		</script>
		<script>
			function comprar(id,tipo,desc,min,max)
			{
				
				var qty=$("#cantidad").val();
				if(qty>max||qty<min)
				{
					bootbox.dialog({
						message: 'La cantidad de pedido de esta mercancia debe estar entre '+min+' y '+max,
						title: "Error",
						className: "",
						buttons: {
							danger: {
							label: "Ok!",
							className: "btn-danger",
							callback: function() {
								}
							}
						}
					});
				}
				else
				{
					var datos={'id':id,'tipo':tipo,'qty':qty,'desc':desc};
					$.ajax({
						data:{info:JSON.stringify(datos)},
						type: 'get',
						url: 'add_merc',
						success: function(msg){
							if(msg=="Error")
							{
								bootbox.dialog({
									message: "¡Ooops! El producto se ha agotado, intente mas tarde porfavor.",
									title: "Error",
									className: "",
									buttons: {
										danger: {
										label: "Ok!",
										className: "btn-danger",
										callback: function() {
											}
										}
									}
								});
							}
							else
							{
								bootbox.dialog({
									message: "El producto se ha añadido al carrito",
									title: "Exito",
									className: "",
									buttons: {
										success: {
										label: "Ok!",
										className: "btn-success",
										callback: function() {
												bootbox.hideAll();
											}
										}
									}
								});
								$("#cart_cont").html(msg);
							}			
						}
					});
					
				}
			}
			function ver_cart()
			{
				$.ajax({
					type: 'get',
					url: 'ver_carrito',
					success: function(msg){
			 			bootbox.dialog({
								message: msg,
								title: "Ver carro",
								className: "",
								buttons: {
									success: {
									label: "Aceptar",
									className: "btn-success",
									callback: function() {
										}
									}
								}
							})
					}
				});
			}
			function to_buy()
			{
				<?php 
					if(isset($_GET['tipo']))
					{
						if($_GET['tipo']==3)
						{
							echo 'var tipo=3;';
						}
						else {
							echo 'var tipo=1;';
						}
					}
					else
					{
						echo 'var tipo=1;';
					}
				?>
				$.ajax({
					type: "get",
					data: "tipo="+tipo,
					url: 'por_comprar',
					success: function(msg){
						bootbox.dialog({
							message: msg,
							title: "Metodo de pago",
							className: "",
						
						});
							$('#startdate').datepicker({
								dateFormat : "yy-mm-dd",
								prevText : '<i class="fa fa-chevron-left"></i>',
								nextText : '<i class="fa fa-chevron-right"></i>',
								changeMonth: false,
								numberOfMonths: 1,
								//defaultDate: "1970-01-01",
								changeYear: false,
								
							}); 
							$('#bootstrap-wizard-1').bootstrapWizard({
							    'tabClass': 'form-wizard',
							    'onNext': function (tab, navigation, index) {
							      var $valid = $("#wizard-1").valid();
							      if (!$valid) {
							        $validator.focusInvalid();
							        return false;
							      } else {
							        $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass(
							          'complete');
							        $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step')
							        .html('<i class="fa fa-check"></i>');
							      }
							    }
							  });
					}
				
				});
			}
			function completar_compra(id)
			{
				switch(id)
				{
					case 1:
						var banco=$("#banco_taj").val();
						var tipo=$("#tipo_taj").val();
						var numero=$("#numero_taj").val();
						var titular=$("#titular_taj").val();
						var mes=$("#mes_taj").val();
						var ano=$("#ano_taj").val();
						var codigo=$("#code_taj").val();
							var fecha=0;
						<?php 
							if(isset($_GET['usr']))
							{
								echo 'var comprador='.$_GET['usr'].';';
							}
							else {
								echo 'var comprador=0;';
							}
						?>
						if($('#saveInfoid').prop('checked'))
						{
							var salvar=1
						}
						else
						{
							var salvar=0
						}
						if(!banco)
						{
							alert('Seleccione una empresa bancaria');
						}
						else
						{
							if(!tipo)
							{
								alert('Seleccione una tipo de tarjeta');
							}
							else
							{
								if(!numero)
								{
									alert('El campo numero es obligatorio');
								}
								else
								{
									if(!titular)
									{
										alert('El nombre del titular es obligatorio');
									}
									else
									{
										if(!mes)
										{
											alert('Seleccione un mes');
										}
										else
										{
											if(!ano)
											{
												alert('Seleccione un año');
											}
											else
											{
												if(!codigo)
												{
													alert('El codigo de seguridad es obligatorio');
												}
												else
												{
													var datos={'id':id,'fecha':fecha,'banco':banco,'tipo':tipo,'numero':numero,'titular':titular,'mes':mes,'ano':ano,'codigo':codigo,'salvar':salvar,'comprador':comprador};
													$.ajax({
														data:{info:JSON.stringify(datos)},
														type: 'get',
														url: 'completar_compra',
														success: function(){
															alert("La compra fue un exito!");
															window.location.href='/ov/compras/carrito_menu'
														}
													});
												}
											}
										}
									}
								}
							}
						}
						break;
					case 5:
						var banco=$("#banco_taj").val();
						var tipo=$("#tipo_taj").val();
						var numero=$("#numero_taj").val();
						var titular=$("#titular_taj").val();
						var mes=$("#mes_taj").val();
						var ano=$("#ano_taj").val();
						var codigo=$("#code_taj").val();
						
							var fecha=$("#startdate").val();
						<?php 
							if(isset($_GET['usr']))
							{
								echo 'var comprador='.$_GET['usr'].';';
							}
							else {
								echo 'var comprador=0;';
							}
						?>
						if($('#saveInfoid').prop('checked'))
						{
							var salvar=1
						}
						else
						{
							var salvar=0
						}
						if(!banco)
						{
							alert('Seleccione una empresa bancaria');
						}
						else
						{
							if(!tipo)
							{
								alert('Seleccione una tipo de tarjeta');
							}
							else
							{
								if(!numero)
								{
									alert('El campo numero es obligatorio');
								}
								else
								{
									if(!titular)
									{
										alert('El nombre del titular es obligatorio');
									}
									else
									{
										if(!mes)
										{
											alert('Seleccione un mes');
										}
										else
										{
											if(!ano)
											{
												alert('Seleccione un año');
											}
											else
											{
												if(!codigo)
												{
													alert('El codigo de seguridad es obligatorio');
												}
												else
												{
													var datos={'id':id,'fecha':fecha,'banco':banco,'tipo':tipo,'numero':numero,'titular':titular,'mes':mes,'ano':ano,'codigo':codigo,'salvar':salvar,'comprador':comprador};
													$.ajax({
														data:{info:JSON.stringify(datos)},
														type: 'get',
														url: 'completar_compra',
														success: function(){
															alert("La compra fue un exito!");
															window.location.href='/ov/compras/carrito_menu'
														}
													});
												}
											}
										}
									}
								}
							}
						}
						break;
					default:
						break;
				}
			}
			function quitar_producto(id)
			{
				$.ajax({
					data:'id='+id,
					type:"get",
					url:"quitar_producto",
					success: function(msg){
						$("#contenido_carro").html(msg);
						$.ajax({
					
							type:"get",
							url:"actualizar_nav",
							success: function(msg){
								
								$("#cart_cont").html(msg);
							}
						});
						
						
						alert('La mercancia se ha borrado del carrito');
					}
				});
				
			}
			function muestra_afiliados()
			{
				if($('#comprar_otro').prop('checked'))
				{
				 	$("#afiliados").show();
				}
				else
				{
					$("#afiliados").hide();

				}
			}
			function show_grupo_prod()
			{
				var grupo=$("#grupo_prod").val();
				$.ajax({
					data:'grupo='+grupo,
					type:"get",
					url:"show_prod_grup",
					success: function(msg){
						$("#mercancias").html(msg);
					}
				});
			}
			function a_comprar()
			{
				$.ajax({
					type: "post",
					url: "verificar_carro",
					data: "hola=hola"
				})
				.done(function(msg)
				{
					if(msg=="si")
					{
						<? if(isset($_GET["usr"]))
						{ ?>
							window.location.href='/ov/compras/comprar?tipo=<?=$_GET["tipo"]?>&usr=<?=$_GET["usr"]?>'
						<? }else{?>
							window.location.href='/ov/compras/comprar?tipo=<?=$_GET["tipo"]?>'
						<?}?>
					}
					else
					{
			            bootbox.dialog({
							message: "No tiene productos en el carrito",
							title: "Alerta!",
							className: "div_info_merc",
							buttons: {
								danger: {
									label: "Aceptar",
									className: "btn-danger",
									callback: function() {
										}
								}
							}
						})
					}
				});
			}
		</script>
		<script>
			$(document).ready(function(){
			    var wizard = $('.wizard').wizard();
	
			  wizard.on('finished', function (e, data) {
			  });
			  
});
			
		</script>