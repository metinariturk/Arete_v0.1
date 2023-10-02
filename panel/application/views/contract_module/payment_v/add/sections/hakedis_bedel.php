<div class="row">
    <div class="col-sm-1"><div class="col-form-label">C</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">Toplam Tutar
            <?php if ($contract->ihzarat == 1 and $contract->fiyat_fark ==1){
                echo "(A1 + A2 + B)";
            } elseif ($contract->ihzarat != 1 and $contract->fiyat_fark ==1){
                echo "(A + B)";
            } elseif ($contract->ihzarat != 1 and $contract->fiyat_fark !=1){
                echo "(A)";
            } elseif ($contract->ihzarat == 1 and $contract->fiyat_fark !=1){
                echo "(A1 + A2)";
            }?>
        </div>
    </div>
    <div class="col-sm-6">
        <input id="C" type="number" step=".01" class="form-control" name="ara_toplam" onblur="calcular()"
               onfocus="calcular()" required readonly
               value="<?php echo isset($form_error) ? set_value("ara_toplam") : ""; ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("ara_toplam"); ?></div>
<?php } ?>
<!---->
<div class="row">
    <div class="col-sm-1"><div class="col-form-label">D</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">Bir Önceki Hakedişlerin Toplam Tutarı</div>
    </div>
    <div class="col-sm-6">
        <input id="D" type="number" step=".01" name="onceki_iif" class="form-control" onblur="calcular()" readonly
               onfocus="calcular()" <?php cms_if_echo(count_payments($contract->id), "0", "disabled", ""); ?>
               value="<?php echo isset($form_error) ? set_value("onceki_iif") : sum_payments("bu_iif", $contract->id); ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("onceki_iif"); ?></div>
<?php } ?>

<div class="row">
    <div class="col-sm-1"><div class="col-form-label"><b>E</b></div></div>
    <div class="col-sm-5">
        <div class="col-form-label"><b>Bu Hakedişin Tutarı (C-D)</b></div>
    </div>
    <div class="col-sm-6">
        <input id="E" type="number" step=".01" name="bu_iif" class="form-control" onblur="calcular()" readonly
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("bu_iif") : ""; ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("bu_iif"); ?></div>
<?php } ?>
