<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model {


	public function cek_username($value)
	{
		$where = array('username' => $value,
						'hapus' => 0);
		$this->db->where($where);

		$query = $this->db->get('user');

		if ($query->num_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function cek_user()
	{
		$user = $this->session->userdata('SESS_USER_ID');
		$where = "id_user != '$user' AND hapus = '0'";
		$this->db->where($where);

		return $this->db->get('user')->num_rows();
	}

	public function cek_pass()
	{
		$where = array('id_user' => $this->session->userdata('SESS_USER_ID'));
		$this->db->where($where);

		return $this->db->get('user')->row()->password;
	}

	public function select_user()
	{
		$user = $this->session->userdata('SESS_USER_ID');
		$where = "id_user != '$user' AND hapus = '0'";
		$this->db->where($where);

		return $this->db->get('user')->result();
	}

	public function select_username($value)
	{
		$where = array('id_user' => $value,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('user')->row();
	}

	public function insert_user($username,$pwd,$email,$akses)
	{
		$data = array('username' => $username,
						'password' => $pwd,
						'email' => $email,
						'hak_akses' => $akses );

		return $this->db->insert('user', $data);
	}

	public function edit_user($data)
	{
		$where = array('id_user' => $this->session->userdata('SESS_USER_ID'));
		$this->db->where($where);

		return $this->db->update('user', $data);
	}

	public function edit_pwd($data)
	{
		$where = array('id_user' => $this->session->userdata('SESS_USER_ID'));
		$this->db->where($where);

		return $this->db->update('user', $data);
	}

	public function edit_username($id,$username,$email)
	{
		$data = array('username' => $username,
						'email' => $email);
		$where = array('id_user' => $id);
		$this->db->where($where);

		return $this->db->update('user', $data);
	}

	public function edit_hak_akses($id,$hak)
	{
		$data = array('hak_akses' => $hak);
		$where = array('id_user' => $id);
		$this->db->where($where);

		return $this->db->update('user', $data);
	}

	public function edit_password($id,$pwd)
	{
		$data = array('password' => $pwd);
		$where = array('id_user' => $id);
		$this->db->where($where);

		return $this->db->update('user', $data);
	}

	public function delete_user($value)
	{
		$data = array('hapus' => 1);
		$where = array('id_user' => $value);
		$this->db->where($where);

		return $this->db->update('user', $data);
	}

}

/* End of file UserModel.php */
/* Location: ./application/models/UserModel.php */