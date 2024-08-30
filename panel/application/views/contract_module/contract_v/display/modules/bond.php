<button class="btn btn-pill btn-outline-success" onclick="bondToExcel('xlsx')"
        type="button"><i class="fa fa-share-square-o"></i> EXCEL
</button>

<table class="table" id="bond_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell">Dosya No</th>
        <th>Başlangıç-Bitiş Tarihi</th>
        <th class="d-none d-sm-table-cell">Gerekçe</th>
        <th>Teminat Tutar</th>
        <th>Dosyalar</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($bonds)) { ?>
        <?php foreach ($bonds as $bond) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $bond->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <?php echo $bond->dosya_no; ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <?php echo dateFormat_dmy($bond->teslim_tarihi); ?>
                    </a> /
                    <?php if (!empty($bond->gecerlilik_tarihi)) { ?>
                        <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                            <?php echo dateFormat_dmy($bond->gecerlilik_tarihi); ?>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                            Süresiz Teminat
                        </a>
                    <?php } ?>
                </td>

                <td class="d-none d-sm-table-cell">
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <?php echo module_name($bond->teminat_gerekce); ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("bond/file_form/$bond->id"); ?>">
                        <?php echo $bond->teminat_miktar; ?><?php echo "$item->para_birimi"; ?>
                    </a>
                </td>
                <td>
                    <div>
                        <?php if (!empty($bond->id)) {
                            $bond_files = get_module_files("bond_files", "bond_id", "$bond->id");
                            if (!empty($bond_files)) { ?>
                                <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                   href="<?php echo base_url("bond/download_all/$bond->id"); ?>"
                                   data-bs-original-title="<?php foreach ($bond_files as $bond_file) { ?>
                                            <?php echo filenamedisplay($bond_file->img_url); ?> |
                                            <?php } ?>"
                                   data-original-title="btn btn-pill btn-info btn-air-info btn-lg">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    (<?php echo count($bond_files); ?>)
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
            <?php echo money_format(sum_anything("bond", "teminat_miktar", "contract_id", $item->id)); ?>
            <?php echo "$item->para_birimi"; ?>
        </td>
    </tr>
    </tfoot>
</table>

<script>
    function bondToExcel(type, fn, dl) {
        var elt = document.getElementById('bond_table');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "Sayfa1"});
        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->contract_name; ?> Teminatlar.' + (type || 'xlsx')));
    }
</script>