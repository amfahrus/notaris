<div class="container">
	<h4 class="text-center text-uppercase">AMBIL DATA KLIEN</h4>
	<div class="panel panel-default">	
    	<div class="panel-heading">
		<?php if ($query === 'search'): ?>
   			<a href="<?php echo base_url().'Home/ambil_klien_pkj/'.$aktor.'/'.$nama.'/'.$tipe;?>"><span class="glyphicon glyphicon-menu-left"></span>Kembali ke tampilan semua</a>    		
    	<?php else: ?>
			<a href="<?php echo base_url().'Home/baru/'.$aktor.'/'.$nama;?>"><span class="glyphicon glyphicon-menu-left"></span>Kembali Ke Pekerjaan Baru</a>
    	<?php endif ?>
    	</div>
		<div class="panel-body">
			<?php if ($search !== 'kosong'): ?>
	   			<span class="pull-right">Menampilkan Hasil Pencarian : <?php echo $search;?></span> 				
   			<?php endif ?>
		</div>
        	<form action="<?php echo base_url().'Home/ambil_klien_pkj/'.$aktor.'/'.$nama.'/'.$tipe;?>" method="post" accept-charset="utf-8">
		        <div class="input-group">
				    <input type="text" class="form-control" name="search_klien" id="search" placeholder="Cari Data Klien Berdasarkan Identitas">
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
			        foreach ($list as $klien): 
			        	$no++; 
			        	switch ($tipe) {
			        		case '1':
			        			$select = $klien->nama_pemohon !== $this->session->userdata('SESS_PEMBELI_NAME');
			        			break;
			        		
			        		case '2':
			        			$select = $klien->nama_pemohon !== $this->session->userdata('SESS_PENJUAL_NAME');
			        			break;
		        			default:
			        			$select = "do nothing";
			        			break;
			        	}
			        	if ($select):
			        	?>	
			        		<div class="list-group-item" >
					            <a data-toggle="collapse" data-target="#sm<?php echo $no;?>" aria-expanded="false" aria-controls="sm<?php echo $no;?>">
					            	<span class="glyphicon glyphicon-menu-down pull-right pointer"></span>
					            </a>
					            <a href="#" data-toggle="modal" data-target=".menu" data-jenis="ambil" data-aktor="<?php echo $aktor;?>" data-nama="<?php echo $nama;?>" data-tipe="<?php echo $tipe;?>" data-id="<?php echo $klien->id_pemohon;?>">
					            	<?php echo $klien->nama_pemohon;?>
					            </a>
			        		</div>
					            <div id="sm<?php echo $no;?>" class="collapse">
			     					<span class="list-group-item small"><span class="glyphicon glyphicon-credit-card"></span> #<?php echo $klien->id_pemohon;?></span>
			     					<span class="list-group-item small"><span class="glyphicon glyphicon-home"></span>  <?php echo $klien->jalan." RT ".$klien->rt." RW ".$klien->rw
				     				." Kel ".$klien->kelurahan." Kec ".$klien->kecamatan." ".$klien->kota." ".$klien->provinsi;?></span>
				     				<span class="list-group-item small"><span class="glyphicon glyphicon-phone"></span>  <?php echo $klien->hp;?></span>
			     					<span class="list-group-item small"><span class="glyphicon glyphicon-envelope"></span>  <?php echo $klien->email;?></span>
					            </div>
			        	<?php endif ?>
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
			        <a id="ambil_klien" href="#" class="list-group-item"><span class="glyphicon glyphicon-edit "></span>  Ambil Data</a>
			      </ul>
			    </div>
			  </div>
			</div>
		</div>
	</div>
	<?php echo $links; ?>
</div>