<?php 
 
class Modeldata extends CI_Model{
    function getKesatuan($kode_kesatuan){
        $where = array(
            'tb_kesatuan.username !=' => 'superadmin_resersenarkoba',
            'tb_kesatuan.nama !=' => 'PRINCIPAL',
        );
        $this->db->select('*')
        ->from('tb_kesatuan')
        ->where('tb_kesatuan.kode_kesatuan !=', $kode_kesatuan)
        ->where($where);
        $query = $this->db->get();     
        return $query->result_array();  
    }

    function getKasusByKodeKesatuan($kode_kesatuan, $firstDate, $lastDate){
        $where = array(
            "tb_kasus.kode_kesatuan" => $kode_kesatuan,
        );
        $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','INNER')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->order_by("tb_kasus.created_at", 'DESC');

        $query = $this->db->get();         
        return $query->result_array();  
    }
    
    function getKasusReturnIdKasus($kode_kesatuan){
        $this->db->select('*')
        ->from('tb_kasus')
        ->where('tb_kasus.kode_kesatuan',$kode_kesatuan)
        ->order_by("tb_kasus.id_kasus", "ASC");

        $query = $this->db->get();         
        return $query->result_array();  
    }
    
    function updateStatusKasus($idKasus, $status, $keterangan, $date){
        $set = array(
            'status_kasus' => $status,
            'ket_statusKasus' => $keterangan,
            'date_statusKasus' => $date,
        );
        $this->db->set($set);
        $this->db->where('id_kasus', $idKasus);
        $this->db->update('tb_kasus');
    }

    function updateKasusMenonjol($idKasus){
        $this->db->set('isKasusMenonjol', 1);
        $this->db->where('id_kasus', $idKasus);
        $this->db->update('tb_kasus');
    }
    
    function batalKasusMenonjol($idKasus){
        $this->db->set('isKasusMenonjol', 0);
        $this->db->where('id_kasus', $idKasus);
        $this->db->update('tb_kasus');
    }
    
    function lockLP($idKasus){
        $this->db->set('isLocked', 1);
        $this->db->where('id_kasus', $idKasus);
        $this->db->update('tb_kasus');
    }
    
    function delKasus($idKasus){
        $this->db->delete('tb_kasus', array('id_kasus' => $idKasus)); 
        $this->db->delete('tb_tersangka', array('id_kasus' => $idKasus)); 
        $this->db->delete('tb_barangbukti', array('id_kasus' => $idKasus)); 
        return true;
    }

    function checkKasusKosong($kode_kesatuan){
        $emptyField = array();
        $idKasus = $this->db->select('tb_kasus.id_kasus')
        ->from('tb_kasus')
        ->where('kode_kesatuan', $kode_kesatuan)
        ->get()->result_array();
        $res = $this->checkinTSK($idKasus[0]);
        // for ($i=0; $i <count($idKasus) ; $i++) { 
        //     $res = $this->checkinTSK($idKasus[$i]);
        //     if (!empty($res)) {
        //         $emptyField[] = $res;
        //     }
        // }
        return $res;
    }

    function checkinTSK($idKasus){
        $res = $this->db->select('*')
        ->from('tb_tersangka')
        ->where('id_kasus', $idKasus)
        ->get();
        return $idKasus;
    }

    function updateAdminKasus($nrp, $idKasus){
        return $this->db->set('nrp_admin', $nrp)
        ->where('id_kasus', $idKasus)
        ->update('tb_kasus');
    }

    // Matrik Kasus Modul
    function getKSS($kode_kesatuan, $firstDate, $lastDate){
        $where = array(
            "kode_kesatuan" => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
        );
        return $this->db->where($where)
        ->from("tb_kasus")->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")->count_all_results();
    }
    
    function getTSK($kode_kesatuan, $firstDate, $lastDate){
        $where = array(
            "tb_kasus.kode_kesatuan" => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
        );
        return $this->db->select('*')
        ->from('tb_tersangka')
        ->join('tb_kasus','tb_tersangka.id_kasus=tb_kasus.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->count_all_results();
    }

    function getCountWithOneCondition($kode_kesatuan, $field, $value, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            $field => $value,
            "tb_kasus.isLocked" => 1,
        );
        $res = $this->db->select('*')
        ->from('tb_tersangka')
        ->join('tb_kasus','tb_tersangka.id_kasus=tb_kasus.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->count_all_results();

        return $res;
    }
    
    function getKewarganegaraanJenisKelamin($kode_kesatuan, $status_kewarganegaraan, $jenis_kelamin, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
            'tb_tersangka.status_kewarganegaraan' => $status_kewarganegaraan,
            'tb_tersangka.jenis_kelamin' => $jenis_kelamin
        );
        return $this->db->select('id_tersangka')
        ->from('tb_tersangka')
        ->join('tb_kasus','tb_tersangka.id_kasus=tb_kasus.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->count_all_results();
    }

    function getBeratBB($kode_kesatuan, $kategori, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
            'tb_barangbukti.kategori' => $kategori,
            'tb_barangbukti.isDuplicate' => 0,
        );
        return $this->db->select('*')
        ->from('tb_barangbukti')
        ->join('tb_kasus','tb_barangbukti.id_kasus=tb_kasus.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
    }

    // Matrik Barang Bukti Modul
    function getBBJumlahKSS($kode_kesatuan, $kategori, $status, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
            'tb_barangbukti.kategori'   => $kategori,
            'tb_tersangka.status'   => $status,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_barangbukti','tb_kasus.id_kasus=tb_barangbukti.id_kasus','LEFT')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_kasus.no_laporanpolisi")
        ->get();

        return $res->result_array();
    }
    
    function getBBJumlahTSK($kode_kesatuan, $kategori, $status, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
            'tb_tersangka.status'   => $status,
            'tb_barangbukti.kategori'   => $kategori,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_barangbukti','tb_kasus.id_kasus=tb_barangbukti.id_kasus','LEFT')
        ->join('tb_tersangka','tb_tersangka.id_tersangka=tb_barangbukti.id_tersangka','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_tersangka.nama")
        ->get();

        return $res->result_array();
    }
    
    function getBBSelesaiKSS($kode_kesatuan, $kategori, $status, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
            'tb_kasus.status_kasus !=' => "",
            'tb_barangbukti.kategori'   => $kategori,
            'tb_tersangka.status'   => $status,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_barangbukti','tb_kasus.id_kasus=tb_barangbukti.id_kasus','LEFT')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_kasus.no_laporanpolisi")
        ->get();

        return $res->result_array();
    }
    
    function getBBKewarganegaraanJK($kode_kesatuan, $kategori, $status, $status_kewarganegaraan, $jenis_kelamin, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
            'tb_barangbukti.kategori'   => $kategori,
            'tb_tersangka.status'   => $status,
            'tb_tersangka.status_kewarganegaraan' => $status_kewarganegaraan,
            'tb_tersangka.jenis_kelamin' => $jenis_kelamin,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_barangbukti','tb_kasus.id_kasus=tb_barangbukti.id_kasus','LEFT')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_tersangka.id_tersangka")
        ->get();
        
        return $res->result_array();
    }

    function getBBMatrikInstrumen($kode_kesatuan, $kategori, $status, $field, $value, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
            'tb_barangbukti.kategori'   => $kategori,
            'tb_tersangka.status'   => $status,
            $field => $value,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->join('tb_barangbukti','tb_barangbukti.id_tersangka=tb_tersangka.id_tersangka','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_tersangka.id_tersangka")
        ->get();
        
        return $res->result_array();
    }

    function getBBJumlahBerat($kode_kesatuan, $kategori, $status, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            "tb_kasus.isLocked" => 1,
            'tb_barangbukti.kategori'   => $kategori,
            'tb_tersangka.status'   => $status,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->join('tb_barangbukti','tb_barangbukti.id_tersangka=tb_tersangka.id_tersangka','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }

    // Selra Modul
    function getSelraCC($kode_kesatuan, $firstDate, $lastDate){
        $where = array(
            'kode_kesatuan' => $kode_kesatuan,
            'isLocked' => 1,
            'status_kasus !='   => '',
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }
    
    function getSelraCT($kode_kesatuan, $firstDate, $lastDate){
        $where = array(
            'kode_kesatuan' => $kode_kesatuan,
            'isLocked' => 1,
            'status_kasus ='   => '',
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }
    
    function getSelraCCTersangka($kode_kesatuan, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            'tb_kasus.isLocked' => 1,
            'tb_kasus.status_kasus !='   => '',
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }
    
    function getSelraCTTersangka($kode_kesatuan, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.kode_kesatuan' => $kode_kesatuan,
            'tb_kasus.isLocked' => 1,
            'tb_kasus.status_kasus ='   => '',
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }
    
    function getMatrikSelra($kode_kesatuan, $firstDate, $lastDate, $status){
        $where = array(
            'kode_kesatuan' => $kode_kesatuan,
            'isLocked' => 1,
            'status_kasus'   => $status,
        );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }

    // Kasus Menonjol Modul
    function getMenonjol($kode_kesatuan, $firstDate, $lastDate, $status){
        $where = array(
            'kode_kesatuan' => $kode_kesatuan,
            'isLocked' => 1,
            'isKasusMenonjol'   => $status,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }

    // Aditional for Superadmin
    function getSuperKasus($firstDate, $lastDate){
        $where = array(
            "tb_kasus.kode_kesatuan !=" => "ADMINSUPER",
            "tb_kasus.isLocked" => 1,
        );
        $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','INNER')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->order_by('kode_kesatuan','DESC');

        $query = $this->db->get();         
        return $query->result_array();  
    }
    
    function getSuperSelraCC($firstDate, $lastDate){
        $where = array(
            'status_kasus !='   => '',
            "isLocked" => 1,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->order_by('tb_kasus.kode_kesatuan')
        ->get();
        
        return $res->result_array();
    }
    
    function getSuperSelraCT($firstDate, $lastDate){
        $where = array(
            'status_kasus ='   => '',
            "isLocked" => 1,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->order_by('tb_kasus.kode_kesatuan')
        ->get();
        
        return $res->result_array();
    }

    function getSuperSelraCCTersangka($firstDate, $lastDate){
        $where = array(
            'status_kasus !=' => '',
            "isLocked" => 1,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }
    
    function getSuperSelraCTTersangka($firstDate, $lastDate){
        $where = array(
            "isLocked" => 1,
            'status_kasus ='   => '',
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }
    
    function getTotalMatrikSelra($firstDate, $lastDate, $status){
        $where = array(
            'isLocked' => 1,
            'status_kasus'   => $status,
        );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }
    
    function getTotalMenonjol($firstDate, $lastDate, $status){
        $where = array(
            'isLocked' => 1,
            'isKasusMenonjol'   => $status,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }
    
    function getSuperCountWithOneCondition($field, $value, $firstDate, $lastDate){
        $where = array(
            $field => $value,
        );
        $res = $this->db->select('*')
        ->from('tb_tersangka')
        ->join('tb_kasus','tb_tersangka.id_kasus=tb_kasus.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->count_all_results();

        return $res;
    }
    
    function getSuperBeratBB($kategori, $firstDate, $lastDate){
        $where = array(
            'tb_barangbukti.kategori' => $kategori,
            'tb_barangbukti.isDuplicate' => 0
        );
        return $this->db->select('*')
        ->from('tb_barangbukti')
        ->join('tb_kasus','tb_barangbukti.id_kasus=tb_kasus.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
    }

    function getSuperKSS($firstDate, $lastDate){
        return $this->db->select('*')
        ->from("tb_kasus")->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")->count_all_results();
    }
    
    function getSuperTSK($firstDate, $lastDate){
        return $this->db->select('*')
        ->from('tb_tersangka')
        ->join('tb_kasus','tb_tersangka.id_kasus=tb_kasus.id_kasus','LEFT')
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->count_all_results();
    }
    
    function getSuperKewarganegaraanJenisKelamin($status_kewarganegaraan, $jenis_kelamin, $firstDate, $lastDate){
        $where = array(
            "tb_kasus.isLocked" => 1,
            'tb_tersangka.status_kewarganegaraan' => $status_kewarganegaraan,
            'tb_tersangka.jenis_kelamin' => $jenis_kelamin
        );
        return $this->db->select('id_tersangka')
        ->from('tb_tersangka')
        ->join('tb_kasus','tb_tersangka.id_kasus=tb_kasus.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->count_all_results();
    }

    function getSuperMenonjol($firstDate, $lastDate, $status){
        $where = array(
            'isLocked' => 1,
            'isKasusMenonjol'   => $status,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }
    
    // Matrik BB Super
    
    function getSuperBBKewarganegaraanJK($kategori, $status, $status_kewarganegaraan, $jenis_kelamin, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.isLocked' => 1,
            'tb_barangbukti.kategori' => $kategori,
            'tb_tersangka.status'  => $status,
            'tb_tersangka.status_kewarganegaraan' => $status_kewarganegaraan,
            'tb_tersangka.jenis_kelamin' => $jenis_kelamin,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_barangbukti','tb_kasus.id_kasus=tb_barangbukti.id_kasus','LEFT')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_tersangka.id_tersangka")
        ->get();
        
        return $res->result_array();
    }
    
    function getSuperBBJumlahKSS($kategori, $status, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.isLocked'   => 1,
            'tb_barangbukti.kategori'   => $kategori,
            'tb_tersangka.status'   => $status,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_barangbukti','tb_kasus.id_kasus=tb_barangbukti.id_kasus','LEFT')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_kasus.no_laporanpolisi")
        ->get();

        return $res->result_array();
    }
    
    function getSuperBBJumlahTSK($kategori, $status, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.isLocked'   => 1,
            'tb_tersangka.status'   => $status,
            'tb_barangbukti.kategori'   => $kategori,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_barangbukti','tb_kasus.id_kasus=tb_barangbukti.id_kasus','LEFT')
        ->join('tb_tersangka','tb_tersangka.id_tersangka=tb_barangbukti.id_tersangka','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_tersangka.nama")
        ->get();

        return $res->result_array();
    }
    
    function getSuperBBSelesaiKSS($kategori, $status, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.isLocked'   => 1,
            'tb_kasus.status_kasus !=' => "",
            'tb_barangbukti.kategori'   => $kategori,
            'tb_tersangka.status'   => $status,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_barangbukti','tb_kasus.id_kasus=tb_barangbukti.id_kasus','LEFT')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_kasus.no_laporanpolisi")
        ->get();

        return $res->result_array();
    }

    function getSuperBBMatrikInstrumen($kategori, $status, $field, $value, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.isLocked'   => 1,
            'tb_barangbukti.kategori'   => $kategori,
            'tb_tersangka.status'   => $status,
            $field => $value,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->join('tb_barangbukti','tb_barangbukti.id_tersangka=tb_tersangka.id_tersangka','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->group_by("tb_tersangka.id_tersangka")
        ->get();
        
        return $res->result_array();
    }

    function getSuperBBJumlahBerat($kategori, $status, $firstDate, $lastDate){
        $where = array(
            'tb_kasus.isLocked'   => 1,
            'tb_barangbukti.kategori'   => $kategori,
            'tb_tersangka.status'   => $status,
          );
        $res = $this->db->select('*')
        ->from('tb_kasus')
        ->join('tb_tersangka','tb_kasus.id_kasus=tb_tersangka.id_kasus','LEFT')
        ->join('tb_barangbukti','tb_barangbukti.id_tersangka=tb_tersangka.id_tersangka','LEFT')
        ->where($where)
        ->where("tb_kasus.created_at BETWEEN '$firstDate' AND '$lastDate'")
        ->get();
        
        return $res->result_array();
    }

}


