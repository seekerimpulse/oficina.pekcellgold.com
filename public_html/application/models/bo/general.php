<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class general extends CI_Model
{
	function get_username($id)
	{
		$q=$this->db->query('select * from user_profiles where user_id = '.$id);
		return $q->result();
	}
	function get_groups()
	{
		$q=$this->db->query('select * from cat_grupo');
		return $q->result();
	}
	function get_tipo_archivo($ext)
	{
		$q=$this->$this->db->query('select id from cat_tipo_archivo where descripcion= '.$ext);
		return $q->result();
	}
	function get_video()
	{
		$q=$this->db->query('select * from archivo where id_tipo=2');
		return $q->result();
	}
	
	function get_style($id)
	{
		$q=$this->db->query('select * from estilo_usuario where id_usuario = '.$id);
		return $q->result();
	}
}