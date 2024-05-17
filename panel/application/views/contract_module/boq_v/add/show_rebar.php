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
                   href="<?php echo base_url("$this->Module_Name/template_download_rebar/$contract_id/$payment->id/$income"); ?>">
                    <i class="fa fa-file-excel-o"></i> Metrajı Excel Olarak İndir
                </a>
            </fieldset>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th colspan="6" style="text-align: right">TOPLAM</th>
            <th><?php if (!empty($old_boq)) {
                    echo $old_boq->total;
                } ?> ton
            </th>
        </tr>
        <tr>
            <th>Mahal</th>
            <th>Açıklama</th>
            <th style="text-align: center">Çap (mm)</th>
            <th style="text-align: center">Benzer</th>
            <th style="text-align: center">Adet</th>
            <th style="text-align: center">Boy (m)</th>
            <th>Ağırlık (kg)</th>
        </tr>
        </thead>
        <tbody>
        <?php $j = null; ?>
        <?php $range = 0; ?>
        <?php if (!empty($old_boq)) { ?>
            <?php $old_boqs = json_decode($old_boq->calculation, true); ?>
            <?php $i = 1; ?>
            <?php foreach ($old_boqs as $row_no => $info) { ?>
                <?php $j = $i++; ?>
                <?php $range = count($old_boqs); ?>
                <tr>
                    <td><?php echo $info['s']; ?></td>
                    <td><?php echo $info['n']; ?></td>
                    <td style="text-align: center">Ø<?php echo $info['q']; ?></td>
                    <td style="text-align: center"><?php echo $info['w']; ?></td>
                    <td style="text-align: center"><?php echo $info['h']; ?></td>
                    <td style="text-align: center"><?php echo $info['l']; ?></td>
                    <td><?php echo $info['t']; ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>

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

</div>
<script>
    function saveCalc(btn) {

        calculateAndSetResult(<?php echo $income; ?>, 1);

        var url = btn.getAttribute('data-url');
        var formId = btn.getAttribute('form');


        // Serialize the form data
        var formData = new FormData(document.getElementById(formId));

        // Send an AJAX POST request
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Assuming the response contains the updated content
                $(".dynamic").html(response);
                calculateAndSetResult(<?php echo $income; ?>, 1);
                var autoRefreshButton = document.querySelector('.auto-refresh-button');
                if (autoRefreshButton) {
                    autoRefreshButton.click();
                }

            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>
<script>
    function renderGroup(btn) {
        var $url = btn.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".renderGroup").html(response);
        })
    }
</script>



