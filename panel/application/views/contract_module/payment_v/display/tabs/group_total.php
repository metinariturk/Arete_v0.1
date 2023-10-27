<div class="fade tab-pane <?php if ($active_tab == "group_total") {
    echo "active show";
} ?>"
     id="group_total" role="tabpanel"
     aria-labelledby="group_total-tab">
    <div class="col-sm-10 offset-1">
        <div class="content">
            <p style="text-align:center; font-size:14pt;">
                <strong><?php echo contract_name($item->contract_id); ?></strong>
            </p>
            <p style="text-align:center; font-size:14pt;">
                <strong>YAPILAN İŞLER GRUP İCMALLERİ</strong>
            </p>
            <table>
                <tbody>
                <tr>
                    <td colspan="5" class ="w-72">
                    </td>
                    <td style="text-align:right; font-size:9pt;">
                        <strong>Sayfa No :</strong>
                    </td>
                    <td style="text-align:left; font-size:9pt; padding-left: 5px">
                        <strong>1</strong>
                    </td>
                </tr>
                <tr>
                    <td  colspan="5" class ="w- 30">
                        <p style="margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                            <strong><?php echo mb_strtoupper(contract_name($item->contract_id)); ?></strong>
                        </p>
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
        <table class ="w-100;">
            <thead>
            <tr>
                <td colspan="7">
                    <p style="margin-top:3pt; width:100%; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                    </p>
                </td>
            </tr>
            <tr style="height:14.1pt;">
                <td class ="w-3 total-group-header-center">
                    <p><strong>Sıra No</strong></p>
                </td>
                <td class ="w-9 total-group-header-center">
                    <p><strong>Grup Kodu</strong></p>
                </td>
                <td class ="w-25 total-group-header-center">
                    <p><strong>Grup Adı</strong></p>
                </td>
                <td class ="w-4 total-group-header-center">
                    <p><strong>Yapılan İşler Toplamı</strong></p>
                </td>
                <td class ="w-8 total-group-header-center">
                    <p><strong>Önceli Hakediş Toplamı</strong></p>
                </td>
                <td class ="w-8 total-group-header-center">
                    <p><strong>Bu Hakediş Toplamı</strong></p>
                </td>
            </tr>
            </thead>
            <tbody>
        <?php foreach ($active_boqs as $group_key => $boq_ids) { ?>
            <?php
            $all_time = 0;
            $old_time = 0;
            $this_time = 0;
            ?>
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
                <?php if (!empty($foundItems)) { ?>
                    <?php foreach ($foundItems as $foundItem) { ?>
                        <?php $price = (float)$prices[$group_key][$boq_id]['price'];
                        if (!isset($price)) {
                            $price = 0;
                        } ?>
                        <?php $all_time = $all_time + ($foundItem->total + $old_total) * $price; ?>
                        <?php $old_time = $old_time + ($old_total * $price); ?>
                        <?php $this_time = $all_time - $old_time; ?>
                    <?php } ?>
                <?php } else { ?>
                    <?php foreach ($foundItems as $foundItem) { ?>
                        <?php $price = (float)$prices[$group_key][$boq_id]['price'];
                        if (!isset($price)) {
                            $price = 0;
                        } ?>
                        <?php $all_time = $all_time + ($old_total * $price); ?>
                        <?php $old_time = $old_time + ($old_total * $price); ?>
                        <?php $this_time = $all_time - $old_time; ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <tr style="height:14.1pt;">
                <td class ="w-3 total-group-row-center">
                    <p><strong> # </strong></p>
                </td>
                <td class ="w-9 total-group-row-center">
                    <p><strong><?php echo $group_key; ?></strong></p>
                </td>
                <td class ="w-25 total-group-row-left">
                    <p><strong><?php echo boq_name($group_key); ?></strong></p>
                </td>
                <td class ="w-4 total-group-row-right">
                    <p><strong><?php echo money_format($all_time); ?></strong></p>
                </td>
                <td class ="w-8 total-group-row-right">
                    <p><strong><?php echo money_format($old_time); ?></strong></p>
                </td>
                <td class ="w-8 total-group-row-right">
                    <p><strong><?php echo money_format($this_time); ?></strong></p>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/0"); ?>">Önizleme</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/1"); ?>">Sıfır Olanları Gizle</a>
        <a class="btn btn-primary" target="_blank" href="<?php echo base_url("payment/print_green/$item->id/2"); ?>">Sadece Bu Hakediş</a>
    </div>
</div>