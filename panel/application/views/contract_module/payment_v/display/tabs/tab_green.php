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
        <?php foreach ($main_groups as $main_group) { ?>
        <table style="width:100%;">
            <thead>
            <tr>
                <td colspan="7">
                    <p style="margin-top:3pt; width:100%; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                        <strong><?php echo $main_group->code . " - " . $main_group->name; ?></strong>
                    </p>
                </td>
            </tr>

            </thead>
            <tbody>

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
                <table style="width:100%;">
                    <tbody>
                    <tr style="height:14.1pt;">
                        <td class="w5c" style="background-color:#e7e7e7; border: 0.75pt solid black; border-width:0.75pt;">
                            <p><strong>Sıra No</strong></p>
                        </td>
                        <td class="w15c" style="background-color:#e7e7e7; border: 0.75pt solid black; border-width:0.75pt;">
                            <p><strong>Poz No</strong></p>
                        </td>
                        <td class="w35c" style="background-color:#e7e7e7;  border: 0.75pt solid black; border-width:0.75pt;">
                            <p><strong>Yapılan İşin Cinsi</strong></p>
                        </td>

                        <td class="w5c" style="background-color:#e7e7e7;  border: 0.75pt solid black; border-width:0.75pt;">
                            <p><strong>Birimi</strong></p>
                        </td>
                        <td class="w10c" style="background-color:#e7e7e7;  border: 0.75pt solid black; border-width:0.75pt;">
                            <p><strong>Toplam Miktarı</strong></p>
                        </td>
                        <td class="w10c" style="background-color:#e7e7e7; border: 0.75pt solid black; border-width:0.75pt;">
                            <p><strong>Önceki Hakediş Miktarı</strong>
                            </p>
                        </td>
                        <td class="w10c" style="background-color:#e7e7e7;  border: 0.75pt solid black; border-width:0.75pt;">
                            <p><strong>Bu Hakediş Miktarı</strong>
                            </p>
                        </td>
                    </tr>
                    <?php $contract_items = $this->Contract_price_model->get_all(array('contract_id' => $item->contract_id, "sub_id" => $sub_group->id)); ?>
                    <?php $i = 1; ?>
                    <?php foreach ($contract_items as $contract_item) { ?>
                        <?php $calculate = $this->Boq_model->get(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "boq_id" => $contract_item->id)); ?>
                        <?php $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "boq_id" => $contract_item->id), "total"); ?>
                        <?php $this_total = isset($calculate->total) ? $calculate->total : 0; ?>

                        <tr>
                            <td class="w5c" style="border: 0.75pt solid black; border-width:0.75pt;"><?php echo $i++; ?>
                            </td>
                            <td  class="w15" style="border: 0.75pt solid black; border-width:0.75pt; text-align:center; font-size:9pt;">
                                <?php echo($contract_item->code); ?>
                            </td>
                            <td  class="w35" style="border: 0.75pt solid black; border-width:0.75pt; text-align:left; font-size:9pt;">
                                <?php echo($contract_item->name); ?>
                            </td>
                            <td  class="w5c" style="border: 0.75pt solid black; border-width:0.75pt; font-size:9pt;">
                                <?php echo($contract_item->unit); ?>
                            </td>
                            <td  class="w10" style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($old_total + $this_total); ?>
                            </td>
                            <td  class="w10" style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($old_total); ?>
                            </td>
                            <td  class="w10" style="border: 0.75pt solid black; border-width:0.75pt; text-align:right; font-size:9pt;">
                                <?php echo money_format($this_total); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
            <?php } ?>
            <div>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/tabs/tab_sign"); ?>
            </div>
            <a class="btn btn-primary" target="_blank"
               href="<?php echo base_url("payment/print_green/$item->id/0"); ?>">Önizleme</a>
            <a class="btn btn-primary" target="_blank"
               href="<?php echo base_url("payment/print_green/$item->id/1"); ?>">Sıfır Olanları Gizle</a>
            <a class="btn btn-primary" target="_blank"
               href="<?php echo base_url("payment/print_green/$item->id/2"); ?>">Sadece Bu Hakediş</a>

    </div>
</div>


