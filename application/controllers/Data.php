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
		$this->load->model('Modelkesatuan');
		$this->load->model('Modelpermohonan');
	}

	//  MASTER KASUS MODUL
	public function viewMasterKasus(){
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {

			$date = $this->rangeMonth(date("Y-m-d", strtotime("-1 month")), date("Y-m-d", strtotime("+1 month")));
			$res = $this->Modeldata->getSuperKasus($date['start'], $date['end']);
			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($date['start']))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($date['end'])));
	
			$data['title'] = "Data Ungkap Kasus";
			$data['menuLink'] = "master-kasus";
			$data['dataKasus'] = $res;
			$data['dateNow'] = $dateNow;

		}else{
			$date = $this->rangeMonth(date("Y-m-d", strtotime("-1 month")), date("Y-m-d", strtotime("+1 month")));
			$res = $this->Modeldata->getKasusByKodeKesatuan($this->kode_kesatuan, $date['start'], $date['end']);
			$kesatuan = $this->Modeldata->getKesatuan($this->kode_kesatuan);
			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($date['start']))) .' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($date['end'])));
	
			$data['title'] = "Data Ungkap Kasus";
			$data['menuLink'] = "master-kasus";
			$data['dataKasus'] = $res;
			$data['kesatuan'] = $kesatuan;
			$data['dateNow'] = $dateNow;

		}
		
		$data['btnExitSort'] = false;

		$this->load->view('include/header',$data);
		$this->load->view('v_data_masterkasus',$data);
		$this->load->view('include/footer',$data);
	}

  public function viewMasterKasusByDate(){
		$nama_kesatuan = $this->input->post('kode_kesatuan');
		$tanggalAwal = $this->input->post('tanggalAwal');
		$tanggalAkhir = $this->input->post('tanggalAkhir');
		$firstDate = '';
		$lastDate = '';

		if (empty($tanggalAwal) || empty($tanggalAkhir)) {
			$firstDate = $tanggalAwal;
			$lastDate = $tanggalAwal;

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate)));
		} else {
			$firstDate = $tanggalAwal;
			$lastDate = $tanggalAkhir;

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($lastDate)));	
		}

		
		if ($nama_kesatuan == 'all'){
			$res = $this->Modeldata->getSuperKasus($firstDate, $lastDate);
		
			$data['title'] = "Data Ungkap Kasus";
			$data['menuLink'] = "master-kasus";
			$data['dataKasus'] = $res;
			$data['dateNow'] = $dateNow;
		}else{
			if ($this->kode_kesatuan == 'ADMINSUPER') {
	
				$res = $this->Modeldata->getKasusByKodeKesatuan($nama_kesatuan, $firstDate, $lastDate);
				$kesatuan = $this->Modeldata->getKesatuan($nama_kesatuan);
		
				$data['title'] = "Data Ungkap Kasus";
				$data['menuLink'] = "master-kasus";
				$data['dataKasus'] = $res;
				$data['kesatuan'] = $kesatuan;
				$data['dateNow'] = $dateNow;

			} else {
	
				$res = $this->Modeldata->getKasusByKodeKesatuan($this->kode_kesatuan, $firstDate, $lastDate);
				$kesatuan = $this->Modeldata->getKesatuan($this->kode_kesatuan);
		
				$data['title'] = "Data Ungkap Kasus";
				$data['menuLink'] = "master-kasus";
				$data['dataKasus'] = $res;
				$data['kesatuan'] = $kesatuan;
				$data['dateNow'] = $dateNow;
	
			}
		}

		$data['btnExitSort'] = true;
	
		$this->load->view('include/header',$data);
		$this->load->view('v_data_masterkasus',$data);
		$this->load->view('include/footer',$data);

	}

	public function updateStatusKasus($idKasus){
		$status_kasus = $this->input->post('status_kasus');
		$ket_statusKasus = $this->input->post('ket_statusKasus');
		$date = date('Y-m-d');

		$this->Modeldata->updateStatusKasus($idKasus,$status_kasus,$ket_statusKasus,$date);
		$this->session->set_flashdata('success', 'Status kasus berhasil diupdate!');
		redirect(base_url("selra"));
	}

	public function updateKasusMenonjol($idKasus){

		$this->Modeldata->updateKasusMenonjol($idKasus);
		$this->session->set_flashdata('success', 'Kasus menonjol berhasil diupdate!');
		redirect(base_url("kasus-menonjol"));
	}
	
	public function batalKasusMenonjol($idKasus){

		$this->Modeldata->batalKasusMenonjol($idKasus);
		$this->session->set_flashdata('success', 'Kasus menonjol berhasil diupdate!');
		redirect(base_url("kasus-menonjol"));
	}

	public function delKasus($idKasus){
		// Check if pelimpahan exist
		$checkPelimpahan = $this->Modelpelimpahan->checkIsPelimpahan($idKasus);
		
		if (!empty($checkPelimpahan)) {
			$this->Modelpelimpahan->delPelimpahan($checkPelimpahan[0]['idKasusPelimpahan']);
		}

		$this->Modeldata->delKasus($idKasus);
		$this->session->set_flashdata('success', 'Informasi kasus berhasil dihapus!');
		redirect(base_url("master-kasus"));
	}
	
	public function updateAdmin($idKasus){
		$nrp = $this->input->post('nrp');
		$this->Modeldata->updateAdminKasus($nrp, $idKasus);
		$this->session->set_flashdata('success', 'Admin kasus berhasil diupdate!');
		redirect(base_url("master-kasus"));
	}
	
	public function lockLP($idKasus){
		$this->Modeldata->lockLP($idKasus);

		// Check Permohonan
		$res = $this->Modelpermohonan->checkPermohonan($idKasus);
		if (!empty($res)) {
			$this->Modelpermohonan->delPermohonanByIdKasus($idKasus);
		}

		$this->session->set_flashdata('success', 'Data kasus berhasil dikunci ke database!');
		redirect(base_url("master-kasus"));
	}
	
	public function addPermohonan($idKasus){
		$alasan_permohonan = $this->input->post('alasan_permohonan');
		$dataPermohonan = array(
			"kode_kesatuan" => $this->kode_kesatuan,
			"id_kasus" => $idKasus,
			"alasan_permohonan" => $alasan_permohonan,
		);
		$this->Modelpermohonan->addPermohonan($dataPermohonan);
		$this->session->set_flashdata('success', 'Permohonan perubahan kasus berhasil diupdate!');
		redirect(base_url("daftar-permohonan-edit"));
	}


	// MATRIK KASUS MODUL	
  public function viewMatrikKasus(){
		$date = $this->rangeMonth(date("Y-m-d", strtotime("-1 month")), date("Y-m-d", strtotime("+1 month")));
		$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($date['start']))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($date['end'])));

		if ($this->kode_kesatuan == 'ADMINSUPER') {

			$dataMatrikKasus = array();
			$kesatuan = $this->Modelkesatuan->getKesatuan();
			
			$statusInstrumen = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
			$status = array();

			
			$usiaInstrumen = array("<14","15-18","19-24","25-64","<65");
			$usia = array();
			
			$pendidikanInstrumen = array("Tidak Sekolah","SD","SMP","SMA","PT","Belum Diketahui");
			$pendidikan = array();
			
			$pekerjaanInstrumen = array("Pelajar","Mahasiswa","Swasta","Buruh/Karyawan","Petani/Nelayan","Pedagang","Wiraswasta/Pengusaha", "Sopir/TukangOjek","Ikut Orang Tua", "Ibu Rumah Tangga","Tidak Kerja", "Notaris", "TNI","POLRI","PNS","PEMBANTU","NAPI");
			$pekerjaan = array();
			
			$tkpInstrumen = array("Hotel/Villa/Kos","Ruko/Gedung/Mall/Pabrik","Tempat Umum","Pemukiman/Pondok","Diskotik/Tempat Karaoke","Terminal/Bandara/Pelabuhan","Rumah Tahanan");
			$tkp = array();
			
			$bbInstrumen = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu", "GOL III","GOL IV","Daftar G","Kosmetik","Jamu");
			$bb = array();

			foreach ($kesatuan as $keyKesatuan) {

				// Get Count For Matrik
				foreach ($statusInstrumen as $keyStatusInstrumen) {
					$status[$keyStatusInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.status", $keyStatusInstrumen, $date['start'], $date['end']);
				};
				foreach ($usiaInstrumen as $keyUsiaInstrumen) {
					$usia[$keyUsiaInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.kategori_usia", $keyUsiaInstrumen, $date['start'], $date['end']);
				};
				foreach ($pendidikanInstrumen as $keyPendidikanInstrumen) {
					$pendidikan[$keyPendidikanInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.pendidikan", $keyPendidikanInstrumen, $date['start'], $date['end']);
				};
				foreach ($pekerjaanInstrumen as $keyPekerjaanInstrumen) {
					$pekerjaan[$keyPekerjaanInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.pekerjaan", $keyPekerjaanInstrumen, $date['start'], $date['end']);
				};
				foreach ($tkpInstrumen as $keyTkpInstrumen) {
					$tkp[$keyTkpInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.pekerjaan", $keyTkpInstrumen, $date['start'], $date['end']);
				};
				foreach ($bbInstrumen as $keyBbInstrumen) {
					$jumlahBerat = 0;
					$berat_gram = 0;
					$berat_butir = 0;
					$res = $this->Modeldata->getBeratBB($keyKesatuan['kode_kesatuan'], $keyBbInstrumen, $date['start'], $date['end'])->result_array();
					if (!empty($res)) {
						if($keyBbInstrumen === 'GOL IV' || $keyBbInstrumen === 'GOL III'){
							foreach ($res as $keybb) {
								if ($keybb['satuan'] == 'gram') {
									$berat_gram += (float)$keybb['jumlah'];
								} else {
									$berat_butir += (float)$keybb['jumlah'];
								}
							}
							if ($berat_gram != 0 && $berat_butir != 0) {
								$beratSatuan = $berat_gram." gram & ".$berat_butir." butir";
							}elseif ($berat_gram == 0) {
								$beratSatuan = $berat_butir." butir";
							}else{
								$beratSatuan = $berat_gram." gram";
							}
						}else{
							foreach ($res as $keybb) {
								$jumlahBerat += $keybb['jumlah'];
							}
							$beratSatuan = "{$jumlahBerat} {$res[0]['satuan']}";
						}
					}else{
						$beratSatuan = $jumlahBerat;
					}
					$bb[$keyBbInstrumen] = $beratSatuan;
				};

				$dataMatrikKasus[$keyKesatuan['kode_kesatuan']] = array(
					"KSS" => $this->Modeldata->getKSS($keyKesatuan['kode_kesatuan'], $date['start'], $date['end']),
					"TSK" => $this->Modeldata->getTSK($keyKesatuan['kode_kesatuan'], $date['start'], $date['end']),
					"StatusTSK" => $status,
					"KEWARGANEGARAAN" => array(
						"WNA" => array(
							"LK" => $this->Modeldata->getKewarganegaraanJenisKelamin($keyKesatuan['kode_kesatuan'], "WNA", "LK", $date['start'], $date['end']),
							"PR" => $this->Modeldata->getKewarganegaraanJenisKelamin($keyKesatuan['kode_kesatuan'], "WNA", "PR", $date['start'], $date['end']),
						),
						"WNI" => array(
							"LK" => $this->Modeldata->getKewarganegaraanJenisKelamin($keyKesatuan['kode_kesatuan'], "WNI", "LK", $date['start'], $date['end']),
							"PR" => $this->Modeldata->getKewarganegaraanJenisKelamin($keyKesatuan['kode_kesatuan'], "WNI", "PR", $date['start'], $date['end']),
						),
					),
					"USIA" => $usia,
					"PENDIDIKAN" => $pendidikan,
					"PEKERJAAAN" => $pekerjaan,
					"TKP" => $tkp,
					"BARANGBUKTI" => $bb,
				);
			};

			// Get Total
			$statusTotal = array();
			$usiaTotal = array();
			$pendidikanTotal = array();
			$pekerjaanTotal = array();
			$tkpTotal = array();
			$bbTotal = array();
			
			foreach ($statusInstrumen as $keyStatusInstrumen) {
				$statusTotal[$keyStatusInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.status", $keyStatusInstrumen, $date['start'], $date['end']);
			};
			foreach ($usiaInstrumen as $keyUsiaInstrumen) {
				$usiaTotal[$keyUsiaInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.kategori_usia", $keyUsiaInstrumen, $date['start'], $date['end']);
			};
			foreach ($pendidikanInstrumen as $keyPendidikanInstrumen) {
				$pendidikanTotal[$keyPendidikanInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.pendidikan", $keyPendidikanInstrumen, $date['start'], $date['end']);
			};
			foreach ($pekerjaanInstrumen as $keyPekerjaanInstrumen) {
				$pekerjaanTotal[$keyPekerjaanInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.pekerjaan", $keyPekerjaanInstrumen, $date['start'], $date['end']);
			};
			foreach ($tkpInstrumen as $keyTkpInstrumen) {
				$tkpTotal[$keyTkpInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.pekerjaan", $keyTkpInstrumen, $date['start'], $date['end']);
			};
			foreach ($bbInstrumen as $keyBbInstrumen) {
				$jumlahBerat = 0;
				$berat_gram = 0;
				$berat_butir = 0;
				$res = $this->Modeldata->getSuperBeratBB($keyBbInstrumen, $date['start'], $date['end'])->result_array();
				if (!empty($res)) {
					if($keyBbInstrumen === 'GOL IV' || $keyBbInstrumen === 'GOL III'){
						foreach ($res as $keybb) {
							if ($keybb['satuan'] == 'gram') {
								$berat_gram += (float)$keybb['jumlah'];
							} else {
								$berat_butir += (float)$keybb['jumlah'];
							}
						}
						if ($berat_gram != 0 && $berat_butir != 0) {
							$beratSatuan = $berat_gram." gram & ".$berat_butir." butir";
						}elseif ($berat_gram == 0) {
							$beratSatuan = $berat_butir." butir";
						}else{
							$beratSatuan = $berat_gram." gram";
						}
					}else{
						foreach ($res as $keybb) {
							$jumlahBerat += $keybb['jumlah'];
						}
						$beratSatuan = "{$jumlahBerat} {$res[0]['satuan']}";
					}
				}else{
					$beratSatuan = $jumlahBerat;
				}
				$bbTotal[$keyBbInstrumen] = $beratSatuan;
			};

			$totalMatrik = array(
				"KSS" => $this->Modeldata->getSuperKSS($date['start'], $date['end']),
				"TSK" => $this->Modeldata->getSuperTSK($date['start'], $date['end']),
				"StatusTSK" => $statusTotal,
				"KEWARGANEGARAAN" => array(
					"WNA" => array(
						"LK" => $this->Modeldata->getSuperKewarganegaraanJenisKelamin("WNA", "LK", $date['start'], $date['end']),
						"PR" => $this->Modeldata->getSuperKewarganegaraanJenisKelamin("WNA", "PR", $date['start'], $date['end']),
					),
					"WNI" => array(
						"LK" => $this->Modeldata->getSuperKewarganegaraanJenisKelamin("WNI", "LK", $date['start'], $date['end']),
						"PR" => $this->Modeldata->getSuperKewarganegaraanJenisKelamin("WNI", "PR", $date['start'], $date['end']),
					),
				),
				"USIA" => $usiaTotal,
				"PENDIDIKAN" => $pendidikanTotal,
				"PEKERJAAAN" => $pekerjaanTotal,
				"TKP" => $tkpTotal,
				"BARANGBUKTI" => $bbTotal,
			);

			$data['title'] = "Rekap Ungkap Kasus";
			$data['menuLink'] = "matrik-kasus";
			$data['dataMatrik'] = $dataMatrikKasus;
			$data['totalMatrik'] = $totalMatrik;
			$data['dateNow'] = $dateNow;

		} else {

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
			$bb = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL III", "GOL IV","Daftar G","Kosmetik","Jamu");

			foreach ($bb as $key) {
				$jumlahBerat = 0;
				$berat_gram = 0;
				$berat_butir = 0;
				$res = $this->Modeldata->getBeratBB($this->kode_kesatuan, $key, $date['start'], $date['end'])->result_array();
				if (!empty($res)) {
					if($key === 'GOL IV' || $key === 'GOL III'){
						foreach ($res as $keybb) {
							if ($keybb['satuan'] == 'gram') {
								$berat_gram += (float)$keybb['jumlah'];
							} else {
								$berat_butir += (float)$keybb['jumlah'];
							}
						}
						if ($berat_gram != 0 && $berat_butir != 0) {
							$beratSatuan = $berat_gram." gram & ".$berat_butir." butir";
						}elseif ($berat_gram == 0) {
							$beratSatuan = $berat_butir." butir";
						}else{
							$beratSatuan = $berat_gram." gram";
						}
					}else{
						foreach ($res as $keybb) {
							$jumlahBerat += $keybb['jumlah'];
						}
						$beratSatuan = "{$jumlahBerat} {$res[0]['satuan']}";
					}
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

			$data['title'] = "Rekap Ungkap Kasus";
			$data['menuLink'] = "matrik-kasus";
			$data['dataMatrik'] = $data;
			$data['dateNow'] = $dateNow;

		}
			
		$data['btnExitSort'] = false;
		
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

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate)));
		} else {
			$firstDate = $tanggalAwal;
			$lastDate = $tanggalAkhir;

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($lastDate)));	
		}
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {

			$dataMatrikKasus = array();
			$kesatuan = $this->Modelkesatuan->getKesatuan();
			
			$statusInstrumen = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
			$status = array();

			
			$usiaInstrumen = array("<14","15-18","19-24","25-64","<65");
			$usia = array();
			
			$pendidikanInstrumen = array("Tidak Sekolah","SD","SMP","SMA","PT","Belum Diketahui");
			$pendidikan = array();
			
			$pekerjaanInstrumen = array("Pelajar","Mahasiswa","Swasta","Buruh/Karyawan","Petani/Nelayan","Pedagang","Wiraswasta/Pengusaha", "Sopir/TukangOjek","Ikut Orang Tua", "Ibu Rumah Tangga","Tidak Kerja", "Notaris", "TNI","POLRI","PNS","PEMBANTU","NAPI");
			$pekerjaan = array();
			
			$tkpInstrumen = array("Hotel/Villa/Kos","Ruko/Gedung/Mall/Pabrik","Tempat Umum","Pemukiman/Pondok","Diskotik/Tempat Karaoke","Terminal/Bandara/Pelabuhan","Rumah Tahanan");
			$tkp = array();
			
			$bbInstrumen = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL III","GOL IV","Daftar G","Kosmetik","Jamu");
			$bb = array();
			

			foreach ($kesatuan as $keyKesatuan) {

				// Get Count For Matrik
				foreach ($statusInstrumen as $keyStatusInstrumen) {
					$status[$keyStatusInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.status", $keyStatusInstrumen, $firstDate, $lastDate);
				};
				foreach ($usiaInstrumen as $keyUsiaInstrumen) {
					$usia[$keyUsiaInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.kategori_usia", $keyUsiaInstrumen, $firstDate, $lastDate);
				};
				foreach ($pendidikanInstrumen as $keyPendidikanInstrumen) {
					$pendidikan[$keyPendidikanInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.pendidikan", $keyPendidikanInstrumen, $firstDate, $lastDate);
				};
				foreach ($pekerjaanInstrumen as $keyPekerjaanInstrumen) {
					$pekerjaan[$keyPekerjaanInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.pekerjaan", $keyPekerjaanInstrumen, $firstDate, $lastDate);
				};
				foreach ($tkpInstrumen as $keyTkpInstrumen) {
					$tkp[$keyTkpInstrumen] = $this->Modeldata->getCountWithOneCondition($keyKesatuan['kode_kesatuan'], "tb_tersangka.pekerjaan", $keyTkpInstrumen, $firstDate, $lastDate);
				};
				foreach ($bbInstrumen as $keyBbInstrumen) {
					$jumlahBerat = 0;
					$berat_gram = 0;
					$berat_butir = 0;
					$res = $this->Modeldata->getBeratBB($keyKesatuan['kode_kesatuan'], $keyBbInstrumen, $firstDate, $lastDate)->result_array();
					if (!empty($res)) {
						if($keyBbInstrumen === 'GOL IV' || $keyBbInstrumen === 'GOL III'){
							foreach ($res as $keybb) {
								if ($keybb['satuan'] == 'gram') {
									$berat_gram += (float)$keybb['jumlah'];
								} else {
									$berat_butir += (float)$keybb['jumlah'];
								}
							}
							if ($berat_gram != 0 && $berat_butir != 0) {
								$beratSatuan = $berat_gram." gram & ".$berat_butir." butir";
							}elseif ($berat_gram == 0) {
								$beratSatuan = $berat_butir." butir";
							}else{
								$beratSatuan = $berat_gram." gram";
							}
						}else{
							foreach ($res as $keybb) {
								$jumlahBerat += $keybb['jumlah'];
							}
							$beratSatuan = "{$jumlahBerat} {$res[0]['satuan']}";
						}
					}else{
						$beratSatuan = $jumlahBerat;
					}
					$bb[$keyBbInstrumen] = $beratSatuan;
				};

				$dataMatrikKasus[$keyKesatuan['kode_kesatuan']] = array(
					"KSS" => $this->Modeldata->getKSS($keyKesatuan['kode_kesatuan'], $firstDate, $lastDate),
					"TSK" => $this->Modeldata->getTSK($keyKesatuan['kode_kesatuan'], $firstDate, $lastDate),
					"StatusTSK" => $status,
					"KEWARGANEGARAAN" => array(
						"WNA" => array(
							"LK" => $this->Modeldata->getKewarganegaraanJenisKelamin($keyKesatuan['kode_kesatuan'], "WNA", "LK", $firstDate, $lastDate),
							"PR" => $this->Modeldata->getKewarganegaraanJenisKelamin($keyKesatuan['kode_kesatuan'], "WNA", "PR", $firstDate, $lastDate),
						),
						"WNI" => array(
							"LK" => $this->Modeldata->getKewarganegaraanJenisKelamin($keyKesatuan['kode_kesatuan'], "WNI", "LK", $firstDate, $lastDate),
							"PR" => $this->Modeldata->getKewarganegaraanJenisKelamin($keyKesatuan['kode_kesatuan'], "WNI", "PR", $firstDate, $lastDate),
						),
					),
					"USIA" => $usia,
					"PENDIDIKAN" => $pendidikan,
					"PEKERJAAAN" => $pekerjaan,
					"TKP" => $tkp,
					"BARANGBUKTI" => $bb,
				);
			};

			// Get Total
			$statusTotal = array();
			$usiaTotal = array();
			$pendidikanTotal = array();
			$pekerjaanTotal = array();
			$tkpTotal = array();
			$bbTotal = array();
			
			foreach ($statusInstrumen as $keyStatusInstrumen) {
				$statusTotal[$keyStatusInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.status", $keyStatusInstrumen, $firstDate, $lastDate);
			};
			foreach ($usiaInstrumen as $keyUsiaInstrumen) {
				$usiaTotal[$keyUsiaInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.kategori_usia", $keyUsiaInstrumen, $firstDate, $lastDate);
			};
			foreach ($pendidikanInstrumen as $keyPendidikanInstrumen) {
				$pendidikanTotal[$keyPendidikanInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.pendidikan", $keyPendidikanInstrumen, $firstDate, $lastDate);
			};
			foreach ($pekerjaanInstrumen as $keyPekerjaanInstrumen) {
				$pekerjaanTotal[$keyPekerjaanInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.pekerjaan", $keyPekerjaanInstrumen, $firstDate, $lastDate);
			};
			foreach ($tkpInstrumen as $keyTkpInstrumen) {
				$tkpTotal[$keyTkpInstrumen] = $this->Modeldata->getSuperCountWithOneCondition("tb_tersangka.pekerjaan", $keyTkpInstrumen, $firstDate, $lastDate);
			};
			foreach ($bbInstrumen as $keyBbInstrumen) {
				$jumlahBerat = 0;
				$berat_gram = 0;
				$berat_butir = 0;
				$res = $this->Modeldata->getSuperBeratBB($keyBbInstrumen, $firstDate, $lastDate)->result_array();
				if (!empty($res)) {
					if($keyBbInstrumen === 'GOL IV' || $keyBbInstrumen === 'GOL III'){
						foreach ($res as $keybb) {
							if ($keybb['satuan'] == 'gram') {
								$berat_gram += (float)$keybb['jumlah'];
							} else {
								$berat_butir += (float)$keybb['jumlah'];
							}
						}
						if ($berat_gram != 0 && $berat_butir != 0) {
							$beratSatuan = $berat_gram." gram & ".$berat_butir." butir";
						}elseif ($berat_gram == 0) {
							$beratSatuan = $berat_butir." butir";
						}else{
							$beratSatuan = $berat_gram." gram";
						}
					}else{
						foreach ($res as $keybb) {
							$jumlahBerat += $keybb['jumlah'];
						}
						$beratSatuan = "{$jumlahBerat} {$res[0]['satuan']}";
					}
				}else{
					$beratSatuan = $jumlahBerat;
				}
				$bbTotal[$keyBbInstrumen] = $beratSatuan;
			};

			$totalMatrik = array(
				"KSS" => $this->Modeldata->getSuperKSS($firstDate, $lastDate),
				"TSK" => $this->Modeldata->getSuperTSK($firstDate, $lastDate),
				"StatusTSK" => $statusTotal,
				"KEWARGANEGARAAN" => array(
					"WNA" => array(
						"LK" => $this->Modeldata->getSuperKewarganegaraanJenisKelamin("WNA", "LK", $firstDate, $lastDate),
						"PR" => $this->Modeldata->getSuperKewarganegaraanJenisKelamin("WNA", "PR", $firstDate, $lastDate),
					),
					"WNI" => array(
						"LK" => $this->Modeldata->getSuperKewarganegaraanJenisKelamin("WNI", "LK", $firstDate, $lastDate),
						"PR" => $this->Modeldata->getSuperKewarganegaraanJenisKelamin("WNI", "PR", $firstDate, $lastDate),
					),
				),
				"USIA" => $usiaTotal,
				"PENDIDIKAN" => $pendidikanTotal,
				"PEKERJAAAN" => $pekerjaanTotal,
				"TKP" => $tkpTotal,
				"BARANGBUKTI" => $bbTotal,
			);

			$data['title'] = "Rekap Ungkap Kasus";
			$data['menuLink'] = "matrik-kasus";
			$data['totalMatrik'] = $totalMatrik;
			$data['dataMatrik'] = $dataMatrikKasus;
			$data['dateNow'] = $dateNow;

		} else {
		
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
			$bb = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL III", "GOL IV","Daftar G","Kosmetik","Jamu");
			foreach ($bb as $key) {
				$jumlahBerat = 0;
				$berat_gram = 0;
				$berat_butir = 0;
				$res = $this->Modeldata->getBeratBB($this->kode_kesatuan, $key, $firstDate, $lastDate)->result_array();
				if (!empty($res)) {
					if($key === 'GOL IV' || $key === 'GOL III'){
						foreach ($res as $keybb) {
							if ($keybb['satuan'] == 'gram') {
								$berat_gram += (float)$keybb['jumlah'];
							} else {
								$berat_butir += (float)$keybb['jumlah'];
							}
						}
						if ($berat_gram != 0 && $berat_butir != 0) {
							$beratSatuan = $berat_gram." gram & ".$berat_butir." butir";
						}elseif ($berat_gram == 0) {
							$beratSatuan = $berat_butir." butir";
						}else{
							$beratSatuan = $berat_gram." gram";
						}
					}else{
						foreach ($res as $keybb) {
							$jumlahBerat += $keybb['jumlah'];
						}
						$beratSatuan = "{$jumlahBerat} {$res[0]['satuan']}";
					}
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

			$data['title'] = "Rekap Ungkap Kasus";
			$data['menuLink'] = "matrik-kasus";
			$data['dataMatrik'] = $data;
			$data['dateNow'] = $dateNow;

		}
			
		$data['btnExitSort'] = true;

		$this->load->view('include/header',$data);
		$this->load->view('v_data_matrikkasus',$data);
		$this->load->view('include/footer',$data);
	}


	// MATRIK BARANG BUKTI MODUL
  public function viewMatrikBarangBukti(){
		$date = $this->rangeMonth(date("Y-m-d", strtotime("-1 month")), date("Y-m-d", strtotime("+1 month")));
		$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($date['start']))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($date['end'])));

		$kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","Daftar G","Kosmetik","Jamu");
		$statusTSK = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
		$data = array();

		$kategoriBBGol = array("GOL IV", "GOL III");
		$dataGol = array();
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			foreach($kategoriBB as $kategori) {
				// DATA
				$dataStatusTSK = array();
				foreach ($statusTSK as $keyStatusTSK) {
					$dataStatusTSK[$keyStatusTSK] = array(
						"JML_KSS" => $this->Modeldata->getSuperBBJumlahKSS($kategori, $keyStatusTSK, $date['start'], $date['end']),
						"JML_TSK" => $this->Modeldata->getSuperBBJumlahTSK($kategori, $keyStatusTSK, $date['start'], $date['end']),
						"JML_SelesaiKSS" => $this->Modeldata->getSuperBBSelesaiKSS($kategori, $keyStatusTSK, $date['start'], $date['end']),
						"WNILK" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategori, $keyStatusTSK, 'WNI', 'LK', $date['start'], $date['end']),
						"WNIPR" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategori, $keyStatusTSK, 'WNI', 'PR', $date['start'], $date['end']),
						"WNALK" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategori, $keyStatusTSK, 'WNA', 'LK', $date['start'], $date['end']),
						"WNAPR" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategori, $keyStatusTSK, 'WNA', 'PR', $date['start'], $date['end']),
						"USIA14" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $date['start'], $date['end']),
						"USIA1518" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $date['start'], $date['end']),
						"USIA1924" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $date['start'], $date['end']),
						"USIA2564" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $date['start'], $date['end']),
						"USIA65" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $date['start'], $date['end']),
						"PND_TIDAKSEKOLAH" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $date['start'], $date['end']),
						"PND_SD" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $date['start'], $date['end']),
						"PND_SMP" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $date['start'], $date['end']),
						"PND_SMA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $date['start'], $date['end']),
						"PND_PT" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $date['start'], $date['end']),
						"PND_BELUMDIKETAHUI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $date['start'], $date['end']),
						"PKR_PELAJAR" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $date['start'], $date['end']),
						"PKR_MAHASISWA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $date['start'], $date['end']),
						"PKR_SWASTA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $date['start'], $date['end']),
						"PKR_BURUHKARYAWAN" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $date['start'], $date['end']),
						"PKR_PETANINELAYAN" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $date['start'], $date['end']),
						"PKR_PEDAGANG" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $date['start'], $date['end']),
						"PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $date['start'], $date['end']),
						"PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $date['start'], $date['end']),
						"PKR_IKUTORANGTUA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $date['start'], $date['end']),
						"PKR_IBURUMAHTANGGA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $date['start'], $date['end']),
						"PKR_TIDAKKERJA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $date['start'], $date['end']),
						"PKR_NOTARIS" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $date['start'], $date['end']),
						"PKR_TNI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $date['start'], $date['end']),
						"PKR_POLRI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $date['start'], $date['end']),
						"PKR_PNS" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $date['start'], $date['end']),
						"PKR_PEMBANTU" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $date['start'], $date['end']),
						"PKR_NAPI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $date['start'], $date['end']),
						"JML_BERAT_BB" => $this->Modeldata->getSuperBBJumlahBerat($kategori, $keyStatusTSK, $date['start'], $date['end']),
					);
				};
				$data[$kategori] = $dataStatusTSK; 
			}
			// Khusus GOL IV & GOL III
			foreach($kategoriBBGol as $kategoriGol) {
				// DATA
				$dataStatusTSKGol = array();
				foreach ($statusTSK as $keyStatusTSK) {
					$dataStatusTSKGol[$keyStatusTSK] = array(
						"JML_KSS" => $this->Modeldata->getSuperBBJumlahKSS($kategoriGol, $keyStatusTSK, $date['start'], $date['end']),
						"JML_TSK" => $this->Modeldata->getSuperBBJumlahTSK($kategoriGol, $keyStatusTSK, $date['start'], $date['end']),
						"JML_SelesaiKSS" => $this->Modeldata->getSuperBBSelesaiKSS($kategoriGol, $keyStatusTSK, $date['start'], $date['end']),
						"WNILK" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategoriGol, $keyStatusTSK, 'WNI', 'LK', $date['start'], $date['end']),
						"WNIPR" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategoriGol, $keyStatusTSK, 'WNI', 'PR', $date['start'], $date['end']),
						"WNALK" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategoriGol, $keyStatusTSK, 'WNA', 'LK', $date['start'], $date['end']),
						"WNAPR" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategoriGol, $keyStatusTSK, 'WNA', 'PR', $date['start'], $date['end']),
						"USIA14" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $date['start'], $date['end']),
						"USIA1518" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $date['start'], $date['end']),
						"USIA1924" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $date['start'], $date['end']),
						"USIA2564" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $date['start'], $date['end']),
						"USIA65" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $date['start'], $date['end']),
						"PND_TIDAKSEKOLAH" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $date['start'], $date['end']),
						"PND_SD" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $date['start'], $date['end']),
						"PND_SMP" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $date['start'], $date['end']),
						"PND_SMA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $date['start'], $date['end']),
						"PND_PT" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $date['start'], $date['end']),
						"PND_BELUMDIKETAHUI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $date['start'], $date['end']),
						"PKR_PELAJAR" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $date['start'], $date['end']),
						"PKR_MAHASISWA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $date['start'], $date['end']),
						"PKR_SWASTA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $date['start'], $date['end']),
						"PKR_BURUHKARYAWAN" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $date['start'], $date['end']),
						"PKR_PETANINELAYAN" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $date['start'], $date['end']),
						"PKR_PEDAGANG" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $date['start'], $date['end']),
						"PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $date['start'], $date['end']),
						"PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $date['start'], $date['end']),
						"PKR_IKUTORANGTUA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $date['start'], $date['end']),
						"PKR_IBURUMAHTANGGA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $date['start'], $date['end']),
						"PKR_TIDAKKERJA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $date['start'], $date['end']),
						"PKR_NOTARIS" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $date['start'], $date['end']),
						"PKR_TNI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $date['start'], $date['end']),
						"PKR_POLRI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $date['start'], $date['end']),
						"PKR_PNS" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $date['start'], $date['end']),
						"PKR_PEMBANTU" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $date['start'], $date['end']),
						"PKR_NAPI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $date['start'], $date['end']),
						"JML_BERAT_BB" => $this->Modeldata->getSuperBBJumlahBerat($kategoriGol, $keyStatusTSK, $date['start'], $date['end']),
					);
				};
				$dataGol[$kategoriGol] = $dataStatusTSKGol; 
			}
		} else {
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
			// Khusus GOL IV & GOL III
			foreach($kategoriBBGol as $kategoriGol) {
				// DATA
				$dataStatusTSKGol = array();
				foreach ($statusTSK as $keyStatusTSK) {
					$dataStatusTSKGol[$keyStatusTSK] = array(
						"JML_KSS" => $this->Modeldata->getBBJumlahKSS($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, $date['start'], $date['end']),
						"JML_TSK" => $this->Modeldata->getBBJumlahTSK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, $date['start'], $date['end']),
						"JML_SelesaiKSS" => $this->Modeldata->getBBSelesaiKSS($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, $date['start'], $date['end']),
						"WNILK" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'WNI', 'LK', $date['start'], $date['end']),
						"WNIPR" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'WNI', 'PR', $date['start'], $date['end']),
						"WNALK" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'WNA', 'LK', $date['start'], $date['end']),
						"WNAPR" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'WNA', 'PR', $date['start'], $date['end']),
						"USIA14" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $date['start'], $date['end']),
						"USIA1518" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $date['start'], $date['end']),
						"USIA1924" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $date['start'], $date['end']),
						"USIA2564" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $date['start'], $date['end']),
						"USIA65" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $date['start'], $date['end']),
						"PND_TIDAKSEKOLAH" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $date['start'], $date['end']),
						"PND_SD" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $date['start'], $date['end']),
						"PND_SMP" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $date['start'], $date['end']),
						"PND_SMA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $date['start'], $date['end']),
						"PND_PT" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $date['start'], $date['end']),
						"PND_BELUMDIKETAHUI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $date['start'], $date['end']),
						"PKR_PELAJAR" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $date['start'], $date['end']),
						"PKR_MAHASISWA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $date['start'], $date['end']),
						"PKR_SWASTA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $date['start'], $date['end']),
						"PKR_BURUHKARYAWAN" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $date['start'], $date['end']),
						"PKR_PETANINELAYAN" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $date['start'], $date['end']),
						"PKR_PEDAGANG" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $date['start'], $date['end']),
						"PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $date['start'], $date['end']),
						"PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $date['start'], $date['end']),
						"PKR_IKUTORANGTUA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $date['start'], $date['end']),
						"PKR_IBURUMAHTANGGA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $date['start'], $date['end']),
						"PKR_TIDAKKERJA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $date['start'], $date['end']),
						"PKR_NOTARIS" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $date['start'], $date['end']),
						"PKR_TNI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $date['start'], $date['end']),
						"PKR_POLRI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $date['start'], $date['end']),
						"PKR_PNS" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $date['start'], $date['end']),
						"PKR_PEMBANTU" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $date['start'], $date['end']),
						"PKR_NAPI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $date['start'], $date['end']),
						"JML_BERAT_BB" => $this->Modeldata->getBBJumlahBerat($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, $date['start'], $date['end']),
					);
				};
				$dataGol[$kategoriGol] = $dataStatusTSKGol; 
			}
		}

		$data['title'] = "Matrik Ungkap Kasus";
		$data['menuLink'] = "matrik-barang-bukti";
		$data['dataMatrik'] = $data;
		$data['dataMatrikGol'] = $dataGol;
		$data['dateNow'] = $dateNow;
		
		$data['btnExitSort'] = false;

		$this->load->view('include/header',$data);
		$this->load->view('v_data_matrikbarangbukti',$data);
		$this->load->view('include/footer',$data);
	}
	
  public function viewMatrikBarangBuktiByDate(){
		$nama_kesatuan = $this->input->post('kode_kesatuan');
		$tanggalAwal = $this->input->post('tanggalAwal');
		$tanggalAkhir = $this->input->post('tanggalAkhir');
		$firstDate = '';
		$lastDate = '';
		
		if (empty($tanggalAwal) || empty($tanggalAkhir)) {
			$firstDate = $tanggalAwal;
			$lastDate = $tanggalAwal;

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate)));
		} else {
			$firstDate = $tanggalAwal;
			$lastDate = $tanggalAkhir;

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($lastDate)));	
		}

		$kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","Daftar G","Kosmetik","Jamu");
		$statusTSK = array("Penanam", "Produksi", "Bandar", "Pengedar", "Pengguna");
		$data = array();
		
		$kategoriBBGol = array("GOL IV", "GOL III");
		$dataGol = array();

		if ($nama_kesatuan == 'all') {
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
			// Khusus GOL IV & GOL III
			foreach($kategoriBBGol as $kategoriGol) {
				// DATA
				$dataStatusTSKGol = array();
				foreach ($statusTSK as $keyStatusTSK) {
					$dataStatusTSKGol[$keyStatusTSK] = array(
						"JML_KSS" => $this->Modeldata->getSuperBBJumlahKSS($kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
						"JML_TSK" => $this->Modeldata->getSuperBBJumlahTSK($kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
						"JML_SelesaiKSS" => $this->Modeldata->getSuperBBSelesaiKSS($kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
						"WNILK" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategoriGol, $keyStatusTSK, 'WNI', 'LK', $firstDate, $lastDate),
						"WNIPR" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategoriGol, $keyStatusTSK, 'WNI', 'PR', $firstDate, $lastDate),
						"WNALK" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategoriGol, $keyStatusTSK, 'WNA', 'LK', $firstDate, $lastDate),
						"WNAPR" => $this->Modeldata->getSuperBBKewarganegaraanJK($kategoriGol, $keyStatusTSK, 'WNA', 'PR', $firstDate, $lastDate),
						"USIA14" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $firstDate, $lastDate),
						"USIA1518" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $firstDate, $lastDate),
						"USIA1924" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $firstDate, $lastDate),
						"USIA2564" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $firstDate, $lastDate),
						"USIA65" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $firstDate, $lastDate),
						"PND_TIDAKSEKOLAH" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $firstDate, $lastDate),
						"PND_SD" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $firstDate, $lastDate),
						"PND_SMP" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $firstDate, $lastDate),
						"PND_SMA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $firstDate, $lastDate),
						"PND_PT" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $firstDate, $lastDate),
						"PND_BELUMDIKETAHUI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $firstDate, $lastDate),
						"PKR_PELAJAR" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $firstDate, $lastDate),
						"PKR_MAHASISWA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $firstDate, $lastDate),
						"PKR_SWASTA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $firstDate, $lastDate),
						"PKR_BURUHKARYAWAN" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $firstDate, $lastDate),
						"PKR_PETANINELAYAN" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $firstDate, $lastDate),
						"PKR_PEDAGANG" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $firstDate, $lastDate),
						"PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $firstDate, $lastDate),
						"PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $firstDate, $lastDate),
						"PKR_IKUTORANGTUA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $firstDate, $lastDate),
						"PKR_IBURUMAHTANGGA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $firstDate, $lastDate),
						"PKR_TIDAKKERJA" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $firstDate, $lastDate),
						"PKR_NOTARIS" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $firstDate, $lastDate),
						"PKR_TNI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $firstDate, $lastDate),
						"PKR_POLRI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $firstDate, $lastDate),
						"PKR_PNS" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $firstDate, $lastDate),
						"PKR_PEMBANTU" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $firstDate, $lastDate),
						"PKR_NAPI" => $this->Modeldata->getSuperBBMatrikInstrumen($kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $firstDate, $lastDate),
						"JML_BERAT_BB" => $this->Modeldata->getSuperBBJumlahBerat($kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
					);
				};
				$dataGol[$kategoriGol] = $dataStatusTSKGol; 
			}
			
			$data['title'] = "Matrik Ungkap Kasus";
			$data['menuLink'] = "matrik-barang-bukti";
			$data['dataMatrik'] = $data;
			$data['dataMatrikGol'] = $dataGol;
			$data['dateNow'] = $dateNow;
			$data['btnExitSort'] = true;

			$this->load->view('include/header',$data);
			$this->load->view('v_data_matrikbarangbukti',$data);
			$this->load->view('include/footer',$data);
		} else {
			if ($this->kode_kesatuan == 'ADMINSUPER') {
				foreach($kategoriBB as $kategori) {
						// DATA
						$dataStatusTSK = array();
						foreach ($statusTSK as $keyStatusTSK) {
							$dataStatusTSK[$keyStatusTSK] = array(
								"JML_KSS" => $this->Modeldata->getBBJumlahKSS($nama_kesatuan, $kategori, $keyStatusTSK, $firstDate, $lastDate),
								"JML_TSK" => $this->Modeldata->getBBJumlahTSK($nama_kesatuan, $kategori, $keyStatusTSK, $firstDate, $lastDate),
								"JML_SelesaiKSS" => $this->Modeldata->getBBSelesaiKSS($nama_kesatuan, $kategori, $keyStatusTSK, $firstDate, $lastDate),
								"WNILK" => $this->Modeldata->getBBKewarganegaraanJK($nama_kesatuan, $kategori, $keyStatusTSK, 'WNI', 'LK', $firstDate, $lastDate),
								"WNIPR" => $this->Modeldata->getBBKewarganegaraanJK($nama_kesatuan, $kategori, $keyStatusTSK, 'WNI', 'PR', $firstDate, $lastDate),
								"WNALK" => $this->Modeldata->getBBKewarganegaraanJK($nama_kesatuan, $kategori, $keyStatusTSK, 'WNA', 'LK', $firstDate, $lastDate),
								"WNAPR" => $this->Modeldata->getBBKewarganegaraanJK($nama_kesatuan, $kategori, $keyStatusTSK, 'WNA', 'PR', $firstDate, $lastDate),
								"USIA14" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $firstDate, $lastDate),
								"USIA1518" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $firstDate, $lastDate),
								"USIA1924" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $firstDate, $lastDate),
								"USIA2564" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $firstDate, $lastDate),
								"USIA65" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $firstDate, $lastDate),
								"PND_TIDAKSEKOLAH" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $firstDate, $lastDate),
								"PND_SD" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $firstDate, $lastDate),
								"PND_SMP" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $firstDate, $lastDate),
								"PND_SMA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $firstDate, $lastDate),
								"PND_PT" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $firstDate, $lastDate),
								"PND_BELUMDIKETAHUI" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $firstDate, $lastDate),
								"PKR_PELAJAR" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $firstDate, $lastDate),
								"PKR_MAHASISWA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $firstDate, $lastDate),
								"PKR_SWASTA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $firstDate, $lastDate),
								"PKR_BURUHKARYAWAN" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $firstDate, $lastDate),
								"PKR_PETANINELAYAN" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $firstDate, $lastDate),
								"PKR_PEDAGANG" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $firstDate, $lastDate),
								"PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $firstDate, $lastDate),
								"PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $firstDate, $lastDate),
								"PKR_IKUTORANGTUA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $firstDate, $lastDate),
								"PKR_IBURUMAHTANGGA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $firstDate, $lastDate),
								"PKR_TIDAKKERJA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $firstDate, $lastDate),
								"PKR_NOTARIS" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $firstDate, $lastDate),
								"PKR_TNI" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $firstDate, $lastDate),
								"PKR_POLRI" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $firstDate, $lastDate),
								"PKR_PNS" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $firstDate, $lastDate),
								"PKR_PEMBANTU" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $firstDate, $lastDate),
								"PKR_NAPI" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategori, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $firstDate, $lastDate),
								"JML_BERAT_BB" => $this->Modeldata->getBBJumlahBerat($nama_kesatuan, $kategori, $keyStatusTSK, $firstDate, $lastDate),
							);
						};
						$data[$kategori] = $dataStatusTSK; 
				}
				// Khusus GOL IV & GOL III
				foreach($kategoriBBGol as $kategoriGol) {
					// DATA
					$dataStatusTSKGol = array();
					foreach ($statusTSK as $keyStatusTSK) {
						$dataStatusTSKGol[$keyStatusTSK] = array(
							"JML_KSS" => $this->Modeldata->getBBJumlahKSS($nama_kesatuan, $kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
							"JML_TSK" => $this->Modeldata->getBBJumlahTSK($nama_kesatuan, $kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
							"JML_SelesaiKSS" => $this->Modeldata->getBBSelesaiKSS($nama_kesatuan, $kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
							"WNILK" => $this->Modeldata->getBBKewarganegaraanJK($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'WNI', 'LK', $firstDate, $lastDate),
							"WNIPR" => $this->Modeldata->getBBKewarganegaraanJK($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'WNI', 'PR', $firstDate, $lastDate),
							"WNALK" => $this->Modeldata->getBBKewarganegaraanJK($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'WNA', 'LK', $firstDate, $lastDate),
							"WNAPR" => $this->Modeldata->getBBKewarganegaraanJK($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'WNA', 'PR', $firstDate, $lastDate),
							"USIA14" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $firstDate, $lastDate),
							"USIA1518" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $firstDate, $lastDate),
							"USIA1924" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $firstDate, $lastDate),
							"USIA2564" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $firstDate, $lastDate),
							"USIA65" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $firstDate, $lastDate),
							"PND_TIDAKSEKOLAH" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $firstDate, $lastDate),
							"PND_SD" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $firstDate, $lastDate),
							"PND_SMP" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $firstDate, $lastDate),
							"PND_SMA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $firstDate, $lastDate),
							"PND_PT" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $firstDate, $lastDate),
							"PND_BELUMDIKETAHUI" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $firstDate, $lastDate),
							"PKR_PELAJAR" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $firstDate, $lastDate),
							"PKR_MAHASISWA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $firstDate, $lastDate),
							"PKR_SWASTA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $firstDate, $lastDate),
							"PKR_BURUHKARYAWAN" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $firstDate, $lastDate),
							"PKR_PETANINELAYAN" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $firstDate, $lastDate),
							"PKR_PEDAGANG" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $firstDate, $lastDate),
							"PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $firstDate, $lastDate),
							"PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $firstDate, $lastDate),
							"PKR_IKUTORANGTUA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $firstDate, $lastDate),
							"PKR_IBURUMAHTANGGA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $firstDate, $lastDate),
							"PKR_TIDAKKERJA" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $firstDate, $lastDate),
							"PKR_NOTARIS" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $firstDate, $lastDate),
							"PKR_TNI" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $firstDate, $lastDate),
							"PKR_POLRI" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $firstDate, $lastDate),
							"PKR_PNS" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $firstDate, $lastDate),
							"PKR_PEMBANTU" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $firstDate, $lastDate),
							"PKR_NAPI" => $this->Modeldata->getBBMatrikInstrumen($nama_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $firstDate, $lastDate),
							"JML_BERAT_BB" => $this->Modeldata->getBBJumlahBerat($nama_kesatuan, $kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
						);
					};
					$dataGol[$kategoriGol] = $dataStatusTSKGol; 
				}
				
				$data['title'] = "Matrik Ungkap Kasus";
				$data['menuLink'] = "matrik-barang-bukti";
				$data['dataMatrik'] = $data;
				$data['dataMatrikGol'] = $dataGol;
				$data['kesatuanChoosen'] = $nama_kesatuan;
				$data['dateNow'] = $dateNow;
				$data['btnExitSort'] = true;

				$this->load->view('include/header',$data);
				$this->load->view('v_data_matrikbarangbukti',$data);
				$this->load->view('include/footer',$data);
	
			} else {
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
				// Khusus GOL IV & GOL III
				foreach($kategoriBBGol as $kategoriGol) {
					// DATA
					$dataStatusTSKGol = array();
					foreach ($statusTSK as $keyStatusTSK) {
						$dataStatusTSKGol[$keyStatusTSK] = array(
							"JML_KSS" => $this->Modeldata->getBBJumlahKSS($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
							"JML_TSK" => $this->Modeldata->getBBJumlahTSK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
							"JML_SelesaiKSS" => $this->Modeldata->getBBSelesaiKSS($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
							"WNILK" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'WNI', 'LK', $firstDate, $lastDate),
							"WNIPR" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'WNI', 'PR', $firstDate, $lastDate),
							"WNALK" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'WNA', 'LK', $firstDate, $lastDate),
							"WNAPR" => $this->Modeldata->getBBKewarganegaraanJK($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'WNA', 'PR', $firstDate, $lastDate),
							"USIA14" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'<14', $firstDate, $lastDate),
							"USIA1518" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '15-18', $firstDate, $lastDate),
							"USIA1924" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK,'tb_tersangka.kategori_usia' , '19-24', $firstDate, $lastDate),
							"USIA2564" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'25-64', $firstDate, $lastDate),
							"USIA65" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.kategori_usia' ,'65', $firstDate, $lastDate),
							"PND_TIDAKSEKOLAH" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Tidak Sekolah', $firstDate, $lastDate),
							"PND_SD" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SD', $firstDate, $lastDate),
							"PND_SMP" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMP', $firstDate, $lastDate),
							"PND_SMA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'SMA', $firstDate, $lastDate),
							"PND_PT" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'PT', $firstDate, $lastDate),
							"PND_BELUMDIKETAHUI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pendidikan' ,'Belum Diketahui', $firstDate, $lastDate),
							"PKR_PELAJAR" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pelajar', $firstDate, $lastDate),
							"PKR_MAHASISWA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Mahasiswa', $firstDate, $lastDate),
							"PKR_SWASTA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Swasta', $firstDate, $lastDate),
							"PKR_BURUHKARYAWAN" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Buruh/Karyawan', $firstDate, $lastDate),
							"PKR_PETANINELAYAN" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Petani/Nelayan', $firstDate, $lastDate),
							"PKR_PEDAGANG" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Pedagang', $firstDate, $lastDate),
							"PKR_WIRASWASTAPENGUSAHA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Wiraswasta/Pengusaha', $firstDate, $lastDate),
							"PKR_SOPIRTUKANGOJEK" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Sopir/TukangOjek', $firstDate, $lastDate),
							"PKR_IKUTORANGTUA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ikut Orang Tua', $firstDate, $lastDate),
							"PKR_IBURUMAHTANGGA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Ibu Rumah Tangga', $firstDate, $lastDate),
							"PKR_TIDAKKERJA" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Tidak Kerja', $firstDate, $lastDate),
							"PKR_NOTARIS" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'Notaris', $firstDate, $lastDate),
							"PKR_TNI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'TNI', $firstDate, $lastDate),
							"PKR_POLRI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'POLRI', $firstDate, $lastDate),
							"PKR_PNS" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PNS', $firstDate, $lastDate),
							"PKR_PEMBANTU" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'PEMBANTU', $firstDate, $lastDate),
							"PKR_NAPI" => $this->Modeldata->getBBMatrikInstrumen($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, 'tb_tersangka.pekerjaan' ,'NAPI', $firstDate, $lastDate),
							"JML_BERAT_BB" => $this->Modeldata->getBBJumlahBerat($this->kode_kesatuan, $kategoriGol, $keyStatusTSK, $firstDate, $lastDate),
						);
					};
					$dataGol[$kategoriGol] = $dataStatusTSKGol; 
				}
				
				$data['title'] = "Matrik Ungkap Kasus";
				$data['menuLink'] = "matrik-barang-bukti";
				$data['dataMatrik'] = $data;
				$data['dataMatrikGol'] = $dataGol;
				$data['dateNow'] = $dateNow;
				$data['btnExitSort'] = true;

				$this->load->view('include/header',$data);
				$this->load->view('v_data_matrikbarangbukti',$data);
				$this->load->view('include/footer',$data);
			}
		}

	}


	// SELRA MODUL
  public function viewSelra(){

		$date = $this->rangeMonth(date("Y-m-d", strtotime("-1 month")), date("Y-m-d", strtotime("+1 month")));
		$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($date['start']))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($date['end'])));

		if ($this->kode_kesatuan == 'ADMINSUPER') {
			
			$addMatrikSelra = array();
			$kesatuan = $this->Modelkesatuan->getKesatuan();
			
			foreach ($kesatuan as $keyKesatuan) {
				$addMatrikSelra[$keyKesatuan['kode_kesatuan']] = array(
					"CT" => $this->Modeldata->getKSS($keyKesatuan['kode_kesatuan'],$date['start'], $date['end']),
					"CC" => array(
						"Total" =>  count($this->Modeldata->getSelraCC($keyKesatuan['kode_kesatuan'],$date['start'], $date['end'])),
						"SP3" => count($this->Modeldata->getMatrikSelra($keyKesatuan['kode_kesatuan'],$date['start'], $date['end'], "SP3")),
						"RJ" => count($this->Modeldata->getMatrikSelra($keyKesatuan['kode_kesatuan'],$date['start'], $date['end'], "RJ")),
						"TAHAPII" => count($this->Modeldata->getMatrikSelra($keyKesatuan['kode_kesatuan'],$date['start'], $date['end'], "TAHAP II")),	
					),
					"SEDANGPROSES" => count($this->Modeldata->getMatrikSelra($keyKesatuan['kode_kesatuan'],$date['start'], $date['end'], " ")),
					"PRESENTASE" => $this->persentaseSelra(count($this->Modeldata->getSelraCC($keyKesatuan['kode_kesatuan'],$date['start'], $date['end'])), $this->Modeldata->getKSS($keyKesatuan['kode_kesatuan'],$date['start'], $date['end']))
				);
			}
			
			$matrikSelra = array(
				$addMatrikSelra,
				"TOTAL" => array(
					"CT" => $this->Modeldata->getSuperKSS($date['start'], $date['end']),
					"CC" => array(
						"Total" =>  count($this->Modeldata->getSuperSelraCC($date['start'], $date['end'])),
						"SP3" => count($this->Modeldata->getTotalMatrikSelra($date['start'], $date['end'], "SP3")),
						"RJ" => count($this->Modeldata->getTotalMatrikSelra($date['start'], $date['end'], "RJ")),
						"TAHAPII" => count($this->Modeldata->getTotalMatrikSelra($date['start'], $date['end'], "TAHAP II")),	
					),
					"SEDANGPROSES" => count($this->Modeldata->getTotalMatrikSelra($date['start'], $date['end'], " ")),
					"PRESENTASE" => $this->persentaseSelra(count($this->Modeldata->getSuperSelraCC($date['start'], $date['end'])), $this->Modeldata->getSuperKSS($date['start'], $date['end']))
				)
			);

			$data['title'] = "Data Selesai Perkara";
			$data['menuLink'] = "selra";
			$data['dateNow'] = $dateNow;
			$data['matrikSelra'] = $matrikSelra;
			$data['totalMatrikSelra'] = $matrikSelra['TOTAL'];
			$data['dataCC'] = $this->Modeldata->getSuperSelraCC($date['start'], $date['end']);
			$data['dataCT'] = $this->Modeldata->getSuperSelraCT($date['start'], $date['end']);
			$data['orderDate'] = false;
			
		} else {
			
			$matrikCCCT = array(
				"CT" => $this->Modeldata->getKSS($this->kode_kesatuan,$date['start'], $date['end']),
				"CC" => array(
					"Total" =>  count($this->Modeldata->getSelraCC($this->kode_kesatuan,$date['start'], $date['end'])),
					"SP3" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$date['start'], $date['end'], "SP3")),
					"RJ" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$date['start'], $date['end'], "RJ")),
					"TAHAPII" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$date['start'], $date['end'], "TAHAP II")),	
				),
				"SEDANGPROSES" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$date['start'], $date['end'], " ")),
				"PRESENTASE" => $this->persentaseSelra(count($this->Modeldata->getSelraCC($this->kode_kesatuan,$date['start'], $date['end'])), $this->Modeldata->getKSS($this->kode_kesatuan,$date['start'], $date['end']))
			);

			$matrikSelra = array(
				"SP3" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$date['start'], $date['end'], "SP3")),
				"RJ" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$date['start'], $date['end'], "RJ")),
				"TAHAPII" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$date['start'], $date['end'], "TAHAP II")),
				"BELUMDIKETAHUI" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$date['start'], $date['end'], " ")),
			);
	
			$data['title'] = "Data Selesai Perkara";
			$data['menuLink'] = "selra";
			$data['dataKasus'] = $matrikCCCT;
			$data['matrikSelra'] = $matrikSelra;
			$data['dataCC'] = $this->Modeldata->getSelraCC($this->kode_kesatuan,$date['start'], $date['end']);
			$data['dataCT'] = $this->Modeldata->getSelraCT($this->kode_kesatuan,$date['start'], $date['end']);
			$data['dateNow'] = $dateNow;
			$data['orderDate'] = false;
		}
		
		$data['btnExitSort'] = false;
		
		$this->load->view('include/header',$data);
		$this->load->view('v_selra',$data);
		$this->load->view('include/footer',$data);

	}
	
  public function viewSelraByDate(){
		$nama_kesatuan = $this->input->post('kode_kesatuan');
		$tanggalAwal = $this->input->post('tanggalAwal');
		$tanggalAkhir = $this->input->post('tanggalAkhir');
		$firstDate = '';
		$lastDate = '';
		
		if (empty($tanggalAwal) || empty($tanggalAkhir)) {
			$firstDate = $tanggalAwal;
			$lastDate = $tanggalAwal;

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate)));
		} else {
			$firstDate = $tanggalAwal;
			$lastDate = $tanggalAkhir;

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($lastDate)));	
		}

		if ($nama_kesatuan == 'all') {
			
			$addMatrikSelra = array();
			$kesatuan = $this->Modelkesatuan->getKesatuan();
			
			foreach ($kesatuan as $keyKesatuan) {
				$addMatrikSelra[$keyKesatuan['kode_kesatuan']] = array(
					"CT" => $this->Modeldata->getKSS($keyKesatuan['kode_kesatuan'],$firstDate, $lastDate),
					"CC" => array(
						"Total" =>  count($this->Modeldata->getSelraCC($keyKesatuan['kode_kesatuan'],$firstDate, $lastDate)),
						"SP3" => count($this->Modeldata->getMatrikSelra($keyKesatuan['kode_kesatuan'],$firstDate, $lastDate, "SP3")),
						"RJ" => count($this->Modeldata->getMatrikSelra($keyKesatuan['kode_kesatuan'],$firstDate, $lastDate, "RJ")),
						"TAHAPII" => count($this->Modeldata->getMatrikSelra($keyKesatuan['kode_kesatuan'],$firstDate, $lastDate, "TAHAP II")),	
					),
					"SEDANGPROSES" => count($this->Modeldata->getMatrikSelra($keyKesatuan['kode_kesatuan'],$firstDate, $lastDate, " ")),
					"PRESENTASE" => $this->persentaseSelra(count($this->Modeldata->getSelraCC($keyKesatuan['kode_kesatuan'],$firstDate, $lastDate)), $this->Modeldata->getKSS($keyKesatuan['kode_kesatuan'],$firstDate, $lastDate))
				);
			}
			
			$matrikSelra = array(
				$addMatrikSelra,
				"TOTAL" => array(
					"CT" => $this->Modeldata->getSuperKSS($firstDate, $lastDate),
					"CC" => array(
						"Total" =>  count($this->Modeldata->getSuperSelraCC($firstDate, $lastDate)),
						"SP3" => count($this->Modeldata->getTotalMatrikSelra($firstDate, $lastDate, "SP3")),
						"RJ" => count($this->Modeldata->getTotalMatrikSelra($firstDate, $lastDate, "RJ")),
						"TAHAPII" => count($this->Modeldata->getTotalMatrikSelra($firstDate, $lastDate, "TAHAP II")),	
					),
					"SEDANGPROSES" => count($this->Modeldata->getTotalMatrikSelra($firstDate, $lastDate, " ")),
					"PRESENTASE" => $this->persentaseSelra(count($this->Modeldata->getSuperSelraCC($firstDate, $lastDate)), $this->Modeldata->getSuperKSS($firstDate, $lastDate))
				)
			);
	
			$data['title'] = "Data Selesai Perkara";
			$data['menuLink'] = "selra";
			$data['matrikSelra'] = $matrikSelra;
			$data['totalMatrikSelra'] = $matrikSelra['TOTAL'];
			$data['dataCC'] = $this->Modeldata->getSuperSelraCC($firstDate, $lastDate);
			$data['dataCT'] = $this->Modeldata->getSuperSelraCT($firstDate, $lastDate);
			$data['dateNow'] = $dateNow;
			$data['orderDate'] = false;

		} else {

			if ($this->kode_kesatuan == 'ADMINSUPER') {
				$addMatrikSelra[$nama_kesatuan] = array(
					"CT" => $this->Modeldata->getKSS($nama_kesatuan,$firstDate, $lastDate),
					"CC" => array(
						"Total" =>  count($this->Modeldata->getSelraCC($nama_kesatuan,$firstDate, $lastDate)),
						"SP3" => count($this->Modeldata->getMatrikSelra($nama_kesatuan,$firstDate, $lastDate, "SP3")),
						"RJ" => count($this->Modeldata->getMatrikSelra($nama_kesatuan,$firstDate, $lastDate, "RJ")),
						"TAHAPII" => count($this->Modeldata->getMatrikSelra($nama_kesatuan,$firstDate, $lastDate, "TAHAP II")),	
					),
					"SEDANGPROSES" => count($this->Modeldata->getMatrikSelra($nama_kesatuan,$firstDate, $lastDate, " ")),
					"PRESENTASE" => $this->persentaseSelra(count($this->Modeldata->getSelraCC($nama_kesatuan,$firstDate, $lastDate)), $this->Modeldata->getKSS($nama_kesatuan,$firstDate, $lastDate))
				);
				
				$matrikSelra = array(
					$addMatrikSelra,
					"TOTAL" => array(
						"CT" => count($this->Modeldata->getSuperKasus($firstDate, $lastDate)),
						"CC" => array(
							"Total" =>  count($this->Modeldata->getSuperSelraCC($firstDate, $lastDate)),
							"SP3" => count($this->Modeldata->getTotalMatrikSelra($firstDate, $lastDate, "SP3")),
							"RJ" => count($this->Modeldata->getTotalMatrikSelra($firstDate, $lastDate, "RJ")),
							"TAHAPII" => count($this->Modeldata->getTotalMatrikSelra($firstDate, $lastDate, "TAHAP II")),	
						),
						"SEDANGPROSES" => count($this->Modeldata->getTotalMatrikSelra($firstDate, $lastDate, " ")),
						"PRESENTASE" => $this->persentaseSelra(count($this->Modeldata->getSuperSelraCC($firstDate, $lastDate)), count($this->Modeldata->getSuperKasus($firstDate, $lastDate)))
					)
				);
		
				$data['title'] = "Data Selesai Perkara";
				$data['menuLink'] = "selra";
				$data['matrikSelra'] = $matrikSelra;
				$data['totalMatrikSelra'] = $matrikSelra['TOTAL'];
				$data['kesatuanChoosen'] = $nama_kesatuan;
				$data['dataCC'] = $this->Modeldata->getSelraCC($nama_kesatuan, $firstDate, $lastDate);
				$data['dataCT'] = $this->Modeldata->getSelraCT($nama_kesatuan, $firstDate, $lastDate);
				$data['dateNow'] = $dateNow;
				$data['orderDate'] = true;
	
			} else {
			
				$matrikCCCT = array(
					"CT" => $this->Modeldata->getKSS($this->kode_kesatuan,$firstDate, $lastDate),
					"CC" => array(
						"Total" =>  count($this->Modeldata->getSelraCC($this->kode_kesatuan,$firstDate, $lastDate)),
						"SP3" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$firstDate, $lastDate, "SP3")),
						"RJ" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$firstDate, $lastDate, "RJ")),
						"TAHAPII" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$firstDate, $lastDate, "TAHAP II")),	
					),
					"SEDANGPROSES" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$firstDate, $lastDate, " ")),
					"PRESENTASE" => $this->persentaseSelra(count($this->Modeldata->getSelraCC($this->kode_kesatuan,$firstDate, $lastDate)), $this->Modeldata->getKSS($this->kode_kesatuan,$firstDate, $lastDate))
				);
	
				$matrikSelra = array(
					"SP3" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$firstDate, $lastDate, "SP3")),
					"RJ" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$firstDate, $lastDate, "RJ")),
					"TAHAPII" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$firstDate, $lastDate, "TAHAP II")),
					"BELUMDIKETAHUI" => count($this->Modeldata->getMatrikSelra($this->kode_kesatuan,$firstDate, $lastDate, " ")),
				);
		
				$data['title'] = "Data Selesai Perkara";
				$data['menuLink'] = "selra";
				$data['dataKasus'] = $matrikCCCT;
				$data['matrikSelra'] = $matrikSelra;
				$data['dataCC'] = $this->Modeldata->getSelraCC($this->kode_kesatuan, $firstDate, $lastDate);
				$data['dataCT'] = $this->Modeldata->getSelraCT($this->kode_kesatuan, $firstDate, $lastDate);
				$data['dateNow'] = $dateNow;
				$data['orderDate'] = false;
	
			}

		}
		
		$data['btnExitSort'] = true;
		
		$this->load->view('include/header',$data);
		$this->load->view('v_selra',$data);
		$this->load->view('include/footer',$data);
		

	}


	// KASUS MENONJOL MODUL
  public function viewKasusMenonjol(){

		$date = $this->rangeMonth(date("Y-m-d", strtotime("-1 month")), date("Y-m-d", strtotime("+1 month")));
		$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($date['start']))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($date['end'])));

		if ($this->kode_kesatuan == 'ADMINSUPER') {
	
			$matrikKasusMenonjol = array(
				"BukanMenonjol" => count($this->Modeldata->getSuperMenonjol($date['start'], $date['end'], 0)),
				"Menonjol" => count($this->Modeldata->getSuperMenonjol($date['start'], $date['end'], 1)),
			);
			
			
			$addMatrikMenonjol = array();
			$kesatuan = $this->Modelkesatuan->getKesatuan();

			foreach ($kesatuan as $keyKesatuan) {
				$addMatrikMenonjol[$keyKesatuan['kode_kesatuan']] = array(
					"BukanMenonjol" => count($this->Modeldata->getMenonjol($keyKesatuan['kode_kesatuan'], $date['start'], $date['end'], 0)),
					"Menonjol" => count($this->Modeldata->getMenonjol($keyKesatuan['kode_kesatuan'], $date['start'], $date['end'], 1)),
				);
			}
			
			$matrikMenonjol = array(
				$addMatrikMenonjol,
				"TOTAL" => array(
					"BukanMenonjol" => count($this->Modeldata->getTotalMenonjol($date['start'], $date['end'], 0)),
					"Menonjol" => count($this->Modeldata->getTotalMenonjol($date['start'], $date['end'], 1)),
				),
			);

			$data['title'] = "Data Kasus Menonjol";
			$data['menuLink'] = "kasus-menonjol";
			$data['dateNow'] = $dateNow;
			$data['dataKasus'] = $matrikKasusMenonjol;
			$data['matrikMenonjol'] = $matrikMenonjol[0];
			$data['totalMatrikMenonjol'] = $matrikMenonjol['TOTAL'];
			$data['dataMenonjol'] = $this->Modeldata->getSuperMenonjol($date['start'], $date['end'], 1);
			$data['dataBukanMenonjol'] = $this->Modeldata->getSuperMenonjol($date['start'], $date['end'], 0);
			
		} else {
	
			$matrikKasusMenonjol = array(
				"BukanMenonjol" => count($this->Modeldata->getMenonjol($this->kode_kesatuan, $date['start'], $date['end'], 0)),
				"Menonjol" => count($this->Modeldata->getMenonjol($this->kode_kesatuan, $date['start'], $date['end'], 1)),
			);

			$data['title'] = "Data Kasus Menonjol";
			$data['menuLink'] = "kasus-menonjol";
			$data['dateNow'] = $dateNow;
			$data['dataKasus'] = $matrikKasusMenonjol;
			$data['dataMenonjol'] = $this->Modeldata->getMenonjol($this->kode_kesatuan, $date['start'], $date['end'], 1);
			$data['dataBukanMenonjol'] = $this->Modeldata->getMenonjol($this->kode_kesatuan, $date['start'], $date['end'], 0);

		}
		
		$data['btnExitSort'] = false;
		
		$this->load->view('include/header',$data);
		$this->load->view('v_kasusmenonjol',$data);
		$this->load->view('include/footer',$data);

	}
	
  public function viewKasusMenonjolByDate(){
		$nama_kesatuan = $this->input->post('kode_kesatuan');
		$tanggalAwal = $this->input->post('tanggalAwal');
		$tanggalAkhir = $this->input->post('tanggalAkhir');
		$firstDate = '';
		$lastDate = '';
		
		if (empty($tanggalAwal) || empty($tanggalAkhir)) {
			$firstDate = $tanggalAwal;
			$lastDate = $tanggalAwal;

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate)));
		} else {
			$firstDate = $tanggalAwal;
			$lastDate = $tanggalAkhir;

			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($firstDate))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($lastDate)));	
		}

		if ($nama_kesatuan == 'all') {
			
			$matrikKasusMenonjol = array(
				"BukanMenonjol" => count($this->Modeldata->getSuperMenonjol($firstDate, $lastDate, 0)),
				"Menonjol" => count($this->Modeldata->getSuperMenonjol($firstDate, $lastDate, 1)),
			);
			
			$addMatrikMenonjol = array();
			$kesatuan = $this->Modelkesatuan->getKesatuan();

			foreach ($kesatuan as $keyKesatuan) {
				$addMatrikMenonjol[$keyKesatuan['kode_kesatuan']] = array(
					"BukanMenonjol" => count($this->Modeldata->getMenonjol($keyKesatuan['kode_kesatuan'], $firstDate, $lastDate, 0)),
					"Menonjol" => count($this->Modeldata->getMenonjol($keyKesatuan['kode_kesatuan'], $firstDate, $lastDate, 1)),
				);
			}
			
			$matrikMenonjol = array(
				$addMatrikMenonjol,
				"TOTAL" => array(
					"BukanMenonjol" => count($this->Modeldata->getTotalMenonjol($firstDate, $lastDate, 0)),
					"Menonjol" => count($this->Modeldata->getTotalMenonjol($firstDate, $lastDate, 1)),
				),
			);

			$data['title'] = "Data Kasus Menonjol";
			$data['menuLink'] = "kasus-menonjol";
			$data['dateNow'] = $dateNow;
			$data['dataKasus'] = $matrikKasusMenonjol;
			$data['matrikMenonjol'] = $matrikMenonjol[0];
			$data['totalMatrikMenonjol'] = $matrikMenonjol['TOTAL'];
			$data['dataMenonjol'] = $this->Modeldata->getSuperMenonjol($firstDate, $lastDate, 1);
			$data['dataBukanMenonjol'] = $this->Modeldata->getSuperMenonjol($firstDate, $lastDate, 0);

		} else {

			if ($this->kode_kesatuan == 'ADMINSUPER') {
				
				$matrikKasusMenonjol = array(
					"BukanMenonjol" => count($this->Modeldata->getMenonjol($nama_kesatuan, $firstDate, $lastDate, 0)),
					"Menonjol" => count($this->Modeldata->getMenonjol($nama_kesatuan, $firstDate, $lastDate, 1)),
				);
			
				$addMatrikMenonjol = array();
				$kesatuan = $this->Modelkesatuan->getKesatuan();
	
				foreach ($kesatuan as $keyKesatuan) {
					$addMatrikMenonjol[$nama_kesatuan] = array(
						"BukanMenonjol" => count($this->Modeldata->getMenonjol($nama_kesatuan, $firstDate, $lastDate, 0)),
						"Menonjol" => count($this->Modeldata->getMenonjol($nama_kesatuan, $firstDate, $lastDate, 1)),
					);
				}
				
				$matrikMenonjol = array(
					$addMatrikMenonjol,
					"TOTAL" => array(
						"BukanMenonjol" => count($this->Modeldata->getTotalMenonjol($firstDate, $lastDate, 0)),
						"Menonjol" => count($this->Modeldata->getTotalMenonjol($firstDate, $lastDate, 1)),
					),
				);

				$data['title'] = "Data Kasus Menonjol";
				$data['menuLink'] = "kasus-menonjol";
				$data['dateNow'] = $dateNow;
				$data['dataKasus'] = $matrikKasusMenonjol;
				$data['matrikMenonjol'] = $matrikMenonjol[0];
				$data['totalMatrikMenonjol'] = $matrikMenonjol['TOTAL'];
				$data['dataMenonjol'] = $this->Modeldata->getMenonjol($nama_kesatuan, $firstDate, $lastDate, 1);
				$data['dataBukanMenonjol'] = $this->Modeldata->getMenonjol($nama_kesatuan, $firstDate, $lastDate, 0);
				$data['orderDate'] = true;
	
			} else {
				
				$matrikKasusMenonjol = array(
					"BukanMenonjol" => count($this->Modeldata->getMenonjol($this->kode_kesatuan, $firstDate, $lastDate, 0)),
					"Menonjol" => count($this->Modeldata->getMenonjol($this->kode_kesatuan, $firstDate, $lastDate, 1)),
				);

				$data['title'] = "Data Kasus Menonjol";
				$data['menuLink'] = "kasus-menonjol";
				$data['dateNow'] = $dateNow;
				$data['dataKasus'] = $matrikKasusMenonjol;
				$data['dataMenonjol'] = $this->Modeldata->getMenonjol($this->kode_kesatuan, $firstDate, $lastDate, 1);
				$data['dataBukanMenonjol'] = $this->Modeldata->getMenonjol($this->kode_kesatuan, $firstDate, $lastDate, 0);

			}

		}
		
		$data['btnExitSort'] = true;
		
		$this->load->view('include/header',$data);
		$this->load->view('v_kasusmenonjol',$data);
		$this->load->view('include/footer',$data);

	}


	// IDENTITAS TERSANGKA
	public function viewTersangka(){
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$res = $this->Modeltersangka->getSuperTersangkaByKodeKesatuan();
		} else {
			$res = $this->Modeltersangka->getTersangkaByKodeKesatuan($this->kode_kesatuan);	
		}
		

		$data['title'] = "Master File Identitas Tersangka";
		$data['menuLink'] = "master-tersangka";
		$data['dataKasus'] = $res;

		$this->load->view('include/header',$data);
		$this->load->view('v_data_tersangka',$data);
		$this->load->view('include/footer',$data);
	}
	
	public function uploadFoto($id_tersangka){
		$time = time();
		$file_name = $_FILES['file'];
		
		// Move uploaded file to a temp location
		$uploadDir = $_SERVER['DOCUMENT_ROOT'].'/si-lapor/uploads/fotoTersangka/';
		$uploadFile = $uploadDir . $time . " - " . basename($_FILES['file']['name']);
		
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)){
			$namafile = [
				'file_foto' => $time. " - " .$file_name['name'],
			];
			$this->Modeltersangka->uploadFoto($id_tersangka, $namafile);
			$this->session->set_flashdata('success', 'Foto Tersangka berhasil diupload!');
		}else{
			echo "Possible file upload attack!\n";
      $this->session->set_flashdata('error', 'Foto gagal diupload!');
		}
		
		redirect(base_url("master-tersangka"));
	}


	// Date Modul
	function rangeMonth($dateBefore, $dateAfter) {
		date_default_timezone_set (date_default_timezone_get());
		$dtBefore = strtotime ($dateBefore);
		$dtAfter = strtotime ($dateAfter);
		return array (
			"start" => date ('Y-m-d', strtotime ('first day of this month', $dtBefore)),
			"end" => date ('Y-m-d', strtotime ('last day of this month', $dtAfter))
		);
	}

	function dateIndonesia($waktu_lengkap){
		$nama_hari = array(
			1 => 'Senin',
			2 => 'Selasa',
			3 => 'Rabu',
			4 => 'Kamis',
			5 => 'Jumat',
			6 => 'Sabtu',
			7 => 'Minggu',
		);
		$nama_bulan = array(
			1 =>  'Januari',
			2 =>  'Februari',
			3 =>  'Maret',
			4 =>  'April',
			5 =>  'Mei',
			6 =>  'Juni',
			7 =>  'Juli',
			8 =>  'Agustus',
			9 =>  'September',
			10 =>  'Oktober',
			11 =>  'November',
			12 =>  'Desember',
		);

		$pisah_waktu = explode(" ",$waktu_lengkap);
		$hari = $pisah_waktu[0];
		$tanggal = $pisah_waktu[1];

		$hari_baru = $nama_hari[$hari];

		$pisah_tanggal = explode("/",$tanggal);
		$tanggal_baru = $pisah_tanggal[0]." ".$nama_bulan[$pisah_tanggal[1]]." ".$pisah_tanggal[2];

		return $hari_baru.", ".$tanggal_baru;
	}

	function persentaseSelra($total_cc, $total_ct){
		if ($total_cc == 0) {
			return '0%';
		} else {
			$percent = ($total_cc / $total_ct) * 100;
			return round($percent).'%';
		}
	}
}

