<div class="container">
	<?php
		 $desimal = "2";
		 $pemecah_desimal = ",";
		 $pemecah_ribuan = ".";
	 ?>
	<h4 class="text-center text-uppercase">REKAP DATA PEKERJAAN</h4>
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
   			<a href="<?php echo base_url();?>Home/rekap_pekerjaan"><span class="glyphicon glyphicon-menu-left"></span>Kembali ke tampilan semua</a>    		
    	</div>
    	<?php endif ?>
		<div class="panel-body">
		    <div class="dropdown pull-right">
	   				<a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
	   					<?php if (isset($jp)): ?>
	   						<?php echo $jp;?>
	   					<?php else: ?>
	   						Semua
	   					<?php endif ?>  <span class="caret"></span>
	   				</a>
		            <ul class="dropdown-menu" role="menu">
		            	<li><a href="<?php echo base_url();?>Home/rekap_pekerjaan">Semua</a><li>
		            	<?php foreach ($dataBaruAll as $dataPkj): ?>
			                <li><a href="<?php echo base_url().'/Home/rekap_pekerjaan/'.$dataPkj->nama_pekerjaan;?>"><?php echo $dataPkj->nama_pekerjaan;?></a></li>
		            	<?php endforeach ?>
		            </ul>
   			</div>
   			<br><br><br>
			<?php if ($search !== 'kosong'): ?>
	   			<span class="pull-left">Menampilkan Hasil Pencarian : <?php echo $search;?></span> 				
   			<?php endif ?>
    	</div>
	    <form action="<?php echo base_url();?>Home/rekap_pekerjaan" method="post" accept-charset="utf-8">
	        <div class="input-group">
			    <input type="text" class="form-control" name="search_berkas" id="search" placeholder="Cari Data Berkas">
			    <span class="input-group-btn">
			        <button class="btn btn-default" type="submit">
			        	<span class="glyphicon glyphicon-search"></span>
			        </button>
			    </span>
		    </div>
    	</form>
    <?php if ($list ==="belum"): ?>
    	<div class="list-group">
    		<div class="list-group-item">Belum Ada Data</div>
    	</div>
    <?php elseif ($list === "kosong"): ?>
    	<div class="list-group">
    		<div class="list-group-item">Data Tidak Ditemukan</div>
    	</div>
	<?php else: ?>
		<table class="table">
			<thead>
				<tr>
					<th></th>
					<?php if ($this->session->userdata('SESS_HAK_AKSES') == 0): ?>
						<th class="tmbnl">Biaya</th>
					<?php endif ?>
					<th class="tmbnl">Tgl Selesai</th>
				</tr>
			</thead>
			<tbody id="myTable">
				<?php
			    	$no = 0;
			    	foreach ($list as $berkas): 
			    	$no++; 
				?>
				<tr>
					<td>
						<div class="list-group">
				            <a href="#sm<?php echo $no;?>" data-toggle="collapse" data-target="#sm<?php echo $no;?>" aria-expanded="false" aria-controls="sm<?php echo $no;?>">
				            	<span class="glyphicon glyphicon-menu-down pull-right pointer"></span>
				            </a>
				            <!-- <a href="#" data-toggle="modal" data-target=".menu" data-jenis="rekap" data-detail="<?php echo $berkas->detail;?>" data-jmldetail="<?php echo $berkas->jml_detail;?>" data-syarat="<?php echo $berkas->syarat;?>" data-jmlsyarat="<?php echo $berkas->jml_syarat;?>" data-id="<?php echo $berkas->id_berkas;?>"> -->
				            	#BKS<?php echo $berkas->id_berkas;?> - <strong><?php echo $berkas->nama_pekerjaan;?></strong>
				            <!-- </a> -->
				            <div id="sm<?php echo $no;?>" class="collapse">
			     				<span class="list-group-item small">Lokasi : <strong><?php echo $berkas->lokasi_penyimpanan;?></strong></span>
			     				<span class="list-group-item small">Tanggal Didaftarkan : <strong><?php echo $berkas->tgl_masuk_pekerjaan; ?></strong></span>
			     				<span class="list-group-item small">Tanggal Dikerjakan : <strong><?php echo $berkas->tgl_diterima_pekerjaan;?></strong></span>
					            <?php if ($berkas->jenis_aktor == "Notaris"): ?>
			     					<span class="list-group-item small">Pemohon : 
			     						<a data-toggle="modal" href="<?php echo base_url().'Home/detail_klien/'.$berkas->id_pemohon;?>" data-target=".extra">
			     							<strong><?php echo $berkas->nama_pemohon;?></strong>
			     						</a>
			 						</span>
			     					<?php if ($berkas->nama_instansi != ""): ?>
				     					<span class="list-group-item small">Instansi : <strong><?php echo $berkas->nama_instansi;?></strong></span>
			     					<?php endif ?>
			     				<?php else: ?>
			     					<span class="list-group-item small">Penjual : 
			     						<a data-toggle="modal" href="<?php echo base_url().'Home/detail_klien/'.$berkas->id_penjual;?>" data-target=".extra">
			     							<strong><?php echo $berkas->nama_penjual;?></strong>
			     						</a>
			     					</span>
			     					<span class="list-group-item small">Pembeli : 
			     						<a data-toggle="modal" href="<?php echo base_url().'Home/detail_klien/'.$berkas->id_pembeli;?>" data-target=".extra">
			     							<strong><?php echo $berkas->nama_pembeli;?></strong>
			     						</a>
			     					</span>
			     					<span class="list-group-item small">Tanah : 
			     						<a data-toggle="modal" href="<?php echo base_url().'Home/detail_tanah/'.$berkas->id_tanah;?>" data-target=".extra">
			     							<strong><?php echo $berkas->no_hak;?></strong>
			     						</a>
			     					</span>
					            <?php endif ?>
					            <span class="list-group-item small">PJ : <strong><?php echo $berkas->username;?></strong></span>
				            </div>
						</div>
			        </td>
			        <?php if ($this->session->userdata('SESS_HAK_AKSES') == 0): ?>
				        <td class="biaya">
				        	<?php echo "Rp ".number_format($berkas->biaya_klien, $desimal, $pemecah_desimal, $pemecah_ribuan);?>
				        </td>
			        <?php endif ?>
			        <td class="tanggal">
			        	<?php echo $berkas->tgl_selesai_pekerjaan;?>
			        </td>
			    </tr>
			<?php endforeach;?>
			</tbody>
		</table>
	<?php endif ?>	
		<!-- modal detail syarat lunas -->
    	<div class="modal fade extra" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    		<div class="modal-dialog modal-md">
    			<div class="modal-content">
    			</div>
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
			      <ul class="list-group" id="bks">
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
		          <h4 class="modal-title" id="mySmallModalLabel">Verifikasi Hapus</h4>
		        </div>
		        <div class="modal-body">
		          <form action="<?php echo base_url();?>Home/delete_berkas/rekap" method="POST">
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
	<div class="text-center">
		<ul class="pagination" id="myPager"></ul>
	</div>
</div>