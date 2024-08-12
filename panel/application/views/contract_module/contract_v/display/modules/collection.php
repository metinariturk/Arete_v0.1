<table class="table" id="collection_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th>Tarihi</th>
        <th>Ödeme Türü/Açıklama</th>
        <th class="d-none d-sm-table-cell">Tutarı</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($collections)) { ?>
        <?php foreach ($collections as $collection) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $collection->id; ?>
                </td>
                <td>
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo dateFormat_dmy($collection->tahsilat_tarih); ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo $collection->tahsilat_turu; ?> / <?php echo $collection->aciklama; ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo money_format($collection->tahsilat_miktar) . " " . get_currency($item->id); ?>
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
            <?php echo money_format(sum_anything("collection", "tahsilat_miktar", "contract_id", $item->id)); ?>
            <?php echo "$item->para_birimi"; ?>
        </td>
    </tr>
    </tfoot>
</table>
