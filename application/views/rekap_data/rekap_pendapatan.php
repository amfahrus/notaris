<?php if ($this->session->userdata('SESS_HAK_AKSES') !== '0'): ?>
<h1>AKSES DITOLAK</h1>
<?php else: ?>
	<div class="container">
		<h4 class="text-center text-uppercase">REKAP PENDAPATAN</h4>
		<div class="panel panel-info">
			<div class="panel-heading text-center">
				<?php
				$desimal = "2";
				$pemisah_desimal = ",";
				$pemisah_ribuan = ".";
				$tanggal = ($now === "") ? $tanggal = gmdate('Y-m', time()+60*60*7) : $tanggal = $now ;
				$colspan = "3";
				$kemarin = date('Y-m', strtotime($tanggal." -1 month"));
				$besok = date('Y-m', strtotime($tanggal." +1 month"));
				if ($besok != gmdate('Y-m', time()+60*60*7)) {
					$linkbsk = base_url().'Home/rekap_pendapatan/'.$besok;
				}else{
					$linkbsk = base_url().'Home/rekap_pendapatan';
				}
				if ($kemarin !== gmdate('Y-m', time()+60*60*7)) {
					$linkkmr = base_url().'Home/rekap_pendapatan/'.$kemarin;
				}else{
					$linkkmr = base_url().'Home/rekap_pendapatan';
				}
				?>
				<a href="<?php echo $linkkmr ?>">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<?php echo $tanggal;?>
				<?php if ($now !== ""): ?>
					<a href="<?php echo $linkbsk ?>">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				<?php endif ?>
			</div>
			<div class="panel-body">
				<div class="col-md-6">
					<table class="table table-bordered">
						<tr class="success">
							<th class="text-center" colspan="3">Pemasukan</th>
						</tr>
						<tr>
							<th>Tanggal</th>
							<th>Keterangan</th>
							<th>Nominal</th>
						</tr>
						<?php $total_pemasukan = 0; ?>
						<?php if ($pemasukan === "belum"): ?>
							<tr>
								<td colspan="3" class="text-center">Belum Ada Pemasukan</td>
							</tr>
						<?php else: ?>
							<?php
								foreach ($pemasukan as $masuk): 
									$total_pemasukan += $masuk->biaya_titip;
							?>
								<tr>
									<td><?php echo $masuk->tgl_titip; ?></td>
									<td>Titip <a href="<?php echo base_url().'Home/detail_berkas_pengeluaran/'.$masuk->id_berkas;?>" data-toggle="modal" data-target=".extra">#BKS<?php echo $masuk->id_berkas; ?></a></td>
									<td>Rp <?php echo number_format($masuk->biaya_titip, $desimal, $pemisah_desimal, $pemisah_ribuan); ?></td>
								</tr>
							<?php endforeach ?>
						<?php endif ?>
						<tr>
							<th colspan="2" class="text-right">Total Pemasukan</th>
							<th>Rp <?php echo number_format($total_pemasukan, $desimal, $pemisah_desimal, $pemisah_ribuan); ?></th>
						</tr>
					</table>
				</div>
				<div class="col-md-6">
					<table class="table table-bordered">
						<tr class="danger">
							<th class="text-center" colspan="3">Pengeluaran</th>
						</tr>
						<tr>
							<th>Tanggal</th>
							<th>Keterangan</th>
							<th>Nominal</th>
						</tr>
						<?php $total_pengeluaran = 0; ?>
						<?php if ($pengeluaran === "belum" && $tambahan === "belum"): ?>
							<tr>
								<td colspan="3" class="text-center">Belum Ada Pengeluaran</td>
							</tr>
						<?php else: ?>
							<?php if ($pengeluaran !== "belum"): ?>
								<?php
								foreach ($pengeluaran as $keluar):
								?>
									<tr>
										<td><?php echo $keluar->tgl_bayar; ?></td>
										<td><?php echo $keluar->langkah_pekerjaan;?> <a href="<?php echo base_url().'Home/detail_berkas_pengeluaran/'.$keluar->id_berkas;?>" data-toggle="modal" data-target=".extra"><?php echo '#BKS'.$keluar->id_berkas; ?></a></td>
										<td>Rp <?php echo number_format($keluar->biaya_bayar+$keluar->biaya_pekerjaan, $desimal, $pemisah_desimal, $pemisah_ribuan); ?></td>
									</tr>
								<?php
									$keluar->biaya_bayar += $keluar->biaya_pekerjaan;
									$total_pengeluaran += $keluar->biaya_bayar;
								endforeach ?>
							<?php endif ?>
							<?php if ($tambahan !== "belum"): ?>
								<?php
								foreach ($tambahan as $tambah):
									$total_pengeluaran += $tambah->nominal_pengeluaran;
								?>
									<tr>
										<td><?php echo $tambah->tgl_pengeluaran; ?></td>
										<td><?php echo $tambah->ket_pengeluaran; ?></td>
										<td>Rp <?php echo number_format($tambah->nominal_pengeluaran, $desimal, $pemisah_desimal, $pemisah_ribuan); ?></td>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						<?php endif ?>
						<tr>
							<th colspan="2" class="text-right">Total Pengeluaran</th>
							<th>Rp <?php echo number_format($total_pengeluaran, $desimal, $pemisah_desimal, $pemisah_ribuan); ?></th>
						</tr>
					</table>
				</div>
				<div class="col-md-12">
					
					<table class="table table-bordered">
						<tr class="warning">
							<th colspan="2" class="text-center">Total Pendapatan</th>
						</tr>
						<tr>
							<th>Pemasukan</th>
							<th>Rp <?php echo number_format($total_pemasukan, $desimal, $pemisah_desimal, $pemisah_ribuan); ?></th>
						</tr>
						<tr>
							<th>Pengeluaran</th>
							<th>Rp <?php echo number_format($total_pengeluaran, $desimal, $pemisah_desimal, $pemisah_ribuan); ?></th>
						</tr>
						<tr>
							<th>Total</th>
							<th>Rp <?php echo number_format($total_pemasukan-$total_pengeluaran, $desimal, $pemisah_desimal, $pemisah_ribuan); ?></th>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- modal detail berkas -->
	<div class="modal fade extra" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
			</div>
		</div>
	</div>
<?php endif ?>