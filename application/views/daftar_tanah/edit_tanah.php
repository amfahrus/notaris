<div class="container">
	<h4 class="text-center text-uppercase">EDIT TANAH</h4>
	<div class="panel panel-default">
		<?php if ($this->session->flashdata('error')): ?>
	        <div class="alert alert-danger alert-dismisable" role="alert">
	          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	          <span class="sr-only">Error:</span>
	          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <?php echo $this->session->flashdata('error'); ?>
	        </div>
	    <?php endif; ?>	
		<div class="panel-heading">
			<a href="<?php echo base_url();?>Home/daftar_tanah"><span class="glyphicon glyphicon-menu-left"></span>Kembali Ke Daftar Tanah</a>
		</div>
		<div class="panel-body">
			<form action="<?php echo base_url();?>Home/ubah_tanah" method="POST">
				<input type="hidden" name="id" value="<?php echo $tanah->id_tanah;?>">
		        <div class="form-group">
		          <label for="inputHak">Nomor Hak</label>
		          <input type="text" class="form-control" name="hak" id="inputHak" value="<?php echo $tanah->no_hak;?>" placeholder="Masukkan Nomor Hak" autofocus required>
		        </div>
		        <div class="form-group">
		          <label for="inputNama">Nama Pemilik</label>
		          <select class="form-control" name="nama" id="inputNama">
		          		<option value="<?php echo $pemilik->id_pemohon;?>" selected ><?php echo $pemilik->nama_pemohon;?></option>
		          	<?php foreach ($klien as $k): ?>
		          		<?php if ($k->nama_pemohon !== $pemilik->nama_pemohon): ?>
			          		<option value="<?php echo $k->id_pemohon;?>"><?php echo $k->nama_pemohon;?></option>
		          		<?php endif ?>
		          	<?php endforeach ?>
		          </select>
		        </div>
		        <div class="form-group">
		        	<label for="inputJenisHak">Jenis Hak</label>
		        	<input type="text" class="form-control" name="jenis" id="inputJenisHak" value="<?php echo $tanah->jenis_hak;?>" placeholder="Masukkan Jenis Hak" required>
		        </div>
		        <div class="form-group">
		          <label for="inputJalan">Jalan</label>
		          <input type="text" class="form-control" name="jalan" id="inputJalan" value="<?php echo $tanah->jalan;?>" placeholder="Masukkan Nama Jalan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputRT">RT</label>
		          <input type="text" class="form-control" name="rt" id="inputRT" value="<?php echo $tanah->rt;?>" placeholder="Masukkan RT" required>
		        </div>
		        <div class="form-group">
		          <label for="inputRW">RW</label>
		          <input type="text" class="form-control" name="rw" id="inputRW" value="<?php echo $tanah->rw;?>" placeholder="Masukkan RW" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKel">Kelurahan</label>
		          <input type="text" class="form-control" name="kel" id="inputKel" value="<?php echo $tanah->kelurahan;?>" placeholder="Masukkan Kelurahan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKec">Kecamatan</label>
		          <input type="text" class="form-control" name="kec" id="inputKec" value="<?php echo $tanah->kecamatan;?>" placeholder="Masukkan Kecamatan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKota">Kota</label>
		          <input type="text" class="form-control" name="kota" id="inputKota" value="<?php echo $tanah->kota;?>" placeholder="Masukkan Kota" required>
		        </div>
		        <div class="form-group">
		          <label for="inputProv">Provinsi</label>
		          <input type="text" class="form-control" name="prov" id="inputProv" value="<?php echo $tanah->provinsi;?>" placeholder="Masukkan Provinsi" required>
		        </div>
		        <div class="form-group">
		          <label for="inputLuas">Luas Tanah</label>
		          <div class=input-group>
		          	<input type="number" class="form-control" name="luas" id="inputLuas" value="<?php echo $tanah->luas_tanah;?>" placeholder="Masukkan Luas Tanah" >
		        	<span class="input-group-addon">m2</span>
		          </div>
		        </div>
		        <div class="form-group pull-right">
			        <button type="submit" class="btn btn-primary">Submit</button>
				    <button type="reset" class="btn btn-default">Reset</button>
		        </div>
		    </form>
		</div>
	</div>		
</div>