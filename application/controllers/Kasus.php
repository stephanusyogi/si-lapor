<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasus extends CI_Controller {
	
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
		$this->load->model('Modeltersangka');
		$this->load->model('Modelbarangbukti');
	}

	// LAPOR KASUS MODUL
	public function viewLaporKasus(){
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

        $data['title'] = "Lapor Ungkap Kasus";
        $data['menuLink'] = "lapor-ungkap-kasus";

		$this->load->view('include/header',$data);
		$this->load->view('v_kasus_laporkasus',$data);
		$this->load->view('include/footer',$data);
	}
	
	public function viewLaporKasusById($idKasus){
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$res = $this->Modelkasus->getByIdKasus($idKasus, $this->kode_kesatuan)->result_array()[0];

		if (!$res) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		if ($res['isLocked']) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$data['title'] = "Lapor Ungkap Kasus";
		$data['menuLink'] = "lapor-ungkap-kasus";
		$data['dataKasus'] = $res;

		$this->load->view('include/header',$data);
		$this->load->view('v_kasus_laporkasusbyid',$data);
		$this->load->view('include/footer',$data);
	}

	public function addKasus(){
		$kesatuan = $this->input->post('kesatuan');
		$nosurat = $this->input->post('nosurat');
		$bulansurat = $this->input->post('bulansurat');
		$tahunsurat = $this->input->post('tahunsurat');
		$namapolsek = strtoupper($this->input->post('namapolsek'));
		$kode_lp = $this->session->userdata('login_data_admin')['kode_lp'];
		$namasatuan = $this->session->userdata('login_data_admin')['nama'];
		$kodekesatuan = $this->session->userdata('login_data_admin')['kodekesatuan'];
		$nrp_admin = $this->session->userdata('login_data_admin')['nrp_admin'];

		if ($kesatuan == 'polres') {
			$noLP = "LP/A/{$nosurat}/{$bulansurat}/{$tahunsurat}/SPKT.{$kode_lp}/POLDA JAWA TIMUR";
		} else {
			$noLP = "LP/A/{$nosurat}/{$bulansurat}/{$tahunsurat}/SPKT/{$namapolsek}/{$namasatuan}/POLDA JAWA TIMUR";
		}

		$tkp = $this->input->post('tkp');
		$deskripsi_waktudantkp = $this->input->post('deskripsi_waktudantkp');
		$pasal = $this->input->post('pasal');

		$dataKasus = array(
			'kode_kesatuan' => $kodekesatuan,
			'no_laporanpolisi' => $noLP,
			'pasal' => $pasal,
			'deskripsi_waktudantkp' => $deskripsi_waktudantkp,
			'ket' => null,
			'tkp' => $tkp,
			'status_kasus' => '',
			'nrp_admin' => $nrp_admin,
			'ket_pelimpahan' => 0,
		);

		$checkDuplicate = $this->Modelkasus->checkNomorSuratDuplikat($noLP)->result_array();

		if(!empty($checkDuplicate)){
			$this->session->set_flashdata('error', 'Nomor Laporan Polisi telah digunakan. Mohon periksa kembali!');
			redirect(base_url('lapor-ungkap-kasus'));	
		}

		$this->Modelkasus->addKasus($dataKasus, 'tb_kasus');
		$idKasusDatabase = $this->Modelkasus->checkNomorSuratDuplikat($noLP)->result_array();

		$this->session->set_flashdata('success', 'Informasi kasus berhasil disimpan ke database!');
		redirect(base_url("data-tersangka/{$idKasusDatabase[0]['id_kasus']}"));
	}

	public function updateKasus($idKasus){
		$kesatuan = $this->input->post('kesatuan');
		$nosurat = $this->input->post('nosurat');
		$bulansurat = $this->input->post('bulansurat');
		$tahunsurat = $this->input->post('tahunsurat');
		$namapolsek = strtoupper($this->input->post('namapolsek'));
		$kode_lp = $this->session->userdata('login_data_admin')['kode_lp'];
		$namasatuan = $this->session->userdata('login_data_admin')['nama'];
		$kodekesatuan = $this->session->userdata('login_data_admin')['kodekesatuan'];

		if ($kesatuan == 'polres') {
			$noLP = "LP/A/{$nosurat}/{$bulansurat}/{$tahunsurat}/SPKT.{$kode_lp}/POLDA JAWA TIMUR";
		} else {
			$noLP = "LP/A/{$nosurat}/{$bulansurat}/{$tahunsurat}/SPKT/{$namapolsek}/{$namasatuan}/POLDA JAWA TIMUR";
		}

		$tkp = $this->input->post('tkp');
		$deskripsi_waktudantkp = $this->input->post('deskripsi_waktudantkp');
		$pasal = $this->input->post('pasal');

		$dataKasus = array(
			'id_kasus' => $idKasus,
			'kode_kesatuan' => $kodekesatuan,
			'no_laporanpolisi' => $noLP,
			'pasal' => $pasal,
			'deskripsi_waktudantkp' => $deskripsi_waktudantkp,
			'ket' => null,
			'tkp' => $tkp,
			'status_kasus' => '',
			'ket_pelimpahan' => 0,
		);

		$this->Modelkasus->updateKasus($idKasus, $dataKasus, 'tb_kasus');
		
		$this->session->set_flashdata('success', 'Update informasi kasus berhasil disimpan ke database!');
		redirect(base_url("data-tersangka/{$idKasus}"));	
	}

	// DATA TERSANGKA MODUL
	public function viewTersangka($idKasus){

		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$res = $this->Modelkasus->getByIdKasus($idKasus, $this->kode_kesatuan)->result_array()[0];

		if (!$res) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}
		
		if ($res['isLocked']) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$data['title'] = "Data Tersangka";
		$data['menuLink'] = "lapor-ungkap-kasus";
		$data['dataKasus'] = $res;
		$data['dataTersangka'] = $this->Modeltersangka->getTersangkaByIdKasus($idKasus)->result_array();

		$this->load->view('include/header',$data);
		$this->load->view('v_kasus_tersangka',$data);
		$this->load->view('include/footer',$data);
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

		$this->Modeltersangka->addTersangka($dataTersangka, 'tb_tersangka');

		$this->session->set_flashdata('success', 'Informasi tersangka berhasil disimpan ke database!');
		redirect(base_url("data-tersangka/{$idKasus}"));
	}

	public function delTersangka($idTersangka, $idKasus){
		$this->Modeltersangka->delTersangka($idTersangka);
		$this->session->set_flashdata('success', 'Informasi tersangka berhasil dihapus dari database!');
		redirect(base_url("data-tersangka/{$idKasus}"));
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

		$this->Modeltersangka->updateTersangka($idTersangka,$dataTersangka);

		$this->session->set_flashdata('success', 'Informasi tersangka berhasil diupdate ke database!');
		redirect(base_url("data-tersangka/{$idKasus}"));
	}

	// BARANG BUKTI MODUL
	public function viewBarangBukti($idKasus, $idTersangka){
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$res = $this->Modelkasus->getByIdKasus($idKasus, $this->kode_kesatuan)->result_array()[0];

		if (!$res) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}
		
		if ($res['isLocked']) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$res_tsk = $this->Modeltersangka->getTersangkaByIdTersangka($idKasus, $idTersangka)->result_array()[0];
		if (!$res_tsk) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$data['title'] = "Data Barang Bukti";
		$data['menuLink'] = "lapor-ungkap-kasus";
		$data['dataKasus'] = $res;
		$data['dataTersangka'] = $res_tsk;
		$data['dataBarangBukti'] = $this->Modelbarangbukti->getBarangBuktiByIdTersangka($idKasus, $idTersangka)->result_array();

		$this->load->view('include/header',$data);
		$this->load->view('v_kasus_barangbukti',$data);
		$this->load->view('include/footer',$data);
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

		$this->Modelbarangbukti->addBarangBukti($dataBarangBukti, 'tb_barangbukti');

		$this->session->set_flashdata('success', 'Informasi barang bukti kasus berhasil disimpan ke database!');
		redirect(base_url("barang-bukti/{$idKasus}/{$id_tersangka}"));
	}
	
	public function delBarangBukti($idBarangBukti, $idKasus, $idTersangka){
		$this->Modelbarangbukti->delBarangBukti($idBarangBukti);
		$this->session->set_flashdata('success', 'Informasi barang bukti berhasil dihapus dari database!');
		redirect(base_url("barang-bukti/{$idKasus}/{$idTersangka}"));
	}

	public function getBBDuplicate(){

		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$id_tersangka = $_POST['id_tersangka'];
		$id_kasus = $_POST['id_kasus'];
		$option = '';

		$res = $this->Modelbarangbukti->getBarangBuktiByIdTersangka($id_kasus, $id_tersangka)->result_array();
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

	public function addBBDuplicate($id_kasus, $idTersangka){
		$id_tersangkarujukan = $this->input->post('id_tersangka');
		$kategori = $this->input->post('kategori');
		
		if (!$kategori) {
			$this->session->set_flashdata('error', 'Barang Bukti Harus Diisi');
			redirect(base_url("data-tersangka/{$id_kasus}"));
		}
		
		$dataBarangBukti = array(
			'id_kasus' => $id_kasus,
			'id_tersangka' => $idTersangka,
			'kategori' => $kategori,
			'isDuplicate' => 1,
			'id_duplicateTSK' => $id_tersangkarujukan,
		);
		$this->Modelbarangbukti->addBarangBukti($dataBarangBukti, 'tb_barangbukti');

		$this->session->set_flashdata('success', 'Informasi barang bukti kasus berhasil disimpan ke database!');
		redirect(base_url("data-tersangka/{$id_kasus}"));
	}

	// FINALISASI DATA MODUL
	public function viewFinalisasiData($idKasus){
		
		if ($this->kode_kesatuan == 'ADMINSUPER') {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

		$res = $this->Modelkasus->getByIdKasus($idKasus, $this->kode_kesatuan)->result_array()[0];
		if (!$res) {
			$this->session->set_flashdata('error', 'Forbidden Accsess!');
			redirect(base_url('404_override'));
		}

        $data['title'] = "Finalisasi Data";
        $data['menuLink'] = "lapor-ungkap-kasus";
		$data['dataKasus'] = $res;
		$data['dataTersangka'] = $this->Modeltersangka->getTersangkaByIdKasus($idKasus)->result_array();
		$data['dataBarangBukti'] = $this->Modelbarangbukti->getBarangBuktiByIdKasus($idKasus)->result_array();

		$this->load->view('include/header',$data);
		$this->load->view('v_kasus_finalisasidata',$data);
		$this->load->view('include/footer',$data);
	}


}

