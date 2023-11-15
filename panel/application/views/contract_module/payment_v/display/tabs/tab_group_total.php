<div class="fade tab-pane <?php if ($active_tab == "group_total") {
    echo "active show";
} ?>"
     id="group_total" role="tabpanel"
     aria-labelledby="group_total-tab">
    <div class="content">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <p style="text-align:center; font-size:14pt;">
                        <strong><?php echo contract_name($item->contract_id); ?></strong>
                    </p>
                </div>
                <div class="col-12">
                    <p style="text-align:center; font-size:14pt;">
                        <strong>YAPILAN İŞLER GRUP İCMALLERİ</strong>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                </div>
                <div class="col-2">
                    <p style="text-align:right; margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                        <strong>Hakediş No : <?php echo $item->hakedis_no; ?></strong>
                    </p>
                </div>
            </div>
            <hr>
            <?php foreach ($main_groups

            as $main_group) { ?>
            <table style="width:100%;">
                <thead>
                <tr>
                    <th colspan="6">
                        <p style="font-size:10pt;">
                            <strong><?php echo $main_group->code . " - " . $main_group->name; ?></strong></p>
                    </th>
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
                <?php foreach ($sub_groups as $sub_group) { ?>
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
                        <td class="total-group-row-center"><?php echo $i++; ?></td>
                        <td  class="total-group-row-left"><?php echo $main_group->code . "." . $sub_group->code; ?></td>
                        <td  class="total-group-row-left"><?php echo $sub_group->name; ?></td>
                        <td  class="total-group-row-right"><?php echo money_format($a + $b); ?></td>
                        <td  class="total-group-row-right"><?php echo money_format($b); ?></td>
                        <td  class="total-group-row-right"><?php echo money_format($a); ?></td>
                    </tr>

                    <?php $c += $a; ?>
                    <?php $d += $b; ?>

                <?php } ?>

                <tr>
                    <td colspan="3" class="w-3 total-group-row-right">
                        <p><strong>TOPLAM</strong></p>
                    </td>
                    <td class="total-group-row-right">
                        <p><strong><?php echo money_format($d + $c); ?></strong></p>
                    </td>
                    <td class="total-group-row-right">
                        <p><strong><?php echo money_format($d); ?></strong></p>
                    </td>
                    <td class="total-group-row-right">
                        <p><strong><?php echo money_format($c); ?></strong></p>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <hr>
            <div class="container mt-5">
                <div class="form-group">
                    <input data-url="<?php echo base_url("payment/print_group_total/$item->id"); ?>" type="radio"
                           checked
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
</div>
