<div data-url="<?php echo base_url("$this->Module_Name/refresh_qualify_list/$item->id"); ?>"
     action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/Qualify"); ?>"
     id="dropzone_qualify" class="dropzone"
     data-plugin="dropzone"
     data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/Qualify"); ?>'}">
    <div class="dz-message">
        <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
        <h3>Yeterlilik Dokümanlarını Buraya Ekleyiniz</h3>
    </div>
</div>