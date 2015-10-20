<div class="container">
	<h4 class="text-center text-uppercase">TAMBAH TANAH</h4>
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
			<a href="<?php echo base_url().'Home/edit_berkas_pending/'.$id_berkas;?>"><span class="glyphicon glyphicon-menu-left"></span>Kembali Ke Edit Berkas</a>
		</div>
		<div class="panel-body">
			<form action="<?php echo base_url().'Home/input_tanah_berkas/'.$id_berkas.'/'.$tipe.'/pending';?>" method="POST">
		        <div class="form-group">
		          <label for="inputHak">Nomor Hak</label>
		          <input type="text" class="form-control" name="hak" id="inputHak" placeholder="Masukkan Nomor Hak" autofocus required>
		        </div>
		        <div class="form-group">
		          <label for="inputNama">Nama Pemilik</label>
		          <select class="form-control" name="nama" id="inputNama">
		          	<?php foreach ($klien as $k): ?>
		          		<option value="<?php echo $k->id_pemohon;?>"><?php echo $k->nama_pemohon;?></option>
		          	<?php endforeach ?>
		          </select>
		        </div>
		        <div class="form-group">
		        	<label for="inputJenisHak">Jenis Hak</label>
		        	<input type="text" class="form-control" name="jenis" id="inputJenisHak" placeholder="Masukkan Jenis Hak" required>
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
		          <label for="inputLuas">Luas Tanah</label>
		          <div class=input-group>
			          <input type="number" class="form-control" name="luas" id="inputLuas" placeholder="Masukkan Luas Tanah" >
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