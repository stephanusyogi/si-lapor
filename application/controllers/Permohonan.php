<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonan extends CI_Controller {
	
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

		$this->load->model('Modelpermohonan');
	}

	public function index(){
		if($this->kode_kesatuan == 'ADMINSUPER'){

			$dataPermohonan = $this->Modelpermohonan->getSuperPermohanan();

			$data['title'] = "Daftar Permohonan Perubahan";
			$data['menuLink'] = "daftar-permohonan-edit";
			$data['dataPermohonan'] = $dataPermohonan;

		}else{

			$dataPermohonan = $this->Modelpermohonan->getPermohonanByKesatuan($this->kode_kesatuan);

			$data['title'] = "Daftar Permohonan Perubahan";
			$data['menuLink'] = "daftar-permohonan-edit";
			$data['dataPermohonan'] = $dataPermohonan;

    }

		$this->load->view('include/header', $data);
		$this->load->view('v_permohonan_edit', $data);
		$this->load->view('include/footer', $data);
	}

	public function countPermohonan(){
		$this->Modelpermohonan->countPermohonan();
	}
	
	public function delPermohonan($idPermohonan){
		$this->Modelpermohonan->delPermohonan($idPermohonan);
		$this->session->set_flashdata('success', 'Permohonan perubahan berhasil dihapus dari database!');
		redirect(base_url("daftar-permohonan-edit"));
	}
  
	public function updatePermohonan($idPermohonan , $idKasus){
		$this->Modelpermohonan->updatePermohonan($idPermohonan, $idKasus);
		$this->session->set_flashdata('success', 'Permohonan berhasil diupdate!');
		redirect(base_url("daftar-permohonan-edit"));
	}
}
