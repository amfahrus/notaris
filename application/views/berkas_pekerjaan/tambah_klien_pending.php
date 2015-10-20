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
			<a href="<?php echo base_url().'Home/edit_berkas_pending/'.$id_berkas;?>"><span class="glyphicon glyphicon-menu-left"></span>Kembali Ke Edit Berkas</a>
		</div>
		<div class="panel-body">
			<form action="<?php echo base_url().'Home/input_klien_berkas/'.$id_berkas.'/'.$tipe.'/pending';?>" method="POST">
		        <div class="form-group">
		          <label for="inputKTP">Nomor KTP</label>
		          <input type="number" class="form-control" name="ktp" id="inputKTP" placeholder="Masukkan Nomor KTP" autofocus required>
		        </div>
		        <div class="form-group">
		          <label for="inputNama">Nama Lengkap</label>
		          <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Masukkan Nama Lengkap" required>
		        </div>
		        <div class="form-group">
		          <label for="inputJalan">Jalan</label>
		          <input type="text" class="form-control" name="jalan" id="inputJalan" placeholder="Masukkan Nama Jalan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputRT">RT</label>
		          <input type="text" class="form-control" name="rt" id="inputRT" placeholder="Masukkan RT" required>
		        </div>
		        <div class="form-group">
		          <label for="inputRW">RW</label>
		          <input type="text" class="form-control" name="rw" id="inputRW" placeholder="Masukkan RW" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKel">Kelurahan</label>
		          <input type="text" class="form-control" name="kel" id="inputKel" placeholder="Masukkan Kelurahan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKec">Kecamatan</label>
		          <input type="text" class="form-control" name="kec" id="inputKec" placeholder="Masukkan Kecamatan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKota">Kota</label>
		          <input type="text" class="form-control" name="kota" id="inputKota" placeholder="Masukkan Kota" required>
		        </div>
		        <div class="form-group">
		          <label for="inputProv">Provinsi</label>
		          <input type="text" class="form-control" name="prov" id="inputProv" placeholder="Masukkan Provinsi" required>
		        </div>
		        <div class="form-group">
		          <label for="inputHP">Nomor HP</label>
		          <input type="number" class="form-control" name="hp" id="inputHP" placeholder="Masukkan Nomor HP" >
		        </div>
		        <div class="form-group">
		          <label for="inputEmail">Email</label>
		          <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Masukkan Email" >
		        </div>
		        <div class="form-group pull-right">
			        <button type="submit" class="btn btn-primary">Submit</button>
				    <button type="reset" class="btn btn-default">Reset</button>
		        </div>
		    </form>
		</div>
	</div>		
</div>