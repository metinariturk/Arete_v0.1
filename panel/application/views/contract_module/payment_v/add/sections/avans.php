<?php if ($contract->avans_mahsup_durum == 1) { ?>
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">g</div></div>
        <div class="col-sm-3">
            <div class="col-form-label">Avans Mahsubu
                <br>
                <i>Toplam verilen
                    avans <?php echo money_format(sum_from_table("advance", "avans_miktar", $contract->id)) . " " . get_currency($contract->id); ?></i>
                <i>Toplam mahsup edilen
                    avans <?php echo money_format(sum_payments("avans_mahsup_miktar", $contract->id)) . " " . get_currency($contract->id); ?></i>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="number" step=".0001" id="KES_g_1" name="avans_mahsup_oran" class="form-control"
                   onblur="calcular()" onfocus="calcular()"
                   value="<?php echo isset($form_error) ? "$contract->avans_mahsup_oran" : "$contract->avans_mahsup_oran"; ?>">
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="KES_g" name="avans_mahsup_miktar" class="form-control" onblur="calcular()"
                   onfocus="calcular()" readonly
                   value="<?php echo isset($form_error) ? set_value("avans_mahsup_miktar") : ""; ?>">
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("avans_mahsup_miktar"); ?></div>
            <?php } ?>
        <?php if ($contract->avans_stopaj == 1) { ?>
            <input type="number" step=".01" id="KES_g_2" hidden onblur="calcular()" onfocus="calcular()"
                   value="1">
        <?php } else { ?>
            <input type="number" step=".01" id="KES_g_2" hidden onblur="calcular()" onfocus="calcular()"
                   value="0">
        <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <input type="number" step=".01" id="KES_g_1" onblur="calcular()" onfocus="calcular()" value="0" hidden>
    <input type="number" step=".01" id="KES_g" onblur="calcular()" onfocus="calcular()" value="0" hidden>
    <input type="number" step=".01" id="KES_g_2" onblur="calcular()" onfocus="calcular()" value="0" hidden>
<?php } ?>