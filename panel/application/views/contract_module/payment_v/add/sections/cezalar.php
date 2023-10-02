<div class="row">
    <div class="col-sm-1"><div class="col-form-label">d</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">SGK Kesintisi</div>
    </div>
    <div class="col-sm-6">
        <input type="number" step=".01" id="KES_d" name="sgk" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("sgk") : ""; ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("sgk"); ?></div>
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
    <div class="col-sm-1"><div class="col-form-label">f</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">Gecikme Cezası</div>
    </div>
    <div class="col-sm-6">
        <input type="number" step=".01" id="KES_f" name="gecikme" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("gecikme") : ""; ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("gecikme"); ?></div>
<?php } ?>

