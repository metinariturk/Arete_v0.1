<div class="mb-2">
    <div class="col-form-label">Yeni Klasör Adı</div>
    <input class="form-control <?php cms_isset(form_error("new_folder_name"), "is-invalid", ""); ?>"
           type="text"
           name="new_folder_name"
           value="<?php echo isset($form_error) ? set_value("new_folder_name") : ""; ?>"
    >
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("new_folder_name"); ?></div>
    <?php } ?>
</div>
