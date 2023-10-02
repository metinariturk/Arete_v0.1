<div data-url="<?php echo base_url("$this->Module_Name/refresh_technical_list/$item->id"); ?>"
     action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/Technical"); ?>"
     id="dropzone_technical" class="dropzone"
     data-plugin="dropzone"
     data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/Technical"); ?>'}">
    <div class="dz-message">
        <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
        <h3>Teknik Şartname Dokümanlarını Buraya Ekleyiniz</h3>
    </div>
</div>
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/technical_list_v"); ?>

