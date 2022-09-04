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
	
	function getAdminToday(){
		$begin = date('Y-m-d 00:00:00');
		$end = date('Y-m-d 23:59:59');

		$sql = "SELECT * FROM tb_history_login WHERE created_at BETWEEN '$begin' AND '$end' GROUP BY id_admin";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	function getAdminByLevel($level){
		$this->db->select('*')
		->from('tb_admin')
		->where('kode_kesatuan', $level);
		$query = $this->db->get();   
		return $query->result_array();
	}
	
	function getAdminBiasa(){
		$this->db->select('*')
		->from('tb_admin')
		->where('tb_admin.kode_kesatuan !=', 'ADMINSUPER')
		->where('tb_admin.kode_kesatuan !=', 'PRINCIPAL');
		$query = $this->db->get();   
		return $query->result_array();
	}
	
	function delAdmin($idAdmin){
			return $this->db->delete('tb_admin', array('id_admin' => $idAdmin)); 
	}

	function updateAdmin($dataAdmin, $idAdmin){
		$this->db->where('id_admin', $idAdmin);
		$this->db->update('tb_admin', $dataAdmin);
		return true;
	}

	function getLevels(){
		$this->db->select('*')
		->from('tb_kesatuan');
		$query = $this->db->get();   
		return $query->result_array();
	}
	
	function addAdmin($dataAdmin){
		return $this->db->insert('tb_admin', $dataAdmin);
	}

	function getHistoryAdmin(){
		$this->db->select('*')
		->from('tb_history_login')
		->join('tb_admin','tb_admin.id_admin=tb_history_login.id_admin','INNER')
		->where('tb_admin.kode_kesatuan !=', 'ADMINSUPER')
		->where('tb_admin.kode_kesatuan !=', 'PRINCIPAL')
		->order_by('tb_history_login.created_at', 'DESC');

		$query = $this->db->get();         
		return $query->result_array();
	}
	
	function delHistory(){
			return $this->db->empty_table('tb_history_login'); 
	}

}