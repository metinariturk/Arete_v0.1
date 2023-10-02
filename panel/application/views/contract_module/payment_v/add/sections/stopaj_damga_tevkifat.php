<?php if ($contract->stopaj_oran > 0) { ?>
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">a</div></div>
        <div class="col-sm-3">
            <div class="col-form-label">Gelir Kurumlar Vergisi<br>
                (E <?php cms_if_echo($contract->avans_stopaj, "1", "-g", ""); ?>) x
                %<?php echo $contract->stopaj_oran; ?>
            </div>
        </div>
        <div class="col-sm-2">
            <select id="KES_a_1" onblur="calcular()" onclick="calcular()"
                    class="form-control <?php cms_isset(form_error("stopaj_oran"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="stopaj_oran">
                <option value="<?php echo isset($form_error) ? set_value("stopaj_oran") : "$contract->stopaj_oran"; ?>"
                        onblur="calcular()" onfocus="calcular()">
                    %<?php echo isset($form_error) ? set_value("stopaj_oran") : "$contract->stopaj_oran"; ?></option>
                <?php $oranlar = str_getcsv($settings->stopaj_oran);
                foreach ($oranlar as $oran) { ?>
                    <option value="<?php echo $oran; ?>">% <?php echo $oran; ?></option>";
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-6">
            <input id="KES_a" type="number" step=".01" name="stopaj_tutar" class="form-control" onblur="calcular()"
                   readonly
                   onfocus="calcular()" onblur="calcular()"
                   value="<?php echo isset($form_error) ? set_value("stopaj_tutar") : ""; ?>">
        </div>
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("stopaj_tutar"); ?></div>
    <?php } ?>
<?php } else { ?>
    <!---->
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">a</div></div>
        <div class="col-sm-3">
            <div class="col-form-label">Gelir Kurumlar Vergisi<br>
                (E <?php cms_if_echo($contract->avans_stopaj, "1", "-g", ""); ?>) x
                %<?php echo $contract->stopaj_oran; ?>
            </div>
        </div>
        <div class="col-sm-2">
            <select id="KES_a_1" onblur="calcular()" onclick="calcular()"
                    class="form-control <?php cms_isset(form_error("stopaj_oran"), "is-invalid", ""); ?>"
                    data-plugin="select2" name="stopaj_oran">
                <option value="<?php echo isset($form_error) ? set_value("stopaj_oran") : "$contract->stopaj_oran"; ?>"
                        onblur="calcular()" onfocus="calcular()">
                    %<?php echo isset($form_error) ? set_value("stopaj_oran") : "$contract->stopaj_oran"; ?></option>
                <?php $oranlar = str_getcsv($settings->stopaj_oran);
                foreach ($oranlar as $oran) { ?>
                    <option value="<?php echo $oran; ?>">% <?php echo $oran; ?></option>";
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="KES_a" disabled name="stopaj_tutar" class="form-control" readonly
                   onblur="calcular()"
                   onfocus="calcular()"
                   value="<?php echo isset($form_error) ? set_value("stopaj_tutar") : ""; ?>">
        </div>
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("stopaj_tutar"); ?></div>
    <?php } ?>
<?php } ?>

<?php if ($contract->damga_oran >= 0) { ?>
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">b</div></div>
        <div class="col-sm-3">
            <div class="col-form-label">Damga Vergisi <br>(E x ‰<?php echo $contract->damga_oran; ?>)
            </div>
        </div>
        <div class="col-sm-2">
            <?php if ($contract->damga_kesinti == 1) { ?>
                <select name="damga_oran" id="KES_b_1" class="form-control" onclick="calcular()"
                        onfocus="calcular()">
                    <option value="<?php echo isset($form_error) ? set_value("damga_oran") : "$contract->damga_oran"; ?>"
                            onblur="calcular()" onfocus="calcular()">
                        ‰ <?php echo isset($form_error) ? set_value("damga_oran") : "$contract->damga_oran"; ?></option>
                    <?php $oranlar = str_getcsv($settings->damga_oran);
                    foreach ($oranlar as $oran) {
                        echo "<option value='$oran'>‰ $oran</option>";
                    }
                    ?>
                </select>
                <?php if (isset($form_error)) { ?>
                    <small class="pull-left input-form-error"> <?php echo form_error("damga_oran"); ?></small>
                <?php } ?>
            <?php } else { ?>
                <input type="number" step=".01" hidden id="KES_b_1" onblur="calcular()" onfocus="calcular()" value="0">
            <?php } ?>
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="KES_b" name="damga_tutar" class="form-control" onblur="calcular()"
                   readonly
                   onfocus="calcular()"
                   value="<?php echo isset($form_error) ? set_value("damga_tutar") : ""; ?>">

        </div>
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("damga_tutar"); ?></div>
    <?php } ?>
<?php } else { ?>
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">b</div></div>
        <div class="col-sm-5">
            <div class="col-form-label">Damga Vergisi
            </div>
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="KES_b" disabled name="damga_tutar" class="form-control" readonly
                   onblur="calcular()" onfocus="calcular()"
                   value="<?php echo isset($form_error) ? set_value("damga_tutar") : "0"; ?>">
        </div>
    </div>
<?php } ?>
<?php if (tevkifat($contract->tevkifat_oran) > 0) { ?>
    <!--        -->
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">c</div></div>
        <div class="col-sm-3">
            <div class="col-form-label">KDV Tevkifatı<br>(F x <?php echo $contract->tevkifat_oran; ?>)
            </div>
        </div>
        <div class="col-sm-2">
            <select name="tevkifat_oran" id="KES_c_1" class="form-control" onclick="calcular()"
                    onfocus="calcular()">
                <option value="<?php echo isset($form_error) ? set_value("tevkifat_oran") : tevkifat($contract->tevkifat_oran); ?>"
                        onblur="calcular()"
                        onfocus="calcular()"><?php echo isset($form_error) ? set_value("tevkifat_oran") : "$contract->tevkifat_oran"; ?></option>
                <?php $oranlar = str_getcsv($settings->kdv_tevkifat_oran);
                foreach ($oranlar as $oran) { ?>
                    <option onblur="calcular()" onfocus="calcular()"
                            value="<?php echo tevkifat($oran); ?>"><?php echo $oran; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <small class="pull-left input-form-error"> <?php echo form_error("tevkifat_oran"); ?></small>
            <?php } ?>
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="KES_c" name="tevkifat_tutar" class="form-control" readonly
                   onblur="calcular()"
                   onfocus="calcular()"
                   value="<?php echo isset($form_error) ? set_value("tevkifat_tutar") : ""; ?>">
        </div>
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("tevkifat_tutar"); ?></div>
    <?php } ?>
    <!---->
<?php } else { ?>
    <div class="row">
        <div class="col-sm-1">c</div>
        <div class="col-sm-3">
            <div class="col-form-label">KDV Tevkifatı</div>
        </div>
        <div class="col-sm-2">
            <input name="tevkifat_oran" disabled hidden value="0" id="KES_c_1"
                   class="form-control" onblur="calcular()" onfocus="calcular()">
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="KES_c" name="tevkifat_tutar" class="form-control" readonly
                    onblur="calcular()"
                    onfocus="calcular()"
                    value="<?php echo isset($form_error) ? set_value("tevkifat_tutar") : ""; ?>">
        </div>
    </div>
<?php } ?>
