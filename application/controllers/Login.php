<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		if ($this->session->userdata('SESS_IS_LOGIN'))
			redirect(base_url());

		$this->load->model('LoginModel');
	}

	public function index()
	{
		$this->form_validation->set_rules('un', 'User Name', 'required');
		$this->form_validation->set_rules('pwd', 'Password', 'required');

		if ($this->form_validation->run() === FALSE) {
			// //tampilkan form
			$this->load->view('login/login');
		} else {
			//jalankan aksi
			$username = $this->input->post('un');
			$password = md5($this->input->post('pwd'));

			if ($this->LoginModel->count($username, $password)) {
				// ambil data user
				$detail_user = $this->LoginModel->select_user($username, $password);

				$data = array(
					'SESS_USER_ID' => $detail_user->id_user,
					'SESS_USERNAME' => $detail_user->username,
					'SESS_HAK_AKSES' => $detail_user->hak_akses,
					'SESS_IS_LOGIN' => true
				);
				
				$this->session->set_userdata( $data );
				redirect(base_url());
			} else {
				$status = "Username atau Password Salah";
				$this->session->set_flashdata('error', $status);
				$this->session->set_flashdata('username', $username);
				redirect(base_url('login'));
			}
				
		}
	}

	public function forgot_pass()
	{
		$this->form_validation->set_rules('un', 'username', 'required');

		if ($this->form_validation->run() === FALSE) {
			redirect(base_url('Login'));
		}else{
			$connected = @fsockopen("www.google.com", 80);
		    if (!$connected){
		        $status = "Komputer Tidak Terhubung ke Internet! Periksa Koneksi Anda";
				$this->session->set_flashdata('error', $status);
				redirect(base_url('Login'));
		    }else{
				if ($this->LoginModel->cek_username($this->input->post('un')) > 0	) {
					$tgl = gmdate('dmY', time()+60*60*7);
					$waktu = gmdate('His', time()+60*60*7);
					$reset = $tgl+$waktu;
					$pwd = md5($reset);
					$id = $this->LoginModel->select_username($this->input->post('un'))->id_user;
					if ($this->LoginModel->change_pwd($id,$pwd)) {
						$this->load->library('email');
						$subject = 'SI Kenotariatan - Password Baru Anda';
						$name = $this->input->post('un');
						$email = $this->LoginModel->select_username($this->input->post('un'))->email;
						$body = "<h2>Halo ".$name."</h2>";
						$body .= "<p>Kami informasikan bahwa password anda telah berhasil di reset</p>";
						$body .= "<p>Gunakan password baru anda untuk masuk kedalam sistem</p>";
						$body .= "<p>Jangan lupa untuk merubah password baru anda agar mudah diingat</p>";
						$body .= "<p>Password Baru : <strong>".$reset."</strong></p>";


						$this->email->from('ichandbvrg@gmail.com');
						$this->email->to($email);
						$this->email->subject($subject);
						$this->email->message($body);
						if ($this->email->send()) {
							$status = "Password Berhasil Di Kirim Ke Alamat Email Anda! Check folder inbox atau folder spam pada Email Anda";
							$this->session->set_flashdata('success', $status);
							$this->session->set_flashdata('username', $this->input->post('un'));
							redirect(base_url('Login'));
						}else{
							$status = "Password Gagal Di Kirim Ke Alamat Email Anda!";
							$this->session->set_flashdata('error', $status);
							$this->session->set_flashdata('username', $this->input->post('un'));
							redirect(base_url('Login'));
						}
					}else{
						$status = "Password Gagal Di Ubah! Silahkan Ulangi";
						$this->session->set_flashdata('error', $status);
						$this->session->set_flashdata('username', $this->input->post('un'));
						redirect(base_url('Login'));
					}
				}else{
					$status = "Tidak Ada Username Terdaftar!";
					$this->session->set_flashdata('error', $status);
					$this->session->set_flashdata('username', $this->input->post('un'));
					redirect(base_url('Login'));
				}
		    }
		}
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */