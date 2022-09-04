<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
	
  protected $session_status;
	protected $kode_kesatuan;
	function __construct(){
		parent::__construct();		
    $this->session_status = $this->session->userdata('isLoggedIn_admin');
		$this->kode_kesatuan = $this->session->userdata('login_data_admin')['kodekesatuan'];
		
		$this->load->model('Modelchat');
	}

	// LAPOR KASUS MODUL
	public function index(){
		$data['title'] = "Chat App";
		$data['menuLink'] = "chat";
		
		$this->session->set_flashdata('success', 'Please Wait, Data Chat Loading...');
		$this->load->view('include/header',$data);
		$this->load->view('v_chat',$data);
		$this->load->view('include/footer',$data);
	}
    
	public function getAllUsers(){
		$kode_kesatuan = ($this->kode_kesatuan == 'ADMINSUPER') ? $_POST['kode_kesatuan'] : str_replace('_','-',$_POST['kode_kesatuan']);
		$this->Modelchat->get_allusers($kode_kesatuan);
	}

	public function getGroup(){
		$this->Modelchat->getGroup();
	}

	public function getmessagegroup(){
		$this->Modelchat->getmessagegroup($this->kode_kesatuan);
	}

	public function getbyUser(){
		$incoming_id = $_POST['kode_kesatuan'];
    $this->Modelchat->get_infouser($incoming_id);
	}

	public function getmessage(){
		$incoming_id = ($_POST['incoming_id'] == 'ADMINSUPER') ? $_POST['incoming_id'] : str_replace('_','-',$_POST['incoming_id']);
    $outgoing_id = ($this->kode_kesatuan == 'ADMINSUPER') ? $_POST['outgoing_id'] : str_replace('_','-',$_POST['outgoing_id']);

    $this->Modelchat->get_message($incoming_id, $outgoing_id);
	}

	public function insertChat(){
		$incoming_id = ($_POST['kode_kesatuan'] == 'ADMINSUPER') ? $_POST['kode_kesatuan'] : str_replace('_','-',$_POST['kode_kesatuan']);
		$outgoing_id = $this->kode_kesatuan;
		$msg = $_POST['message'];

    $this->Modelchat->insert_message($outgoing_id,$incoming_id, $msg);
	}
	
	public function insertChatGroup(){
		$outgoing_id = $this->kode_kesatuan;
		$msg = $_POST['message'];

		$this->Modelchat->insert_message_group($outgoing_id, $msg);
	}

	public function updateIsRead(){
		$incoming_id = $_POST['incoming_id'];
		$outgoing_id = $this->kode_kesatuan;

		$this->Modelchat->updateStatusRead($incoming_id, $outgoing_id);
	}

	public function countMsg(){
			$this->Modelchat->countMessage($this->kode_kesatuan);
	}

	public function deleteChat(){
		$iduserchat = $_POST['incoming_id'];

		$this->Modelchat->delete_message($iduserchat);
	}

}

