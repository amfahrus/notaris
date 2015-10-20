<?php
		 $desimal = "0";
		 $desimal2 = "2";
		 $pemecah_desimal = ",";
		 $pemecah_ribuan = ".";
	 ?>
<div class="container-fluid">
	<br>
	<h4 class="text-center text-uppercase">BIAYA BERKAS #BKS<?php echo $id_berkas;?></h4>
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
			<?php 
				if ($aksi == "tambah"){
					$back = base_url().'Home/biaya_berkas/'.$id_berkas;
					$kembali = "Kembali";
				}
				else if($aksi == "edit"){
					$back = base_url().'Home/biaya_berkas/'.$id_berkas;
					$kembali = "Kembali";
				}else{
					$back = base_url().'Home/berkas_pekerjaan';
					$kembali = "Kembali ke Berkas Pekerjaan";
				} 
			?>
			<a href="<?php echo $back;?>"><span class="glyphicon glyphicon-menu-left"></span><?php echo $kembali;?></a>
		</div>
		<table id="biayaBerkas" class="table">
		<?php if ($aksi == "kosong"):
			$disabled = "disabled";
			$duit = number_format($biaya_klien->biaya_klien, $desimal, $pemecah_desimal, $pemecah_ribuan); ?>
		<tr>
			<td colspan="5">
				<a href="<?php echo base_url().'Home/biaya_berkas/'.$id_berkas.'/tambah';?>"><span class="glyphicon glyphicon-plus"></span> Tambah Biaya Titip</a>
			</td>
		</tr>
		<tr>
		<?php if ($this->session->userdata('SESS_HAK_AKSES') != 2): ?>
		<td colspan="5">
			<a href="<?php echo base_url().'Home/biaya_berkas/'.$id_berkas.'/edit';?>"><span class="glyphicon glyphicon-edit"></span> Edit Biaya Berkas</a>
		</td>
		<?php endif ?>
		</tr>
		<?php elseif($aksi == "tambah"):
			$disabled = "disabled";
			$duit = number_format($biaya_klien->biaya_klien, $desimal, $pemecah_desimal, $pemecah_ribuan);
			 ?>
		<form action="<?php echo base_url().'Home/input_biaya_titip/'.$id_berkas;?>" method="post">
		<tr id="baris">
			<td>Tambah Biaya Titip</td>
			<td>
				<input type="text" name="tgl" value="" id="tanggalan" class="form-control datepick" placeholder="yyyy-mm-dd">
			</td>
			<td colspan="2">
				<div class="input-group">
					<span class="input-group-addon">Rp</span>
					<input type="number" id="BiayaTitip" name="biaya_titip"  class= "form-control" value="">
					<span class="input-group-addon">,00</span>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<div class="form-group pull-right">
					<input type="submit" class="btn btn-default" value="Submit">
				</div>
			</td>
		</tr>
		</form>
		<?php elseif($aksi == "edit"): 
			$disabled = "";
			$duit = $biaya_klien->biaya_klien;
			endif ?>
		<form action="<?php echo base_url().'Home/update_biaya_berkas/'.$id_berkas;?>" method="post">
			<tr>
				<td>Biaya Klien</td>
				<td colspan="4">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" id="BiayaKlien" name="biaya_klien" value="<?php echo $duit;?>" <?php echo $disabled;?>>
						<span class="input-group-addon">,00</span>
					</div>
				</td>
			</tr>
			<?php 
				$no = 0;
				$total_titip = 0;
				foreach ($biaya_titip as $biaya):
				$no++;
				$total_titip += $biaya->biaya_titip; ?>
			<input type="hidden" name="id_titip[]" value="<?php echo $biaya->id_titip;?>">
			<tr>
				<td>Biaya Titip <?php echo $no;?></td>
				<td>
					<input type="text" name="tgl_titip[]" value="<?php echo $biaya->tgl_titip;?>" id="tanggalan" class="form-control datepick" placeholder="yyyy-mm-dd" <?php echo $disabled;?>>
				</td>
				<td colspan="3">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="number" id="BiayaTitip<?php echo $no;?>" name="biaya_titip[]"  class= "form-control" value="<?php echo $biaya->biaya_titip;?>" <?php echo $disabled;?>>
						<span class="input-group-addon">,00</span>
					</div>
				</td>
			</tr>
			<?php endforeach ?>
			<?php if ($aksi == "edit"): ?>
			<tr>
				<td colspan="5">
					<div class="form-group pull-right">
						<input type="submit" class="btn btn-default" value="Submit">
			        </div>
				</td>
			</tr>
			<?php else: ?>
			<tr>
				<td>Kekurangan</td>
				<td colspan="4">Rp <?php echo number_format($biaya_klien->biaya_klien - $total_titip, $desimal2, $pemecah_desimal, $pemecah_ribuan); ?></td>
			</tr>
			<?php endif ?>
		</table>
		</form>
	</div>
</div>