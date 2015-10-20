<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="mySmallModalLabel">Biaya Pekerjaan</h4>
</div>
<form action="<?php echo base_url().'Home/update_detail_berkas/'.$id_berkas.'/'.$id_pkj;?>" method="post">
  <table class="table">
    <?php foreach ($detail as $det): ?>
      <tr>
        <td>
            <?php if ($det->status === '0'): ?>
            <input type="checkbox" name="<?php echo 'status'.$det->id_detail;?>" aria-label="..." class="pointer">
            <?php else: ?>
            <input type="checkbox" name="<?php echo 'status'.$det->id_detail;?>" aria-label="..." class="pointer" checked>
            <?php endif ?>
        </td>
        <td>
          <?php echo $det->langkah_pekerjaan; ?>
        </td>
        <td>
          <?php if ($det->biaya_default == ""): ?>
            <input type="text" name="biaya_pkj<?php echo $det->id_detail;?>" class="form-control" value="<?php echo $det->biaya_pekerjaan;?>" placeholder="Masukkan Biaya Detail Pekerjaan" aria-label="...">
          <?php else: ?>
            <?php if ($this->session->userdata('SESS_HAK_AKSES') != '2'): ?>
              <input type="text" class="form-control" value="Rp <?php echo $det->biaya_default;?>,-" disabled aria-label="...">
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