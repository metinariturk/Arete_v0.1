    <button class="btn btn-pill btn-outline-success" onclick="advanceToExcel('xlsx')"
            type="button"><i class="fa fa-share-square-o"></i> EXCEL
    </button>
    <table class="table" id="advance_table">
        <thead>
        <tr>
            <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
            <th class="d-none d-sm-table-cell">Dosya No</th>
            <th class="d-none d-sm-table-cell">Ödeme Tarihi</th>
            <th>Ödeme Tutarı</th>
            <th>Dosyalar</th>
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
                        <a href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                            <?php echo $advance->dosya_no; ?>
                        </a>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <a href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                            <?php echo dateFormat_dmy($advance->avans_tarih); ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("advance/file_form/$advance->id"); ?>">
                            <?php echo money_format($advance->avans_miktar) . " " . get_currency($item->id); ?>
                        </a>
                    </td>
                    <td>
                        <div>
                            <?php if (!empty($advance->id)) {
                                $advance_files = get_module_files("advance_files", "advance_id", "$advance->id");
                                if (!empty($advance_files)) { ?>
                                    <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                       href="<?php echo base_url("advance/download_all/$advance->id"); ?>"
                                       data-bs-original-title="<?php foreach ($advance_files as $advance_file) { ?>
                                            <?php echo filenamedisplay($advance_file->img_url); ?> |
                                            <?php } ?>"
                                       data-original-title="btn btn-pill btn-info btn-air-info btn-lg">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        (<?php echo count($advance_files); ?>)
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
            <td>
                TOPLAM
            </td>
            <td>
                <?php echo money_format(sum_anything("advance", "avans_miktar", "contract_id", $item->id)); ?>
                <?php echo "$item->para_birimi"; ?>
            </td>
        </tr>
        </tfoot>
    </table>





<script>

    function advanceToExcel(type, fn, dl) {
        var elt = document.getElementById('advance_table');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "Sayfa1"});
        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->sozlesme_ad; ?> Maliyet.' + (type || 'xlsx')));
    }
</script>