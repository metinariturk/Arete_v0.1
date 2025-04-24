<div class="mb-2">
    <div class="col-form-label">Tahsilat Ödeme Tarihi</div>
    <input class="flatpickr form-control <?php cms_isset(form_error("tahsilat_tarih"), "is-invalid", ""); ?>"
           type="text" id="flatpickr"
           name="tahsilat_tarih"
           value="<?php echo isset($form_error) ? set_value("tahsilat_tarih") : ""; ?>"
    >
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("tahsilat_tarih"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Tahsilat Türü</div>
    <select id="select2-demo-1" style="width: 100%;"
            class="form-control <?php cms_isset(form_error("tahsilat_turu"), "is-invalid", ""); ?>"
            data-plugin="select2" name="tahsilat_turu">
        <option selected="selected"
                value="<?php echo isset($form_error) ? set_value("tahsilat_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("tahsilat_turu") : "Seçiniz"; ?>
        </option>
        <?php $odeme_turleri = get_as_array($this->settings->odeme_turu);
        foreach ($odeme_turleri as $odeme_turu) {
            echo "<option value='$odeme_turu'>$odeme_turu</option>";
        } ?>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("tahsilat_turu"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Tahsilat Tutar</div>
    <?php if (isset($form_error)) { ?>
        <?php
        // Tahsilat miktarı alanı boş değilse ve sözleşme bedelinden fazla girildiyse kontrol yap
        if (!empty(set_value("tahsilat_miktar")) && form_error("tahsilat_miktar")) { ?>
            <div style="color: red">
                *** Sözleşme bedelinden fazla tahsilat yapılamaz. Özel bir gerekçe ile fazla
                tahsilat yapılması gerekiyorsa aşağıdaki onay kutusunu işaretleyiniz.
                <br>
                <input name="onay" type="checkbox" id="cb-10"> Sözleşme bedelinden fazla tahsilat
                yapmak istiyorum!
            </div>
        <?php } ?>
    <?php } ?>
    <input class="form-control <?php cms_isset(form_error("tahsilat_miktar"), "is-invalid", ""); ?>"
           name="tahsilat_miktar" type="number"
           placeholder="Tahsilat Tutar"
           value="<?php echo isset($form_error) ? set_value("tahsilat_miktar") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("tahsilat_miktar"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Vade Tarihi</div>
    <input class="flatpickr form-control digits <?php cms_isset(form_error("vade_tarih"), "is-invalid", ""); ?>"
           type="text" id="flatpickr"
           name="vade_tarih"
           value="<?php echo isset($form_error) ? set_value("vade_tarih") : ""; ?>"
           data-options="{ format: 'DD-MM-YYYY' }"
           data-language="tr">
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
