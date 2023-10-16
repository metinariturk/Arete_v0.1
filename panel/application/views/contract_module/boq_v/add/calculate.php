<?php if (isset($income)) { ?>
<?php
print_r($old_boq); } ?>


<?php if (isset($income)) { ?>
<div class="card">
    <div class="card-body">
        <fieldset>
            <h4 class="m-t-10 text-center"><?php echo contract_name($contract_id); ?> Sözleşemesine
                Ait <?php echo $payment_no; ?>
                Nolu Hakediş </h4>
            <h5 class="text-center"><?php echo boq_name($income); ?> </h5>
            <h6 class="text-center">Metraj Formu</h6>
            <hr>
            <div class="mb-3 row">
                <label class="col-lg-2 form-label text-lg-start" for="prependedcheckbox">El İle Metraj Git</label>
                <div class="col-lg-2">
                    <div class="input-group">
                        <span class="input-group-text">
                            <input type="checkbox" id="toggleCheckbox" onclick="toggleReadOnly(<?php echo $income; ?>)">
                        </span>
                        <input id="total_<?php echo $income; ?>" readonly name="total_<?php echo $income; ?>"
                               class="form-control btn-square" type="text" placeholder="">
                        <input name="boq_id" value="<?php echo $income; ?>">
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="container-fluid">

            <div class="row">
                <div class="col-2">
                    <strong>Bölüm</strong>
                </div>
                <div class="col-4">
                    <strong>Açıklama</strong>
                </div>
                <div class="col-1">
                    <strong>Adet</strong>
                </div>
                <div class="col-1">
                    <strong>En</strong>
                </div>
                <div class="col-1">
                    <strong>Boy</strong>
                </div>
                <div class="col-1">
                    <strong>Yükseklik</strong>
                </div>
                <div class="col-2">
                    <strong>Toplam</strong>
                </div>
            </div>
        </div>

        <?php if (isset($income_number)) {
            $number = $income_number;
        } else {
            $number = 10;
        } ?>
        <?php $row_numbers = range(1, $number); ?>
        <?php foreach ($row_numbers as $row_number) { ?>
            <div class="container-fluid">
                <div class="row" id="row_<?php echo $income; ?>_<?php echo $row_number; ?>">
                    <div class="col-2 mb-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][s]" style="width: 100%"
                               id="s_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="text">
                    </div>
                    <div class="col-4" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][n]" style="width: 100%"
                               id="n_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="text">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][q]" style="width: 100%"
                               id="q_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $row_number; ?>][w]" style="width: 100%"
                               id="w_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;" id="h_<?php echo $row_number; ?>">
                        <input name="boq[<?php echo $row_number; ?>][h]" style="width: 100%"
                               id="h_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;" id="l_<?php echo $row_number; ?>">
                        <input name="boq[<?php echo $row_number; ?>][l]" style="width: 100%"
                               id="l_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-2" style="margin: 0; padding: 0;" id="t_<?php echo $row_number; ?>">
                        <input readonly name="boq[<?php echo $row_number; ?>][t]" style="width: 100%"
                               id="t_<?php echo $income; ?>_<?php echo $row_number; ?>"
                               onblur="calculateAndSetResult(<?php echo $income; ?>, <?php echo $row_number; ?>)"
                               type="number" step="any">
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php } else { ?>
            <div class="card" style="height: 150px">
                <div class="card-body">
                    <h4 class="m-t-10 text-center"><?php echo contract_name($contract_id); ?> </h4>
                    <h5 class="text-center"> <?php echo $payment_no; ?> Nolu Hakediş </h5>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    Soldaki Menüden İmalat Seçiniz
                </div>
            </div>
        <?php } ?>











