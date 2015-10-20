<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginModel extends CI_Model {
	public function count($username, $password)
	{
		$data = array(
			'username' => $username,
			'password' => $password,
			'hapus' => 0
		);
		$this->db->where($data);
		return $this->db->get('user')->num_rows();
	}

	public function select_user($username, $password)
	{
		$data = array(
			'username' => $username,
			'password' => $password,
			'hapus' => 0
		);
		$this->db->where($data);
		return $this->db->get('user')->row();
	}

	public function select_pass($value)
	{
		$where = array('id_user' => $value);
		$this->db->where($where);
		return $this->db->get('user')->row();
	}

	public function cek_username($value)
	{
		$where = array('username' => $value,
		 				'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('user')->num_rows();
	}

	public function select_username($value)
	{
		$where = array('username' => $value,
		 				'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('user')->row();
	}

	public function change_pwd($id,$pwd)
	{
		$object = array('password' => $pwd);
		$where = array('id_user' => $id);
		$this->db->where($where);

		return $this->db->update('user', $object);
	}
}

/* End of file login.php */
/* Location: ./application/models/login.php */