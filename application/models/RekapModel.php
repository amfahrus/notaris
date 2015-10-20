<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RekapModel extends CI_Model {

	/* pengeluaran kerja */

	public function select_stat_biaya($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);
		return $this->db->get('viewstatbiaya')->result();
	}

	public function select_stat_biaya_sudah($value)
	{
		$where = array('id_berkas' => $value,
		 				'status' => '1');
		$this->db->where($where);

		return $this->db->get('viewstatbiaya')->result();
	}

	public function select_stat_biaya_belum($value)
	{
		$where = array('id_berkas' => $value,
		 				'status' => '0');
		$this->db->where($where);

		return $this->db->get('viewstatbiaya')->result();
	}
	
	public function select_id_berkas($value)
	{
		$this->db->select('DISTINCT(id_berkas)');
		if ($value == "belum") {
			$where = array('status' => 0,
							'stat_pekerjaan' => 1,
			 				'hapus_pekerjaan' => 0 );
		}elseif ($value == "sudah"){
			$where = array('status' => 1,
							'stat_pekerjaan' => 1,
			 				'hapus_pekerjaan' => 0 );
		}else{
			$where = array('stat_pekerjaan' => 1,
			 				'hapus_pekerjaan' => 0);
		}
		$this->db->where($where);
		$this->db->order_by('id_berkas', 'desc');
		return $this->db->get('viewstatbiaya')->result();
	}

	public function select_id_detail($value,$detail)
	{
		$where = array('id_berkas' => $value,
		 				'id_detail' => $detail);
		$this->db->where($where);

		return $this->db->get('viewstatbiaya')->row();
	}

	public function update_biaya_bayar($id,$detail,$default)
	{
		$where = array('id_berkas' => $id,
		 				'id_detail' => $detail);
		$data = array('biaya_bayar' => $default );
		$this->db->where($where);

		return $this->db->update('status_biaya_pekerjaan', $data);
	}

	public function update_biarkan($id,$detail)
	{
		$where = array('id_berkas' => $id,
		 				'id_detail' => $detail);
		$data = array('biarkan' => 1);
		$this->db->where($where);

		return $this->db->update('status_biaya_pekerjaan', $data);
	}

	public function update_stat_biaya($value,$detail,$tgl,$biaya)
	{
		$data = array('status' => '1',
		 				'tgl_bayar' => $tgl,
		 				'biaya_bayar' => $biaya);
		$where = array('id_berkas' => $value,
		 				'id_detail' => $detail);
		$this->db->where($where);

		return $this->db->update('status_biaya_pekerjaan', $data);
	}

	public function cek_rekap($value='')
	{
		$where = array('id_pekerjaan' => $value,
		 				'status' => 3);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function select_rekap($value='')
	{
		$where = array('id_pekerjaan' => $value,
		 				'status' => 3);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->result();
	}

	public function cek_rekap_pekerjaan()
	{
		$where = array('status' => 3,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function select_rekap_pekerjaan()
	{
		$where = array('status' => 3,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->result();
	}

	public function cek_search_pekerjaan($value)
	{
		$where = "(id_berkas LIKE '%$value%' OR 
							tgl_masuk_pekerjaan LIKE '%$value%' OR
							lokasi_penyimpanan LIKE '%$value%' OR 
							nama_pekerjaan LIKE '%$value%' OR
							nama_instansi LIKE '%$value%' OR
							no_hak LIKE '%$value%' OR
							nama_pemohon LIKE '%$value%' OR
							nama_penjual LIKE '%$value%' OR
							nama_pembeli LIKE '%$value%') AND
					status = 3";
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function cek_search_pekerjaan_id($value)
	{
		$where = array('id_berkas' => $value,
		 				'status' => 3);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function search_pekerjaan($value)
	{
		$where = "(id_berkas LIKE '%$value%' OR 
							tgl_masuk_pekerjaan LIKE '%$value%' OR
							lokasi_penyimpanan LIKE '%$value%' OR 
							nama_pekerjaan LIKE '%$value%' OR
							nama_instansi LIKE '%$value%' OR
							no_hak LIKE '%$value%' OR
							nama_pemohon LIKE '%$value%' OR
							nama_penjual LIKE '%$value%' OR
							nama_pembeli LIKE '%$value%') AND
					status = 3";
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->result();
	}

	public function search_pekerjaan_id($value)
	{
		$where = array('id_berkas' => $value,
		 				'status' => 3);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->result();
	}

	public function cek_search($value)
	{
		$where = "(id_berkas LIKE '%$value%' OR 
					tgl_masuk_pekerjaan LIKE '%$value%' OR
					lokasi_penyimpanan LIKE '%$value%' OR 
					nama_pekerjaan LIKE '%$value%' OR
					nama_instansi LIKE '%$value%' OR
					no_hak LIKE '%$value%' OR
					nama_pemohon LIKE '%$value%' OR
					nama_penjual LIKE '%$value%' OR
					nama_pembeli LIKE '%$value%') AND (hapus = '0')";
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function cek_search_id($value)
	{
		$where = array('id_berkas' => $value,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function search($value)
	{
		$this->db->select('DISTINCT(id_berkas)');
		$where = "(id_berkas LIKE '%$value%' OR 
					tgl_masuk_pekerjaan LIKE '%$value%' OR
					lokasi_penyimpanan LIKE '%$value%' OR 
					nama_pekerjaan LIKE '%$value%' OR
					nama_instansi LIKE '%$value%' OR
					no_hak LIKE '%$value%' OR
					nama_pemohon LIKE '%$value%' OR
					nama_penjual LIKE '%$value%' OR
					nama_pembeli LIKE '%$value%') AND (hapus = '0')";
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->result();
	}

	public function search_id($value)
	{
		$this->db->select('DISTINCT(id_berkas)');
		$where = array('id_berkas' => $value,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->result();
	}

	/* pengeluaran tambahan */

	public function select_tambahan_all()
	{
		return $this->db->get('pengeluaran_tambahan')->result();
	}

	public function select_tambahan_tgl($value)
	{
		$where = array('tgl_pengeluaran' => $value);
		$this->db->where($where);

		return $this->db->get('pengeluaran_tambahan')->result();
	}

	public function cek_tambahan($value)
	{
		$where = array('SUBSTRING(tgl_pengeluaran,1,7)' => $value);
		$this->db->where($where);

		return $this->db->get('pengeluaran_tambahan')->num_rows();
	}

	public function select_tambahan_bln($value)
	{
		$where = array('SUBSTRING(tgl_pengeluaran,1,7)' => $value);
		$this->db->where($where);

		return $this->db->get('pengeluaran_tambahan')->result();
	}

	public function insert_tambahan($tgl,$nominal,$ket)
	{
		$data = array('tgl_pengeluaran' => $tgl,
		 				'nominal_pengeluaran' => $nominal,
		 				'ket_pengeluaran' => $ket);

		return $this->db->insert('pengeluaran_tambahan', $data);
	}

	public function update_tambahan($id,$nominal,$ket)
	{
		$data = array('nominal_pengeluaran' => $nominal,
		 				'ket_pengeluaran' => $ket);
		$where = array('id_pengeluaran' => $id);
		$this->db->where($where);

		return $this->db->update('pengeluaran_tambahan', $data);
	}

	public function delete_tambahan($value)
	{
		$where = array('id_pengeluaran' => $value);
		$this->db->where($where);

		return $this->db->delete('pengeluaran_tambahan');
	}

	/* REKAP PENDAPATAN */

	public function cek_pemasukan($value)
	{
		$where = array('SUBSTRING(tgl_titip,1,7)' => $value);
		$this->db->where($where);

		return $this->db->get('biaya_titip')->num_rows();
	}

	public function select_pemasukan($value)
	{
		$where = array('SUBSTRING(tgl_titip,1,7)' => $value);
		$this->db->where($where);

		return $this->db->get('biaya_titip')->result();
	}

	public function cek_pengeluaran($value)
	{
		$where = array('SUBSTRING(tgl_bayar,1,7)' => $value,
						'status' => '1');
		$this->db->where($where);

		return $this->db->get('viewstatbiaya')->num_rows();
	}

	public function select_pengeluaran($value)
	{
		$where = array('SUBSTRING(tgl_bayar,1,7)' => $value,
						'status' => '1');
		$this->db->where($where);

		return $this->db->get('viewstatbiaya')->result();
	}

	/* GRAFIK PENDAPATAN */

	public function sum_pendapatan($value)
	{
		$this->db->select_sum('biaya_titip');
		$where = array('SUBSTRING(tgl_titip,1,4)' => $value);
		$this->db->where($where);

		return $this->db->get('biaya_titip')->row();
	}

	public function sum_pengeluaran($value)
	{
		$this->db->select_sum('biaya_default');
		$where = array('SUBSTRING(tgl_bayar,1,4)' => $value,
						'status' => '1');
		$this->db->where($where);

		return $this->db->get('viewstatbiaya')->row();
	}

	public function sum_tambahan($value)
	{
		$this->db->select_sum('nominal_pengeluaran');
		$where = array('SUBSTRING(tgl_pengeluaran,1,4)' => $value);
		$this->db->where($where);

		return $this->db->get('pengeluaran_tambahan')->row();
	}

	public function pemasukan_bln($value)
	{
		$query = " SELECT
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=1) AND (YEAR(tgl_titip)='$value'))),0) AS 'Januari',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=2) AND (YEAR(tgl_titip)='$value'))),0) AS 'Februari',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=3) AND (YEAR(tgl_titip)='$value'))),0) AS 'Maret',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=4) AND (YEAR(tgl_titip)='$value'))),0) AS 'April',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=5) AND (YEAR(tgl_titip)='$value'))),0) AS 'Mei',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=6) AND (YEAR(tgl_titip)='$value'))),0) AS 'Juni',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=7) AND (YEAR(tgl_titip)='$value'))),0) AS 'Juli',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=8) AND (YEAR(tgl_titip)='$value'))),0) AS 'Agustus',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=9) AND (YEAR(tgl_titip)='$value'))),0) AS 'September',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=10) AND (YEAR(tgl_titip)='$value'))),0) AS 'Oktober',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=11) AND (YEAR(tgl_titip)='$value'))),0) AS 'November',
					ifnull((SELECT SUM(biaya_titip) FROM (biaya_titip) WHERE ((MONTH(tgl_titip)=12) AND (YEAR(tgl_titip)='$value'))),0) AS 'Desember'
				 FROM biaya_titip GROUP BY YEAR(tgl_titip)";

		return $this->db->query($query)->row_array(); 
	}

	public function pengeluaran_bln($value)
	{
		$query = " SELECT
					ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=1) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=1) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0) AS 'Januari',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=2) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=2) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'Februari',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=3) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=3) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'Maret',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=4) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=4) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'April',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=5) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=5) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'Mei',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=6) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=6) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'Juni',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=7) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=7) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'Juli',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=8) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=8) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'Agustus',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=9) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=9) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'September',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=10) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=10) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'Oktober',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=11) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=11) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'November',
					(ifnull((SELECT SUM(biaya_bayar) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=12) AND (YEAR(tgl_bayar)='$value') AND (status='1'))),0) 
						+ 
					ifnull((SELECT SUM(biaya_pekerjaan) FROM (viewstatbiaya) WHERE ((MONTH(tgl_bayar)=12) AND (YEAR(tgl_bayar)='$value') AND (status='1')))
						,0)) AS 'Desember'
				FROM viewstatbiaya GROUP BY YEAR(tgl_bayar)";

		return $this->db->query($query)->row_array();
	}

	public function tambahan_bln($value)
	{
		$query = " SELECT
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=1) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'Januari',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=2) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'Februari',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=3) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'Maret',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=4) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'April',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=5) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'Mei',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=6) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'Juni',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=7) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'Juli',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=8) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'Agustus',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=9) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'September',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=10) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'Oktober',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=11) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'November',
					ifnull((SELECT SUM(nominal_pengeluaran) FROM (pengeluaran_tambahan) WHERE ((MONTH(tgl_pengeluaran)=12) AND (YEAR(tgl_pengeluaran)='$value'))),0) AS 'Desember'
				 FROM pengeluaran_tambahan GROUP BY YEAR(tgl_pengeluaran)";

		return $this->db->query($query)->row_array(); 
	}

}

/* End of file RekapModel.php */
/* Location: ./application/models/RekapModel.php */