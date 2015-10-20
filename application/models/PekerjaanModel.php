<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PekerjaanModel extends CI_Model {

	public function cek_id_pkj($value)
	{
		$where = array('id_pekerjaan' => $value);
		$this->db->where($where);

		return $this->db->get('pekerjaan')->num_rows();
	}

	public function select_id_pkj($value)
	{
		$where = array('id_pekerjaan' => $value);
		$this->db->where($where);

		return $this->db->get('pekerjaan')->result();
	}

	public function max_id_berkas()
	{
		$this->db->select_max('id_berkas');

		return $this->db->get('pekerjaan')->row();
	}

	public function insert_pertama($id_berkas, $tgl, $lokasi, $id_pkj, $user)
	{
		$data = array('id_berkas' => $id_berkas,
		 				'tgl_masuk_pekerjaan' => $tgl,
		 				'lokasi_penyimpanan' => $lokasi,
		 				'id_pekerjaan' => $id_pkj,
		 				'id_user' => $user);

		return $this->db->insert('pekerjaan', $data);
	}

	public function update_biaya_kerja($id_berkas, $biaya)
	{
		$data = array('biaya_kerja' => $biaya);
		$where = array('id_berkas' => $id_berkas);
		$this->db->where($where);

		return $this->db->update('pekerjaan', $data);
	}

	public function insert_instansi($id_berkas, $instansi)
	{
		$data = array('id_berkas' => $id_berkas,
		 				'nama_instansi' => $instansi);

		return $this->db->insert('instansi', $data);
	}

	public function insert_stat_tanah($id_berkas,$id_tanah)
	{
		$data = array('id_berkas' => $id_berkas,
		 					'id_tanah' => $id_tanah);

		return $this->db->insert('status_tanah', $data);
	}

	public function insert_stat_pemohon($id_berkas,$id_pemohon,$status)
	{
		$data = array('id_berkas' => $id_berkas,
		 				'id_pemohon' => $id_pemohon,
		 				'status' => $status);

		return $this->db->insert('status_pemohon', $data);
	}

	public function insert_stat_syarat($data)
	{
		for ($i=0; $i < count($data); $i++) { 
			$data_array = array('id_berkas' => $data[$i]['id_berkas'],
			 						'id_syarat' => $data[$i]['syarat'],
			 						'id_ket' => $data[$i]['id_ket'],
			 						'keterangan' => $data[$i]['ket_syarat'],
			 						'status' => '0');
			$a = $this->db->insert('status_syarat_pekerjaan', $data_array);
		}

		return $a;
	}

	public function update_stat_syarat($value)
	{
		for ($i=0; $i < count($value); $i++) { 
			$data = array('id_syarat' => $value[$i]['syarat'],
							'keterangan' => $value[$i]['ket_syarat'] );
			$where = array('id_berkas' => $value[$i]['id_berkas'],
							'id_ket' => $value[$i]['id_ket'] );
			$this->db->where($where);

			$a = $this->db->update('status_syarat_pekerjaan', $data);
		}

		return $a;
	}

	public function max_id_ket_syarat($value)
	{
		$this->db->select_max('id_ket');
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('status_syarat_pekerjaan')->row();
	}

	public function insert_stat_detail($value)
	{
		for($i=0;$i < count($value);$i++) { 
			$data_array = array('id_berkas' => $value[$i]['id_berkas'],
			 						'id_detail' => $value[$i]['id_detail'],
			 						'status' => '0');
			$a = $this->db->insert('status_detail_pekerjaan', $data_array);
		}

		return $a;
	}

	public function delete_stat_detail($value)
	{
		for ($i=0; $i < count($value); $i++) {
			$where = array('id_berkas' => $value[$i]['id_berkas'],
							'id_detail' => $value[$i]['id_detail'] );
			$this->db->where($where);

			$a = $this->db->delete('status_detail_pekerjaan');
		}
		return $a;
	}

	public function insert_stat_biaya($value)
	{
		for($i=0;$i < count($value);$i++) { 
			$data_array = array('id_berkas' => $value[$i]['id_berkas'],
			 						'id_detail' => $value[$i]['id_detail'],
			 						'status' => '0');
			$a = $this->db->insert('status_biaya_pekerjaan', $data_array);
		}

		return $a;
	}

	public function delete_stat_biaya($value)
	{
		for ($i=0; $i < count($value); $i++) { 
			$where = array('id_berkas' => $value[$i]['id_berkas'],
							'id_detail' => $value[$i]['id_detail']);
			$this->db->where($where);

			$a = $this->db->delete('status_biaya_pekerjaan');
		}

		return $a;
	}

}

/* End of file PekerjaanModel.php */
/* Location: ./application/models/PekerjaanModel.php */