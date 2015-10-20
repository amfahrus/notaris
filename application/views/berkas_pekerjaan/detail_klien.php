<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="mySmallModalLabel">Detail Klien</h4>
</div>
<ul class="list-group">
    <li class="list-group-item"><span class="glyphicon glyphicon-user"></span> <?php echo $klien->nama_pemohon;?></li>
    <li class="list-group-item"><span class="glyphicon glyphicon-credit-card"></span> #<?php echo $klien->id_pemohon;?></li>
    <li class="list-group-item"><span class="glyphicon glyphicon-home"></span> <?php echo $klien->jalan.' RT '.$klien->rt.' RW '.$klien->rw.'<br /> Kel '.$klien->kelurahan.' Kec '.$klien->kecamatan.' '.$klien->kota.' '.$klien->provinsi;?></li>
    <li class="list-group-item"><span class="glyphicon glyphicon-phone"></span> <?php echo $klien->hp;?></li>
    <li class="list-group-item"><span class="glyphicon glyphicon-envelope"></span> <?php echo $klien->email;?></li>
</ul>