<div class="fade tab-pane <?php if ($active_tab == "green") {
    echo "show active";
} ?>"
     id="green" role="tabpanel"
     aria-labelledby="green-tab">
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
                        <strong>02 - METRAJ İCMALİ</strong>
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
                    <th>
                        <p style="font-size:10pt;">
                            <strong><?php echo $main_group->code . " - " . $main_group->name; ?></strong></p>
                    </th>
                </tr>
                </thead>
                <tbody>

                <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id)); ?>
                <?php foreach ($sub_groups as $sub_group) { ?>
                    <table style="width:100%;">
                        <thead>
                        <tr>
                            <td colspan="3">
                                <p style="font-size:10pt;">
                                    <strong><?php echo $main_group->code . "." . $sub_group->code . " - " . $sub_group->name; ?></strong>
                                </p>
                            </td>
                        </tr>
                        </thead>
                    </table>
                    <table style="width:100%;">
                        <tbody>
                        <tr style="height:14.1pt;">
                            <td class="w5c"
                                style="background-color:#e7e7e7;  border-width:0.75pt;">
                                <p><strong>Sıra No</strong></p>
                            </td>
                            <td class="w15c"
                                style="background-color:#e7e7e7;  border-width:0.75pt;">
                                <p><strong>Poz No</strong></p>
                            </td>
                            <td class="w35c"
                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                <p><strong>Yapılan İşin Cinsi</strong></p>
                            </td>

                            <td class="w5c"
                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                <p><strong>Birimi</strong></p>
                            </td>
                            <td class="w10c"
                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                <p><strong>Toplam Miktarı</strong></p>
                            </td>
                            <td class="w10c"
                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                <p><strong>Önceki Hakediş Miktarı</strong>
                                </p>
                            </td>
                            <td class="w10c"
                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                <p><strong>Bu Hakediş Miktarı</strong>
                                </p>
                            </td>
                        </tr>
                        <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>
                        <?php $i = 1; ?>
                        <?php foreach ($contract_items as $contract_item) { ?>
                            <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                            <?php $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total"); ?>
                            <?php $this_total = isset($calculate->total) ? $calculate->total : 0; ?>

                            <tr>
                                <td class="w5c total-group-row-center"><?php echo $i++; ?>
                                </td>
                                <td class="w15 total-group-row-left">
                                    <?php echo($contract_item->code); ?>
                                </td>
                                <td class="w35 total-group-row-left">
                                    <?php echo($contract_item->name); ?>
                                </td>
                                <td class="w5c total-group-row-center">
                                    <?php echo($contract_item->unit); ?>
                                </td>
                                <td class="w10 total-group-row-right">
                                    <?php echo money_format($old_total + $this_total); ?>
                                </td>
                                <td class="w10 total-group-row-right">
                                    <?php echo money_format($old_total); ?>
                                </td>
                                <td class="w10 total-group-row-right">
                                    <?php echo money_format($this_total); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3" style="height: 200px;">
        <div class="h-100 checkbox-checked">
            <h6 class="sub-title">02 - Metraj İcmali</h6>
            <div style="height: 100px;">
                <div class="form-check radio radio-success">
                    <input class="form-check-input" id="green1"
                           data-url="<?php echo base_url("payment/print_green_all/$item->id"); ?>"
                           type="radio" name="green" value="green" checked="">
                    <label class="form-check-label" for="green1">Sıralı Yazdır</label>
                </div>
                <div class="form-check radio radio-success">
                    <input class="form-check-input" id="green2"
                           data-url="<?php echo base_url("payment/print_green_hide_zero/$item->id"); ?>"
                           type="radio" name="green" value="green">
                    <label class="form-check-label" for="green2">Toplamı Sıfır Olanları
                        Gösterme</label>
                </div>
            </div>
            <div class="form-check radio radio-success">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="btn-group btn-group-pill" role="group"
                             aria-label="Basic example">
                            <button class="btn btn-outline-success" name="green"
                                    onclick="handleButtonClick(1)"
                                    type="button"><i class="fa fa-download"></i> İndir
                            </button>
                            <button class="btn btn-outline-success" name="green"
                                    onclick="handleButtonClick(0)"
                                    type="button"><i class="fa fa-file-pdf-o"></i>Önizle
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


