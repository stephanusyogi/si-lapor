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
		$dataAdmin = $this->Modeladmin->getAllAdmin($this->kode_kesatuan);

		$data['title'] = "Data Administrator - {$this->session->userdata('login_data_admin')['nama']}";
		$data['menuLink'] = "data-admin";
		$data['dataAdmin'] = $dataAdmin;

		$this->load->view('include/header', $data);
		$this->load->view('v_admin', $data);
		$this->load->view('include/footer', $data);
	}
}
