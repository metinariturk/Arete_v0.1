<div class="row content-container">
    <table class="table table-bordered table-striped table-hover pictures_list">
        <thead>
        <th>#id</th>
        <th>Sözleşme Adı</th>
        <th>Sözleşme Bedel</th>
        <th>Toplam Hakediş</th>
        <th class="w20c">Gerçekleşme Oran</th>
        </thead>
        <tbody>
        <?php $i = 0;
        foreach ($contracts as $contract) { ?>
            <tr>
                <td  style="color: #0b43c6; font-weight: bolder;"><?php echo $contract->id; ?></td>
                <td  style="color: #0b43c6; font-weight: bolder;">
                    <a href="<?php echo base_url("contract/file_form/$contract->id"); ?>"><?php echo $contract->sozlesme_ad; ?></a>
                </td>
                <td style="color: #0b43c6; font-weight: bolder;"><?php echo money_format($contract->sozlesme_bedel) . " " . get_currency($contract->id); ?></td>
                <td  style="color: #0b43c6; font-weight: bolder;"><?php
                    $main_payment_total = sum_from_table("payment", "bu_imalat_ihzarat", "$contract->id");
                    echo money_format($main_payment_total) . " " . get_currency($contract->id); ?></td>
                <td  style="color: #0b43c6; font-weight: bolder;">
                    % <?php echo money_format(100 * sum_from_table("payment", "bu_imalat_ihzarat", "$contract->id") / $contract->sozlesme_bedel); ?></td>
            </tr>
        <?php } ?>

        <?php $j = "a";
        $subcontracts = $this->Contract_model->get_all(array(
            "main_contract" => $contract->id,
        )); ?>
        <?php $i = 0;
        $sub_total_payment = 0;
        foreach ($subcontracts as $subcontract) { ?>
            <tr>
                <td style="color: #a43207; font-weight: bolder;"><?php echo $subcontract->id; ?></td>
                <td  style="color: #a43207; font-weight: bolder; text-align: right">
                    <a href="<?php echo base_url("contract/file_form/$subcontract->id"); ?>">
                        <?php echo $j . ' ';
                        $j = chr(ord($j) + 1); ?> -  <?php echo $subcontract->sozlesme_ad; ?>
                    </a>
                </td>
                <td style="color: #a43207; font-weight: bolder;"><?php echo money_format($subcontract->sozlesme_bedel) . " " . get_currency($subcontract->id); ?></td>
                <td  style="color: #a43207; font-weight: bolder;">-<?php $sub_cont_payment = sum_from_table("payment", "bu_imalat_ihzarat", "$subcontract->id");
                echo money_format($sub_cont_payment) . " " . get_currency($subcontract->id); ?></td>
                <td  style="color: #a43207; font-weight: bolder;">
                    % <?php echo money_format(100 * sum_from_table("payment", "bu_imalat_ihzarat", "$subcontract->id") / $subcontract->sozlesme_bedel); ?></td>
            </tr>
            <?php $sub_total_payment = $sub_total_payment + $sub_cont_payment; ?>
        <?php } ?>
            <tr>
                <td colspan="3">
                   TOPLAM
                </td>
                <td>
                    <?php $earning = $main_payment_total - $sub_total_payment;
                    echo money_format($earning) . " " . get_currency($contract->id);?>
                </td>
            </tr>
        </tbody>
    </table>
</div>

