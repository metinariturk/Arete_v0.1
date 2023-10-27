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
        <?php foreach ($active_boqs as $group_key => $boq_ids) { ?>
            <table style="width:100%;">
                <thead>
                <tr>
                    <td colspan="7">
                        <p style="margin-top:3pt; width:100%; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                            <strong><?php echo $group_key . " - " . boq_name($group_key); ?></strong>
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
                <?php foreach ($boq_ids as $boq_id) { ?>
                    <?php
                    $foundItems = array_filter($calculates, function ($item) use ($boq_id) {
                        return $item->boq_id == $boq_id;
                    }); ?>

                    <?php $old_total_array = $this->Boq_model->get_all(
                        array(
                            "contract_id" => $item->contract_id,
                            "payment_no <" => $item->hakedis_no,
                            "boq_id" => $boq_id,
                        ),
                    ); ?>
                    <?php if (!empty($old_total_array)) { ?>
                        <?php $old_total = sum_anything_and_and("boq", "total", "contract_id", $item->contract_id, "payment_no <", $item->hakedis_no, "boq_id", "$boq_id"); ?>
                    <?php } else {
                        $old_total = 0;
                    } ?>

                    <?php if (!empty($foundItems)) {
                        // Hedef boq_id bulundu, $foundItems içinde saklanır.
                        foreach ($foundItems as $foundItem) { ?>
                            <tr>
                                <td class="calculate-row-center"></td>
                                <td class="calculate-row-center">
                                    <?php echo($boq_id); ?>
                                </td>
                                <td class="calculate-row-left">
                                    <?php echo boq_name($boq_id); ?>
                                </td>
                                <td class="calculate-row-right">
                                    <?php echo boq_unit($boq_id); ?>
                                </td>
                                <?php
                                if (!isset($price)) {
                                    $price = 0;
                                }
                                if (isset($prices[$group_key][$boq_id]['price'])) {
                                    $price = (float)$prices[$group_key][$boq_id]['price'];
                                }
                                ?>
                                <td class="calculate-row-right <?php if ($price == 0) { echo "bg-danger"; } ?>">
                                    <?php echo money_format($price); ?>
                                </td>
                                <td class="calculate-row-right">
                                    <?php $all_time = ($foundItem->total + $old_total);
                                    echo money_format($all_time);
                                    ?>
                                </td>
                                <td class="calculate-row-right">
                                    <?php echo money_format($old_total); ?>
                                </td>
                                <td class="calculate-row-right">
                                    <?php echo money_format($foundItem->total); ?>
                                </td>
                                <td class="calculate-row-right">
                                    <?php echo money_format($price * $all_time); ?>
                                </td>
                                <td class="calculate-row-right">
                                    <?php echo money_format($price * $old_total); ?>
                                </td>
                                <td class="calculate-row-right">
                                    <?php echo money_format($price * $foundItem->total); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td class="calculate-row-center">
                            </td>
                            <td class="calculate-row-center">
                                <?php echo($boq_id); ?>
                            </td>
                            <td class="calculate-row-left">
                                <?php echo boq_name($boq_id); ?>
                            </td>
                            <td class="calculate-row-right">
                                <?php echo boq_unit($boq_id); ?>
                            </td>

                            <?php
                            if (!isset($price)) {
                                $price = 0;
                            }
                            if (isset($prices[$group_key][$boq_id]['price'])) {
                                $price = (float)$prices[$group_key][$boq_id]['price'];
                            }
                            ?>

                            <td class="calculate-row-right <?php if ($price == 0) { echo "bg-danger"; } ?>">
                                <?php echo money_format($price); ?>
                            </td>
                            <td class="calculate-row-right">
                                <?php echo money_format($old_total); ?>
                            </td>
                            <td class="calculate-row-right">
                                <?php echo money_format($old_total); ?>
                            </td>
                            <td class="calculate-row-right">
                                0,00
                            </td>
                            <td class="calculate-row-right">
                                <?php echo money_format($price * $old_total); ?>
                            </td>
                            <td class="calculate-row-right">
                                <?php echo money_format($price * $old_total); ?>
                            </td>
                            <td class="calculate-row-right">
                                0,00
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/0"); ?>">Önizleme</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/1"); ?>">Sıfır
            Olanları Gizle</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/2"); ?>">Sadece
            Bu Hakediş</a>

    </div>


</div>





