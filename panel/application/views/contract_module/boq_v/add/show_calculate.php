<?php if (isset($income)) { ?>
<?php $boq = $this->Contract_price_model->get(array("id" => $income)); ?>
<div class="card">
    <div class="card-body">
        <fieldset>
            <h4 class="m-t-10 text-center"><?php echo contract_name($contract_id); ?></h4>
            <h4 class="m-t-10 text-center"> <?php echo $payment->hakedis_no; ?> Nolu Hakediş</h4>
            <h5 class="text-center"><?php echo $boq->name; ?> </h5>
            <h6 class="text-center">Metraj Görüntüle</h6>
            <h6 class="text-center">Hakediş Kapağı Oluşturulduğu İçin Metraj Verisi Giremezsiniz. Hakediş kapağını
                temizlemek için
                <a href="<?php echo base_url("payment/file_form/$payment->id/report"); ?>"> tıklayınız</a></h6>
            <hr>
            <a class="btn btn-outline-primary"
               href="<?php echo base_url("$this->Module_Name/template_download/$contract_id/$payment->id/$income"); ?>">
                <i class="fa fa-file-excel-o"></i> Metrajı Excel Olarak İndir
            </a>
        </fieldset>
        <p>Metraj ID : <?php echo $old_boq->id; ?></p>
        <p>Boq ID : <?php echo $old_boq->boq_id; ?></p>
        <p>Leader ID : <?php echo $old_boq->leader_id; ?></p>
    </div>
</div>
<table class="table">
    <thead>
    <tr>
        <th colspan="6" style="text-align: right">TOPLAM</th>
        <th><?php if (!empty($old_boq)) {
                echo $old_boq->total;
            } ?><?php echo $boq->unit; ?>
        </th>
    </tr>
    </thead>
</table>

<div class="row">
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
            <div class="col-2" style="text-align: right">
                <strong>Toplam</strong>
            </div>
        </div>
    </div>
    <?php $j = null; ?>
    <?php $range = 0; ?>
    <?php if (!empty($old_boq)) { ?>
        <?php $old_boqs = json_decode($old_boq->calculation, true); ?>
        <?php $i = 1; ?>
        <?php foreach ($old_boqs as $row_no => $info) { ?>
            <?php $j = $i++; ?>
            <?php $range = count($old_boqs); ?>
            <div class="container-fluid">
                <div class="row" id="row_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>">
                    <div class="col-2 mb-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $j; ?>][s]" style="width: 100%" disabled
                               id="s_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                               value="<?php echo $info['s']; ?>"
                               onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               type="text">
                    </div>
                    <div class="col-4" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $j; ?>][n]" style="width: 100%" disabled
                               id="n_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                               value="<?php echo $info['n']; ?>"
                               onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               type="text">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $j; ?>][q]" style="width: 100%" disabled
                               id="q_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                               value="<?php echo $info['q']; ?>"
                               onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;">
                        <input name="boq[<?php echo $j; ?>][w]" style="width: 100%" disabled
                               id="w_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                               value="<?php echo $info['w']; ?>"
                               onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;" id="h_<?php echo $j; ?>">
                        <input name="boq[<?php echo $j; ?>][h]" style="width: 100%" disabled
                               id="h_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                               value="<?php echo $info['h']; ?>"
                               onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-1" style="margin: 0; padding: 0;" id="l_<?php echo $j; ?>">
                        <input name="boq[<?php echo $j; ?>][l]" style="width: 100%" disabled
                               id="l_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                               value="<?php echo $info['l']; ?>"
                               onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               type="number" step="any">
                    </div>
                    <div class="col-2" style="margin: 0; padding: 0;" id="t_<?php echo $j; ?>">
                        <input readonly name="boq[<?php echo $j; ?>][t]" style="width: 100%" disabled
                               id="t_<?php echo $old_boq->boq_id; ?>_<?php echo $j; ?>"
                               value="<?php echo isset($info['t']) ? $info['t'] : ''; ?>"
                               onclick="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               onblur="calculateAndSetResult(<?php echo $old_boq->boq_id; ?>, <?php echo $j; ?>)"
                               type="number" step="any">
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>


    <?php } else { ?>
        <div class="card" style="height: 150px">
            <div class="card-body">
                <h4 class="m-t-10 text-center"><?php echo contract_name($contract->id); ?> </h4>
                <h5 class="text-center"> <?php echo $payment->hakedis_no; ?> Nolu Hakediş </h5>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                Soldaki Menüden İmalat Seçiniz
            </div>
        </div>
    <?php } ?>

    <script>
        function renderCalculate(btn) {
            var $url = btn.getAttribute('url');

            $.post($url, {}, function (response) {
                $(".dynamic").html(response);

            })
        }
    </script>






