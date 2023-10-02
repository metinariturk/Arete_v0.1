<?php if (company_avatar_isset($item->id)) { ?>
    <?php $avatars = directory_map("uploads/companys_v/system_companys/$item->id"); ?>
    <?php foreach ($avatars as $avatar) { ?>
        <img style="max-width:50hv; max-height: 25vh; "
             src="<?php echo base_url("uploads/companys_v/system_companys/$item->id/$avatar"); ?>">
        <div class="icon-wrapper">
            <a class="icofont icofont-pencil-alt-5" onclick="deleteCompanyavatar(this)"
               data-url="<?php echo base_url("$this->Module_Name/delete_avatar/$item->id"); ?>"
               url="<?php echo base_url("$this->Module_Name/delete_avatar/$item->id"); ?>"></a>
        </div>
    <?php } ?>
<?php } else { ?>
    <div data-url="<?php echo base_url("$this->Module_Name/refresh_file_list/$item->id"); ?>"
         action="<?php echo base_url("$this->Module_Name/file_upload/$item->id"); ?>"
         id="dropzone_avatar" class="dropzone"
         data-plugin="dropzone"
         data-options="{ url: '<?php echo base_url("$this->Module_Name/file_upload/$item->id"); ?>'}">
        <div class="dz-message">
            <i class="fa-solid fa-cloud-arrow-up fa-4x"></i>
            <h3>Firma Logosunu Buraya Bırakınız</h3>
        </div>
    </div>
<?php } ?>