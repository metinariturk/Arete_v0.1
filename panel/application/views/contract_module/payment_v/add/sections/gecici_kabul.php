<?php if ($contract->gecici_kabul_kesinti == 1) { ?>
    <div class="row">
        <div class="col-sm-1"><div class="col-form-label">k</div></div>

        <div class="col-sm-3">
            <div class="col-form-label">Nakit Geçici Kabul Kesintisi % <?php echo $contract->teminat_oran; ?></div>
        </div>
        <div class="col-sm-2">
            <input type="number" step=".0001" id="KES_k_1" name="gecici_kabul_kesinti_oran" class="form-control"
                   onblur="calcular()" onfocus="calcular()"
                   value="<?php echo isset($form_error) ? "$contract->teminat_oran" : "$contract->teminat_oran"; ?>">
        </div>
        <div class="col-sm-6">
            <input type="number" step=".01" id="KES_k" name="gecici_kabul_kesinti" class="form-control"
                   onblur="calcular()"
                   onfocus="calcular()" readonly
                   value="<?php echo isset($form_error) ? set_value("gecici_kabul_kesinti") : ""; ?>">
        </div>
    </div>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("gecici_kabul_kesinti"); ?></div>
    <?php } ?>
<?php } else { ?>
    <input type="number" step=".01" id="KES_k_1" onblur="calcular()" onfocus="calcular()" value="0" hidden>
    <input type="number" step=".01" id="KES_k" onblur="calcular()" onfocus="calcular()" value="0" hidden>
<?php } ?>