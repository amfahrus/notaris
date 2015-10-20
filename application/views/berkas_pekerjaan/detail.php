<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="mySmallModalLabel">Detail Pekerjaan</h4>
</div>
<div class="modal-body">
    <span class="pull-right"><span class="glyphicon glyphicon-info-sign"></span>  Checklist Detail Jika Telah Dikerjakan</span><br />
</div>
<form action="<?php echo base_url().'Home/update_detail_berkas/'.$id_berkas.'/'.$id_pkj;?>" method="post">
  <table class="table">
    <?php
      if ($this->session->userdata('SESS_HAK_AKSES') != 2 || $row->id_user == $this->session->userdata('SESS_USER_ID')) {
        $check = '';
      }else{
        $check = 'disabled';
      }
    ?>
    <?php foreach ($detail as $det): ?>
      <tr>
        <td class="col-md-1">
            <?php if ($det->status === '0'): ?>
            <input type="checkbox" name="<?php echo 'status'.$det->id_detail;?>" aria-label="..." class="pointer" <?php echo $check; ?>>
            <?php else: ?>
            <input type="checkbox" name="<?php echo 'status'.$det->id_detail;?>" aria-label="..." class="pointer" checked <?php echo $check; ?>>
            <?php endif ?>
        </td>
        <td class="col-md-6">
          <?php echo $det->langkah_pekerjaan; ?>
        </td>
        <td class="col-md-5">
          <?php if ($det->biaya_default == ""): ?>
            <?php if ($det->status_biaya == 1): ?>
              <div class="input-group">
                <input type="text" name="biaya_pkj<?php echo $det->id_detail;?>" aria-describedby="sizing-addon1" class="form-control" value="<?php echo $det->biaya_pekerjaan;?>" placeholder="Masukkan Biaya Detail Pekerjaan" aria-label="..." disabled>
                <span id="sizing-addon1" class="input-group-addon"><span class="glyphicon glyphicon-lock" data-toggle="tooltip" title="Sudah Dibayar Notaris"></span></span>
              </div>
            <?php else: ?>
              <input type="text" name="biaya_pkj<?php echo $det->id_detail;?>" class="form-control" value="<?php echo $det->biaya_pekerjaan;?>" placeholder="Masukkan Biaya Detail Pekerjaan" aria-label="..." <?php echo $check; ?>>
            <?php endif ?>
          <?php else: ?>
              <?php if ($det->status_biaya == 1): ?>
                <?php $biaya = ($det->biarkan == 1) ? $biaya = $det->biaya_bayar : $biaya = $det->biaya_default ; ?>
                <div class="input-group">
                  <input type="text" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $biaya;?>" disabled aria-label="...">
                  <span id="sizing-addon2" class="input-group-addon"><span class="glyphicon glyphicon-lock" data-toggle="tooltip" title="Sudah Dibayar Notaris"></span></span>
                </div>
              <?php else: ?>
                <input type="text" class="form-control" value="<?php echo $det->biaya_default;?>" disabled aria-label="...">
              <?php endif ?>
          <?php endif ?>
        </td>
      </tr>
    <?php endforeach ?>
  </table>
<div class="modal-footer">
  <input type="submit" class="btn btn-primary btn-block" value="Save">
</div>
</form>