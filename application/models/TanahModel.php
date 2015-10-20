<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TanahModel extends CI_Model {

	public function jumlah()
	{
		$where = array('hapus' => 0);
		$this->db->where($where);
		return $this->db->get('viewtanah')->num_rows();
	}

	public function table($sampai,$dari)
	{
		$where = array('hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewtanah',$sampai,$dari)->result();
	}

	public function search($value)
	{
		$where = "(nama_pemohon LIKE '%$value%' OR
					no_hak LIKE '%$value%' OR 
					jenis_hak LIKE '%$value%' OR
					jalan LIKE '%$value%' OR
					rt LIKE '%$value%' OR
					rw LIKE '%$value%' OR
					kelurahan LIKE '%$value%' OR
					kecamatan LIKE '%$value%' OR
					provinsi LIKE '%$value%' OR
					luas_tanah LIKE '%$value%') AND
					hapus = '0' ";
		$this->db->where($where);

		return $this->db->get('viewtanah')->result();
	}

	public function cek_search($value)
	{
		$where = "nama_pemohon LIKE '%$value%' OR
					no_hak LIKE '%$value%' OR 
					jenis_hak LIKE '%$value%' OR
					jalan LIKE '%$value%' OR
					rt LIKE '%$value%' OR
					rw LIKE '%$value%' OR
					kelurahan LIKE '%$value%' OR
					kecamatan LIKE '%$value%' OR
					provinsi LIKE '%$value%' OR
					luas_tanah LIKE '%$value%'";
		$this->db->where($where);

		return $this->db->get('viewtanah')->num_rows();
	}

	public function cek_hak($value)
	{
		$where = array('no_hak' => $value);
		$this->db->where($where);

		return $this->db->get('tanah')->num_rows();
	}

	public function select_id($value)
	{
		$where = array('no_hak' => $value);
		$this->db->where($where);

		return $this->db->get('tanah')->row();
	}

	public function cek_tanah($value)
	{
		$where = array('id_tanah' => $value);
		$this->db->where($where);

		return $this->db->get('tanah')->num_rows();
	}

	public function select_tanah($value)
	{
		$where = array('id_tanah' => $value);
		$this->db->where($where);

		return $this->db->get('tanah')->row();
	}

	public function detail_tanah($value)
	{
		$where = array('id_tanah' => $value);
		$this->db->where($where);

		return $this->db->get('viewtanah')->row();
	}

	public function insert($hak,$nama,$jenis,$jln,$rt,$rw,$kel,$kec,$kota,$prov,$luas)
	{
		$data = array('no_hak' => $hak,
		 				'id_pemegang_hak' => $nama,
		 				'jenis_hak' => $jenis,
		 				'jalan' => $jln,
		 				'rt' => $rt,
		 				'rw' => $rw,
		 				'kelurahan' => $kel,
		 				'kecamatan' => $kec,
		 				'kota' => $kota,
		 				'provinsi' => $prov,
		 				'luas_tanah' => $luas);

		return $this->db->insert('tanah', $data);
	}

	public function update($id,$hak,$nama,$jenis,$jln,$rt,$rw,$kel,$kec,$kota,$prov,$luas)
	{
		$data = array('no_hak' => $hak,
		 				'id_pemegang_hak' => $nama,
		 				'jenis_hak' => $jenis,
		 				'jalan' => $jln,
		 				'rt' => $rt,
		 				'rw' => $rw,
		 				'kelurahan' => $kel,
		 				'kecamatan' => $kec,
		 				'kota' => $kota,
		 				'provinsi' => $prov,
		 				'luas_tanah' => $luas);

		$where = array('id_tanah' => $id);
		$this->db->where($where);

		return $this->db->update('tanah', $data);
	}

	public function delete($value)
	{
		$data = array('hapus' => 1);
		$where = array('id_tanah' => $value);
		$this->db->where($where);

		return $this->db->update('tanah', $data);
	}

}

/* End of file TanahModel.php */
/* Location: ./application/models/TanahModel.php */