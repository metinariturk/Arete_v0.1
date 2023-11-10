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
                <?php $main_this_total_price = 0; ?>
                <?php $main_old_total_price = 0; ?>
                <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                <?php foreach ($sub_groups as $sub_group) { ?>
                    <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>
                    <?php $sub_group_total_price = 0; ?>
                    <?php $sub_group_old_total_price = 0; ?>
                    <?php foreach ($contract_items as $contract_item) { ?>
                        <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                        <?php $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total"); ?>
                        <?php $this_price = isset($calculate->total) ? $calculate->total * $contract_item->price : 0; ?>
                        <?php $old_price = isset($old_total) ? $old_total * $contract_item->price : 0; ?>
                        <?php $sub_group_total_price += $this_price; ?>
                        <?php $sub_group_old_total_price += $old_price; ?>
                    <?php } ?>
                    <?php $main_this_total_price += $sub_group_total_price; ?>
                    <?php $main_old_total_price += $sub_group_old_total_price; ?>
                <?php } ?>
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
                        <p><strong><?php echo money_format($main_this_total_price + $main_old_total_price); ?></strong>
                        </p>
                    </td>
                    <td class="w-8 total-group-row-right">
                        <p><strong><?php echo money_format($main_old_total_price); ?></strong></p>
                    </td>
                    <td class="w-8 total-group-row-right">
                        <p><strong><?php echo money_format($main_this_total_price); ?></strong></p>
                    </td>
                </tr>
                <?php $total_payment += $main_this_total_price; ?>

            <?php } ?>
            <tr>
                <td style="text-align: right" colspan="5">TOPLAM</td>
                <td class="total-group-row-right">
                    <?php echo money_format($total_payment); ?>
                    <form id="myForm"
                          action="<?php base_url("payment/file_form/$item->id/report"); ?>"
                          method="post"
                          enctype="multipart">
                        <input name="total_payment" value="<?php echo $total_payment; ?>">
                    </form>
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