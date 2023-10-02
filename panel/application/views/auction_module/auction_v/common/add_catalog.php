<div data-url="<?php echo base_url("$this->Module_Name/refresh_catalog/$item->id"); ?>"
      action="<?php echo base_url("$this->Module_Name/upload_catalog/$item->id"); ?>" id="dropzone_catalog" class="dropzone"
      data-plugin="dropzone"
      data-options="{ url: '<?php echo base_url("$this->Module_Name/upload_catalog/$item->id"); ?>'}">
    <div class="dz-message">
        <i class="fa-solid fa-cloud-arrow-up fa-4x"></i><h3>Görselleri Eklemek İçin Tıklayınız veya Sürükleyip Bırakınız</h3>
    </div>
</div>
