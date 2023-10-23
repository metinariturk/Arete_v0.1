<div class="fade tab-pane <?php if ($active_tab == "green") {
    echo "active show";
} ?>"
     id="green" role="tabpanel"
     aria-labelledby="green-tab">
    <div class="col-sm-8 offset-sm-2">
        <div class="content">
            <p style="text-align:center; font-size:14pt;">
                <strong><?php echo contract_name($item->contract_id); ?></strong>
            </p>
            <p style="text-align:center; font-size:14pt;">
                <strong>METRAJ İCMALİ</strong>
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
        <div>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_sign"); ?>
        </div>
    </div>
</div>
<form id="green" target="_blank"
      action="<?php echo base_url("payment/print/$item->id/green"); ?>" method="post"
      enctype="multipart/form-data" autocomplete="off">
            <textarea name="body">
                <table style="width:100%;">
                    <thead>
<tr style="height:10px;">
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
                <?php foreach ($active_boqs as $group_key => $boq_ids) { ?>

                    <tr>
                    <td colspan="6" style="width:12%; font-weight: bold; background-color:#e7e7e7; text-align: left; border: 0.75pt solid black;  border-width:0.75pt; font-size:8pt;">
                    <?php echo $group_key . " - " . boq_name($group_key); ?>
                    </td>
                    </tr>


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

                <?php } ?>
                                    </tbody>
                    </table>
            </textarea>
    <button type="submit"
            class="btn btn-success">
        <i class="fa fa-floppy-o fa-lg"></i> Devam
    </button>
</form>


