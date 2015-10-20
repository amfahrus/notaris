<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="mySmallModalLabel">Pelunasan Biaya</h4>
</div>
<div class="modal-body">
	<?php
		 $desimal = "2";
		 $pemecah_desimal = ",";
		 $pemecah_ribuan = ".";
	 ?>
	<form action="<?php echo base_url();?>Home/bayar_pelunasan" method="POST">
		<?php $kurang = $berkas->biaya_klien - $berkas->biaya_titip;?>
		<input type="hidden" name="id" value="<?php echo $berkas->id_berkas;?>">
		<input type="hidden" name="kurang" value="<?php echo $kurang;?>">
		<p>Biaya Klien sebesar <strong>Rp <?php echo number_format($berkas->biaya_klien, $desimal, $pemecah_desimal, $pemecah_ribuan);?></strong></p>
		<?php 
			if ($berkas->biaya_titip == NULL) {
				$titip = 0;
			}else{
				$titip = $berkas->biaya_titip;
			}
		 ?>
		<p>Biaya yang Telah Dibayar Klien sebesar <strong>Rp <?php echo number_format($titip, $desimal, $pemecah_desimal, $pemecah_ribuan);?></strong></p>
		<p>Kekurangan Biaya Klien sebesar <strong>Rp <?php echo number_format($kurang, $desimal, $pemecah_desimal, $pemecah_ribuan);?></strong></p>
		<?php if ($this->session->userdata('SESS_HAK_AKSES') == 0): ?>
			<p>Lunasi Sekarang?</p>
			<button type="submit" class="btn btn-primary btn-block">Ya</button>
		<?php endif ?>
	</form>
</div>