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
                <strong>METRAJ İCMALİ</strong>
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
                <tr style="height:14.1pt;">
                    <td rowspan="2"
                        style="width:3%; background-color:#e7e7e7; text-align: center;  border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Sıra No</strong></p>
                    </td>
                    <td rowspan="2"
                        style="width:9%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Poz No</strong></p>
                    </td>
                    <td rowspan="2"
                        style="width:25%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Yapılan İşin Cinsi</strong></p>
                    </td>

                    <td rowspan="2"
                        style="width:4%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Birimi</strong></p>
                    </td>
                    <td style="width:8%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>A</strong></p>
                    </td>
                    <td style="width:8%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>B</strong></p>
                    </td>
                    <td style="width:8%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>C</strong>
                        </p>
                    </td>
                    <td style="width:8%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>D=B-C</strong>
                        </p>
                    </td>
                    <td style="width:9%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>E=AxB</strong>
                        </p>
                    </td>
                    <td style="width:9%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>F=AxC</strong>
                        </p>
                    </td>
                    <td style="width:9%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>G=E-F</strong>
                        </p>
                    </td>
                </tr>
                <tr style="height:14.1pt;">
                    <td style="background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Tekif Birim Fiyatı</strong></p>
                    </td>
                    <td style="background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Toplam Miktarı</strong></p>
                    </td>
                    <td style="background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Önceki Hakediş Miktarı</strong>
                        </p>
                    </td>
                    <td style="background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Bu Hakediş Miktarı</strong>
                        </p>
                    </td>
                    <td style="background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Toplam İmalat İhzarat</strong>
                        </p>
                    </td>
                    <td style="background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Bir Önceki Tutarı</strong>
                        </p>
                    </td>
                    <td style="background-color:#e7e7e7; text-align: center; border: 0.75pt solid black; border-width:0.75pt;">
                        <p><strong>Bu Hakediş</strong>
                        </p>
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
                                <td style="border: 0.75pt solid black; text-align:center; border-width:0.75pt;">
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
                                    <?php $price = (float)$prices[$group_key][$boq_id]['price'];

                                    if (!isset($price)) {
                                        $price = 0;
                                    }

                                    echo money_format($price);

                                    ?>
                                </td>
                                <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php $all_time = ($foundItem->total + $old_total);
                                    echo money_format($all_time); ?>
                                </td>
                                <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($old_total); ?>
                                </td>
                                <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($foundItem->total); ?>
                                </td>
                                <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($price * $all_time); ?>
                                </td>
                                <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($price * $old_total); ?>
                                </td>
                                <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                    <?php echo money_format($price * $foundItem->total); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td style="border: 0.75pt solid black; text-align:center; border-width:0.75pt;">
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
                            <?php $price = (float)$prices[$group_key][$boq_id]['price']; ?>
                            <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;"
                                class="<?php if (empty($price)) {
                                    echo "bg-danger";
                                } ?>">
                                <?php
                                if (!isset($price)) {
                                    $price = 0;
                                }
                                echo money_format($price);

                                ?>
                            </td>
                            <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($old_total); ?>
                            </td>
                            <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($old_total); ?>
                            </td>
                            <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                0.00
                            </td>
                            <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($price * $old_total); ?>
                            </td>
                            <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($price * $old_total); ?>
                            </td>
                            <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                0.00
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





