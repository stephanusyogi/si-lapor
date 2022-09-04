<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
  protected $session_status;
	function __construct(){
		parent::__construct();		
		$this->load->model('Modelauth');
    $this->session_status = $this->session->userdata('isLoggedIn_admin');
	}

	public function index()
	{
    $this->load->view('v_auth_login');
	}

	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$data['res'] = $this->Modelauth->checkAuth($username);

		if (!$data['res']) {

      $this->session->set_flashdata('error', 'Username / Password Anda Salah!');
			redirect(base_url() . 'login');

		}else{

			if (password_verify($password, $data['res'][0]['password'])) {


				$kesatuan = $this->Modelauth->getKesatuanbyKode($data['res'][0]['kode_kesatuan']);
				$dataAdmin = $data['res'][0];
				$resultAuth = $kesatuan[0];
				$kode_lp = str_replace('/', ' ', $resultAuth['kode_lp']);
				$dataUser = array(
					'nama_admin' => $dataAdmin['nama_admin'],
					'nrp_admin' => $dataAdmin['nrp'],
					'nama' => $resultAuth['nama'],
					'kodekesatuan' => $resultAuth['kode_kesatuan'],
					'kode_lp' => $resultAuth['kode_lp'],
					'tambahan_lp' => $kode_lp
				);

				// Add to History
				if ($dataAdmin['kode_kesatuan'] != 'ADMINSUPER' && !$dataAdmin['kode_kesatuan'] != 'PRINCIPAL'){
					$this->Modelauth->addHistory(array(
						'id_admin' => $dataAdmin['id_admin']
					));
				}
	
				$this->session->set_userdata('login_data_admin', $dataUser);
				$this->session->set_userdata('isLoggedIn_admin', true);
				redirect(base_url('dashboard'));

			} else {

				$this->session->set_flashdata('error', 'Password Anda Salah!');
				redirect(base_url() . 'login');

			}
		}
	}

	public function logout()
	{
			session_destroy();
			redirect(base_url() . 'login');
	}
}
