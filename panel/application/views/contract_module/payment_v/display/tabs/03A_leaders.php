<div class="content">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <p style="text-align:center; font-size:14pt;">
                    <strong><?php echo contract_name($item->contract_id); ?></strong>
                </p>
            </div>
            <div class="col-12">
                <p style="text-align:center; font-size:14pt;">
                    <strong>03/A - Pozlar İcmali</strong>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-10">
            </div>
            <div class="col-2">
                <p style="text-align:right; margin-top:3pt; margin-bottom:3pt; widows:0; orphans:0; font-size:10pt;">
                    <strong>Hakediş No : <?php echo $item->hakedis_no; ?></strong>
                </p>
            </div>
        </div>
        <hr>

        <table style="width:100%;">
            <tbody>
            <tr>
                <td rowspan="2"
                    style="width:0.9cm;" class="calculate-header-center">
                    <p><strong>Sıra No</strong></p>
                </td>
                <td rowspan="2"
                    style="width:2cm;" class="calculate-header-center">
                    <p><strong>Poz No</strong></p>
                </td>
                <td rowspan="2"
                    style="width:6.8cm;" class="calculate-header-center">
                    <p><strong>Yapılan İşin Cinsi</strong></p>
                </td>
                <td rowspan="2"
                    style="width:1cm;" class="calculate-header-center">
                    <p><strong>Birimi</strong></p>
                </td>
                <td style="width:1.9cm;" class="calculate-header-center">
                    <p><strong>A</strong></p>
                </td>
                <td style="width:1.9cm;" class="calculate-header-center">
                    <p><strong>B</strong></p>
                </td>
                <td style="width:1.9cm;" class="calculate-header-center">
                    <p><strong>C</strong></p>
                </td>
                <td style="width:1.9cm;" class="calculate-header-center">
                    <p><strong>D=B-C</strong>
                    </p>
                </td>
                <td style="width:1.9cm;" class="calculate-header-center">
                    <p><strong>E=AxB</strong>
                    </p>
                </td>
                <td style="width:1.9cm;" class="calculate-header-center">
                    <p><strong>F=AxC</strong></p>
                </td>
                <td style="width:1.9cm;" class="calculate-header-center">
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
            <?php $i = 1; ?>
            <?php $total_A = 0;
            $total_B = 0;
            $total_C = 0;
            ?>
            <?php foreach ($leaders as $leader) { ?>
                <tr>
                    <td class="w5c total-group-row-center">
                        <p><strong><?php echo $i++; ?></strong></p>
                    </td>
                    <td class="w10c total-group-row-center">
                        <p><strong><?php echo $leader->code; ?></strong></p>
                    </td>
                    <td class="w20c total-group-row-left">
                        <p><strong><?php echo $leader->name; ?></strong></p>
                    </td>
                    <td class="w5c total-group-row-center">
                        <p><strong><?php echo $leader->unit; ?></strong></p>
                    </td>
                    <td class="w10c total-group-row-center">
                        <p><strong><?php echo $leader->price . " " . $contract->para_birimi; ?> </strong></p>
                    </td>
                    <?php $calculate = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no" => $item->hakedis_no, "leader_id" => $leader->id), "total"); ?>
                    <?php $old_total = $this->Boq_model->sum_all(array('contract_id' => $item->contract_id, "payment_no <" => $item->hakedis_no, "leader_id" => $leader->id), "total"); ?>
                    <?php $this_total = !empty($calculate) ? $calculate : 0; ?>
                    <?php $total_A += $old_total*$leader->price + $this_total*$leader->price;
                    $total_B += $old_total*$leader->price;
                    $total_C += $this_total*$leader->price; ?>

                    <td class="total-group-row-right">
                        <?php echo money_format($old_total + $this_total); ?>
                    </td>
                    <td class="total-group-row-right">
                        <?php echo money_format($old_total); ?>
                    </td>
                    <td class="total-group-row-right">
                        <?php echo money_format($this_total); ?>
                    </td>
                    <td class="total-group-row-right">
                        <?php echo money_format($old_total*$leader->price + $this_total*$leader->price); ?>
                    </td>
                    <td class="total-group-row-right">
                        <?php echo money_format($old_total*$leader->price); ?>
                    </td>
                    <td class="total-group-row-right">
                        <?php echo money_format($this_total*$leader->price); ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="8"></td>
                <td class="total-group-row-right">
                    <?php echo money_format($total_A); ?>
                </td>
                <td class="total-group-row-right">
                    <?php echo money_format($total_B); ?>
                </td>
                <td class="total-group-row-right">
                    <?php echo money_format($total_C); ?>
                </td>
            </tr>

            </tfoot>
        </table>
    </div>
</div>
