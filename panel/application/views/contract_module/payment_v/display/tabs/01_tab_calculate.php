<div class="fade tab-pane <?php if ($active_tab == "calculate" or $active_tab == null) {
    echo "active show";
} ?>"
     id="calculate" role="tabpanel"
     aria-labelledby="calculate-tab">

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
                        <strong>01 - METRAJ CETVELİ</strong>
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
                <?php $isset_main = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "main_id" => $main_group->id)); ?>
                <?php if (!empty($isset_main)) { ?>
                    <table style="width:100%;">
                    <thead>
                    <tr>
                        <th>
                            <p style="font-size:10pt;">
                                <strong><?php echo $main_group->code . " - " . $main_group->name; ?></strong></p>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                    <?php foreach ($sub_groups as $sub_group) { ?>
                        <?php $isset_sub = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "sub_id" => $sub_group->id)); ?>
                        <?php if (!empty($isset_sub)) { ?>
                            <tr>
                                <td colspan="3">
                                    <p style="font-size:10pt;">
                                        <strong><?php echo $main_group->code . "." . $sub_group->code . " - " . $sub_group->name; ?></strong>
                                    </p>
                                </td>
                            </tr>
                            <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>
                            <?php foreach ($contract_items as $contract_item) { ?>
                                <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                                <?php if (isset($calculate)) { ?>
                                    <tr>
                                        <td colspan="7">
                                            <p style="font-size:10pt;">
                                                <strong><?php echo $contract_item->code . " - " . $contract_item->name . " - " . $contract_item->unit; ?></strong>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:10%; background-color:#e7e7e7; text-align: center">
                                            <p><strong>Bölüm</strong></p>
                                        </td>
                                        <td style="width:40%; background-color:#e7e7e7; text-align: center">
                                            <p><strong>Açıklama</strong></p>
                                        </td>
                                        <td style="width:8%; background-color:#e7e7e7; text-align: center">
                                            <p><strong>Adet</strong></p>
                                        </td>
                                        <td style="width:8%; background-color:#e7e7e7; text-align: center">
                                            <p><strong>En</strong></p>
                                        </td>
                                        <td style="width:8%; background-color:#e7e7e7; text-align: center">
                                            <p><strong>Boy</strong></p>
                                        </td>
                                        <td style="width:8%; background-color:#e7e7e7; text-align: center">
                                            <p><strong>Yükseklik</strong></p>
                                        </td>
                                        <td style="width:18%; background-color:#e7e7e7; text-align: center">
                                            <p><strong>Toplam</strong></p>
                                        </td>
                                    </tr>

                                    <?php foreach (json_decode($calculate->calculation, true) as $calculation_data) { ?>
                                        <tr>
                                            <td class="total-group-row-left">
                                                <?php echo $calculation_data["s"]; ?>
                                            </td>
                                            <td class="total-group-row-left">
                                                <?php echo $calculation_data["n"]; ?>
                                            </td>
                                            <td class="total-group-row-right">
                                                <?php echo money_format($calculation_data["q"]); ?>
                                            </td>
                                            <td class="total-group-row-right">
                                                <?php echo money_format($calculation_data["w"]); ?>
                                            </td>
                                            <td class="total-group-row-right">
                                                <?php echo money_format($calculation_data["h"]); ?>
                                            </td>
                                            <td class="total-group-row-right">
                                                <?php echo money_format($calculation_data["l"]); ?>
                                            </td>
                                            <td class="total-group-row-right">
                                                <?php echo money_format($calculation_data["t"]); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="6" class="w-3 total-group-row-right">
                                            <p><strong>TOPLAM</strong></p>
                                        </td>
                                        <td class="total-group-row-right">
                                            <strong><?php echo $calculate->total; ?></strong>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                </tbody>
                </table>
            <?php } ?>
            <div class="card">
                <div class="card-body">
                    <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3" style="height: 200px;">
                        <div class="h-100 checkbox-checked">
                            <h6 class="sub-title">01 - Metrajlar</h6>
                            <div style="height: 100px;">
                                <div class="form-check radio radio-success">
                                    <input class="form-check-input" id="radio22"
                                           data-url="<?php echo base_url("payment/print_calculate/$item->id/0"); ?>"
                                           type="radio" name="calculate" value="option1" checked="">
                                    <label class="form-check-label" for="radio22">Tüm Metrajlar</label>
                                </div>
                                <div class="form-check radio radio-success">
                                    <input class="form-check-input" id="radio33"
                                           data-url="<?php echo base_url("payment/print_calculate/$item->id/2"); ?>"
                                           type="radio" name="calculate" value="option2">
                                    <label class="form-check-label" for="radio33">Alt Gruplardan Ayır</label>
                                </div>
                            </div>
                            <div class="form-check radio radio-success">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                            <button class="btn btn-outline-success" name="calculate"
                                                    onclick="handleButtonClick(1)" type="button"><i class="fa fa-download"></i>
                                                İndir
                                            </button>
                                            <button class="btn btn-outline-success" name="calculate"
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
</div>



