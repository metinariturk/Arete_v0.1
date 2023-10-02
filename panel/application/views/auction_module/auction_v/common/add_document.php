<div data-url="<?php echo base_url("$this->Module_Name/refresh_file_list/$item->id"); ?>"
     action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/Main"); ?>" id="dropzone" class="dropzone"
     data-plugin="dropzone"
     data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/Main"); ?>'}">
    <div class="dz-message">
        <i class="fa-solid fa-cloud-arrow-up fa-4x"></i><h3>Dosyalarınızı Eklemek İçin Tıklayınız veya Sürükleyip Bırakınız</h3>
    </div>
</div>
