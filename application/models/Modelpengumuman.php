<?php 
 
class Modelpengumuman extends CI_Model{

  function addPengumuman($dataPengumuman){
      $this->db->insert('tb_pengumuman', $dataPengumuman);
      $insert_id = $this->db->insert_id();

      return $insert_id;
  }
  
  function addPengumumanTujuan($dataPengumumanTujuan){
      return $this->db->insert('tb_pengumuman_tujuan', $dataPengumumanTujuan);
  }

	function getAllPengumuman(){
		return $this->db->select('*')
		->from('tb_pengumuman')
    ->order_by('created_at', 'DESC')
		->get()->result_array();
	}
  
	function getPengumumanByKodeKesatuan($kode_kesatuan){
		return $this->db->select('*')
		->from('tb_pengumuman_tujuan')
    ->join('tb_pengumuman','tb_pengumuman_tujuan.id_pengumuman=tb_pengumuman.id_pengumuman','INNER')
    ->where('tb_pengumuman_tujuan.kode_kesatuan', $kode_kesatuan)
    ->order_by('tb_pengumuman.created_at', 'DESC')
		->get()->result_array();
	}
  
  function getPengumuman($idPengumuman){
      $this->db->select('*')
      ->from('tb_pengumuman')
      ->where('id_pengumuman', $idPengumuman);
      $query = $this->db->get();     
      return $query->result_array();  
  }

  
  function getBelumBaca($idPengumuman){
    $where = array(
      'tb_pengumuman_tujuan.id_pengumuman' => $idPengumuman,
      'tb_pengumuman_tujuan.isRead' => 0,
    );
		return $this->db->select('*')
		->from('tb_pengumuman_tujuan')
    ->join('tb_pengumuman','tb_pengumuman_tujuan.id_pengumuman=tb_pengumuman.id_pengumuman','INNER')
    ->where($where)
		->get()->result_array();
}

  function countPengumuman($kode_kesatuan){
		$res = $this->db->select('*')
		->from('tb_pengumuman_tujuan')
    ->join('tb_pengumuman','tb_pengumuman_tujuan.id_pengumuman=tb_pengumuman.id_pengumuman','INNER')
    ->where('tb_pengumuman_tujuan.kode_kesatuan', $kode_kesatuan)
    ->where('tb_pengumuman_tujuan.isRead', 0)
		->get()->result_array(); 

    echo count($res);
  }
  
  function delPengumuman($idPengumuman){
    $this->db->delete('tb_pengumuman', array('id_pengumuman' => $idPengumuman)); 
    $this->db->delete('tb_pengumuman_tujuan', array('id_pengumuman' => $idPengumuman)); 
    return true;
  }
  
  function delPengumumanTujuan($idPengumuman){
    $this->db->delete('tb_pengumuman_tujuan', array('id_pengumuman_tujuan' => $idPengumuman)); 
    return true;
  }

  function bacaPengumuman($idPengumuman){
    $this->db->set('isRead', 1);
    $this->db->where('id_pengumuman_tujuan', $idPengumuman);
    $this->db->update('tb_pengumuman_tujuan');
    return true;
  }
  
}