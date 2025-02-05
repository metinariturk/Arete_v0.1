<div class="mb-2">
    <div class="col-form-label">Hakediş No</div>
    <input class="form-control" type="number" name="hakedis_no" readonly
           value="<?php echo $edit_payment->hakedis_no; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("hakedis_no"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Son İmalat
        Tarihi
    </div>
    <input class="flatpickr form-control <?php cms_isset(form_error("imalat_tarihi"), "is-invalid", ""); ?>"
           type="text" id="flatpickr" style="width: 100%"
           name="imalat_tarihi"
           value="<?php echo isset($form_error) ? set_value("imalat_tarihi") : dateFormat_dmy($edit_payment->imalat_tarihi); ?>"
           data-options="{ format: 'DD-MM-YYYY' }"
           data-language="tr">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("imalat_tarihi"); ?></div>
    <?php } ?>
</div>