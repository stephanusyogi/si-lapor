<?php 
 
class Modelauth extends CI_Model{

	function checkAuth($username, $password){
		$where = array(
			'tb_admin.nrp' => $username,
			'tb_admin.password' => $password,
		);
		$this->db->select('*')
		->from('tb_admin')
		->where($where);
		$query = $this->db->get();   
		return $query->result_array();
	}

	function getKesatuanbyKode($kode_kesatuan){
		$where = array(
			'tb_kesatuan.kode_kesatuan' => $kode_kesatuan,
		);
		$this->db->select('*')
		->from('tb_kesatuan')
		->where($where);
		$query = $this->db->get();   
		return $query->result_array();
	}
}