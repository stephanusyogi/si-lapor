<?php 
 
class Modelfile extends CI_Model{

	function getAllFile($kode_kesatuan){
        $where = array(
            "tb_file.kode_kesatuan" => $kode_kesatuan,
        );
        $this->db->select('*')
        ->from('tb_file')
        ->join('tb_admin','tb_file.nrp=tb_admin.nrp','LEFT')
        ->where($where);

        $query = $this->db->get();         
        return $query->result_array();  
	}

    function getFile($idFile){
        $this->db->select('*')
        ->from('tb_file')
        ->where('id_file', $idFile);
        $query = $this->db->get();     
        return $query->result_array();  
    }
    
    function addFile($dataFile){
        return $this->db->insert('tb_file', $dataFile);
    }
    
    function delFile($idFile){
        return $this->db->delete('tb_file', array('id_file' => $idFile)); 
    }
}