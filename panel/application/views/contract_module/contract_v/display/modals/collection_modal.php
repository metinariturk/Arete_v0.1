<div class="modal fade" id="modalCollection" tabindex="-1"
     role="dialog"
     aria-labelledby="modalCollection" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Yeni Tahsilat</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="collection_form"
                      action="<?php echo base_url("collection/save/$item->id"); ?>"
                      method="post"
                      enctype="multipart">
                    <div class="mb-2">
                        <div class="col-form-label">Dosya No</div>
                        <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">TA</span>
                            <?php if (!empty(get_last_fn("collection"))) { ?>
                                <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                       type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                                       readonly
                                       data-bs-original-title="" title="" name="dosya_no"
                                       value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("collection"); ?>">
                                <?php
                            } else { ?>
                                <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                                       type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                                       readonly
                                       required="" data-bs-original-title="" title="" name="dosya_no"
                                       value="<?php echo isset($form_error) ? set_value("dosya_no") : fill_empty_digits() . "1" ?>">
                            <?php } ?>
                            <?php if (isset($form_error)) { ?>
                                <div class="invalid-feedback"><?php echo form_error("dosya_no"); ?></div>
                                <div class="invalid-feedback">* Önerilen Proje Kodu
                                    : <?php echo increase_code_suffix("collection"); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="col-form-label">Tahsilat Ödeme Tarihi</div>
                        <input class="datepicker-here form-control digits <?php cms_isset(form_error("tahsilat_tarih"), "is-invalid", ""); ?>"
                               type="text"
                               name="tahsilat_tarih"
                               value="<?php echo isset($form_error) ? set_value("tahsilat_tarih") : ""; ?>"
                               data-options="{ format: 'DD-MM-YYYY' }"
                               data-language="tr">
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
                            <?php $odeme_turleri = get_as_array($settings->odeme_turu);
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
                               name="tahsilat_miktar"
                               placeholder="Tahsilat Tutar"
                               value="<?php echo isset($form_error) ? set_value("tahsilat_miktar") : ""; ?>">
                        <?php if (isset($form_error)) { ?>
                            <div class="invalid-feedback"><?php echo form_error("tahsilat_miktar"); ?></div>
                        <?php } ?>
                    </div>
                    <div class="mb-2">
                        <div class="col-form-label">Vade Tarihi</div>
                        <input class="datepicker-here form-control digits <?php cms_isset(form_error("vade_tarih"), "is-invalid", ""); ?>"
                               type="text"
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
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">
                    Kapat
                </button>
                <button class="btn btn-primary" form="collection_form"
                        type="submit">
                    Oluştur
                </button>
            </div>
        </div>
    </div>
</div>