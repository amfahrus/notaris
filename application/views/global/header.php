<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>SI Notaris</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/datepicker.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="navbar-brand" href="#">SI Ke<span class="navbvar-brand navbar-span">notariat</span>an</span>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="menu">
          <ul class="nav navbar-nav">
            <?php 
            $beranda = "";
            $dft_pkj = "";
            $dft_klien = "";
            $dft_tanah = "";
            $baru = "";
            $berkas = "";
            $rekap = "";
            $pengeluaran = "";
            $akun = "";
              switch ($this->uri->segment(2)) {
                case '':
                  $beranda = "active";
                  break;

                case 'daftar_pekerjaan':
                  $dft_pkj = "active";
                  break;

                case 'detail_pekerjaan':
                  $dft_pkj = "active";
                  break;

                case 'daftar_klien':
                  $dft_klien = "active";
                  break;

                case 'tambah_klien':
                  $dft_klien = "active";
                  break;

                case 'edit_klien':
                  $dft_klien = "active";
                  break;

                case 'daftar_tanah':
                  $dft_tanah = "active";
                  break;

                case 'tambah_tanah':
                  $dft_tanah = "active";
                  break;

                case 'edit_tanah':
                  $dft_tanah = "active";
                  break;

                case 'baru':
                  $baru = "active";
                  break;

                case 'ambil_klien_pkj':
                  $baru = "active";
                  break;

                case 'tmb_klien_pkj':
                  $baru = "active";
                  break;

                case 'ambil_tanah_pkj':
                  $baru = "active";
                  break;

                case 'tmb_tanah_pkj':
                  $baru = "active";
                  break;

                case 'pkj_pending':
                  $berkas = "active";
                  break;

                case 'berkas_pekerjaan':
                  $berkas = "active";
                  break;

                case 'edit_berkas':
                  $berkas = "active";
                  break;

                case 'biaya_berkas':
                  $berkas = "active";
                  break;

                case 'pkj_selesai':
                  $berkas = "active";
                  break;

                case 'rekap_pekerjaan':
                  $rekap = "active";
                  break;

                case 'pengeluaran_kerja':
                  $pengeluaran = "active";
                  break;

                case 'pengeluaran_tambahan':
                  $pengeluaran = "active";
                  break;

                case 'rekap_pendapatan':
                  $rekap = "active";
                  break;

                case 'grafik_pendapatan':
                  $rekap = "active";
                  break;
                
                case 'setting_akun':
                  $akun = "active";
                  break;

                case 'data_user':
                  $akun = "active";
                  break;
              }
            ?>
              
            <li class="<?php echo $beranda;?>"><a href="<?php echo base_url(); ?>">Beranda <span class="sr-only">(current)</span></a></li>
            <?php if ($this->session->userdata('SESS_HAK_AKSES') != 1): ?>
            <li class="dropdown <?php echo $dft_pkj;?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Daftar Pekerjaan <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo base_url(); ?>Home/daftar_pekerjaan/Notaris">Notaris</a></li>
                <li><a href="<?php echo base_url(); ?>Home/daftar_pekerjaan/PPAT">PPAT</a></li>
              </ul>
            </li>
            <li class="<?php echo $dft_klien;?>"><a href="<?php echo base_url(); ?>Home/daftar_klien">Klien</a></li>
            <li class="<?php echo $dft_tanah;?>"><a href="<?php echo base_url(); ?>Home/daftar_tanah">Data Tanah</a></li>
            <li class="dropdown <?php echo $baru;?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pekerjaan Baru <span class="caret"></span></a>
              <ul class="dropdown-menu scrollable-menu" role="menu">
                <li class="dropdown-header">Notaris</li>
                <?php foreach ($dataBaruNotaris as $notaris):?>
                  <li><a href="<?php echo base_url().'Home/baru/Notaris/'.$notaris->nama_pekerjaan;?>"><?php echo $notaris->nama_pekerjaan; ?></a></li>
                <?php endforeach ?> 
                <li class="divider"></li>
                <li class="dropdown-header">PPAT</li>
                <?php foreach ($dataBaruPpat as $ppat): ?>
                  <li><a href="<?php echo base_url().'Home/baru/PPAT/'.$ppat->nama_pekerjaan;?>"><?php echo $ppat->nama_pekerjaan;?></a></li>
                <?php endforeach ?>
              </ul>
            </li>
            <li class="<?php echo $berkas;?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Berkas Pekerjaan <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo base_url();?>Home/pkj_pending">Penerimaan Tertunda <span class="header badge"><?php echo $pkjPending;?></span></a></li>
                  <li><a href="<?php echo base_url();?>Home/berkas_pekerjaan">Dalam Proses <span class="header badge"><?php echo $pkjProses;?></span></a></li>
                  <li><a href="<?php echo base_url();?>Home/pkj_selesai">Pekerjaan Selesai <span class="header badge"><?php echo $pkjSelesai;?></span></a></li>
              </ul>
            </li>
            <?php if ($this->session->userdata('SESS_HAK_AKSES') == 0): ?>
            <li class="dropdown <?php echo $pengeluaran;?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pengeluaran <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo base_url().'Home/pengeluaran_kerja';?>">Pengeluaran Kerja</a></li>
                <li><a href="<?php echo base_url().'Home/pengeluaran_tambahan';?>">Pengeluaran Tambahan</a></li>
              </ul>
            </li>
            <?php endif ?>
            <li class="dropdown <?php echo $rekap;?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Rekap Data <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
              <li><a href="<?php echo base_url();?>Home/rekap_pekerjaan">Rekap Pekerjaan</a></li>
              <?php if ($this->session->userdata('SESS_HAK_AKSES') == 0): ?>
                  <li><a href="<?php echo base_url().'Home/rekap_pendapatan';?>">Rekap Pendapatan</a></li>
                  <li><a href="<?php echo base_url().'Home/grafik_pendapatan';?>">Grafik Pendapatan</a></li>
              <?php endif ?>
              </ul>
            </li>
          </ul>
            <?php endif ?>
          <ul class="nav navbar-nav navbar-right" id="pengguna">
            <li class="dropdown <?php echo $akun;?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <?php echo $this->session->userdata('SESS_USERNAME'); ?><span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu" >
                <li><a href="<?php echo base_url().'Home/setting_akun'; ?>">Akun Setting</a></li>
                <?php if ($this->session->userdata('SESS_HAK_AKSES') == 1): ?>
                  <li><a href="<?php echo base_url().'Home/data_user'?>">Kelola User</a></li>
                <?php endif ?>
                <li class="divider"></li>
                <li class="logout"><a href="<?php echo base_url(); ?>Logout"><span class="glyphicon glyphicon-log-out"></span>  Keluar</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <br><br>