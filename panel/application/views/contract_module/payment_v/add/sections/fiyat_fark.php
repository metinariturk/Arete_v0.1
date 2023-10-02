<?php if ($contract->fiyat_fark != 0) { ?>
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">B</div></div>
        <div class="col-sm-5">
            <div class="col-form-label">Toplam Fiyat Farkı Tutarı</div>
            <small>Önceki Toplam <?php echo money_format(sum_payments("bu_fiyat_fark", "$contract->id"))." ".$contract->para_birimi; ?></small>
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="Z" hidden
                   value="<?php echo sum_payments("bu_fiyat_fark", $contract->id); ?>" onblur="calcular()"
                   onfocus="calcular()">
            <input type="number" step=".01" id="B1"
                   class="form-control <?php cms_isset(form_error("toplam_fiyat_fark"), "is-invalid", ""); ?>"
                   name="toplam_fiyat_fark" readonly
                   onblur="calcular()"
                   onfocus="calcular()"
                   value="<?php echo isset($form_error) ? set_value("toplam_fiyat_fark") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("toplam_fiyat_fark"); ?></div>
            <?php } ?>
        </div>
    </div>

    <!---->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-5">
            <div class="col-form-label">Fiyat Farkı Tutarı (Bu Hak.)</div>
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01"  id="B2"
                   class="form-control <?php cms_isset(form_error("bu_fiyat_fark"), "is-invalid", ""); ?>"
                   name="bu_fiyat_fark"
                   onblur="calcular()"
                   onfocus="calcular()"
                   value="<?php echo isset($form_error) ? set_value("bu_fiyat_fark") : ""; ?>">
        </div>
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("bu_fiyat_fark"); ?></div>
    <?php } ?>
<?php } else { ?>
    <input type="number" step=".01" id="Z" onblur="calcular()" onfocus="calcular()" value="0" hidden>
    <input type="number" step=".01" id="B1" onblur="calcular()" onfocus="calcular()" value="0" hidden>
    <input type="number" step=".01" id="B2" onblur="calcular()" onfocus="calcular()" value="0" hidden>
<?php } ?>
<!---->


