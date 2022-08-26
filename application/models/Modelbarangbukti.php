<?php 
 
class Modelbarangbukti extends CI_Model{
    function getBarangBuktiByIdKasus($idKasus){
        return $this->db->get_where('tb_barangbukti', array('id_kasus'=>$idKasus));
    }

    function getBarangBuktiByIdTersangka($idKasus, $idTersangka){
        return $this->db->get_where('tb_barangbukti', array('id_kasus'=>$idKasus, 'id_tersangka'=>$idTersangka));
    }

    function addBarangBukti($dataBarangBukti, $table){
        return $this->db->insert($table, $dataBarangBukti);
    }

    function delBarangBukti($idBarangBukti){
        return $this->db->delete('tb_barangbukti', array('id_barangbukti' => $idBarangBukti)); 
    }

    function updateBarangBukti($idBarangBukti, $dataBarangBukti){
        return $this->db->update('tb_tersangka', $dataBarangBukti, "id_tersangka={$idBarangBukti}");
    }
}

