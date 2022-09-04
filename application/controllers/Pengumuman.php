<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman extends CI_Controller {
	
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

		$this->load->model('Modelpengumuman');
    $this->load->model('Modelkesatuan');
	}

	public function index(){
    if ($this->kode_kesatuan == 'ADMINSUPER') {
      $res = $this->Modelpengumuman->getAllPengumuman();

      $data['title'] = "Management Pengumuman";
      $data['menuLink'] = "pengumuman";
      $data['dataPengumuman'] = $res;
  
    }else{
      $res = $this->Modelpengumuman->getPengumumanByKodeKesatuan($this->kode_kesatuan);

      $data['title'] = "Pengumuman";
      $data['menuLink'] = "pengumuman";
      $data['dataPengumuman'] = $res;
    }
    $this->load->view('include/header', $data);
    $this->load->view('v_pengumuman', $data);
    $this->load->view('include/footer', $data);
	}

  public function addPengumuman(){
		$judul = $this->input->post('judul');
		$deskripsi = $this->input->post('deskripsi');
		$file_name = $_FILES['nama_file'];
		$time = time();

    if (!empty($file_name['name'])) {
      
      // Move uploaded file to a temp location
      $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/si-lapor/uploads/filePengumuman/';
      $uploadFile = $uploadDir . $time . " - " . basename($_FILES['nama_file']['name']);
      move_uploaded_file($_FILES['nama_file']['tmp_name'], $uploadFile);
      
    }

    $dataPengumuman = array(
      'judul' => $judul,
      'deskripsi' => $deskripsi,
      'nama_file' => ($file_name['name']) ? $time. " - " .$file_name['name'] : ''
    );

    // Add to Tabel Pengumuman
    $idPengumuman = $this->Modelpengumuman->addPengumuman($dataPengumuman);

    // Add to Tabel Pengumuan Tujuan
    $kesatuan = $this->Modelkesatuan->getKesatuan();
    $dataPengumumanTujuan = array();
    for ($i=0; $i < sizeof($kesatuan); $i++) { 
      array_push($dataPengumumanTujuan, array(
        'id_pengumuman' => $idPengumuman,
        'kode_kesatuan' => $kesatuan[$i]['kode_kesatuan'],
      ));
    }

    $this->db->insert_batch('tb_pengumuman_tujuan', $dataPengumumanTujuan);
  
    $this->session->set_flashdata('success', 'Pengumuman berhasil dipublish!');
    redirect(base_url().'pengumuman');
  }
  
	public function downloadFile($idPengumuman){
    $res = $this->Modelpengumuman->getPengumuman($idPengumuman);

    $namaFile = $res[0]['nama_file'];
    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/si-lapor/uploads/filePengumuman/';
    $uploadFile = $uploadDir . $namaFile;

    force_download($uploadFile, NULL);
  }
  
	public function delPengumuman($idPengumuman){
    $res = $this->Modelpengumuman->getPengumuman($idPengumuman);

    $namaFile = $res[0]['nama_file'];
    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/si-lapor/uploads/filePengumuman/';
    $uploadFile = $uploadDir . $namaFile;
      
    $this->Modelpengumuman->delPengumuman($idPengumuman);
        
    unlink($uploadFile);
    
    $this->session->set_flashdata('success', 'Pengumuman berhasil dihapus dari database!');
    redirect(base_url("pengumuman"));
  }
  
	public function delPengumumanTujuan($idPengumuman){
      
    $this->Modelpengumuman->delPengumumanTujuan($idPengumuman);
    
    $this->session->set_flashdata('success', 'Pengumuman berhasil dihapus dari database!');
    redirect(base_url("pengumuman"));
  }
  
	public function countPengumuman(){
    $this->Modelpengumuman->countPengumuman($this->kode_kesatuan);
  }

	public function bacaPengumuman($idPengumuman){
    $this->Modelpengumuman->bacaPengumuman($idPengumuman);

    $this->session->set_flashdata('success', 'Pengumuman berhasil dibaca!');
    redirect(base_url("pengumuman"));
  }
}
