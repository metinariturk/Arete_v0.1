<div class="card">
    <div class="card-body">
        <div class="mb-2">
            <div class="col-form-label">Dosya No</div>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">AV</span>
                <?php if (!empty(get_last_fn("advance"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("advance"); ?>">
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
                        : <?php echo increase_code_suffix("advance"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Avans Ödeme Tarihi</div>
            <input class="datepicker-here form-control digits <?php cms_isset(form_error("avans_tarih"), "is-invalid", ""); ?>"
                   type="text"
                   name="avans_tarih"
                   value="<?php echo isset($form_error) ? set_value("avans_tarih") : dateFormat('d-m-Y',$item->avans_tarih); ?>"
                   data-options="{ format: 'DD-MM-YYYY' }"
                   data-language="tr">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("avans_tarih"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="col-form-label">Avans Tutar
                <?php if (isset($form_error)) { ?>
                    <?php if (!empty(form_error("avans_miktar"))) { ?>
                        <div style="color: red">*** Sözleşme bedelinden fazla avans ödemesi yapılamaz. Özel bir gerekçe ile fazla avans verilmesi gerekiyorsa aşağıdaki onay kutusunu işaretleyiniz.
                            <br><input  name="onay" type="checkbox" id="cb-10"> Sözleşme bedelinden fazla avans ödemesi yapmak istiyorum!</div>
                    <?php } ?>
                <?php } ?>
            </div>

            <input type="integer" id="calA" onblur="calcular()" onfocus="calcular()"
                   onChange="myFunction(calA)" class="form-control" name="avans_miktar"
                   placeholder="Avans Tutar"
                   value="<?php echo isset($form_error) ? set_value("avans_miktar") : "$item->avans_miktar"; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("avans_miktar"); ?></div>
            <?php } ?>
        </div>

        <div class="mb-2">
            <div class="row">
                <div class="col-sm-4 col-md-3">
                    <div class="col-form-label">Mahsup Oran (%)</div>
                    <div>
                        % <?php echo $payment_settings->avans_oran; ?>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="col-form-label">Avans Oran</div>
                    <div>
                        <input hidden type="text" id="calD" value="" name="avans_oran">
                        %<span id="calC" onblur="calcular()" onfocus="calcular()"></span>
                    </div>
                </div>
                <div class="col-sm-4 col-md-3">
                    <div class="col-form-label">Sözleşme Tutarı</div>
                    <input hidden id="calB" value="<?php echo $contract->sozlesme_bedel; ?>">
                    <span><?php echo money_format($contract->sozlesme_bedel)." ".$contract->para_birimi;  ?></span>
                </div>
            </div>

        </div>
        <div class="mb-2">
            <div class="col-form-label">Açıklama</div>
            <textarea class="form-control <?php cms_isset(form_error("aciklama"), "is-invalid", ""); ?>"
                      name="aciklama"
                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : "$item->aciklama"; ?></textarea>

            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>

