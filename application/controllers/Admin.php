<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
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

		$this->load->model('Modeladmin');
	}

	public function viewAdmin(){
		if($this->kode_kesatuan == 'ADMINSUPER'){

			$dataAdmin = $this->Modeladmin->getAdminBiasa();
			$dataSuperAdmin = $this->Modeladmin->getAdminByLevel('ADMINSUPER');
			$dataPrincipalAdmin = $this->Modeladmin->getAdminByLevel('PRINCIPAL');

			$kesatuan = $this->Modeladmin->getLevels();
			$historyAdmin = $this->Modeladmin->getHistoryAdmin();

			$data['title'] = "Management Administrator";
			$data['menuLink'] = "data-admin";
			$data['dataAdmin'] = $dataAdmin;
			$data['dataSuperAdmin'] = $dataSuperAdmin;
			$data['dataPrincipalAdmin'] = $dataPrincipalAdmin;
			$data['kesatuan'] = $kesatuan;
			$data['historyAdmin'] = $historyAdmin;

		}else{
			
			$dataAdmin = $this->Modeladmin->getAllAdmin($this->kode_kesatuan);
	
			$data['title'] = "Data Administrator - {$this->session->userdata('login_data_admin')['nama']}";
			$data['menuLink'] = "data-admin";
			$data['dataAdmin'] = $dataAdmin;

		}

		$this->load->view('include/header', $data);
		$this->load->view('v_admin', $data);
		$this->load->view('include/footer', $data);
	}

	public function editAdmin($idAdmin){
		$nama_admin = $this->input->post('nama_admin');
		$kode_kesatuan = $this->input->post('kode_kesatuan');
		$nrp = $this->input->post('nrp');
		$notelp = $this->input->post('notelp');
		$password = $this->input->post('password');
		$newPassword = '';

		$res = $this->Modeladmin->getAdminById($idAdmin);
		if ($password == null) {
			$newPassword = $res[0]['password'];
		} else {
			$newPassword = password_hash($password, PASSWORD_DEFAULT);
		}

		$dataAdmin = array(
			'kode_kesatuan' => $kode_kesatuan,
			'nama_admin' => $nama_admin,
			'nrp' => $nrp,
			'notelp' => $notelp,
			'password' => $newPassword,
		);

		$this->Modeladmin->updateAdmin($dataAdmin, $idAdmin);
		$this->session->set_flashdata('success', 'Admin berhasil diupdate!');
    redirect(base_url("data-admin"));

	}

	public function addAdmin(){
		$nama_admin = $this->input->post('nama_admin');
		$kode_kesatuan = $this->input->post('kode_kesatuan');
		$nrp = $this->input->post('nrp');
		$notelp = $this->input->post('notelp');
		$password = $this->input->post('password');

		$dataAdmin = array(
			'kode_kesatuan' => $kode_kesatuan,
			'nama_admin' => $nama_admin,
			'nrp' => $nrp,
			'notelp' => $notelp,
			'password' => password_hash($password, PASSWORD_DEFAULT),
		);

		$this->Modeladmin->addAdmin($dataAdmin);
		$this->session->set_flashdata('success', 'Admin berhasil ditambahkan ke database!');
    redirect(base_url("data-admin"));

	}
	
	public function delAdmin($idAdmin){
    $this->Modeladmin->delAdmin($idAdmin);
    $this->session->set_flashdata('success', 'Admin berhasil dihapus dari database!');
    redirect(base_url("data-admin"));
  }

	public function delHistory(){
    $this->Modeladmin->delHistory();
    $this->session->set_flashdata('success', 'History admin login berhasil dihapus dari database!');
    redirect(base_url("data-admin"));
  }
}
