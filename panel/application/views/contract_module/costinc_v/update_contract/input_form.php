<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Dosya No</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">KA</span>
                <?php if (!empty(get_last_fn("costinc"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("costinc"); ?>">
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
                        : <?php echo increase_code_suffix("costinc"); ?>
                    </div>
                <?php } ?>
            </div>
        </div><!--Dosya No-->
        <div class="mb-2">
            <div class="row">
                <div class="col-6">
                    <div class="col-form-label">Keşif Artış Karar Tarihi</div>
                    <input class="datepicker-here form-control digits <?php cms_isset(form_error("artis_tarih"), "is-invalid", ""); ?>"
                           type="text"
                           name="artis_tarih"
                           value="<?php echo isset($form_error) ? set_value("artis_tarih") : dateFormat_dmy($item->artis_tarih); ?>"
                           data-options="{ format: 'DD-MM-YYYY' }"
                           data-language="tr">
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("artis_tarih"); ?></div>
                    <?php } ?></div>
                <div class="col-6">
                    <div class="col-form-label">Karar No</div>
                    <input type="text"
                           class="form-control <?php cms_isset(form_error("karar_no"), "is-invalid", ""); ?>"
                           onblur="calcular()"
                           onfocus="calcular()" name="karar_no" placeholder="2023/3 vs."
                           value="<?php echo isset($form_error) ? set_value("karar_no") : "$item->karar_no"; ?>">
                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("karar_no"); ?></div>
                    <?php } ?></div>
            </div>
        </div><!--Tarih ve No-->
        <div class="mb-2">
            <div class="col-form-label">Keşif Artış Miktar</div>
            <input type="text" id="calA" onblur="calcular()" onfocus="calcular()"
                   onChange="myFunction(calA)"
                   class="form-control  <?php cms_isset(form_error("artis_miktar"), "is-invalid", ""); ?>"
                   name="artis_miktar"
                   placeholder="Keşif Artış Miktar"
                   value="<?php echo isset($form_error) ? set_value("artis_miktar") : "$item->artis_miktar"; ?>">

            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("artis_miktar"); ?></div>
            <?php } ?>
        </div><!--Miktar-->
        <div class="mb-2">
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    <div class="col-form-label">Sözleşme Tutar</div>
                    <div>
                        <input hidden id="calB"
                               value="<?php echo get_from_id("contract", "sozlesme_bedel", $contract_id); ?>">
                        <span><?php echo money_format(get_from_id("contract", "sozlesme_bedel", $contract_id)) . " " . get_currency($contract_id); ?></span>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3">
                    <div class="col-form-label">Önceki Keşif Artışları</div>
                    <div>
                    </div>
                </div>
            </div>
        </div><!--Kapalı Bilgi-->
        <div class="mb-2">
            <?php if (($item->artis_oran >= 20) or ((set_value("artis_oran") >= 20))) { ?>
                <?php if ($onay_input = "checked") { ?>
                    <div class="form-check checkbox checkbox-secondary mb-0">
                        <input name="onay" class="form-check-input" id="checkbox-dark"
                               type="checkbox" <?php echo $onay_input; ?>
                               onclick="calcular()" data-bs-original-title="" title="">
                        <label class="form-check-label text-danger" for="checkbox-dark">Sözleşme bedeli
                            %20'sinden fazla tutarda Keşif Artışı yapmak istiyorum</label>
                    </div>
                <?php } else { ?>
                    <?php if ((form_error("artis_oran")) != "on") { ?>
                        <div class="form-check checkbox checkbox-secondary mb-0">
                            <input name="onay" class="form-check-input" id="checkbox-dark"
                                   type="checkbox"
                                   onclick="calcular()" data-bs-original-title="" title="">
                            <label class="form-check-label text-danger" for="checkbox-dark">Sözleşme bedeli
                                %20'sinden fazla tutarda Keşif Artışı yapmak istiyorum</label>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <div class="col-form-label">Keşif Artışı/Sözleşme Oranı</div>

            <input hidden type="text" id="calD"
                   value="<?php echo isset($form_error) ? set_value("artis_oran") : "$item->artis_oran"; ?>"
                   name="artis_oran">
            <div class="col-sm-4">
                %
                <span id="calC" onblur="calcular()" <?php if (!empty(form_error("artis_oran"))) { ?>
                    class="text-danger";
                <?php } ?>
                              onfocus="calcular()"> <?php echo isset($form_error) ? set_value("artis_oran") : "$item->artis_oran"; ?></span>
            </div>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("artis_oran"); ?></div>
            <?php } ?>
        </div><!--Oran-->
        <div class="mb-2">
            <div class="col-form-label">Açıklama</div>
            <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
                      name="aciklama"
                      placeholder="Gerekçe Özeti"><?php echo isset($form_error) ? set_value("aciklama") : $item->aciklama; ?></textarea>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div><!--Açıklama-->
    </div>
</div>





