<div class="container">
	<?php if ($this->session->userdata('SESS_HAK_AKSES') == 1): ?>
	<h4 class="text-center text-uppercase">KELOLA USER</h4>
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
		<div class="panel-body">
			<button class="btn btn-primary" data-toggle="modal" data-target=".tambah-user">
			<span class="glyphicon glyphicon-plus"></span>  User
			</button>
			<?php if ($this->session->flashdata('pwd')): ?>
			<p></p>
			<p><span class="glyphicon glyphicon-info-sign"></span> Password Hasil Reset : <strong><?php echo $this->session->flashdata('pwd'); ?></strong></p>
			<?php endif; ?>
		</div>
		<table class="table table-striped table-hover">
			<tr>
				<th>Username</th>
				<th>Hak Akses</th>
			</tr>
			<?php foreach ($user as $list): ?>
			<tr class="row-modal" data-toggle="modal" data-target=".menu" data-jenis="user" data-id="<?php echo $list->id_user;?>" data-user="<?php echo $list->username;?>" data-email="<?php echo $list->email; ?>" data-akses="<?php echo $list->hak_akses;?>">
				<td><?php echo $list->username;?></td>
				<?php switch ($list->hak_akses) {
					case '0':
						$hak = "Notaris";
						break;
					case '1':
						$hak = "Admin";
						break;
					case '2':
						$hak = "Staff";
						break;
					case '3':
						$hak = "Staff Khusus";
						break;
				}?>
				<td><?php echo $hak;?></td>
			</tr>
			<?php endforeach ?>
		</table>
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
						<a id="edit" href="#" data-toggle="modal" data-target=".edit-user" data-id="" data-user="" data-akses="" class="list-group-item"><span class="glyphicon glyphicon-edit "></span>  Edit</a>
						<!-- <a id="reset" href="#" class="list-group-item" data-toggle="modal" data-target=".reset-pwd" data-id=""><span class="glyphicon glyphicon-lock"></span> Reset Password</a> -->
						<a id="delete" href="#" data-toggle="modal" data-target=".delete" data-id="" class="list-group-item"><span class="glyphicon glyphicon-trash"></span>  Hapus</a>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- modal tambah user -->
	<div class="modal fade tambah-user" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="mySmallModalLabel">Tambah User</h4>
				</div>
				<div class="modal-body">
					<form id="userForm" action="<?php echo base_url();?>Home/tambah_user" method="POST">
						<div class="form-group">
							<label for="inputUser">Username</label>
							<p class="pull-right"><span id="logo_check2" class=""></span>  <span id="username_check" class=""></span></p>
							<input type="text" class="form-control" name="username" id="inputUser" value="<?php echo set_value('inputUser'); ?>" placeholder="Masukkan Username" autofocus required>
						</div>
						<div class="form-group">
							<label for="inputPass">Password</label>
							<!-- <p><span id="pass_check" class=""></span></p> -->
							<input type="password" class="form-control" name="password" id="inputPass" placeholder="Masukkan Password" required>
						</div>
						<div class="form-group">
							<p class="pull-right"><span id="logo_check" class=""></span>  <span id="email_check" class=""></span></p>
							<label for="inputEmail">Email</label>
							<input type="email" class="form-control" name="email" id="inputEmail" placeholder="Masukkan Email" required >
						</div>
						<div class="form-group">
							<label for="optionAkses">Hak Akses</label>
							<select name="hak_akses" class="form-control">
								<option id="optionAkses" value="0">Notaris</option>
								<option id="optionAkses1" value="1">Admin</option>
								<option id="optionAkses2" value="2">Staff</option>
								<option id="optionAkses3" value="2">Staff Khusus</option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary btn-block">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- modal edit user -->
	<div class="modal fade edit-user" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="mySmallModalLabel">Edit User</h4>
				</div>
				<div class="modal-body">
					<form action="<?php echo base_url();?>Home/edit_user/kelola" method="POST">
						<input type="hidden" name="id" id="inputId" value="">
						<div class="form-group">
							<label for="inputUser">Username</label>
							<p class="pull-right"><span id="logo_check2" class=""></span>  <span id="username_check" class=""></span></p>
							<input type="text" class="form-control" name="username" id="inputUser" value="<?php echo set_value('inputUser');?>" placeholder="Masukkan Username" autofocus required>
						</div>
						<div class="form-group">
							<p class="pull-right"><span id="logo_check" class=""></span>  <span id="email_check" class=""></span></p>
							<label for="inputEmail">Email</label>
							<input type="email" class="form-control" name="email" id="inputEmail" placeholder="Masukkan Email" value="<?php echo set_value('inputEmail');?>" required >
						</div>
						<div class="form-group">
							<label for="optionAkses">Hak Akses</label>
							<select name="hak_akses" class="form-control">
								<option id="optionAkses" value=""></option>
								<option id="optionAkses1" value=""></option>
								<option id="optionAkses2" value=""></option>
								<option id="optionAkses3" value=""></option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary btn-block">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- modal reset password -->
	<div class="modal fade reset-pwd" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="mySmallModalLabel">Verifikasi</h4>
				</div>
				<div class="modal-body">
					<form action="<?php echo base_url();?>Home/reset_password" method="POST">
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
	<!-- modal delete -->
	<div class="modal fade delete" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="mySmallModalLabel">Verifikasi</h4>
				</div>
				<div class="modal-body">
					<form action="<?php echo base_url();?>Home/delete_user" method="POST">
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
	<?php else: ?>
	<h1>AKSES DITOLAK</h1>
	<?php endif ?>
</div>