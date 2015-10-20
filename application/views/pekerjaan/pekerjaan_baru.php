<div class="container">
	<h4 class="text-center text-uppercase">PEKERJAAN BARU <?php echo $pkj;?></h4>
	<div class="panel panel-default">
		<form action="<?php echo base_url().'Home/input_pkj_baru/'.$aktor.'/'.$pkj;?>" method="POST">
			<table id="table_pkj_baru" class="table">
				<?php if ($aktor === "PPAT"): ?>
				<tr>
					<td>Nama Penjual</td>
					<td colspan="2">
						<?php if (!$this->session->userdata('SESS_PENJUAL_ID')): ?>
						<div class="btn-group" role="group" aria-label="...">
							<a href="<?php echo base_url().'Home/tmb_klien_pkj/'.$aktor.'/'.$pkj.'/1';?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Tambah Klien"><span class="glyphicon glyphicon-plus"></span></a>
							<a href="<?php echo base_url().'Home/ambil_klien_pkj/'.$aktor.'/'.$pkj.'/1';?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Ambil Klien"><span class="glyphicon glyphicon-folder-open"></span></a>
						</div>
						<?php else: ?>
						<?php echo $this->session->userdata('SESS_PENJUAL_NAME'); ?>
						<a href="<?php echo base_url().'Home/reset_data/'.$aktor.'/'.$pkj.'/1';?>" data-toggle="tooltip" data-placement="right" title="Batalkan Penjual"><span class="glyphicon glyphicon-remove"></span></a>
						<?php endif ?>
					</td>
				</tr>
				<tr>
					<td>Nama Pembeli</td>
					<td colspan="2">
						<?php if (!$this->session->userdata('SESS_PEMBELI_ID')): ?>
						<div class="btn-group" role="group" aria-label="...">
							<a href="<?php echo base_url().'Home/tmb_klien_pkj/'.$aktor.'/'.$pkj.'/2';?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Tambah Klien"><span class="glyphicon glyphicon-plus"></span></a>
							<a href="<?php echo base_url().'Home/ambil_klien_pkj/'.$aktor.'/'.$pkj.'/2';?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Ambil Klien"><span class="glyphicon glyphicon-folder-open"></span></a>
						</div>
						<?php else: ?>
						<?php echo $this->session->userdata('SESS_PEMBELI_NAME'); ?>
						<a href="<?php echo base_url().'Home/reset_data/'.$aktor.'/'.$pkj.'/2';?>" data-toggle="tooltip" data-placement="right" title="Batalkan Pembeli"><span class="glyphicon glyphicon-remove"></span></a>
						<?php endif ?>
					</td>
				</tr>
				<tr>
					<td>Data Tanah</td>
					<td colspan="2">
						<?php if (!$this->session->userdata('SESS_TANAH_ID')): ?>
						<div class="btn-group" role="group" aria-label="...">
							<a href="<?php echo base_url().'Home/tmb_tanah_pkj/'.$aktor.'/'.$pkj.'/4';?>" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Tambah Tanah"><span class="glyphicon glyphicon-plus"></span></a>
							<a href="<?php echo base_url().'Home/ambil_tanah_pkj/'.$aktor.'/'.$pkj.'/4';?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Ambil Tanah"><span class="glyphicon glyphicon-folder-open"></span></a>
						</div>
						<?php else: ?>
						<?php echo $this->session->userdata('SESS_TANAH_NAME'); ?>
						<a href="<?php echo base_url().'Home/reset_data/'.$aktor.'/'.$pkj.'/4';?>" data-toggle="tooltip" data-placement="right" title="Batalkan Tanah"><span class="glyphicon glyphicon-remove"></span></a>
						<?php endif ?>
					</td>
				</tr>
				<?php else: ?>
				<tr>
					<td>Nama Pemohon</td>
					<td colspan="2">
						<?php if (!$this->session->userdata('SESS_PEMOHON_ID')): ?>
						<div class="btn-group" role="group" aria-label="...">
							<a href="<?php echo base_url().'Home/tmb_klien_pkj/'.$aktor.'/'.$pkj.'/3';?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Tambah Klien"><span class="glyphicon glyphicon-plus"></span></a>
							<a href="<?php echo base_url().'Home/ambil_klien_pkj/'.$aktor.'/'.$pkj.'/3';?>" class="btn btn-default"  data-toggle="tooltip" data-placement="top" title="Ambil Klien"><span class="glyphicon glyphicon-folder-open"></span></a>
						</div>
						<?php else: ?>
						<?php echo $this->session->userdata('SESS_PEMOHON_NAME'); ?>
						<a href="<?php echo base_url().'Home/reset_data/'.$aktor.'/'.$pkj.'/3';?>" data-toggle="tooltip" data-placement="right" title="Batalkan Pemohon"><span class="glyphicon glyphicon-remove"></span></a>
						<?php endif ?>
					</td>
				</tr>
				<tr>
					<td>Nama Instansi</td>
					<td colspan="2">
						<input type="text" name="instansi" class="form-control" value="" placeholder="Masukkan Nama Instansi" data-toggle="tooltip" data-placement="top" title="Kosongi Bila Tidak Diperlukan">
					</td>
				</tr>
				<?php endif ?>
				<tr>
					<td>Lokasi Penyimpanan</td>
					<td colspan="2">
						<input type="text" name="lokasi" class="form-control" value="" placeholder="Masukkan Lokasi Penyimpanan Berkas Anda" required >
					</td>
				</tr>
				<tr class="warning">
					<th colspan="3">
						<h4 class="text-center">Syarat Pekerjaan yang Dibutuhkan</h4>
					</th>
				</tr>
				<?php if ($syarat === 'kosong'): ?>
				<tr>
					<td colspan="3">Belum Ada Syarat Untuk Pekerjaan Ini</td>
				</tr>
				<?php else: ?>
				<tr>
					<td colspan="3"><a href="#" id="tmbSrt" class="pull-left"><span class="glyphicon glyphicon-plus"></span> Tambah Baris Syarat</a></td>
				</tr>
				<tr id="baris">
					<td>
						<select name="tmb_syarat[]" class="form-control">
							<?php foreach ($syarat as $srt): ?>
							<option value="<?php echo $srt->id_syarat;?>"><?php echo $srt->syarat;?></option>
							<?php endforeach ?>
						</select>
					</td>
					<td>
						<input type="text" class="form-control" name="tmb_ket_syarat[]" placeholder="Keterangan Syarat">
					</td>
					<td>
						<a href="#" class="btn btn-danger pull-right delRow" style="visibility: hidden;"><span class="glyphicon glyphicon-remove"></span></a>
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<td colspan="3">
						<div class="form-group pull-right">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>