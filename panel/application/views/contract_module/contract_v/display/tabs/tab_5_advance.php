<table class="table-lg" id="advance_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell w5"><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell w15"><p>Dosya No</p></th>
        <th class="d-none d-sm-table-cell w20"><p>Ödeme Tarihi</p></th>
        <th class="w20"><p>Ödeme Tutarı</p></th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($advances)) { ?>
        <?php foreach ($advances as $advance) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <p><?php echo $advance->id; ?></p>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a target="_blank" href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                        <p><?php echo $advance->dosya_no; ?></p>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a target="_blank" href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                        <p><?php echo dateFormat_dmy($advance->avans_tarih); ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                        <p><?php echo money_format($advance->avans_miktar) . " " . get_currency($item->id); ?></p>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"><p>TOPLAM</p></td>
        <td>
            <p><?php echo money_format(sum_anything("advance", "avans_miktar", "contract_id", $item->id)); ?> <?php echo "$item->para_birimi"; ?></p>
        </td>
    </tr>
    </tfoot>
</table>
