<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="mySmallModalLabel">Syarat Pekerjaan</h4>
</div>
<div class="modal-body">
    <span class="pull-right"><span class="glyphicon glyphicon-info-sign"></span>  Checklist Syarat Jika Data Telah Dikumpulkan Klien</span><br />
</div>
<form action="<?php echo base_url().'Home/update_syarat_pekerjaan/'.$id_berkas;?>" method="post">
  <table class="table">
    <?php
    if ($this->session->userdata('SESS_HAK_AKSES') != 2 || $row->id_user == $this->session->userdata('SESS_USER_ID')) {
    $check = '';
    }else{
    $check = 'disabled';
    }
    ?>
    <?php foreach ($syarat as $srt): ?>
    <tr>
      <td>
        <?php if ($srt->status == "0"): ?>
        <input type="checkbox" name="status<?php echo $srt->id_ket;?>" aria-label="..." class="pointer" <?php echo $check; ?>>
        <?php else: ?>
        <input type="checkbox" name="status<?php echo $srt->id_ket;?>" aria-label="..." class="pointer" checked <?php echo $check; ?>>
        <?php endif ?>
      </td>
      <td>
        <?php echo $srt->syarat; ?>
      </td>
      <td>
        <input type="text" class="form-control" name="ket_syarat<?php echo $srt->id_ket;?>" value="<?php echo $srt->keterangan;?>" placeholder="Masukkan Keterangan Syarat" aria-label="..." <?php echo $check; ?>>
      </td>
    </tr>
    <?php endforeach ?>
  </table>
  <div class="modal-footer">
    <input type="submit" class="btn btn-primary btn-block" value="Save">
  </div>
</form>