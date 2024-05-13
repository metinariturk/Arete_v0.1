<div class="fade tab-pane <?php if ($active_tab == "calculate" or $active_tab == null) {
    echo "active show";
} ?>"
     id="calculate" role="tabpanel"
     aria-labelledby="calculate-tab">


    <div class="content">
        <div class="card">
            <div class="card-body">
                <table>
                    <thead>
                    <tr>
                        <td colspan="5">
                            <h3 class="text-center"><?php echo contract_name($item->contract_id); ?></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <h4 class="text-center">METRAJ CETVELİ</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <h5 class="text-center">Hakediş No : <?php echo $item->hakedis_no; ?></h5>
                        </td>
                    </tr>
                    </thead>
                </table>
                <div class="table-responsive signal-table">
                    <table class="table table-hover table-light table-condensed table-striped">
                        <?php foreach ($main_groups as $main_group) { ?>
                            <?php $isset_main = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "main_id" => $main_group->id)); ?>
                            <?php if (!empty($isset_main)) { ?>

                                <tbody>
                                <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                                <?php foreach ($sub_groups as $sub_group) { ?>
                                    <?php $isset_sub = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "sub_id" => $sub_group->id)); ?>
                                    <?php if (!empty($isset_sub)) { ?>
                                        <tr>
                                            <th colspan="7">
                                                <?php echo $main_group->code . " - " . $main_group->name; ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <?php echo $main_group->code . "." . $sub_group->code . " - " . $sub_group->name; ?>
                                            </td>
                                        </tr>
                                        <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>
                                        <?php foreach ($contract_items as $contract_item) { ?>
                                            <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                                            <?php if (isset($calculate)) { ?>
                                                <tr>
                                                    <td colspan="7">

                                                        <?php echo $contract_item->code . " - " . $contract_item->name . " - " . $contract_item->unit; ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="w20c">
                                                        <strong>Bölüm</strong>
                                                    </td>
                                                    <td class="w35c">
                                                        <strong>Açıklama</strong>
                                                    </td>
                                                    <td class="w10c d-none d-sm-table-cell">
                                                        <strong>Adet</strong>
                                                    </td>
                                                    <td class="w10c d-none d-sm-table-cell">
                                                        <strong>En</strong>
                                                    </td>
                                                    <td class="w10c d-none d-sm-table-cell">
                                                        <strong>Boy</strong>
                                                    </td>
                                                    <td class="w10c d-none d-sm-table-cell">
                                                        <strong>Yükseklik</strong>
                                                    </td>
                                                    <td class="w10c">
                                                        <strong>Toplam</strong>
                                                    </td>
                                                </tr>

                                                <?php foreach (json_decode($calculate->calculation, true) as $calculation_data) { ?>
                                                    <tr>
                                                        <td class="w20">
                                                            <?php echo $calculation_data["s"]; ?>
                                                        </td>
                                                        <td class="w35">
                                                            <?php echo $calculation_data["n"]; ?>
                                                        </td>
                                                        <td class="w10c d-none d-sm-table-cell">
                                                            <?php echo money_format($calculation_data["q"]); ?>
                                                        </td>
                                                        <td class="w10c d-none d-sm-table-cell">
                                                            <?php echo money_format($calculation_data["w"]); ?>
                                                        </td>
                                                        <td class="w10c d-none d-sm-table-cell">
                                                            <?php echo money_format($calculation_data["h"]); ?>
                                                        </td>
                                                        <td class="w10c d-none d-sm-table-cell">
                                                            <?php echo money_format($calculation_data["l"]); ?>
                                                        </td>
                                                        <td class="w10c">
                                                            <?php echo money_format($calculation_data["t"]); ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td class="d-none d-sm-table-cell" colspan="5">
                                                    </td>
                                                    <td style="text-align: right" colspan="2">
                                                        <strong>Toplam <?php echo $calculate->total; ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7" class="bg-light-light">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </table>
                </div>
            </div>
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
                                                onclick="handleButtonClick(1)" type="button"><i
                                                    class="fa fa-download"></i>
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



