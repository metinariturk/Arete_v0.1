<?php if ($contract->kdv_oran > 0) { ?>
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">F</div></div>
        <div class="col-sm-3">
            <div class="col-form-label">KDV (E x<?php echo $contract->kdv_oran; ?>)</div>
        </div>
        <div class="col-sm-2">
            <select id="F_a" onblur="calcular()" onclick="calcular()"
                    class="form-control <?php cms_isset(form_error("kdv_oran"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="kdv_oran">
                <option value="<?php echo isset($form_error) ? set_value("kdv_oran") : "$contract->kdv_oran"; ?>">
                    %<?php echo isset($form_error) ? set_value("kdv_oran") : "$contract->kdv_oran"; ?></option>
                <?php $oranlar = str_getcsv($settings->KDV_oran);
                foreach ($oranlar as $oran) { ?>
                    <option value="<?php echo $oran; ?>">% <?php echo $oran; ?></option>";
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-6">
            <input id="F" type="number" step=".01" name="kdv_tutar" class="form-control" onblur="calcular()"
                   readonly
                   onfocus="calcular()" onblur="calcular()"
                   value="<?php echo isset($form_error) ? set_value("kdv_tutar") : ""; ?>">
        </div>
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("kdv_tutar"); ?></div>
    <?php } ?>
<?php } else { ?>
    <!---->
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">F</div></div>
        <div class="col-sm-3">
            <div class="col-form-label">KDV</div>
        </div>
        <div class="col-sm-2">
            <input name="kdv_oran" id="F_a" value="0" class="form-control" disabled
                   onblur="calcular()" onfocus="calcular()">
        </div>
        <div class="col-sm-6">
            <input id="F" type="number" step=".01" name="kdv_tutar" class="form-control" onblur="calcular()"
                   readonly
                   onfocus="calcular()" onblur="calcular()"
                   value="<?php echo isset($form_error) ? set_value("kdv_tutar") : ""; ?>">
        </div>
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("kdv_oran"); ?></div>
    <?php } ?>
<?php } ?>

<div class="row">
    <div class="col-sm-1"><div class="col-form-label">G</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">Taahhuk Tutarı (E + F)</div>
    </div>
    <div class="col-sm-6">
        <input type="number" step=".01" id="G" name="taahhuk" class="form-control"
               value="<?php echo isset($form_error) ? set_value("taahhuk") : ""; ?>" onblur="calcular()"
               readonly
               onfocus="calcular()">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("taahhuk"); ?></div>
<?php } ?>

<hr>