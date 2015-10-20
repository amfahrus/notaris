<?php if ($this->session->userdata('SESS_HAK_AKSES') !== '0'): ?>
<h1>AKSES DITOLAK</h1>
<?php else: ?>
	<div class="container">
		<h4 class="text-center text-uppercase">GRAFIK PENDAPATAN</h4>
		<div class="panel panel-info">
			<div class="panel-heading text-center">
				<?php
					$tanggal = ($now === "") ? $tanggal = gmdate('Y', time()+60*60*7) : $tanggal = $now ;
					$kemarin = $tanggal - 1;
					if ($kemarin != gmdate('Y', time()+60*60*7)) {
						$linkkmr = base_url().'Home/grafik_pendapatan/'.$kemarin;
					}else{
						$linkkmr = base_url().'Home/grafik_pendapatan';
					}
					$besok = $tanggal + 1;
					if ($besok != gmdate('Y', time()+60*60*7)) {
						$linkbsk = base_url().'Home/grafik_pendapatan/'.$besok;
					}else{
						$linkbsk = base_url().'Home/grafik_pendapatan';
					}
				?>
				<a href="<?php echo $linkkmr;?>">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<?php echo $tanggal; ?>
				<?php if ($now !== ""): ?>
					<a href="<?php echo $linkbsk ?>">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				<?php endif ?>
			</div>
			<div class="panel-body">
				<div id="chart"></div>
			</div>
					
		</div>
	</div>
<?php endif ?>