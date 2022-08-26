<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {
	
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

		$this->load->model('Modelfile');
	}

	public function viewUploadFile(){
		$dataFile = $this->Modelfile->getAllFile($this->kode_kesatuan);

        $data['title'] = "Data Files";
        $data['menuLink'] = "upload-file";
		$data['dataFile'] = $dataFile;

		$this->load->view('include/header', $data);
		$this->load->view('v_uploadfile', $data);
		$this->load->view('include/footer', $data);
	}

    public function uploadFile(){
        $nrp = $this->session->userdata('login_data_admin')['nrp_admin'];
        $ket_file = $this->input->post('ket_file');
        $time = time();
        $file_name = $_FILES['file'];

		// Move uploaded file to a temp location
		$uploadDir = $_SERVER['DOCUMENT_ROOT'].'/si-lapor/uploads/fileJajaran/';
		$uploadFile = $uploadDir . $time . " - " . basename($_FILES['file']['name']);
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)){
			$new_data = [
				'nrp' => $nrp,
                'kode_kesatuan' => $this->kode_kesatuan,
                'ket_file' => $ket_file,
                'nama_file' => $time. " - " .$file_name['name'],
			];
            $this->Modelfile->addFile($new_data);
            $this->session->set_flashdata('success', 'File berhasil diupload ke database!');
		}
		else
		{
			echo "Possible file upload attack!\n";
            $this->session->set_flashdata('error', 'File gagal diupload ke database!');
		}

        redirect(base_url().'upload-file');
    }
    
	public function delFile($idFile){
        $res = $this->Modelfile->getFile($idFile);

        $namaFile = $res[0]['nama_file'];
        $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/si-lapor/uploads/fileJajaran/';
        $uploadFile = $uploadDir . $namaFile;
        
		$this->Modelfile->delFile($idFile);
        
		unlink($uploadFile);
		$this->session->set_flashdata('success', 'File berhasil dihapus dari database!');
		redirect(base_url("upload-file"));
	}

    public function downloadFile($idFile){
        $res = $this->Modelfile->getFile($idFile);

        $namaFile = $res[0]['nama_file'];
        $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/si-lapor/uploads/fileJajaran/';
        $uploadFile = $uploadDir . $namaFile;

        force_download($uploadFile, NULL);
    }
}
