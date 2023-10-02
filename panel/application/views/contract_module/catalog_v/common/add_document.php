<div data-url="<?php echo base_url("$this->Module_Name/refresh_file_list/$contract_id/$catalog_name"); ?>"
      action="<?php echo base_url("$this->Module_Name/file_upload/$contract_id/$catalog_name"); ?>" id="dropzone" class="dropzone"
      data-plugin="dropzone"
      data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$contract_id/$catalog_name"); ?>'}">
    <div class="dz-message">
        <i class="fa-solid fa-cloud-arrow-up fa-4x"></i><h3>Görselleri Eklemek İçin Tıklayınız veya Sürükleyip Bırakınız</h3>
    </div>
</div>
