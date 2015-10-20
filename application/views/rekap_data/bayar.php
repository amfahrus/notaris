<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="mySmallModalLabel">Perubahan Biaya Kerja <?php echo $biaya->langkah_pekerjaan; ?></h4>
</div>
<div class="modal-body">
  <?php
  $desimal = "2";
  $pemecah_desimal = ",";
  $pemecah_ribuan = ".";
  ?>
  <p>Biaya kerja untuk <?php echo $biaya->langkah_pekerjaan; ?> telah dirubah menjadi Rp <?php echo number_format($biaya->biaya_default, $desimal, $pemecah_desimal, $pemecah_ribuan);?></p>
  <p>Sedangkan Anda telah membayar biaya kerja <?php echo $biaya->langkah_pekerjaan; ?> senilai Rp <?php echo number_format($biaya->biaya_bayar, $desimal, $pemecah_desimal, $pemecah_ribuan);?></p>
  <p>Ganti pembayaran Anda sesuai dengan biaya kerja baru?</p>
</div>
<div class="modal-footer">
  <div class="text-right">
    <a href="<?php echo base_url().'Home/ganti_bayar/y/'.$biaya->id_berkas.'/'.$biaya->id_detail; ?>" class="btn btn-primary">Ya</a>
    <a href="<?php echo base_url().'Home/ganti_bayar/n/'.$biaya->id_berkas.'/'.$biaya->id_detail; ?>" class="btn btn-danger">Tidak</a>
  </div>
</div>