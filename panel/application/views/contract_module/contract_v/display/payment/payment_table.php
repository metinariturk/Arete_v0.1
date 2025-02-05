<table class="table-lg" id="paymentTable">
    <thead>
    <tr>
        <th><p>Hakediş No</p></th>
        <th><p>Hakediş İtibar Tarihi</p></th>
        <th><p>Hakediş Tutar</p></th>
        <th><p>Kesinti</p></th>
        <th><p>Net Ödenecek</p></th>
        <th><p>Düzenle</p></th>
        <th><p>Çıktı Al</p></th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($payments)) { ?>
        <?php foreach ($payments as $payment) { ?>
            <tr id="center_row">
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo str_pad($payment->hakedis_no, 2, "0", STR_PAD_LEFT); ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo dateFormat_dmy($payment->imalat_tarihi); ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo money_format($payment->E); ?><?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo money_format($payment->I); ?><?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("payment/file_form/$payment->id"); ?>">
                        <p><?php echo money_format($payment->balance); ?><?php echo "$item->para_birimi"; ?></p>
                    </a>
                </td>
                <td>
                    <?php if (last_payment($item->id) == $payment->hakedis_no) { ?>
                        <a data-bs-toggle="modal" class="text-primary"
                           id="open_edit_payment_modal_<?php echo $payment->id; ?>"
                           onclick="edit_modal_form('<?php echo base_url("Contract/open_edit_payment_modal/$payment->id"); ?>','edit_payment_modal','EditPaymentModal')">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                    <?php } ?>
                </td>
                <td>
                    <a href="<?php echo base_url("Export/print_payment_all/$payment->id/new_tab"); ?>" target="_blank"
                       title="Hakediş Gör">
                        <i class="fa fa-file fa-lg"></i>
                    </a>
                    <a href="<?php echo base_url("Export/print_payment_all/$payment->id/download"); ?>" target="_blank"
                       title="Hakediş İndir">
                        <i class="fa fa-download fa-lg"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td><p>TOPLAM</p></td>
        <td></td>
        <td>
            <p><?php echo money_format(sum_anything("payment", "E", "contract_id", $item->id)); ?><?php echo "$item->para_birimi"; ?></p>
        </td>
        <td>
            <p><?php echo money_format(sum_anything("payment", "H", "contract_id", $item->id)); ?><?php echo "$item->para_birimi"; ?></p>
        </td>
        <td>
            <p><?php echo money_format(sum_anything("payment", "balance", "contract_id", $item->id)); ?><?php echo "$item->para_birimi"; ?></p>
        </td>

    </tr>
    </tfoot>
</table>

