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
    <div class="col-form-label">Giriş Tarihi</div>
    <input class="flatpickr form-control digits <?php cms_isset(form_error("createdAt"), "is-invalid", ""); ?>"
           type="text" id="createdAt"
           name="createdAt"
           value="<?php echo isset($form_error) ? set_value("createdAt") : ""; ?>"
           data-date-format="d-m-Y"
           data-language="tr">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("createdAt"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Telefon</div>
    <input id="phone" name="phone" class="form-control <?php cms_isset(form_error("phone"), "is-invalid", ""); ?>"
           type="text" placeholder="Telefon"
           value="<?php echo isset($form_error) ? set_value("phone") : ""; ?>"
    >

    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("phone"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Kullanıcı Adı</div>
    <input class="form-control <?php cms_isset(form_error("user_name"), "is-invalid", ""); ?>" type="text"
           placeholder="Kullanıcı Adı" name="user_name" id="user_name"
           value="<?php echo isset($form_error) ? set_value("user_name") : ""; ?>"
    >
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("user_name"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">E-Posta</div>
    <input class="form-control <?php cms_isset(form_error("email"), "is-invalid", ""); ?>"
           name="email" type="email"
           placeholder="E-Posta"
           value="<?php echo isset($form_error) ? set_value("email") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("email"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Banka</div>
    <input class="form-control  <?php cms_isset(form_error("bank"), "is-invalid", ""); ?>" name="bank"
           list="datalistOptions" placeholder="Banka Adı Yazınız"
           value="<?php echo isset($form_error) ? set_value("bank") : ""; ?>">
    <datalist id="datalistOptions">
        <?php $bankalar = get_as_array($settings->bankalar);
        foreach ($bankalar as $banka) {
            echo "<option value='$banka'>$banka</option>";
        } ?>
    </datalist>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("bank"); ?></div>
    <?php } ?>
</div>
<div class="mb-3">
    <label class="col-form-label" for="IBAN">IBAN:</label>
    <input id="IBAN" type="text" name="IBAN"
           class="form-control <?php cms_isset(form_error("IBAN"), "is-invalid", ""); ?>"
           value="<?php echo isset($form_error) ? set_value("IBAN") : ""; ?>"
           placeholder="TR__ ____ ____ ____ ____ ____ __">

    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error('IBAN'); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="form-check">
        <input class="form-check-input <?php cms_isset(form_error("user_role"), "is-invalid", ""); ?>"
               type="checkbox" id="user_role"
               name="user_role" value="1"
            <?php echo set_checkbox('user_role', '1'); ?>>
        <label class="form-check-label" for="user_role">
            Sistem Kullanıcısı
        </label>
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback d-block"><?php echo form_error("user_role"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Şifre</div>
    <input class="form-control <?php cms_isset(form_error("password"), "is-invalid", ""); ?>"
           name="password" type="password" autocomplete="new-password"
           placeholder="Şifre">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("password"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Şifre Tekrar</div>
    <input class="form-control <?php cms_isset(form_error("password_check"), "is-invalid", ""); ?>"
           name="password_check" type="password" autocomplete="new-password"
           placeholder="Şifre Tekrar">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("password_check"); ?></div>
    <?php } ?>
</div>