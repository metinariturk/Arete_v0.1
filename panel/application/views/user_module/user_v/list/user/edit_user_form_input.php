<div class="mb-2">
    <div class="col-form-label">Ad</div>
    <input class="form-control <?php cms_isset(form_error("name"), "is-invalid", ""); ?>"
           name="name" type="text"
           placeholder="Ad"
           value="<?php echo isset($form_error) ? set_value("name") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("name"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Soyad</div>
    <input class="form-control <?php cms_isset(form_error("surname"), "is-invalid", ""); ?>"
           name="surname" type="text"
           placeholder="Soyad"
           value="<?php echo isset($form_error) ? set_value("surname") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("surname"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Meslek</div>
    <input class="form-control <?php cms_isset(form_error("profession"), "is-invalid", ""); ?>"
           name="profession" type="text"
           placeholder="Meslek"
           value="<?php echo isset($form_error) ? set_value("profession") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("profession"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Ünvan</div>
    <input class="form-control <?php cms_isset(form_error("unvan"), "is-invalid", ""); ?>"
           name="unvan" type="text"
           placeholder="Ünvan"
           value="<?php echo isset($form_error) ? set_value("unvan") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("unvan"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Oluşturulma Tarihi</div>
    <input class="form-control <?php cms_isset(form_error("createdAt"), "is-invalid", ""); ?>"
           name="createdAt" type="date"
           value="<?php echo isset($form_error) ? set_value("createdAt") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("createdAt"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Telefon</div>
    <input class="form-control <?php cms_isset(form_error("phone"), "is-invalid", ""); ?>"
           name="phone" type="tel"
           placeholder="Telefon"
           value="<?php echo isset($form_error) ? set_value("phone") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("phone"); ?></div>
    <?php } ?>
</div>
