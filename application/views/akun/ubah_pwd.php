<form action="<?php echo base_url().'Home/edit_pwd';?>" method="POST">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="mySmallModalLabel">Password</h4>
</div>
<div class="modal-body">
	<input type="hidden" name="id" value="<?php echo $this->session->userdata('SESS_USER_ID');?>">
	<div class="form-group">
		<label for="inputPwdOld">Password Lama</label>
		<input type="password" class="form-control" name="pwd_old" id="inputPwdOld" placeholder="Masukkan Password Lama" value="" autofocus required>
	</div>
	<div class="form-group">
		<label for="inputPwdNew">Password Baru</label>
		<input type="password" class="form-control" name="pwd_new" id="inputPwdNew" placeholder="Masukkan Password Baru" value="" autofocus required>
	</div>
	<div class="form-group">
		<label for="inputPwdConf">Konfirmasi Password Baru</label>
		<input type="password" class="form-control" name="pwd_conf" id="inputPwdConf" placeholder="Masukkan Password Baru" value="" autofocus required>
	</div>
</div>
<div class="modal-footer">
	<input type="submit" name="submit" class="btn btn-primary" value="Submit">
</div>
</form>