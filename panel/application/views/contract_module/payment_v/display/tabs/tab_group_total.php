<div class="fade tab-pane <?php if ($active_tab == "group_total") {
    echo "active show";
} ?>"
     id="group_total" role="tabpanel"
     aria-labelledby="group_total-tab">
    <div class="col-sm-10 offset-1">
        <div class="content">
            <p style="text-align:center; font-size:14pt;">
                <strong><?php echo contract_name($item->contract_id); ?></strong>
            </p>
            <p style="text-align:center; font-size:14pt;">
                <strong>YAPILAN İŞLER GRUP İCMALLERİ</strong>
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
        <?php foreach ($main_groups as $main_group) { ?>
        <table style="width:100%;">
            <thead>
            <tr>
                <td colspan="6">
                    <p style="margin-top:3pt; width:100%; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                        <strong><?php echo $main_group->code . " - " . $main_group->name; ?></strong>
                    </p>
                </td>
            </tr>
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
            <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id)); ?>
            <?php $i = 1; ?>
            <?php foreach ($sub_groups as $sub_group) { ?>
                <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>

                <?php $old_total_price = 0; ?>
                <?php $this_total_price = 0; ?>
                <?php foreach ($contract_items as $contract_item) { ?>
                    <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                    <?php $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total"); ?>
                    <?php $this_price = isset($calculate->total) ? $calculate->total*$contract_item->price : 0; ?>
                    <?php $old_price = isset($old_total) ? $old_total*$contract_item->price : 0; ?>
                    <?php $this_total_price += $this_price; ?>
                    <?php  $old_total_price += $old_price; ?>

                <?php } ?>
                <tr style="height:14.1pt;">
                    <td class ="w-3 total-group-row-center">
                        <p><strong><?php echo $i++; ?></strong></p>
                    </td>
                    <td class ="w-9 total-group-row-center">
                        <p><strong><?php echo $sub_group->code; ?></strong></p>
                    </td>
                    <td class ="w-25 total-group-row-left">
                        <p><strong><?php echo $sub_group->name; ?></strong></p>
                    </td>
                    <td class ="w-4 total-group-row-right">
                        <p><strong><?php echo money_format($old_total_price+$this_total_price); ?></strong></p>
                    </td>
                    <td class ="w-8 total-group-row-right">
                        <p><strong><?php echo money_format($old_total_price); ?></strong></p>
                    </td>
                    <td class ="w-8 total-group-row-right">
                        <p><strong><?php echo money_format($this_total_price);
                                ?></strong></p>
                    </td>
                </tr>
            <?php } ?>

            <?php } ?>
            </tbody>
        </table>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/0"); ?>">Önizleme</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/1"); ?>">Sıfır
            Olanları Gizle</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/2"); ?>">Sadece
            Bu Hakediş</a>
    </div>
</div>
