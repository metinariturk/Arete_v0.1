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
        <div class="table-responsive signal-table">
            <table>
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
                                        <b><?php echo $main_group->code . "." . $sub_group->code . " - " . $sub_group->name; ?></b>
                                    </td>
                                </tr>
                                <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>
                                <?php foreach ($contract_items as $contract_item) { ?>
                                    <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                                    <?php if (isset($calculate)) { ?>
                                        <tr>
                                            <td class="w100l" colspan="7">
                                                <?php if ($contract_item->type == "rebar") { ?>
                                                    <a href="<?php echo base_url("boq/template_download_rebar/$item->contract_id/$item->id/$contract_item->id"); ?>" ><i class="fa fa-download fa-lg"></i></a>
                                                <?php } else { ?>
                                                    <a href="<?php echo base_url("boq/template_download/$item->contract_id/$item->id/$contract_item->id"); ?>" ><i class="fa fa-download fa-lg"></i></a>
                                                <?php } ?>

                                                <b><?php echo $contract_item->code . " - " . $contract_item->name . " - " . $contract_item->unit; ?></b>

                                            </td>
                                        </tr>
                                        <tr style="height:14.1pt;">
                                            <td class="w5c"
                                                style="background-color:#e7e7e7;  border-width:0.75pt;">
                                                <p><strong>Mahal</strong></p>
                                            </td>
                                            <td class="w15c"
                                                style="background-color:#e7e7e7;  border-width:0.75pt;">
                                                <p><strong>Açıklama</strong></p>
                                            </td>
                                            <td class="w35c"
                                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                                <?php if ($contract_item->type == "rebar") { ?>
                                                    <p><strong>Çap</strong></p>
                                                <?php } else { ?>
                                                    <p><strong>Adet</strong></p>
                                                <?php } ?>
                                            </td>

                                            <td class="w5c"
                                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                                <?php if ($contract_item->type == "rebar") { ?>
                                                    <p><strong>Benzer</strong></p>
                                                <?php } else { ?>
                                                    <p><strong>En</strong></p>
                                                <?php } ?>
                                            </td>
                                            <td class="w10c"
                                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                                <?php if ($contract_item->type == "rebar") { ?>
                                                    <p><strong>Adet</strong></p>
                                                <?php } else { ?>
                                                    <p><strong>Boy</strong></p>
                                                <?php } ?>
                                            </td>
                                            <td class="w10c"
                                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                                <?php if ($contract_item->type == "rebar") { ?>
                                                    <p><strong>Uzunluk</strong></p>
                                                <?php } else { ?>
                                                    <p><strong>Yükseklik</strong></p>
                                                <?php } ?>
                                            </td>
                                            <td class="w10c"
                                                style="background-color:#e7e7e7; border-width:0.75pt;">
                                                <p><strong>Toplam</strong>
                                                </p>
                                            </td>
                                        </tr>

                                        <?php foreach (json_decode($calculate->calculation, true) as $calculation_data) { ?>
                                            <tr>
                                                <td class="w15 total-group-row-left">
                                                    <?php echo $calculation_data["s"]; ?>
                                                </td>
                                                <td class="w35 total-group-row-left">
                                                    <?php echo $calculation_data["n"]; ?>
                                                </td>
                                                <td class="w5c total-group-row-center">
                                                    <?php if ($contract_item->type == "rebar") { ?>
                                                        Ø <?php }?><?php echo money_format($calculation_data["q"]); ?>
                                                </td>
                                                <td class="w10 total-group-row-right">
                                                    <?php echo money_format($calculation_data["w"]); ?>
                                                </td>
                                                <td class="w10 total-group-row-right">
                                                    <?php echo money_format($calculation_data["h"]); ?>
                                                </td>
                                                <td class="w10 total-group-row-right">
                                                    <?php echo money_format($calculation_data["l"]); ?>
                                                </td>
                                                <td class="w10 total-group-row-right">
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
</div>



