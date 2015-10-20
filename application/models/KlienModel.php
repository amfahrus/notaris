<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KlienModel extends CI_Model {

	public function jumlah()
	{
		$where = array('hapus' => 0);
		$this->db->where($where);
		return $this->db->get('pemohon')->num_rows();
	}

	public function tabel()
	{
		$where = array('hapus' => 0);
		$this->db->where($where);

		return $this->db->get('pemohon')->result();
	}

	public function search($value)
	{
		$where = "(id_pemohon LIKE '%$value%' OR 
					nama_pemohon LIKE '%$value%' OR
					jalan LIKE '%$value%' OR 
					rt LIKE '%$value%' OR
					rw LIKE '%$value%' OR
					kelurahan LIKE '%$value%' OR
					kecamatan LIKE '%$value%' OR
					kota LIKE '%$value%' OR
					provinsi LIKE '%$value%' OR
					hp LIKE '%$value%' OR
					email LIKE '%$value%')
					AND hapus = '0' ";
		$this->db->where($where);

		return $this->db->get('pemohon')->result();
	}

	public function cek_search($value)
	{
		$where = "(id_pemohon LIKE '%$value%' OR 
					nama_pemohon LIKE '%$value%' OR
					jalan LIKE '%$value%' OR 
					rt LIKE '%$value%' OR
					rw LIKE '%$value%' OR
					kelurahan LIKE '%$value%' OR
					kecamatan LIKE '%$value%' OR
					kota LIKE '%$value%' OR
					provinsi LIKE '%$value%' OR
					hp LIKE '%$value%' OR
					email LIKE '%$value%')
					AND hapus = '0' ";
		$this->db->where($where);

		return $this->db->get('pemohon')->num_rows();
	}

	public function insert($ktp,$nama,$jln,$rt,$rw,$kel,$kec,$kota,$prov,$hp,$email)
	{
		$data = array('id_pemohon' => $ktp,
		 				'nama_pemohon' => $nama,
		 				'jalan' => $jln,
		 				'rt' => $rt,
		 				'rw' => $rw,
		 				'kelurahan' => $kel,
		 				'kecamatan' => $kec,
		 				'kota' => $kota,
		 				'provinsi' => $prov,
		 				'hp' => $hp,
		 				'email' => $email);
		return $this->db->insert('pemohon', $data);
	}

	public function update($id,$ktp,$nama,$jln,$rt,$rw,$kel,$kec,$kota,$prov,$hp,$email)
	{
		$data = array('id_pemohon' => $ktp,
		 				'nama_pemohon' => $nama,
		 				'jalan' => $jln,
		 				'rt' => $rt,
		 				'rw' => $rw,
		 				'kelurahan' => $kel,
		 				'kecamatan' => $kec,
		 				'kota' => $kota,
		 				'provinsi' => $prov,
		 				'hp' => $hp,
		 				'email' => $email);

		$where = array('id_pemohon' => $id);
		$this->db->where($where);

		return $this->db->update('pemohon', $data);
	}

	public function delete($value)
	{
		$data = array('hapus' => 1);
		$where = array('id_pemohon' => $value);
		$this->db->where($where);

		return $this->db->update('pemohon', $data);
	}

	public function select_ktp($value)
	{
		$where = array('id_pemohon' => $value);
		$this->db->where($where);

		return $this->db->get('pemohon')->num_rows();
	}

	public function select_klien($value)
	{
		$where = array('id_pemohon' => $value);
		$this->db->where($where);

		return $this->db->get('pemohon')->row();
	}
}

/* End of file KlienModel.php */
/* Location: ./application/models/KlienModel.php */