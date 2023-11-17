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
                        <strong>04 - YAPILAN İŞLER GRUP İCMALLERİ</strong>
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
            <div class="card-body">
                <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3" style="height: 200px;">
                    <div class="h-100 checkbox-checked">
                        <h6 class="sub-title">04 - Yapılan İşler Grup İcmalleri</h6>
                        <div style="height: 50px;" hidden>
                            <div class="form-check radio radio-success">
                                <input class="form-check-input" id="gt1"
                                       data-url="<?php echo base_url("payment/print_group_total/$item->id"); ?>"
                                       type="radio" name="gt" value="green" checked="">
                                <label class="form-check-label" for="gt1">Tümünü Yazdır</label>
                            </div>
                        </div>
                        <div class="form-check radio radio-success">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                        <button class="btn btn-outline-success" name="gt"
                                                onclick="handleButtonClick(1)" type="button"><i class="fa fa-download"></i>
                                            İndir
                                        </button>
                                        <button class="btn btn-outline-success" name="gt"
                                                onclick="handleButtonClick(0)" type="button"><i
                                                    class="fa fa-file-pdf-o"></i>Önizle
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
