<?php 
 
class Modelkasus extends CI_Model{

// MODEL FUNCTIONS ADMIN
function getKasusDashboard($kode_kesatuan){
    $where = array(
        'kode_kesatuan' => $kode_kesatuan,
        'isLocked' => 1,
    );
    return $this->db->where($where)
    ->from("tb_kasus")->count_all_results();
}

function getTersangkaDashboard($kode_kesatuan){
    $where = array(
        'tb_kasus.kode_kesatuan'=>$kode_kesatuan,
        'isLocked' => 1,
    );
    return $this->db->select('*')
    ->from('tb_tersangka')
    ->join('tb_kasus','tb_tersangka.id_kasus=tb_kasus.id_kasus','LEFT')
    ->where($where)
    ->count_all_results();
}

function getKasusSelesaiDashboard($kode_kesatuan){
    $where = array(
        'kode_kesatuan' => $kode_kesatuan,
        'status_kasus !=' => "",
        'isLocked' => 1,
      );
    $res = $this->db->where($where)
    ->from("tb_kasus")->get();

    return $res->result_array();
}

function addKasus($dataKasus, $table){
return $this->db->insert($table, $dataKasus);
}

function updateKasus($idKasus,$dataKasus, $table){
return $this->db->update($table, $dataKasus, "id_kasus={$idKasus}");
}

function checkNomorSuratDuplikat($dataKasus){
return $this->db->get_where('tb_kasus', array('no_laporanpolisi'=>$dataKasus));
}

function getByIdKasus($idKasus, $kode_kesatuan){
    return $this->db->get_where('tb_kasus', array('id_kasus'=>$idKasus, 'kode_kesatuan'=>$kode_kesatuan));
}

function addKasusPelimpahan($dataKasus, $table){
return $this->db->insert($table, $dataKasus);
}

function checkNomorSuratDuplikatPelimpahan($dataKasus){
return $this->db->get_where('tb_temp_kasus', array('no_laporanpolisi'=>$dataKasus));
}

function getByIdKasusPelimpahan($idKasus, $kode_kesatuan){
    return $this->db->get_where('tb_temp_kasus', array('id_kasus'=>$idKasus, 'kode_kesatuan'=>$kode_kesatuan));
}

// ADDITIONAL FUNCTIONS FOR SUPER ADMIN
function getKasusMenonjol($kode_kesatuan){
    $where = array(
        'tb_kasus.isKasusMenonjol' => 1,
        'tb_kasus.kode_kesatuan' => $kode_kesatuan
    );
    return $this->db->where($where)
    ->from("tb_kasus")->count_all_results();
}

function getSuperKasusDashboard(){
    return $this->db->select('*')
    ->from("tb_kasus")->where("isLocked", 1)->count_all_results();
}

function getSuperTersangkaDashboard(){
    return $this->db->select('*')
    ->from('tb_tersangka')
    ->join('tb_kasus','tb_tersangka.id_kasus=tb_kasus.id_kasus','LEFT')
    ->where("tb_kasus.isLocked", 1)
    ->count_all_results();
}

function getSuperKasusSelesaiDashboard(){
    $where = array(
        'status_kasus !=' => "",
        'isLocked' => 1,
      );
    $res = $this->db->where($where)
    ->from("tb_kasus")->get();

    return $res->result_array();
}

function getSuperKasusMenonjol(){
    $where = array(
        'tb_kasus.isKasusMenonjol' => 1,
        'tb_kasus.isLocked' => 1,
    );
    return $this->db->where($where)
    ->from("tb_kasus")->count_all_results();
}



}