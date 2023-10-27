<div class="row">
    <div class="col-sm-1"><div class="col-form-label">A<?php cms_if_echo($contract->ihzarat, "1", "1", ""); ?></div></div>
    <div class="col-sm-5">
        <div class="col-form-label">Toplam İmalat Bedeli</div>
        <small>Önceki
            Toplam <?php echo money_format((sum_payments("bu_imalat", $contract->id))) . " " . get_currency($contract->id); ?>
        </small>
    </div>
    <div class="col-sm-6">
        <input type="number" step=".01" id="X" hidden
               value="<?php echo sum_payments("bu_imalat", $contract->id); ?>" onblur="calcular()"
               onfocus="calcular()">
        <input type="number" step=".01" id="A1" onblur="calcular()" onfocus="calcular()"
               onChange="calcular()" required readonly
               class="form-control <?php cms_isset(form_error("toplam_imalat"), "is-invalid", ""); ?> "
               name="toplam_imalat"
               placeholder="Toplam İmalat"
               value="<?php echo isset($form_error) ? set_value("toplam_imalat") : ""; ?>">
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error("toplam_imalat"); ?></div>
            Negatif Değerde Hakediş Yaptığımın Farkındayım<input type="checkbox" name="is_negative">
        <?php } ?>
    </div>
</div>
<!-- -->
<?php if ($contract->ihzarat == 1) { ?>
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">A2</div></div>
        <div class="col-sm-5">
            <div class="col-form-label">Toplam İhzarat Bedeli</div>
            <small>
                Önceki
                Toplam <?php echo money_format((sum_payments("bu_ihzarat", $contract->id))) . " " . get_currency($contract->id); ?>
            </small>
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="Y" hidden
                   value="<?php echo sum_payments("bu_ihzarat", $contract->id); ?>" onblur="calcular()"
                   onfocus="calcular()">

            <input type="number" step=".01" id="A2"
                   class="form-control <?php cms_isset(form_error("toplam_ihzarat"), "is-invalid", ""); ?> "
                   name="toplam_ihzarat" required disabled
                   value="<?php echo isset($form_error) ? set_value("toplam_ihzarat") : ""; ?>"
                   onblur="calcular()"
                   onfocus="calcular()" placeholder="Toplam İhzarat">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("toplam_ihzarat"); ?></div>
                <input type="checkbox" name="is_negative">
            <?php } ?>
        </div>
    </div>

<?php } else { ?>
    <input type="number" step=".01" id="Y" value="0" onblur="calcular()" onfocus="calcular()" hidden>
    <input type="number" step=".01" id="A2" value="0" onblur="calcular()" onfocus="calcular()" hidden>
<?php } ?>
<!---->
<div class="row">
    <div class="col-sm-1"><div class="col-form-label"><?php cms_if_echo($contract->ihzarat, "1", "A3", ""); ?></div></div>
    <div class="col-sm-5">
        <div class="col-form-label">İmalat Bedeli (Bu Hak.)</div>
    </div>
    <div class="col-sm-6">
        <?php if (isset($boq)) { ?>
        <input type="number" step=".01" id="A3" name="bu_imalat"
               value="<?php echo isset($form_error) ? set_value("bu_imalat") : "$boq->total"; ?>"
               class="form-control <?php cms_isset(form_error("bu_imalat"), "is-invalid", ""); ?>"
               onblur="calcular()" required
               onfocus="calcular()">
        <?php } else { ?>
            <input type="number" step=".01" id="A3" name="bu_imalat"
                   value="<?php echo isset($form_error) ? set_value("bu_imalat") : ""; ?>"
                   class="form-control <?php cms_isset(form_error("bu_imalat"), "is-invalid", ""); ?>"
                   onblur="calcular()" required
                   onfocus="calcular()">
        <?php } ?>
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error("bu_imalat"); ?></div>
        <?php } ?>
    </div>
</div>

<!-- -->
<?php if ($contract->ihzarat == 1) { ?>
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">A4</div></div>
        <div class="col-sm-5">
            <div class="col-form-label">İhzarat Bedeli (Bu Hak.)</div>
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="A4"
                   class="form-control <?php cms_isset(form_error("bu_ihzarat"), "is-invalid", ""); ?>"
                   name="bu_ihzarat"
                   value="<?php echo isset($form_error) ? set_value("bu_ihzarat") : ""; ?>"
                   onblur="calcular()"
                   onfocus="calcular()">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("bu_ihzarat"); ?></div>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <input type="number" step=".01" id="A4" value="0" onblur="calcular()" onfocus="calcular()" hidden>
<?php } ?>

