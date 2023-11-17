<div class="fade tab-pane <?php if ($active_tab == "main_total") {
    echo "active show";
} ?>"
     id="main_total" role="tabpanel"
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
                        <strong>YAPILAN İŞLER İCMALİ</strong>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                </div>
                <div class="col-2">
                    <p style="text-align:right;">
                        <strong>Hakediş No : <?php echo $item->hakedis_no; ?></strong>
                    </p>
                </div>
            </div>
            <hr>
            <table style="width:100%;">
                <thead>
                <tr>
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
                <?php $i = 1; ?>
                <?php $x = 0; ?>
                <?php $y = 0; ?>
                <?php foreach ($main_groups as $main_group) {
                    $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id));
                    $c = 0;
                    $d = 0;
                    foreach ($sub_groups as $sub_group) {
                        $sum_group_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "sub_id" => $sub_group->id));
                        $a = array_reduce($sum_group_items, function ($carry, $sum_group_item) {
                            $contract_price = get_from_any("contract_price", "price", "id", "$sum_group_item->boq_id");
                            return $carry + $sum_group_item->total * $contract_price;
                        }, 0);
                        $sum_group_old_items = $this->Boq_model->get_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "sub_id" => $sub_group->id));
                        $b = array_reduce($sum_group_old_items, function ($carry, $sum_group_old_item) {
                            $contract_price = get_from_any("contract_price", "price", "id", "$sum_group_old_item->boq_id");
                            return $carry + $sum_group_old_item->total * $contract_price;
                        }, 0);
                        $c += $a;
                        $d += $b;
                    } ?>
                    <tr>
                        <td class="w-3 total-group-row-center">
                            <?php echo $i++; ?>
                        </td>
                        <td class="w-9 total-group-row-center">
                            <?php echo $main_group->code; ?>
                        </td>
                        <td class="w-25 total-group-row-left">
                            <?php echo $main_group->name; ?>
                        </td>
                        <td class="w-4 total-group-row-right">
                            <?php echo money_format($c + $d); ?>
                        </td>
                        <td class="w-8 total-group-row-right">
                            <?php echo money_format($d); ?>
                        </td>
                        <td class="w-8 total-group-row-right">
                            <?php echo money_format($c); ?>
                        </td>
                    </tr>
                    <?php $x += $d; ?>
                    <?php $y += $c; ?>
                <?php } ?>

                <tfoot>
                <tr style="height:14.1pt;">
                    <td colspan="3" class="w-3 total-group-row-right">
                        <p><strong>TOPLAM</strong></p>
                    </td>

                    <td class="w-4 total-group-row-right">
                        <p><strong><?php echo money_format($x + $y); ?></strong>
                        </p>
                    </td>
                    <td class="w-8 total-group-row-right">
                        <p><strong><?php echo money_format($x); ?></strong></p>
                    </td>
                    <td class="w-8 total-group-row-right">
                        <p><strong><?php echo money_format($y); ?></strong></p>
                    </td>
                </tr>


                </tfoot>
                </tbody>
            </table>
            <div class="card-body">
                <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3" style="height: 200px;">
                    <div class="h-100 checkbox-checked">
                        <h6 class="sub-title">05 - Yapılan İşler Grup İcmalleri</h6>
                        <div style="height: 50px;" hidden>
                            <div class="form-check radio radio-success">
                                <input class="form-check-input" id="mt1"
                                       data-url="<?php echo base_url("payment/print_main_total/$item->id"); ?>"
                                       type="radio" name="mt" value="main" checked="">
                                <label class="form-check-label" for="mt1">Tümünü Yazdır</label>
                            </div>
                        </div>
                        <div class="form-check radio radio-success">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                        <button class="btn btn-outline-success" name="mt"
                                                onclick="handleButtonClick(1)" type="button"><i
                                                    class="fa fa-download"></i>
                                            İndir
                                        </button>
                                        <button class="btn btn-outline-success" name="mt"
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