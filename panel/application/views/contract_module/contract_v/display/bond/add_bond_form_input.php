<div class="mb-2">
    <div class="col-form-label">Teminat Tarihi</div>
    <input class="datepicker-here form-control digits <?php cms_isset(form_error("teslim_tarih"), "is-invalid", ""); ?>"
           type="text" id="flatpickr"
           name="teslim_tarih"
           value="<?php echo isset($form_error) ? set_value("teslim_tarih") : ""; ?>"
           data-options="{ format: 'DD-MM-YYYY' }"
           data-language="tr">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("teslim_tarih"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Teminat Türü</div>
    <select id="select2-demo-1" style="width: 100%;"
            class="form-control <?php cms_isset(form_error("teminat_turu"), "is-invalid", ""); ?>"
            data-plugin="select2" name="teminat_turu">
        <option selected="selected"
                value="<?php echo isset($form_error) ? set_value("teminat_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("teminat_turu") : "Seçiniz"; ?>
        </option>
        <?php $teminat_turleri = get_as_array($settings->teminat_turu);
        foreach ($teminat_turleri as $teminat_turu) {
            echo "<option value='$teminat_turu'>$teminat_turu</option>";
        } ?>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("teminat_turu"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Gerekçe</div>
    <select id="select2-demo-1" style="width: 100%;"
            class="form-control <?php cms_isset(form_error("teminat_gerekce"), "is-invalid", ""); ?>"
            data-plugin="select2" name="teminat_gerekce">
        <option selected="selected"
                value="<?php echo isset($form_error) ? set_value("teminat_gerekce") : ""; ?>"><?php echo isset($form_error) ? set_value("teminat_gerekce") : "Seçiniz"; ?>
        </option>
        <option>Sözleşme Teminatı</option>
        <option>Fiyat Farkı Teminatı</option>
        <option>Avans Teminatı</option>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("teminat_gerekce"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Banka</div>
    <input class="form-control  <?php cms_isset(form_error("teminat_banka"), "is-invalid", ""); ?>" name="teminat_banka"
           list="datalistOptions" placeholder="Banka Adı Yazınız" value="<?php echo isset($form_error) ? set_value("teminat_banka") : ""; ?>">
    <datalist id="datalistOptions">
        <?php $bankalar = get_as_array($settings->bankalar);
        foreach ($bankalar as $banka) {
            echo "<option value='$banka'>$banka</option>";
        } ?>
    </datalist>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("teminat_banka"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Teminat Tutar</div>

    <input class="form-control <?php cms_isset(form_error("teminat_miktar"), "is-invalid", ""); ?>"
           name="teminat_miktar" type="number"
           placeholder="Teminat Tutar"
           value="<?php echo isset($form_error) ? set_value("teminat_miktar") : ""; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("teminat_miktar"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Geçerlilik Tarihi</div>
    <input class="datepicker-here form-control digits <?php cms_isset(form_error("gecerlilik_tarih"), "is-invalid", ""); ?>"
           type="text" id="flatpickr"
           name="gecerlilik_tarih"
           value="<?php echo isset($form_error) ? set_value("gecerlilik_tarih") : ""; ?>"
           data-options="{ format: 'DD-MM-YYYY' }"
           data-language="tr">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("gecerlilik_tarih"); ?></div>
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