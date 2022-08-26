<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
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
		$this->load->model('Modelkasus');
		$this->load->model('Modeldata');
		$this->load->model('Modeltersangka');
		$this->load->model('Modelbarangbukti');
	}

	public function index()
	{
		// Check Admin Level
		if ($this->kode_kesatuan == 'ADMINSUPER') {

			$dataDashboard = array(
				"jumlahKasus" => $this->Modelkasus->getKasusDashboard($this->kode_kesatuan),
				"jumlahTersangka" => $this->Modelkasus->getTersangkaDashboard($this->kode_kesatuan),
				"jumlahKasusSelesai" => $this->Modelkasus->getKasusSelesaiDashboard($this->kode_kesatuan),
				"jumlahAdmin" => count($this->Modeladmin->getAdmin($this->kode_kesatuan)),
				"jumlahKasusMenonjol" => $this->Modelkasus->getKasusMenonjol($this->kode_kesatuan),
				"jumlahLoginToday" => 100,
			);

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;

			$this->load->view('superadmin/include/header', $data);
			$this->load->view('superadmin/v_dashboard', $data);
			$this->load->view('superadmin/include/footer', $data);

		} else {

			// TSK NOTIFICATION
			$displayTSK = false;
			$checkEmptyTSK = $this->checkTersangkaEmpty();
			if (in_array("unvailable", $checkEmptyTSK)) {
				$displayTSK = true;
			}
			$displayBB = false;
			$checkEmptyBB = $this->checkBBEmpty();
			if (in_array("unvailable", $checkEmptyBB)) {
				$displayBB = true;
			}

			$dataDashboard = array(
				"jumlahKasus" => $this->Modelkasus->getKasusDashboard($this->kode_kesatuan),
				"jumlahTersangka" => $this->Modelkasus->getTersangkaDashboard($this->kode_kesatuan),
				"jumlahKasusSelesai" => $this->Modelkasus->getKasusSelesaiDashboard($this->kode_kesatuan),
			);

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;
			// Notification If Case TSK / BB Empty
			$data['displayTSK'] = $displayTSK;
			$data['displayBB'] = $displayBB;

			$this->load->view('include/header', $data);
			$this->load->view('v_dashboard', $data);
			$this->load->view('include/footer', $data);

		}
	}

	public function checkTersangkaEmpty(){
		$checkEmpty = array();
		$res = $this->Modeldata->getKasusReturnIdKasus($this->kode_kesatuan);
		for ($i=0; $i < count($res); $i++) { 
			$idKasus = $res[$i]['id_kasus'];
			$TSK = $this->Modeltersangka->getTersangkaByIdKasus($idKasus)->result_array();
			if (empty($TSK)) {
				$checkEmpty[] = 'unvailable';
			}
		}
		return $checkEmpty;
	}

	public function checkBBEmpty(){
		$checkEmpty = array();
		$res = $this->Modeldata->getKasusReturnIdKasus($this->kode_kesatuan);
		for ($i=0; $i < count($res); $i++) { 
			$idKasus = $res[$i]['id_kasus'];
			$BB = $this->Modelbarangbukti->getBarangBuktiByIdKasus($idKasus)->result_array();
			if (empty($BB)) {
				$checkEmpty[] = 'unvailable';
			}
		}
		return $checkEmpty;
	}
}
