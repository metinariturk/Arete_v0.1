

<table class="table-lg" id="payment_Table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><p>Hakediş No</p></th>
        <th class="d-none d-sm-table-cell"><p>Hakediş İtibar Tarihi</p></th>
        <th><p>Hakediş Tutar</p></th>
        <th><p>Kesinti</p></th>
        <th class="d-none d-sm-table-cell"><p>Net Ödenecek</p></th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($payments)) { ?>
        <?php foreach ($payments as $payment) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo str_pad($payment->hakedis_no, 2, "0", STR_PAD_LEFT); ?></p>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo dateFormat_dmy($payment->imalat_tarihi); ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo money_format($payment->E); ?> <?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo money_format($payment->I); ?> <?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo money_format($payment->balance); ?> <?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td class="d-none d-sm-table-cell"><p>TOPLAM</p></td>
        <td class="d-none d-sm-table-cell"></td>
        <td>
            <p><?php echo money_format(sum_anything("payment", "E", "contract_id", $item->id)); ?> <?php echo "$item->para_birimi"; ?></p>
        </td>
        <td class="d-none d-sm-table-cell">
            <p><?php echo money_format(sum_anything("payment", "balance", "contract_id", $item->id)); ?> <?php echo "$item->para_birimi"; ?></p>
        </td>
    </tr>
    </tfoot>
</table>
