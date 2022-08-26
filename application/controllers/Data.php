<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

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
		

		$this->load->model('Modelkasus');
		$this->load->model('Modeldata');
		$this->load->model('Modeltersangka');
		$this->load->model('Modelbarangbukti');
	}

    //  MASTER KASUS MODUL
    public function viewMasterKasus(){
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {

			$date = $this->rangeMonth(date("Y-m-d"));
			$res = $this->Modeldata->getSuperKasus($date['start'], $date['end']);
			$dateNow = date('l jS \of F Y', strtotime($date['start'])).' - '.date('l jS \of F Y', strtotime($date['end']));
	
			$data['title'] = "Data Master Kasus";
			$data['menuLink'] = "master-kasus";
			$data['dataKasus'] = $res;
			$data['dateNow'] = $dateNow;
	
	
			$this->load->view('superadmin/include/header',$data);
			$this->load->view('superadmin/v_data_masterkasus',$data);
			$this->load->view('superadmin/include/footer',$data);

		}else{

			$date = $this->rangeMonth(date("Y-m-d"));
			$res = $this->Modeldata->getKasusByKodeKesatuan($this->kode_kesatuan, $date['start'], $date['end']);
			$kesatuan = $this->Modeldata->getKesatuan($this->kode_kesatuan);
			$dateNow = date('l jS \of F Y', strtotime($date['start'])).' - '.date('l jS \of F Y', strtotime($date['end']));
	
			$data['title'] = "Data Master Kasus";
			$data['menuLink'] = "master-kasus";
			$data['dataKasus'] = $res;
			$data['kesatuan'] = $kesatuan;
			$data['dateNow'] = $dateNow;
	
	
			$this->load->view('include/header',$data);
			$this->load->view('v_data_masterkasus',$data);
			$this->load->view('include/footer',$data);

		}
	}

    public function viewMasterKasusByDate(){
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
		

		$res = $this->Modeldata->getKasusByKodeKesatuan($this->kode_kesatuan, $firstDate, $lastDate);
		$kesatuan = $this->Modeldata->getKesatuan($this->kode_kesatuan);

        $data['title'] = "Data Master Kasus";
        $data['menuLink'] = "master-kasus";
		$data['dataKasus'] = $res;
		$data['kesatuan'] = $kesatuan;
		$data['dateNow'] = $dateNow;

		$this->load->view('include/header',$data);
		$this->load->view('v_data_masterkasus',$data);
		$this->load->view('include/footer',$data);
	}

	public function updateStatusKasus($idKasus){
		$status_kasus = $this->input->post('status_kasus');

		$this->Modeldata->updateStatusKasus($idKasus,$status_kasus);
		$this->session->set_flashdata('success', 'Status kasus berhasil diupdate ke database!');
		redirect(base_url("master-kasus"));
	}

	public function updateKasusMenonjol($idKasus){

		$this->Modeldata->updateKasusMenonjol($idKasus);
		$this->session->set_flashdata('success', 'Kasus menonjol berhasil diupdate ke database!');
		redirect(base_url("master-kasus"));
	}

	public function delKasus($idKasus){
		// Check if pelimpahan exist
		$checkPelimpahan = $this->Modelpelimpahan->checkIsPelimpahan($idKasus);
		
		if (!empty($checkPelimpahan)) {
			$this->Modelpelimpahan->delPelimpahan($checkPelimpahan[0]['idKasusPelimpahan']);
		}

		$this->Modeldata->delKasus($idKasus);
		$this->session->set_flashdata('success', 'Informasi kasus berhasil dihapus dari database!');
		redirect(base_url("master-kasus"));
	}

	// MATRIK KASUS MODUL	
    public function viewMatrikKasus(){
		$date = $this->rangeMonth(date("Y-m-d"));
		$dateNow = date('l jS \of F Y', strtotime($date['start'])).' - '.date('l jS \of F Y', strtotime($date['end']));

		// Get Count For Matrik
		$status = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
		foreach ($status as $key) {
			$status[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.status", $key, $date['start'], $date['end']);
		};
		$usia = array("<14","15-18","19-24","25-64","<65");
		foreach ($usia as $key) {
			$usia[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.kategori_usia", $key, $date['start'], $date['end']);
		};
		$pendidikan = array("Tidak Sekolah","SD","SMP","SMA","PT","Belum Diketahui");
		foreach ($pendidikan as $key) {
			$pendidikan[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.pendidikan", $key, $date['start'], $date['end']);
		};
		$pekerjaan = array("Pelajar","Mahasiswa","Swasta","Buruh/Karyawan","Petani/Nelayan","Pedagang","Wiraswasta/Pengusaha", "Sopir/TukangOjek","Ikut Orang Tua", "Ibu Rumah Tangga","Tidak Kerja", "Notaris", "TNI","POLRI","PNS","PEMBANTU","NAPI");
		foreach ($pekerjaan as $key) {
			$pekerjaan[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.pekerjaan", $key, $date['start'], $date['end']);
		};
		$tkp = array("Hotel/Villa/Kos","Ruko/Gedung/Mall/Pabrik","Tempat Umum","Pemukiman/Pondok","Diskotik/Tempat Karaoke","Terminal/Bandara/Pelabuhan","Rumah Tahanan");
		foreach ($tkp as $key) {
			$tkp[$key] = $this->Modeldata->getCountWithOneCondition($this->kode_kesatuan, "tb_tersangka.pekerjaan", $key, $date['start'], $date['end']);
		};
		$bb = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
		foreach ($bb as $key) {
			$jumlahBerat = 0;
			$res = $this->Modeldata->getBeratBB($this->kode_kesatuan, $key, $date['start'], $date['end'])->result_array();
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
			"KSS" => $this->Modeldata->getKSS($this->kode_kesatuan, $date['start'], $date['end']),
			"TSK" => $this->Modeldata->getTSK($this->kode_kesatuan, $date['start'], $date['end']),
			"StatusTSK" => $status,
			"KEWARGANEGARAAN" => array(
				"WNA" => array(
					"LK" => $this->Modeldata->getKewarganegaraanJenisKelamin($this->kode_kesatuan, "WNA", "LK", $date['start'], $date['end']),
					"PR" => $this->Modeldata->getKewarganegaraanJenisKelamin($this->kode_kesatuan, "WNA", "PR", $date['start'], $date['end']),
				),
				"WNI" => array(
					"LK" => $this->Modeldata->getKewarganegaraanJenisKelamin($this->kode_kesatuan, "WNI", "LK", $date['start'], $date['end']),
					"PR" => $this->Modeldata->getKewarganegaraanJenisKelamin($this->kode_kesatuan, "WNI", "PR", $date['start'], $date['end']),
				),
			),
			"USIA" => $usia,
			"PENDIDIKAN" => $pendidikan,
			"PEKERJAAAN" => $pekerjaan,
			"TKP" => $tkp,
			"BARANGBUKTI" => $bb,
		);

        $data['title'] = "Data Matrik Kasus";
        $data['menuLink'] = "matrik-kasus";
		$data['dataMatrik'] = $data;
		$data['dateNow'] = $dateNow;

		$this->load->view('include/header',$data);
		$this->load->view('v_data_matrikkasus',$data);
		$this->load->view('include/footer',$data);
	}
	
    public function viewMatrikKasusByDate(){
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

        $data['title'] = "Data Matrik Kasus";
        $data['menuLink'] = "matrik-kasus";
		$data['dataMatrik'] = $data;
		$data['dateNow'] = $dateNow;

		$this->load->view('include/header',$data);
		$this->load->view('v_data_matrikkasus',$data);
		$this->load->view('include/footer',$data);
	}

	// MATRIK BARANG BUKTI MODUL
    public function viewMatrikBarangBukti(){
		$date = $this->rangeMonth(date("Y-m-d"));
		$dateNow = date('l jS \of F Y', strtotime($date['start'])).' - '.date('l jS \of F Y', strtotime($date['end']));

		$kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
		$statusTSK = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
		$data = array();
		
		foreach($kategoriBB as $kategori) {
				// DATA
				$dataStatusTSK = array();
				foreach ($statusTSK as $keyStatusTSK) {
					$dataStatusTSK[$keyStatusTSK] = array(
						"JML_KSS" => $this->Modeldata->getBBJumlahKSS($this->kode_kesatuan, $kategori, $keyStatusTSK, $date['start'], $date['end']),
						"JML_TSK" => $this->Modeldata->getBBJumlahTSK($this->kode_kesatuan, $kategori, $keyStatusTSK, $date['start'], $date['end']),
						"JML_SelesaiKSS" => $this->Modeldata->getBBSelesaiKSS($this->kode_kesatuan, $kategori, $keyStatusTSK, $date['start'], $date['end']),
						"WNILK" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategori, $keyStatusTSK, 'WNI', 'LK', $date['start'], $date['end']),
						"WNIPR" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategori, $keyStatusTSK, 'WNI', 'PR', $date['start'], $date['end']),
						"WNALK" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategori, $keyStatusTSK, 'WNA', 'LK', $date['start'], $date['end']),
						"WNAPR" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategori, $keyStatusTSK, 'WNA', 'PR', $date['start'], $date['end']),
						"USIA14" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $date['start'], $date['end']),
						"USIA1518" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $date['start'], $date['end']),
						"USIA1924" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $date['start'], $date['end']),
						"USIA2564" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $date['start'], $date['end']),
						"USIA65" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $date['start'], $date['end']),
						"PND_TIDAKSEKOLAH" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $date['start'], $date['end']),
						"PND_SD" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $date['start'], $date['end']),
						"PND_SMP" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $date['start'], $date['end']),
						"PND_SMA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $date['start'], $date['end']),
						"PND_PT" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $date['start'], $date['end']),
						"PND_BELUMDIKETAHUI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $date['start'], $date['end']),
						"PKR_PELAJAR" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $date['start'], $date['end']),
						"PKR_MAHASISWA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $date['start'], $date['end']),
						"PKR_SWASTA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $date['start'], $date['end']),
						"PKR_BURUHKARYAWAN" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $date['start'], $date['end']),
						"PKR_PETANINELAYAN" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $date['start'], $date['end']),
						"PKR_PEDAGANG" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $date['start'], $date['end']),
						"PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $date['start'], $date['end']),
						"PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $date['start'], $date['end']),
						"PKR_IKUTORANGTUA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $date['start'], $date['end']),
						"PKR_IBURUMAHTANGGA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $date['start'], $date['end']),
						"PKR_TIDAKKERJA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $date['start'], $date['end']),
						"PKR_NOTARIS" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $date['start'], $date['end']),
						"PKR_TNI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $date['start'], $date['end']),
						"PKR_POLRI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $date['start'], $date['end']),
						"PKR_PNS" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $date['start'], $date['end']),
						"PKR_PEMBANTU" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $date['start'], $date['end']),
						"PKR_NAPI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $date['start'], $date['end']),
						"JML_BERAT_BB" => $this->Modeldata->getBBJumlahBerat($this->kode_kesatuan, $kategori, $keyStatusTSK, $date['start'], $date['end']),
					);
				};
				$data[$kategori] = $dataStatusTSK; 
		}

        $data['title'] = "Data Matrik Barang Bukti";
        $data['menuLink'] = "matrik-barang-bukti";
		$data['dataMatrik'] = $data;
		$data['dateNow'] = $dateNow;

		$this->load->view('include/header',$data);
		$this->load->view('v_data_matrikbarangbukti',$data);
		$this->load->view('include/footer',$data);
	}
	
    public function viewMatrikBarangBuktiByDate(){
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

        $data['title'] = "Data Matrik Barang Bukti";
        $data['menuLink'] = "matrik-barang-bukti";
		$data['dataMatrik'] = $data;
		$data['dateNow'] = $dateNow;

		$this->load->view('include/header',$data);
		$this->load->view('v_data_matrikbarangbukti',$data);
		$this->load->view('include/footer',$data);
	}

	// SELRA MODUL
    public function viewSelra(){
		$date = $this->rangeMonth(date("Y-m-d"));
		$dateNow = date('l jS \of F Y', strtotime($date['start'])).' - '.date('l jS \of F Y', strtotime($date['end']));

		$matrikCCCT = array(
			"CC" => array(
				"Kasus" => count($this->Modeldata->getSelraCC($this->kode_kesatuan,$date['start'], $date['end'])),
				"Tersangka" => count($this->Modeldata->getSelraCCTersangka($this->kode_kesatuan,$date['start'], $date['end'])),
			),
			"CT" => array(
				"Kasus" => count($this->Modeldata->getSelraCT($this->kode_kesatuan,$date['start'], $date['end'])),
				"Tersangka" => count($this->Modeldata->getSelraCTTersangka($this->kode_kesatuan,$date['start'], $date['end'])),
			),
		);

        $data['title'] = "Data Selesai Perkara";
        $data['menuLink'] = "selra";
		$data['dataKasus'] = $matrikCCCT;
		$data['dataCC'] = $this->Modeldata->getSelraCC($this->kode_kesatuan,$date['start'], $date['end']);
		$data['dataCT'] = $this->Modeldata->getSelraCT($this->kode_kesatuan,$date['start'], $date['end']);
		$data['dateNow'] = $dateNow;

		$this->load->view('include/header',$data);
		$this->load->view('v_selra',$data);
		$this->load->view('include/footer',$data);
	}
	
    public function viewSelraByDate(){
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

        $data['title'] = "Data Selesai Perkara";
        $data['menuLink'] = "selra";
		$data['dataKasus'] = $matrikCCCT;
		$data['dataCC'] = $this->Modeldata->getSelraCC($this->kode_kesatuan, $firstDate, $lastDate);
		$data['dataCT'] = $this->Modeldata->getSelraCT($this->kode_kesatuan, $firstDate, $lastDate);
		$data['dateNow'] = $dateNow;

		$this->load->view('include/header',$data);
		$this->load->view('v_selra',$data);
		$this->load->view('include/footer',$data);
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

