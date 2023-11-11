<div class="fade tab-pane <?php if ($active_tab == "main_total") {
    echo "active show";
} ?>"
     id="main_total" role="tabpanel"
     aria-labelledby="group_total-tab">
    <div class="col-sm-10 offset-1">
        <div class="content">
            <p style="text-align:center; font-size:14pt;">
                <strong><?php echo contract_name($item->contract_id); ?></strong>
            </p>
            <p style="text-align:center; font-size:14pt;">
                <strong>YAPILAN İŞLER İCMALİ</strong>
            </p>
            <table>
                <tbody>
                <tr>
                    <td colspan="5" class="w-72">
                    </td>
                    <td style="text-align:right; font-size:9pt;">
                        <strong>Sayfa No :</strong>
                    </td>
                    <td style="text-align:left; font-size:9pt; padding-left: 5px">
                        <strong>1</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="w- 30">
                        <p style="margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                            <strong><?php echo mb_strtoupper(contract_name($item->contract_id)); ?></strong>
                        </p>
                    </td>
                    <td style="text-align:right; font-size:9pt;">
                        <strong>Hakediş No :</strong>
                    </td>
                    <td style="text-align:left; font-size:9pt; padding-left: 5px ">
                        <strong><?php echo $item->hakedis_no; ?> No lu Hakediş</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <table style="width:100%;">
            <thead>
            <tr style="height:14.1pt;">
                <td class="w-5 total-group-header-center">
                    <p><strong>Sıra No</strong></p>
                </td>
                <td class="w-10 total-group-header-center">
                    <p><strong>Grup Kodu</strong></p>
                </td>
                <td class="w-25 total-group-header-center">
                    <p><strong>Grup Adı</strong></p>
                </td>
                <td class="w-15 total-group-header-center">
                    <p><strong>Yapılan İşler Toplamı</strong></p>
                </td>
                <td class="w-15 total-group-header-center">
                    <p><strong>Önceki Hakediş Toplamı</strong></p>
                </td>
                <td class="w-15 total-group-header-center">
                    <p><strong>Bu Hakediş Toplamı</strong></p>
                </td>
            </tr>
            </thead>
            <tbody>
            <?php $total_payment = 0; ?>
            <?php $i = 1; ?>
            <?php foreach ($main_groups as $main_group) { ?>
                <?php $sum_main_this = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id,"payment_no" => $item->hakedis_no, "main_id" => $main_group->id),"total"); ?>
                <?php $sum_main_old = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id,"payment_no <" => $item->hakedis_no, "main_id" => $main_group->id),"total"); ?>

                <tr style="height:14.1pt;">
                    <td class="w-3 total-group-row-center">
                        <p><strong> # </strong></p>
                    </td>
                    <td class="w-9 total-group-row-center">
                        <p><strong><?php echo $main_group->code; ?></strong></p>
                    </td>
                    <td class="w-25 total-group-row-left">
                        <p><strong><?php echo $main_group->name; ?></strong></p>
                    </td>
                    <td class="w-4 total-group-row-right">
                        <p><strong><?php echo money_format($sum_main_old + $sum_main_this); ?></strong>
                        </p>
                    </td>
                    <td class="w-8 total-group-row-right">
                        <p><strong><?php echo money_format($sum_main_old); ?></strong></p>
                    </td>
                    <td class="w-8 total-group-row-right">
                        <p><strong><?php echo money_format($sum_main_this); ?></strong></p>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="5" class="total-group-header-right">
                    <p><strong>Toplam</strong></p>
                </td>
                <td class="total-group-header-right">
                    <?php $sum_this_payment = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no),"total"); ?>
                    <p><strong><?php echo money_format($sum_this_payment); ?></strong></p>
                </td>

            </tr>
            </tbody>
        </table>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/0"); ?>">Önizleme</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/1"); ?>">Sıfır
            Olanları Gizle</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/2"); ?>">Sadece
            Bu Hakediş</a>
    </div>
</div>