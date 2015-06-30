<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class general extends CI_Model
{
	function get_status($id)
	{
		$q=$this->db->query('select id_estatus from user_profiles where user_id = '.$id);
		return $q->result();
	}

	function get_tipo($id)
	{
		$q=$this->db->query('select id_tipo_usuario from user_profiles where user_id = '.$id);
		return $q->result();
	}
  	function get_password($id)
	{
		$q=$this->db->query('select password from users where id = '.$id);
		return $q->result();
	}
	function get_style($id)
	{
	  	$q=$this->db->query('select * from estilo_usuario where id_usuario = '.$id);
	 	return $q->result();
	}
	function get_username($id)
	{
		$q=$this->db->query('select * from user_profiles where user_id = '.$id);
		return $q->result();
	}
	function get_user($id)
	{
		$q=$this->db->query('select username from users where id = '.$id);
		return $q->result();
	}
	function get_last_id()
	{
		$q=$this->db->query("SELECT id from users order by id desc limit 1");
		return $q->result();
	}
	function dato_usuario($email)
	{
		$q=$this->db->query('
			SELECT profile.user_id, profile.nombre nombre, profile.apellido apellido,
			profile.fecha_nacimiento nacimiento, profile.id_estudio id_estudio,
			profile.id_ocupacion id_ocupacion,
			profile.id_tiempo_dedicado id_tiempo_dedicado,
			sexo.descripcion sexo,
			edo_civil.descripcion edo_civil,
			estilos.bg_color, estilos.btn_1_color, estilos.btn_2_color
			from user_profiles profile
			left join cat_sexo sexo
			on profile.id_sexo=sexo.id_sexo
			left join estilo_usuario estilos on
			profile.user_id=estilos.id_usuario
			left join cat_edo_civil edo_civil on
			profile.id_edo_civil=edo_civil.id_edo_civil
			left join users on profile.user_id=users.id
			where users.email="'.$email.'"');
		return $q->result();
	}
	function update_login($id)
	{
		$q=$this->db->query('select last_login from users where id = '.$id);
		$q=$q->result();

		$this->db->query('update user_profiles set ultima_sesion="'.$q[0]->last_login.'" where user_id='.$id);
	}

}
