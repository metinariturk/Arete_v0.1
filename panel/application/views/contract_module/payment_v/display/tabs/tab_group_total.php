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
        <?php foreach ($main_groups

        as $main_group) { ?>
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

            <?php $c = 0; ?>
            <?php $d = 0; ?>
            <?php foreach ($sub_groups as $sub_group) : ?>
                <?php
                $sum_group_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "sub_id" => $sub_group->id));
                $a = array_reduce($sum_group_items, function ($carry, $sum_group_item) {
                    $contract_price = get_from_any("contract_price", "price", "id", "$sum_group_item->boq_id");
                    return $carry + $sum_group_item->total * $contract_price;
                }, 0);
                ?>

                <?php
                $sum_group_old_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "sub_id" => $sub_group->id));
                $b = array_reduce($sum_group_old_items, function ($carry, $sum_group_old_item) {
                    $contract_price = get_from_any("contract_price", "price", "id", "$sum_group_old_item->boq_id");
                    return $carry + $sum_group_old_item->total * $contract_price;
                }, 0);
                ?>

                <tr>
                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:center; font-size:9pt;"><?php echo $i++; ?></td>
                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:left; font-size:9pt;"><?php echo $main_group->code . "." . $sub_group->code; ?></td>
                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:left; font-size:9pt;"><?php echo $sub_group->name; ?></td>
                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;"><?php echo money_format($a + $b); ?></td>
                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;"><?php echo money_format($b); ?></td>
                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;"><?php echo money_format($a); ?></td>
                </tr>

                <?php $c += $a; ?>
                <?php $d += $b; ?>
            <?php endforeach; ?>

            <tr>
                <td colspan="3" class="total-group-header-right">
                    <p><strong>Toplam</strong></p>
                </td>
                <td class="total-group-header-right">
                    <p><strong><?php echo money_format($d+$c); ?></strong></p>
                </td>
                <td class="total-group-header-right">
                    <p><strong><?php echo money_format($d); ?></strong></p>
                </td>
                <td class="total-group-header-right">
                    <p><strong><?php echo money_format($c); ?></strong></p>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <hr>
        <div class="container mt-5">
            <div class="form-group">
                <input data-url="<?php echo base_url("payment/print_group_total/$item->id/0"); ?>" type="radio" checked
                       id="option1" name="options" class="form-check-input">
                <label for="option1">Yazdır</label>
            </div>
            <div class="col-6">
                <button class="btn btn-success" id="printGreen" onclick="handleButtonClick(1)"><i
                            class="fa fa-print"></i>PDF Kaydet
                </button>
                <button class="btn btn-success" id="displayGreen" onclick="handleButtonClick(0)"><i
                            class="fa fa-print"></i>Ön İzleme
                </button>
            </div>
        </div>
    </div>
</div>
