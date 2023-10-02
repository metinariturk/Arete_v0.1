<div class="row">
    <div class="col-sm-4">
        <div class="mb-2">
            <div class="col-form-label">Dosya No</div>
            <label for="custome-checkbox2">&nbsp;</label>
            <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">HAK</span>
                <?php if (!empty(get_last_fn("payment"))) { ?>
                    <input class="form-control <?php cms_isset(form_error("dosya_no"), "is-invalid", ""); ?>"
                           type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                           data-bs-original-title="" title="" name="dosya_no"
                           value="<?php echo isset($form_error) ? set_value("dosya_no") : increase_code_suffix("payment"); ?>">
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
                        : <?php echo increase_code_suffix("payment"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="col-form-label">Hakediş No <br>
            <input type="checkbox" name="final"/>
            <label for="custome-checkbox2">Kesin Hakediş</label>
        </div>
        <input type="number" step=".01" name="hakedis_no" class="form-control" readonly
               value="<?php cms_if_echo(count_payments($contract->id), "0", "1", last_payment($contract->id) + 1); ?>">
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error("hakedis_no"); ?></div>
        <?php } ?>
    </div>
    <div class="col-sm-4">
        <div class="col-form-label">Son İmalat Tarihi<br>
            <label for="customer-checkbox2">&nbsp;</label>
        </div>
        <input class="datepicker-here form-control digits <?php cms_isset(form_error("imalat_tarihi"), "is-invalid", ""); ?>"
               type="text"
               name="imalat_tarihi"
               value="<?php echo isset($form_error) ? set_value("imalat_tarihi") : ""; ?>"
               data-options="{ format: 'DD-MM-YYYY' }"
               data-language="tr">
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error("imalat_tarihi"); ?></div>
        <?php } ?>
    </div>
</div>



