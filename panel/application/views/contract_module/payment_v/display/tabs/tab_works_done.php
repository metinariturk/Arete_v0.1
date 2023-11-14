<div class="fade tab-pane <?php if ($active_tab == "works_done") {
    echo "active show";
} ?>"
     id="works_done" role="tabpanel"
     aria-labelledby="works_done-tab">

    <div class="col-sm-10 offset-1">
        <div class="content">
            <p style="text-align:center; font-size:14pt;">
                <strong><?php echo contract_name($item->contract_id); ?></strong>
            </p>
            <p style="text-align:center; font-size:14pt;">
                <strong>YAPILAN İŞLER LİSTESİ</strong>
            </p>
            <table>
                <tbody>
                <tr>
                    <td colspan="5" style="width: 72%">
                    </td>
                    <td style="text-align:right; font-size:9pt;">
                        <strong>Sayfa No :</strong>
                    </td>
                    <td style="text-align:left; font-size:9pt; padding-left: 5px">
                        <strong>1</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="width: 72%">
                        <p style="margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                            <strong><?php echo mb_strtoupper(contract_name($item->contract_id)); ?></strong></p>
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
                <td colspan="7">
                    <p style="margin-top:3pt; width:100%; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                        <strong><?php echo $main_group->code . " - " . $main_group->name; ?></strong>
                    </p>
                </td>
            </tr>

            </thead>
            <tbody>

            <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id)); ?>
            <?php foreach ($sub_groups as $sub_group) { ?>
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <td colspan="7">
                            <p style="margin-top:3pt; width:100%; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                                <strong><?php echo $sub_group->code . " - " . $sub_group->name; ?></strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2"
                            style="width:3%;" class="calculate-header-center">
                            <p><strong>Sıra No</strong></p>
                        </td>
                        <td rowspan="2"
                            style="width:9%;" class="calculate-header-center">
                            <p><strong>Poz No</strong></p>
                        </td>
                        <td rowspan="2"
                            style="width:25%;" class="calculate-header-center">
                            <p><strong>Yapılan İşin Cinsi</strong></p>
                        </td>
                        <td rowspan="2"
                            style="width:4%;" class="calculate-header-center">
                            <p><strong>Birimi</strong></p>
                        </td>
                        <td style="width:8%;" class="calculate-header-center">
                            <p><strong>A</strong></p>
                        </td>
                        <td style="width:8%;" class="calculate-header-center">
                            <p><strong>B</strong></p>
                        </td>
                        <td style="width:8%;" class="calculate-header-center">
                            <p><strong>C</strong></p>
                        </td>
                        <td style="width:8%;" class="calculate-header-center">
                            <p><strong>D=B-C</strong>
                            </p>
                        </td>
                        <td style="width:9%;" class="calculate-header-center">
                            <p><strong>E=AxB</strong>
                            </p>
                        </td>
                        <td style="width:9%;" class="calculate-header-center">
                            <p><strong>F=AxC</strong></p>
                        </td>
                        <td style="width:9%;" class="calculate-header-center">
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

                    </thead>
                    <tbody>
                    <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>
                    <?php $i = 1; ?>
                    <?php foreach ($contract_items as $contract_item) { ?>
                        <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                        <?php $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total"); ?>
                        <?php $this_total = isset($calculate->total) ? $calculate->total : 0; ?>

                        <tr>
                            <td class="w5c" style="border: 0.75pt solid black; border-width:0.75pt;"><?php echo $i++; ?>
                            </td>
                            <td  class="w15" style="border: 0.75pt solid black; border-width:0.75pt; text-align:center; font-size:9pt;">
                                <?php echo($contract_item->code); ?>
                            </td>
                            <td  class="w35" style="border: 0.75pt solid black; border-width:0.75pt; text-align:left; font-size:9pt;">
                                <?php echo($contract_item->name); ?>
                            </td>
                            <td  class="w5c" style="border: 0.75pt solid black; border-width:0.75pt; font-size:9pt;">
                                <?php echo($contract_item->unit); ?>
                            </td>
                            <td  class="w5c" style="border: 0.75pt solid black; border-width:0.75pt; font-size:9pt;">
                                <?php echo money_format($contract_item->price); ?>
                            </td>
                            <td  class="w10" style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($old_total + $this_total); ?>
                            </td>
                            <td  class="w10" style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($old_total); ?>
                            </td>
                            <td  class="w10" style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($this_total); ?>
                            </td>
                            <td  class="w10" style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format(($old_total + $this_total)*$contract_item->price); ?>
                            </td>
                            <td  class="w10" style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($old_total*$contract_item->price); ?>
                            </td>
                            <td  class="w10" style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($this_total*$contract_item->price); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
            <?php } ?>
            <hr>
            <div class="container mt-5">
                <div class="form-group">
                    <div class="form-group">
                        <input data-url="<?php echo base_url("payment/print_works_done/$item->id/1"); ?>" type="radio"
                               id="option2" name="options" class="form-check-input">
                        <label for="option2">Toplamı Sıfır Olanları Yazdırma(Sayfa Tasarrufu)</label>
                    </div>
                    <input data-url="<?php echo base_url("payment/print_works_done/$item->id/0"); ?>" type="radio"
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





