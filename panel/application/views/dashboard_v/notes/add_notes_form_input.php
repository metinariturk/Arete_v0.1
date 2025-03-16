<div class="mb-2">
    <div class="col-form-label">Hatırlatma Tarihi</div>
    <input class="flatpickr form-control <?php cms_isset(form_error("reminder"), "is-invalid", ""); ?>"
           type="text" id="flatpickr"
           name="reminder"
           value="<?php echo isset($form_error) ? set_value("reminder") : ""; ?>" />
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("reminder"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <input class="form-control <?php cms_isset(form_error("title"), "is-invalid", ""); ?>"
           name="title" type="text"
           placeholder="Başlık"
           value="<?php echo isset($form_error) ? set_value("title") : ""; ?>" />
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("title"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <input class="form-control <?php cms_isset(form_error("topic"), "is-invalid", ""); ?>"
           name="topic" type="text"
           placeholder="Konu"
           value="<?php echo isset($form_error) ? set_value("topic") : ""; ?>" />
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("topic"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <input class="form-control <?php cms_isset(form_error("note"), "is-invalid", ""); ?>"
           name="note" type="text"
           placeholder="Not"
           value="<?php echo isset($form_error) ? set_value("note") : ""; ?>" />
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("note"); ?></div>
    <?php } ?>
</div>