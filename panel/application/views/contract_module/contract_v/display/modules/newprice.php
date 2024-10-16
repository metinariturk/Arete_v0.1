
<button class="btn btn-pill btn-outline-success" onclick="newpriceToExcel('xlsx')"
        type="button"><i class="fa fa-share-square-o"></i> EXCEL
</button>
<table class="table" id="newprice_table">
    <thead>
    <tr>
        <th  class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th  class="d-none d-sm-table-cell">Dosya No</th>
        <th class="d-none d-sm-table-cell">YBF Tarihi</th>
        <th>YBF Tutar</th>
        <th>Evraklar</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($newprices)) { ?>
        <?php foreach ($newprices as $newprice) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $newprice->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("newprice/file_form/$newprice->id"); ?>">
                        <?php echo $newprice->dosya_no; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("newprice/file_form/$newprice->id"); ?>">
                        <?php echo dateFormat_dmy($newprice->ybf_tarih); ?>
                    </a>
                </td>
                <td>
                    <a  href="<?php echo base_url("newprice/file_form/$newprice->id"); ?>">
                        <?php echo $newprice->ybf_tutar; ?> <?php echo "$item->para_birimi"; ?>
                    </a>
                </td>
                <td>
                    <div>
                        <?php if (!empty($newprice->id)) {
                            $newprice_files = get_module_files("newprice_files", "newprice_id", "$newprice->id");
                            if (!empty($newprice_files)) { ?>
                                <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                   href="<?php echo base_url("newprice/download_all/$newprice->id"); ?>"
                                   data-bs-original-title="<?php foreach ($newprice_files as $newprice_file) { ?>
                                            <?php echo filenamedisplay($newprice_file->img_url); ?> |
                                            <?php } ?>"
                                   data-original-title="btn btn-pill btn-info btn-air-info btn-lg">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    (<?php echo count($newprice_files); ?>)
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
        <td class="d-none d-sm-table-cell"></td>
        <td class="d-none d-sm-table-cell"></td>
        <td>
            TOPLAM
        </td>
        <td>
            <?php echo money_format(sum_anything("newprice", "ybf_tutar", "contract_id", $item->id)); ?>
            <?php echo "$item->para_birimi"; ?>
        </td>

    </tr>
    </tfoot>
</table>

<script>

    function newpriceToExcel(type, fn, dl) {
        var elt = document.getElementById('newprice_table');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "Sayfa1"});
        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->contract_name; ?> Maliyet.' + (type || 'xlsx')));
    }
</script>