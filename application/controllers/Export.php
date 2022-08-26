<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {
	
    protected $session_status;
	protected $kode_kesatuan;
	function __construct(){
		parent::__construct();		
        $this->session_status = $this->session->userdata('isLoggedIn_admin');
		$this->kode_kesatuan = $this->session->userdata('login_data_admin')['kodekesatuan'];

		if (!$this->session_status) {
            $this->session->set_flashdata('error', 'Your Session Has Expired!');
			return redirect(base_url() . 'login');
		}
		
		$this->load->model('Modelpelimpahan');
		$this->load->model('Modelkasus');
		$this->load->model('Modeldata');
		$this->load->model('Modeltersangka');
		$this->load->model('Modelbarangbukti');
	}
    
	public function viewExport($kodeExport){

        switch ($kodeExport) {
            case 'kasusMaster':
                $data['title'] = "Export Master Kasus";
                $data['menuLink'] = "master-kasus";
                break;
                
            case 'selra':
                $data['title'] = "Export Selra Kasus";
                $data['menuLink'] = "selra";
                break;
                
            case 'matrikKasus':
                $data['title'] = "Export Matrik Kasus";
                $data['menuLink'] = "matrik-kasus";
                break;
                
            case 'matrikBB':
                $data['title'] = "Export Matrik Barang Bukti";
                $data['menuLink'] = "matrik-barang-bukti";
                break;
                
            case 'pelimpahanMaster':
                $data['title'] = "Export Kasus Pelimpahan";
                $data['menuLink'] = "kasus-pelimpahan";
                break;
                
            case 'pelimpahanRiwayat':
                $data['title'] = "Export Riwayat Pelimpahan";
                $data['menuLink'] = "riwayat-pelimpahan";
                break;
            
            default:
                # code...
                break;
        }

        $data['kodeExport'] = $kodeExport;

        if ($this->kode_kesatuan == 'ADMINSUPER') {
            $this->load->view('superadmin/include/header',$data);
            $this->load->view('v_export',$data);
            $this->load->view('superadmin/include/footer',$data);
        }else{
            $this->load->view('include/header',$data);
            $this->load->view('v_export',$data);
            $this->load->view('include/footer',$data);
        }

	}

    public function downloadExcel($kodeExport){
        if ($this->kode_kesatuan == 'ADMINSUPER') {
            
            $tanggalAwal = $this->input->post('tanggalAwal');
            $tanggalAkhir = $this->input->post('tanggalAkhir');
            $firstDate = '';
            $lastDate = '';
    
            if (empty($tanggalAwal) || empty($tanggalAkhir)) {
                $firstDate = $tanggalAwal;
                $lastDate = $tanggalAwal;
    
                $dateNow = date('l jS \of F Y', strtotime($firstDate));
            } else {
                $firstDate = $tanggalAwal;
                $lastDate = $tanggalAkhir;
    
                $dateNow = date('l jS \of F Y', strtotime($firstDate)).' - '.date('l jS \of F Y', strtotime($lastDate));	
            }
            
    
            switch ($kodeExport) {
                case 'kasusMaster':
                    $res = $this->Modeldata->getSuperKasus($firstDate, $lastDate);
                    $data['dataKasus'] = $res;
                    $data['dateNow'] = $dateNow;
    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_masterkasus', $data);
                    $this->load->view('exportExcel/include/footerExport');
                    break;
                    
                case 'selra':
                    $matrikCCCT = array(
                        "CC" => array(
                            "Kasus" => count($this->Modeldata->getSuperSelraCC($firstDate, $lastDate)),
                            "Tersangka" => count($this->Modeldata->getSuperSelraCCTersangka($firstDate, $lastDate)),
                        ),
                        "CT" => array(
                            "Kasus" => count($this->Modeldata->getSuperSelraCT($firstDate, $lastDate)),
                            "Tersangka" => count($this->Modeldata->getSuperSelraCCTersangka($firstDate, $lastDate)),
                        ),
                    );
    
                    $data['dataKasus'] = $matrikCCCT;
                    $data['dateNow'] = $dateNow;
                    $data['dataCC'] = $this->Modeldata->getSuperSelraCC($firstDate, $lastDate);
                    $data['dataCT'] = $this->Modeldata->getSuperSelraCT($firstDate, $lastDate);
                    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_selra', $data);
                    $this->load->view('exportExcel/include/footerExport');
    
                    break;
                    
                case 'matrikKasus':
                    // Get Count For Matrik
                    $status = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
                    foreach ($status as $key) {
                        $status[$key] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.status", $key, $firstDate, $lastDate);
                    };
                    $usia = array("<14","15-18","19-24","25-64","<65");
                    foreach ($usia as $key) {
                        $usia[$key] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.kategori_usia", $key, $firstDate, $lastDate);
                    };
                    $pendidikan = array("Tidak Sekolah","SD","SMP","SMA","PT","Belum Diketahui");
                    foreach ($pendidikan as $key) {
                        $pendidikan[$key] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.pendidikan", $key, $firstDate, $lastDate);
                    };
                    $pekerjaan = array("Pelajar","Mahasiswa","Swasta","Buruh/Karyawan","Petani/Nelayan","Pedagang","Wiraswasta/Pengusaha", "Sopir/TukangOjek","Ikut Orang Tua", "Ibu Rumah Tangga","Tidak Kerja", "Notaris", "TNI","POLRI","PNS","PEMBANTU","NAPI");
                    foreach ($pekerjaan as $key) {
                        $pekerjaan[$key] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.pekerjaan", $key, $firstDate, $lastDate);
                    };
                    $tkp = array("Hotel/Villa/Kos","Ruko/Gedung/Mall/Pabrik","Tempat Umum","Pemukiman/Pondok","Diskotik/Tempat Karaoke","Terminal/Bandara/Pelabuhan","Rumah Tahanan");
                    foreach ($tkp as $key) {
                        $tkp[$key] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.pekerjaan", $key, $firstDate, $lastDate);
                    };
                    $bb = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
                    foreach ($bb as $key) {
                        $jumlahBerat = 0;
                        $res = $this->Modeldata->getSuperBeratBB($key, $firstDate, $lastDate)->result_array();
                        if (!empty($res)) {
                            foreach ($res as $keybb) {
                                $jumlahBerat += $keybb['jumlah'];
                            }
                            $beratSatuan = "{$jumlahBerat} {$res[0]['satuan']}";
                        }else{
                            $beratSatuan = $jumlahBerat;
                        }
                        $bb[$key] = $beratSatuan;
                    };
            
                    $data = array(
                        "KSS" => $this->Modeldata->getSuperKSS($firstDate, $lastDate),
                        "TSK" => $this->Modeldata->getSuperTSK($firstDate, $lastDate),
                        "StatusTSK" => $status,
                        "KEWARGANEGARAAN" => array(
                            "WNA" => array(
                                "LK" => $this->Modeldata->getSuperBBKewarganegaraanJK("WNA", "LK", $firstDate, $lastDate),
                                "PR" => $this->Modeldata->getSuperBBKewarganegaraanJK("WNA", "PR", $firstDate, $lastDate),
                            ),
                            "WNI" => array(
                                "LK" => $this->Modeldata->getSuperBBKewarganegaraanJK("WNI", "LK", $firstDate, $lastDate),
                                "PR" => $this->Modeldata->getSuperBBKewarganegaraanJK("WNI", "PR", $firstDate, $lastDate),
                            ),
                        ),
                        "USIA" => $usia,
                        "PENDIDIKAN" => $pendidikan,
                        "PEKERJAAAN" => $pekerjaan,
                        "TKP" => $tkp,
                        "BARANGBUKTI" => $bb,
                    );
    
                    $data['dataMatrik'] = $data;
                    $data['dateNow'] = $dateNow;
    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_matrikkasus', $data);
                    $this->load->view('exportExcel/include/footerExport');
    
                    break;
                    
                case 'matrikBB':
                    $kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
                    $statusTSK = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
                    $data = array();
                    
                    foreach($kategoriBB as $kategori) {
                            // DATA
                            $dataStatusTSK = array();
                            foreach ($statusTSK as $keyStatusTSK) {
                                $dataStatusTSK[$keyStatusTSK] = array(
                                    "JML_KSS" => $this->Modeldata->getSuperBBJumlahKSS($kategori, $keyStatusTSK, $firstDate, $lastDate),
                                    "JML_TSK" => $this->Modeldata->getSuperBBJumlahTSK($kategori, $keyStatusTSK, $firstDate, $lastDate),
                                    "JML_SelesaiKSS" => $this->Modeldata->getSuperBBSelesaiKSS($kategori, $keyStatusTSK, $firstDate, $lastDate),
                                    "WNILK" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategori, $keyStatusTSK, 'WNI', 'LK', $firstDate, $lastDate),
                                    "WNIPR" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategori, $keyStatusTSK, 'WNI', 'PR', $firstDate, $lastDate),
                                    "WNALK" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategori, $keyStatusTSK, 'WNA', 'LK', $firstDate, $lastDate),
                                    "WNAPR" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategori, $keyStatusTSK, 'WNA', 'PR', $firstDate, $lastDate),
                                    "USIA14" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $firstDate, $lastDate),
                                    "USIA1518" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $firstDate, $lastDate),
                                    "USIA1924" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $firstDate, $lastDate),
                                    "USIA2564" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $firstDate, $lastDate),
                                    "USIA65" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $firstDate, $lastDate),
                                    "PND_TIDAKSEKOLAH" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $firstDate, $lastDate),
                                    "PND_SD" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $firstDate, $lastDate),
                                    "PND_SMP" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $firstDate, $lastDate),
                                    "PND_SMA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $firstDate, $lastDate),
                                    "PND_PT" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $firstDate, $lastDate),
                                    "PND_BELUMDIKETAHUI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $firstDate, $lastDate),
                                    "PKR_PELAJAR" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $firstDate, $lastDate),
                                    "PKR_MAHASISWA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $firstDate, $lastDate),
                                    "PKR_SWASTA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $firstDate, $lastDate),
                                    "PKR_BURUHKARYAWAN" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $firstDate, $lastDate),
                                    "PKR_PETANINELAYAN" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $firstDate, $lastDate),
                                    "PKR_PEDAGANG" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $firstDate, $lastDate),
                                    "PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $firstDate, $lastDate),
                                    "PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $firstDate, $lastDate),
                                    "PKR_IKUTORANGTUA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $firstDate, $lastDate),
                                    "PKR_IBURUMAHTANGGA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $firstDate, $lastDate),
                                    "PKR_TIDAKKERJA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $firstDate, $lastDate),
                                    "PKR_NOTARIS" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $firstDate, $lastDate),
                                    "PKR_TNI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $firstDate, $lastDate),
                                    "PKR_POLRI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $firstDate, $lastDate),
                                    "PKR_PNS" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $firstDate, $lastDate),
                                    "PKR_PEMBANTU" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $firstDate, $lastDate),
                                    "PKR_NAPI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $firstDate, $lastDate),
                                    "JML_BERAT_BB" => $this->Modeldata->getSuperBBJumlahBerat($kategori, $keyStatusTSK, $firstDate, $lastDate),
                                );
                            };
                            $data[$kategori] = $dataStatusTSK; 
                    }
                    
                    $data['dataMatrik'] = $data;
                    $data['dateNow'] = $dateNow;
    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_matrikbarangbukti', $data);
                    $this->load->view('exportExcel/include/footerExport');
            
                    break;
                    
                
                case 'pelimpahanRiwayat':
                    $data['LPditerima'] = $this->Modelpelimpahan->getSuperPelimpahanDiterima($firstDate, $lastDate);
                    $data['LPdilimpahkan'] = $this->Modelpelimpahan->getSuperPelimpahanDilimpahkan($firstDate, $lastDate);
                    $data['dateNow'] = $dateNow;
                    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_pelimpahanriwayat', $data);
                    $this->load->view('exportExcel/include/footerExport');
                    break;
                
                default:
                    # code...
                    break;
            }   
        } else {
            $tanggalAwal = $this->input->post('tanggalAwal');
            $tanggalAkhir = $this->input->post('tanggalAkhir');
            $firstDate = '';
            $lastDate = '';
    
            if (empty($tanggalAwal) || empty($tanggalAkhir)) {
                $firstDate = $tanggalAwal;
                $lastDate = $tanggalAwal;
    
                $dateNow = date('l jS \of F Y', strtotime($firstDate));
            } else {
                $firstDate = $tanggalAwal;
                $lastDate = $tanggalAkhir;
    
                $dateNow = date('l jS \of F Y', strtotime($firstDate)).' - '.date('l jS \of F Y', strtotime($lastDate));	
            }
            
    
            switch ($kodeExport) {
                case 'kasusMaster':
                    $res = $this->Modeldata->getKasusByKodeKesatuan($this->kode_kesatuan, $firstDate, $lastDate);
                    $data['dataKasus'] = $res;
                    $data['dateNow'] = $dateNow;
    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_masterkasus', $data);
                    $this->load->view('exportExcel/include/footerExport');
                    break;
                    
                case 'selra':
                    $matrikCCCT = array(
                        "CC" => array(
                            "Kasus" => count($this->Modeldata->getSelraCC($this->kode_kesatuan, $firstDate, $lastDate)),
                            "Tersangka" => count($this->Modeldata->getSelraCCTersangka($this->kode_kesatuan, $firstDate, $lastDate)),
                        ),
                        "CT" => array(
                            "Kasus" => count($this->Modeldata->getSelraCT($this->kode_kesatuan, $firstDate, $lastDate)),
                            "Tersangka" => count($this->Modeldata->getSelraCTTersangka($this->kode_kesatuan, $firstDate, $lastDate)),
                        ),
                    );
    
                    $data['dataKasus'] = $matrikCCCT;
                    $data['dateNow'] = $dateNow;
                    $data['dataCC'] = $this->Modeldata->getSelraCC($this->kode_kesatuan, $firstDate, $lastDate);
                    $data['dataCT'] = $this->Modeldata->getSelraCT($this->kode_kesatuan, $firstDate, $lastDate);
                    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_selra', $data);
                    $this->load->view('exportExcel/include/footerExport');
    
                    break;
                    
                case 'matrikKasus':
                    // Get Count For Matrik
                    $status = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
                    foreach ($status as $key) {
                        $status[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.status", $key, $firstDate, $lastDate);
                    };
                    $usia = array("<14","15-18","19-24","25-64","<65");
                    foreach ($usia as $key) {
                        $usia[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.kategori_usia", $key, $firstDate, $lastDate);
                    };
                    $pendidikan = array("Tidak Sekolah","SD","SMP","SMA","PT","Belum Diketahui");
                    foreach ($pendidikan as $key) {
                        $pendidikan[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.pendidikan", $key, $firstDate, $lastDate);
                    };
                    $pekerjaan = array("Pelajar","Mahasiswa","Swasta","Buruh/Karyawan","Petani/Nelayan","Pedagang","Wiraswasta/Pengusaha", "Sopir/TukangOjek","Ikut Orang Tua", "Ibu Rumah Tangga","Tidak Kerja", "Notaris", "TNI","POLRI","PNS","PEMBANTU","NAPI");
                    foreach ($pekerjaan as $key) {
                        $pekerjaan[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.pekerjaan", $key, $firstDate, $lastDate);
                    };
                    $tkp = array("Hotel/Villa/Kos","Ruko/Gedung/Mall/Pabrik","Tempat Umum","Pemukiman/Pondok","Diskotik/Tempat Karaoke","Terminal/Bandara/Pelabuhan","Rumah Tahanan");
                    foreach ($tkp as $key) {
                        $tkp[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.pekerjaan", $key, $firstDate, $lastDate);
                    };
                    $bb = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
                    foreach ($bb as $key) {
                        $jumlahBerat = 0;
                        $res = $this->Modeldata->getBeratBB($this->kode_kesatuan, $key, $firstDate, $lastDate)->result_array();
                        if (!empty($res)) {
                            foreach ($res as $keybb) {
                                $jumlahBerat += $keybb['jumlah'];
                            }
                            $beratSatuan = "{$jumlahBerat} {$res[0]['satuan']}";
                        }else{
                            $beratSatuan = $jumlahBerat;
                        }
                        $bb[$key] = $beratSatuan;
                    };
            
                    $data = array(
                        "KSS" => $this->Modeldata->getKSS($this->kode_kesatuan, $firstDate, $lastDate),
                        "TSK" => $this->Modeldata->getTSK($this->kode_kesatuan, $firstDate, $lastDate),
                        "StatusTSK" => $status,
                        "KEWARGANEGARAAN" => array(
                            "WNA" => array(
                                "LK" => $this->Modeldata->getKewarganegaraanJenisKelamin($this->kode_kesatuan, "WNA", "LK", $firstDate, $lastDate),
                                "PR" => $this->Modeldata->getKewarganegaraanJenisKelamin($this->kode_kesatuan, "WNA", "PR", $firstDate, $lastDate),
                            ),
                            "WNI" => array(
                                "LK" => $this->Modeldata->getKewarganegaraanJenisKelamin($this->kode_kesatuan, "WNI", "LK", $firstDate, $lastDate),
                                "PR" => $this->Modeldata->getKewarganegaraanJenisKelamin($this->kode_kesatuan, "WNI", "PR", $firstDate, $lastDate),
                            ),
                        ),
                        "USIA" => $usia,
                        "PENDIDIKAN" => $pendidikan,
                        "PEKERJAAAN" => $pekerjaan,
                        "TKP" => $tkp,
                        "BARANGBUKTI" => $bb,
                    );
    
                    $data['dataMatrik'] = $data;
                    $data['dateNow'] = $dateNow;
    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_matrikkasus', $data);
                    $this->load->view('exportExcel/include/footerExport');
    
                    break;
                    
                case 'matrikBB':
                    $kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
                    $statusTSK = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
                    $data = array();
                    
                    foreach($kategoriBB as $kategori) {
                            // DATA
                            $dataStatusTSK = array();
                            foreach ($statusTSK as $keyStatusTSK) {
                                $dataStatusTSK[$keyStatusTSK] = array(
                                    "JML_KSS" => $this->Modeldata->getBBJumlahKSS($this->kode_kesatuan, $kategori, $keyStatusTSK, $firstDate, $lastDate),
                                    "JML_TSK" => $this->Modeldata->getBBJumlahTSK($this->kode_kesatuan, $kategori, $keyStatusTSK, $firstDate, $lastDate),
                                    "JML_SelesaiKSS" => $this->Modeldata->getBBSelesaiKSS($this->kode_kesatuan, $kategori, $keyStatusTSK, $firstDate, $lastDate),
                                    "WNILK" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategori, $keyStatusTSK, 'WNI', 'LK', $firstDate, $lastDate),
                                    "WNIPR" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategori, $keyStatusTSK, 'WNI', 'PR', $firstDate, $lastDate),
                                    "WNALK" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategori, $keyStatusTSK, 'WNA', 'LK', $firstDate, $lastDate),
                                    "WNAPR" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategori, $keyStatusTSK, 'WNA', 'PR', $firstDate, $lastDate),
                                    "USIA14" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $firstDate, $lastDate),
                                    "USIA1518" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $firstDate, $lastDate),
                                    "USIA1924" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $firstDate, $lastDate),
                                    "USIA2564" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $firstDate, $lastDate),
                                    "USIA65" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $firstDate, $lastDate),
                                    "PND_TIDAKSEKOLAH" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $firstDate, $lastDate),
                                    "PND_SD" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $firstDate, $lastDate),
                                    "PND_SMP" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $firstDate, $lastDate),
                                    "PND_SMA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $firstDate, $lastDate),
                                    "PND_PT" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $firstDate, $lastDate),
                                    "PND_BELUMDIKETAHUI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $firstDate, $lastDate),
                                    "PKR_PELAJAR" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $firstDate, $lastDate),
                                    "PKR_MAHASISWA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $firstDate, $lastDate),
                                    "PKR_SWASTA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $firstDate, $lastDate),
                                    "PKR_BURUHKARYAWAN" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $firstDate, $lastDate),
                                    "PKR_PETANINELAYAN" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $firstDate, $lastDate),
                                    "PKR_PEDAGANG" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $firstDate, $lastDate),
                                    "PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $firstDate, $lastDate),
                                    "PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $firstDate, $lastDate),
                                    "PKR_IKUTORANGTUA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $firstDate, $lastDate),
                                    "PKR_IBURUMAHTANGGA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $firstDate, $lastDate),
                                    "PKR_TIDAKKERJA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $firstDate, $lastDate),
                                    "PKR_NOTARIS" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $firstDate, $lastDate),
                                    "PKR_TNI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $firstDate, $lastDate),
                                    "PKR_POLRI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $firstDate, $lastDate),
                                    "PKR_PNS" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $firstDate, $lastDate),
                                    "PKR_PEMBANTU" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $firstDate, $lastDate),
                                    "PKR_NAPI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $firstDate, $lastDate),
                                    "JML_BERAT_BB" => $this->Modeldata->getBBJumlahBerat($this->kode_kesatuan, $kategori, $keyStatusTSK, $firstDate, $lastDate),
                                );
                            };
                            $data[$kategori] = $dataStatusTSK; 
                    }
                    
                    $data['dataMatrik'] = $data;
                    $data['dateNow'] = $dateNow;
    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_matrikbarangbukti', $data);
                    $this->load->view('exportExcel/include/footerExport');
            
                    break;
                    
                case 'pelimpahanMaster':
                    $res = $this->Modelpelimpahan->getKasusPelimpahanById($this->kode_kesatuan, $firstDate, $lastDate);
                    $data['dataKasus'] = $res;
                    $data['dateNow'] = $dateNow;
    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_pelimpahanmaster', $data);
                    $this->load->view('exportExcel/include/footerExport');
                    break;
                    
                case 'pelimpahanRiwayat':
                    $data['LPditerima'] = $this->Modelpelimpahan->getPelimpahanDiterima($this->kode_kesatuan, $firstDate, $lastDate);
                    $data['LPdilimpahkan'] = $this->Modelpelimpahan->getPelimpahanDilimpahkan($this->kode_kesatuan, $firstDate, $lastDate);
                    $data['dateNow'] = $dateNow;
                    
                    $this->load->view('exportExcel/include/headerExport');
                    $this->load->view('exportExcel/v_excel_pelimpahanriwayat', $data);
                    $this->load->view('exportExcel/include/footerExport');
                    break;
                
                default:
                    # code...
                    break;
            }   
        }
        
        
    }
	
	// Date Modul
	function rangeMonth($datestr) {
		date_default_timezone_set (date_default_timezone_get());
		$dt = strtotime ($datestr);
		return array (
		"start" => date ('Y-m-d', strtotime ('first day of this month', $dt)),
		"end" => date ('Y-m-d', strtotime ('last day of this month', $dt))
		);
	}
}