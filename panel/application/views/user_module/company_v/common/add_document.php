<div data-url="<?php echo base_url("Company/refresh_file_list/$item->id/file_form"); ?>"
      action="<?php echo base_url("Company/file_upload/$item->id/file_form"); ?>" id="dropzone" class="dropzone"
      data-plugin="dropzone"
      data-options="{ url: '<?php echo base_url("Company/file_upload/$item->id/file_form"); ?>'}">
    <div class="dz-message">
        <i class="fa fa-upload"></i><h5>Dosyalarınızı Eklemek İçin Tıklayınız veya Sürükleyip Bırakınız</h5>
    </div>
</div>
