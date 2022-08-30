<?php 
 
class Modelkesatuan extends CI_Model{
	function getKesatuan(){
                $where = array(
                        'tb_kesatuan.username !=' => 'superadmin_resersenarkoba',
                        'tb_kesatuan.kode_kesatuan !='=> 'PRINCIPAL',
                );
                return $this->db->select('kode_kesatuan')
                ->from('tb_kesatuan')
                ->where($where)
                ->get()
                ->result_array();
	}

	function getKesatuanByKode($kode_kesatuan){
                $this->db->select('*')
                ->from('tb_kesatuan')
                ->where('tb_kesatuan.kode_kesatuan', $kode_kesatuan);
                $query = $this->db->get();     
                return $query->result_array();  
	}
}