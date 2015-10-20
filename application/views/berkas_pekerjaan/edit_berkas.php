<div class="container">
	<h4 class="text-center text-uppercase">EDIT BERKAS #BKS<?php echo $id_berkas;?></h4>
	<div class="panel panel-default">
		<?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismisable" role="alert">
          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php echo $this->session->flashdata('success'); ?>
        </div>
	    <?php endif; ?>
	    <?php if ($this->session->flashdata('error')): ?>
	        <div class="alert alert-danger alert-dismisable" role="alert">
	          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	          <span class="sr-only">Error:</span>
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <?php echo $this->session->flashdata('error'); ?>
	        </div>
	    <?php endif; ?>
		<div class="panel-heading">
			<a href="<?php echo base_url();?>Home/berkas_pekerjaan"><span class="glyphicon glyphicon-menu-left"></span>Kembali ke Berkas Pekerjaan</a>
		</div>
		<form action="<?php echo base_url().'Home/update_berkas/'.$id_berkas;?>" method="post">
		<table class="table" id="editBerkas">
			<?php if ($berkas->jenis_aktor == "Notaris"): ?>
			<tr>
				<td>Pemohon</td>
				<td colspan="3">
					<?php if ($aksi == "pemohon"): ?>
						<a href="<?php echo base_url().'Home/tmb_klien_berkas/'.$id_berkas.'/'.$tipe;?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Tambah Klien"><span class="glyphicon glyphicon-plus"></span></a>
						<a href="<?php echo base_url().'Home/ambil_klien_berkas/'.$id_berkas.'/'.$tipe;?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Ambil Klien"><span class="glyphicon glyphicon-folder-open"></span></a>
						<a href="<?php echo base_url().'Home/edit_berkas/'.$id_berkas;?>" data-toggle="tooltip" data-placement="right" title="Batal"><span class="glyphicon glyphicon-remove"></span></a>
					<?php else: ?>
						<?php if (!$this->session->userdata('SESS_PEMOHON_ID')): ?>
							<?php echo $berkas->nama_pemohon;?>
							<a href="<?php echo base_url().'Home/edit_berkas/'.$id_berkas.'/pemohon';?>" data-toggle="tooltip" data-placement="top" title="Edit Pemohon"><span class="glyphicon glyphicon-edit"></span></a>
						<?php else: ?>
							<?php echo $this->session->userdata('SESS_PEMOHON_NAME'); ?>
							<a href="<?php echo base_url().'Home/reset_data_berkas/'.$id_berkas.'/3';?>" data-toggle="tooltip" data-placement="right" title="Batalkan Pemohon"><span class="glyphicon glyphicon-remove"></span></a>
						<?php endif ?>
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<td>Instansi</td>
				<td colspan="3"><input type="text" class="form-control" name="instansi" value="<?php echo $berkas->nama_instansi;?>" placeholder="Masukkan Nama Instansi"></td>
			</tr>
			<?php else: ?>
			<tr>
				<td>Pembeli</td>
				<td colspan="3">
					<?php if ($aksi == "pembeli"): ?>
						<a href="<?php echo base_url().'Home/tmb_klien_berkas/'.$id_berkas.'/'.$tipe;?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Tambah Klien"><span class="glyphicon glyphicon-plus"></span></a>
						<a href="<?php echo base_url().'Home/ambil_klien_berkas/'.$id_berkas.'/'.$tipe;?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Ambil Klien"><span class="glyphicon glyphicon-folder-open"></span></a>
						<a href="<?php echo base_url().'Home/edit_berkas/'.$id_berkas;?>" data-toggle="tooltip" data-placement="right" title="Batal"><span class="glyphicon glyphicon-remove"></span></a>
					<?php else: ?>
						<?php if (!$this->session->userdata('SESS_PEMBELI_ID')): ?>
							<?php echo $berkas->nama_pembeli;?>
							<a href="<?php echo base_url().'Home/edit_berkas/'.$id_berkas.'/pembeli';?>" data-toggle="tooltip" data-placement="top" title="Edit Pembeli"><span class="glyphicon glyphicon-edit"></span></a>
						<?php else: ?>
							<?php echo $this->session->userdata('SESS_PEMBELI_NAME'); ?>
							<a href="<?php echo base_url().'Home/reset_data_berkas/'.$id_berkas.'/2';?>" data-toggle="tooltip" data-placement="right" title="Batalkan Pemohon"><span class="glyphicon glyphicon-remove"></span></a>
						<?php endif ?>
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<td>Penjual</td>
				<td colspan="3">
					<?php if ($aksi == "penjual"): ?>
						<a href="<?php echo base_url().'Home/tmb_klien_berkas/'.$id_berkas.'/'.$tipe;?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Tambah Klien"><span class="glyphicon glyphicon-plus"></span></a>
						<a href="<?php echo base_url().'Home/ambil_klien_berkas/'.$id_berkas.'/'.$tipe;?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Ambil Klien"><span class="glyphicon glyphicon-folder-open"></span></a>
						<a href="<?php echo base_url().'Home/edit_berkas/'.$id_berkas;?>" data-toggle="tooltip" data-placement="right" title="Batal"><span class="glyphicon glyphicon-remove"></span></a>
					<?php else: ?>
						<?php if (!$this->session->userdata('SESS_PENJUAL_ID')): ?>
							<?php echo $berkas->nama_penjual;?>
							<a href="<?php echo base_url().'Home/edit_berkas/'.$id_berkas.'/penjual';?>" data-toggle="tooltip" data-placement="top" title="Edit Penjual"><span class="glyphicon glyphicon-edit"></span></a>
						<?php else: ?>
							<?php echo $this->session->userdata('SESS_PENJUAL_NAME'); ?>
							<a href="<?php echo base_url().'Home/reset_data_berkas/'.$id_berkas.'/1';?>" data-toggle="tooltip" data-placement="right" title="Batalkan Pemohon"><span class="glyphicon glyphicon-remove"></span></a>
						<?php endif ?>
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<td>Tanah</td>
				<td colspan="3">
					<?php if ($aksi == "tanah"): ?>
						<a href="<?php echo base_url().'Home/tmb_tanah_berkas/'.$id_berkas.'/'.$tipe;?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Tambah Tanah"><span class="glyphicon glyphicon-plus"></span></a>
						<a href="<?php echo base_url().'Home/ambil_tanah_berkas/'.$id_berkas.'/'.$tipe;?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Ambil Tanah"><span class="glyphicon glyphicon-folder-open"></span></a>
						<a href="<?php echo base_url().'Home/edit_berkas/'.$id_berkas;?>" data-toggle="tooltip" data-placement="right" title="Batal"><span class="glyphicon glyphicon-remove"></span></a>
					<?php else: ?>
						<?php if (!$this->session->userdata('SESS_TANAH_ID')): ?>
							<?php echo $berkas->no_hak;?>
							<a href="<?php echo base_url().'Home/edit_berkas/'.$id_berkas.'/tanah';?>" data-toggle="tooltip" data-placement="top" title="Edit Tanah"><span class="glyphicon glyphicon-edit"></span></a>
						<?php else: ?>	
							<?php echo $this->session->userdata('SESS_TANAH_NAME'); ?>
							<a href="<?php echo base_url().'Home/reset_data_berkas/'.$id_berkas.'/4';?>" data-toggle="tooltip" data-placement="right" title="Batalkan Pemohon"><span class="glyphicon glyphicon-remove"></span></a>
						<?php endif ?>
					<?php endif ?>
				</td>
			</tr>
			<?php endif ?>
			<tr>
				<td>Lokasi Penyimpanan</td>
				<td colspan="3"><input type="text" class="form-control" name="lokasi" value="<?php echo $berkas->lokasi_penyimpanan;?>" placeholder="Masukkan Lokasi Penyimpanan Berkas Anda"></td>
			</tr>
			<?php if ($syarat === 'kosong'): ?>
			<tr>
				<td colspan="4">Belum Ada Syarat Untuk Pekerjaan Ini</td>
			</tr>
			<?php else: ?>
			<tr>
				<td colspan="4"><a href="javascript:void(0);" id="tmbSrt"  class="pull-left"><span class="glyphicon glyphicon-plus"></span> Tambah Baris Syarat</a></td>
			</tr>
			<?php foreach ($stat_syarat as $stat): ?>
			<input type="hidden" name="id_ket[]" value="<?php echo $stat->id_ket;?>">
			<tr id="baris">
				<td>
					<select name="syarat[]" class="form-control">
						<option value="<?php echo $stat->id_syarat;?>" selected><?php echo $stat->syarat;?></option>
						<?php foreach ($syarat as $srt): ?>
						<?php if ($srt->id_syarat != $stat->id_syarat): ?>
							<option value="<?php echo $srt->id_syarat;?>"><?php echo $srt->syarat;?></option>
						<?php endif ?>
						<?php endforeach ?>
					</select>
				</td>
				<td>
					<input type="text" class="form-control" name="ket_syarat[]" value="<?php echo $stat->keterangan;?>" placeholder="Keterangan Syarat">
				</td>
				<td class="delete">
					<a href="#" data-id-berkas="<?php echo $id_berkas; ?>" data-id-ket="<?php echo $stat->id_ket; ?>" style="visibility: visible;" class="btn btn-danger del"><span class="glyphicon glyphicon-trash"></span></a>

				</td>
			</tr>
			<?php endforeach ?>
			<?php endif; ?>
			<tr id="baris"></tr>
			<tr class="hide">
				<td colspan="4">
					<div id="daftar_berkas_dihapus"></div>
					<div id="daftar_ket_dihapus"></div>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<div class="form-group pull-right">
						<input type="submit" class="btn btn-primary" name="submit" value="Submit">
					</div>
				</td>
			</tr>
		</table>
		</form>
	</div>
</div>