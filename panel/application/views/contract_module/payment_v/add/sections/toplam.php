<div class="row">
    <div class="col-sm-1"><div class="col-form-label">H</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">KESİNTİ VE MAHSUPLAR TOPLAMI</div>
        <small>Önceki Toplam <?php echo money_format(sum_payments("bu_fiyat_fark", "$contract->id"))." ".$contract->para_birimi; ?></small>
    </div>
    <div class="col-sm-6">
        <input type="number" step=".01" id="H" name="kesinti_toplam" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("kesinti_toplam") : ""; ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("kesinti_toplam"); ?></div>
<?php } ?>

<div class="row">
    <div class="col-sm-1"><div class="col-form-label">J</div></div>
    <div class="col-sm-5">
        <div class="col-form-label">ÖDENECEK NET TUTAR (G-H)</div>
        <small>Önceki Toplam <?php echo money_format(sum_payments("net_bedel", "$contract->id"))." ".$contract->para_birimi; ?></small>
    </div>
    <div class="col-sm-6">
        <input type="number" step=".01" id="T" name="net_bedel" class="form-control" onblur="calcular()"
               onfocus="calcular()"
               value="<?php echo isset($form_error) ? set_value("net_bedel") : ""; ?>">
    </div>
</div>
<?php if (isset($form_error)) { ?>
    <div class="invalid-feedback"><?php echo form_error("net_bedel"); ?></div>
<?php } ?>
