<?php if ($contract->fiyat_fark == 1) { ?>
    <?php if ($contract->fiyat_fark_teminat == 1) { ?>
        <div class="row">
            <div class="col-sm-1"><div class="col-form-label">j</div></div>

            <div class="col-sm-3">
                <div class="col-form-label">Bu Hakedişte Ödenen Fiyat Farkının Teminatı</div>
            </div>
            <div class="col-sm-2">
                <input type="number" step=".01" id="KES_j_1" name="fiyat_fark_teminat_oran" class="form-control"
                       onblur="calcular()"
                       onfocus="calcular()"
                       value="<?php echo isset($form_error) ? set_value("fiyat_fark_teminat_oran") : $contract->teminat_oran; ?>">
            </div>
            <div class="col-sm-6">
                <input type="number" step=".01" id="KES_j" name="fiyat_fark_teminat" class="form-control" readonly
                       onblur="calcular()"
                       onfocus="calcular()"
                       value="<?php echo isset($form_error) ? set_value("fiyat_fark_teminat") : ""; ?>">
            </div>
        </div>
        <?php if (isset($form_error)) { ?>
            <div class="invalid-feedback"><?php echo form_error("fiyat_fark_teminat"); ?></div>
        <?php } ?>
    <?php } else { ?>
        <input type="number" step=".01" id="KES_j" onblur="calcular()" onfocus="calcular()" value="0" hidden>
        <input type="number" step=".01" id="KES_j_1" onblur="calcular()" onfocus="calcular()" value="0" hidden>
    <?php } ?>
<?php } else { ?>
    <input type="number" step=".01" id="KES_j_1" onblur="calcular()" onfocus="calcular()" value="0" hidden>
    <input type="number" step=".01" id="KES_j" onblur="calcular()" onfocus="calcular()" value="0" hidden>
<?php } ?>

