<div class="container">
	<h4 class="text-center text-uppercase">DAFTAR TANAH</h4>
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
		<?php if ($tipe === 'search'): ?>
    	<div class="panel-heading">
   			<a href="<?php echo base_url();?>Home/daftar_tanah"><span class="glyphicon glyphicon-menu-left"></span>Kembali ke tampilan semua</a>    		
    	</div>
    	<?php endif ?>
		<div class="panel-body">
			<a href="<?php echo base_url();?>Home/tambah_tanah" class="btn btn-primary">
			<span class="glyphicon glyphicon-plus"></span> Tanah
			</a>
			<?php if ($search !== 'kosong'): ?>
	   			<span class="pull-right">Menampilkan Hasil Pencarian : <?php echo $search;?></span> 				
   			<?php endif ?>
		</div>
        	<form action="<?php echo base_url();?>Home/daftar_tanah" method="post" accept-charset="utf-8">
		        <div class="input-group">
				    <input type="text" class="form-control" name="search_tanah" id="search" placeholder="Cari Data Tanah Berdasarkan Identitas">
				    <span class="input-group-btn">
				        <button class="btn btn-default" type="submit">
				        	<span class="glyphicon glyphicon-search"></span>
				        </button>
				    </span>
			    </div>
        	</form>
	        <div class="list-group">
	        	<?php if ($list === "kosong"): ?>
	        		<div class="list-group-item">Data Tidak Ditemukan</div>
	        	<?php else: 
		        	$no = 0;
		        	foreach ($list as $tanah): 
		        	$no++; ?>
		        		<div class="list-group-item" >
				            <a href="#sm<?php echo $no;?>" data-toggle="collapse" data-target="#sm<?php echo $no;?>" aria-expanded="false" aria-controls="sm<?php echo $no;?>"><span class="glyphicon glyphicon-menu-down pull-right pointer"></span></a>
				            <a href="#" data-toggle="modal" data-target=".menu" data-jenis="tanah" data-id="<?php echo $tanah->id_tanah;?>">
				            	<?php echo $tanah->no_hak;?>
				            </a>
				            <br>
				            <span>Pemilik : <?php echo $tanah->nama_pemohon;?></span>
		        		</div>
				            <div id="sm<?php echo $no;?>" class="collapse">
		     					<span class="list-group-item small"><span class="glyphicon glyphicon-check"></span> <?php echo $tanah->jenis_hak;?></span>
		     					<span class="list-group-item small"><span class="glyphicon glyphicon-home"></span>  <?php echo $tanah->jalan.
		     																											' RT '.$tanah->rt.
		     																											' RW '.$tanah->rw.
		     																											' Kel '.$tanah->kelurahan.
		     																											' Kec '.$tanah->kecamatan.
		     																											' Provinsi '.$tanah->provinsi;?></span>
		     					<span class="list-group-item small"><span class="glyphicon glyphicon-map-marker"></span>  <?php echo $tanah->luas_tanah.' m2';?></span>
				            </div>
		        	<?php endforeach ?>
	        	<?php endif ?>
	        </div>
		<!-- modal menu-->
		<div class="modal fade menu" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
			  <div class="modal-content">
			    <div class="modal-header">
			      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      <h4 class="modal-title" id="mySmallModalLabel">Pilih Menu</h4>
			    </div>
			    <div class="modal-body">
			      <ul class="list-group">
			        <a id="edit_tanah" href="#" class="list-group-item"><span class="glyphicon glyphicon-edit "></span>  Edit</a>
			        <a id="delete" href="#" data-toggle="modal" data-target=".delete" data-id="" class="list-group-item"><span class="glyphicon glyphicon-trash"></span>  Hapus</a>
			      </ul>
			    </div>
			  </div>
			</div>
		</div>
		<!-- modal delete -->
		<div class="modal fade delete" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		    <div class="modal-dialog modal-sm">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		          <h4 class="modal-title" id="mySmallModalLabel">Verifikasi</h4>
		        </div>
		        <div class="modal-body">
		          <form action="<?php echo base_url();?>Home/delete_tanah" method="POST">
		            <div class="form-group">
		              <input type="hidden" name="id" id="inputId" value="">
		              <label for="verPass">Password</label>
		              <input type="password" class="form-control" name="pwver" id="verPass" placeholder="Masukkan Password Anda" autofocus required>
		            </div>
		            <button type="submit" class="btn btn-primary btn-block">Submit</button>
		          </form>
		        </div>
		      </div>
		    </div>
		</div>
	</div>
	<?php echo $links; ?>
</div>