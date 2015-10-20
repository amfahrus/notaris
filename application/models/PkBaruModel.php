<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PkBaruModel extends CI_Model {
	public function load_pekerjaan($type){
		$where = array('jenis_aktor' => $type,
						'hapus' => 0);
		$this->db->where($where);
		
		return $this->db->get('jenis_pekerjaan')->result();
	}

	public function load_all()
	{
		$where = array('hapus' => 0);
		$this->db->where($where);

		return $this->db->get('jenis_pekerjaan')->result();
	}

	public function pending()
	{
		$where = array('status' => 0,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('pekerjaan')->num_rows();
	}

	public function proses()
	{
		$where = array('status' => 1,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('pekerjaan')->num_rows();
	}

	public function selesai()
	{
		$where = array('status' => 2,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('pekerjaan')->num_rows();
	}
	

}

/* End of file PkBaruModel.php */
/* Location: ./application/models/PkBaruModel.php */