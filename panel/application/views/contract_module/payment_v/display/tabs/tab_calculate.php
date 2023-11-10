<div class="tab-pane fade <?php if (empty($active_tab)) {
    echo "active show";
} ?>"
     id="calculate" role="tabpanel"
     aria-labelledby="calculate-tab">

    <div class="col-sm-8 offset-sm-2">
        <div class="content">
            <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                <tbody>
                <tr>
                    <td style="width:524.2pt; padding-right:2.85pt; padding-left:2.85pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; widows:0; orphans:0; font-size:10pt;">
                            <img class="img-fluid for-dark d-none" width="200px"
                                 src="<?php echo base_url(); ?>/assets/images/logo/logo_dark.png" alt="">

                    </td>
                </tr>
                </tbody>
            </table>

            <p style="text-align:center; font-size:14pt;">
                <strong><?php echo contract_name($item->contract_id); ?></strong>
            </p>
            <p style="text-align:center; font-size:14pt;">
                <strong>METRAJ CETVELİ</strong>
            </p>
            <table style="width:100%;">
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
                    </td>
                    <td style="text-align:right; font-size:9pt;">
                        <strong>Hakediş No :</strong>
                    </td>
                    <td style="text-align:left; font-size:9pt; padding-left: 5px ">
                        <strong><?php echo $item->hakedis_no; ?> No'lu Hakediş</strong>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
        <?php foreach ($main_groups as $main_group) { ?>
            <table style="width:100%;">
                <thead>
                <tr>
                    <td>
                        <p style="font-size:12pt;">
                            <strong><?php echo $main_group->code . "." . $main_group->name; ?></strong></p>
                    </td>
                </tr>
                </thead>
            </table>

            <?php $sub_groups = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_group" => 1, "parent" => $main_group->id)); ?>
            <?php foreach ($sub_groups as $sub_group) { ?>
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <td>
                            <p style="font-size:10pt;">
                                <strong><?php echo $sub_group->code . "." . $sub_group->name; ?></strong></p>
                        </td>
                    </tr>
                    </thead>
                </table>
                <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>
                <?php foreach ($contract_items as $contract_item) { ?>
                    <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                    <table style="width:100%;">
                        <thead>
                        <tr>
                            <td colspan="7">
                                <p style="font-size:9pt;">
                                    <strong><?php echo $contract_item->code . "." . $contract_item->name . "." . $contract_item->unit; ?></strong>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:10%; background-color:#e7e7e7; text-align: center">
                                <p><strong>Bölüm</strong></p>
                            </td>
                            <td style="width:40%; background-color:#e7e7e7; text-align: center"
                            ">
                            <p><strong>Açıklama</strong></p>
                            </td>
                            <td style="width:8%; background-color:#e7e7e7; text-align: center"
                            ">
                            <p><strong>Adet</strong></p>
                            </td>
                            <td style="width:8%; background-color:#e7e7e7; text-align: center"
                            ">
                            <p><strong>En</strong></p>
                            </td>
                            <td style="width:8%; background-color:#e7e7e7; text-align: center"
                            ">
                            <p><strong>Boy</strong></p>
                            </td>
                            <td style="width:8%; background-color:#e7e7e7; text-align: center"
                            ">
                            <p><strong>Yükseklik</strong></p>
                            </td>
                            <td style="width:18%; background-color:#e7e7e7; text-align: center"
                            ">
                            <p><strong>Toplam</strong></p>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach (json_decode($calculate->calculation, true) as $calculation_data) { ?>
                            <tr>
                                <td style="border-style:solid; text-align:left; border-width:0.75pt;">
                                    <?php echo $calculation_data["s"]; ?>
                                </td>
                                <td style="border-style:solid; border-width:0.75pt; text-align:left; font-size:9pt;">
                                    <?php echo $calculation_data["n"]; ?>
                                </td>
                                <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($calculation_data["q"]); ?>
                                </td>
                                <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($calculation_data["w"]); ?>
                                </td>
                                <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($calculation_data["h"]); ?>
                                </td>
                                <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($calculation_data["l"]); ?>
                                </td>
                                <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($calculation_data["t"]); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <div>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_sign"); ?>
        </div>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_calculate/$item->id"); ?>">Tümünü
            Yazdır</a>
        <a class="btn btn-primary" target="_blank"
           href="<?php echo base_url("payment/print_calculate/$item->id/1"); ?>">Grupları Ayır</a>
    </div>

</div>



