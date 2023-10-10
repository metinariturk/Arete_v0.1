<div class="row content-container">
    <table class="table table-bordered table-striped table-hover pictures_list">
        <thead>
        <th>#id</th>
        <th>Sözleşme Adı</th>
        <th>Bağlı Şantiye</th>
        <th>Sözleşme Bedel</th>
        <th>Toplam Hakediş</th>
        <th class="w20c">Gerçekleşme Oran</th>
        </thead>
        <tbody>
        <?php $i = 0;
        foreach ($subcontracts as $subcontract) { ?>
            <tr>
                <td><?php echo $subcontract->id; ?></td>
                <td>
                    <a href="<?php echo base_url("contract/file_form/$subcontract->id"); ?>"><?php echo $subcontract->sozlesme_ad; ?></a>
                </td>
                <td>
                    <?php $connected_site = get_from_any("contract", "site_id", "id", $subcontract->id); ?>
                    <?php if (isset($connected_site)) { ?>
                        <a href="<?php echo base_url("site/file_form/$connected_site"); ?>"><?php echo site_name($connected_site); ?></a>
                    <?php } ?>
                </td>
                <td><?php echo money_format($subcontract->sozlesme_bedel) . " " . get_currency($subcontract->id); ?></td>
                <td><?php echo money_format(sum_from_table("payment", "bu_imalat_ihzarat", "$subcontract->id")) . " " . get_currency($subcontract->id); ?></td>
                <td>
                    % <?php echo money_format(100 * sum_from_table("payment", "bu_imalat_ihzarat", "$subcontract->id") / $subcontract->sozlesme_bedel); ?></td>
            </tr>
        <?php } ?>
        <?php if (sum_selected("contract", "proje_id", "para_birimi", $item->id, "TL", "sozlesme_bedel") > 0) { ?>
            <tr>
                <td colspan="3"><strong>Toplam TL</strong></td>
                <td>
                    <?php
                    $total_sub_cont = sum_anything_and_and_and("contract", "sozlesme_bedel", "proje_id", "$item->id", "para_birimi", "TL", "subcont", "1");
                    echo money_format($total_sub_cont) . " TL";
                    ?>
                </td>
                <td><?php
                    $total_payment_sub_cont = sum_connected_contract_payments_ci(array_column($subcontracts, 'id'), "TL");
                    echo money_format($total_payment_sub_cont) . " " . "TL"; ?>
                </td>
                <td>% <?php echo money_format(100 * $total_payment_sub_cont / $total_sub_cont); ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ((sum_connected_contract_payments_ci(array_column($subcontracts, "id"), "Dolar")) > 0) { ?>
            <tr>
                <td colspan="2"><strong>Toplam Dolar</strong></td>
                <td>
                    <?php
                    $total_sub_cont = sum_anything_and_and_and("contract", "sozlesme_bedel", "proje_id", "$item->id", "para_birimi", "Dolar", "subcont", "1");
                    echo money_format($total_sub_cont) . " Dolar";
                    ?>
                </td>
                <td><?php
                    $total_payment_sub_cont = sum_connected_contract_payments_ci(array_column($subcontracts, 'id'), "Dolar");
                    echo money_format($total_payment_sub_cont) . " " . "Dolar"; ?>
                </td>
                <td>% <?php echo money_format(100 * $total_payment_sub_cont / $total_sub_cont); ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ((sum_connected_contract_payments_ci(array_column($subcontracts, "id"), "Euro")) > 0) { ?>
            <tr>
                <td colspan="2"><strong>Toplam Euro</strong></td>
                <td>
                    <?php
                    $total_sub_cont = sum_anything_and_and_and("contract", "sozlesme_bedel", "proje_id", "$item->id", "para_birimi", "Euro", "subcont", "1");
                    echo money_format($total_sub_cont) . " Euro";
                    ?>
                </td>
                <td><?php
                    $total_payment_sub_cont = sum_connected_contract_payments_ci(array_column($subcontracts, 'id'), "Euro");
                    echo money_format($total_payment_sub_cont) . " " . "Euro"; ?>
                </td>
                <td>% <?php echo money_format(100 * $total_payment_sub_cont / $total_sub_cont); ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
