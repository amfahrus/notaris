<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $defaultdb = $this->load->database('default', TRUE);
		// $otherdb = $this->load->database('otherdb', TRUE);
	}

	public function index()
	{
		redirect(base_url());
	}

	public function kirim_sms($value='')
	{
		$this->load->model('BerkasModel');
		$this->load->model('KlienModel');
		$this->load->model('SmsModel');

		$berkas = $this->BerkasModel->select_id_berkas($value);

		if ($berkas->jenis_aktor === 'Notaris') {
	    	/* kalo notaris simpan id pemohon */
	    	$pemohon = $berkas->id_pemohon;
	    	/* ambil email berdasarkan id pemohon (array) */
	    	$nama_pemohon[] = $this->KlienModel->select_klien($pemohon)->nama_pemohon;
	    	$hp_pemohon[] = $this->KlienModel->select_klien($pemohon)->hp;
    	}else{
	    	/* kalo ppat simpan id penjual dan id pembeli */
	    	$penjual = $berkas->id_penjual;
	    	$pembeli = $berkas->id_pembeli;
	    	/* ambil email berdasarkan id penjual dan id pembeli (array) */
	    	$nama_pemohon[] = $this->KlienModel->select_klien($penjual)->nama_pemohon;
	    	$nama_pemohon[] = $this->KlienModel->select_klien($pembeli)->nama_pemohon;
	    	$hp_pemohon[] = $this->KlienModel->select_klien($penjual)->hp;
	    	$hp_pemohon[] = $this->KlienModel->select_klien($pembeli)->hp;
    	}

    	for ($i=0; $i < count($hp_pemohon); $i++) { 
    		if ($hp_pemohon[$i] != '') {
    			$data = array('class' => '1',
    			 				'message' => "Pekerjaan ".$berkas->nama_pekerjaan." atas nama ".$nama_pemohon[$i]." telah selesai di kerjakan. Silahkan datang ke kantor Notaris untuk melakukan proses selanjutnya",
    			 				'date' => gmdate('Y-m-d H:i:s', time()+60*60*7),
    			 				'delivery_report' => 'yes',
    			 				'coding' => 'default',
    			 				'ncpr' => false,
    			 				'uid' => 4,
    			 				'url' => '',
    			 				'dest' => $hp_pemohon[$i]);

    			exec("cd c:\gammu && gammu-smsd -c smsdrc -k -n smsgateway",$hasil1);
    			exec("cd c:\gammu && gammu --identify",$hasil);
    			if ($hasil[0] == "Error opening device, it doesn't exist." || $hasil[0] == "No response in specified timeout. Probably phone not connected.") {
    				$status = "SMS Tidak Dikirim! Modem Tidak Ditemukan";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/pkj_selesai'));
    			}else if($hasil[0] == "Error opening device. Unknown, busy or no permissions."){
    				$status = "SMS Tidak Dikirim! Modem Sibuk atau Tidak Diizinkan Digunakan";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/pkj_selesai'));
    			}else{
    				exec("cd c:\gammu && gammu-smsd -c smsdrc -s -n smsgateway",$hasil1);
	    			if ($this->SmsModel->kirim_pesan($data) == NULL) {
	    				$status = "SMS Pemberitahuan Dikirim!";
						$this->session->set_flashdata('success', $status);
						redirect(base_url('Home/pkj_selesai'));
	    			}else{
	    				$status = "SMS Tidak Dikirim! Terjadi Kesalahan Sistem";
						$this->session->set_flashdata('error', $status);
						redirect(base_url('Home/pkj_selesai'));
	    			}
    			}
    		}
    	}
	}

}

/* End of file sms.php */
/* Location: ./application/controllers/sms.php */