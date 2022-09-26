<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelimpahan extends CI_Controller {
	
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
		
		$this->load->model('Modeldata');
		$this->load->model('Modelpelimpahan');
		$this->load->model('Modeltersangka');
		$this->load->model('Modelbarangbukti');
	}
    
	public function viewKasusPelimpahan(){
		if ($this->kode_kesatuan == 'ADMINSUPER') {

			$date = $this->rangeMonth(date("Y-m-d", strtotime("-1 month")), date("Y-m-d", strtotime("+1 month")));
			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($date['start']))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($date['end'])));
			$res = $this->Modelpelimpahan->getSuperPelimpahan($date['start'], $date['end']);
	
			$data['title'] = "Data Kasus Pelimpahan";
			$data['menuLink'] = "kasus-pelimpahan";
			$data['dataKasus'] = $res;
			$data['dateNow'] = $dateNow;

		}else{

			$date = $this->rangeMonth(date("Y-m-d", strtotime("-1 month")), date("Y-m-d", strtotime("+1 month")));
			$dateNow = $this->dateIndonesia(date('N j/n/Y', strtotime($date['start']))).' - '.$this->dateIndonesia(date('N j/n/Y', strtotime($date['end'])));
			$res = $this->Modelpelimpahan->getKasusPelimpahanById($this->kode_kesatuan, $date['start'], $date['end']);
			$resPelimpahan = $this->Modelpelimpahan->getKasusPelimpahanByIdPelimpahan($this->kode_kesatuan, $date['start'], $date['end']);
	
			$data['title'] = "Data Kasus Pelimpahan";
			$data['menuLink'] = "kasus-pelimpahan";
			$data['dataKasus'] = $res;
			$data['dateNow'] = $dateNow;
			$data['dataKasusPelimpahan'] = $resPelimpahan;

		}
	
		$this->load->view('include/header',$data);
		$this->load->view('v_pelimpahan_masterkasus',$data);
		$this->load->view('include/footer',$data);
	}

	public function viewKasusPelimpahanByDate(){
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
			
			$res = $this->Modelpelimpahan->getSuperPelimpahan($firstDate, $lastDate);
	
			$data['title'] = "Data Kasus Pelimpahan";
			$data['menuLink'] = "kasus-pelimpahan";
			$data['dataKasus'] = $res;
			$data['dateNow'] = $dateNow;

		} else {
			
			$res = $this->Modelpelimpahan->getKasusPelimpahanById($this->kode_kesatuan, $firstDate, $lastDate);
			$resPelimpahan = $this->Modelpelimpahan->getKasusPelimpahanByIdPelimpahan($this->kode_kesatuan, $firstDate, $lastDate);

			$data['title'] = "Data Kasus Pelimpahan";
			$data['menuLink'] = "kasus-pelimpahan";
			$data['dataKasus'] = $res;
			$data['dataKasusPelimpahan'] = $resPelimpahan;
			$data['dateNow'] = $dateNow;

		}
		
		$this->load->view('include/header',$data);
		$this->load->view('v_pelimpahan_masterkasus',$data);
		$this->load->view('include/footer',$data);

	}

	public function viewKasusPelimpahanById($idKasus){

		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$res = $this->Modelpelimpahan->getByIdKasus($idKasus, $this->kode_kesatuan)->result_array()[0];
		if (!$res) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$data['title'] = "Data Kasus Pelimpahan";
		$data['menuLink'] = "kasus-pelimpahan";
		$data['dataKasus'] = $res;
		$data['dataTersangka'] = $this->Modelpelimpahan->getTersangkaByIdKasus($idKasus)->result_array();

		$this->load->view('include/header',$data);
		$this->load->view('v_pelimpahan_laporkasusbyid',$data);
		$this->load->view('include/footer',$data);
	}
	
	public function viewRiwayatPelimpahan(){
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$data['title'] = "Riwayat LP Kasus Pelimpahan";
		$data['menuLink'] = "riwayat-pelimpahan";
		$data['LPditerima'] = $this->Modelpelimpahan->getPelimpahanDiterima($this->kode_kesatuan);
		$data['LPdilimpahkan'] = $this->Modelpelimpahan->getPelimpahanDilimpahkan($this->kode_kesatuan);
		$data['dateNow'] = "All";


		$this->load->view('include/header',$data);
		$this->load->view('v_pelimpahan_riwayat',$data);
		$this->load->view('include/footer',$data);
	}
	
	public function viewRiwayatPelimpahanByDate(){
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

		$data['title'] = "Riwayat LP Kasus Pelimpahan";
		$data['menuLink'] = "riwayat-pelimpahan";
		$data['LPditerima'] = $this->Modelpelimpahan->getPelimpahanDiterima($this->kode_kesatuan);
		$data['LPdilimpahkan'] = $this->Modelpelimpahan->getPelimpahanDilimpahkan($this->kode_kesatuan);
		$data['dateNow'] = $dateNow;


		$this->load->view('include/header',$data);
		$this->load->view('v_pelimpahan_riwayat',$data);
		$this->load->view('include/footer',$data);
	}

	public function addKasusPelimpahan($idKasus){
		$fromIdKasus = $idKasus;
		$fromKodeKesatuan = $this->kode_kesatuan;
		$nama_polsek = strtoupper($this->input->post('nama_polsek'));
		$toKodeKesatuan = $_POST['kode_kesatuan'];
		// Get From Kasus
		$kasus = $this->Modelpelimpahan->getKasusById($idKasus);
		for ($i=0; $i < count($kasus); $i++) { 
			$fromKasus = array(
				"kode_kesatuan" => $toKodeKesatuan,
				"nama_polsek" => $nama_polsek,
				"no_laporanpolisi" => $kasus[$i]['no_laporanpolisi'],
				"pasal" => $kasus[$i]['pasal'],
				"deskripsi_waktudantkp" => $kasus[$i]['deskripsi_waktudantkp'],
				"ket" => $kasus[$i]['ket'],
				"tkp" => $kasus[$i]['tkp'],
				"status_kasus" => "",
				"ket_pelimpahan" => "diterima",
				"idkasus_pelimpahanDari" => $fromIdKasus,
				"kodekesatuan_pelimpahanDari" => $fromKodeKesatuan,
			);
		}

		// Add to Temporary Kasus
		$newIdKasus = $this->Modelpelimpahan->addKasusPelimpahan($fromKasus);
		
		$this->Modelpelimpahan->updateKetPelimpahan($idKasus, "dilimpahkan", $toKodeKesatuan, $nama_polsek, $newIdKasus);

		$TSK = $this->Modeltersangka->getTersangkaByIdKasus($idKasus)->result_array();
		$fromIdTSK = array();
		$idTSKPelimpahan = array();
		for ($i=0; $i < count($TSK); $i++) { 
			$newTSK = array(
				'id_kasus' => $newIdKasus,
				'nama' => $TSK[$i]['nama'],
				'ttl' => $TSK[$i]['ttl'],
				'alamat' => $TSK[$i]['alamat'],
				'nik' => $TSK[$i]['nik'],
				'agama' => $TSK[$i]['agama'],
				'status' => $TSK[$i]['status'],
				'status_kewarganegaraan' => $TSK[$i]['status_kewarganegaraan'],
				'jenis_kelamin' => $TSK[$i]['jenis_kelamin'],
				'kategori_usia' => $TSK[$i]['kategori_usia'],
				'usia' => $TSK[$i]['usia'],
				'pendidikan' => $TSK[$i]['pendidikan'],
				'pekerjaan' => $TSK[$i]['pekerjaan'],
				'file_foto' => $TSK[$i]['file_foto'],
			);

			// Add to Temporary Tersangka
			$newIdTSK = $this->Modelpelimpahan->addTSKPelimpahan($newTSK);

			// Get From BB
			$fromBB = $this->Modelbarangbukti->getBarangBuktiByIdTersangka($idKasus, $TSK[$i]['id_tersangka'])->result_array();
			for ($j=0; $j < count($fromBB) ; $j++) { 
				$newBB = array(
					'id_kasus' => $newIdKasus,
					'id_tersangka' =>$newIdTSK,
					'kategori' => $fromBB[$j]['kategori'],
					'nama_barangbukti' => $fromBB[$j]['nama_barangbukti'],
					'jumlah' => $fromBB[$j]['jumlah'],
					'berat' => $fromBB[$j]['berat'],
					'keterangan' => $fromBB[$j]['keterangan'],
					'satuan' => $fromBB[$j]['satuan'],
					'isDuplicate' => $fromBB[$j]['isDuplicate'],
					'id_duplicateTSK' => $fromBB[$j]['id_duplicateTSK'],
				);
				$this->Modelpelimpahan->addBBPelimpahan($newBB);
			}
		}
        
		$this->session->set_flashdata('success', 'Pelimpahan berhasil diproses!');
		return redirect(base_url() . 'riwayat-pelimpahan');
	}

	public function batalPelimpahan($idPelimpahan, $idFrom){
		$this->Modelpelimpahan->delPelimpahan($idPelimpahan);
		$this->Modelpelimpahan->updatePelimpahanFrom($idFrom);
        
		$this->session->set_flashdata('success', 'Pelimpahan berhasil dibatalkan!');
		return redirect(base_url() . 'kasus-pelimpahan');
	}

	public function updateStatusKasus($idKasus, $fromIdKasus){
		$status_kasus = $this->input->post('status_kasus');
		$ket_statusKasus = $this->input->post('ket_statusKasus');
		$date = date('Y-m-d');

		$this->Modelpelimpahan->updateStatusKasus($fromIdKasus,$status_kasus,$ket_statusKasus,$date);
		$this->Modelpelimpahan->updateStatusKasusPelimpahan($idKasus,$status_kasus);
		$this->session->set_flashdata('success', 'Status kasus pelimpahan berhasil diupdate ke database!');
		redirect(base_url("kasus-pelimpahan"));
	}

	public function updateAdmin($idKasus){
		$nrp = $this->input->post('nrp');
		$this->Modelpelimpahan->updateAdminKasus($nrp, $idKasus);
		$this->session->set_flashdata('success', 'Admin kasus berhasil diupdate ke database!');
		redirect(base_url("kasus-pelimpahan"));
	}

	public function updateKasus($idKasus){
		$kodekesatuan = $this->session->userdata('login_data_admin')['kodekesatuan'];
		$tkp = $this->input->post('tkp');
		$deskripsi_waktudantkp = $this->input->post('deskripsi_waktudantkp');
		$pasal = $this->input->post('pasal');

		$dataKasus = array(
			'id_kasus' => $idKasus,
			'kode_kesatuan' => $kodekesatuan,
			'pasal' => $pasal,
			'deskripsi_waktudantkp' => $deskripsi_waktudantkp,
			'ket' => null,
			'tkp' => $tkp,
			'status_kasus' => '',
			'ket_pelimpahan' => '',
		);

		$this->Modelpelimpahan->updateKasus($idKasus, $dataKasus, 'tb_temp_kasus');
		$this->session->set_flashdata('success', 'Update informasi kasus berhasil disimpan ke database!');
		redirect(base_url("kasus-pelimpahan/{$idKasus}"));	
	}
	
	public function updateKasusPelimpahanMenonjol($idKasus, $fromIdKasus){
		$this->Modelpelimpahan->updateKasusMenonjol($fromIdKasus);
		$this->Modelpelimpahan->updateKasusPelimpahanMenonjol($idKasus);
		$this->session->set_flashdata('success', 'Status kasus pelimpahan berhasil diupdate ke database!');
		redirect(base_url("kasus-pelimpahan"));
	}
	
	public function batalKasusPelimpahanMenonjol($idKasus, $fromIdKasus){
		$this->Modelpelimpahan->batalKasusMenonjol($fromIdKasus);
		$this->Modelpelimpahan->batalKasusPelimpahanMenonjol($idKasus);
		$this->session->set_flashdata('success', 'Status kasus pelimpahan berhasil diupdate ke database!');
		redirect(base_url("kasus-pelimpahan"));
	}

	public function viewTersangkaPelimpahan($idKasus){
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$res = $this->Modelpelimpahan->getByIdKasus($idKasus, $this->kode_kesatuan)->result_array()[0];
		if (!$res) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

        $data['title'] = "Data Tersangka Pelimpahan";
        $data['menuLink'] = "data-tersangka-pelimpahan";
		$data['dataKasus'] = $res;
		$data['dataTersangka'] = $this->Modelpelimpahan->getTersangkaByIdKasus($idKasus)->result_array();

		$this->load->view('include/header',$data);
		$this->load->view('v_pelimpahan_tersangka',$data);
		$this->load->view('include/footer',$data);
	}
	
	public function updateTersangka($idTersangka, $idKasus){
		$nama = $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$nik = $this->input->post('nik');
		$agama = $this->input->post('agama');
		$status = $this->input->post('status');
		$status_kewarganegaraan = $this->input->post('status_kewarganegaraan');
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		$kategori_usia = $this->input->post('kategori_usia');
		$usia = $this->input->post('usia');
		$pendidikan = $this->input->post('pendidikan');
		$pekerjaan = $this->input->post('pekerjaan');

		$dataTersangka = array(
			'id_kasus' => $idKasus,
			'nama' => $nama,
			'alamat' => $alamat,
			'nik' => $nik,
			'agama' => $agama,
			'status' => $status,
			'status_kewarganegaraan' => $status_kewarganegaraan,
			'jenis_kelamin' => $jenis_kelamin,
			'kategori_usia' => $kategori_usia,
			'usia' => $usia,
			'pendidikan' => $pendidikan,
			'pekerjaan' => $pekerjaan,
		);

		$this->Modelpelimpahan->updateTersangka($idTersangka,$dataTersangka);

		$this->session->set_flashdata('success', 'Informasi tersangka berhasil diupdate ke database!');
		redirect(base_url("kasus-pelimpahan/{$idKasus}"));
	}
	
	public function addTersangka($idKasus){
		$nama = $this->input->post('nama');
		$alamat = $this->input->post('alamat');
		$nik = $this->input->post('nik');
		$agama = $this->input->post('agama');
		$status = $this->input->post('status');
		$status_kewarganegaraan = $this->input->post('status_kewarganegaraan');
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		$kategori_usia = $this->input->post('kategori_usia');
		$usia = $this->input->post('usia');
		$pendidikan = $this->input->post('pendidikan');
		$pekerjaan = $this->input->post('pekerjaan');

		$dataTersangka = array(
			'id_kasus' => $idKasus,
			'nama' => $nama,
			'alamat' => $alamat,
			'nik' => $nik,
			'agama' => $agama,
			'status' => $status,
			'status_kewarganegaraan' => $status_kewarganegaraan,
			'jenis_kelamin' => $jenis_kelamin,
			'kategori_usia' => $kategori_usia,
			'usia' => $usia,
			'pendidikan' => $pendidikan,
			'pekerjaan' => $pekerjaan,
		);

		$this->Modelpelimpahan->addTersangka($dataTersangka, 'tb_temp_tersangka');

		$this->session->set_flashdata('success', 'Informasi tersangka berhasil disimpan ke database!');
		redirect(base_url("kasus-pelimpahan/{$idKasus}"));
	}

	public function delTersangka($idTersangka, $idKasus){
		$this->Modelpelimpahan->delTersangka($idTersangka);
		$this->session->set_flashdata('success', 'Informasi tersangka berhasil dihapus dari database!');
		redirect(base_url("kasus-pelimpahan/{$idKasus}"));
	}

	public function getBBDuplicate(){
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}
		$id_tersangka = $_POST['id_tersangka'];
		$id_kasus = $_POST['id_kasus'];
		$option = '';

		$res = $this->Modelpelimpahan->getBarangBuktiByIdTersangka($id_kasus, $id_tersangka)->result_array();
		if (!empty($res)) {
			foreach ($res as $key) {
				$option .= "<option value='{$key['kategori']}'>{$key['kategori']}</option>";
			}
		}else{
			$option .= '';
		}
		
		$output = "<select name='kategori' class='form-control formKategori'><option selected disabled>Pilih Barang Bukti</option>{$option}</select>";
		echo $output;
	}
	
	public function viewBarangBukti($idKasus, $idTersangka){
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$res = $this->Modelpelimpahan->getByIdKasus($idKasus, $this->kode_kesatuan)->result_array()[0];
		if (!$res) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$res_tsk = $this->Modelpelimpahan->getTersangkaByIdTersangka($idKasus, $idTersangka)->result_array()[0];
		if (!$res_tsk) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

        $data['title'] = "Data Barang Bukti Pelimpahan";
        $data['menuLink'] = "barang-bukti-pelimpahan";
		$data['dataKasus'] = $res;
		$data['dataTersangka'] = $res_tsk;
		$data['dataBarangBukti'] = $this->Modelpelimpahan->getBarangBuktiByIdTersangka($idKasus, $idTersangka)->result_array();

		$this->load->view('include/header',$data);
		$this->load->view('v_pelimpahan_barangbukti',$data);
		$this->load->view('include/footer',$data);
	}

	public function addBBDuplicate($id_kasus, $idTersangka){
		$id_tersangkarujukan = $this->input->post('id_tersangka');
		$kategori = $this->input->post('kategori');
		
		if (!$kategori) {
			$this->session->set_flashdata('error', 'Barang Bukti Harus Diisi');
			redirect(base_url("kasus-pelimpahan/{$id_kasus}"));
		}
		
		$dataBarangBukti = array(
			'id_kasus' => $id_kasus,
			'id_tersangka' => $idTersangka,
			'kategori' => $kategori,
			'isDuplicate' => 1,
			'id_duplicateTSK' => $id_tersangkarujukan,
		);
		$this->Modelpelimpahan->addBarangBukti($dataBarangBukti, 'tb_temp_barangbukti');

		$this->session->set_flashdata('success', 'Informasi barang bukti kasus berhasil disimpan ke database!');
		redirect(base_url("kasus-pelimpahan/{$id_kasus}"));
	}
	
	public function delBBDuplicate($idBarangBukti, $idKasus){
		$this->Modelpelimpahan->delBarangBukti($idBarangBukti);
		$this->session->set_flashdata('success', 'Pembatalan berhasil!');
		redirect(base_url("kasus-pelimpahan/{$idKasus}"));
	}
	
	public function addBarangBukti($idKasus){
		$id_tersangka = $this->input->post('id_tersangka');
		$kategori = $this->input->post('kategori');
		$nama_barangbukti = $this->input->post('nama_barangbukti');
		$jumlah = (float)$this->input->post('jumlah');
		$berat = (float)$this->input->post('berat');
		$keterangan = $this->input->post('keterangan');
		$satuan = $this->input->post('satuan');
		$satuanGanja = $this->input->post('satuanGanja');
		$satuanEkstasi = $this->input->post('satuanEkstasi');

		if ($satuanGanja) {
			if ($satuanGanja == 'batang') {
				$kategori = 'Lain-lain';
				$satuan = $satuanGanja;
			}else{
				$satuan = $satuanGanja;
			}		
		}

		if ($satuanEkstasi) {
			if ($satuanEkstasi == 'gram') {
				$kategori = 'Lain-lain';
				$satuan = $satuanEkstasi;
			}else{
				$satuan = $satuanEkstasi;
			}		
		}

		$dataBarangBukti = array(
			'id_kasus' => $idKasus,
			'id_tersangka' => $id_tersangka,
			'kategori' => $kategori,
			'nama_barangbukti' => $nama_barangbukti,
			'keterangan' => $keterangan,
			'jumlah' => $jumlah,
			'berat' => $berat,
			'satuan' => $satuan,
			'isDuplicate' => 0,
		);


		$this->Modelpelimpahan->addBarangBukti($dataBarangBukti, 'tb_temp_barangbukti');

		$this->session->set_flashdata('success', 'Informasi barang bukti kasus berhasil disimpan ke database!');
		redirect(base_url("barang-bukti-pelimpahan/{$idKasus}/{$id_tersangka}"));
	}
	
	public function delBarangBukti($idBarangBukti, $idKasus, $idTersangka){
		$this->Modelpelimpahan->delBarangBukti($idBarangBukti);
		$this->session->set_flashdata('success', 'Informasi barang bukti berhasil dihapus dari database!');
		redirect(base_url("barang-bukti-pelimpahan/{$idKasus}/{$idTersangka}"));
	}
	
	public function viewFinalisasiData($idKasus){
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}
		
		$res = $this->Modelpelimpahan->getByIdKasus($idKasus, $this->kode_kesatuan)->result_array()[0];
		if (!$res) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

        $data['title'] = "Finalisasi Data";
        $data['menuLink'] = "kasus-pelimpahan";
		$data['dataKasus'] = $res;
		$data['dataTersangka'] = $this->Modelpelimpahan->getTersangkaByIdKasus($idKasus)->result_array();
		$data['dataBarangBukti'] = $this->Modelpelimpahan->getBarangBuktiByIdKasus($idKasus)->result_array();

		$this->load->view('include/header',$data);
		$this->load->view('v_pelimpahan_finalisasidata',$data);
		$this->load->view('include/footer',$data);
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
}