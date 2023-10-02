<div data-url="<?php echo base_url("$this->Module_Name/refresh_file_list/$item->id"); ?>"
      action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/$item->vehicle_id"); ?>" id="dropzone" class="dropzone"
      data-plugin="dropzone"
      data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/$item->vehicle_id"); ?>'}">
    <div class="dz-message">
        <i class="fa-solid fa-file fa-4x"></i><h3>Dosyalarınızı buraya bırakın veya seçiniz</h3>
    </div>
</div>
