<div class="mb-2">
    <div class="col-form-label">Avans Ödeme Tarihi</div>
    <input class="flatpickr form-control <?php cms_isset(form_error("avans_tarih"), "is-invalid", ""); ?>"
           type="text" id="flatpickr"
           name="avans_tarih"
           value="<?php echo isset($form_error) ? set_value("avans_tarih") : ""; ?>"
    >
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("avans_tarih"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Ödeme Türü</div>
    <select id="select2-demo-1" style="width: 100%;"
            class="form-control <?php cms_isset(form_error("avans_turu"), "is-invalid", ""); ?>"
            data-plugin="select2" name="avans_turu">
        <option selected="selected"
                value="<?php echo isset($form_error) ? set_value("avans_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("avans_turu") : "Seçiniz"; ?>
        </option>
        <?php $odeme_turleri = get_as_array($settings->odeme_turu);
        foreach ($odeme_turleri as $odeme_turu) {
            echo "<option value='$odeme_turu'>$odeme_turu</option>";
        } ?>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("avans_turu"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Avans Tutar</div>
    <?php if (isset($form_error)) { ?>
        <?php
        // Avans miktarı alanı boş değilse ve sözleşme bedelinden fazla girildiyse kontrol yap
        if (!empty(set_value("avans_miktar")) && form_error("avans_miktar")) { ?>
            <div style="color: red">
                *** Sözleşme bedelinden fazla tahsilat yapılamaz. Özel bir gerekçe ile fazla
                tahsilat yapılması gerekiyorsa aşağıdaki onay kutusunu işaretleyiniz.
                <br>
                <input name="onay" type="checkbox" id="cb-10"> Sözleşme bedelinden fazla tahsilat
                yapmak istiyorum!
            </div>
        <?php } ?>
    <?php } ?>
    <input class="form-control <?php cms_isset(form_error("avans_miktar"), "is-invalid", ""); ?>"
           name="avans_miktar" type="number"
           placeholder="Avans Tutar"
           value="<?php echo isset($form_error) ? set_value("avans_miktar") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("avans_miktar"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Vade Tarihi</div>
    <input class="flatpickr form-control <?php cms_isset(form_error("vade_tarih"), "is-invalid", ""); ?>"
           type="text" id="flatpickr"
           name="vade_tarih"
           value="<?php echo isset($form_error) ? set_value("vade_tarih") : ""; ?>"
    >
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("vade_tarih"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Açıklama</div>
    <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
              name="aciklama"
              placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : ""; ?></textarea>

    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
    <?php } ?>
</div>

<!-- Dosya Yükle -->
<div class="mb-3">
    <label class="col-form-label" for="file-input">Dosya Yükle:</label>
    <input class="form-control" name="file" id="file-input" type="file">
</div>