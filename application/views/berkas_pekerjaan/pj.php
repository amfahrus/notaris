<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="mySmallModalLabel">Ubah PJ <?php echo '#BKS'.$id; ?></h4>
</div>
<form class="form-horizontal" action="<?php echo base_url().'Home/ganti_pj';?>" method="post">
	<div class="modal-body">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="hidden" name="idname" value="<?php echo $idu; ?>">
		<div class="form-group">
			<label for="awalLabel" class="col-md-4 control-label">PJ Awal</label>
			<div class="col-md-8">
				<input type="text" class="form-control" name="uname" value="<?php echo $un; ?>" disabled>
			</div>
		</div>
		<div class="form-group">
			<label for="pjLabel" class="col-md-4 control-label">Pilih PJ</label>
			<div class="col-md-8">
				<select class="form-control" name="pj" id="pjLabel">
					<?php foreach ($user as $pj): ?>
					<option value="<?php echo $pj->id_user; ?>"><?php echo $pj->username; ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="berkasLabel" class="col-md-4 control-label">Ubah PJ Untuk</label>
			<div class="col-md-8">
				<select name="pilih" class="form-control" id="berkasLabel">
					<option value="1">Berkas Ini</option>
					<option value="2">Seluruh Berkas Dalam Proses PJ <?php echo $un; ?></option>
				</select>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<input class="btn btn-primary" type="submit" value="Ubah">
	</div>
</form>