<div class="container">
	<h4 class="text-center text-uppercase">EDIT KLIEN</h4>
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="<?php echo base_url();?>Home/daftar_klien"><span class="glyphicon glyphicon-menu-left"></span>Kembali Ke Daftar Klien</a>
		</div>
		<div class="panel-body">
			<form action="<?php echo base_url();?>Home/ubah_klien" method="POST">
		        <input type="hidden" name="id" value="<?php echo $list->id_pemohon;?>">
		        <div class="form-group">
		          <label for="inputKTP">Nomor KTP</label>
		          <input type="number" class="form-control" name="ktp" id="inputKTP" value="<?php echo $list->id_pemohon;?>" placeholder="Masukkan Nomor KTP" autofocus required>
		        </div>
		        <div class="form-group">
		          <label for="inputNama">Nama Lengkap</label>
		          <input type="text" class="form-control" name="nama" id="inputNama" value="<?php echo $list->nama_pemohon;?>" placeholder="Masukkan Nama Lengkap" required>
		        </div>
		        <div class="form-group">
		          <label for="inputJalan">Jalan</label>
		          <input type="text" class="form-control" name="jalan" id="inputJalan" value="<?php echo $list->jalan;?>" placeholder="Masukkan Nama Jalan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputRT">RT</label>
		          <input type="text" class="form-control" name="rt" id="inputRT" value="<?php echo $list->rt;?>" placeholder="Masukkan RT" required>
		        </div>
		        <div class="form-group">
		          <label for="inputRW">RW</label>
		          <input type="text" class="form-control" name="rw" id="inputRW" value="<?php echo $list->rw;?>" placeholder="Masukkan RW" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKel">Kelurahan</label>
		          <input type="text" class="form-control" name="kel" id="inputKel" value="<?php echo $list->kelurahan;?>" placeholder="Masukkan Kelurahan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKec">Kecamatan</label>
		          <input type="text" class="form-control" name="kec" id="inputKec" value="<?php echo $list->kecamatan;?>" placeholder="Masukkan Kecamatan" required>
		        </div>
		        <div class="form-group">
		          <label for="inputKota">Kota</label>
		          <input type="text" class="form-control" name="kota" id="inputKota" value="<?php echo $list->kota;?>" placeholder="Masukkan Kota" required>
		        </div>
		        <div class="form-group">
		          <label for="inputProv">Provinsi</label>
		          <input type="text" class="form-control" name="prov" id="inputProv" value="<?php echo $list->provinsi;?>" placeholder="Masukkan Provinsi" required>
		        </div>
		        <div class="form-group">
		          <label for="inputHP">Nomor HP</label>
		          <input type="number" class="form-control" name="hp" id="inputHP" value="<?php echo $list->hp;?>" placeholder="Masukkan Nomor HP" >
		        </div>
		        <div class="form-group">
		          <p class="pull-right"><span id="logo_check" class=""></span>  <span id="email_check" class=""></span></p>
		          <label for="inputEmail">Email</label>
		          <input type="email" class="form-control" name="email" id="inputEmail" value="<?php echo $list->email;?>" placeholder="Masukkan Email" >
		        </div>
		        <div class="form-group pull-right">
			        <button type="submit" class="btn btn-primary">Submit</button>
				    <button type="reset" class="btn btn-default">Reset</button>
		        </div>
		    </form>
		</div>
	</div>		
</div>