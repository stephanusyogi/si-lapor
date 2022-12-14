<?php 
 
class Modeltersangka extends CI_Model{
    function getTersangkaByIdKasus($idKasus){
        return $this->db->get_where('tb_tersangka', array('id_kasus'=>$idKasus));
    }

    function getTersangkaByIdTersangka($idKasus, $idTersangka){
        return $this->db->get_where('tb_tersangka', array('id_tersangka'=>$idTersangka, 'id_kasus' => $idKasus));
    }
    
    function getTersangkaExceptIdTersangka($kode_kesatuan,$idKasus){
        $where = array(
            'tb_kasus.kode_kesatuan =' => $kode_kesatuan,
            'tb_kasus.id_kasus =' => $idKasus,
            'tb_barangbukti.isDuplicate =' => 0,
          );

        return $this->db->select('*')
        ->from('tb_tersangka')
        ->join('tb_kasus','tb_tersangka.id_kasus=tb_kasus.id_kasus','LEFT')
        ->join('tb_barangbukti','tb_tersangka.id_tersangka=tb_barangbukti.id_tersangka','LEFT')
        ->where($where)
        ->group_by('tb_tersangka.id_tersangka')
        ->get();
    }
    
    function getTersangkaByKodeKesatuan($kode_kesatuan){
        $where = array(
            "tb_kasus.kode_kesatuan" => $kode_kesatuan,
        );
        $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','INNER')
        ->where($where)
        ->order_by("tb_kasus.created_at", 'DESC');

        $query = $this->db->get();         
        return $query->result_array();  
    }
    
    function getSuperTersangkaByKodeKesatuan(){
        $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','INNER')
        ->order_by("tb_kasus.created_at", 'DESC');

        $query = $this->db->get();         
        return $query->result_array();  
    }

    function addTersangka($dataTersangka, $table){
        return $this->db->insert($table, $dataTersangka);
    }

    function delTersangka($idTersangka){
        return $this->db->delete('tb_tersangka', array('id_tersangka' => $idTersangka)); 
    }

    function updateTersangka($idTersangka, $dataTersangka){
        return $this->db->update('tb_tersangka', $dataTersangka, "id_tersangka={$idTersangka}");
    }
    
    function uploadFoto($idTersangka, $namafile){
        return $this->db->update('tb_tersangka', $namafile, "id_tersangka={$idTersangka}");
    }
}

