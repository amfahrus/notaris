<div class="container">
	<h4 class="text-center text-uppercase">DETAIL PEKERJAAN <?php echo $nama;?></h4>
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
			<a href="<?php echo base_url();?>Home/daftar_pekerjaan/<?php echo $aktor;?>"><span class="glyphicon glyphicon-menu-left"></span>Kembali ke Daftar Pekerjaan</a>
		</div>
		<?php if ($this->session->userdata('SESS_HAK_AKSES') == 3): ?>
			<div class="panel-body">
		        <div class="btn-group" role="group" aria-label="...">
					<button class="btn btn-primary" data-toggle="modal" data-target=".tambah-detail">
			          <span class="glyphicon glyphicon-plus"></span>  Detail
			        </button>
					<button class="btn btn-info" data-toggle="modal" data-target=".tambah-syarat">
			          <span class="glyphicon glyphicon-plus"></span>  Syarat
			        </button>
				</div>
		    </div>
		<?php endif ?>
	    <table class="table table-striped table-hover" >
	      <tr>
	        <th>Detail Pekerjaan</th>
	        <th>Biaya Kerja</th>
	      </tr>
	      <?php if ($detail === 'kosong'): ?>
		      <tr>
		      	<td colspan="2" class="text-center">Belum Ada Detail</td>
		      </tr>
		  <?php else: ?>
		      <?php foreach ($detail as $det): ?>
		      <?php if ($this->session->userdata('SESS_HAK_AKSES') == 3): ?>
			      <tr class="row-modal" data-toggle="modal" data-target=".menu" data-jenis="detail" data-id="<?php echo $det->id_detail;?>" data-langkah="<?php echo $det->langkah_pekerjaan;?>" data-biaya="<?php echo $det->biaya_default;?>">
		      <?php else: ?>
		      <tr>
		      <?php endif ?>
		          <td><?php echo $det->langkah_pekerjaan;?></td>    
		          <td>
		          	<?php if ($det->biaya_default != ''): ?>
			          	Rp <?php echo $det->biaya_default;?>,-
		          	<?php endif ?>
		          </td>    
		      </tr>
		      <?php endforeach ?>
	      <?php endif ?>
	    </table>
	    <div class="panel-body">
	    </div>
	    <table class="table table-striped table-hover" >
		    <tr>
		    	<th>Syarat Pekerjaan</th>
		    </tr>
		    <?php if ($syaratPkj === 'kosong'): ?>
		    <tr>
		    	<td colspan="2" class="text-center">Belum Ada Syarat</td>
		    </tr>
			<?php else: ?>
		    <?php foreach ($syaratPkj as $srt): ?>
		    <?php if ($this->session->userdata('SESS_HAK_AKSES') == 3): ?>
			    <tr class="row-modal" data-toggle="modal" data-target=".menu" data-jenis="syarat" data-id="<?php echo $srt->id_syarat;?>" data-syarat="<?php echo $srt->syarat;?>">
	    	<?php else: ?>
		    	<tr>
		    <?php endif ?>
		        <td><?php echo $srt->syarat;?></td>  
		    </tr>
		    <?php endforeach ?>
		    <?php endif ?>
	    </table>
	</div>
	<!-- modal tambah detail pekerjaan -->
	<div class="modal fade tambah-detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title" id="mySmallModalLabel">Tambah Detail Pekerjaan</h4>
	        </div>
            <form data-toggle="validator" role="form" action="<?php echo base_url();?>Home/input_detail_pekerjaan/<?php echo $aktor.'/'.$nama.'/'.$id;?>" method="POST">
		        <div class="modal-body">
		            <div class="form-group">
		              <label for="inputDetail">Detail Pekerjaan</label>
		              <input type="text" class="form-control" name="detail" id="inputDetail" placeholder="Masukkan Detail Pekerjaan" autofocus required>
		            </div>
		            <div class="form-group">
		              <label for="inputBiaya">Biaya Kerja</label>
		              <input type="number" class="form-control" name="biaya" id="inputBiaya" placeholder="Masukkan Biaya Kerja">
		            </div>
		        </div>
		        <div class="modal-footer">
		            <button type="submit" class="btn btn-primary btn-block">Submit</button>
		        </div>
	        </form>
	      </div>
	    </div>
	</div>
	<!-- modal tambah syarat pekerjaan -->
	<div class="modal fade tambah-syarat" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title" id="mySmallModalLabel">Tambah Syarat Pekerjaan</h4>
	        </div>
            <form data-toggle="validator" role="form" action="<?php echo base_url();?>Home/input_syarat_pekerjaan/<?php echo $aktor.'/'.$nama.'/'.$id;?>" method="POST">
		        <div class="modal-body">
		            <div class="form-group">
		              <label for="inputSyarat">Syarat Pekerjaan</label>
		              <input type="text" class="form-control" name="syarat" id="inputSyarat" placeholder="Masukkan Syarat Pekerjaan" autofocus required>
		            </div>
		        </div>
		        <div class="modal-footer">
		            <button type="submit" class="btn btn-primary btn-block">Submit</button>
		        </div>
	        </form>
	      </div>
	    </div>
	</div>
	<!-- modal edit detail pekerjaan -->
	<div class="modal fade edit-detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title" id="mySmallModalLabel">Edit Detail Pekerjaan</h4>
	        </div>
            <form data-toggle="validator" role="form" action="<?php echo base_url();?>Home/edit_detail_pekerjaan/<?php echo $aktor.'/'.$nama.'/'.$id;?>" method="POST">
		        <div class="modal-body">
		        	<input type="hidden" name="id" id="inputId" value="">
		            <div class="form-group">
		              <label for="inputDetail">Detail Pekerjaan</label>
		              <input type="text" class="form-control" name="detail" id="inputDetail" placeholder="Masukkan Detail Pekerjaan" autofocus required>
		            </div>
		            <div class="form-group">
		              <label for="inputBiaya">Biaya Kerja</label>
		              <input type="number" class="form-control" name="biaya" id="inputBiaya" placeholder="Masukkan Biaya Kerja">
		            </div>
		        </div>
		        <div class="modal-footer">
		            <button type="submit" class="btn btn-primary btn-block">Submit</button>
		        </div>
	        </form>
	      </div>
	    </div>
	</div>
	<!-- modal edit syarat pekerjaan -->
	<div class="modal fade edit-syarat" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title" id="mySmallModalLabel">Edit Syarat Pekerjaan</h4>
	        </div>
            <form data-toggle="validator" role="form" action="<?php echo base_url();?>Home/edit_syarat_pekerjaan/<?php echo $aktor.'/'.$nama.'/'.$id;?>" method="POST">
		        <div class="modal-body">
		        	<input type="hidden" name="id" id="inputId" value="">
		            <div class="form-group">
		              <label for="inputSyarat">Syarat Pekerjaan</label>
		              <input type="text" class="form-control" name="syarat" id="inputSyarat" placeholder="Masukkan Syarat Pekerjaan" autofocus required>
		            </div>
		        </div>
		        <div class="modal-footer">
		            <button type="submit" class="btn btn-primary btn-block">Submit</button>
		        </div>
	        </form>
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
	          <ul class="list-group">
	            <a id="edit" href="#" data-toggle="modal" data-target="" data-id="" data-syarat="" data-langkah="" data-biaya="" class="list-group-item"><span class="glyphicon glyphicon-edit "></span>  Edit</a>
	            <a id="delete" href="#" data-toggle="modal" data-target=".delete" data-jenis="" data-id="" data-aktor="<?php echo $aktor;?>" data-nama="<?php echo $nama;?>" data-pkj="<?php echo $id;?>" class="list-group-item"><span class="glyphicon glyphicon-trash"></span>  Hapus</a>
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
	          <form id="verDelete" action="" method="POST">
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