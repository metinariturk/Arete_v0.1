<?php foreach ($active_boqs as $group_key => $boq_ids) { ?>
    <table style="width:100%;">
        <thead>
        <tr>
            <th colspan="7">
                <p style="width:100%; font-size:10pt;">
                    <strong><?php echo $group_key . " - " . boq_name($group_key); ?></strong>
                </p>
            </th>
        </tr>
        <tr style="height:20px;">
            <th style="width:5%; background-color:#e7e7e7; text-align: center;  border: 0.75pt solid black;  border-width:0.75pt; font-size:8pt;;">
                <p><strong>Sıra No</strong></p>
            </th>
            <th style="width:10%; background-color:#e7e7e7; text-align: center;  border: 0.75pt solid black;  border-width:0.75pt; font-size:8pt;">
                <p><strong>Poz No</strong></p>
            </th>
            <th style="width:40%; background-color:#e7e7e7; text-align: center;  border: 0.75pt solid black;  border-width:0.75pt; font-size:8pt;">
                <p><strong>Yapılan İşin Cinsi</strong></p>
            </th>

            <th style="width:8%; background-color:#e7e7e7; text-align: center;  border: 0.75pt solid black;  border-width:0.75pt; font-size:8pt;">
                <p><strong>Birimi</strong></p>
            </th>
            <th style="width:13%; background-color:#e7e7e7; text-align: center;  border: 0.75pt solid black;  border-width:0.75pt; font-size:8pt;">
                <p><strong>Toplam</strong></p>
            </th>
            <th style="width:12%; background-color:#e7e7e7; text-align: center;  border: 0.75pt solid black;  border-width:0.75pt; font-size:8pt;">
                <p><strong>Önceki Hakediş</strong>
                </p>
            </th>
            <th style="width:12%; background-color:#e7e7e7; text-align: center; border: 0.75pt solid black;  border-width:0.75pt; font-size:8pt;">
                <p><strong>Bu Hakediş</strong>
                </p>
            </th>
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
                        <td style="width:5%; border: 0.75pt solid black; text-align:center; border-width:0.75pt;">
                        </td>
                        <td style="width:10%; border: 0.75pt solid black; border-width:0.75pt; text-align:center; font-size:9pt;">
                            <?php echo($boq_id); ?>
                        </td>
                        <td style="width:40%; border: 0.75pt solid black; border-width:0.75pt; text-align:left; font-size:9pt;">
                            <?php echo boq_name($boq_id); ?>
                        </td>
                        <td style="width:8%; border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                            <?php echo boq_unit($boq_id); ?>
                        </td>
                        <td style="width:13%; border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                            <?php echo money_format($foundItem->total + $old_total); ?>
                        </td>
                        <td style="width:12%; border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                            <?php echo money_format($old_total); ?>
                        </td>
                        <td style="width:12%; border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                            <?php echo money_format($foundItem->total); ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td style=" width:5%; border: 0.75pt solid black; text-align:center; border-width:0.75pt;">
                    </td>
                    <td style=" width:10%; border: 0.75pt solid black; border-width:0.75pt; text-align:center; font-size:9pt;">
                        <?php echo($boq_id); ?>
                    </td>
                    <td style=" width:40%; border: 0.75pt solid black; border-width:0.75pt; text-align:left; font-size:9pt;">
                        <?php echo boq_name($boq_id); ?>
                    </td>
                    <td style=" width:8%; border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                        <?php echo boq_unit($boq_id); ?>
                    </td>
                    <td style=" width:13%; border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                        <?php echo money_format($old_total); ?>
                    </td>
                    <td style=" width:12%; border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                        <?php echo money_format($old_total); ?>
                    </td>
                    <td style=" width:12%; border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                        0.00
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>



foreach ($boq_ids as $boq_id) {
    $foundItems = array_filter($calculates, function ($item) use ($boq_id) {
        return $item->boq_id == $boq_id;
    });

   $old_total_array = $this->Boq_model->get_all(
        array(
            "contract_id" => $item->contract_id,
            "payment_no <" => $item->hakedis_no,
            "boq_id" => $boq_id,
        ),
    );
   if (!empty($old_total_array)) { ?>
         $old_total = sum_anything_and_and("boq", "total", "contract_id", $item->contract_id, "payment_no <", $item->hakedis_no, "boq_id", "$boq_id");
     } else {
        $old_total = 0;
    }

     if (!empty($foundItems)) {
        foreach ($foundItems as $foundItem) {
                     echo($boq_id);
                     echo boq_name($boq_id);
                     echo boq_unit($boq_id);
                     echo money_format($foundItem->total + $old_total);
                     echo money_format($old_total);
                     echo money_format($foundItem->total);
         }
     } else {
                 echo($boq_id);
                 echo boq_name($boq_id);
                 echo boq_unit($boq_id);
                 echo money_format($old_total);
                 echo money_format($old_total);
                0.00
     }
 }
