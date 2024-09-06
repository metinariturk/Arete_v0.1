
<div class="modal fade" id="modalAdvance" tabindex="-1"
     role="dialog"
     aria-labelledby="modalAdvance" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Yeni <?php echo $this->Module_Title; ?></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="advance_form"
                      action="<?php echo base_url("advance/save/$item->id"); ?>"
                      method="post"
                      enctype="multipart">
                    <div class="mb-2">
                        <div class="col-form-label">Dosya No</div>
                        <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">AV</span>
                            <?php if (!empty(get_last_fn("advance"))) { ?>
                                <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                       type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                                       data-bs-original-title="" title="" name="dosya_no" readonly
                                       value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("advance"); ?>">
                                <?php
                            } else { ?>
                                <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                       type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                                       required="" data-bs-original-title="" title="" name="dosya_no" readonly
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
                               value="<?php echo isset($form_error) ? set_value("avans_tarih") : ""; ?>"
                               data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("avans_tarih"); ?></div>
                        <?php } ?>
                    </div>

                    <div class="mb-2">
                        <div class="col-form-label">Avans Tutar
                            <?php if (isset($form_error)) { ?>
                                <?php
                                // Tahsilat miktarı alanı boş değilse ve sözleşme bedelinden fazla girildiyse kontrol yap
                                if (!empty(set_value("avans_miktar")) && form_error("avans_miktar")) { ?>
                                    <div style="color: red">*** Sözleşme bedelinden fazla avans ödemesi yapılamaz. Özel bir gerekçe ile fazla avans verilmesi gerekiyorsa aşağıdaki onay kutusunu işaretleyiniz.
                                        <br><input  name="onay" type="checkbox" id="cb-10"> Sözleşme bedelinden fazla avans ödemesi yapmak istiyorum!</div>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <input type="integer" class="form-control <?php cms_isset(form_error("avans_miktar"), "is-invalid", ""); ?>"
                               name="avans_miktar"
                               placeholder="Avans Tutar"
                               value="<?php echo isset($form_error) ? set_value("avans_miktar") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("avans_miktar"); ?></div>
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
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">
                    Kapat
                </button>
                <button class="btn btn-primary" form="advance_form"
                        type="submit">
                    Oluştur
                </button>
            </div>
        </div>
    </div>
</div>