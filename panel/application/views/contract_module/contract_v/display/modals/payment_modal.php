
<div class="modal fade" id="modalPayment" tabindex="-1"
     role="dialog"
     aria-labelledby="modalPayment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Yeni <?php echo $this->Module_Title; ?></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="payment_form"
                      action="<?php echo base_url("payment/create/$item->id"); ?>"
                      method="post"
                      enctype="multipart">
                    <div class="mb-3">
                        <div style="color: tomato"><?php print_r($form_errors); ?></div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="col-form-label">Hakediş No<br>
                                    <label for="customer-checkbox2">&nbsp;</label>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <input class="form-control" type="number" name="hakedis_no" readonly
                                       value="<?php echo last_payment($item->id)+1; ?>" onblur="calcular()" onfocus="calcular()">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("hakedis_no"); ?></div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="col-form-label">Son İmalat
                                    Tarihi<br>
                                    <label for="customer-checkbox2">&nbsp;</label>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <input class="datepicker-here form-control digits <?php cms_isset(form_error("imalat_tarihi"), "is-invalid", ""); ?>"
                                       type="text" style="width: 100%"
                                       name="imalat_tarihi"
                                       value="<?php echo isset($form_error) ? set_value("imalat_tarihi") : ""; ?>"
                                       data-options="{ format: 'DD-MM-YYYY' }"
                                       data-language="tr">
                                <?php if (isset($form_error)) { ?>
                                    <div class="invalid-feedback"><?php echo form_error("imalat_tarihi"); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button"
                        data-bs-dismiss="modal">
                    Kapat
                </button>
                <button class="btn btn-primary" form="payment_form"
                        type="submit">
                    Oluştur
                </button>
            </div>
        </div>
    </div>
</div>