<div class="container">
	<h4 class="text-center text-uppercase">AKUN SETTING</h4>
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
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Identitas User</h3>
		</div>
		<div class="panel-body">
			<table class="table">
				<tr>
					<th>Username</th>
					<td><?php echo $this->session->userdata('SESS_USERNAME'); ?></td>
				</tr>
				<tr>
					<th>Email</th>
					<td><?php echo $user->email; ?></td>
				</tr>
			</table>
	    </div>
	    <div class="panel-footer text-right">
	    	<a href="<?php echo base_url('Home/ubah_user'); ?>" class="btn btn-warning btn-sm" data-toggle="modal" data-target=".extra"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
	    </div>
	</div>
	<div class="panel panel-default">
	    <div class="panel-heading">
			<h3 class="panel-title">Password</h3>
		</div>
		<div class="panel-body">
			<table class="table">
				<tr>
					<th>Password</th>
					<td>********</td>
				</tr>
			</table>
	    </div>
	    <div class="panel-footer text-right">
	    	<a href="<?php echo base_url('Home/ubah_pwd'); ?>" class="btn btn-warning btn-sm" data-toggle="modal" data-target=".extra"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
	    </div>
	</div>
	<div class="modal fade extra" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
			</div>
		</div>
	</div>