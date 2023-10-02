<div class="row">
    <div class="col-sm-1"><div class="col-form-label">h</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">Diğer Kesinti (1)</div>
    </div>
    <div class="col-sm-6">
        <input type="number" step=".01" id="KES_h" name="diger_1" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("diger_1") : ""; ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("diger_1"); ?></div>
<?php } ?>
<!---->
<div class="row">
    <div class="col-sm-1"><div class="col-form-label">e</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">İş Makinesi Kesintisi</div>
    </div>
    <div class="col-sm-6">
        <input type="number" step=".01" id="KES_e" name="makine" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("makine") : ""; ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("makine"); ?></div>
<?php } ?>

<!---->
<div class="row">
    <div class="col-sm-1"><div class="col-form-label">i</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">Diğer Kesinti (2)</div>
    </div>
    <div class="col-sm-6">
        <input type="number" step=".01" id="KES_i" name="diger_2" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("diger_2") : ""; ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("diger_2"); ?></div>
<?php } ?>


