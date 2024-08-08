<button class="btn btn-pill btn-outline-success" onclick="advanceToExcel('xlsx')"
        type="button"><i class="fa fa-share-square-o"></i> EXCEL
</button>
<table class="table" id="collection_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell">Dosya No</th>
        <th>Tarihi</th>
        <th>Ödeme Türü</th>
        <th>Açıklama</th>
        <th class="d-none d-sm-table-cell">Tutarı</th>
        <th>Dosyalar</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($collections)) { ?>
        <?php foreach ($collections as $collection) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $collection->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo $collection->dosya_no; ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo dateFormat_dmy($collection->tahsilat_tarih); ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo $collection->tahsilat_turu; ?>
                    </a>
                </td>
                <td  class="d-none d-sm-table-cell">
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo $collection->aciklama; ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo money_format($collection->tahsilat_miktar) . " " . get_currency($item->id); ?>
                    </a>
                </td>
                <td>
                    <div>

                    </div>
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
<script>

    function advanceToExcel(type, fn, dl) {
        var elt = document.getElementById('collection_table');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "Sayfa1"});
        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->sozlesme_ad; ?> Tahsilat.' + (type || 'xlsx')));
    }
</script>