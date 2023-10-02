<div data-url="<?php echo base_url("$this->Module_Name/refresh_file_list/$item->id"); ?>"
      action="<?php echo base_url("$this->Module_Name/file_upload/$item->id"); ?>" id="dropzone" class="dropzone"
      data-plugin="dropzone" style="height: 100px"
      data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id"); ?>'}">
    <div><i class="fa fa-upload" style="font-size: 30px"></i>
        <h6>Dosyalarınızı Ekleyiniz</h6>
    </div>
</div>
