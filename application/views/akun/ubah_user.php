<form action="<?php echo base_url().'Home/edit_akun';?>" method="POST">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="mySmallModalLabel">Identitas User</h4>
</div>
<div class="modal-body">
	<input type="hidden" name="id" value="<?php echo $this->session->userdata('SESS_USER_ID');?>">
	<div class="form-group">
		<label for="inputUsername">Username</label>
		<input type="text" name="username" class="form-control" value="<?php echo $user->username;?>" placeholder="Masukkan Username" autofocus required>
	</div>
	<div class="form-group">
		<p class="pull-right"><span id="logo_check" class=""></span>  <span id="email_check" class=""></span></p>
		<label for="inputEmail">Email</label>
		<input type="text" name="email" class="form-control" id="inputEmail" value="<?php echo $user->email;?>" placeholder="Masukkan Email" required>
	</div>
</div>
<div class="modal-footer">
	<input type="submit" name="submit" class="btn btn-primary" value="Submit">
</div>
</form>