<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_welcome extends CI_Model {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function getInmobiliariaModel()
	{
		$this->db->select('idInmobiliaria,nombre');
		$this->db->from('zz_glead_inmobiliaria');
		$this->db->where("estado",1);
		$r=$this->db->get();
		return $r->result();
	}

		public function getProyectosModel($idInmobiliaria)
	{
		$this->db->select('idProyecto,nombreM');
		$this->db->from('zz_glead_proyectos');
		$this->db->where("idInmobiliaria",$idInmobiliaria);
		$this->db->where("estado",1);
		$r=$this->db->get();
		return $r->result();
	}

		public function getCatModel($idInmobiliaria)
	{

	}


}

