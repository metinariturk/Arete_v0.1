<div class="fade tab-pane <?php if ($active_tab == "works_done") {
    echo "active show";
} ?>"
     id="works_done" role="tabpanel"
     aria-labelledby="works_done-tab">

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
                        <strong>YAPILAN İŞLER LİSTESİ</strong>
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
                        <?php foreach ($contract_items as $contract_item) { ?>
                            <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                            <?php $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total"); ?>
                            <?php $this_total = isset($calculate->total) ? $calculate->total : 0; ?>
                            <tr>
                                <td style="border-width:0.75pt;"><?php echo $i++; ?>
                                </td>
                                <td style="border-width:0.75pt; text-align:center; font-size:9pt;">
                                    <?php echo($contract_item->code); ?>
                                </td>
                                <td style="border-width:0.75pt; text-align:left; font-size:9pt;">
                                    <?php echo($contract_item->name); ?>
                                </td>
                                <td style="border-width:0.75pt; font-size:9pt;">
                                    <?php echo($contract_item->unit); ?>
                                </td>
                                <td style="border-width:0.75pt; font-size:9pt;">
                                    <?php echo money_format($contract_item->price); ?>
                                </td>
                                <td style="border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($old_total + $this_total); ?>
                                </td>
                                <td style="border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($old_total); ?>
                                </td>
                                <td style="border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($this_total); ?>
                                </td>
                                <td style="border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format(($old_total + $this_total) * $contract_item->price); ?>
                                </td>
                                <td style="border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($old_total * $contract_item->price); ?>
                                </td>
                                <td style="border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($this_total * $contract_item->price); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
            <hr>
            <div class="container mt-5">
                <div class="form-group">
                    <div class="form-group">
                        <input data-url="<?php echo base_url("payment/print_works_done_hide_zero/$item->id"); ?>"
                               type="radio"
                               id="option2" name="options" class="form-check-input">
                        <label for="option2">Toplamı Sıfır Olanları Yazdırma(Sayfa Tasarrufu)</label>
                    </div>
                    <input data-url="<?php echo base_url("payment/print_works_done_print_all/$item->id"); ?>"
                           type="radio"
                           id="option1" name="options" class="form-check-input">
                    <label for="option1">Tümümünü Yazdır</label>
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