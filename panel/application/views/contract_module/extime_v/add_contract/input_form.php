<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Dosya No</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">SU</span>
                <?php if (!empty(get_last_fn("extime"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("extime"); ?>">
                    <?php
                } else { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                           required="" data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
                <?php } ?>

                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
                    <div class="invalid-feedback">* Önerilen Proje Kodu
                        : <?php echo increase_code_suffix("extime"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Karar Tarih</div>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("karar_tarih"), "is-invalid", ""); ?>"
                   type="text"
                   name="karar_tarih"
                   value="<?php echo isset($form_error) ? set_value("karar_tarih") : ""; ?>"
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("karar_tarih"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Süre Uzatım Miktar (Gün)</div>
            <input class="form-control <?php cms_isset(form_error("uzatim_miktar"), "is-invalid", ""); ?>"
                   type="number"
                   name="uzatim_miktar"
                   value="<?php echo isset($form_error) ? set_value("uzatim_miktar") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("uzatim_miktar"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Süre Uzatımı Başlangıç Tarihi</div>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("baslangic_tarih"), "is-invalid", ""); ?>"
                   type="text"
                   name="baslangic_tarih"
                   value="<?php echo isset($form_error) ? set_value("baslangic_tarih") : ""; ?>"
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("baslangic_tarih"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Süre Uzatımı Gerekçesi</div>
            <select id="select2-demo-1" style="width: 100%;"
                    class="form-control <?php cms_isset(form_error("uzatim_turu"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="uzatim_turu">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? set_value("uzatim_turu") : ""; ?>"><?php echo isset($form_error) ? set_value("uzatim_turu") : "Seçiniz"; ?>
                </option>
                <?php $sure_uzatimlari = str_getcsv($settings->sure_uzatim);
                foreach ($sure_uzatimlari as $sure_uzatim) {
                    echo "<option value='$sure_uzatim'>$sure_uzatim</option>";
                } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("uzatim_turu"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Sözleşmeye Bitiş Tarihi</div>
            <?php echo dateFormat('d-m-Y', get_from_id("contract", "sozlesme_bitis", $contract_id)); ?>
        </div><!--Açıklama-->
        <div class="mb-2">
            <div class="col-form-label">Açıklama</div>
            <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
                      name="aciklama"
                      placeholder="Gerekçe Özeti"><?php echo isset($form_error) ? set_value("aciklama") : ""; ?></textarea>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div><!--Açıklama-->
    </div>
</div>



