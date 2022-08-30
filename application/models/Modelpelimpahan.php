<?php 
 
class Modelpelimpahan extends CI_Model{
    function getKasusById($idKasus){
        return $this->db->where('id_kasus',$idKasus)
        ->from("tb_kasus")->get()->result_array();
    }
    
    function getKasusPelimpahanById($kodekesatuan, $firstDate, $lastDate){
        $this->db->select('*')
        ->from('tb_temp_kasus')
        ->join('tb_temp_tersangka','tb_temp_kasus.id_kasus=tb_temp_tersangka.id_kasus','LEFT')
        ->where('tb_temp_kasus.kode_kesatuan',$kodekesatuan)
        ->where("tb_temp_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->order_by("tb_temp_kasus.id_kasus", "ASC");

        $query = $this->db->get();         
        return $query->result_array();  
    }
    
	public function addKasusPelimpahan($fromKasus){
        $this->db->insert('tb_temp_kasus', $fromKasus);
        $newIdKasus = $this->db->insert_id();
        return $newIdKasus;
	}

	public function addTSKPelimpahan($fromTSK){
        $this->db->insert('tb_temp_tersangka', $fromTSK);
        $newIdTSK = $this->db->insert_id();
        return $newIdTSK;
	}
    
	public function addBBPelimpahan($fromBB){
        $this->db->insert('tb_temp_barangbukti', $fromBB);
        $newIdBB = $this->db->insert_id();
        return $newIdBB;
	}

	public function updateKetPelimpahan($idKasus, $ket_pelimpahan, $kodekesatuan_pelimpahanKe, $namaPolsekPelimpahan, $newIdKasus){
        $set = array(
            'ket_pelimpahan' => $ket_pelimpahan,
            'kodekesatuan_pelimpahanKe' => $kodekesatuan_pelimpahanKe,
            'namaPolsekPelimpahan' => $namaPolsekPelimpahan,
            'idKasusPelimpahan' => $newIdKasus,
        );
        return $this->db->set($set)
        ->where('id_kasus', $idKasus)
        ->update('tb_kasus');
	}
    
    // Modul Riwayat Pelimpahan
	public function getPelimpahanDiterima($kodekesatuan, $firstDate, $lastDate){
        $where = array(
            'tb_temp_kasus.kode_kesatuan' => $kodekesatuan,
            'tb_temp_kasus.ket_pelimpahan' => 'diterima',
          );
          $res = $this->db->select('*')
          ->from('tb_temp_kasus')
          ->where($where)
          ->where("tb_temp_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
          ->get();
  
          return $res->result_array();
	}

    public function getPelimpahanDilimpahkan($kodekesatuan, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kodekesatuan,
            'tb_kasus.ket_pelimpahan' => 'dilimpahkan',
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();

        return $res->result_array();
	}

    public function delPelimpahan($idPelimpahan){
        $this->db->delete('tb_temp_barangbukti', array('id_kasus' => $idPelimpahan)); 
        $this->db->delete('tb_temp_tersangka', array('id_kasus' => $idPelimpahan)); 
        $this->db->delete('tb_temp_kasus', array('id_kasus' => $idPelimpahan)); 
        return true;
    }

    public function updatePelimpahanFrom($idFrom){
        $set = array(
            'ket_pelimpahan' => null,
            'kodekesatuan_pelimpahanKe' => null,
            'namaPolsekPelimpahan' => null,
            'idKasusPelimpahan' => null,
        );
        return $this->db->set($set)
        ->where('id_kasus', $idFrom)
        ->update('tb_kasus');
    }

    public function checkIsPelimpahan($idKasus){
        $where = array(
            'id_kasus' => $idKasus,
            'ket_pelimpahan' => 'dilimpahkan',
        );
        $this->db->select('*')
        ->from('tb_kasus')
        ->where($where);

        $query = $this->db->get();         
        return $query->result_array();  
    }
    
    function getBarangBuktiByIdTersangka($idKasus, $idTersangka){
        return $this->db->get_where('tb_temp_barangbukti', array('id_kasus'=>$idKasus, 'id_tersangka'=>$idTersangka));
    }
    
    function getTersangkaByIdTersangka($idKasus, $idTersangka){
        return $this->db->get_where('tb_temp_tersangka', array('id_tersangka'=>$idTersangka, 'id_kasus' => $idKasus));
    }
    
    function updateStatusKasus($idKasus, $status){
        return $this->db->set('status_kasus', $status)
        ->where('id_kasus', $idKasus)
        ->update('tb_kasus');
    }
    
    function updateStatusKasusPelimpahan($idKasus, $status){
        return $this->db->set('status_kasus', $status)
        ->where('id_kasus', $idKasus)
        ->update('tb_temp_kasus');
    }
    
    function updateKasusMenonjol($idKasus){
        return $this->db->set('isKasusMenonjol', 1)
        ->where('id_kasus', $idKasus)
        ->update('tb_kasus');
    }
    
    function updateKasusPelimpahanMenonjol($idKasus){
        return $this->db->set('isKasusMenonjol', 1)
        ->where('id_kasus', $idKasus)
        ->update('tb_temp_kasus');
    }

    function updateAdminKasus($nrp, $idKasus){
        return $this->db->set('nrp_admin', $nrp)
        ->where('id_kasus', $idKasus)
        ->update('tb_temp_kasus');
    }

    function getByIdKasus($idKasus, $kode_kesatuan){
        return $this->db->get_where('tb_temp_kasus', array('id_kasus'=>$idKasus, 'kode_kesatuan'=>$kode_kesatuan));
    }

    function updateKasus($idKasus,$dataKasus, $table){
        return $this->db->update($table, $dataKasus, "id_kasus={$idKasus}");
    }

    function getTersangkaByIdKasus($idKasus){
        return $this->db->get_where('tb_temp_tersangka', array('id_kasus'=>$idKasus));
    }
    
    function getBarangBuktiByIdKasus($idKasus){
        return $this->db->get_where('tb_temp_barangbukti', array('id_kasus'=>$idKasus));
    }
    
    function updateTersangka($idTersangka, $dataTersangka){
        return $this->db->update('tb_temp_tersangka', $dataTersangka, "id_tersangka={$idTersangka}");
    }

    function delTersangka($idTersangka){
        return $this->db->delete('tb_temp_tersangka', array('id_tersangka' => $idTersangka)); 
    }

    function addBarangBukti($dataBarangBukti, $table){
        return $this->db->insert($table, $dataBarangBukti);
    }
    
    function delBarangBukti($idBarangBukti){
        return $this->db->delete('tb_temp_barangbukti', array('id_barangbukti' => $idBarangBukti)); 
    }
    
    // ADDITIONAL FUNCTIONS FOR SUPER ADMIN
    public function getSuperPelimpahan($firstDate, $lastDate){
        $res = $this->db->select('*')
        ->from('tb_temp_kasus')
        ->where("tb_temp_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();

        return $res->result_array();
	}

	public function getSuperPelimpahanDiterima($firstDate, $lastDate){
        $where = array(
            'tb_temp_kasus.ket_pelimpahan' => 'diterima',
          );
          $res = $this->db->select('*')
          ->from('tb_temp_kasus')
          ->where($where)
          ->where("tb_temp_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
          ->get();
  
          return $res->result_array();
	}

    public function getSuperPelimpahanDilimpahkan($firstDate, $lastDate){
        $where = array(
            'tb_kasus.ket_pelimpahan' => 'dilimpahkan',
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();

        return $res->result_array();
	}

}
