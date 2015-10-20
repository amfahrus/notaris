<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DaftarPekerjaanModel extends CI_Model {

	public function tabel($value)
	{
		$where = array('jenis_aktor' => $value,
						'hapus' => 0);
		$this->db->where($where);
		return $this->db->get('jenis_pekerjaan')->result();
	}

	public function insert($pekerjaan,$akta,$aktor)
	{
		$data = array(
			'nama_pekerjaan' => $pekerjaan,
			'jenis_akta' => $akta,
			'jenis_aktor' => $aktor
		);
		
		return $this->db->insert('jenis_pekerjaan', $data);
	}

	public function edit_daftar_pekerjaan($id,$pekerjaan,$akta)
	{
		$data = array(
			'nama_pekerjaan' => $pekerjaan,
			'jenis_akta' => $akta
		);
		$where = array('id_pekerjaan' => $id);
		$this->db->where($where);

		return $this->db->update('jenis_pekerjaan', $data);
	}

	public function delete_daftar_pekerjaan($id)
	{
		$data = array('hapus' => 1);
		$where = array('id_pekerjaan' => $id);
		$this->db->where($where);

		return $this->db->update('jenis_pekerjaan', $data);
	}

	public function id_pekerjaan($value)
	{
		$where = array('nama_pekerjaan' => $value);
		$this->db->where($where);

		return $this->db->get('jenis_pekerjaan')->row();
	}

	public function cek_nama_pekerjaan($value)
	{
		$where = array('nama_pekerjaan' => $value,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('jenis_pekerjaan')->num_rows();
	}

	public function cek_detail($value)
	{
		$where = array('id_pekerjaan' => $value);
		$this->db->where($where);
		return $this->db->get('detail_pekerjaan')->num_rows();	
	}

	public function cek_syarat($value)
	{
		$where = array('id_pekerjaan' => $value,
						'hapus' => 0);
		$this->db->where($where);
		return $this->db->get('syarat_pkj')->num_rows();
	}

	public function detail($value)
	{
		$where = array('id_pekerjaan' => $value);
		$this->db->where($where);
		$this->db->order_by('id_detail', 'asc');
		return $this->db->get('viewkerja')->result();
	}

	public function id_detail($value)
	{
		$where = array('id_pekerjaan' => $value);
		$this->db->where($where);

		return $this->db->get('detail_pekerjaan')->row();
	}

	public function syarat($value)
	{
		$where = array('id_pekerjaan' => $value,
						'hapus' => 0);
		$this->db->where($where);
		$this->db->order_by('id_syarat', 'asc');
		return $this->db->get('syarat_pkj')->result();
	}

	public function max_id_detail($value)
	{
		$where = array('id_pekerjaan' => $value);
		$this->db->select_max('id_detail');
		$this->db->where($where);
		$this->db->limit(1);
		return $this->db->get('detail_pekerjaan')->row();
	}

	public function max_id_syarat($value)
	{
		$where = array('id_pekerjaan' => $value);
		$this->db->select_max('id_syarat');
		$this->db->where($where);
		$this->db->limit(1);
		return $this->db->get('syarat_pkj')->row();
	}

	public function insert_detail($detail,$pekerjaan,$langkah)
	{
		$data = array('id_detail' => $detail,
						'id_pekerjaan' => $pekerjaan,
						'langkah_pekerjaan' => $langkah);

		return $this->db->insert('detail_pekerjaan', $data);
	}

	public function insert_syarat($id,$pekerjaan,$syarat)
	{
		$data = array('id_syarat' => $id,
						'id_pekerjaan' => $pekerjaan,
						'syarat' => $syarat);

		return $this->db->insert('syarat_pkj', $data);
	}

	public function cek_biaya($detail)
	{
		$where = array('id_detail' => $detail);
		$this->db->where($where);
		
		return $this->db->get('biaya_default_pekerjaan')->num_rows();
	}

	public function sum_biaya($id)
	{
		$where = array('id_pekerjaan' => $id);
		$this->db->where($where);
		$this->db->select_sum('biaya_default');
		$query =  $this->db->get('biaya_default_pekerjaan');
		$result = $query->result();

		return $result[0]->biaya_default;
	}

	public function cek_biaya_pekerjaan($value)
	{
		$where = array('id_pekerjaan' => $value);
		$this->db->where($where);

		return $this->db->get('biaya_default_pekerjaan')->num_rows();
	}

	public function select_biaya_pekerjaan($value)
	{
		$where = array('id_pekerjaan' => $value);
		$this->db->where($where);

		return $this->db->get('biaya_default_pekerjaan')->result();
	}

	public function insert_biaya($detail,$pekerjaan,$biaya)
	{
		$data = array('id_detail' => $detail,
						'id_pekerjaan' => $pekerjaan,
						'biaya_default' => $biaya);

		return $this->db->insert('biaya_default_pekerjaan', $data);
	}

	public function edit_detail($detail,$langkah)
	{
		$data = array('langkah_pekerjaan' => $langkah);
		$where = array('id_detail' => $detail);
		$this->db->where($where);

		return $this->db->update('detail_pekerjaan', $data);
	}

	public function edit_biaya($detail,$biaya)
	{
		$data = array('biaya_default' => $biaya);
		$where = array('id_detail' => $detail);
		$this->db->where($where);

		return $this->db->update('biaya_default_pekerjaan', $data);
	}

	public function delete_detail($detail)
	{
		$where = array('id_detail' => $detail);
		$this->db->where($where);

		return $this->db->delete('detail_pekerjaan');;
	}

	public function delete_biaya($detail)
	{
		$where = array('id_detail' => $detail);
		$this->db->where($where);

		return $this->db->delete('biaya_default_pekerjaan');
	}

	public function edit_syarat($id,$syarat)
	{
		$data = array('syarat' => $syarat);
		$where = array('id_syarat' => $id);
		$this->db->where($where);

		return $this->db->update('syarat_pkj', $data);
	}

	public function delete_syarat($id)
	{
		$data = array('hapus' => 1);
		$where = array('id_syarat' => $id);
		$this->db->where($where);

		return $this->db->update('syarat_pkj', $data);
	}
}

/* End of file DaftarPekerjaanModel.php */
/* Location: ./application/models/DaftarPekerjaanModel.php */