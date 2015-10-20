<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="mySmallModalLabel">Detail Tanah</h4>
</div>
<ul class="list-group">
    <li class="list-group-item"><span class="glyphicon glyphicon-credit-card"></span> #<?php echo $tanah->no_hak;?></li>
    <li class="list-group-item"><span class="glyphicon glyphicon-user"></span> <?php echo $tanah->nama_pemohon;?></li>
    <li class="list-group-item"><span class="glyphicon glyphicon-check"></span> <?php echo $tanah->jenis_hak;?></li>
    <li class="list-group-item"><span class="glyphicon glyphicon-home"></span> <?php echo $tanah->jalan.' RT '.$tanah->rt.' RW '.$tanah->rw.'<br /> Kel '.$tanah->kelurahan.' Kec '.$tanah->kecamatan.' '.$tanah->kota.' '.$tanah->provinsi;?></li>
    <li class="list-group-item"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $tanah->luas_tanah;?> m2</li>
</ul>