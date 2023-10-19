<div class="fade tab-pane <?php if ($active_tab == "green") {
    echo "active show";
} ?>"
     id="green" role="tabpanel"
     aria-labelledby="green-tab">
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
                <strong>YEŞİL DEFTER</strong>
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
                        <p style="margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                            <strong><?php echo mb_strtoupper(contract_name($item->contract_id)); ?></strong></p>
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
            <?php $i = 1; ?>
            <table style="width:100%;">
                <thead>
                <tr>
                    <td colspan="7">
                        <p style="margin-top:3pt; width:100%; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                            <strong><?php echo $group_key . " - " . boq_name($group_key); ?></strong>
                        </p>
                    </td>
                </tr>
                <tr style="height:14.1pt;">
                    <td style="width:5%; background-color:#e7e7e7; text-align: center;  border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Sıra No</strong></p>
                    </td>
                    <td style="width:10%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Poz No</strong></p>
                    </td>
                    <td style="width:40%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Yapılan İşin Cinsi</strong></p>
                    </td>

                    <td style="width:8%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Birimi</strong></p>
                    </td>
                    <td style="width:13%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Toplam Miktarı</strong></p>
                    </td>
                    <td style="width:12%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Önceki Hakediş Miktarı</strong>
                        </p>
                    </td>
                    <td style="width:12%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Bu Hakediş Miktarı</strong>
                        </p>
                    </td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($boq_ids as $boq_id) { ?>
                    <?php $calculation_item_found = false; ?>
                    <?php foreach ($calculates as $calculation_item) { ?>
                        <?php if ($calculation_item->boq_id == $boq_id) { ?>

                                <tr>
                                    <td style="border: 0.75pt solid black; text-align:center; border-width:0.75pt;">
                                        <?php echo $i;
                                        $i++; ?>
                                    </td>
                                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:center; font-size:9pt;">
                                        <?php echo($boq_id); ?>
                                    </td>
                                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:left; font-size:9pt;">
                                        <?php echo boq_name($boq_id); ?>
                                    </td>
                                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                        <?php echo boq_unit($boq_id); ?>
                                    </td>
                                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    </td>
                                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    </td>
                                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                        <?php echo money_format($calculation_item->total); ?>
                                    </td>
                                </tr>

                        <?php } ?>
                    <?php } ?>
                    <?php if (!$calculation_item_found) { ?>
                        <!-- Handle the case where no calculation item is found for this boq_id -->
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        <div>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_sign"); ?>
        </div>
        <a class="btn btn-primary" href="<?php echo base_url("payment/print/$item->id"); ?>">Önizleme</a>
    </div>
</div>





