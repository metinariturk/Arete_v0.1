<button class="btn btn-pill btn-outline-success" onclick="extimeToExcel('xlsx')"
        type="button"><i class="fa fa-share-square-o"></i> EXCEL
</button>

<table class="table" id="extime_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell">Dosya No</th>
        <th class="d-none d-sm-table-cell">Süre Uzatım Verildiği Tarih</th>
        <th class="d-none d-sm-table-cell">Gerekçe</th>
        <th>Verilen Süre</th>
        <th>Dosyalar</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($extimes)) { ?>
        <?php foreach ($extimes as $extime) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell"
                    <?php echo $extime->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("extime/file_form/$extime->id"); ?>">
                        <?php echo $extime->dosya_no; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("extime/file_form/$extime->id"); ?>">
                        <?php echo dateFormat_dmy($extime->karar_tarih); ?>
                    </a>
                </td>

                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("extime/file_form/$extime->id"); ?>">
                        <?php echo $extime->uzatim_turu; ?>
                    </a>
                </td>
                <td>
                    <a  href="<?php echo base_url("extime/file_form/$extime->id"); ?>">
                        <?php echo $extime->uzatim_miktar; ?> Gün
                    </a>
                </td>
                <td>
                    <div>
                        <?php if (!empty($extime->id)) {
                            $extime_files = get_module_files("extime_files", "extime_id", "$extime->id");
                            if (!empty($extime_files)) { ?>
                                <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                   href="<?php echo base_url("extime/download_all/$extime->id"); ?>"
                                   data-bs-original-title="<?php foreach ($extime_files as $extime_file) { ?>
                                            <?php echo filenamedisplay($extime_file->img_url); ?> |
                                            <?php } ?>"
                                   data-original-title="btn btn-pill btn-info btn-air-info btn-lg">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                    (<?php echo count($extime_files); ?>)
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
        <td class="d-none d-sm-table-cell"></td>
        <td>
            TOPLAM
        </td>
        <td>
            <?php echo money_format(sum_anything("extime", "uzatim_miktar", "contract_id", $item->id)); ?>
            GÜN
        </td>
    </tr>
    </tfoot>
</table>

