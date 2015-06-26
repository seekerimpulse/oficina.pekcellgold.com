<div style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-right: 0px; margin-left: 0px; padding-bottom: 3rem;" class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<form action="/bo/tipo_red/guardar_red" method="POST" role="form">
		<legend>Nueva Red</legend>
	
		<div class="form-group">
			<label for="">ID</label>
			<input type="text" class="form-control" name="id" >

			<label for="">Nombre</label>
			<input type="text" class="form-control" name="nombre" >

			<label for="">Apellido</label>
			<input type="text" class="form-control" name="apellido" >
			
			<label for="">Usuario</label>
			<input type="text" class="form-control" name="usuario" >

			<label for="">e-mail</label>
			<input type="text" class="form-control" name="email" >
			
			<label for="">Nombre</label>
			<input type="text" class="form-control" name="nombre" >

			<label for="">Descripcion</label>
			<input type="text" class="form-control" name="descripcion" >
		</div>
		<button type="submit" class="btn btn-primary">Crear</button>
	</form>
</div>
</div>
<!-- 
select U.id, U.username, U.email, U.activated as estado, CS.descripcion as sexo,
CEC.descripcion as estado_civil, CTU.descripcion as tipo_usuario, CE.descripcion as estudio,
CO.descripcion as ocupacion, CTD.descripcion as tiempo_dedicado

from users U, user_profiles UP, cat_sexo CS, cat_edo_civil CEC, cat_tipo_usuario CTU,
cat_estudios CE, cat_ocupacion CO, cat_tiempo_dedicado CTD
 
where UP.id_sexo = CS.id_sexo and UP.id_edo_civil = CEC.id_edo_civil and UP.id_tipo_usuario = CTU.id_tipo_usuario
and UP.id_estudio = CE.id_estudio and UP.id_ocupacion = CO.id_ocupacion and U.id = UP.user_id 
and UP.id_tiempo_dedicado = CTD.id_tiempo_dedicado ;
 -->