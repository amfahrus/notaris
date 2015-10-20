<?php if ($this->session->userdata('SESS_HAK_AKSES') !== '0'): ?>
	<h1>AKSES DITOLAK</h1>
<?php else: ?>
<div class="container">
	<?php 
	if ($sort === "belum"): 
		$judul = "PENGELUARAN KERJA BELUM DIBAYAR";
	elseif($sort === "sudah"):
		$judul = "PENGELUARAN KERJA SUDAH DIBAYAR";
	else: 
		$judul = "PENGELUARAN KERJA";
	endif ?>
	<?php
		 $desimal = "2";
		 $pemecah_desimal = ",";
		 $pemecah_ribuan = ".";
	 ?>
	<h4 class="text-center text-uppercase"><?php echo $judul; ?></h4>
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
	    <?php if ($sort === "belum" || $sort === "sudah" || $tipe === "search"): ?>
	    	<div class="panel-heading">
	   			<a href="<?php echo base_url();?>Home/pengeluaran_kerja"><span class="glyphicon glyphicon-menu-left"></span>Kembali ke tampilan semua</a>    		
	    	</div>
	    <?php endif ?>
		    <div class="panel-body">
				<?php if ($search !== 'kosong'): ?>
		   			<span class="pull-left">Menampilkan Hasil Pencarian : <?php echo $search;?></span> 				
	   			<?php endif ?>
	   			<div class="dropdown pull-right">
		   				<a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
		   					<span class="glyphicon glyphicon-list"></span>  <span class="caret"></span>
		   				</a>
			            <ul class="dropdown-menu" role="menu">
			            	<li><a href="<?php echo base_url();?>Home/pengeluaran_kerja">Semua</a><li>
			            	<li><a href="<?php echo base_url();?>Home/pengeluaran_kerja/sudah">Sudah</a></li>
			            	<li><a href="<?php echo base_url();?>Home/pengeluaran_kerja/belum">Belum</a></li>
			            </ul>
	   			</div>
			</div>
	    	<!-- <form action="<?php echo base_url();?>Home/pengeluaran_kerja" method="post" accept-charset="utf-8">
		        <div class="input-group">
				    <input type="text" class="form-control" name="search_berkas" id="search" placeholder="Cari Data Berkas">
				    <span class="input-group-btn">
				        <button class="btn btn-default" type="submit">
				        	<span class="glyphicon glyphicon-search"></span>
				        </button>
				    </span>
			    </div>
	    	</form> -->
	    	<?php if ($id === "kosong"): ?>
	    	<div class="list-group">
        		<div class="list-group-item">Data Tidak Ditemukan</div>
        	</div>
	        <?php else: ?>
	    		<ul class="list-group" id="myTable">
		    	<?php $no = 0; foreach ($id as $i): $no++; ?>
		    		    <li class="list-group-item list-group-item-info">
		    		    	<!-- <a href="#sm<?php echo $no;?>" data-toggle="collapse" data-target="#sm<?php echo $no;?>" aria-expanded="false" aria-controls="sm<?php echo $no;?>">
				            	<span class="glyphicon glyphicon-menu-down pull-right pointer"></span>
				            </a> -->
		    		    	<a href="<?php echo base_url().'Home/detail_berkas_pengeluaran/'.$i->id_berkas;?>" data-toggle="modal" data-target=".extra">
			    		    	#BKS<?php echo $i->id_berkas;?>
		    		    	</a>
		    		    </li>
		    		    	<?php
		    		    	if ($sort === "sudah") {
		    		    		$isi = $this->RekapModel->select_stat_biaya_sudah($i->id_berkas);
		    		    	}else if($sort === "belum"){
		    		    		$isi = $this->RekapModel->select_stat_biaya_belum($i->id_berkas);
		    		    	}else{
		    		    		$isi = $this->RekapModel->select_stat_biaya($i->id_berkas);
		    		    	}
		    		    	?>
		    		    	<!-- <div id="sm<?php echo $no;?>" class="collapse"> -->
	    		    			<table class="table table-bordered table-hover">
	    		    				<tr class="danger">
	    		    					<th>Langkah</th>
	    		    					<th>Biaya</th>
	    		    					<th>Status</th>
	    		    					<th>Tanggal</th>
	    		    				</tr>
		    		    		<?php foreach ($isi as $rek): ?>
								    <?php 
								    	if ($rek->status == 0) {
										    $biaya = ($rek->biaya_default) ? $biaya = $rek->biaya_default : $biaya = $rek->biaya_pekerjaan ;
								    	}else{
								    		$biaya = $rek->biaya_bayar;
								    	}
								    ?>
		    		    			<?php if ($rek->status === "0"): ?>
			    					<tr class="row-modal" data-toggle="modal" data-target=".menu" data-ket="<?php echo $sort;?>" data-jenis="pengeluaran" data-id="<?php echo $rek->id_detail;?>" data-berkas="<?php echo $rek->id_berkas;?>" data-biaya_bayar="<?php echo $biaya; ?>">
		    		    			<?php else: ?>
		    		    			<tr>
		    		    			<?php endif ?>
			    						<td class="col-md-3"><?php echo $rek->langkah_pekerjaan;?></td>
									    <td class="col-md-3">
									    	Rp <?php echo number_format($biaya, $desimal, $pemecah_desimal, $pemecah_ribuan);?>
									    	<!-- cek apakah biaya default berubah -->
									    	<?php if ($rek->status == 1 && $rek->biaya_default != NULL && $rek->biaya_bayar != $rek->biaya_default && $rek->biarkan == 0): ?>
									    		<span class="pull-right"><a href="<?php echo base_url().'Home/lihat_bayar/'.$rek->id_berkas.'/'.$rek->id_detail; ?>" class="round round-warning" data-toggle="modal" data-target=".extra" ><span class="glyphicon glyphicon-alert" data-toggle="tooltip" title="Ada Perubahan Biaya Kerja"></span></a></span>
									    	<?php endif ?>
									    </td>
									    <?php $status = ($rek->status === '0') ? $status = "Belum" : $status = "Sudah" ; ?>
									    <td class="col-md-3"><?php echo $status;?></td>
									    <?php $tgl = ($rek->tgl_bayar === '0000-00-00') ? $tgl = "-" : $tgl = $rek->tgl_bayar ; ?>
									    <td class="col-md-3"><?php echo $tgl;?></td>
			    					</tr>
		    		    		<?php endforeach ?>
	    		    			</table>
	    		    		<!-- </div> -->
		    	<?php endforeach ?>
	    		</ul>
		    <?php endif ?>
	</div>
	<div class="text-center">
		<ul class="pagination" id="myPager"></ul>
	</div>
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
					<a id="bayar_pengeluaran" href="#" class="list-group-item"><span class="glyphicon glyphicon-briefcase"></span>  Bayar</a>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- modal detail berkas -->
<div class="modal fade extra" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		</div>
	</div>
</div>
<?php endif ?>