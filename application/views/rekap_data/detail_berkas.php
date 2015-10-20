<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="mySmallModalLabel">Detail Berkas</h4>
</div>
<ul class="list-group">
	<li class="list-group-item">Pekerjaan : <strong><?php echo $berkas->nama_pekerjaan;?></strong></li>
    <li class="list-group-item ">Lokasi : <strong><?php echo $berkas->lokasi_penyimpanan;?></strong></li>
	<li class="list-group-item ">Tanggal : <strong><?php echo $berkas->tgl_masuk_pekerjaan;?></strong></li>
	<?php if ($berkas->jenis_aktor == "Notaris"): ?>
		<li class="list-group-item ">Pemohon : 
				<strong><?php echo $berkas->nama_pemohon;?></strong>
		</li>
		<?php if ($berkas->nama_instansi != ""): ?>
			<li class="list-group-item ">Instansi : <strong><?php echo $berkas->nama_instansi;?></strong></li>
		<?php endif ?>
	<?php else: ?>
		<li class="list-group-item ">Penjual : 
			<strong><?php echo $berkas->nama_penjual;?></strong>
		</li>
		<li class="list-group-item ">Pembeli :
			<strong><?php echo $berkas->nama_pembeli;?></strong>
		</li>
		<li class="list-group-item ">Tanah : <strong><?php echo $berkas->no_hak;?></strong></li>
	<?php endif ?>
	<li class="list-group-item ">PJ : <strong><?php echo $berkas->username;?></strong></li>
</ul>