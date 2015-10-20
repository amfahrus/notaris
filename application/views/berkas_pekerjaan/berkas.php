<div class="container">
	<?php
		switch ($tipe) {
			case 'username':
				$judul = "BERKAS PEKERJAAN ANDA BELUM SELESAI";
				break;
			case 'hari':
				$judul = "BERKAS PEKERJAAN MASUK HARI INI";
				break;
			case 'klien':
				$judul = "BERKAS PEKERJAAN BIAYA KLIEN BELUM DI SET";
				break;
			case 'pending':
				$judul = "BERKAS PEKERJAAN BELUM DITERIMA";
				break;
			default:
				$judul = "BERKAS PEKERJAAN DALAM PROSES";
				break;
		}
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
		<?php if ($tipe !== 'kosong'): ?>
    	<div class="panel-heading">
   			<a href="<?php echo base_url();?>Home/berkas_pekerjaan"><span class="glyphicon glyphicon-menu-left"></span>Kembali ke tampilan semua</a>    		
    	</div>
			<?php if ($search !== 'kosong'): ?>
			<div class="panel-body">
	   			<span class="pull-left">Menampilkan Hasil Pencarian : <?php echo $search;?></span> 				
			</div>
   			<?php endif ?>
	    <?php else: ?>
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
		            	<li><a href="<?php echo base_url();?>Home/berkas_pekerjaan">Semua</a><li>
		            	<?php foreach ($dataBaruAll as $dataPkj): ?>
			                <li><a href="<?php echo base_url().'/Home/berkas_pekerjaan/'.$dataPkj->nama_pekerjaan;?>"><?php echo $dataPkj->nama_pekerjaan;?></a></li>
		            	<?php endforeach ?>
		            </ul>
   			</div>
		</div>
    	<form action="<?php echo base_url();?>Home/berkas_pekerjaan" method="post" accept-charset="utf-8">
	        <div class="input-group">
			    <input type="text" class="form-control" name="search_berkas" id="search" placeholder="Cari Data Berkas">
			    <span class="input-group-btn">
			        <button class="btn btn-default" type="submit">
			        	<span class="glyphicon glyphicon-search"></span>
			        </button>
			    </span>
		    </div>
    	</form>
    	<?php endif ?>
    	<?php if ($list === "kosong"): ?>
	    	<div class="list-group">
        		<div class="list-group-item">
        			<p class="text-center">Data Tidak Ditemukan</p>
        		</div>
        	</div>
        <?php elseif ($list ==="belum"): ?>
        	<div class="list-group">
        		<div class="list-group-item">
        			<p class="text-center">Belum Ada Data</p>
        			<?php if ($tampil === "semua"): ?>
        				<p class="text-center"><a href="<?php echo base_url().'Home/berkas_pekerjaan';?>">Tampilkan Semua Data</a></p>
        			<?php endif ?>
        		</div>
        	</div>
    	<?php else: ?>
    	<?php foreach ($list as $cek_berkas): ?>
    		<?php if ($cek_berkas->detail == $cek_berkas->jml_detail && $cek_berkas->syarat == $cek_berkas->jml_syarat): ?>
	            <?php if ($cek_berkas->id_user == $this->session->userdata('SESS_USER_ID')): ?>
    			<div class="alert alert-info" role="alert">
					<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
          			Detail dan Syarat Berkas #BKS<?php echo $cek_berkas->id_berkas;?> Telah Terpenuhi, Nyatakan Selesai?
          			<a href="<?php echo base_url().'Home/berkas_pekerjaan/selesai/'.$cek_berkas->id_berkas;?>" class="btn btn-primary">Ya</a>
					<button type="button" class="btn btn-danger" data-dismiss="alert">Tidak</button>
		        </div>
	    		<?php endif ?>
    		<?php endif ?>
    	<?php endforeach ?>
    	<table class="table">
    		<thead>
	    		<tr>
	    			<th></th>
	    			<th class="tmbnl"><p class="text-center">Detail</p></th>
	    			<th class="tmbnl"><p class="text-center">Syarat</p></th>
	    			<th class="tmbnl"><p class="text-center">Lunas</p></th>
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
				            <?php if ($this->session->userdata('SESS_HAK_AKSES') != 2 || $berkas->id_user == $this->session->userdata('SESS_USER_ID')): ?>
				            <a href="#" data-toggle="modal" data-target=".menu" data-jenis="berkas" data-detail="<?php echo $berkas->detail;?>" data-jmldetail="<?php echo $berkas->jml_detail;?>" data-syarat="<?php echo $berkas->syarat;?>" data-jmlsyarat="<?php echo $berkas->jml_syarat;?>" data-id="<?php echo $berkas->id_berkas;?>">
				            	#BKS<?php echo $berkas->id_berkas;?> - <strong><?php echo $berkas->nama_pekerjaan;?></strong>
				            </a>
			            	<?php else: ?>
				            	#BKS<?php echo $berkas->id_berkas;?> - <strong><?php echo $berkas->nama_pekerjaan;?></strong>
				            <?php endif ?>
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
					            <span class="list-group-item small">
					            	PJ : <strong><?php echo $berkas->username;?></strong> 
					            	<?php if ($this->session->userdata('SESS_HAK_AKSES') == 0): ?>
					            		<a data-toggle="modal" href="<?php echo base_url().'Home/ubah_pj/'.$berkas->id_berkas.'/'.$berkas->username.'/'.$berkas->id_user; ?>" data-target=".extra""><span class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Ubah PJ"></span></a>
					            	<?php endif ?>
					            </span>
				            </div>
						</div>
			        </td>
			        <td class="detail">
			        	<a data-toggle="modal" href="<?php echo base_url().'Home/detail_berkas/'.$berkas->id_berkas.'/'.$berkas->id_pekerjaan;?>" data-target=".extra">
			        		<p class="text-center"><?php echo $berkas->detail.' / '.$berkas->jml_detail;?></p>
			        	</a>
			        </td>
			        <td class="syarat">
			        	<a data-toggle="modal" href="<?php echo base_url().'Home/syarat_berkas/'.$berkas->id_berkas;?>" data-target=".extra">
				        	<p class="text-center"><?php echo $berkas->syarat.' / '.$berkas->jml_syarat;?></p>
			        	</a>
		        	</td>
			        <td class="lunas">
			        	<a href="<?php echo base_url().'Home/biaya_berkas/'.$berkas->id_berkas;?>">
				        	<p class="text-center">
				        		<?php if ($berkas->biaya_klien == ""): ?>
				        			<span class="glyphicon glyphicon-question-sign alert-danger" data-toggle="tooltip" data-placement="top" title="Belum Di Set"></span>
				        		<?php elseif($berkas->biaya_klien != "" && $berkas->biaya_klien != $berkas->biaya_titip): ?>
									<span class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top" title="Belum Lunas"></span>
								<?php else: ?>
									<span class="glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="top" title="Lunas"></span>
				        		<?php endif ?>
				        	</p>
			        	</a>
			        </td>	
				</tr>
		        	<?php endforeach ?>
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
			        <a id="edit_berkas" href="#" class="list-group-item"><span class="glyphicon glyphicon-edit "></span>  Edit</a>
			        <?php if ($this->session->userdata('SESS_HAK_AKSES != 2')): ?>
				        <a id="delete" href="#" data-toggle="modal" data-target=".delete" data-id="" class="list-group-item"><span class="glyphicon glyphicon-trash"></span>  Hapus</a>
			        <?php endif ?>
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
		          <form action="<?php echo base_url();?>Home/delete_berkas" method="POST">
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