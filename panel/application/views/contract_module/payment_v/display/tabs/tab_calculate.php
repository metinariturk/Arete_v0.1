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
        <?php foreach ($active_boqs as $group_key => $boq_ids) { ?>
            <?php foreach ($boq_ids as $boq_id) { ?>
                <?php foreach ($calculates as $calculation_item) { ?>
                    <?php if ($calculation_item->boq_id == $boq_id) { ?>
                        <table style="width:100%;">
                            <thead>
                            <tr>
                                <td>
                                    <p style="margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                                        <strong><?php echo boq_name($group_key); ?></strong></p>
                                </td>
                            </tr>
                            </thead>
                        </table>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <?php foreach ($boq_ids as $boq_id) { ?>
                <?php foreach ($calculates as $calculation_item) { ?>
                    <?php if ($calculation_item->boq_id == $boq_id) { ?>
                        <table style="width:100%;">
                            <thead>
                            <tr>
                                <td>
                                    <p style="margin:3pt 2.85pt; page-break-inside:avoid; page-break-after:avoid; widows:0; orphans:0; font-size:9pt;">
                                        <strong><?php echo boq_name($boq_id) . " " . boq_unit($boq_id); ?></strong>
                                        <?php $calculation_datas = json_decode($calculation_item->calculation, true); ?>

                                    <table style="width:100%;">
                                        <thead>
                                        <tr style="height:14.1pt;">
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
                                        <?php foreach ($calculation_datas as $calculation_data) { ?>
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
                                        <tr>
                                            <td colspan="5">
                                            </td>
                                            <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                                <strong>Toplam</strong>
                                            </td>
                                            <td style="border-style:solid; border-width:0.75pt; text-align:right; font-size:9pt;">
                                                <strong><?php echo $calculation_item->total; ?></strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </thead>
                        </table>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <div>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_sign"); ?>
        </div>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_calculate/$item->id"); ?>">Önizleme</a>
    </div>

</div>



