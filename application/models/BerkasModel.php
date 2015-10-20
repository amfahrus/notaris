<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BerkasModel extends CI_Model {

	public function cek_pending()
	{
		$where = array('status' => 0,
						'hapus' => 0 );
		$this->db->where($where);
		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function pending()
	{
		$where = array('status' => 0,
						'hapus' => 0 );
		$this->db->where($where);
		$this->db->order_by('tgl_masuk_pekerjaan desc, id_berkas desc');
		return $this->db->get('viewpkmasuk')->result();
	}

	public function cek_pending_user()
	{
		$un = $this->session->userdata('SESS_USER_ID');
		$where = array('id_user' => $un,
		 				'status' => 0,
						'hapus' => 0);
		$this->db->where($where);
		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function pending_user()
	{
		$un = $this->session->userdata('SESS_USER_ID');
		$where = array('id_user' => $un,
		 				'status' => 0,
						'hapus' => 0);
		$this->db->where($where);
		return $this->db->get('viewpkmasuk')->result();
	}

	public function tabel()
	{
		$where = array('status' => 1,
						'hapus' => 0 );
		$this->db->where($where);
		$this->db->order_by('tgl_masuk_pekerjaan desc, id_berkas desc');
		return $this->db->get('viewpkmasuk')->result();
	}

	public function tabel_pagination($sampai,$dari)
	{
		$where = array('status' => 1,
						'hapus' => 0 );
		$this->db->where($where);
		$this->db->order_by('tgl_masuk_pekerjaan desc, id_berkas desc');
		return $this->db->get('viewpkmasuk',$sampai,$dari)->result();
	}

	public function select_pj()
	{
		$query = "SELECT * FROM  `user` WHERE (hak_akses !=0) AND (hak_akses !=1)";
		return $this->db->query($query)->result();
	}

	public function cek_selesai()
	{
		$where = array('status' => 2,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function selesai()
	{
		$where = array('status' => 2,
						'hapus' => 0);
		$this->db->where($where);
		$this->db->order_by('tgl_masuk_pekerjaan desc, id_berkas desc');

		return $this->db->get('viewpkmasuk')->result();
	}

	public function update_status_diterima($value)
	{
		$tgl = gmdate('Y-m-d', time()+60*60*7);
		$data = array('status' => 1,
						'tgl_diterima_pekerjaan' => $tgl);
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->update('pekerjaan', $data);
	}

	public function update_status_selesai($value)
	{
		$tgl = gmdate('Y-m-d', time()+60*60*7);
		$data = array('status' => 2,
						'tgl_selesai_pekerjaan' => $tgl);
		$where = array('id_berkas' => $value);
		$this->db->where($where);
		
		return $this->db->update('pekerjaan', $data);

	}

	public function cek_tabel()
	{
		$where = array('status' => 1,
						'hapus' => 0 );
		$this->db->where($where);
		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function select_berkas($value)
	{
		$where = array('id_pekerjaan' => $value,
						'status' => 1,
						'hapus' => 0);
		$this->db->where($where);
		$this->db->order_by('tgl_masuk_pekerjaan', 'desc');

		return $this->db->get('viewpkmasuk')->result();
	}	

	public function cek_berkas($value)
	{
		$where = array('id_pekerjaan' => $value,
						'status' => 1,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function cek_berkas_username($username)
	{
		$where = "username = '$username' AND (detail < jml_detail OR syarat < jml_syarat) AND status = '1' AND hapus = '0' ";
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function select_berkas_username($username)
	{
		$where = "username = '$username' AND (detail < jml_detail OR syarat < jml_syarat) AND status = '1' AND hapus = '0' ";
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->result();
	}

	public function cek_berkas_hari_ini($value)
	{
		$where = array('tgl_diterima_pekerjaan' => $value,
						'status' => 1,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function select_berkas_hari_ini($value)
	{
		$where = array('tgl_diterima_pekerjaan' => $value,
						'status' => 1,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->result();
	}

	public function cek_id_berkas($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function select_id_berkas($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->row();
	}

	public function cek_search_id($value)
	{
		$where = array('id_berkas' => $value,
		 				'status' => 1,
						'hapus' => 0);
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function search_id($value)
	{
		$where = array('id_berkas' => $value,
		 				'status' => 1,
						'hapus' => 0);
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
					nama_pembeli LIKE '%$value%') AND status = '1' AND hapus = '0' ";
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->num_rows();
	}

	public function search($value)
	{
		$where = "(id_berkas LIKE '%$value%' OR 
							tgl_masuk_pekerjaan LIKE '%$value%' OR
							lokasi_penyimpanan LIKE '%$value%' OR 
							nama_pekerjaan LIKE '%$value%' OR
							nama_instansi LIKE '%$value%' OR
							no_hak LIKE '%$value%' OR
							nama_pemohon LIKE '%$value%' OR
							nama_penjual LIKE '%$value%' OR
							nama_pembeli LIKE '%$value%') AND status = '1' AND hapus = '0' ";
		$this->db->where($where);

		return $this->db->get('viewpkmasuk')->result();
	}

	public function cek_detail_pkj($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('viewstatdetail')->num_rows();
	}

	public function select_detail_pkj($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);
		$this->db->order_by('id_detail', 'asc');

		return $this->db->get('viewstatdetail')->result();
	}

	public function cek_detail_pkj_null($value)
	{
		$where = array('id_berkas' => $value,
		 				'langkah_pekerjaan' => NULL);
		$this->db->where($where);

		return $this->db->get('viewstatdetail')->num_rows();
	}

	public function select_detail_pkj_null($value)
	{
		$where = array('id_berkas' => $value,
		 				'langkah_pekerjaan' => NULL);
		$this->db->where($where);

		return $this->db->get('viewstatdetail')->result();
	}

	public function select_syarat_pkj($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('viewstatsyarat')->result();
	}

	public function cek_stat_detail($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('status_detail_pekerjaan')->num_rows();
	}

	public function update_stat_detail($berkas,$detail,$stat)
	{
		$data = array('status' => $stat);
		$where = array('id_berkas' => $berkas,
						'id_detail' => $detail );
		$this->db->where($where);

		return $this->db->update('status_detail_pekerjaan', $data);
	}

	public function cek_biaya_detail($berkas,$value)
	{
		$where = array('id_detail' => $value,
						'id_berkas' => $berkas);
		$this->db->where($where);

		return $this->db->get('biaya_detail_pekerjaan')->num_rows();
	}

	public function insert_biaya_detail($berkas,$detail,$biaya)
	{
		$data = array('id_berkas' => $berkas,
		 				'id_detail' => $detail,
		 				'biaya_pekerjaan' => $biaya);

		return $this->db->insert('biaya_detail_pekerjaan', $data);
	}

	public function update_biaya_detail($berkas,$detail,$biaya)
	{
		$data = array('biaya_pekerjaan' => $biaya);
		$where = array('id_berkas' => $berkas,
		 				'id_detail' => $detail);
		$this->db->where($where);

		return $this->db->update('biaya_detail_pekerjaan', $data);
	}

	public function delete_biaya_detail($berkas,$detail)
	{
		$where = array('id_berkas' => $berkas,
		 				'id_detail' => $detail);
		$this->db->where($where);

		return $this->db->delete('biaya_detail_pekerjaan');
	}

	public function delete_biaya_detail_id($value)
	{
		for ($i=0; $i < count($value); $i++) { 
			$where = array('id_berkas' => $value[$i]['id_berkas'],
			 				'id_detail' => $value[$i]['id_detail']);
			$this->db->where($where);

			$a = $this->db->delete('biaya_detail_pekerjaan');
		}
	}

	public function insert_stat_biaya_detail($value,$detail)
	{
		$data = array('id_berkas' => $value,
		 				'id_detail' => $detail);

		return $this->db->insert('status_biaya_pekerjaan', $data);
	}

	public function delete_stat_biaya_detail($value,$detail)
	{
		$where = array('id_berkas' => $value,
		 				'id_detail' => $detail);
		$this->db->where($where);

		return $this->db->delete('status_biaya_pekerjaan');
	}

	public function update_stat_syarat($berkas,$ket,$status)
	{
		$data = array('status' => $status);
		$where = array('id_berkas' => $berkas, 
						'id_ket' =>$ket);
		$this->db->where($where);

		return $this->db->update('status_syarat_pekerjaan', $data);
	}

	public function cek_ket_syarat($berkas,$ket)
	{
		$where = array('id_berkas' => $berkas, 
						'id_ket' => $ket);
		$this->db->where($where);

		return $this->db->get('status_syarat_pekerjaan')->num_rows();
	}

	public function update_ket_syarat($berkas,$ket,$value)
	{
		$data = array('keterangan' => $value);
		$where = array('id_berkas' => $berkas,
		 				'id_ket' => $ket);
		$this->db->where($where);

		return $this->db->update('status_syarat_pekerjaan', $data);
	}

	public function cek_biaya_klien($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('pekerjaan')->num_rows();
	}

	public function select_biaya_klien($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('pekerjaan')->row();
	}

	public function cek_biaya_titip($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('biaya_titip')->num_rows();
	}

	public function select_biaya_titip($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('biaya_titip')->result();
	}

	public function input_biaya_titip($value,$tgl,$biaya)
	{
		$data = array('tgl_titip' => $tgl,
						'biaya_titip' => $biaya,
						'id_berkas' => $value );

		return $this->db->insert('biaya_titip', $data);
	}

	public function update_biaya_klien($value,$biaya)
	{
		$data = array('biaya_klien' => $biaya);
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->update('pekerjaan', $data);
	}

	public function update_biaya_titip($value)
	{
		for ($i=0; $i < count($value); $i++) { 
			$data = array('tgl_titip' => $value[$i]['tgl_titip'],
							'biaya_titip' => $value[$i]['biaya_titip'] );
			$where = array('id_titip' => $value[$i]['id_titip']);
			$this->db->where($where);

			$a = $this->db->update('biaya_titip', $data);
		}

		return $a;
	}

	public function delete_stat_detail($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->delete('status_detail_pekerjaan');
	}

	

	public function delete_stat_pemohon($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->delete('status_pemohon');
	}

	public function delete_stat_syarat($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->delete('status_syarat_pekerjaan');
	}

	public function delete_stat_syarat_id($value,$ket)
	{
		$where = array('id_berkas' => $value, 
						'id_ket' => $ket);
		$this->db->where($where);

		return $this->db->delete('status_syarat_pekerjaan');
	}

	public function cek_stat_tanah($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('status_tanah')->num_rows();
	}

	public function delete_stat_tanah($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->delete('status_tanah');
	}

	public function cek_stat_biaya($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('status_biaya_pekerjaan')->num_rows();
	}

	public function cek_stat_biaya_detail($value)
	{
		$where = array('id_detail' => $value);
		$this->db->where($where);

		return $this->db->get('status_biaya_pekerjaan')->num_rows();
	}

	public function delete_stat_biaya($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->delete('status_biaya_pekerjaan');
	}

	public function cek_biaya_detail_berkas($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('biaya_detail_pekerjaan')->num_rows();
	}

	public function delete_biaya_detail_berkas($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->delete('biaya_detail_pekerjaan');
	}

	public function cek_instansi($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->get('instansi')->num_rows();
	}

	public function insert_instansi($value,$instansi)
	{
		$data = array('id_berkas' => $value,
						'nama_instansi' => $instansi);

		return $this->db->insert('instansi', $data);
	}

	public function update_instansi($value,$instansi)
	{
		$data = array('nama_instansi' => $instansi);
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->update('instansi', $data);
	}

	public function delete_instansi($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->delete('instansi');
	}

	public function delete_biaya_titip($value)
	{
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->delete('biaya_titip');
	}

	public function delete_pekerjaan($value)
	{
		$data = array('hapus' => 1);
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->update('pekerjaan', $data);
	}

	public function update_stat_pemohon($value,$id,$stat)
	{
		$data = array('id_pemohon' => $id);
		$where = array('id_berkas' => $value,
		 				'status' => $stat);
		$this->db->where($where);

		return $this->db->update('status_pemohon', $data);
	}

	public function update_stat_tanah($value,$id)
	{
		$data = array('id_tanah' => $id);
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->update('status_tanah', $data);
	}

	public function update_lokasi($value,$lokasi)
	{
		$data = array('lokasi_penyimpanan' => $lokasi);
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->update('pekerjaan', $data);
	}

	public function lunaskan($id, $biaya_klien)
	{
		$tgl = gmdate('Y-m-d', time()+60*60*7);
		$data = array('id_berkas' => $id,
						'biaya_titip' => $biaya_klien,
						'tgl_titip' => $tgl);

		return $this->db->insert('biaya_titip', $data);
	}

	public function set_selesai($value)
	{
		$tgl = gmdate('Y-m-d', time()+60*60*7);
		$data = array('status' => 3,
						'tgl_selesai_pekerjaan' => $tgl);
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->update('pekerjaan', $data);
	}

	public function ganti_pj($value, $data)
	{
		$object = array('id_user' => $data);
		$where = array('id_berkas' => $value);
		$this->db->where($where);

		return $this->db->update('pekerjaan', $object);
	}

	public function search_berkas_pj($value)
	{
		$where = array('id_user' => $value,
		 				'status' => 1,
		 				'hapus' => 0);

		$this->db->where($where);

		return $this->db->get('pekerjaan')->result();
	}

}

/* End of file BerkasModel.php */
/* Location: ./application/models/BerkasModel.php */