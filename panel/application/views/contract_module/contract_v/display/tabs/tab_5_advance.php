<a class="pager-btn btn btn-info btn-outline"
   href="<?php echo base_url("advance/new_form/$item->id"); ?>" target="_blank">
    <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni
    Avans Ödemesi Ekle
</a>

<table class="table" id="advance_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell w5" ><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell w15">Dosya No</th>
        <th class="d-none d-sm-table-cell w20">Ödeme Tarihi</th>
        <th class="w20">Ödeme Tutarı</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($advances)) { ?>
        <?php foreach ($advances as $advance) { ?>
            <tr id="center_row">
                <td  class="d-none d-sm-table-cell">
                    <?php echo $advance->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a target="_blank" href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                        <?php echo $advance->dosya_no; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a target="_blank" href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                        <?php echo dateFormat_dmy($advance->avans_tarih); ?>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                        <?php echo money_format($advance->avans_miktar) . " " . get_currency($item->id); ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3">
            TOPLAM
        </td>
        <td>
            <?php echo money_format(sum_anything("advance", "avans_miktar", "contract_id", $item->id)); ?>
            <?php echo "$item->para_birimi"; ?>
        </td>
    </tr>
    </tfoot>
</table>

