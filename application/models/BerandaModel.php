<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BerandaModel extends CI_Model {

	public function cek_pk_masuk()
	{
		$tgl = gmdate('Y-m-d', time()+60*60*7);
		$where = array(
			'tgl_diterima_pekerjaan' => $tgl,
			'status' => 1);
		$this->db->where($where);
		return $this->db->get('viewpkmasuk')->num_rows();
	}

	// public function cek_biaya_klien($value='')
	// {
	// 	if ($value == '') {
	// 		$where = array('biaya_klien' => NULL);
	// 	}else{
	// 		$where = array('biaya_klien' => NULL,
	// 						'username' => $this->session->userdata('SESS_USERNAME'));
	// 	}
	// 	$this->db->where($where);

	// 	return $this->db->get('viewpkmasuk')->num_rows();
	// }

	public function cek_biaya_kerja()
	{
		$where = array('status' => '0',
						'stat_pekerjaan' => 1,
						'hapus_pekerjaan' => 0);
		$this->db->where($where);

		return $this->db->get('viewstatbiaya')->num_rows();
	}

	public function cek_blm_selesai()
	{
		$un = $this->session->userdata('SESS_USERNAME');
		$where = "username = '$un' AND (detail < jml_detail OR syarat < jml_syarat) AND status = '1'";
		$this->db->where($where);
		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function cek_pending()
	{
		$un = $this->session->userdata('SESS_USERNAME');
		$where = array('username' => $un,
		 				'status' => 0);
		$this->db->where($where);
		return $this->db->get('viewpkmasuk')->num_rows();
	}

}

/* End of file BerandaModel */
/* Location: ./application/models/BerandaModel.php */