<?php if ($this->session->userdata('SESS_HAK_AKSES') !== '0'): ?>
<h1>AKSES DITOLAK</h1>
<?php else: ?>
	<?php
		 $desimal = "2";
		 $pemecah_desimal = ",";
		 $pemecah_ribuan = ".";
	 ?>
<div class="container">
	<h4 class="text-center text-uppercase">PENGELUARAN TAMBAHAN</h4>
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
		<div class="panel-body">
			<div class="dropdown pull-right">
				<a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
					<span class="glyphicon glyphicon-list"></span>  <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo base_url().'Home/pengeluaran_tambahan';?>">Semua</a></li>
					<li><a href="<?php echo base_url().'Home/pengeluaran_tambahan/tgl';?>">Tanggal</a></li>
					<li><a href="<?php echo base_url().'Home/pengeluaran_tambahan/bln';?>">Bulan</a></li>
				</ul>
			</div>
			<button class="btn btn-primary" data-toggle="modal" data-target=".tambah-pengeluaran">
			<span class="glyphicon glyphicon-plus"></span> Tambah
			</button>
			<p></p>
			<div class="panel panel-info">
				<?php if ($sort !== "all"): ?>
				<div class="panel-heading text-center">
					<?php
					if ($sort === "tgl"):
						$tanggal = ($now === "") ? $tanggal = gmdate('Y-m-d', time()+60*60*7) : $tanggal = $now ;
						$colspan = "2";
						$hari = substr($tanggal, 8,2);
						$bln = substr($tanggal, 5,2);
						$thn = substr($tanggal, 0,4);
						$kemarin = date('Y-m-d', mktime(0,0,0, $bln,$hari-1,$thn));
						$besok = date('Y-m-d', mktime(0,0,0, $bln,$hari+1,$thn));
						if ($besok !== gmdate('Y-m-d', time()+60*60*7)) {
							$linkbsk = base_url().'Home/pengeluaran_tambahan/'.$sort.'/'.$besok;
						}else{
							$linkbsk = base_url().'Home/pengeluaran_tambahan/'.$sort;
						}
						if ($kemarin !== gmdate('Y-m-d', time()+60*60*7)) {
							$linkkmr = base_url().'Home/pengeluaran_tambahan/'.$sort.'/'.$kemarin;
						}else{
							$linkkmr = base_url().'Home/pengeluaran_tambahan/'.$sort;
						}
					else:
						$tanggal = ($now === "") ? $tanggal = gmdate('Y-m', time()+60*60*7) : $tanggal = $now ;
						$colspan = "3";
						$kemarin = date('Y-m', strtotime($tanggal." -1 month"));
						$besok = date('Y-m', strtotime($tanggal." +1 month"));
						if ($besok != gmdate('Y-m', time()+60*60*7)) {
							$linkbsk = base_url().'Home/pengeluaran_tambahan/'.$sort.'/'.$besok;
						}else{
							$linkbsk = base_url().'Home/pengeluaran_tambahan/'.$sort;
						}
						if ($kemarin !== gmdate('Y-m', time()+60*60*7)) {
							$linkkmr = base_url().'Home/pengeluaran_tambahan/'.$sort.'/'.$kemarin;
						}else{
							$linkkmr = base_url().'Home/pengeluaran_tambahan/'.$sort;
						}
					endif ?>
					<a href="<?php echo $linkkmr;?>">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<?php echo $tanggal;?>
					<?php if ($now !== ''): ?>
					<a href="<?php echo $linkbsk;?>">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
					<?php endif ?>
				</div>
				<?php else: ?>
				<?php $colspan = 3;?>
				<?php endif ?>
				<table class="table table-hover text-center">
					<tr class="danger">
						<?php if ($sort !== "tgl"): ?>
						<td><strong>Tanggal</strong></td>
						<?php endif ?>
						<td><strong>Nominal</strong></td>
						<td><strong>Keterangan</strong></td>
					</tr>
					<?php if (count($tgl) > 0): ?>
					<?php foreach ($tgl as $t): ?>
					<tr class="row-modal" data-toggle="modal" data-target=".menu" data-jenis="tambahan" data-id="<?php echo $t->id_pengeluaran;?>" data-nominal="<?php echo $t->nominal_pengeluaran;?>" data-ket="<?php echo $t->ket_pengeluaran;?>">
						<?php if ($sort !== "tgl"): ?>
						<td><?php echo $t->tgl_pengeluaran;?></td>
						<?php endif ?>
						<td>Rp <?php echo number_format($t->nominal_pengeluaran, $desimal, $pemecah_desimal, $pemecah_ribuan);?></td>
						<td><?php echo $t->ket_pengeluaran;?></td>
					</tr>
					<?php endforeach ?>
					<?php else: ?>
					<tr>
						<td colspan="<?php echo $colspan;?>">Belum Ada Tambahan Pengeluaran</td>
					</tr>
					<?php endif ?>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- modal menu-->
<div class="modal fade menu" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="mySmallModalLabel">Pilih Menu</h4>
			</div>
			<div class="modal-body">
				<ul class="list-group">
					<a id="edit" href="#" data-toggle="modal" data-target=".edit-tambahan" data-id="" data-nominal="" data-ket="" class="list-group-item"><span class="glyphicon glyphicon-edit "></span>  Edit</a>
					<a id="delete" href="#" data-toggle="modal" data-target=".delete" data-id="" class="list-group-item"><span class="glyphicon glyphicon-trash"></span>  Hapus</a>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- modal tambah pengeluaran -->
<div class="modal fade tambah-pengeluaran" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="mySmallModalLabel">Tambah Pengeluaran</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>Home/tambah_pengeluaran_tambahan" method="POST">
					<div class="form-group">
						<label for="inputTanggal">Tanggal</label>
						<input type="text" class="form-control datepick" placeholder="yyyy-mm-dd" name="tanggal" id="inputTanggal" value="" autofocus required>
					</div>
					<div class="form-group">
						<label for="inputNominal">Nominal</label>
						<input type="text" class="form-control" name="nominal" id="inputNominal" value="" placeholder="Masukkan Nominal" autofocus required>
					</div>
					<div class="form-group">
						<label for="inputKet">Keterangan</label>
						<input type="text" class="form-control" name="ket" id="inputKet" value="" placeholder="Masukkan Keterangan" required>
					</div>
					<button type="submit" class="btn btn-primary btn-block">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- modal edit tambahan -->
<div class="modal fade edit-tambahan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="mySmallModalLabel">Edit Pengeluaran Tambahan</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>Home/edit_pengeluaran_tambahan" method="POST">
					<input type="hidden" name="id" id="inputId" value="">
					<div class="form-group">
						<label for="inputNominal">Nominal</label>
						<input type="text" class="form-control" name="nominal" id="inputNominal" value="" placeholder="Masukkan Nominal" autofocus required>
					</div>
					<div class="form-group">
						<label for="inputKet">Keterangan</label>
						<input type="text" class="form-control" name="ket" id="inputKet" value="" placeholder="Masukkan Keterangan" required>
					</div>
					<button type="submit" class="btn btn-primary btn-block">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- modal delete -->
<div class="modal fade delete" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="mySmallModalLabel">Verifikasi</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url();?>Home/delete_pengeluaran_tambahan" method="POST">
					<div class="form-group">
						<input type="hidden" name="id" id="inputId" value="">
						<label for="verPass">Password</label>
						<input type="password" class="form-control" name="pwver" id="verPass" placeholder="Masukkan Password Anda" autofocus required>
					</div>
					<button type="submit" class="btn btn-primary btn-block">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>