<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
		if (!$this->session->userdata('SESS_IS_LOGIN')){
			redirect(base_url('login'));
		}
		$this->load->model('PkBaruModel');
		$this->data['dataBaruPpat'] = $this->PkBaruModel->load_pekerjaan('PPAT');
		$this->data['dataBaruNotaris'] = $this->PkBaruModel->load_pekerjaan('Notaris');
		$this->data['dataBaruAll'] = $this->PkBaruModel->load_all();
		if ($this->PkBaruModel->pending() == 0) {
			$this->data['pkjPending'] = "";
		}else{
			$this->data['pkjPending'] = $this->PkBaruModel->pending();
		}
		if ($this->PkBaruModel->proses() == 0) {
			$this->data['pkjProses'] = "";
		}else{
			$this->data['pkjProses'] = $this->PkBaruModel->proses();
		}
		if ($this->PkBaruModel->selesai() == 0) {
			$this->data['pkjSelesai'] = "";
		}else{
			$this->data['pkjSelesai'] = $this->PkBaruModel->selesai();
		}
		
	}


	

	public function index()
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();

		$this->load->view('global/header',$this->data);

		$this->load->model('BerandaModel');
		$data['pkMasuk'] = $this->BerandaModel->cek_pk_masuk();
		$data['biayaKerja'] = $this->BerandaModel->cek_biaya_kerja();
		$data['blmSelesai'] = $this->BerandaModel->cek_blm_selesai();
		$data['pending'] = $this->PkBaruModel->pending();
		$data['userPending'] = $this->BerandaModel->cek_pending();

		$this->load->view('beranda/beranda',$data);

		$this->load->view('global/footer');
	}

	/* TIMELINE KHUSUS NOTARIS BELUM FIX */
	public function timeline()
	{
		$this->load->view('global/header', $this->data);
		$this->load->view('global/footer');
	}

	/* SETTING ACCOUNT */

	/* halaman setting akun */
	public function setting_akun()
	{
		$this->load->model('UserModel');

		$data['user'] = $this->UserModel->select_username($this->session->userdata('SESS_USER_ID'));

		$this->load->view('global/header', $this->data);
		$this->load->view('akun/setting_akun',$data);
		$this->load->view('global/footer');
	}

	public function ubah_user()
	{
		$this->load->model('UserModel');

		$data['user'] = $this->UserModel->select_username($this->session->userdata('SESS_USER_ID'));
		$this->load->view('akun/ubah_user',$data);
	}

	public function ubah_pwd()
	{
		$this->load->view('akun/ubah_pwd');
	}

	/* halaman data user */
	public function data_user()
	{
		if ($this->session->userdata('SESS_HAK_AKSES') !== '1') {
			/* tidak boleh */
			redirect(base_url('Home'));
		}else{
			$this->load->model('UserModel');
			if ($this->UserModel->cek_user()) {
				$data['user'] = $this->UserModel->select_user();
			}else{
				$data['user'] = "kosong";
			}

			$this->load->view('global/header', $this->data);
			$this->load->view('akun/data_user', $data);
			$this->load->view('global/footer');
		}
	}

	public function cek_username()
	{
		$this->load->model('UserModel');

		$username = $this->input->post('name');

		if ($this->UserModel->cek_username($username)) {
			echo "false";
		}else{
			echo "true";
		}
	}

	public function konfirm_pass()
	{
		$username = $this->input->post('name');
		$pass = $this->input->post('pass');

		if ($username == $pass) {
			echo "true";
		}else{
			echo "false";
		}
	}

	public function cek_email()
	{
		$this->form_validation->set_rules('email', 'Email', 'valid_email');

		if ($this->form_validation->run() === FALSE) {
			echo "false";
		}else{
			echo "true";
		}
	}

	public function tambah_user()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('hak_akses', 'Akses', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/data_user'));
		}else{
			$this->load->model('UserModel');

			if ($this->UserModel->cek_username($this->input->post('username')) || strlen($this->input->post('username')) < 4 ) {
				$status = "Username Tidak Sesuai! Silahkan Gunakan Username Lain";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/data_user'));
			}else{
				$pwd = md5($this->input->post('password'));
				if ($this->UserModel->insert_user($this->input->post('username'),$pwd,$this->input->post('email'), $this->input->post('hak_akses'))) {
					$status = "Data User Berhasil Ditambah!";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/data_user'));
				}else{
					$status = "Data User Gagal Ditambah! Terdapat Kesalahan Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/data_user'));
				}
			}
		}
	}

	/* reset password */
	public function reset_password()
	{
		$this->form_validation->set_rules('id', 'Id', 'required');
		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/data_user'));
		}else{
			$this->load->model('LoginModel');
			$pass = $this->LoginModel->select_pass($this->session->userdata('SESS_USER_ID'))->password;
			if (md5($this->input->post('pwver')) === $pass) {
				$this->load->model('UserModel');

				$tgl = gmdate('dmY', time()+60*60*7);
				$waktu = gmdate('His', time()+60*60*7);
				$reset = $tgl+$waktu;
				$pwd = md5($reset);
				if ($this->UserModel->edit_password($this->input->post('id'),$pwd)) {
					$this->session->set_flashdata('pwd',$reset);
					$status = "Password Berhasil Direset!";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/data_user'));
				}else{
					$status = "Password Gagal Direset! Terdapat Kesalahan Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/data_user'));
				}
				/* $ reset = reset password */
				/* kembali ke halaman setting akun */
			}else{
				$status = "Password Tidak Cocok! Silahkan Ulangi";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/data_user'));
			}
		}
	}

	public function edit_akun()
	{
		$this->form_validation->set_rules('username', 'Uname', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/setting_akun'));
		}else{
			$this->load->model('UserModel');
			$polaemail = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";

			/* cek ketersediaan username */
			if ($this->input->post('username') != $this->session->userdata('SESS_USERNAME') && $this->UserModel->cek_username($this->input->post('username'))) {
				$status = "Data User Gagal Diubah! Username Telah Digunakan";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/setting_akun'));
			}
			/* cek panjang karakter username */
			else if(strlen($this->input->post('username')) < 4){
				$status = "Data User Gagal Diubah! Username Harus Lebih Dari 4 Huruf";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/setting_akun'));
			}
			/* cek format email */
			else if(!preg_match($polaemail, $this->input->post('email'))){
				$status = "Data User Gagal Diubah! Format Email Salah";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/setting_akun'));
			}else{
				$data = array(
								'username' => $this->input->post('username'),
				 				'email' => $this->input->post('email')
				 			);
				if ($this->UserModel->edit_user($data)) {
					$sess = array('SESS_USERNAME' => $this->input->post('username'));
					$this->session->set_userdata( $sess );
					$status = "Data User Berhasil Diubah!";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/setting_akun'));
				}else{
					$status = "Data User Gagal Diubah! Terjadi Kesalahan Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/setting_akun'));
				}
			}
		}
	}

	public function edit_pwd()
	{
		$this->form_validation->set_rules('pwd_old', 'old', 'required');
		$this->form_validation->set_rules('pwd_new', 'new', 'required');
		$this->form_validation->set_rules('pwd_conf', 'conf', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('backend/profile'));
		}else{
			$pwd = md5($this->input->post('pwd_old'));
			$this->load->model('UserModel');
			if ($this->input->post('pwd_new') != $this->input->post('pwd_conf')) {
				$error = 'Konfirmasi Password Baru Tidak Sesuai! Silahkan Ulangi';
				$this->session->set_flashdata('error', $error);
				redirect(base_url('Home/setting_akun'));
			}elseif ($this->UserModel->cek_pass() != $pwd) {
				$error = 'Password Lama Salah! Silahkan Ulangi';
				$this->session->set_flashdata('error', $error);
				redirect(base_url('Home/setting_akun'));
			}else{
				$pwd_new = md5($this->input->post('pwd_new'));
				$data = array('password' => $pwd_new );
				if ($this->UserModel->edit_pwd($data)) {
					$success = 'Password Berhasil Diubah!';
					$this->session->set_flashdata('success', $success);
					redirect(base_url('Home/setting_akun'));
				}else{
					$error = 'Password Gagal Diubah! Silahkan Ulangi!';
					$this->session->set_flashdata('error', $error);
					redirect(base_url('Home/setting_akun'));
				}
			}
		}
	}

	/* edit user */
	public function edit_user($value='')
	{
		$this->form_validation->set_rules('id', 'Id', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/data_user'));
		}else{
			$this->load->model('UserModel');
			if ($value == "kelola") {
				$query = $this->UserModel->select_username($this->input->post('id'))->username != $this->input->post('username') && $this->UserModel->cek_username($this->input->post('username'));
			}else{
				$query = $this->input->post('username') != $this->session->userdata('SESS_USERNAME') && $this->UserModel->cek_username($this->input->post('username'));
			}
			if ($query) {
				$status = "Data User Gagal Diubah! Username Telah Digunakan";
				$this->session->set_flashdata('error', $status);
				if ($value === "kelola") {
					redirect(base_url('Home/data_user'));
				}else{
					redirect(base_url('Home/setting_akun/'.$this->session->userdata('SESS_USER_ID')));
				}
			}elseif( strlen($this->input->post('username')) < 4){
				$status = "Data User Gagal Diubah! Username Harus Lebih Dari 4 Huruf";
				$this->session->set_flashdata('error', $status);
				if ($value === "kelola") {
					redirect(base_url('Home/data_user'));
				}else{
					redirect(base_url('Home/setting_akun/'.$this->session->userdata('SESS_USER_ID')));
				}
			}else{
				$username = $this->UserModel->edit_username($this->input->post('id'),$this->input->post('username'),$this->input->post('email'));
				$hak = $this->input->post('hak_akses');
				$pwd = md5($this->input->post('passNew'));
				if (isset($hak) && $hak != '') {
					$st = $this->UserModel->edit_hak_akses($this->input->post('id'),$hak);
				}else{
					$st = "do nothing";
				}
				if ($value !== "kelola") {
					if ($this->input->post('passNew') !== '') {
						$pass = $this->UserModel->edit_password($this->input->post('id'),$pwd);
					}else{
						$pass = "do nothing";
					}
				}else{
					$pass = "do nothing";
				}
				if ($username && $st) {
					$status = "Data User Berhasil Diubah!";
					$this->session->set_flashdata('success', $status);
					if ($value === "kelola") {
						redirect(base_url('Home/data_user'));
					}else{
						$data = array(
							'SESS_USERNAME' => $this->input->post('username')
						);
						
						$this->session->set_userdata( $data );
						redirect(base_url('Home/setting_akun/'.$this->session->userdata('SESS_USER_ID')));
					}
				}else{
					$status = "Data User Gagal Diubah! Terdapat Kesalahan Sistem";
					$this->session->set_flashdata('error', $status);
					if ($value === "kelola") {
						redirect(base_url('Home/data_user'));
					}else{
						redirect(base_url('Home/setting_akun/'.$this->session->userdata('SESS_USER_ID')));
					}
				}
				
			}
		}
	}

	/* delete user */
	public function delete_user()
	{
		$this->form_validation->set_rules('id', 'Id', 'required');
		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/data_user'));
		}else{
			/* cek password */
			$this->load->model('LoginModel');
			$pass = $this->LoginModel->select_pass($this->session->userdata('SESS_USER_ID'))->password;
			/* jika password benar */
			if (md5($this->input->post('pwver')) === $pass) {
				$this->load->model('UserModel');
				if ($this->UserModel->delete_user($this->input->post('id'))) {
					$status = "Data User Berhasil Dihapus!";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/data_user'));
				}else{
					$status = "Data User Gagal Dihapus! Terdapat Kesalahan Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/data_user'));
				}
			}else{
				$status = "Password Tidak Cocok! Silahkan Ulangi";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/data_user'));
			}
		}
	}

	/* DAFTAR PEKERJAAN*/

	/* lihat daftar pekerjaan */
	public function daftar_pekerjaan($value="Notaris")
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();

		// load model
		$this->load->model('DaftarPekerjaanModel');
		$this->load->model('BerkasModel');

		// load data berdasarkan $value
		$data['list'] = $this->DaftarPekerjaanModel->tabel($value);
		$data['tabel'] = $this->BerkasModel->tabel();
		$data['aktor'] = $value;
		// load view
		$this->load->view('global/header',$this->data);
		$this->load->view('daftar_pekerjaan/list', $data);
		$this->load->view('global/footer');
	}

	/* tambah daftar pekerjaan */
	public function input_daftar_pekerjaan()
	{
		if(is_null($this->input->post('pekerjaan')) || $this->input->post('pekerjaan') == ""){
			$status = "Data Pekerjaan Gagal Ditambah! Nama Pekerjaan Tidak Boleh Kosong";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan/'.$this->input->post('aktor')));
		}else{

			$akta = ($this->input->post('akta') === '') ? $akta = '-' : $akta = $this->input->post('akta');

			$this->load->model('DaftarPekerjaanModel');

			if ($this->DaftarPekerjaanModel->cek_nama_pekerjaan($this->input->post('pekerjaan')) > 0) {
				$status = "Data Pekerjaan Gagal Ditambah! Pekerjaan ".$this->input->post('pekerjaan')." Sudah Terdaftar";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/daftar_pekerjaan/'.$this->input->post('aktor')));
			}else{
				if ($this->DaftarPekerjaanModel->insert($this->input->post('pekerjaan'),$akta,$this->input->post('aktor'))) {
					$status = "Daftar Pekerjaan Berhasil Ditambah";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/daftar_pekerjaan/'.$this->input->post('aktor')));
				}else{
					$status = "Data Pekerjaan Gagal Ditambah! Terdapat Kesalahan Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/daftar_pekerjaan/'.$this->input->post('aktor')));
				}
			}

		}
	}

	/* ubah daftar pekerjaan */
	public function edit_daftar_pekerjaan($value="")
	{
		if (is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data Pekerjaan yang Akan Di Edit";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan'));
		}else{
			if(is_null($this->input->post('pekerjaan')) || $this->input->post('pekerjaan') == ""){
				$status = "Data Pekerjaan Gagal Diubah! Nama Pekerjaan Tidak Boleh Kosong";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/daftar_pekerjaan/'.$this->input->post('aktor')));
			}else{

				$akta = ($this->input->post('akta') === '') ? $akta = '-' : $akta = $this->input->post('akta');

				$this->load->model('DaftarPekerjaanModel');

				if ($this->DaftarPekerjaanModel->edit_daftar_pekerjaan($this->input->post('id'),$this->input->post('pekerjaan'),$akta)) {
					$status = "Daftar Pekerjaan Berhasil Diubah";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/daftar_pekerjaan/'.$value));
				}else{
					$status = "Daftar Pekerjaan Gagal Diubah! Terdapat Kesalahan Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/daftar_pekerjaan/'.$value));
				}

			}
		}
	}

	/* hapus daftar pekerjaan */
	public function delete_daftar_pekerjaan($value="")
	{
		if (is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data Pekerjaan yang Akan Dihapus";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan'));
		}else{
			/* cek password */
			$this->load->model('LoginModel');
			$pass = $this->LoginModel->select_pass($this->session->userdata('SESS_USER_ID'))->password;
			/* jika password benar */
			if (md5($this->input->post('pwver')) === $pass) {

				$this->load->model('DaftarPekerjaanModel');
				/* cek detail */
				// if ($this->DaftarPekerjaanModel->cek_detail($this->input->post('id')) > 0) {
				// 	/* jika ada, tampilkan id detail*/
				// 	$id_detail = $this->DaftarPekerjaanModel->detail($this->input->post('id'));
				// 	foreach ($id_detail as $detail) {
						
				// 		/* cek biaya*/
				// 		if ($this->DaftarPekerjaanModel->cek_biaya($detail->id_detail) > 0) {
				// 			/* jika ada, hapus tiap biaya */
				// 			$delete_biaya = $this->DaftarPekerjaanModel->delete_biaya($detail->id_detail);
				// 		}else{
				// 			$delete_biaya = "do nothing";
				// 		}

				// 		/* hapus tiap detail */
				// 		$delete_detail = $this->DaftarPekerjaanModel->delete_detail($detail->id_detail);
				// 	}
				// }else{
				// 	$delete_detail = "do nothing";
				// 	$delete_biaya = "do nothing";
				// }
				// /* cek syarat */
				// if ($this->DaftarPekerjaanModel->cek_syarat($this->input->post('id')) > 0) {
				// 	/* jika ada, tampilkan id syarat*/
				// 	$id_syarat = $this->DaftarPekerjaanModel->syarat($this->input->post('id'));
				// 	foreach ($id_syarat as $syarat) {
				// 		/* hapus tiap syarat */
				// 		$delete_syarat = $this->DaftarPekerjaanModel->delete_syarat($syarat->id_syarat);
				// 	}
				// }else{
				// 	$delete_syarat = "do nothing";
				// }
				/* hapus pekerjaan */
				$delete_pekerjaan = $this->DaftarPekerjaanModel->delete_daftar_pekerjaan($this->input->post('id'));

				/* jika semua delete berhasil*/
				if ($delete_pekerjaan) {
					$status = "Daftar Pekerjaan Berhasil Dihapus";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/daftar_pekerjaan/'.$value));
				}else{
					$status = "Daftar Pekerjaan Gagal Dihapus! Terdapat Kesalahan Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/daftar_pekerjaan/'.$value));
				}
			}
			/* jika password salah */
			else{
				/* kembali ke halaman daftar pekerjaan status error password */
				$status = "Password Tidak Cocok! Silahkan Ulangi";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/daftar_pekerjaan/'.$value));
			}
		}
	}

	/* lihat detail pekerjaan + syarat pekerjaan */
	public function detail_pekerjaan($aktor="",$nama="",$value="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data Pekerjaan";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan'));
		}else{
			$this->load->view('global/header', $this->data);
			$this->load->model('DaftarPekerjaanModel');
			$data['aktor'] = $aktor;
			$data['nama'] = urldecode($nama);
			$data['id'] = $value;
			if ($this->DaftarPekerjaanModel->cek_detail($value) > 0) {
				$data['detail'] = $this->DaftarPekerjaanModel->detail($value);
			}else{
				$data['detail'] = "kosong";
			}
			if ($this->DaftarPekerjaanModel->cek_syarat($value) > 0){
				$data['syaratPkj'] = $this->DaftarPekerjaanModel->syarat($value);
			}else{
				$data['syaratPkj'] = "kosong";
			}
			$this->load->view('daftar_pekerjaan/detail_pekerjaan', $data);
			$this->load->view('global/footer');
		}
	}

	/* tambah detail pekerjaan */
	public function input_detail_pekerjaan($aktor="",$nama="",$value="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data yang Akan Di Edit";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan'));
		}else{
			if (is_null($this->input->post('detail')) || $this->input->post('detail') == "") {
				$status = "Data Pekerjaan Gagal Ditambah! Detail Pekerjaan Tidak Boleh Kosong";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
			}else{

				$this->load->model('DaftarPekerjaanModel');
				$this->load->model('PekerjaanModel');

				$idmax = $this->DaftarPekerjaanModel->max_id_detail($value)->id_detail;

				if (is_null($idmax)) {
					$idnew = $value.'01';
				}else{
					$idnew = $idmax+1;
				}

				$insert_detail = $this->DaftarPekerjaanModel->insert_detail($idnew,$value,$this->input->post('detail'));
				/* select id berkas berdasarkan id pekerjaan */
				if ($this->PekerjaanModel->cek_id_pkj($value) > 0) {
					$id_berkas = $this->PekerjaanModel->select_id_pkj($value);
					for ($i=0; $i < count($id_berkas); $i++) { 
						foreach ($id_berkas as $berkas) {
							$a[] = $berkas->id_berkas;
							$brks[$i]['id_detail'] = $idnew;
							$brks[$i]['id_berkas'] = $a[$i];
						}
					}
					$insert_berkas = $this->PekerjaanModel->insert_stat_detail($brks);
					if ($this->input->post('biaya') != '') {
						$insert_biaya_berkas = $this->PekerjaanModel->insert_stat_biaya($brks);
					}else{
						$insert_biaya_berkas = "do nothing";
					}
				}else{
					$insert_berkas = "do nothing";
					$insert_biaya_berkas = "do nothing";
				}

				if ($this->input->post('biaya') != '') {
					$insert_biaya = $this->DaftarPekerjaanModel->insert_biaya($idnew,$value,$this->input->post('biaya'));
				}else{
					$insert_biaya = "do nothing";
				}

				if ($insert_detail && $insert_biaya && $insert_berkas && $insert_biaya_berkas) {
					$status = "Detail Pekerjaan Berhasil Ditambah";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}else{
					$status = "Data Pekerjaan Gagal Ditambah! Terdapat Kesalahan Pada Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}

			}
		}
	}

	/* ubah detail pekerjaan */
	public function edit_detail_pekerjaan($aktor="",$nama="",$value="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data yang Akan Di Edit";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan'));
		}else{
			if (is_null($this->input->post('detail')) || $this->input->post('detail') == "") {
				$status = "Data Pekerjaan Gagal Diubah! Detail Pekerjaan Tidak Boleh Kosong";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
			}else{

				$this->load->model('DaftarPekerjaanModel');
				$this->load->model('PekerjaanModel');

				/* ubah langkah pekerjaan */
				$edit_detail = $this->DaftarPekerjaanModel->edit_detail($this->input->post('id'),$this->input->post('detail'));

				/* select id berkas berdasarkan id pekerjaan */
				if ($this->PekerjaanModel->cek_id_pkj($value) > 0) {
					$id_berkas = $this->PekerjaanModel->select_id_pkj($value);
					for ($i=0; $i < count($id_berkas); $i++) { 
						foreach ($id_berkas as $berkas) {
							$a[] = $berkas->id_berkas;
							$brks[$i]['id_detail'] = $this->input->post('id');
							$brks[$i]['id_berkas'] = $a[$i];
						}
					}
					if ($this->input->post('biaya') != '') {
						if ($this->DaftarPekerjaanModel->cek_biaya($this->input->post('id')) == 0){
							/*tambah status biaya pekerjaan dg id_detail yg dimaksud*/
							$edit_biaya_berkas = $this->PekerjaanModel->insert_stat_biaya($brks);
						}else{
							$edit_biaya_berkas = "do nothing";
						}
					}else{
						if ($this->DaftarPekerjaanModel->cek_biaya($this->input->post('id')) > 0) {
							/*hapus status biaya pekerjaan dg id_detail yg dimaksud*/
							$edit_biaya_berkas = $this->PekerjaanModel->delete_stat_biaya($brks); 
						}else{
							$edit_biaya_berkas = "do nothing";
						}
					}
				}else{
					$edit_biaya_berkas = "do nothing";
				}

				if ($this->input->post('biaya') != '') { /* cek apakah input biaya tidak kosong */
					if ($this->DaftarPekerjaanModel->cek_biaya($this->input->post('id')) > 0 ) { /* cek apakah biaya sudah terdaftar */
						/* ubah biaya yang ada */
						$edit_biaya = $this->DaftarPekerjaanModel->edit_biaya($this->input->post('id'),$this->input->post('biaya'));
					}else{
						/* menambahkan biaya baru */
						$edit_biaya = $this->DaftarPekerjaanModel->insert_biaya($this->input->post('id'),$value,$this->input->post('biaya'));
					}
				}else{
					if ($this->DaftarPekerjaanModel->cek_biaya($this->input->post('id')) > 0 ){
						/* menghapus biaya yang ada */
						$edit_biaya = $this->DaftarPekerjaanModel->delete_biaya($this->input->post('id'));
					}else{
						$edit_biaya = "do nothing";
					}
				}
				if ($edit_detail && $edit_biaya && $edit_biaya_berkas) {
					$status = "Detail Pekerjaan Berhasil Diubah";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}else{
					$status = "Detail Pekerjaan Gagal Diubah";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}
			}
		}
	}

	/* hapus detail pekerjaan */
	public function delete_detail_pekerjaan($aktor="",$nama="",$value="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data yang Akan Di Hapus";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan'));
		}else{
			/* cek password */
			$this->load->model('LoginModel');
			$pass = $this->LoginModel->select_pass($this->session->userdata('SESS_USER_ID'))->password;
			/* jika password benar */
			if (md5($this->input->post('pwver')) === $pass) {
				$this->load->model('DaftarPekerjaanModel');
				$this->load->model('PekerjaanModel');
				/* hapus detail pekerjaan */
				$delete_detail = $this->DaftarPekerjaanModel->delete_detail($this->input->post('id'));

				/* select id berkas berdasarkan id pekerjaan */
				if ($this->PekerjaanModel->cek_id_pkj($value) > 0) {
					$id_berkas = $this->PekerjaanModel->select_id_pkj($value);
					for ($i=0; $i < count($id_berkas); $i++) { 
						foreach ($id_berkas as $berkas) {
							$a[] = $berkas->id_berkas;
							$brks[$i]['id_detail'] = $this->input->post('id');
							$brks[$i]['id_berkas'] = $a[$i];
						}
					}
					$delete_berkas = $this->PekerjaanModel->delete_stat_detail($brks);
					if ($this->DaftarPekerjaanModel->cek_biaya($this->input->post('id')) > 0) {
						$delete_biaya_berkas = $this->PekerjaanModel->delete_stat_biaya($brks);
					}else{
						$delete_biaya_berkas = "do nothing";
					}
				}else{
					$delete_berkas = "do nothing";
					$delete_biaya_berkas = "do nothing";
				}

				if ($this->DaftarPekerjaanModel->cek_biaya($this->input->post('id')) > 0 ) { /* cek apakah biaya sudah terdaftar */
					/* hapus biaya pekerjaan */
					$delete_biaya = $this->DaftarPekerjaanModel->delete_biaya($this->input->post('id'));
				}else{
					$delete_biaya = "do nothing";
				}

				/* jika delete berhasil */
				if ($delete_detail && $delete_biaya && $delete_berkas && $delete_biaya_berkas) {
					$status = "Detail Pekerjaan Berhasil Dihapus";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}
				/* jika delete gagal */
				else{
					$status = "Detail Pekerjaan Gagal Dihapus";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}
			}
			/* jika password salah */
			else{
				/* kembali ke halaman detail pekerjaan status error password */
				$status = "Password Tidak Cocok! Silahkan Ulangi";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
			}
		}
	}

	/* tambah syarat pekerjaan */
	public function input_syarat_pekerjaan($aktor="",$nama="",$value="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data yang Akan Di Tambah";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan'));
		}else{
			if (is_null($this->input->post('detail')) || $this->input->post('syarat') == "") {
				$status = "Data Pekerjaan Gagal Ditambah! Syarat Pekerjaan Tidak Boleh Kosong";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
			}else{

				$this->load->model('DaftarPekerjaanModel');

				$idmax = $this->DaftarPekerjaanModel->max_id_syarat($value)->id_syarat;

				if (is_null($idmax)) {
					$idnew = $value.'01';
				}else{
					$idnew = $idmax+1;
				}

				$insert_syarat = $this->DaftarPekerjaanModel->insert_syarat($idnew,$value,$this->input->post('syarat'));

				if ($insert_syarat) {
					$status = "Syarat Pekerjaan Berhasil Ditambah";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}else{
					$status = "Syarat Pekerjaan Gagal Ditambah";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}

			}
		}
	}
	/* ubah syarat pekerjaan */
	public function edit_syarat_pekerjaan($aktor="",$nama="",$value="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data yang Akan Di Edit";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan'));
		}else{
			if (is_null($this->input->post('syarat')) || $this->input->post('syarat') == "") {
				$status = "Data Pekerjaan Gagal Diubah! Syarat Pekerjaan Tidak Boleh Kosong";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
			}else{
				$this->load->model('DaftarPekerjaanModel');

				/* ubah langkah pekerjaan */
				$edit_syarat = $this->DaftarPekerjaanModel->edit_syarat($this->input->post('id'),$this->input->post('syarat'));

				if ($edit_syarat) {
					$status = "Syarat Pekerjaan Berhasil Diubah";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}else{
					$status = "Syarat Pekerjaan Gagal Diubah";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}
			}
		}
	}

	/* hapus syarat pekerjaan */
	public function delete_syarat_pekerjaan($aktor="",$nama="",$value="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data yang Akan Di Hapus";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_pekerjaan'));
		}else{
			/* cek password */
			$this->load->model('LoginModel');
			$pass = $this->LoginModel->select_pass($this->session->userdata('SESS_USER_ID'))->password;
			/* jika password benar */
			if (md5($this->input->post('pwver')) === $pass) {
				$this->load->model('DaftarPekerjaanModel');
				/* hapus detail pekerjaan */
				$delete_syarat = $this->DaftarPekerjaanModel->delete_syarat($this->input->post('id'));

				/* jika delete berhasil */
				if ($delete_syarat) {
					$status = "Syarat Pekerjaan Berhasil Dihapus";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}
				/* jika delete gagal */
				else{
					$status = "Syarat Pekerjaan Gagal Dihapus";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
				}
			}
			/* jika password salah */
			else{
				/* kembali ke halaman detail pekerjaan status error password */
				$status = "Password Tidak Cocok! Silahkan Ulangi";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/detail_pekerjaan/'.$aktor.'/'.$nama.'/'.$value));
			}
		}
	}

	/* KLIEN */

	public function daftar_klien()
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();

		$this->load->model('KlienModel');
 
		$config['base_url'] = base_url().'Home/daftar_klien/';
		$config['per_page'] = 10;
		$dari = $this->uri->segment('3');
		$config['uri_segment'] = $dari;
		$config['cur_page'] = $dari;
		$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="previous">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo Prev';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next &raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
		
			/* jika jalan search */
		$this->form_validation->set_rules('search_klien', 'Search', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['tipe'] = "kosong";
			$data['search'] = "kosong";
			$jumlah = $this->KlienModel->jumlah();
			$config['total_rows'] = $jumlah;
			$choice = $config['total_rows'] / $config['per_page'];
	        $config['num_links'] = ceil($choice);
			$data['list'] = $this->KlienModel->tabel($config['per_page'],$dari);
			$this->pagination->initialize($config); 
		}
		else {
			$data['tipe'] = "search";
			$data['search'] = $this->input->post('search_klien');
			if ($this->KlienModel->cek_search($this->input->post('search_klien')) > 0) {
				$data['list'] = $this->KlienModel->search($this->input->post('search_klien'));
			}else{
				$data['list'] = "kosong";
			}
		}

		$data['links'] = $this->pagination->create_links();

		$this->load->view('global/header',$this->data);
		$this->load->view('daftar_klien/klien',$data);
		$this->load->view('global/footer');	
	}

	/* tampilkan halaman tambah klien */
	public function tambah_klien()
	{
		$this->load->view('global/header',$this->data);
		$this->load->view('daftar_klien/tambah_klien');
		$this->load->view('global/footer');
	}

	/* tampilkan halaman edit klien */
	public function edit_klien($value="")
	{
		if(is_null($value) || $value == ''){
			$status = "Pilih Terlebih Dahulu Data yang Akan Di Edit";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_klien'));
		}else{
			$this->load->model('KlienModel');
			if ($this->KlienModel->select_ktp($value) > 0) {
				$this->load->view('global/header',$this->data);
				$data['list'] = $this->KlienModel->select_klien($value);
				$this->load->view('daftar_klien/edit_klien',$data);
				$this->load->view('global/footer');
			}else{
				$status = "Data Tidak Ditemukan!";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/daftar_klien'));
			}
		}
	}

	/* tambah data klien */
	public function input_klien()
	{
		$this->form_validation->set_rules('ktp', 'KTP', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('jalan', 'Jalan', 'required');
		$this->form_validation->set_rules('rt', 'RT', 'required');
		$this->form_validation->set_rules('rw', 'RW', 'required');
		$this->form_validation->set_rules('kel', 'Kel', 'required');
		$this->form_validation->set_rules('kec', 'Kec', 'required');
		$this->form_validation->set_rules('kota', 'Kota', 'required');
		$this->form_validation->set_rules('prov', 'Prov', 'required');

		if ($this->form_validation->run() === FALSE) {
			$status = "Data Klien Gagal Ditambah! Lengkapi Form Terlebih Dahulu";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/tambah_klien'));
		}else{
			$biodata = array('ktp' => $this->input->post('ktp'),
		 					'nama' => $this->input->post('nama'),
		 					'jalan' => $this->input->post('jalan'),
		 					'rt' => $this->input->post('rt'),
		 					'rw' => $this->input->post('rw'),
		 					'kec' => $this->input->post('kec'),
		 					'kel' => $this->input->post('kel'),
		 					'kota' => $this->input->post('kota'),
		 					'prov' => $this->input->post('prov'),
		 					'hp' => $this->input->post('hp'),
		 					'email' => $this->input->post('email'));
			$this->load->model('KlienModel');
			/* cek nomor ktp sudah ada apa belum */
			if($this->KlienModel->select_ktp($this->input->post('ktp')) > 0){
				/* sudah ada */
				$status = "Data Klien Gagal Ditambah! KTP Sudah Terdaftar";
				$this->session->set_flashdata('error', $status);
				$this->session->set_flashdata($biodata);
				redirect(base_url('Home/tambah_klien/'));
			}else{
				/* tidak ada */
				if ($this->input->post('email') != NULL) {
					$polaemail = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
					if (!preg_match($polaemail, $this->input->post('email'))){
						$status = "Data Klien Gagal Ditambah! Format Email Salah";
						$this->session->set_flashdata('error', $status);
						$this->session->set_flashdata($biodata);
						redirect(base_url('Home/tambah_klien/'));
					}else{
						if ($this->KlienModel->insert($this->input->post('ktp'),
													$this->input->post('nama'),
													$this->input->post('jalan'),
													$this->input->post('rt'),
													$this->input->post('rw'),
													$this->input->post('kec'),
													$this->input->post('kel'),
													$this->input->post('kota'),
													$this->input->post('prov'),
													$this->input->post('hp'),
													$this->input->post('email')))
						{
							$status = "Data Klien Berhasil Ditambah";
							$this->session->set_flashdata('success', $status);
							redirect(base_url('Home/daftar_klien/'));
						}else{
							$status = "Data Klien Gagal Ditambah! Terdapat Kesalahan pada Sistem";
							$this->session->set_flashdata('error', $status);
							$this->session->set_flashdata($biodata);
							redirect(base_url('Home/tambah_klien/'));
						}
					}
				}else{
					if ($this->KlienModel->insert($this->input->post('ktp'),
												$this->input->post('nama'),
												$this->input->post('jalan'),
												$this->input->post('rt'),
												$this->input->post('rw'),
												$this->input->post('kec'),
												$this->input->post('kel'),
												$this->input->post('kota'),
												$this->input->post('prov'),
												$this->input->post('hp'),
												$this->input->post('email')))
					{
						$status = "Data Klien Berhasil Ditambah";
						$this->session->set_flashdata('success', $status);
						redirect(base_url('Home/daftar_klien/'));
					}else{
						$status = "Data Klien Gagal Ditambah! Terdapat Kesalahan pada Sistem";
						$this->session->set_flashdata('error', $status);
						$this->session->set_flashdata($biodata);
						redirect(base_url('Home/daftar_klien/'));
					}
				}
			}
		}
	}

	/* ubah data klien */
	public function ubah_klien()
	{
		$this->form_validation->set_rules('id', 'ID', 'required');
		$this->form_validation->set_rules('ktp', 'KTP', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('jalan', 'Jalan', 'required');
		$this->form_validation->set_rules('rt', 'RT', 'required');
		$this->form_validation->set_rules('rw', 'RW', 'required');
		$this->form_validation->set_rules('kel', 'Kel', 'required');
		$this->form_validation->set_rules('kec', 'Kec', 'required');
		$this->form_validation->set_rules('kota', 'Kota', 'required');
		$this->form_validation->set_rules('prov', 'Prov', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/edit_klien/'.$this->input->post('id')));
		}else{
			$this->load->model('KlienModel');

			if ($this->KlienModel->update(
										$this->input->post('id'),	
										$this->input->post('ktp'),
										$this->input->post('nama'),
										$this->input->post('jalan'),
										$this->input->post('rt'),
										$this->input->post('rw'),
										$this->input->post('kec'),
										$this->input->post('kel'),
										$this->input->post('kota'),
										$this->input->post('prov'),
										$this->input->post('hp'),
										$this->input->post('email')))
			{
				$status = "Data Klien Berhasil Diubah";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/daftar_klien/'));
			}else{
				$status = "Data Klien Gagal Diubah! Terdapat Kesalahan pada Sistem";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/daftar_klien/'));
			}
		}
	}

	/* hapus data klien */
	public function delete_klien()
	{
		/* cek password */
		$this->load->model('LoginModel');
		$pass = $this->LoginModel->select_pass($this->session->userdata('SESS_USER_ID'))->password;
		/* jika password benar */
		if (md5($this->input->post('pwver')) === $pass) {

			$this->load->model('KlienModel');
			if ($this->KlienModel->delete($this->input->post('id'))) {
				$status = "Data Klien Berhasil Dihapus";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/daftar_klien'));
			}else{
				$status = "Data Klien Gagal Dihapus! Terdapat Kesalahan pada Sistem";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/daftar_klien'));
			}
		}
		/* jika password salah */
		else{
			/* kembali ke halaman detail pekerjaan status error password */
			$status = "Password Tidak Cocok! Silahkan Ulangi";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_klien'));
		}
	}

	/* DATA TANAH*/

	/* lihat daftar tanah */
	public function daftar_tanah()
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();
		
		$this->load->model('TanahModel');

		$config['base_url'] = base_url().'Home/daftar_tanah/';
		$config['per_page'] = 10;
		$dari = $this->uri->segment('3');
		$config['uri_segment'] = $dari;
		$config['cur_page'] = $dari;
		$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="previous">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo Prev';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next &raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
			/* jika jalan search */
		$this->form_validation->set_rules('search_tanah', 'Search', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['tipe'] = "kosong";
			$data['search'] = "kosong";
			$jumlah = $this->TanahModel->jumlah();
			$config['total_rows'] = $jumlah;
			$choice = $config['total_rows'] / $config['per_page'];
	        $config['num_links'] = ceil($choice);
			$data['list'] = $this->TanahModel->table($config['per_page'],$dari);
			$this->pagination->initialize($config); 
		}
		else {
			$data['tipe'] = "search";
			$data['search'] = $this->input->post('search_tanah');
			if ($this->TanahModel->cek_search($this->input->post('search_tanah')) > 0) {
				$data['list'] = $this->TanahModel->search($this->input->post('search_tanah'));
			}else{
				$data['list'] = "kosong";
			}
		}
		$data['links'] = $this->pagination->create_links();
		$this->load->view('global/header',$this->data);
		$this->load->view('daftar_tanah/daftar_tanah',$data);
		$this->load->view('global/footer');
	}
	/* halaman tambah tanah*/
	public function tambah_tanah()
	{
		$this->load->model('KlienModel');
		$data['klien'] = $this->KlienModel->tabel();
		$this->load->view('global/header',$this->data);
		$this->load->view('daftar_tanah/tambah_tanah',$data);
		$this->load->view('global/footer');
	}

	/* halaman edit tanah*/
	public function edit_tanah($value="")
	{
		if (is_null($value) || $value == '') {
			$status = "Pilih Terlebih Dahulu Data yang Akan Di Edit";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_tanah'));
		}else{
			$this->load->model('TanahModel');

			if ($this->TanahModel->cek_tanah($value) > 0) {
				$this->load->model('KlienModel');
				$data['pemilik'] = $this->KlienModel->select_klien($this->TanahModel->select_tanah($value)->id_pemegang_hak);
				$data['tanah'] = $this->TanahModel->select_tanah($value);
				$data['klien'] = $this->KlienModel->tabel();
				$this->load->view('global/header',$this->data);
				$this->load->view('daftar_tanah/edit_tanah',$data);
				$this->load->view('global/footer');
			}else{
				$status = "Data Tidak Ditemukan! Silahkan Pilih Data Tanah yang Lain";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/daftar_tanah'));
			}
		}
	}

	/* tambah data tanah */
	public function input_tanah()
	{
		$this->form_validation->set_rules('hak', 'Hak', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('jenis', 'Jenis', 'required');
		$this->form_validation->set_rules('jalan', 'Jalan', 'required');
		$this->form_validation->set_rules('rt', 'RT', 'required');
		$this->form_validation->set_rules('rw', 'RW', 'required');
		$this->form_validation->set_rules('kel', 'Kel', 'required');
		$this->form_validation->set_rules('kec', 'Kec', 'required');
		$this->form_validation->set_rules('kota', 'Kota', 'required');
		$this->form_validation->set_rules('prov', 'Prov', 'required');
		$this->form_validation->set_rules('luas', 'Luas', 'required');

		if ($this->form_validation->run() === FALSE) {
			$status = "Data Tanah Gagal Ditambah! Lengkapi Form Terlebih Dahulu";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/tambah_tanah'));
		}else{
			$this->load->model('TanahModel');
			$biodata = array('hak' => $this->input->post('hak'),
		 					'nama' => $this->input->post('nama'),
		 					'jenis' => $this->input->post('jenis'),
		 					'jalan' => $this->input->post('jalan'),
		 					'rt' => $this->input->post('rt'),
		 					'rw' => $this->input->post('rw'),
		 					'kec' => $this->input->post('kec'),
		 					'kel' => $this->input->post('kel'),
		 					'kota' => $this->input->post('kota'),
		 					'prov' => $this->input->post('prov'),
		 					'luas' => $this->input->post('luas'));
			/* cek nomor hak sudah ada apa belum */
			if($this->TanahModel->cek_hak($this->input->post('hak')) > 0){
				/* sudah ada */
				$status = "Data Tanah Gagal Ditambah! Nomor Hak Sudah Terdaftar";
				$this->session->set_flashdata('error', $status);
				$this->session->set_flashdata($biodata);
				redirect(base_url('Home/tambah_tanah'));
			}else{
				/* tidak ada */
				if ($this->TanahModel->insert($this->input->post('hak'),
											$this->input->post('nama'),
											$this->input->post('jenis'),
											$this->input->post('jalan'),
											$this->input->post('rt'),
											$this->input->post('rw'),
											$this->input->post('kec'),
											$this->input->post('kel'),
											$this->input->post('kota'),
											$this->input->post('prov'),
											$this->input->post('luas')))
				{
					$status = "Data Tanah Berhasil Ditambah";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/daftar_tanah'));
				}else{
					$status = "Data Tanah Gagal Ditambah! Terdapat Kesalahan pada Sistem";
					$this->session->set_flashdata('error', $status);
					$this->session->set_flashdata($biodata);
					redirect(base_url('Home/tambah_tanah'));
				}
			}
		}
	}

	/* ubah data tanah*/
	public function ubah_tanah()
	{
		$this->form_validation->set_rules('id', 'ID', 'required');
		$this->form_validation->set_rules('hak', 'Hak', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('jenis', 'Jenis', 'required');
		$this->form_validation->set_rules('jalan', 'Jalan', 'required');
		$this->form_validation->set_rules('rt', 'RT', 'required');
		$this->form_validation->set_rules('rw', 'RW', 'required');
		$this->form_validation->set_rules('kel', 'Kel', 'required');
		$this->form_validation->set_rules('kec', 'Kec', 'required');
		$this->form_validation->set_rules('kota', 'Kota', 'required');
		$this->form_validation->set_rules('prov', 'Prov', 'required');
		$this->form_validation->set_rules('luas', 'Luas', 'required');

		if ($this->form_validation->run() === FALSE) {
			$status = "Data Tanah Gagal Ditambah! Lengkapi Form Terlebih Dahulu";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/tambah_tanah'));
		}else{
			$this->load->model('TanahModel');

			if ($this->TanahModel->update($this->input->post('id'),
											$this->input->post('hak'),
											$this->input->post('nama'),
											$this->input->post('jenis'),
											$this->input->post('jalan'),
											$this->input->post('rt'),
											$this->input->post('rw'),
											$this->input->post('kec'),
											$this->input->post('kel'),
											$this->input->post('kota'),
											$this->input->post('prov'),
											$this->input->post('luas')))
			{
				$status = "Data Tanah Berhasil Diubah";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/daftar_tanah/'));
			}else{
				$status = "Data Tanah Gagal Diubah! Terdapat Kesalahan pada Sistem";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/daftar_tanah/'));
			}
		}
	}

	/* hapus data tanah */
	public function delete_tanah()
	{
		/* cek password */
		$this->load->model('LoginModel');
		$pass = $this->LoginModel->select_pass($this->session->userdata('SESS_USER_ID'))->password;
		/* jika password benar */
		if (md5($this->input->post('pwver')) === $pass) {

			$this->load->model('TanahModel');
			if ($this->TanahModel->delete($this->input->post('id'))) {
				$status = "Data Tanah Berhasil Dihapus";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/daftar_tanah'));
			}else{
				$status = "Data Tanah Gagal Dihapus! Terdapat Kesalahan pada Sistem";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/daftar_tanah'));
			}
		}
		/* jika password salah */
		else{
			/* kembali ke halaman detail pekerjaan status error password */
			$status = "Password Tidak Cocok! Silahkan Ulangi";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/daftar_tanah'));
		}
	}

	/* PEKERJAAN BARU */
	public function baru($aktor="",$value="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($value) || $value == '') {
			redirect(base_url('Home'));
		}else{
			$this->load->model('PekerjaanModel');
			$this->load->model('DaftarPekerjaanModel');
			

			$nama = urldecode($value);
			$id_pkj = $this->DaftarPekerjaanModel->id_pekerjaan($nama)->id_pekerjaan;

			if ($this->DaftarPekerjaanModel->cek_syarat($id_pkj) > 0) {
				$data['syarat'] = $this->DaftarPekerjaanModel->syarat($id_pkj);
			}else{
				$data['syarat'] = "kosong";
			}

			$data['pkj'] = $nama;
			$data['aktor'] = $aktor;			
			$this->load->view('global/header',$this->data);
			$this->load->view('pekerjaan/pekerjaan_baru',$data);
			$this->load->view('global/footer');
		}
	}

	/* halaman tambah klien pekerjaan baru*/
	public function tmb_klien_pkj($aktor="",$nama="",$tipe="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($tipe) || $tipe == '') {
			redirect(base_url('Home'));
		}else{
			$data['aktor'] = $aktor;
			$data['nama'] = $nama;
			$data['tipe'] = $tipe;
			$this->load->view('global/header',$this->data);
			$this->load->view('pekerjaan/tambah_klien',$data);
			$this->load->view('global/footer');
		}
	}

	/* halaman ambil klien pekerjaan baru */
	public function ambil_klien_pkj($aktor="",$nama="",$tipe="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($tipe) || $tipe == '') {
			redirect(base_url('Home'));
		}else{
			$this->load->model('KlienModel');

			$config['base_url'] = base_url().'Home/ambil_klien_pkj/'.$aktor.'/'.$nama.'/'.$tipe.'/';
			$config['per_page'] = 10;
			$dari = $this->uri->segment('6');
			$config['uri_segment'] = $dari;
			$config['cur_page'] = $dari;
			$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
	        $config['full_tag_close'] = '</ul></div>';
	        $config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="previous">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo Prev';
	        $config['prev_tag_open'] = '<li class="prev page">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';

			/* jika jalan search */
			$this->form_validation->set_rules('search_klien', 'Search', 'required');

			if ($this->form_validation->run() === FALSE) {
				$data['query'] = "kosong";
				$data['search'] = "kosong";
				$jumlah = $this->KlienModel->jumlah();
				$config['total_rows'] = $jumlah;
				$choice = $config['total_rows'] / $config['per_page'];
		        $config['num_links'] = ceil($choice);
				$data['list'] = $this->KlienModel->tabel($config['per_page'],$dari);
				$this->pagination->initialize($config); 
			}
			else {
				$data['query'] = "search";
				$data['search'] = $this->input->post('search_klien');
				if ($this->KlienModel->cek_search($this->input->post('search_klien')) > 0) {
					$data['list'] = $this->KlienModel->search($this->input->post('search_klien'));
				}else{
					$data['list'] = "kosong";
				}
			}

			$data['aktor'] = $aktor;
			$data['nama'] = $nama;
			$data['tipe'] = $tipe;
			$data['links'] = $this->pagination->create_links();
			$this->load->view('global/header',$this->data);
			$this->load->view('pekerjaan/ambil_klien',$data);
			$this->load->view('global/footer');
		}
	}

	/* halaman tambah tanah pekerjaan baru */
	public function tmb_tanah_pkj($aktor="",$nama="",$tipe="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($tipe) || $tipe == '') {
			redirect(base_url('Home'));
		}else{
			$this->load->model('KlienModel');
			$data['klien'] = $this->KlienModel->tabel();
			$data['aktor'] = $aktor;
			$data['nama'] = $nama;
			$data['tipe'] = $tipe;
			$this->load->view('global/header',$this->data);
			$this->load->view('pekerjaan/tambah_tanah',$data);
			$this->load->view('global/footer');
		}
	}

	/* halaman ambil tanah pekerjaan baru */
	public function ambil_tanah_pkj($aktor="",$nama="",$tipe="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($tipe) || $tipe == '') {
			redirect(base_url('Home'));
		}else{
			$this->load->model('TanahModel');

			$config['base_url'] = base_url().'Home/ambil_tanah_pkj/'.$aktor.'/'.$nama.'/'.$tipe.'/';
			$config['per_page'] = 10;
			$dari = $this->uri->segment('6');
			$config['uri_segment'] = $dari;
			$config['cur_page'] = $dari;
			$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
	        $config['full_tag_close'] = '</ul></div>';
	        $config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="previous">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo Prev';
	        $config['prev_tag_open'] = '<li class="prev page">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';


			/* jika jalan search */
			$this->form_validation->set_rules('search_tanah', 'Search', 'required');

			if ($this->form_validation->run() === FALSE) {
				$data['query'] = "kosong";
				$data['search'] = "kosong";
				$jumlah = $this->TanahModel->jumlah();
				$config['total_rows'] = $jumlah;
				$choice = $config['total_rows'] / $config['per_page'];
		        $config['num_links'] = ceil($choice);
				$data['list'] = $this->TanahModel->table($config['per_page'],$dari);
				$this->pagination->initialize($config);
			}
			else {
				$data['query'] = "search";
				$data['search'] = $this->input->post('search_tanah');
				if ($this->TanahModel->cek_search($this->input->post('search_tanah')) > 0) {
					$data['list'] = $this->TanahModel->search($this->input->post('search_tanah'));
				}else{
					$data['list'] = "kosong";
				}
			}

			$data['aktor'] = $aktor;
			$data['nama'] = $nama;
			$data['tipe'] = $tipe;
			$data['links'] = $this->pagination->create_links();
			$this->load->view('global/header',$this->data);
			$this->load->view('pekerjaan/ambil_tanah',$data);
			$this->load->view('global/footer');
		}
	}

	/* tambah klien pekerjaan baru */
	public function input_klien_pkj($aktor="",$nama="",$tipe="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($tipe) || $tipe == '') {
			redirect(base_url('Home'));
		}else{
			$this->form_validation->set_rules('ktp', 'KTP', 'required');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('jalan', 'Jalan', 'required');
			$this->form_validation->set_rules('rt', 'RT', 'required');
			$this->form_validation->set_rules('rw', 'RW', 'required');
			$this->form_validation->set_rules('kel', 'Nama', 'required');
			$this->form_validation->set_rules('kec', 'Nama', 'required');
			$this->form_validation->set_rules('kota', 'Nama', 'required');
			$this->form_validation->set_rules('prov', 'Nama', 'required');

			if ($this->form_validation->run() === FALSE) {
				redirect(base_url('Home/tmb_klien_pkj'));
			}else{
				$this->load->model('KlienModel');
				$biodata = array('ktp' => $this->input->post('ktp'),
			 					'nama' => $this->input->post('nama'),
			 					'jalan' => $this->input->post('jalan'),
			 					'rt' => $this->input->post('rt'),
			 					'rw' => $this->input->post('rw'),
			 					'kec' => $this->input->post('kec'),
			 					'kel' => $this->input->post('kel'),
			 					'kota' => $this->input->post('kota'),
			 					'prov' => $this->input->post('prov'),
			 					'hp' => $this->input->post('hp'),
			 					'email' => $this->input->post('email'));
				/* cek nomor ktp sudah ada apa belum */
				if($this->KlienModel->select_ktp($this->input->post('ktp')) > 0){
					/* sudah ada */
					$status = "Data Klien Gagal Ditambah! KTP Sudah Terdaftar";
					$this->session->set_flashdata('error', $status);
					$this->session->set_flashdata($biodata);
					redirect(base_url('Home/tmb_klien_pkj/'.$aktor.'/'.$nama.'/'.$tipe));
				}else{
					/* tidak ada */
					if ($this->input->post('email') != NULL) {
						$polaemail = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
						if (!preg_match($polaemail, $this->input->post('email'))){
							$status = "Data Klien Gagal Ditambah! Format Email Salah";
							$this->session->set_flashdata('error', $status);
							$this->session->set_flashdata($biodata);
							redirect(base_url('Home/tmb_klien_pkj/'.$aktor.'/'.$nama.'/'.$tipe));
						}else{
							if ($this->KlienModel->insert($this->input->post('ktp'),
														$this->input->post('nama'),
														$this->input->post('jalan'),
														$this->input->post('rt'),
														$this->input->post('rw'),
														$this->input->post('kec'),
														$this->input->post('kel'),
														$this->input->post('kota'),
														$this->input->post('prov'),
														$this->input->post('hp'),
														$this->input->post('email')))
							{
								$status = "Data Klien Berhasil Ditambah";
								$this->session->set_flashdata('success', $status);

								switch ($tipe) {
									case '1':
										$sess = array(
											'SESS_PENJUAL_ID' => $this->input->post('ktp'),
											'SESS_PENJUAL_NAME' => $this->input->post('nama')
										);
										break;

									case '2':
										$sess = array(
											'SESS_PEMBELI_ID' => $this->input->post('ktp'),
											'SESS_PEMBELI_NAME' => $this->input->post('nama')
										);
										break;

									case '3':
										$sess = array(
											'SESS_PEMOHON_ID' => $this->input->post('ktp'),
											'SESS_PEMOHON_NAME' => $this->input->post('nama')
										);
										break;
								}
							
								$this->session->set_userdata($sess);

								redirect(base_url('Home/baru/'.$aktor.'/'.$nama));
							}else{
								$status = "Data Klien Gagal Ditambah! Terdapat Kesalahan pada Sistem";
								$this->session->set_flashdata('error', $status);
								$this->session->set_flashdata($biodata);
								redirect(base_url('Home/tmb_klien_pkj/'.$aktor.'/'.$nama.'/'.$tipe));
							}
						}
					}else{
						if ($this->KlienModel->insert($this->input->post('ktp'),
													$this->input->post('nama'),
													$this->input->post('jalan'),
													$this->input->post('rt'),
													$this->input->post('rw'),
													$this->input->post('kec'),
													$this->input->post('kel'),
													$this->input->post('kota'),
													$this->input->post('prov'),
													$this->input->post('hp'),
													$this->input->post('email')))
						{
							$status = "Data Klien Berhasil Ditambah";
							$this->session->set_flashdata('success', $status);

							switch ($tipe) {
								case '1':
									$sess = array(
										'SESS_PENJUAL_ID' => $this->input->post('ktp'),
										'SESS_PENJUAL_NAME' => $this->input->post('nama')
									);
									break;

								case '2':
									$sess = array(
										'SESS_PEMBELI_ID' => $this->input->post('ktp'),
										'SESS_PEMBELI_NAME' => $this->input->post('nama')
									);
									break;

								case '3':
									$sess = array(
										'SESS_PEMOHON_ID' => $this->input->post('ktp'),
										'SESS_PEMOHON_NAME' => $this->input->post('nama')
									);
									break;
							}
						
							$this->session->set_userdata($sess);

							redirect(base_url('Home/baru/'.$aktor.'/'.$nama));
						}else{
							$status = "Data Klien Gagal Ditambah! Terdapat Kesalahan pada Sistem";
							$this->session->set_flashdata('error', $status);
							$this->session->set_flashdata($biodata);
							redirect(base_url('Home/tmb_klien_pkj/'.$aktor.'/'.$nama.'/'.$tipe));
						}
					}
				}
			}
		}
	}

	/* tambah tanah pekerjaan baru */
	public function input_tanah_pkj($aktor="",$nama="",$tipe="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($tipe) || $tipe == '') {
			redirect(base_url('Home'));
		}else{
			$this->form_validation->set_rules('hak', 'Hak', 'required');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('jalan', 'Jalan', 'required');
			$this->form_validation->set_rules('rt', 'RT', 'required');
			$this->form_validation->set_rules('rw', 'RW', 'required');
			$this->form_validation->set_rules('kel', 'Kel', 'required');
			$this->form_validation->set_rules('kec', 'Kec', 'required');
			$this->form_validation->set_rules('kota', 'Kota', 'required');
			$this->form_validation->set_rules('prov', 'Prov', 'required');
			$this->form_validation->set_rules('luas', 'Luas', 'required');

			if ($this->form_validation->run() === FALSE) {
				redirect(base_url('Home/tmb_tanah_pkj'));
			}else{
				$this->load->model('TanahModel');
				$biodata = array('hak' => $this->input->post('hak'),
		 					'nama' => $this->input->post('nama'),
		 					'jenis' => $this->input->post('jenis'),
		 					'jalan' => $this->input->post('jalan'),
		 					'rt' => $this->input->post('rt'),
		 					'rw' => $this->input->post('rw'),
		 					'kec' => $this->input->post('kec'),
		 					'kel' => $this->input->post('kel'),
		 					'kota' => $this->input->post('kota'),
		 					'prov' => $this->input->post('prov'),
		 					'luas' => $this->input->post('luas'));
				/* cek nomor hak sudah ada apa belum */
				if($this->TanahModel->cek_tanah($this->input->post('hak')) > 0){
					/* sudah ada */
					$status = "Data Tanah Gagal Ditambah! Nomor Hak Sudah Terdaftar";
					$this->session->set_flashdata('error', $status);
					$this->session->set_flashdata($biodata);
					redirect(base_url('Home/tmb_tanah_pkj/'.$aktor.'/'.$nama.'/'.$tipe));
				}else{
					/* tidak ada */
					if ($this->TanahModel->insert($this->input->post('hak'),
											$this->input->post('nama'),
											$this->input->post('jenis'),
											$this->input->post('jalan'),
											$this->input->post('rt'),
											$this->input->post('rw'),
											$this->input->post('kec'),
											$this->input->post('kel'),
											$this->input->post('kota'),
											$this->input->post('prov'),
											$this->input->post('luas')))
					{
						$status = "Data Tanah Berhasil Ditambah";
						$this->session->set_flashdata('success', $status);

						$id_tanah = $this->TanahModel->select_id($this->input->post('hak'))->id_tanah;

						if($tipe === '4') {
							$sess = array(
								'SESS_TANAH_ID' => $id_tanah,
								'SESS_TANAH_NAME' => $this->input->post('hak')
							);
						}
					
						$this->session->set_userdata($sess);

						redirect(base_url('Home/baru/'.$aktor.'/'.$nama));
					}else{
						$status = "Data Tanah Gagal Ditambah! Terdapat Kesalahan pada Sistem";
						$this->session->set_flashdata('error', $status);
						$this->session->set_flashdata('biodata', $biodata);
						redirect(base_url('Home/tmb_tanah_pkj/'.$aktor.'/'.$nama.'/'.$tipe));
					}
				}
			}
		}
	}

	public function take_klien_pkj($aktor="",$nama="",$tipe="",$id="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($tipe) || $tipe == '' || is_null($id) || $id == '') {
			redirect(base_url('Home'));
		}else{
			$this->load->model('KlienModel');
			if ($this->KlienModel->select_ktp($id) > 0) {
				$klien = $this->KlienModel->select_klien($id)->nama_pemohon;

				switch ($tipe) {
					case '1':
						$sess = array(
							'SESS_PENJUAL_ID' => $id,
							'SESS_PENJUAL_NAME' => $klien
						);
						break;

					case '2':
						$sess = array(
							'SESS_PEMBELI_ID' => $id,
							'SESS_PEMBELI_NAME' => $klien
						);
						break;

					case '3':
						$sess = array(
							'SESS_PEMOHON_ID' => $id,
							'SESS_PEMOHON_NAME' => $klien
						);
						break;
				}
			
				$this->session->set_userdata($sess);

				redirect(base_url('Home/baru/'.$aktor.'/'.$nama));
			}else{
				$status = "Data Klien Tidak Ditemukan! Silahkan Pilih Data Lain";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/ambil_klien_pkj/'.$aktor.'/'.$nama.'/'.$tipe));
			}

		}
	}

	public function take_tanah_pkj($aktor="",$nama="",$tipe="",$id="")
	{
		if (is_null($aktor) || $aktor == '' || is_null($nama) || $nama == '' || is_null($tipe) || $tipe == '' || is_null($id) || $id == '') {
			redirect(base_url('Home'));
		}else{
			$this->load->model('TanahModel');
			if ($this->TanahModel->cek_tanah($id) > 0) {
				$tanah = $this->TanahModel->select_tanah($id)->no_hak;

				if ($tipe === '4') {
					$sess = array(
						'SESS_TANAH_ID' => $id,
						'SESS_TANAH_NAME' => $tanah
					);
				}
			
				$this->session->set_userdata($sess);

				redirect(base_url('Home/baru/'.$aktor.'/'.$nama));
			}else{
				$status = "Data Tanah Tidak Ditemukan! Silahkan Pilih Data Lain";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/ambil_tanah_pkj/'.$aktor.'/'.$nama.'/'.$tipe));
			}

		}
	}

	public function reset_data($aktor="",$nama="",$tipe="")
	{
		switch ($tipe) {
			case '1':
				$sess = array(
					'SESS_PENJUAL_ID' => '',
					'SESS_PENJUAL_NAME' => ''
				);
				break;

			case '2':
				$sess = array(
					'SESS_PEMBELI_ID' => '',
					'SESS_PEMBELI_NAME' => ''
				);
				break;

			case '3':
				$sess = array(
					'SESS_PEMOHON_ID' => '',
					'SESS_PEMOHON_NAME' => ''
				);
				break;

			case '4':
				$sess = array(
					'SESS_TANAH_ID' => '',
					'SESS_TANAH_NAME' => ''
				);
				break;
		}
	
		$this->session->unset_userdata($sess);
		redirect(base_url('Home/baru/'.$aktor.'/'.$nama));
	}

	/* input pekerjaan baru */
	public function input_pkj_baru($aktor="",$nama="")
	{
		/* cek session berdasarkan aktor */
		if ($aktor === "Notaris") {
			if ($this->session->userdata('SESS_PEMOHON_ID') && $this->input->post('lokasi') != "") {
				$sess = "complete";
			}else{
				$sess = "uncomplete";
			}
		}else if ($aktor === "PPAT"){
			if ($this->session->userdata('SESS_PEMBELI_ID') && $this->session->userdata('SESS_PENJUAL_ID') && $this->session->userdata('SESS_TANAH_ID') && $this->input->post('lokasi') != "") {
				$sess = "complete";
			}else{
				$sess = "uncomplete";
			}
		}

		if ($sess === "uncomplete") {
			$status = "Pekerjaan Baru Gagal Ditambah! Lengkapi Data Terlebih Dahulu";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/baru/'.$aktor.'/'.$nama));
		}else{
			$this->load->model('DaftarPekerjaanModel');
			$this->load->model('PekerjaanModel');

			$tgl = gmdate('Y-m-d', time()+60*60*7);
			$nama_pekerjaan = urldecode($nama);
			$id_pkj = $this->DaftarPekerjaanModel->id_pekerjaan($nama_pekerjaan)->id_pekerjaan;

			$max_id_berkas = $this->PekerjaanModel->max_id_berkas()->id_berkas;
			if ($max_id_berkas > 0) {
				$new_id_berkas = $max_id_berkas+1;
			}else{
				$new_id_berkas = 1;
			}

			$insert_pertama = $this->PekerjaanModel->insert_pertama($new_id_berkas,$tgl,$this->input->post('lokasi'),$id_pkj,$this->session->userdata('SESS_USER_ID'));
			
			if ($aktor === "Notaris") {
				$stat_pemohon = $this->PekerjaanModel->insert_stat_pemohon($new_id_berkas,$this->session->userdata('SESS_PEMOHON_ID'),"pemohon");
				if ($this->input->post('instansi') != "") {
					$aksi_object = $this->PekerjaanModel->insert_instansi($new_id_berkas,$this->input->post('instansi'));
				}else{
					$aksi_object = "Do Nothing";
				}
				$stat_pembeli = "Do Nothing";
			}else{
				$aksi_object = $this->PekerjaanModel->insert_stat_tanah($new_id_berkas,$this->session->userdata('SESS_TANAH_ID'));
				$stat_pemohon = $this->PekerjaanModel->insert_stat_pemohon($new_id_berkas,$this->session->userdata('SESS_PENJUAL_ID'),"penjual");
				$stat_pembeli = $this->PekerjaanModel->insert_stat_pemohon($new_id_berkas,$this->session->userdata('SESS_PEMBELI_ID'),"pembeli");
			}

			if ($this->DaftarPekerjaanModel->cek_syarat($id_pkj) > 0) {
				$select_syarat = $this->input->post('tmb_syarat');
				$ket_syarat = $this->input->post('tmb_ket_syarat');
				for ($i=0; $i < count($select_syarat); $i++) {
					$syarat[$i]['id_berkas'] = $new_id_berkas; 
					$syarat[$i]['id_ket'] = $i+1;
					$syarat[$i]['syarat'] = $select_syarat[$i];
					$syarat[$i]['ket_syarat'] = $ket_syarat[$i];
				}

				$insert_stat_syarat = $this->PekerjaanModel->insert_stat_syarat($syarat);
			}else{
				$insert_stat_syarat = "do nothing";
			}

			if ($this->DaftarPekerjaanModel->cek_detail($id_pkj) > 0) {
				$select_detail = $this->DaftarPekerjaanModel->detail($id_pkj);
				for ($i=0; $i < count($select_detail); $i++) { 
					foreach($select_detail as $det) {
						$a[] = $det->id_detail;
						$detail[$i]['id_berkas'] = $new_id_berkas;
						$detail[$i]['id_detail'] = $a[$i];
					}
				}

				$insert_stat_detail = $this->PekerjaanModel->insert_stat_detail($detail);
			}else{
				$insert_stat_detail = "do nothing";
			}

			if ($this->DaftarPekerjaanModel->cek_biaya_pekerjaan($id_pkj) > 0) {
				$select_biaya = $this->DaftarPekerjaanModel->select_biaya_pekerjaan($id_pkj);
				for ($i=0; $i < count($select_biaya); $i++) { 
					foreach ($select_biaya as $by) {
						$b[] = $by->id_detail;
						$biaya[$i]['id_berkas'] = $new_id_berkas;
						$biaya[$i]['id_detail'] = $b[$i];
					}
				}
				$insert_stat_biaya = $this->PekerjaanModel->insert_stat_biaya($biaya);
			}else{
				$insert_stat_biaya = "do nothing";
			}

			
			if ($aksi_object && $stat_pemohon && $stat_pembeli && $insert_pertama && $insert_stat_syarat && $insert_stat_detail && $insert_stat_biaya) {
				$status = "Pekerjaan Baru Berhasil Ditambah";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/pkj_pending'));
			}else{
				$status = "Pekerjaan Baru Gagal Ditambah! Terdapat Kesalahan pada Sistem";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/input_pkj_baru/'.$aktor.'/'.$nama));
			}
		}
	}


	/* BERKAS PEKERJAAN */
	public function berkas_pekerjaan($nama_pkj="",$id="")
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();
		
		$this->load->model('BerkasModel');
		$this->load->model('DaftarPekerjaanModel');
		/* jika jalan search */
		$this->form_validation->set_rules('search_berkas', 'Search', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['search'] = "kosong";
			if ($nama_pkj != "") {
				if ($nama_pkj == "undone") {
					if ($this->BerkasModel->cek_berkas_username($this->session->userdata('SESS_USERNAME')) > 0) {
						$list = $this->BerkasModel->select_berkas_username($this->session->userdata('SESS_USERNAME'));
					}else{
						$list = "belum";
						$data['tampil'] = "semua";
					}
					$data['tipe'] = "username";
				}elseif($nama_pkj == "hari"){
					$tgl = gmdate('Y-m-d', time()+60*60*7);
					if ($this->BerkasModel->cek_berkas_hari_ini($tgl) > 0) {
						$list = $this->BerkasModel->select_berkas_hari_ini($tgl);
					}else{
						$list ="belum";
						$data['tampil'] = "semua";
					}
					$data['tipe'] = "hari";
				}elseif($nama_pkj == "selesai"){
					if ($id !== '') {
						if ($this->BerkasModel->update_status_selesai($id)) {
							$status = "Berkas #BKS".$id." Telah Dinyatakan Selesai";
							$this->session->set_flashdata('success', $status);
							redirect(base_url('Home/berkas_pekerjaan'));
						}else{
							$status = "Terjadi Kesalahan Sistem! Silahkan Ulangi";
							$this->session->set_flashdata('error', $status);
							redirect(base_url('Home/berkas_pekerjaan'));
						}
					}else{
						$status = "Tidak Ada Berkas yang Dimaksud!";
						$this->session->set_flashdata('error', $status);
						redirect(base_url('Home/berkas_pekerjaan'));
					}
				}else{
					$url = urldecode($nama_pkj);
					$id_pkj = $this->DaftarPekerjaanModel->id_pekerjaan($url)->id_pekerjaan;
					if ($this->BerkasModel->cek_berkas($id_pkj) > 0) {
						$list = $this->BerkasModel->select_berkas($id_pkj);
					}else{
						$list = "belum";
						$data['tampil'] = "kosong";
					}
					$data['tipe'] = "kosong";
					$data['jp'] = $url;
				}
			}else{
				if ($this->BerkasModel->cek_tabel() > 0) {
					$list = $this->BerkasModel->tabel();
				}else{
					$list = "belum";
					$data['tampil'] = "kosong";

				}
				$data['tipe'] = "kosong";
			}
			$data['list'] = $list;
		}
		else {
			$data['tipe'] = "search";
			$search = $this->input->post('search_berkas');
			if (strpos($search, 'bks') !== FALSE) {
				$search = substr($search, 3);
				$cari = $this->BerkasModel->cek_search_id($search);
				$golek = $this->BerkasModel->search_id($search);
			}else{
				$search = $search;
				$cari = $this->BerkasModel->cek_search($search);
				$golek = $this->BerkasModel->search($search);
			}
			$data['search'] = $this->input->post('search_berkas');
			if ($cari > 0) {
				$data['list'] = $golek;
			}else{
				$data['list'] = "kosong";
			}
		}

		$this->load->view('global/header',$this->data);
		$this->load->view('berkas_pekerjaan/berkas',$data);
		$this->load->view('global/footer');
	}

	public function pkj_pending($value = '',$page='')
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();

		$this->load->model('BerkasModel');
		$config['base_url'] = base_url().'Home/pkj_pending/'.$value.'/';
		$config['per_page'] = 10;
		$dari = $this->uri->segment('3');
		$config['uri_segment'] = $dari;
		$config['cur_page'] = $page;
		$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></div>';
        $config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="previous">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo Prev';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next &raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

		if ($value == "user") {
			if ($this->BerkasModel->cek_pending_user() > 0) {
				$data['list'] = $this->BerkasModel->pending_user();
			}else{
				$data['list'] = "belum";
			}
		}else{
			if ($this->BerkasModel->cek_pending() > 0) {
				$data['list'] = $this->BerkasModel->pending();
			}else{
				$data['list'] = "belum";
			}
		}
		$data['tipe'] = "pending";
		$this->load->view('global/header',$this->data);
		$this->load->view('berkas_pekerjaan/pending',$data);
		$this->load->view('global/footer');
	}

	public function pkj_selesai()
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();

		$this->load->model('BerkasModel');
		if ($this->BerkasModel->cek_selesai() > 0) {
			$data['list'] = $this->BerkasModel->selesai();
		}else{
			$data['list'] = "belum";
		}
		$data['tipe'] = "selesai";
		$this->load->view('global/header', $this->data);
		$this->load->view('berkas_pekerjaan/selesai', $data);
		$this->load->view('global/footer');
	}

	public function set_selesai($value='')
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();

		$this->load->model('BerkasModel');
		if ($this->BerkasModel->set_selesai($value)) {
			$status = "#BKS".$value." Berhasil Ditandai Sebagai Selesai!";
			$this->session->set_flashdata('info', $status);
			redirect(base_url('Home/pkj_selesai'));
		}else{
			$status = "#BKS".$value." Gagal Ditandai Sebagai Selesai! Silahkan Ulangi Lagi";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/pkj_selesai'));
		}
	}

	public function set_biaya_pending()
	{
		$this->form_validation->set_rules('id', 'inputId', 'required');
		$this->form_validation->set_rules('harga', 'inputHarga', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/pkj_pending'));
		}else{
			$this->load->model('BerkasModel');

			if ($this->BerkasModel->update_biaya_klien($this->input->post('id'), $this->input->post('harga'))) {
				$status = "Biaya Klien #BKS".$this->input->post('id')." Berhasil Diubah!";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/pkj_pending'));
			}else{
				$status = "Biaya Klien #BKS".$this->input->post('id')." Gagal Diubah! Silahkan Ulangi Lagi";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/pkj_pending'));
			}
		}
	}

	public function pkj_approve($value='')
	{
		if ($value!= '') {
			$this->load->model('BerkasModel');
			if ($this->BerkasModel->update_status_diterima($value)) {
				$status = "Pekerjaan #BKS".$value." Berhasil Diterima!";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/berkas_pekerjaan'));
			}else{
				$status = "Pekerjaan Gagal Diterima! Silahkan Ulangi Lagi";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/pkj_pending'));
			}
		}else{
			redirect(base_url('Home/pkj_pending'));
		}
	}

	public function edit_berkas_pending($value="",$aksi="")
	{
		if ($value == "") {
			redirect(base_url('Home/pkj_pending'));
		}else{
			$this->load->model('BerkasModel');
			$this->load->model('DaftarPekerjaanModel');

			if ($this->BerkasModel->cek_id_berkas($value) > 0) {

				$data['berkas'] = $this->BerkasModel->select_id_berkas($value);
				$data['id_berkas'] = $value;
				if ($aksi == "pemohon") {
					$data['aksi'] = "pemohon";
					$data['tipe'] = "3";
				}elseif($aksi == "penjual"){
					$data['aksi'] = "penjual";
					$data['tipe'] = "1";
				}elseif($aksi == "pembeli"){
					$data['aksi'] = "pembeli";
					$data['tipe'] = "2";
				}elseif($aksi == "tanah"){
					$data['aksi'] = "tanah";
					$data['tipe'] = "4";
				}else{
					$data['aksi'] = "kosong";
					$data['tipe'] = "kosong";
				}
				$id_pkj = $this->BerkasModel->select_id_berkas($value)->id_pekerjaan;
				$data['stat_syarat'] = $this->BerkasModel->select_syarat_pkj($value);
				$data['syarat'] = $this->DaftarPekerjaanModel->syarat($id_pkj);
				$this->load->view('global/header',$this->data);
				$this->load->view('berkas_pekerjaan/edit_berkas_pending',$data);
				$this->load->view('global/footer');
			}else{
				$status = "Tidak Ada Data";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/pkj_pending'));
			}
		}
	}

	public function edit_berkas($value="",$aksi="")
	{
		if ($value == "") {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->load->model('BerkasModel');
			$this->load->model('DaftarPekerjaanModel');

			if ($this->BerkasModel->cek_id_berkas($value) > 0) {

				$data['berkas'] = $this->BerkasModel->select_id_berkas($value);
				$data['id_berkas'] = $value;
				if ($aksi == "pemohon") {
					$data['aksi'] = "pemohon";
					$data['tipe'] = "3";
				}elseif($aksi == "penjual"){
					$data['aksi'] = "penjual";
					$data['tipe'] = "1";
				}elseif($aksi == "pembeli"){
					$data['aksi'] = "pembeli";
					$data['tipe'] = "2";
				}elseif($aksi == "tanah"){
					$data['aksi'] = "tanah";
					$data['tipe'] = "4";
				}else{
					$data['aksi'] = "kosong";
					$data['tipe'] = "kosong";
				}
				$id_pkj = $this->BerkasModel->select_id_berkas($value)->id_pekerjaan;
				// if ($this->DaftarPekerjaanModel->cek_syarat($id_pkj) > 0) {
					$data['syarat'] = $this->DaftarPekerjaanModel->syarat($id_pkj);
					$data['stat_syarat'] = $this->BerkasModel->select_syarat_pkj($value);
				// }else{
					// $data['syarat'] = "kosong";
					// $data['stat_syarat'] = "kosong";
				// }
				$this->load->view('global/header',$this->data);
				$this->load->view('berkas_pekerjaan/edit_berkas',$data);
				$this->load->view('global/footer');
			}else{
				$status = "Tidak Ada Data";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/berkas_pekerjaan'));
			}
		}
	}

	/* halaman tambah klien berkas */
	public function tmb_klien_berkas($value="",$tipe="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$data['id_berkas'] = $value;
			$data['tipe'] = $tipe;
			$this->load->view('global/header',$this->data);
			$this->load->view('berkas_pekerjaan/tambah_klien',$data);
			$this->load->view('global/footer');
		}
	}

	public function tmb_klien_berkas_pending($value="",$tipe="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/pkj_pending'));
		}else{
			$data['id_berkas'] = $value;
			$data['tipe'] = $tipe;
			$this->load->view('global/header',$this->data);
			$this->load->view('berkas_pekerjaan/tambah_klien_pending',$data);
			$this->load->view('global/footer');
		}
	}

	/* halaman ambil klien edit berkas */
	public function ambil_klien_berkas($value="",$tipe="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->load->model('KlienModel');

			$config['base_url'] = base_url().'Home/ambil_klien_berkas/'.$value.'/'.$tipe.'/';
			$config['per_page'] = 10;
			$dari = $this->uri->segment('5');
			$config['uri_segment'] = $dari;
			$config['cur_page'] = $dari;
			$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
	        $config['full_tag_close'] = '</ul></div>';
	        $config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="previous">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo Prev';
	        $config['prev_tag_open'] = '<li class="prev page">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';

			/* jika jalan search */
			$this->form_validation->set_rules('search_klien', 'Search', 'required');

			if ($this->form_validation->run() === FALSE) {
				$data['query'] = "kosong";
				$data['search'] = "kosong";
				$jumlah = $this->KlienModel->jumlah();
				$config['total_rows'] = $jumlah;
				$choice = $config['total_rows'] / $config['per_page'];
		        $config['num_links'] = ceil($choice);
				$data['list'] = $this->KlienModel->tabel($config['per_page'],$dari);
				$this->pagination->initialize($config);
			}
			else {
				$data['query'] = "search";
				$data['search'] = $this->input->post('search_klien');
				if ($this->KlienModel->cek_search($this->input->post('search_klien')) > 0) {
					$data['list'] = $this->KlienModel->search($this->input->post('search_klien'));
				}else{
					$data['list'] = "kosong";
				}
			}

			$data['id_berkas'] = $value;
			$data['tipe'] = $tipe;
			$data['links'] = $this->pagination->create_links();
			$this->load->view('global/header',$this->data);
			$this->load->view('berkas_pekerjaan/ambil_klien',$data);
			$this->load->view('global/footer');
		}
	}

	public function ambil_klien_berkas_pending($value="",$tipe="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/pkj_pending'));
		}else{
			$this->load->model('KlienModel');

			$config['base_url'] = base_url().'Home/ambil_klien_berkas_pending/'.$value.'/'.$tipe.'/';
			$config['per_page'] = 10;
			$dari = $this->uri->segment('5');
			$config['uri_segment'] = $dari;
			$config['cur_page'] = $dari;
			$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
	        $config['full_tag_close'] = '</ul></div>';
	        $config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="previous">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo Prev';
	        $config['prev_tag_open'] = '<li class="prev page">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';

			/* jika jalan search */
			$this->form_validation->set_rules('search_klien', 'Search', 'required');

			if ($this->form_validation->run() === FALSE) {
				$data['query'] = "kosong";
				$data['search'] = "kosong";
				$jumlah = $this->KlienModel->jumlah();
				$config['total_rows'] = $jumlah;
				$choice = $config['total_rows'] / $config['per_page'];
		        $config['num_links'] = ceil($choice);
				$data['list'] = $this->KlienModel->tabel($config['per_page'],$dari);
				$this->pagination->initialize($config);
			}
			else {
				$data['query'] = "search";
				$data['search'] = $this->input->post('search_klien');
				if ($this->KlienModel->cek_search($this->input->post('search_klien')) > 0) {
					$data['list'] = $this->KlienModel->search($this->input->post('search_klien'));
				}else{
					$data['list'] = "kosong";
				}
			}

			$data['id_berkas'] = $value;
			$data['tipe'] = $tipe;
			$data['links'] = $this->pagination->create_links();
			$this->load->view('global/header',$this->data);
			$this->load->view('berkas_pekerjaan/ambil_klien_pending',$data);
			$this->load->view('global/footer');
		}
	}

	/* halaman tambah tanah edit berkas */
	public function tmb_tanah_berkas($value="",$tipe="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->load->model('KlienModel');
			$data['klien'] = $this->KlienModel->tabel();
			$data['id_berkas'] = $value;
			$data['tipe'] = $tipe;
			$this->load->view('global/header',$this->data);
			$this->load->view('berkas_pekerjaan/tambah_tanah',$data);
			$this->load->view('global/footer');
		}
	}

	public function tmb_tanah_berkas_pending($value="",$tipe="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/pkj_pending'));
		}else{
			$this->load->model('KlienModel');
			$data['klien'] = $this->KlienModel->tabel();
			$data['id_berkas'] = $value;
			$data['tipe'] = $tipe;
			$this->load->view('global/header',$this->data);
			$this->load->view('berkas_pekerjaan/tambah_tanah_pending',$data);
			$this->load->view('global/footer');
		}
	}

	/* halaman ambil tanah edit berkas */
	public function ambil_tanah_berkas($value="",$tipe="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->load->model('TanahModel');

			$config['base_url'] = base_url().'Home/ambil_tanah_berkas/'.$value.'/'.$tipe.'/';
			$config['per_page'] = 10;
			$dari = $this->uri->segment('5');
			$config['uri_segment'] = $dari;
			$config['cur_page'] = $dari;
			$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
	        $config['full_tag_close'] = '</ul></div>';
	        $config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="previous">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo Prev';
	        $config['prev_tag_open'] = '<li class="prev page">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';

			/* jika jalan search */
			$this->form_validation->set_rules('search_tanah', 'Search', 'required');

			if ($this->form_validation->run() === FALSE) {
				$data['query'] = "kosong";
				$data['search'] = "kosong";
				$jumlah = $this->TanahModel->jumlah();
				$config['total_rows'] = $jumlah;
				$choice = $config['total_rows'] / $config['per_page'];
		        $config['num_links'] = ceil($choice);
				$data['list'] = $this->TanahModel->table($config['per_page'],$dari);
				$this->pagination->initialize($config);
			}
			else {
				$data['query'] = "search";
				$data['search'] = $this->input->post('search_tanah');
				if ($this->TanahModel->cek_search($this->input->post('search_tanah')) > 0) {
					$data['list'] = $this->TanahModel->search($this->input->post('search_tanah'));
				}else{
					$data['list'] = "kosong";
				}
			}

			$data['id_berkas'] = $value;
			$data['tipe'] = $tipe;
			$data['links'] = $this->pagination->create_links();
			$this->load->view('global/header',$this->data);
			$this->load->view('berkas_pekerjaan/ambil_tanah',$data);
			$this->load->view('global/footer');
		}
	}

	public function ambil_tanah_berkas_pending($value="",$tipe="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/pkj_pending'));
		}else{
			$this->load->model('TanahModel');

			$config['base_url'] = base_url().'Home/ambil_tanah_berkas_pending/'.$value.'/'.$tipe.'/';
			$config['per_page'] = 10;
			$dari = $this->uri->segment('5');
			$config['uri_segment'] = $dari;
			$config['cur_page'] = $dari;
			$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
	        $config['full_tag_close'] = '</ul></div>';
	        $config['first_link'] = '&laquo; First';
			$config['first_tag_open'] = '<li class="previous">';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = 'Last &raquo;';
			$config['last_tag_open'] = '<li class="next page">';
			$config['last_tag_close'] = '</li>';
	        $config['first_tag_open'] = '<li>';
	        $config['first_tag_close'] = '</li>';
	        $config['prev_link'] = '&laquo Prev';
	        $config['prev_tag_open'] = '<li class="prev page">';
	        $config['prev_tag_close'] = '</li>';
	        $config['next_link'] = 'Next &raquo';
	        $config['next_tag_open'] = '<li>';
	        $config['next_tag_close'] = '</li>';
	        $config['last_tag_open'] = '<li>';
	        $config['last_tag_close'] = '</li>';
	        $config['cur_tag_open'] = '<li class="active"><a href="">';
	        $config['cur_tag_close'] = '</a></li>';
	        $config['num_tag_open'] = '<li>';
	        $config['num_tag_close'] = '</li>';


			/* jika jalan search */
			$this->form_validation->set_rules('search_tanah', 'Search', 'required');

			if ($this->form_validation->run() === FALSE) {
				$data['query'] = "kosong";
				$data['search'] = "kosong";
				$jumlah = $this->TanahModel->jumlah();
				$config['total_rows'] = $jumlah;
				$choice = $config['total_rows'] / $config['per_page'];
		        $config['num_links'] = ceil($choice);
				$data['list'] = $this->TanahModel->table($config['per_page'],$dari);
				$this->pagination->initialize($config);
			}
			else {
				$data['query'] = "search";
				$data['search'] = $this->input->post('search_tanah');
				if ($this->TanahModel->cek_search($this->input->post('search_tanah')) > 0) {
					$data['list'] = $this->TanahModel->search($this->input->post('search_tanah'));
				}else{
					$data['list'] = "kosong";
				}
			}

			$data['id_berkas'] = $value;
			$data['tipe'] = $tipe;
			$data['links'] = $this->pagination->create_links();
			$this->load->view('global/header',$this->data);
			$this->load->view('berkas_pekerjaan/ambil_tanah_pending',$data);
			$this->load->view('global/footer');
		}
	}

	/* tambah klien edit berkas */
	public function input_klien_berkas($value="",$tipe="",$jenis="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->form_validation->set_rules('ktp', 'KTP', 'required');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('jalan', 'Jalan', 'required');
			$this->form_validation->set_rules('rt', 'RT', 'required');
			$this->form_validation->set_rules('rw', 'RW', 'required');
			$this->form_validation->set_rules('kel', 'Nama', 'required');
			$this->form_validation->set_rules('kec', 'Nama', 'required');
			$this->form_validation->set_rules('kota', 'Nama', 'required');
			$this->form_validation->set_rules('prov', 'Nama', 'required');

			if ($this->form_validation->run() === FALSE) {
				redirect(base_url('Home/tmb_klien_berkas/'.$value.'/'.$tipe));
			}else{
				$this->load->model('KlienModel');
				$biodata = array('ktp' => $this->input->post('ktp'),
							 					'nama' => $this->input->post('nama'),
							 					'jalan' => $this->input->post('jalan'),
							 					'rt' => $this->input->post('rt'),
							 					'rw' => $this->input->post('rw'),
							 					'kec' => $this->input->post('kec'),
							 					'kel' => $this->input->post('kel'),
							 					'kota' => $this->input->post('kota'),
							 					'prov' => $this->input->post('prov'),
							 					'hp' => $this->input->post('hp'),
							 					'email' => $this->input->post('email'));
				/* cek nomor ktp sudah ada apa belum */
				if($this->KlienModel->select_ktp($this->input->post('ktp')) > 0){
					/* sudah ada */
					$status = "Data Klien Gagal Ditambah! KTP Sudah Terdaftar";
					$this->session->set_flashdata('error', $status);
					$this->session->set_flashdata($biodata);
					redirect(base_url('Home/tmb_klien_berkas/'.$value.'/'.$tipe));
				}else{
					/* tidak ada */
					if ($this->input->post('email') != NULL) {
						$polaemail = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
						if (!preg_match($polaemail, $this->input->post('email'))){
							$status = "Data Klien Gagal Ditambah! Format Email Salah";
							$this->session->set_flashdata('error', $status);
							$this->session->set_flashdata($biodata);
							redirect(base_url('Home/tmb_klien_berkas/'.$value.'/'.$tipe));
						}else{
							if ($this->KlienModel->insert($this->input->post('ktp'),
														$this->input->post('nama'),
														$this->input->post('jalan'),
														$this->input->post('rt'),
														$this->input->post('rw'),
														$this->input->post('kec'),
														$this->input->post('kel'),
														$this->input->post('kota'),
														$this->input->post('prov'),
														$this->input->post('hp'),
														$this->input->post('email')))
							{
								$status = "Data Klien Berhasil Ditambah";
								$this->session->set_flashdata('success', $status);

								switch ($tipe) {
									case '1':
										$sess = array(
											'SESS_PENJUAL_ID' => $this->input->post('ktp'),
											'SESS_PENJUAL_NAME' => $this->input->post('nama')
										);
										break;

									case '2':
										$sess = array(
											'SESS_PEMBELI_ID' => $this->input->post('ktp'),
											'SESS_PEMBELI_NAME' => $this->input->post('nama')
										);
										break;

									case '3':
										$sess = array(
											'SESS_PEMOHON_ID' => $this->input->post('ktp'),
											'SESS_PEMOHON_NAME' => $this->input->post('nama')
										);
										break;
								}
							
								$this->session->set_userdata($sess);
								if ($jenis == "pending") {
									redirect(base_url('Home/edit_berkas_pending/'.$value));
								}else{
									redirect(base_url('Home/edit_berkas_pending/'.$value));
								}
							}else{
								$status = "Data Klien Gagal Ditambah! Terdapat Kesalahan pada Sistem";
								$this->session->set_flashdata('error', $status);
								$this->session->set_flashdata($biodata);
								if ($jenis == "pending") {
									redirect(baase_url('Home/edit_berkas_pending/'.$value.'/'.$tipe));
								}else{
									redirect(base_url('Home/edit_berkas_pending/'.$value.'/'.$tipe));
								}
							}
						}
					}else{
						if ($this->KlienModel->insert($this->input->post('ktp'),
													$this->input->post('nama'),
													$this->input->post('jalan'),
													$this->input->post('rt'),
													$this->input->post('rw'),
													$this->input->post('kec'),
													$this->input->post('kel'),
													$this->input->post('kota'),
													$this->input->post('prov'),
													$this->input->post('hp'),
													$this->input->post('email')))
						{
							$status = "Data Klien Berhasil Ditambah";
							$this->session->set_flashdata('success', $status);

							switch ($tipe) {
								case '1':
									$sess = array(
										'SESS_PENJUAL_ID' => $this->input->post('ktp'),
										'SESS_PENJUAL_NAME' => $this->input->post('nama')
									);
									break;

								case '2':
									$sess = array(
										'SESS_PEMBELI_ID' => $this->input->post('ktp'),
										'SESS_PEMBELI_NAME' => $this->input->post('nama')
									);
									break;

								case '3':
									$sess = array(
										'SESS_PEMOHON_ID' => $this->input->post('ktp'),
										'SESS_PEMOHON_NAME' => $this->input->post('nama')
									);
									break;
							}
						
							$this->session->set_userdata($sess);
							if ($jenis == "pending") {
								redirect(base_url('Home/edit_berkas_pending/'.$value));
							}else{
								redirect(base_url('Home/edit_berkas_pending/'.$value));
							}
						}else{
							$status = "Data Klien Gagal Ditambah! Terdapat Kesalahan pada Sistem";
							$this->session->set_flashdata('error', $status);
							$this->session->set_flashdata($biodata);
							if ($jenis == "pending") {
								redirect(baase_url('Home/edit_berkas_pending/'.$value.'/'.$tipe));
							}else{
								redirect(base_url('Home/edit_berkas_pending/'.$value.'/'.$tipe));
							}
						}
					}
				}
			}
		}
	}

	/* tambah tanah edit berkas */
	public function input_tanah_berkas($value="",$tipe="",$jenis="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->form_validation->set_rules('hak', 'Hak', 'required');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('jenis', 'Jenis', 'required');
			$this->form_validation->set_rules('jalan', 'Jalan', 'required');
			$this->form_validation->set_rules('rt', 'RT', 'required');
			$this->form_validation->set_rules('rw', 'RW', 'required');
			$this->form_validation->set_rules('kel', 'Kel', 'required');
			$this->form_validation->set_rules('kec', 'Kec', 'required');
			$this->form_validation->set_rules('kota', 'Kota', 'required');
			$this->form_validation->set_rules('prov', 'Prov', 'required');
			$this->form_validation->set_rules('luas', 'Luas', 'required');

			if ($this->form_validation->run() === FALSE) {
				redirect(base_url('Home/tmb_tanah_berkas/'.$value.'/'.$tipe));
			}else{
				$this->load->model('TanahModel');
				$biodata = array('hak' => $this->input->post('hak'),
		 					'nama' => $this->input->post('nama'),
		 					'jenis' => $this->input->post('jenis'),
		 					'jalan' => $this->input->post('jalan'),
		 					'rt' => $this->input->post('rt'),
		 					'rw' => $this->input->post('rw'),
		 					'kec' => $this->input->post('kec'),
		 					'kel' => $this->input->post('kel'),
		 					'kota' => $this->input->post('kota'),
		 					'prov' => $this->input->post('prov'),
		 					'luas' => $this->input->post('luas'));
				/* cek nomor hak sudah ada apa belum */
				if($this->TanahModel->cek_tanah($this->input->post('hak')) > 0){
					/* sudah ada */
					$status = "Data Tanah Gagal Ditambah! Nomor Hak Sudah Terdaftar";
					$this->session->set_flashdata('error', $status);
					$this->session->set_flashdata($biodata);
					redirect(base_url('Home/tmb_tanah_berkas/'.$value.'/'.$tipe));
				}else{
					/* tidak ada */
					if ($this->TanahModel->insert($this->input->post('hak'),
											$this->input->post('nama'),
											$this->input->post('jenis'),
											$this->input->post('jalan'),
											$this->input->post('rt'),
											$this->input->post('rw'),
											$this->input->post('kec'),
											$this->input->post('kel'),
											$this->input->post('kota'),
											$this->input->post('prov'),
											$this->input->post('luas')))
					{
						$status = "Data Tanah Berhasil Ditambah";
						$this->session->set_flashdata('success', $status);

						$id_tanah = $this->TanahModel->select_id($this->input->post('hak'));

						if($tipe === '4') {
							$sess = array(
								'SESS_TANAH_ID' => $id_tanah,
								'SESS_TANAH_NAME' => $this->input->post('hak')
							);
						}
					
						$this->session->set_userdata($sess);

						if ($jenis == "pending") {
							redirect(base_url('Home/edit_berkas_pending/'.$value));
						}else{
							redirect(base_url('Home/edit_berkas/'.$value));
						}
					}else{
						$status = "Data Tanah Gagal Ditambah! Terdapat Kesalahan pada Sistem";
						$this->session->set_flashdata('error', $status);
						$this->session->set_flashdata($biodata);

						if ($jenis == "pending") {
							redirect(base_url('Home/tmb_tanah_berkas/pending'.$value.'/'.$tipe));
						}else{
							redirect(base_url('Home/tmb_tanah_berkas/'.$value.'/'.$tipe));
						}
					}
				}
			}
		}
	}

	public function take_klien_berkas($value="",$id="",$tipe="",$jenis="")
	{
		if ($value == '' || $id == '' || $tipe == '') {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->load->model('KlienModel');
			if ($this->KlienModel->select_ktp($id) > 0) {
				$klien = $this->KlienModel->select_klien($id)->nama_pemohon;

				switch ($tipe) {
					case '1':
						$sess = array(
							'SESS_PENJUAL_ID' => $id,
							'SESS_PENJUAL_NAME' => $klien
						);
						break;

					case '2':
						$sess = array(
							'SESS_PEMBELI_ID' => $id,
							'SESS_PEMBELI_NAME' => $klien
						);
						break;

					case '3':
						$sess = array(
							'SESS_PEMOHON_ID' => $id,
							'SESS_PEMOHON_NAME' => $klien
						);
						break;
				}
			
				$this->session->set_userdata($sess);

				if ($jenis == "pending") {
					redirect(base_url('Home/edit_berkas_pending/'.$value));
				}else{
					redirect(base_url('Home/edit_berkas/'.$value));
				}
			}else{
				$status = "Data Klien Tidak Ditemukan! Silahkan Pilih Data Lain";
				$this->session->set_flashdata('error', $status);
				if ($jenis == "pending") {
					redirect(base_url('Home/ambil_klien_berkas_pending/'.$value.'/'.$tipe));
				}else{
					redirect(base_url('Home/ambil_klien_berkas/'.$value.'/'.$tipe));
				}
			}

		}
	}

	public function take_tanah_berkas($value="",$id="",$tipe="",$jenis="")
	{
		if ($value == '' || $id == '' || $tipe == '') {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->load->model('TanahModel');
			if ($this->TanahModel->cek_tanah($id) > 0) {
				$tanah = $this->TanahModel->select_tanah($id)->no_hak;

				if ($tipe === '4') {
					$sess = array(
						'SESS_TANAH_ID' => $id,
						'SESS_TANAH_NAME' => $tanah
					);
				}
			
				$this->session->set_userdata($sess);

				if ($jenis == "pending") {
					redirect(base_url('Home/edit_berkas_pending/'.$value));
				}else{
					redirect(base_url('Home/edit_berkas/'.$value));
				}
			}else{
				$status = "Data Tanah Tidak Ditemukan! Silahkan Pilih Data Lain";
				$this->session->set_flashdata('error', $status);
				if ($jenis == "pending") {
					redirect(base_url('Home/ambil_tanah_berkas_pending/'.$value.'/'.$tipe));
				}else{
					redirect(base_url('Home/ambil_tanah_berkas/'.$value.'/'.$tipe));
				}
			}

		}
	}

	public function reset_data_berkas($value="",$tipe="",$jenis="")
	{
		if ($value == '' || $tipe == '') {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			switch ($tipe) {
				case '1':
					$sess = array(
						'SESS_PENJUAL_ID' => '',
						'SESS_PENJUAL_NAME' => ''
					);
					break;

				case '2':
					$sess = array(
						'SESS_PEMBELI_ID' => '',
						'SESS_PEMBELI_NAME' => ''
					);
					break;

				case '3':
					$sess = array(
						'SESS_PEMOHON_ID' => '',
						'SESS_PEMOHON_NAME' => ''
					);
					break;

				case '4':
					$sess = array(
						'SESS_TANAH_ID' => '',
						'SESS_TANAH_NAME' => ''
					);
					break;
			}
		
			$this->session->unset_userdata($sess);
			if ($jenis == 'pending') {
				redirect(base_url('Home/edit_berkas_pending/'.$value));
			}else{
				redirect(base_url('Home/edit_berkas/'.$value));	
			}
		}
	}

	public function update_berkas($value='',$jenis='')
	{
		if ($value == "") {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->form_validation->set_rules('lokasi', 'lokasi', 'required');

			if ($this->form_validation->run() === FALSE) {
				$status = "Lengkapi Data Terlebih Dahulu";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/edit_berkas/'.$value));
			}else{
				$this->load->model('BerkasModel');
				$this->load->model('PekerjaanModel');

				if ($this->session->userdata('SESS_PEMOHON_ID')) {
					$update_pemohon = $this->BerkasModel->update_stat_pemohon($value,$this->session->userdata('SESS_PEMOHON_ID'),'pemohon');
				}else{
					$update_pemohon = "do nothing";
				}
				if ($this->session->userdata('SESS_PENJUAL_ID')) {
					$update_penjual = $this->BerkasModel->update_stat_pemohon($value,$this->session->userdata('SESS_PENJUAL_ID'),'penjual');
				}else{
					$update_penjual = "do nothing";
				}
				if ($this->session->userdata('SESS_PEMBELI_ID')) {
					$update_pembeli = $this->BerkasModel->update_stat_pemohon($value,$this->session->userdata('SESS_PEMBELI_ID'),'pembeli');
				}else{
					$update_pembeli = "do nothing";
				}
				if ($this->session->userdata('SESS_TANAH_ID')) {
					$update_tanah = $this->BerkasModel->update_stat_tanah($value,$this->session->userdata('SESS_TANAH_ID'));
				}else{
					$update_tanah = "do nothing";
				}
				if ($this->BerkasModel->select_id_berkas($value)->jenis_aktor === 'Notaris') {
					if ($this->BerkasModel->cek_instansi($value) > 0) {
						if ($this->input->post('instansi') == '') {
							/* delete */
							$update_instansi = $this->BerkasModel->delete_instansi($value);
						}else{
							/* update */
							$update_instansi = $this->BerkasModel->update_instansi($value,$this->input->post('instansi'));
						}
					}else{
						if ($this->input->post('instansi') == '') {
							/* do nothing */
							$update_instansi = "do nothing";
						}else{
							/* insert */
							$update_instansi = $this->BerkasModel->insert_instansi($value,$this->input->post('instansi'));
						}
					}
				}else{
					$update_instansi = "do nothing";
				}
				$update_lokasi = $this->BerkasModel->update_lokasi($value,$this->input->post('lokasi'));

				$list_berkas_dihapus = $this->input->post('list_berkas_dihapus');
				$list_ket_dihapus = $this->input->post('list_ket_dihapus');
				$pasangan_berkas_ket = array();
				if (count($list_ket_dihapus) !== 0) {
					for ($i=0; $i < count($list_ket_dihapus); $i++) { 
						$this->BerkasModel->delete_stat_syarat_id($list_berkas_dihapus[$i], $list_ket_dihapus[$i]);
					}
				}

				$select_syarat = $this->input->post('syarat');
				$id_ket = $this->input->post('id_ket');
				$ket_syarat = $this->input->post('ket_syarat');
				for ($i=0; $i < count($select_syarat); $i++) {
					$syarat[$i]['id_berkas'] = $value; 
					$syarat[$i]['id_ket'] = $id_ket[$i];
					$syarat[$i]['syarat'] = $select_syarat[$i];
					$syarat[$i]['ket_syarat'] = $ket_syarat[$i];
				}

				$update_stat_syarat = $this->PekerjaanModel->update_stat_syarat($syarat);

				$tmb_syarat = $this->input->post('tmb_syarat');
				if (!empty($tmb_syarat)) {
					$max_id_ket = $this->PekerjaanModel->max_id_ket_syarat($value)->id_ket;
					$new_id_ket = $max_id_ket+1;
					$tmb_ket_syarat = $this->input->post('tmb_ket_syarat');
					for ($i=0; $i < count($tmb_syarat); $i++) { 
						$tmb[$i]['id_berkas'] = $value;
						$tmb[$i]['id_ket'] = $new_id_ket;
						$tmb[$i]['syarat'] = $tmb_syarat[$i];
						$tmb[$i]['ket_syarat'] = $tmb_ket_syarat[$i];
					}

					$insert_stat_syarat = $this->PekerjaanModel->insert_stat_syarat($tmb);
				}else{
					$insert_stat_syarat = "do nothing";
				}

				if ($update_pemohon && $update_penjual && $update_pembeli && $update_lokasi && $update_instansi && $update_stat_syarat && $insert_stat_syarat) {
					$status = "Data Berkas #BKS".$value." Berhasil Diubah!";
					$this->session->set_flashdata('success', $status);
					if ($jenis == 'pending') {
						redirect(base_url('Home/pkj_pending'));
					}else{
						redirect(base_url('Home/berkas_pekerjaan'));
					}
				}else{
					$status = "Data Berkas Gagal Diubah! Terjadi Kesalahan Pada Sistem";
					$this->session->set_flashdata('error', $status);
					if ($jenis == 'pending') {
						redirect(base_url('Home/pkj_pending'));
					}else{
						redirect(base_url('Home/berkas_pekerjaan'));
					}
				}
			}
		}
	}

	public function delete_berkas($jenis="")
	{
		/* cek password */
		$this->load->model('LoginModel');
		$pass = $this->LoginModel->select_pass($this->session->userdata('SESS_USER_ID'))->password;
		/* jika password benar */
		if (md5($this->input->post('pwver')) === $pass) {

			$this->load->model('BerkasModel');

			// $stat_detail = $this->BerkasModel->delete_stat_detail($this->input->post('id'));
			// $stat_pemohon = $this->BerkasModel->delete_stat_pemohon($this->input->post('id'));
			// $stat_syarat = $this->BerkasModel->delete_stat_syarat($this->input->post('id'));
			// if ($this->BerkasModel->cek_stat_tanah($this->input->post('id')) > 0 ) {
			// 	$stat_tanah = $this->BerkasModel->delete_stat_tanah($this->input->post('id'));
			// }else{
			// 	$stat_tanah = "do nothing";
			// }
			// if ($this->BerkasModel->cek_stat_biaya($this->input->post('id')) > 0) {
			// 	$stat_biaya = $this->BerkasModel->delete_stat_biaya($this->input->post('id'));
			// }else{
			// 	$stat_biaya = "do nothing";
			// }
			// if ($this->BerkasModel->cek_biaya_detail_berkas($this->input->post('id')) > 0) {
			// 	$biaya_detail_berkas = $this->BerkasModel->delete_biaya_detail_berkas($this->input->post('id'));
			// }else{
			// 	$biaya_detail_berkas = "do nothing";
			// }
			// if ($this->BerkasModel->cek_biaya_titip($this->input->post('id')) > 0) {
			// 	$biaya_titip = $this->BerkasModel->delete_biaya_titip($this->input->post('id'));
			// }else{
			// 	$biaya_titip = "do nothing";
			// }
			// if ($this->BerkasModel->cek_instansi($this->input->post('id')) > 0) {
			// 	$instansi = $this->BerkasModel->delete_instansi($this->input->post('id'));
			// }else{
			// 	$instansi = "do nothing";
			// }
			$delete_pekerjaan = $this->BerkasModel->delete_pekerjaan($this->input->post('id'));
			if ($delete_pekerjaan) {
				$status = "Berkas Pekerjaan Berhasil Dihapus";
				$this->session->set_flashdata('success', $status);
				if ($jenis == "pending") {
					redirect(base_url('Home/pkj_pending'));
				}elseif($jenis == "rekap"){
					redirect(base_url('Home/rekap_pekerjaan'));
				}else{
					redirect(base_url('Home/berkas_pekerjaan'));
				}
			}else{
				$status = "Berkas Pekerjaan Gagal Dihapus! Terdapat Kesalahan pada Sistem";
				$this->session->set_flashdata('error', $status);
				if ($jenis == "pending") {
					redirect(base_url('Home/pkj_pending'));
				}elseif($jenis == "rekap"){
					redirect(base_url('Home/rekap_pekerjaan'));
				}else{
					redirect(base_url('Home/berkas_pekerjaan'));
				}
			}
		}
		/* jika password salah */
		else{
			/* kembali ke halaman detail pekerjaan status error password */
			$status = "Password Tidak Cocok! Silahkan Ulangi";
			$this->session->set_flashdata('error', $status);
			if ($jenis == "pending") {
				redirect(base_url('Home/pkj_pending'));
			}elseif($jenis == "rekap"){
				redirect(base_url('Home/rekap_pekerjaan'));
			}else{
				redirect(base_url('Home/berkas_pekerjaan'));
			}
		}
	}

	public function ubah_pj($id="",$un="",$idu="")
	{
		$this->load->model('BerkasModel');
		$data['user'] = $this->BerkasModel->select_pj();
		$data['id'] = $id;
		$data['un'] = $un;
		$data['idu'] = $idu;
		$this->load->view('berkas_pekerjaan/pj',$data);
	}

	public function ganti_pj()
	{
		$this->form_validation->set_rules('id', 'id', 'required');
		$this->form_validation->set_rules('idname', 'Idname', 'required');
		$this->form_validation->set_rules('pj', 'Pj', 'required');
		$this->form_validation->set_rules('pilih', 'Pilih', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->load->model('BerkasModel');

			switch ($this->input->post('pilih')) {
				case '1':
					// yang diganti cuma berkas tersebut
					if ($this->BerkasModel->ganti_pj($this->input->post('id'), $this->input->post('pj'))) {
						$status = "PJ Berhasil Diubah";
						$this->session->set_flashdata('success', $status);
						redirect(base_url('Home/berkas_pekerjaan'));
					}else{
						$status = "PJ Gagal Diubah! Silahkan Ulangi";
						$this->session->set_flashdata('error', $status);
						redirect(base_url('Home/berkas_pekerjaan'));
					}
					break;
				
				case '2':
					$data = $this->BerkasModel->search_berkas_pj($this->input->post('idname'));
					foreach ($data as $key) {
						$ganti = $this->BerkasModel->ganti_pj($key->id_berkas, $this->input->post('pj'));
					}
					if ($ganti) {
						$status = "PJ Berhasil Diubah";
						$this->session->set_flashdata('success', $status);
						redirect(base_url('Home/berkas_pekerjaan'));
					}else{
						$status = "PJ Gagal Diubah! Silahkan Ulangi";
						$this->session->set_flashdata('error', $status);
						redirect(base_url('Home/berkas_pekerjaan'));
					}
					break;
			}
		}
	}

	public function detail_berkas($value,$id)
	{
		$this->load->model('BerkasModel');
		$this->load->model('DaftarPekerjaanModel');

		$data['id_berkas'] = $value;
		$data['id_pkj'] = $id;
		$data['row'] = $this->BerkasModel->select_id_berkas($value);
		$data['detail'] = $this->BerkasModel->select_detail_pkj($value);
		$this->load->view('berkas_pekerjaan/detail',$data);
	}

	public function detail_klien($value)
	{
		$this->load->model('KlienModel');

		$data['klien'] = $this->KlienModel->select_klien($value);
		$this->load->view('berkas_pekerjaan/detail_klien', $data);
	}

	public function detail_tanah($value)
	{
		$this->load->model('TanahModel');

		$data['tanah'] = $this->TanahModel->detail_tanah($value);
		$this->load->view('berkas_pekerjaan/detail_tanah', $data);
	}

	public function syarat_berkas($value)
	{
		$this->load->model('BerkasModel');

		$data['id_berkas'] = $value;
		$data['row'] = $this->BerkasModel->select_id_berkas($value);
		$data['syarat'] = $this->BerkasModel->select_syarat_pkj($value);
		$this->load->view('berkas_pekerjaan/syarat',$data);
	}

	public function biaya_berkas($value="",$aksi="")
	{
		if ($value == "") {
			$status = "Tidak Ada Data";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$this->load->model('BerkasModel');

			$data['id_berkas'] = $value;
			$data['biaya_klien'] = $this->BerkasModel->select_biaya_klien($value);
			$data['biaya_titip'] = $this->BerkasModel->select_biaya_titip($value);
			if ($aksi == "tambah") {
				$data['aksi'] = "tambah";
			}elseif ($aksi == "edit") {
				$data['aksi'] = "edit";
			}else{
				$data['aksi'] = "kosong";
			}

			$this->load->view('global/header', $this->data);
			$this->load->view('berkas_pekerjaan/lunas',$data);
			$this->load->view('global/footer');
		}
	}

	public function update_detail_berkas($value='',$id='')
	{
		$this->load->model('BerkasModel');
		$this->load->model('DaftarPekerjaanModel');
		$this->load->model('PekerjaanModel');

		$detail = $this->BerkasModel->select_detail_pkj($value);
		$default = $this->DaftarPekerjaanModel->sum_biaya($id);

		foreach ($detail as $det) {
			$a[] = $this->input->post('biaya_pkj'.$det->id_detail);
			$a += $a;
			if ($this->input->post('status'.$det->id_detail)){
				$status = '1';
			}else{
				$status = '0';
			}
			$update_stat = $this->BerkasModel->update_stat_detail($value,$det->id_detail,$status);

			if($this->input->post('biaya_pkj'.$det->id_detail) !=""){
				if ($this->BerkasModel->cek_biaya_detail($value,$det->id_detail) > 0) {
					$update_biaya = $this->BerkasModel->update_biaya_detail($value,$det->id_detail,$this->input->post('biaya_pkj'.$det->id_detail));
					if ($this->BerkasModel->cek_stat_biaya_detail($det->id_detail) > 0) {
						$update_stat_biaya = "Do Nothing";
					}else{
						$update_stat_biaya = $this->BerkasModel->insert_stat_biaya_detail($value,$det->id_detail);
					}
				}else{
					$update_biaya = $this->BerkasModel->insert_biaya_detail($value,$det->id_detail,$this->input->post('biaya_pkj'.$det->id_detail));
					$update_stat_biaya = $this->BerkasModel->insert_stat_biaya_detail($value,$det->id_detail);
				}
			}else{
				if ($this->BerkasModel->cek_biaya_detail($value,$det->id_detail) > 0) {
					$update_biaya = $this->BerkasModel->delete_biaya_detail($value,$det->id_detail);
					$update_stat_biaya = $this->BerkasModel->delete_stat_biaya_detail($value,$det->id_detail);
				}else{
					$update_biaya = "Do Nothing";
					$update_stat_biaya = "Do Nothing";
				}
			}
		}
			$sum = array_sum($a) + $default;
			$biaya_kerja = $this->PekerjaanModel->update_biaya_kerja($value,$sum);

		if($update_stat && $update_biaya && $biaya_kerja){
			$status = "Detail Berhasil Diubah";
			$this->session->set_flashdata('success', $status);
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$status = "Detail Gagal Diubah! Terdapat Kesalahan pada Sistem";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/berkas_pekerjaan'));
		}
	}

	public function update_syarat_pekerjaan($value='')
	{
		$this->load->model('BerkasModel');

		$syarat = $this->BerkasModel->select_syarat_pkj($value);
		foreach ($syarat as $srt) {
			if ($this->input->post('status'.$srt->id_ket)) {
				$status = '1';
			}else{
				$status = '0';
			}
			$update_syarat = $this->BerkasModel->update_stat_syarat($value,$srt->id_ket,$status);

			$update_ket = $this->BerkasModel->update_ket_syarat($value,$srt->id_ket,$this->input->post('ket_syarat'.$srt->id_ket));
		}
		if ($update_syarat && $update_ket) {
			$status = "Syarat Berhasil Diubah";
			$this->session->set_flashdata('success', $status);
			redirect(base_url('Home/berkas_pekerjaan'));
		}else{
			$status = "Syarat Gagal Diubah! Terdapat Kesalahan pada Sistem";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/berkas_pekerjaan'));
		}
	}

	public function input_biaya_titip($value='')
	{
		$this->form_validation->set_rules('tgl', 'TanggalTitip', 'required');
		$this->form_validation->set_rules('biaya_titip', 'BiayaTitip', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/biaya_berkas/'.$value));
		}else{
			$this->load->model('BerkasModel');
			$cek_biaya_titip = $this->BerkasModel->select_biaya_titip($value);
			$titip = 0;
			foreach ($cek_biaya_titip as $cek) {
				$titip += $cek->biaya_titip;
			}
			$titip += $this->input->post('biaya_titip');
			$klien = $this->BerkasModel->select_id_berkas($value)->biaya_klien;
			if ($titip > $klien) {
				$status = "Biaya Titip Gagal Ditambah! Jumlah Biaya Titip Melebihi Biaya Klien";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/biaya_berkas/'.$value));
			}else{
				if ($this->BerkasModel->input_biaya_titip($value,$this->input->post('tgl'),$this->input->post('biaya_titip'))) {
					$status = "Biaya Titip Berhasil Ditambah";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/biaya_berkas/'.$value));
				}else{
					$status = "Biaya Titip Gagal Ditambah! Terdapat Kesalahan pada Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/biaya_berkas/'.$value));
				}
			}
		}
	}

	public function update_biaya_berkas($value='')
	{
		$this->load->model('BerkasModel');

		if ($this->input->post('biaya_klien') != "") {
			$update_biaya_klien = $this->BerkasModel->update_biaya_klien($value,$this->input->post('biaya_klien'));
		}else{
			$update_biaya_klien = "do nothing";
		}
		$tgl = $this->input->post('tgl_titip');
		$biaya = $this->input->post('biaya_titip');
		$id = $this->input->post('id_titip');
		$cek_biaya_titip = $this->BerkasModel->select_biaya_titip($value);
		$titip = 0;
		for ($i=0; $i < count($tgl); $i++) {
			$biaya_titip[$i]['id_titip'] = $id[$i];
			$biaya_titip[$i]['tgl_titip'] = $tgl[$i];
			$biaya_titip[$i]['biaya_titip'] = $biaya[$i];
			$titip += $biaya[$i];
		}
		$klien = $this->BerkasModel->select_id_berkas($value)->biaya_klien;
		if ($titip > $klien) {
			$status = "Biaya Titip Gagal Diubah! Jumlah Biaya Titip Melebihi Biaya Klien";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/biaya_berkas/'.$value));
		}else{
			$update_biaya_titip = $this->BerkasModel->update_biaya_titip($biaya_titip);
		}

		if ($update_biaya_klien && $update_biaya_titip) {
			$status = "Biaya Berkas Berhasil Diubah";
			$this->session->set_flashdata('success', $status);
			redirect(base_url('Home/biaya_berkas/'.$value));
		}else{
			$status = "Biaya Berkas Gagal Diubah! Terdapat Kesalahan pada Sistem";
			$this->session->set_flashdata('error', $status);
			redirect(base_url('Home/biaya_berkas/'.$value));
		}
	}

	public function pengeluaran_kerja($value="")
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();
		
		$this->load->model('RekapModel');

		if ($value == "belum") {
			$data['sort'] = 'belum';
		}elseif($value == "sudah"){
			$data['sort'] = 'sudah';
		}else{
			$data['sort'] = 'all';			
		}

		$this->form_validation->set_rules('search_berkas', 'Search', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['search'] = "kosong";
			$data['id'] = $this->RekapModel->select_id_berkas($value);
			$data['tipe'] = "kosong";
		}
		else {
			$search = $this->input->post('search_berkas');
			if (strpos($search, 'bks') !== FALSE) {
				$search = substr($search, 3);
				$cari = $this->RekapModel->cek_search_id($search);
				$golek = $this->RekapModel->search_id($search);
			}else{
				$search = $search;
				$cari = $this->RekapModel->cek_search($search);
				$golek = $this->RekapModel->search($search);
			}
			$data['search'] = $this->input->post('search_berkas');
			if ($cari > 0) {
				$data['id'] = $golek;
			}else{
				$data['id'] = "kosong";
			}
			$data['tipe'] = "search";
		}

		$this->load->view('global/header', $this->data);
		$this->load->view('rekap_data/pengeluaran',$data);
		$this->load->view('global/footer');	
	}

	public function lihat_bayar($id='',$detail='')
	{
		$this->load->model('RekapModel');

		$data['biaya'] = $this->RekapModel->select_id_detail($id,$detail);
		$this->load->view('rekap_data/bayar', $data);
	}

	public function ganti_bayar($value='',$id='',$detail='')
	{
		$this->load->model('RekapModel');

		$biaya = $this->RekapModel->select_id_detail($id,$detail)->biaya_default;

		switch ($value) {
			case 'y':
				if ($this->RekapModel->update_biaya_bayar($id,$detail,$biaya)) {
					$status = "Biaya Kerja Berhasil Disesuaikan dengan Biaya Baru!";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/pengeluaran_kerja'));
				}else{
					$status = "Biaya Kerja Gagal Dirubah! Silahkan Ulangi";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/pengeluaran_kerja'));
				}
				break;
			
			case 'n':
				if ($this->RekapModel->update_biarkan($id,$detail)) {
					$status = "Biaya Kerja Tetap Menggunakan Biaya Lama!";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/pengeluaran_kerja'));
				}else{
					$status = "Biaya Kerja Gagal Dirubah! Silahkan Ulangi";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/pengeluaran_kerja'));
				}
				break;
		}
	}

	public function update_stat_biaya($sort='',$value='',$detail='',$biaya='')
	{
		if ($value == "" || $detail == "") {
			redirect(base_url('Home/pengeluaran_kerja'));
		}else{
			$this->load->model('RekapModel');

			$tgl = gmdate('Y-m-d', time()+60*60*7);

			if ($this->RekapModel->update_stat_biaya($value,$detail,$tgl,$biaya)) {
				$status = "Status Pengeluaran Kerja Berhasil Diubah";
				$this->session->set_flashdata('success', $status);
				if ($sort === "belum") {
					redirect(base_url('Home/pengeluaran_kerja/belum'));
				}else{
					redirect(base_url('Home/pengeluaran_kerja'));
				}
			}else{
				$status = "Status Pengeluaran Kerja Gagal Diubah! Terdapat Kesalahan pada Sistem";
				$this->session->set_flashdata('error', $status);
				if ($sort === "belum") {
					redirect(base_url('Home/pengeluaran_kerja/belum'));
				}else{
					redirect(base_url('Home/pengeluaran_kerja'));
				}
			}
		}
	}

	public function detail_berkas_pengeluaran($value='')
	{
		$this->load->model('BerkasModel');
		$data['berkas'] = $this->BerkasModel->select_id_berkas($value);
		$this->load->view('rekap_data/detail_berkas', $data);
	}

	public function pengeluaran_tambahan($value='',$tgl='')
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();
		
		$this->load->model('RekapModel');
		$data['now'] = $tgl;
		if ($value == "") {
			$data['tgl'] = $this->RekapModel->select_tambahan_all();
			$data['sort'] = "all";
		}else if($value == "tgl"){
			$tgl = ($tgl == "") ? $tgl = gmdate('Y-m-d', time()+60*60*7) : $tgl = $tgl ;
			$data['tgl'] = $this->RekapModel->select_tambahan_tgl($tgl);
			$data['sort'] = "tgl";
		}else if($value == "bln"){
			$tgl = ($tgl == "") ? $tgl = gmdate('Y-m', time()+60*60*7) : $tgl = $tgl ;
			$data['tgl'] = $this->RekapModel->select_tambahan_bln($tgl);
			$data['sort'] = "bln";
		}
		$this->load->view('global/header',$this->data);
		$this->load->view('rekap_data/tambahan',$data);
		$this->load->view('global/footer');
	}

	public function tambah_pengeluaran_tambahan()
	{
		$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
		$this->form_validation->set_rules('nominal', 'Nominal', 'required');
		$this->form_validation->set_rules('ket', 'Ket', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/pengeluaran_tambahan'));
		}else{
			$this->load->model('RekapModel');

			if ($this->RekapModel->insert_tambahan($this->input->post('tanggal'),$this->input->post('nominal'),$this->input->post('ket'))) {
				$status = "Pengeluaran Tambahan Berhasil Di Tambah";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/pengeluaran_tambahan'));
			}else{
				$status = "Pengeluaran Tambahan Gagal Diubah! Terjadi Kesalahan Pada Sistem";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/pengeluaran_tambahan'));
			}
		}
	}

	public function edit_pengeluaran_tambahan()
	{
		$this->form_validation->set_rules('nominal', 'Nominal', 'required');
		$this->form_validation->set_rules('ket', 'Ket', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/pengeluaran_tambahan/tgl'));
		}else{
			$this->load->model('RekapModel');

			if ($this->RekapModel->update_tambahan($this->input->post('id'),$this->input->post('nominal'),$this->input->post('ket'))) {
				$status = "Pengeluaran Tambahan Berhasil Diubah";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/pengeluaran_tambahan'));
			}else{
				$status = "Pengeluaran Tambahan Gagal Diubah! Terjadi Kesalahan Pada Sistem";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/pengeluaran_tambahan'));
			}
		}
	}

	public function delete_pengeluaran_tambahan()
	{
		$this->form_validation->set_rules('id', 'Id', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/pengeluaran_tambahan/tgl'));
		}else{
			/* cek password */
			$this->load->model('LoginModel');
			$pass = $this->LoginModel->select_pass($this->session->userdata('SESS_USER_ID'))->password;
			/* jika password benar */
			if (md5($this->input->post('pwver')) === $pass) {
				$this->load->model('RekapModel');

				if ($this->RekapModel->delete_tambahan($this->input->post('id'))) {
				 	$status = "Hapus Pengeluran Tambahan Sukses!";
					$this->session->set_flashdata('success', $status);
					redirect(base_url('Home/pengeluaran_tambahan'));
				 }else{
				 	$status = "Gagal Hapus Pengeluaran Tambahan! Terjadi Kesalahan Sistem";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/pengeluaran_tambahan'));
				 }
			}else{
				$status = "Password Tidak Cocok! Silahkan Ulangi";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/pengeluaran_tambahan'));
			}
		}
	}

	public function pelunasan($value='')
	{
		$this->load->model('BerkasModel');

		$data['berkas'] = $this->BerkasModel->select_id_berkas($value);
		$this->load->view('berkas_pekerjaan/pelunasan', $data);
	}

	public function bayar_pelunasan()
	{
		$this->form_validation->set_rules('kurang', 'Kurang', 'required');
		$this->form_validation->set_rules('id', 'Id', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Home/pkj_selesai'));
		}else{
			$this->load->model('BerkasModel');

			if ($this->BerkasModel->lunaskan($this->input->post('id'),$this->input->post('kurang'))) {
				$status = "Pelunasan Biaya Klien Sukses!";
				$this->session->set_flashdata('success', $status);
				redirect(base_url('Home/pkj_selesai'));
			 }else{
			 	$status = "Pelunasan Biaya Klien Gagal! Terjadi Kesalahan Sistem";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/pkj_selesai'));
			}
		}
	}

	public function rekap_pekerjaan($nama_pkj='')
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();

		$this->load->model('RekapModel');
		$this->load->model('DaftarPekerjaanModel');

		$this->form_validation->set_rules('search_berkas', 'Search', 'required');

		if ($this->form_validation->run() === FALSE) {
			$data['tipe'] = "kosong";
			$data['search'] = "kosong";
			if ($nama_pkj != '') {
				$url = urldecode($nama_pkj);
				$id_pkj = $this->DaftarPekerjaanModel->id_pekerjaan($url)->id_pekerjaan;
				if ($this->RekapModel->cek_rekap($id_pkj) > 0) {
					$data['list'] = $this->RekapModel->select_rekap($id_pkj);
				}else{
					$data['list'] = "belum";
				}
				$data['jp'] = $url;
			}else{
				if ($this->RekapModel->cek_rekap_pekerjaan() > 0) {
					$data['list'] = $this->RekapModel->select_rekap_pekerjaan();
				}else{
					$data['list'] = "belum";
				}
			}
		} else {
			$data['tipe'] = "search";
			$search = $this->input->post('search_berkas');
			if (strpos($search, 'bks') !== FALSE) {
				$search = substr($search, 3);
				$cari = $this->RekapModel->cek_search_pekerjaan_id($search);
				$golek = $this->RekapModel->search_pekerjaan_id($search);
			}else{
				$search = $search;
				$cari = $this->RekapModel->cek_search_pekerjaan($search);
				$golek = $this->RekapModel->search_pekerjaan($search);
			}
			$data['search'] = $this->input->post('search_berkas');
			if ($cari > 0) {
				$data['list'] = $golek;
			}else{
				$data['list'] = "kosong";
			}
		}

		$this->load->view('global/header', $this->data);
		$this->load->view('rekap_data/rekap_pekerjaan', $data);
		$this->load->view('global/footer');
	}

	public function rekap_pendapatan($tgl='')
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();

		$data['now'] = $tgl;
		$tgl == "" ? $tgl = gmdate('Y-m', time()+60*60*7) : $tgl = $tgl ;
		$this->load->model('RekapModel');
		if ($this->RekapModel->cek_pemasukan($tgl) > 0) {
			$pemasukan = $this->RekapModel->select_pemasukan($tgl);
		}else{
			$pemasukan = "belum";
		}
		if ($this->RekapModel->cek_pengeluaran($tgl) > 0) {
			$pengeluaran = $this->RekapModel->select_pengeluaran($tgl);
		}else{
			$pengeluaran = "belum";
		}
		if ($this->RekapModel->cek_tambahan($tgl) > 0) {
			$tambahan = $this->RekapModel->select_tambahan_bln($tgl);
		}else{
			$tambahan = "belum";
		}
		$data['pemasukan'] = $pemasukan;
		$data['pengeluaran'] = $pengeluaran;
		$data['tambahan'] = $tambahan;

		$this->load->view('global/header', $this->data);
		$this->load->view('rekap_data/rekap_pendapatan', $data);
		$this->load->view('global/footer');
	}

	public function grafik_pendapatan($value="")
	{
		$this->load->model('SessionModel');
		$this->SessionModel->remove_sess();
		
		$this->load->model('RekapModel');
		if ($value == "") {
			$value = gmdate('Y', time()+60*60*7);
			$data['now'] = "";
		}else{
			$value = $value;
			$data['now'] = $value;
		}
		$pemasukan_bln = $this->RekapModel->pemasukan_bln($value);
		$pengeluaran_bln = $this->RekapModel->pengeluaran_bln($value);
		$tambahan_bln = $this->RekapModel->tambahan_bln($value);
		$i = 0;

		$bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
		$result = array();
		if ($pemasukan_bln == NULL && $pengeluaran_bln == NULL && $tambahan_bln == NULL) {
			foreach ($bulan as $b) {
				$result[] = NULL;
			}
		}else if ($pemasukan_bln == NULL && $pengeluaran_bln == NULL && $tambahan_bln != NULL) {
			foreach ($bulan as $b) {
				$result[] = $tambahan_bln[$b];
			}
		}else if($pemasukan_bln == NULL && $pengeluaran_bln != NULL && $tambahan_bln == NULL){
			foreach ($bulan as $b) {
				$result[] = 0 - $pengeluaran_bln[$b];
			}
		}else if($pemasukan_bln != NULL && $pengeluaran_bln == NULL && $tambahan_bln == NULL){
			foreach ($bulan as $b) {
				$result[] = $pemasukan_bln[$b];
			}
		}else if($pemasukan_bln == NULL && $pengeluaran_bln != NULL && $tambahan_bln != NULL) {
			foreach ($bulan as $b) {
				$result[] = 0 - $pengeluaran_bln[$b] - $tambahan_bln[$b];
			}
		}else if($pemasukan_bln != NULL && $pengeluaran_bln == NULL && $tambahan_bln != NULL) {
			foreach ($bulan as $b) {
				$result[] = $pemasukan_bln[$b] - $tambahan_bln[$b];
			}
		}else if($pemasukan_bln != NULL && $pengeluaran_bln != NULL && $tambahan_bln == NULL) {
			foreach ($bulan as $b) {
				$result[] = $pemasukan_bln[$b] - $pengeluaran_bln[$b];
			}
		}else{
			echo "mboh le";exit();
		}

		$data['chart'] = $result;

		$this->load->view('global/header', $this->data);
		$this->load->view('rekap_data/grafik', $data);
		$this->load->view('global/footer');
	}

	public function email($value='')
	{
		if ($value == "") {
			redirect(base_url('Home/pkj_selesai'));
		}else{
	    	$this->load->model('BerkasModel');
			if ($this->BerkasModel->cek_id_berkas($value) > 0) {
				$connected = @fsockopen("www.google.com", 80);
			    if (!$connected){
			        $status = "Komputer Tidak Terhubung ke Internet! Periksa Koneksi Anda";
					$this->session->set_flashdata('error', $status);
					redirect(base_url('Home/pkj_selesai'));
			    }else{
			    	$this->load->model('KlienModel');
			    	/* cek jenis_aktor berdasarkan id berkas */
			    	$berkas = $this->BerkasModel->select_id_berkas($value);
			    	if ($berkas->jenis_aktor === 'Notaris') {
				    	/* kalo notaris simpan id pemohon */
				    	$pemohon = $berkas->id_pemohon;
				    	/* ambil email berdasarkan id pemohon (array) */
				    	$nama_pemohon[] = $this->KlienModel->select_klien($pemohon)->nama_pemohon;
				    	$email_pemohon[] = $this->KlienModel->select_klien($pemohon)->email;
			    	}else{
				    	/* kalo ppat simpan id penjual dan id pembeli */
				    	$penjual = $berkas->id_penjual;
				    	$pembeli = $berkas->id_pembeli;
				    	/* ambil email berdasarkan id penjual dan id pembeli (array) */
				    	$nama_pemohon[] = $this->KlienModel->select_klien($penjual)->nama_pemohon;
				    	$nama_pemohon[] = $this->KlienModel->select_klien($pembeli)->nama_pemohon;
				    	$email_pemohon[] = $this->KlienModel->select_klien($penjual)->email;
				    	$email_pemohon[] = $this->KlienModel->select_klien($pembeli)->email;
			    	}
			    	for ($i=0; $i < count($email_pemohon); $i++) {
			    		if ($email_pemohon[$i] !== "") {
			    		 	$this->load->library('email');
							$subject = 'Pemberitahuan perihal Pekerjaan '.$berkas->nama_pekerjaan;
							$name = $nama_pemohon[$i];
							$email = $email_pemohon[$i];
							$body = "Pekerjaan ".$berkas->nama_pekerjaan." atas nama ".$name." telah selesai di kerjakan. Silahkan datang ke kantor Notaris untuk melakukan proses selanjutnya";

							$this->email->from('ichandbvrg@gmail.com');
							$this->email->to($email);
							$this->email->subject($subject);
							$this->email->message($body);
							$this->email->send();
							$result = "sukses";
			    		 } else{
			    		 	$result = "kosong";
			    		 }
			    	}
			    	if($result === "sukses"){
						$status = "Email Pemberitahuan Terkirim!";
						$this->session->set_flashdata('success', $status);
						redirect(base_url('Home/pkj_selesai'));
					}elseif($result === "kosong"){
			    		 	$status = "Klien Tidak Memiliki Email!";
							$this->session->set_flashdata('error', $status);
							redirect(base_url('Home/pkj_selesai'));
					}else{
						$status = "Email Tidak Terkirim! Terjadi Kesalahan Sistem";
						$this->session->set_flashdata('error', $status);
						redirect(base_url('Home/pkj_selesai'));
					}
	        				
				}
				
		    }else{ /* berkas tidak ditemukan */
		    	$status = "Berkas Tidak Ada Dalam Data!";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Home/pkj_selesai'));
		    }
		}
	}
	
}
