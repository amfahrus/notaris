<div class="container">
  <h4 class="text-center text-uppercase">BERANDA</h4>
  <div class="panel panel-default">
    <div class="panel-body">
      <p>Selamat Datang, <?php echo $this->session->userdata('SESS_USERNAME'); ?></p>
      <div class="list-group">
        <?php if ($this->session->userdata('SESS_HAK_AKSES') == 0): ?>
          <a class="list-group-item" href="<?php echo base_url().'Home/pkj_pending';?>"><span class="badge"><?php echo $pending; ?></span> Pekerjaan Baru Belum Diterima</a>
          <a class="list-group-item" href="<?php echo base_url().'Home/berkas_pekerjaan/hari';?>"><span class="badge"><?php echo $pkMasuk; ?></span> Pekerjaan Masuk Hari Ini</a>
          <a class="list-group-item" href="<?php echo base_url().'Home/pengeluaran_kerja/belum';?>"><span class="badge"><?php echo $biayaKerja; ?></span> Biaya Kerja Belum Dibayar</a>
        <?php elseif ($this->session->userdata('SESS_HAK_AKSES') == 1): ?>
          <p>Silahkan Gunakan Menu Diatas Untuk Mengelola User</p>
        <?php else: ?>
          <a class="list-group-item" href="<?php echo base_url().'Home/pkj_pending/user'; ?>"><span class="badge"><?php echo $userPending; ?></span> Pekerjaan Anda Belum Diterima</a>
          <a class="list-group-item" href="<?php echo base_url().'Home/berkas_pekerjaan/undone'; ?>"><span class="badge"><?php echo $blmSelesai; ?></span> Pekerjaan Anda Belum Selesai</a>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>