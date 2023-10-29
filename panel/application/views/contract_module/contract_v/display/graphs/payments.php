<?php if (!empty($payments)) { ?>
    <div class="col-12">
        <div class="card-header text-center">
            <h4>Hakediş Durumu</h4>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th class="text-center"></th>
                <?php if ($item->fiyat_fark == 1) { ?>
                    <th class="text-center bg-light-primary" colspan="3">Hakediş Tutar</th>
                <?php } else { ?>
                    <th class="text-center bg-light-primary" colspan="2">Hakediş Tutar</th>
                <?php } ?>
                <th class="text-center"></th>
                <th class="text-center"></th>
                <?php if ($item->avans_durum == 1) { ?>
                    <th class="text-center bg-light-primary" colspan="2">Avans</th>
                <?php } ?>
            </tr>
            <tr>
                <th class="text-center">Hakediş No</th>
                <th class="text-center">İmalat-İhzrat Tutar</th>
                <?php if ($item->fiyat_fark == 1) { ?>
                    <th class="text-center">Fiyat Farkı</th>
                <?php } ?>
                <th class="text-center">KDV</th>
                <th class="text-center">Kesintiler</th>
                <th class="text-center">Net Ödenen</th>
                <?php if ($item->avans_durum == 1) { ?>
                    <th class="text-center">Mahsup Miktar</th>
                    <th class="text-center">Mahsup Oran</th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($payments)) { ?>
                <?php
                foreach ($payments as $payment) { ?>
                    <tr>
                        <td class="text-center"><a href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                                <b><?php echo $payment->hakedis_no . " - " . $payment->dosya_no; ?></b></a>
                        </td>
                        <td class="text-center"><?php echo money_format($payment->bu_imalat_ihzarat) . " " . $item->para_birimi; ?></td>
                        <?php if ($item->fiyat_fark == 1) { ?>
                            <td class="text-center"><?php echo money_format($payment->bu_fiyat_fark) . " " . $item->para_birimi; ?></td>
                        <?php } ?>
                        <td class="text-center"><?php echo money_format($payment->kdv_tutar) . " " . $item->para_birimi; ?></td>
                        <td class="text-center"><?php echo money_format($payment->kesinti_toplam) . " " . $item->para_birimi; ?></td>
                        <td class="text-center"><?php echo money_format($payment->net_bedel) . " " . $item->para_birimi; ?></td>
                        <?php if ($item->avans_durum == 1) { ?>
                            <td class="text-center"> <?php echo money_format($payment->avans_mahsup_miktar) . " " . $item->para_birimi; ?></td>
                            <td class="text-center"> <?php echo "%" . round($payment->avans_mahsup_oran); ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <th class="text-center">TOPLAM</th>
                <th class="text-center"><?php echo money_format(sum_payments("bu_imalat_ihzarat", "$item->id")) . " " . $item->para_birimi; ?></th>
                <?php if ($item->fiyat_fark == 1) { ?>
                    <th class="text-center"><?php echo money_format(sum_payments("bu_fiyat_fark", "$item->id")) . " " . $item->para_birimi; ?></th>
                <?php } ?>
                <th class="text-center"><?php echo money_format(sum_payments("kdv_tutar", "$item->id")) . " " . $item->para_birimi; ?></th>
                <th class="text-center"><?php echo money_format(sum_payments("kesinti_toplam", "$item->id")) . " " . $item->para_birimi; ?></th>
                <th class="text-center"><?php echo money_format(sum_payments("net_bedel", "$item->id")) . " " . $item->para_birimi; ?></th>
                <?php if ($item->avans_durum == 1) { ?>
                    <th class="text-center"><?php echo money_format(sum_payments("avans_mahsup_miktar", "$item->id")) . " " . $item->para_birimi; ?></th>
                    <th class="text-center">%
                    <?php $value = sum_payments("bu_imalat_ihzarat", "$item->id");
                    if ($value != 0) {
                        echo round((sum_payments("avans_mahsup_miktar", "$item->id") / $value * 100), 2); ?></th>
                    <?php } ?>
                <?php } ?>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-12 text-center">
        <button class="btn btn-pill btn-outline-info btn-xs d-print-none"
                onclick="myFunction(this)"
                data-id="payments"
        >Sayfayı Ayır
        </button>
    </div>
    <div class="col-12" id="payments" style="display: none; page-break-after: always;">
        <div class="d-print-none horizontal-line"></div>
    </div>
<?php } ?>