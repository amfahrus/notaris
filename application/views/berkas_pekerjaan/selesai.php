<div class="container">
	<h4 class="text-center text-uppercase">BERKAS PEKERJAAN SELESAI</h4>
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
    <?php if ($this->session->flashdata('info')): ?>
    	<div class="alert alert-info" role="alert">
          <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php echo $this->session->flashdata('info'); ?> <a href="<?php echo base_url();?>Home/rekap_pekerjaan" class="btn btn-default">Lihat Rekap Data Pekerjaan</a>
        </div>
    <?php endif ?>
    <?php if ($list ==="belum"): ?>
    	<div class="list-group">
    		<div class="list-group-item">Belum Ada Data</div>
    	</div>
	<?php else: ?>
		<table class="table">
			<thead>
				<tr>
					<th></th>
					<th class="text-center">Lunas</th>
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
				            <a href="#" data-toggle="modal" data-target=".menu" data-jenis="selesai" data-titip="<?php echo $berkas->biaya_titip;?>" data-klien="<?php echo $berkas->biaya_klien;?>" data-id="<?php echo $berkas->id_berkas;?>">
				            	#BKS<?php echo $berkas->id_berkas;?> - <strong><?php echo $berkas->nama_pekerjaan;?></strong>
				            </a>
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
			        <td class="biaya">
		        		<p class="text-center">
			        		<?php if($berkas->biaya_klien != "" && $berkas->biaya_klien != $berkas->biaya_titip): ?>
						        	<a href="<?php echo base_url().'Home/pelunasan/'.$berkas->id_berkas;?>" data-toggle="modal" data-target=".pelunasan">
										<span class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="top" title="Belum Lunas"></span>
					        		</a>
							<?php else: ?>
								<span class="glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="top" title="Lunas"></span>
			        		<?php endif ?>
		        		</p>
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
			      </ul>
			    </div>
			  </div>
			</div>
		</div>
		<!-- modal pelunasan -->
		<div class="modal fade pelunasan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		    <div class="modal-dialog modal-sm">
			    <div class="modal-content">
			    </div>
			</div>
		</div>
	</div>
	<div class="text-center">
		<ul class="pagination" id="myPager"></ul>
	</div>
</div>