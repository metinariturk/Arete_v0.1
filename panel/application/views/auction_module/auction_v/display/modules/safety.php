<div data-url="<?php echo base_url("$this->Module_Name/refresh_safety_list/$item->id"); ?>"
     action="<?php echo base_url("$this->Module_Name/file_upload/$item->id/Safety"); ?>"
     id="dropzone_safety" class="dropzone"
     data-plugin="dropzone"
     data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id/Safety"); ?>'}">
    <div class="dz-message">
        <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
        <h3>İSG Şartname Dokümanlarını Buraya Ekleyiniz</h3>
    </div>
</div>
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/safety_list_v"); ?>

