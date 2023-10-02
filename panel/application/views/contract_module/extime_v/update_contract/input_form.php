<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Karar Tarih</div>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("karar_tarih"), "is-invalid", ""); ?>"
                   type="text"
                   name="karar_tarih"
                   value="<?php echo isset($form_error) ? set_value("karar_tarih") : dateFormat_dmy($item->karar_tarih); ?>"
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
                   value="<?php echo isset($form_error) ? set_value("uzatim_miktar") : "$item->uzatim_miktar"; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("uzatim_miktar"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Süre Uzatımı Başlangıç Tarihi</div>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("baslangic_tarih"), "is-invalid", ""); ?>"
                   type="text"
                   name="baslangic_tarih"
                   value="<?php echo isset($form_error) ? set_value("baslangic_tarih") : dateFormat_dmy($item->karar_tarih); ?>"
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("baslangic_tarih"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Süre Uzatımı Gerekçesi</div>
            <span>İşveren Kaynaklı</span>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Sözleşmeye Bitiş Tarihi</div>
            <?php echo dateFormat('d-m-Y', get_from_id("contract", "sozlesme_bitis", $contract_id)); ?>
        </div><!--Açıklama-->
        <div class="mb-2">
            <div class="col-form-label">Açıklama</div>
            <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", "$item->aciklama"); ?>"
                      name="aciklama"
                      placeholder="Gerekçe Özeti"><?php echo isset($form_error) ? set_value("aciklama") : "$item->aciklama"; ?></textarea>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div><!--Açıklama-->
    </div>
</div>



