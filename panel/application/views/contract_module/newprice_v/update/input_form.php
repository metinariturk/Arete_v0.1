<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Karar No</div>
            <input type="text" class="form-control <?php cms_isset(form_error("karar_no"), "is-invalid", ""); ?>"
                   onblur="calcular()"
                   onfocus="calcular()" name="karar_no" placeholder="2023/3 vs."
                   value="<?php echo isset($form_error) ? set_value("karar_no") : "$item->karar_no"; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("karar_no"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">YBF İmza Tarihi</div>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("ybf_tarih"), "is-invalid", ""); ?>"
                   type="text"
                   name="ybf_tarih"
                   value="<?php echo isset($form_error) ? set_value("ybf_tarih") : dateFormat_dmy($item->ybf_tarih); ?>"
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("ybf_tarih"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">YBF Tutar
                <?php if (isset($form_error)) { ?>
                    <?php if (!empty(form_error("ybf_oran"))) { ?>
                        <div class="form-check checkbox checkbox-secondary mb-0">
                            <input name="onay" class="form-check-input" id="checkbox-dark" onclick="calcular()"
                                   type="checkbox"
                                   data-bs-original-title="" title="">
                            <label class="form-check-label text-danger" for="checkbox-dark">Sözleşme bedeli %20'sinden
                                fazla tutarda YBF yapmak istiyorum</label>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <input type="text" id="calA" onblur="calcular()" onfocus="calcular()"
                   onChange="myFunction(calA)"
                   class="form-control <?php cms_isset(form_error("ybf_tutar"), "is-invalid", ""); ?>"
                   name="ybf_tutar"
                   placeholder="Yeni Birim Fiyat Tutar"
                   value="<?php echo isset($form_error) ? set_value("ybf_tutar") : "$item->ybf_tutar"; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("ybf_tutar"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="row">
                <div class="col-sm-5 col-md-4">
                    <div class="col-form-label">YBF Oran</div>
                    <div>
                        <input hidden type="text" id="calD"
                               value="<?php echo isset($form_error) ? set_value("ybf_oran") : ""; ?>" name="ybf_oran">
                        <div class="col-sm-4">
                            %<span id="calC" onblur="calcular()"
                                   onfocus="calcular()"><?php echo isset($form_error) ? set_value("ybf_oran") : "$item->ybf_oran"; ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-4">
                    <div class="col-form-label">Sözleşme Tutarı</div>
                    <input hidden id="calB"
                           value="<?php echo get_from_id("contract", "sozlesme_bedel", $contract_id); ?>">
                    <span><?php echo money_format(get_from_id("contract", "sozlesme_bedel", $contract_id)) . " " . get_currency($contract_id); ?></span>
                </div>
            </div>

        </div>
        <div class="mb-2">
            <div class="col-form-label">YBF Gerekçe</div>
            <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
                      name="aciklama"
                      placeholder="Gerekçe Özeti"><?php echo isset($form_error) ? set_value("aciklama") : "$item->aciklama"; ?></textarea>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>

