<?php 
 
class Modeladmin extends CI_Model{

	// MODEL FUNCTIONS ADMIN
	function getAllAdmin($kode_kesatuan){
		$where = array(
			'tb_admin.kode_kesatuan' => $kode_kesatuan,
		);
		$this->db->select('*')
		->from('tb_admin')
		->where($where);
		$query = $this->db->get();   
		return $query->result_array();
	}
	
	function getAdminByNRP($nrp){
		$where = array(
			'tb_admin.nrp' => $nrp,
		);
		$this->db->select('*')
		->from('tb_admin')
		->where($where);
		$query = $this->db->get();   
		return $query->result_array();
	}
	
	function getAdminByKesatuan($kode_kesatuan){
		$where = array(
			'tb_admin.kode_kesatuan' => $kode_kesatuan,
		);
		$this->db->select('*')
		->from('tb_admin')
		->where($where);
		$query = $this->db->get();   
		return $query->result_array();
	}

	// ADDITIONAL FUNCTIONS FOR SUPER ADMIN
	function getAdmin(){
		$this->db->select('*')
		->from('tb_admin');
		$query = $this->db->get();   
		return $query->result_array();
	}
}