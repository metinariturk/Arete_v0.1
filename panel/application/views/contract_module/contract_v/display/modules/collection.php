<button class="btn btn-pill btn-outline-success" onclick="advanceToExcel('xlsx')"
        type="button"><i class="fa fa-share-square-o"></i> EXCEL
</button>
<table class="table" id="collection_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell">Dosya No</th>
        <th class="d-none d-sm-table-cell">Tarihi</th>
        <th>Tutarı</th>
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
                <td class="d-none d-sm-table-cell">
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo dateFormat_dmy($collection->tahsilat_tarih); ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo money_format($collection->tahsilat_miktar) . " " . get_currency($item->id); ?>
                    </a>
                </td>
                <td>
                    <div>
                        <?php if (!empty($collection->id)) {
                            $collection_files = get_module_files("collection_files", "collection_id", "$collection->id");
                            if (!empty($collection_files)) { ?>
                                <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                   href="<?php echo base_url("collection/download_all/$collection->id"); ?>"
                                   data-bs-original-title="<?php foreach ($collection_files as $collection_file) { ?>
                                            <?php echo filenamedisplay($collection_file->img_url); ?> |
                                            <?php } ?>"
                                   data-original-title="btn btn-pill btn-info btn-air-info btn-lg">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    (<?php echo count($collection_files); ?>)
                                </a>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="div-table">
                                <div class="div-table-row">
                                    <div class="div-table-col">
                                        Dosya Yok, Eklemek İçin Görüntüle Butonundan Şartname Sayfasına
                                        Gidiniz
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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