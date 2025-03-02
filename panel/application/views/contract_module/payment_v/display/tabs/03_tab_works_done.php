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
                        <strong>03 - YAPILAN İŞLER LİSTESİ</strong>
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

            <?php foreach ($main_groups as $main_group) { ?>
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <th colspan="3">
                            <p style="font-size:10pt;">
                                <strong><?php echo $main_group->code . " - " . $main_group->name; ?></strong></p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                    <?php foreach ($sub_groups as $sub_group) { ?>
                        <tr>
                        <tr>
                            <td colspan="3">
                                <p style="font-size:10pt;">
                                    <strong><?php echo $main_group->code . "." . $sub_group->code . " - " . $sub_group->name; ?></strong>
                                </p>
                            </td>
                        </tr>
                        </tr>
                        <tr>
                            <td rowspan="2"
                                style="width:0.9cm;" class="calculate-header-center">
                                <p><strong>Sıra No</strong></p>
                            </td>
                            <td rowspan="2"
                                style="width:2cm;" class="calculate-header-center">
                                <p><strong>Poz No</strong></p>
                            </td>
                            <td rowspan="2"
                                style="width:6.8cm;" class="calculate-header-center">
                                <p><strong>Yapılan İşin Cinsi</strong></p>
                            </td>
                            <td rowspan="2"
                                style="width:1cm;" class="calculate-header-center">
                                <p><strong>Birimi</strong></p>
                            </td>
                            <td style="width:1.9cm;" class="calculate-header-center">
                                <p><strong>A</strong></p>
                            </td>
                            <td style="width:1.9cm;" class="calculate-header-center">
                                <p><strong>B</strong></p>
                            </td>
                            <td style="width:1.9cm;" class="calculate-header-center">
                                <p><strong>C</strong></p>
                            </td>
                            <td style="width:1.9cm;" class="calculate-header-center">
                                <p><strong>D=B-C</strong>
                                </p>
                            </td>
                            <td style="width:1.9cm;" class="calculate-header-center">
                                <p><strong>E=AxB</strong>
                                </p>
                            </td>
                            <td style="width:1.9cm;" class="calculate-header-center">
                                <p><strong>F=AxC</strong></p>
                            </td>
                            <td style="width:1.9cm;" class="calculate-header-center">
                                <p><strong>G=E-F</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="calculate-header-center">
                                <p><strong>Tekif Birim Fiyatı</strong></p>
                            </td>
                            <td class="calculate-header-center">
                                <p><strong>Toplam Miktarı</strong></p>
                            </td>
                            <td class="calculate-header-center">
                                <p><strong>Önceki Hakediş Miktarı</strong></p>
                            </td>
                            <td class="calculate-header-center">
                                <p><strong>Bu Hakediş Miktarı</strong></p>
                            </td>
                            <td class="calculate-header-center">
                                <p><strong>Toplam İmalat İhzarat</strong></p>
                            </td>
                            <td class="calculate-header-center">
                                <p><strong>Bir Önceki Tutarı</strong></p>
                            </td>
                            <td class="calculate-header-center">
                                <p><strong>Bu Hakediş</strong></p>
                            </td>
                        </tr>
                        <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>
                        <?php $i = 1; ?>
                        <?php
                        $total_X = 0;
                        $total_Y = 0;
                        $total_Z = 0;
                        ?>
                        <?php foreach ($contract_items as $contract_item) { ?>
                            <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                            <?php $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total"); ?>
                            <?php $this_total = isset($calculate->total) ? $calculate->total : 0; ?>
                            <?php
                            $total_X += ($old_total + $this_total) * $contract_item->price;
                            $total_Y += $old_total * $contract_item->price;
                            $total_Z += $this_total * $contract_item->price;
                            ?>

                            <tr>
                                <td class="total-group-row-center"><?php echo $i++; ?>
                                </td>
                                <td class="total-group-row-center">
                                    <?php echo($contract_item->code); ?>
                                </td>
                                <td class="total-group-row-left">
                                    <?php echo($contract_item->name); ?>
                                </td>
                                <td class="total-group-row-center">
                                    <?php echo($contract_item->unit); ?>
                                </td>
                                <td class="total-group-row-center">
                                    <?php echo money_format($contract_item->price); ?>
                                </td>
                                <td class="total-group-row-right">
                                    <?php echo money_format($old_total + $this_total); ?>
                                </td>
                                <td class="total-group-row-right">
                                    <?php echo money_format($old_total); ?>
                                </td>
                                <td class="total-group-row-right">
                                    <?php echo money_format($this_total); ?>
                                </td>
                                <td class="total-group-row-right">
                                    <?php echo money_format(($old_total + $this_total) * $contract_item->price); ?>
                                </td>
                                <td class="total-group-row-right">
                                    <?php echo money_format($old_total * $contract_item->price); ?>
                                </td>
                                <td class="total-group-row-right">
                                    <?php echo money_format($this_total * $contract_item->price); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="8">

                            </td>
                            <td class="total-group-row-right"><?php echo money_format($total_X);?></td>
                            <td class="total-group-row-right"><?php echo money_format($total_Y);?></td>
                            <td class="total-group-row-right"><?php echo money_format($total_Z);?></td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            <?php } ?>
            <div class="card-body">
                <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3" style="height: 200px;">
                    <div class="h-100 checkbox-checked">
                        <h6 class="sub-title">03 - Yapılan İşler Listesi</h6>
                        <div style="height: 100px;">
                            <div class="form-check radio radio-success">
                                <input class="form-check-input" id="wd1"
                                       data-url="<?php echo base_url("payment/print_works_done_hide_zero/$item->id"); ?>"
                                       type="radio" name="wd" value="green" checked="">
                                <label class="form-check-label" for="wd1">Sıfır Olanları Gizle</label>
                            </div>
                            <div class="form-check radio radio-success">
                                <input class="form-check-input" id="wd2"
                                       data-url="<?php echo base_url("payment/print_works_done_print_all/$item->id"); ?>"
                                       type="radio" name="wd" value="green">
                                <label class="form-check-label" for="wd2">Tümünü Yazdır</label>
                            </div>
                        </div>
                        <div class="form-check radio radio-success">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                        <button class="btn btn-outline-success" name="wd"
                                                onclick="handleButtonClick(1)" type="button"><i
                                                    class="fa fa-download"></i>
                                            İndir
                                        </button>
                                        <button class="btn btn-outline-success" name="wd"
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
