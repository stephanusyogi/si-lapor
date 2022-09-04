<?php 
 
class Modelpermohonan extends CI_Model{
	function getPermohonanByKesatuan($kode_kesatuan){
    $where = array(
            'kode_kesatuan' => $kode_kesatuan,
    );
    return $this->db->select('*')
    ->from('tb_permohonan_edit')
    ->where($where)
    ->get()
    ->result_array();
	}
  
	function checkPermohonan($idKasus){
    $where = array(
            'id_kasus' => $idKasus,
    );
    return $this->db->select('*')
    ->from('tb_permohonan_edit')
    ->where($where)
    ->get()
    ->result_array();
	}

  function addPermohonan($dataPermohonan){
    return $this->db->insert('tb_permohonan_edit', $dataPermohonan);
  }

  function delPermohonanByIdKasus($idKasus){
      return $this->db->delete('tb_permohonan_edit', array('id_kasus' => $idKasus)); 
  }
  
  function delPermohonan($idPermohonan){
      return $this->db->delete('tb_permohonan_edit', array('id_permohonan' => $idPermohonan)); 
  }
  
  function updatePermohonan($idPermohonan, $idKasus){
    $this->db->set('isApproved', 1);
    $this->db->where('id_permohonan', $idPermohonan);
    $this->db->update('tb_permohonan_edit');
    
    $this->db->set('isLocked', 0);
    $this->db->where('id_kasus', $idKasus);
    $this->db->update('tb_kasus');
}

  // Additional for Superadmin
	function getSuperPermohanan(){
    return $this->db->select('*')
    ->from('tb_permohonan_edit')
    ->get()
    ->result_array();
  }
}