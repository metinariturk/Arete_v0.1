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
                            <?php echo money_format($foundItem->total + $old_total); ?>
                        </td>
                        <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                            <?php echo money_format($old_total); ?>
                        </td>
                        <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                            <?php echo money_format($foundItem->total); ?>
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
                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                        <?php echo money_format($old_total); ?>
                    </td>
                    <td style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                        <?php echo money_format($old_total); ?>
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



