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

	public function index(){
		
		$date = $this->rangeYear(date("Y-m-d", strtotime("-1 month")));
		$tahunDiagram = date("Y");
		// Check Admin Level
		if ($this->kode_kesatuan == 'ADMINSUPER') {

			$dataDashboard = array(
				"jumlahKasus" => $this->Modelkasus->getSuperKasusDashboard(),
				"jumlahTersangka" => $this->Modelkasus->getSuperTersangkaDashboard(),
				"jumlahKasusSelesai" => $this->Modelkasus->getSuperKasusSelesaiDashboard($this->kode_kesatuan),
				"jumlahAdmin" => count($this->Modeladmin->getAdmin()),
				"jumlahKasusMenonjol" => $this->Modelkasus->getSuperKasusMenonjol(),
				"jumlahLoginToday" => count($this->Modeladmin->getAdminToday()),
			);

			$dataDiagram = array(
				"Jan" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of january this year')), date ('Y-m-d', strtotime ('last day of january this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of january this year')), date ('Y-m-d', strtotime ('last day of january this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of january this year')), date ('Y-m-d', strtotime ('last day of january this year'))),
				),
				"Feb" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of february this year')), date ('Y-m-d', strtotime ('last day of february this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of february this year')), date ('Y-m-d', strtotime ('last day of february this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of february this year')), date ('Y-m-d', strtotime ('last day of february this year'))),
				),
				"Mar" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of march this year')), date ('Y-m-d', strtotime ('last day of march this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of march this year')), date ('Y-m-d', strtotime ('last day of march this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of march this year')), date ('Y-m-d', strtotime ('last day of march this year'))),
				),
				"Apr" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of april this year')), date ('Y-m-d', strtotime ('last day of april this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of april this year')), date ('Y-m-d', strtotime ('last day of april this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of april this year')), date ('Y-m-d', strtotime ('last day of april this year'))),
				),
				"Mei" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of may this year')), date ('Y-m-d', strtotime ('last day of may this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of may this year')), date ('Y-m-d', strtotime ('last day of may this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of may this year')), date ('Y-m-d', strtotime ('last day of may this year'))),
				),
				"Jun" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of june this year')), date ('Y-m-d', strtotime ('last day of june this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of june this year')), date ('Y-m-d', strtotime ('last day of june this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of june this year')), date ('Y-m-d', strtotime ('last day of june this year'))),
				),
				"Jul" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of july this year')), date ('Y-m-d', strtotime ('last day of july this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of july this year')), date ('Y-m-d', strtotime ('last day of july this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of july this year')), date ('Y-m-d', strtotime ('last day of july this year'))),
				),
				"Agu" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of august this year')), date ('Y-m-d', strtotime ('last day of august this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of august this year')), date ('Y-m-d', strtotime ('last day of august this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of august this year')), date ('Y-m-d', strtotime ('last day of august this year'))),
				),
				"Sep" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of september this year')), date ('Y-m-d', strtotime ('last day of september this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of september this year')), date ('Y-m-d', strtotime ('last day of september this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of september this year')), date ('Y-m-d', strtotime ('last day of september this year'))),
				),
				"Okt" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of october this year')), date ('Y-m-d', strtotime ('last day of october this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of october this year')), date ('Y-m-d', strtotime ('last day of october this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of october this year')), date ('Y-m-d', strtotime ('last day of october this year'))),
				),
				"Nov" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of november this year')), date ('Y-m-d', strtotime ('last day of november this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of november this year')), date ('Y-m-d', strtotime ('last day of november this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of november this year')), date ('Y-m-d', strtotime ('last day of november this year'))),
				),
				"Des" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ('first day of december this year')), date ('Y-m-d', strtotime ('last day of december this year'))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ('first day of december this year')), date ('Y-m-d', strtotime ('last day of december this year'))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ('first day of december this year')), date ('Y-m-d', strtotime ('last day of december this year'))),
				),
			);

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;

			$data['dataDiagram'] = $dataDiagram;
			$data['tahunDiagram'] = $tahunDiagram;

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

			$dataDiagram = array(
				"Jan" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of january this year')), date ('Y-m-d', strtotime ('last day of january this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of january this year')), date ('Y-m-d', strtotime ('last day of january this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of january this year')), date ('Y-m-d', strtotime ('last day of january this year'))),
				),
				"Feb" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of february this year')), date ('Y-m-d', strtotime ('last day of february this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of february this year')), date ('Y-m-d', strtotime ('last day of february this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of february this year')), date ('Y-m-d', strtotime ('last day of february this year'))),
				),
				"Mar" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of march this year')), date ('Y-m-d', strtotime ('last day of march this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of march this year')), date ('Y-m-d', strtotime ('last day of march this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of march this year')), date ('Y-m-d', strtotime ('last day of march this year'))),
				),
				"Apr" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of april this year')), date ('Y-m-d', strtotime ('last day of april this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of april this year')), date ('Y-m-d', strtotime ('last day of april this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of april this year')), date ('Y-m-d', strtotime ('last day of april this year'))),
				),
				"Mei" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of may this year')), date ('Y-m-d', strtotime ('last day of may this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of may this year')), date ('Y-m-d', strtotime ('last day of may this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of may this year')), date ('Y-m-d', strtotime ('last day of may this year'))),
				),
				"Jun" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of june this year')), date ('Y-m-d', strtotime ('last day of june this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of june this year')), date ('Y-m-d', strtotime ('last day of june this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of june this year')), date ('Y-m-d', strtotime ('last day of june this year'))),
				),
				"Jul" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of july this year')), date ('Y-m-d', strtotime ('last day of july this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of july this year')), date ('Y-m-d', strtotime ('last day of july this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of july this year')), date ('Y-m-d', strtotime ('last day of july this year'))),
				),
				"Agu" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of august this year')), date ('Y-m-d', strtotime ('last day of august this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of august this year')), date ('Y-m-d', strtotime ('last day of august this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of august this year')), date ('Y-m-d', strtotime ('last day of august this year'))),
				),
				"Sep" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of september this year')), date ('Y-m-d', strtotime ('last day of september this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of september this year')), date ('Y-m-d', strtotime ('last day of september this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of september this year')), date ('Y-m-d', strtotime ('last day of september this year'))),
				),
				"Okt" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of october this year')), date ('Y-m-d', strtotime ('last day of october this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of october this year')), date ('Y-m-d', strtotime ('last day of october this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of october this year')), date ('Y-m-d', strtotime ('last day of october this year'))),
				),
				"Nov" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of november this year')), date ('Y-m-d', strtotime ('last day of november this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of november this year')), date ('Y-m-d', strtotime ('last day of november this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of november this year')), date ('Y-m-d', strtotime ('last day of november this year'))),
				),
				"Des" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of december this year')), date ('Y-m-d', strtotime ('last day of december this year'))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of december this year')), date ('Y-m-d', strtotime ('last day of december this year'))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ('first day of december this year')), date ('Y-m-d', strtotime ('last day of december this year'))),
				),
			);

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;
			// Notification If Case TSK / BB Empty
			$data['displayTSK'] = $displayTSK;
			$data['displayBB'] = $displayBB;
			
			$data['dataDiagram'] = $dataDiagram;
			$data['tahunDiagram'] = $tahunDiagram;
		}

		$this->load->view('include/header', $data);
		$this->load->view('v_dashboard', $data);
		$this->load->view('include/footer', $data);
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

	public function viewDiagramByDate(){
		$tahunDiagram = $this->input->post('tahunDiagram');
		$startDate = date ('Y-m-d',strtotime ("first day of january {$tahunDiagram}"));
		$endDate = date ('Y-m-d',strtotime ("last day of december {$tahunDiagram}"));

		if ($this->kode_kesatuan == 'ADMINSUPER') {

			$dataDashboard = array(
				"jumlahKasus" => $this->Modelkasus->getSuperKasusDashboard(),
				"jumlahTersangka" => $this->Modelkasus->getSuperTersangkaDashboard(),
				"jumlahKasusSelesai" => $this->Modelkasus->getSuperKasusSelesaiDashboard($this->kode_kesatuan),
				"jumlahAdmin" => count($this->Modeladmin->getAdmin()),
				"jumlahKasusMenonjol" => $this->Modelkasus->getSuperKasusMenonjol(),
				"jumlahLoginToday" => count($this->Modeladmin->getAdminToday()),
			);

			$dataDiagram = array(
				"Jan" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Feb" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Mar" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Apr" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Mei" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Jun" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Jul" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Agu" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Sep" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Okt" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Nov" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
				"Des" => array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus($startDate, $endDate),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK($startDate, $endDate),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA($startDate, $endDate),
				),
			);

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;

			$data['dataDiagram'] = $dataDiagram;
			$data['tahunDiagram'] = $tahunDiagram;

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

			$dataDiagram = array(
				"Jan" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Feb" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Mar" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Apr" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Mei" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Jun" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Jul" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Agu" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Sep" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Okt" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Nov" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
				"Des" => array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, $startDate, $endDate),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, $startDate, $endDate),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, $startDate, $endDate),
				),
			);

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;
			// Notification If Case TSK / BB Empty
			$data['displayTSK'] = $displayTSK;
			$data['displayBB'] = $displayBB;
			
			$data['dataDiagram'] = $dataDiagram;
			$data['tahunDiagram'] = $tahunDiagram;
		}

		$this->load->view('include/header', $data);
		$this->load->view('v_dashboard', $data);
		$this->load->view('include/footer', $data);

	}

	public function viewSearch($kategoriPencarian){
		$data['title'] = "Pencarian Data";
		$data['menuLink'] = "dashboard";
		$data['kategoriPencarian'] = $kategoriPencarian;
		
		$this->load->view('include/header', $data);
		$this->load->view('v_search', $data);
		$this->load->view('include/footer', $data);
	}

	public function searchData(){
		$kategoriPencarian = $this->input->post('kategoriPencarian');
		$kesatuan = $this->Modeldata->getKesatuan($this->kode_kesatuan);

		if ($kategoriPencarian == 'nolp') {
			$kesatuan = $this->input->post('kesatuan');
			$nosurat = $this->input->post('nosurat');
			$bulansurat = $this->input->post('bulansurat');
			$tahunsurat = $this->input->post('tahunsurat');
			$namapolsek = strtoupper($this->input->post('namapolsek'));
			$kode_lp = $this->session->userdata('login_data_admin')['kode_lp'];
			$namasatuan = $this->session->userdata('login_data_admin')['nama'];
			$kodekesatuan = $this->kode_kesatuan;
			
			if ($kesatuan == 'polres') {
				$noLP = "LP/A/{$nosurat}/{$bulansurat}/{$tahunsurat}/SPKT.{$kode_lp}/POLDA JAWA TIMUR";
			} else {
				$noLP = "LP/A/{$nosurat}/{$bulansurat}/{$tahunsurat}/SPKT/{$namapolsek}/{$namasatuan}/POLDA JAWA TIMUR";
			}

			if ($this->kode_kesatuan == 'ADMINSUPER') {
				$res = $this->Modelkasus->searchSuperData($noLP, $kategoriPencarian);
			} else {
				$res = $this->Modelkasus->searchData($noLP, $this->kode_kesatuan, $kategoriPencarian);
			}
			
			$data['searchValue'] = $noLP;

		} else {
			$searchValue = $this->input->post('searchValue');

			if ($this->kode_kesatuan == 'ADMINSUPER') {
				$res = $this->Modelkasus->searchSuperData($searchValue, $kategoriPencarian);
			} else {
				$res = $this->Modelkasus->searchData($searchValue, $this->kode_kesatuan, $kategoriPencarian);
			}
			
			$data['searchValue'] = $searchValue;
		}
		
		$data['title'] = "Hasil Pencarian Data";
		$data['menuLink'] = "dashboard";
		$data['dataKasus'] = $res;
		$data['kesatuan'] = $kesatuan;

		$this->session->set_flashdata('success', 'Pencarian data sedang diproses!');
		$this->load->view('include/header', $data);
		$this->load->view('v_search_result', $data);
		$this->load->view('include/footer', $data);
	}
	
	// Date Modul
	function rangeYear($date) {
		date_default_timezone_set (date_default_timezone_get());
		$dt = strtotime ($date);
		return array (
			"start" => date ('Y-m-d', strtotime ('first day of january this year', $dt)),
			"end" => date ('Y-m-d', strtotime ('last day of december this year', $dt))
		);
	}
}
