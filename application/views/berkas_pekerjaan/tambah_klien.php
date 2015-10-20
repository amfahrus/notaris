<div class="container">
	<h4 class="text-center text-uppercase">TAMBAH KLIEN</h4>
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
			<a href="<?php echo base_url().'Home/edit_berkas/'.$id_berkas;?>"><span class="glyphicon glyphicon-menu-left"></span>Kembali Ke Edit Berkas</a>
		</div>
		<div class="panel-body">
			<form action="<?php echo base_url().'Home/input_klien_berkas/'.$id_berkas.'/'.$tipe;?>" method="POST">
		        <div class="form-group">
		          <label for="inputKTP">Nomor KTP</label>
		          <input type="number" class="form-control" name="ktp" id="inputKTP" value="<?php if ($this->session->flashdata('ktp')) { echo $this->session->flashdata('ktp');} ?>" placeholder="Masukkan Nomor KTP" autofocus required>
		        </div>
		        <div class="form-group">
		          <label for="inputNama">Nama Lengkap</label>
		          <input type="text" class="form-control" name="nama" id="inputNama" value="<?php if ($this->session->flashdata('nama')) { echo $this->session->flashdata('nama');} ?>" placeholder="Masukkan Nama Lengkap" required>
		        </div>
		        <div class="form-group">
		          <label for="inputJalan">Jalan</label>
		          <input type="text" class="form-control" name="jalan" id="inputJalan" value="<?php if ($this->session->flashdata('jalan')) { echo $this->session->flashdata('jalan');} ?>" placeholder="Masukkan Nama Jalan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputRT">RT</label>
		          <input type="text" class="form-control" name="rt" id="inputRT" value="<?php if ($this->session->flashdata('rt')) { echo $this->session->flashdata('rt');} ?>" placeholder="Masukkan RT" required>
		        </div>
		        <div class="form-group">
		          <label for="inputRW">RW</label>
		          <input type="text" class="form-control" name="rw" id="inputRW" value="<?php if ($this->session->flashdata('rw')) { echo $this->session->flashdata('rw');} ?>" placeholder="Masukkan RW" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKel">Kelurahan</label>
		          <input type="text" class="form-control" name="kel" id="inputKel" value="<?php if ($this->session->flashdata('kel')) { echo $this->session->flashdata('kel');} ?>" placeholder="Masukkan Kelurahan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKec">Kecamatan</label>
		          <input type="text" class="form-control" name="kec" id="inputKec" value="<?php if ($this->session->flashdata('kec')) { echo $this->session->flashdata('kec');} ?>" placeholder="Masukkan Kecamatan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKota">Kota</label>
		          <input type="text" class="form-control" name="kota" id="inputKota" value="<?php if ($this->session->flashdata('kota')) { echo $this->session->flashdata('kota');} ?>" placeholder="Masukkan Kota" required>
		        </div>
		        <div class="form-group">
		          <label for="inputProv">Provinsi</label>
		          <input type="text" class="form-control" name="prov" id="inputProv" value="<?php if ($this->session->flashdata('prov')) { echo $this->session->flashdata('prov');} ?>" placeholder="Masukkan Provinsi" required>
		        </div>
		        <div class="form-group">
		          <label for="inputHP">Nomor HP</label>
		          <input type="number" class="form-control" name="hp" id="inputHP" value="<?php if ($this->session->flashdata('hp')) { echo $this->session->flashdata('hp');} ?>" placeholder="Masukkan Nomor HP" >
		        </div>
		        <div class="form-group">
		          <p class="pull-right"><span id="logo_check" class=""></span>  <span id="email_check" class=""></span></p>
		          <label for="inputEmail">Email</label>
		          <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Masukkan Email" value="<?php if ($this->session->flashdata('email')) { echo $this->session->flashdata('email');} ?>" >
		        </div>
		        <div class="form-group pull-right">
			        <button type="submit" class="btn btn-primary">Submit</button>
				    <button type="reset" class="btn btn-default">Reset</button>
		        </div>
		    </form>
		</div>
	</div>		
</div>