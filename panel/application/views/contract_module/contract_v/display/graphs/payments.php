<?php if (!empty($payments)) { ?>
    <div class="col-12">
        <div class="card-header text-center">
            <h4>Hakediş Durumu</h4>
        </div>
        <table class="table">
            <thead>
            <tr>

            </tr>
            <tr>

            </tr>
            </thead>
            <tbody>
            <?php if (!empty($payments)) { ?>
                <?php
                foreach ($payments as $payment) { ?>
                    <tr>
                        <td class="text-center"><a href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                                <b><?php echo $payment->hakedis_no; ?></b></a>
                        </td>
                        <td class="text-center"><?php echo money_format($payment->E) . " " . $item->para_birimi; ?></td>

                        <td class="text-center"><?php echo money_format($payment->F) . " " . $item->para_birimi; ?></td>
                        <td class="text-center"><?php echo money_format($payment->H) . " " . $item->para_birimi; ?></td>
                        <td class="text-center"><?php echo money_format($payment->balance) . " " . $item->para_birimi; ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <th class="text-center">TOPLAM</th>
                <th class="text-center"><?php echo money_format(sum_payments("E", "$item->id")) . " " . $item->para_birimi; ?></th>
                <th class="text-center"><?php echo money_format(sum_payments("F", "$item->id")) . " " . $item->para_birimi; ?></th>
                <th class="text-center"><?php echo money_format(sum_payments("H", "$item->id")) . " " . $item->para_birimi; ?></th>
                <th class="text-center"><?php echo money_format(sum_payments("balance", "$item->id")) . " " . $item->para_birimi; ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-pill btn-outline-info btn-xs d-print-none"
                onclick="myFunction(this)"
                data-id="payments">Sayfayı Ayır
        </button>
    </div>
    <div class="col-12" id="payments" style="display: none; page-break-after: always;">
        <div class="d-print-none horizontal-line"></div>
    </div>
<?php } ?>