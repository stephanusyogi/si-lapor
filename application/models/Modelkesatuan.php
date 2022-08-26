<?php 
 
class Modelkesatuan extends CI_Model{
	function getKesatuan(){
		return $this->db->get('tb_kesatuan');
	}

	function getKesatuanByKode($kode_kesatuan){
        $this->db->select('*')
        ->from('tb_kesatuan')
        ->where('tb_kesatuan.kode_kesatuan', $kode_kesatuan);
        $query = $this->db->get();     
        return $query->result_array();  
	}
}