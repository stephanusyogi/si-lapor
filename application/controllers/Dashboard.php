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
		// Month Array for Diagram
		$monthArray = array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december");
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
			// Diagram General
			$dataDiagram = array();
			foreach($monthArray as $month){
				$dataDiagram[$month] = array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ("first day of {$month} this year")), date ('Y-m-d', strtotime ("last day of {$month} this year"))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ("first day of {$month} this year")), date ('Y-m-d', strtotime ("last day of {$month} this year"))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ("first day of {$month} this year")), date ('Y-m-d', strtotime ("last day of {$month} this year"))),
				);
			}
			// Diagram Barang Bukti
			$kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
			$dataDiagramBB = array();
			foreach ($monthArray as $month) {
				$dataTempBB = array();
				foreach($kategoriBB as $kategori) {
					$jumlahBerat = 0;
					$resBB = $this->Modelkasus->getSuperDiagramBB($kategori, date ('Y-m-d', strtotime ("first day of {$month} this year")), date ('Y-m-d', strtotime ("last day of {$month} this year")));
					if (!empty($resBB)) {
						foreach ($resBB as $keybb) {
							$jumlahBerat += $keybb['jumlah'];
						}
						$beratSatuan = $jumlahBerat;
					}else{
						$beratSatuan = $jumlahBerat;
					}
					$dataTempBB[$kategori] = $beratSatuan;
				}
				$dataDiagramBB[$month] = $dataTempBB; 
			}

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;

			// Data Diagram General
			$data['dataDiagram'] = $dataDiagram;
			// Data Diagram BB
			$data['dataDiagramBB'] = $dataDiagramBB;
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
			// Diagram General
			$dataDiagram = array();
			foreach($monthArray as $month){
				$dataDiagram[$month] = array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ("first day of {$month} this year")), date ('Y-m-d', strtotime ("last day of {$month} this year"))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ("first day of {$month} this year")), date ('Y-m-d', strtotime ("last day of {$month} this year"))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ("first day of {$month} this year")), date ('Y-m-d', strtotime ("last day of {$month} this year"))),
				);
			}

			// Diagram Barang Bukti
			$kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
			$dataDiagramBB = array();
			foreach ($monthArray as $month) {
				$dataTempBB = array();
				foreach($kategoriBB as $kategori) {
					$jumlahBerat = 0;
					$resBB = $this->Modelkasus->getDiagramBB($this->kode_kesatuan, $kategori, date ('Y-m-d', strtotime ("first day of {$month} this year")), date ('Y-m-d', strtotime ("last day of {$month} this year")));
					if (!empty($resBB)) {
						foreach ($resBB as $keybb) {
							$jumlahBerat += $keybb['jumlah'];
						}
						$beratSatuan = $jumlahBerat;
					}else{
						$beratSatuan = $jumlahBerat;
					}
					$dataTempBB[$kategori] = $beratSatuan;
				}
				$dataDiagramBB[$month] = $dataTempBB; 
			}

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;
			// Notification If Case TSK / BB Empty
			$data['displayTSK'] = $displayTSK;
			$data['displayBB'] = $displayBB;
			// Data Diagram General
			$data['dataDiagram'] = $dataDiagram;
			// Data Diagram BB
			$data['dataDiagramBB'] = $dataDiagramBB;
			$data['tahunDiagram'] = $tahunDiagram;
		}

		$data['viewDiagramByDate'] = false;
		$data['btnExitSort'] = false;

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

		// Month Array for Diagram
		$monthArray = array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december");

		if ($this->kode_kesatuan == 'ADMINSUPER') {

			$dataDashboard = array(
				"jumlahKasus" => $this->Modelkasus->getSuperKasusDashboard(),
				"jumlahTersangka" => $this->Modelkasus->getSuperTersangkaDashboard(),
				"jumlahKasusSelesai" => $this->Modelkasus->getSuperKasusSelesaiDashboard($this->kode_kesatuan),
				"jumlahAdmin" => count($this->Modeladmin->getAdmin()),
				"jumlahKasusMenonjol" => $this->Modelkasus->getSuperKasusMenonjol(),
				"jumlahLoginToday" => count($this->Modeladmin->getAdminToday()),
			);

			// Diagram General
			$dataDiagram = array();
			foreach($monthArray as $month){
				$dataDiagram[$month] = array(
					'KSS' => $this->Modelkasus->getSuperDiagramKasus(date ('Y-m-d', strtotime ("first day of {$month} {$tahunDiagram}")), date ('Y-m-d', strtotime ("last day of {$month} {$tahunDiagram}"))),
					'TSK' => $this->Modelkasus->getSuperDiagramTSK(date ('Y-m-d', strtotime ("first day of {$month} {$tahunDiagram}")), date ('Y-m-d', strtotime ("last day of {$month} {$tahunDiagram}"))),
					'SELRA' => $this->Modelkasus->getSuperDiagramSELRA(date ('Y-m-d', strtotime ("first day of {$month} {$tahunDiagram}r")), date ('Y-m-d', strtotime ("last day of {$month} {$tahunDiagram}"))),
				);
			}
			// Diagram Barang Bukti
			$kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
			$dataDiagramBB = array();
			foreach ($monthArray as $month) {
				$dataTempBB = array();
				foreach($kategoriBB as $kategori) {
					$jumlahBerat = 0;
					$resBB = $this->Modelkasus->getSuperDiagramBB($kategori, date ('Y-m-d', strtotime ("first day of {$month} {$tahunDiagram}")), date ('Y-m-d', strtotime ("last day of {$month} {$tahunDiagram}")));
					if (!empty($resBB)) {
						foreach ($resBB as $keybb) {
							$jumlahBerat += $keybb['jumlah'];
						}
						$beratSatuan = $jumlahBerat;
					}else{
						$beratSatuan = $jumlahBerat;
					}
					$dataTempBB[$kategori] = $beratSatuan;
				}
				$dataDiagramBB[$month] = $dataTempBB; 
			}

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;

			$data['dataDiagram'] = $dataDiagram;
			$data['dataDiagramBB'] = $dataDiagramBB;
			$data['tahunDiagram'] = $tahunDiagram;

			$data['btnExitSort'] = true;

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

			// Diagram General
			$dataDiagram = array();
			foreach($monthArray as $month){
				$dataDiagram[$month] = array(
					'KSS' => $this->Modelkasus->getDiagramKasus($this->kode_kesatuan, date ('Y-m-d', strtotime ("first day of {$month} {$tahunDiagram}")), date ('Y-m-d', strtotime ("last day of {$month} {$tahunDiagram}"))),
					'TSK' => $this->Modelkasus->getDiagramTSK($this->kode_kesatuan, date ('Y-m-d', strtotime ("first day of {$month} {$tahunDiagram}")), date ('Y-m-d', strtotime ("last day of {$month} {$tahunDiagram}"))),
					'SELRA' => $this->Modelkasus->getDiagramSELRA($this->kode_kesatuan, date ('Y-m-d', strtotime ("first day of {$month} {$tahunDiagram}r")), date ('Y-m-d', strtotime ("last day of {$month} {$tahunDiagram}"))),
				);
			}
			// Diagram Barang Bukti
			$kategoriBB = array("Ganja","Tembakau Gorilla","Hashish","Opium","Morphin","Heroin/Putaw","Kokain","Exstacy/Carnophen","Sabu","GOL IV","Daftar G","Kosmetik","Jamu");
			$dataDiagramBB = array();
			foreach ($monthArray as $month) {
				$dataTempBB = array();
				foreach($kategoriBB as $kategori) {
					$jumlahBerat = 0;
					$resBB = $this->Modelkasus->getDiagramBB($this->kode_kesatuan,$kategori, date ('Y-m-d', strtotime ("first day of {$month} {$tahunDiagram}")), date ('Y-m-d', strtotime ("last day of {$month} {$tahunDiagram}")));
					if (!empty($resBB)) {
						foreach ($resBB as $keybb) {
							$jumlahBerat += $keybb['jumlah'];
						}
						$beratSatuan = $jumlahBerat;
					}else{
						$beratSatuan = $jumlahBerat;
					}
					$dataTempBB[$kategori] = $beratSatuan;
				}
				$dataDiagramBB[$month] = $dataTempBB; 
			}

			$data['title'] = "Dashboard";
			$data['menuLink'] = "dashboard";
			$data['dataDashboard'] = $dataDashboard;
			// Notification If Case TSK / BB Empty
			$data['displayTSK'] = $displayTSK;
			$data['displayBB'] = $displayBB;
			
			$data['dataDiagram'] = $dataDiagram;
			$data['dataDiagramBB'] = $dataDiagramBB;
			$data['tahunDiagram'] = $tahunDiagram;

			$data['btnExitSort'] = true;
		}

		$data['viewDiagramByDate'] = true;
		$data['btnExitSort'] = true;

		$this->load->view('include/header', $data);
		$this->load->view('v_dashboard', $data);
		$this->load->view('include/footer', $data);

	}

	public function viewSearch($kategoriPencarian){
		$kesatuan = $this->Modeldata->getKesatuan($this->kode_kesatuan);

		$data['title'] = "Pencarian Data";
		$data['menuLink'] = "dashboard";
		$data['kategoriPencarian'] = $kategoriPencarian;
		$data['kesatuan'] = $kesatuan;
		
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

			if ($this->kode_kesatuan == 'ADMINSUPER') {
				$kode_lp = $_POST['kode_kesatuan'];
				$namasatuan = $_POST['kode_kesatuan'];
			}
			
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
		$data['kategoriPencarian'] = $kategoriPencarian;

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
