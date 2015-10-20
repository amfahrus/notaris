<div class="container">
  <h4 class="text-center text-uppercase">DAFTAR PEKERJAAN <?php echo $aktor;?></h4>
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
    <?php if ($this->session->userdata('SESS_HAK_AKSES') == 3): ?>
      <div class="panel-body">
        <button class="btn btn-primary" data-toggle="modal" data-target=".tambah-pekerjaan">
        <span class="glyphicon glyphicon-plus"></span>  Daftar Pekerjaan
        </button>
      </div>
    <?php endif ?>
    <table class="table table-striped table-hover" >
      <tr>
        <th>Nama Pekerjaan</th>
        <th>Jenis Akta</th>
      </tr>
      <?php foreach ($list as $l): ?>
      <tr class="row-modal" data-toggle="modal" data-target=".menu" data-jenis="pkj" data-aktor="<?php echo $aktor;?>" data-nama="<?php echo $l->nama_pekerjaan;?>" data-akta="<?php echo $l->jenis_akta;?>" data-id="<?php echo $l->id_pekerjaan;?>">
        <td><?php echo $l->nama_pekerjaan;?></td>
        <td><?php echo $l->jenis_akta;?></td>
      </tr>
      <?php endforeach ?>
    </table>
  </div>
  <!-- modal tambah pekerjaan -->
  <div class="modal fade tambah-pekerjaan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="mySmallModalLabel">Tambah Daftar Pekerjaan</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo base_url();?>Home/input_daftar_pekerjaan" method="POST">
            <div class="form-group">
              <label for="inputPekerjaan">Nama Pekerjaan</label>
              <input type="text" class="form-control" name="pekerjaan" id="inputPekerjaan" placeholder="Masukkan Nama Pekerjaan" autofocus required>
            </div>
            <div class="form-group">
              <label for="inputAkta">Jenis Akta</label>
              <input type="text" class="form-control" name="akta" id="inputAkta" placeholder="Masukkan Jenis Akta">
            </div>
            <div class="form-group">
              <label for="selectAktor">Pilih Aktor Pekerjaan</label>
              <select class="form-control" name="aktor" id="selectAktor">
                <option><?php echo $aktor;?></option>
                <?php if ($aktor === 'Notaris'): ?>
                <option>PPAT</option>
                <?php else: ?>
                <option>Notaris</option>
                <?php endif ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- modal edit pekerjaan -->
  <div class="modal fade edit-pekerjaan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="mySmallModalLabel">Edit Daftar Pekerjaan</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo base_url();?>Home/edit_daftar_pekerjaan/<?php echo $aktor;?>" method="POST">
            <input type="hidden" name="id" id="inputId" value="">
            <div class="form-group">
              <label for="inputPekerjaan">Nama Pekerjaan</label>
              <input type="text" class="form-control" name="pekerjaan" id="inputPekerjaan" value="" placeholder="Masukkan Nama Pekerjaan" autofocus required>
            </div>
            <div class="form-group">
              <label for="inputAkta">Jenis Akta</label>
              <input type="text" class="form-control" name="akta" id="inputAkta" value="" placeholder="Masukkan Jenis Akta">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
          </form>
        </div>
      </div>
    </div>
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
            <a id="detail_pekerjaan" href="#" class="list-group-item"><span class="glyphicon glyphicon-eye-open"></span>  Lihat Detail</a>
            <?php if ($this->session->userdata('SESS_HAK_AKSES') == 3): ?>
              <a id="edit" href="#" data-toggle="modal" data-target=".edit-pekerjaan" data-id="" data-nama="" data-akta="" class="list-group-item"><span class="glyphicon glyphicon-edit "></span>  Edit</a>
              <a id="delete" href="#" data-toggle="modal" data-target=".delete" data-id="" class="list-group-item"><span class="glyphicon glyphicon-trash"></span>  Hapus</a>
            <?php endif ?>
          </ul>
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
          <form action="<?php echo base_url();?>Home/delete_daftar_pekerjaan/<?php echo $aktor;?>" method="POST">
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
</div>