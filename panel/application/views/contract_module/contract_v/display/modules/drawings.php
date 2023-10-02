<table class="table" id="drawings_table">
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th class="d-none d-sm-table-cell">Dosya No</th>
        <th class="d-none d-sm-table-cell">Döküman Grubu</th>
        <th>Döküman Adı</th>
        <th>Dosyalar</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($drawings)) { ?>
        <?php foreach ($drawings as $drawing) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $drawing->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("drawings/file_form/$drawing->id"); ?>">
                        <?php echo $drawing->dosya_no; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("drawings/file_form/$drawing->id"); ?>">
                        <?php echo $drawing->cizim_grup; ?>
                    </a>
                </td>
                <td>
                    <a  href="<?php echo base_url("drawings/file_form/$drawing->id"); ?>">
                        <?php echo  $drawing->cizim_ad; ?>
                    </a>
                </td>
                <td>
                    <div>
                        <?php if (!empty($drawing->id)) {
                            $drawing_files = get_module_files("drawings_files", "drawings_id", "$drawing->id");
                            if (!empty($drawing_files)) { ?>
                                <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                   href="<?php echo base_url("drawings/download_all/$drawing->id"); ?>"
                                   data-bs-original-title="<?php foreach ($drawing_files as $drawing_file) { ?>
                                            <?php echo filenamedisplay($drawing_file->img_url); ?> |
                                            <?php } ?>"
                                   data-original-title="btn btn-pill btn-info btn-air-info btn-lg">
                                    <i class="fa fa-download" aria-hidden="true"></i> Dosya
                                    (<?php echo count($drawing_files); ?>)
                                </a>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="div-table">
                                <div class="div-table-row">
                                    <div class="div-table-col">
                                        Dosya Yok, Eklemek İçin Görüntüle Butonundan Döküman Sayfasına
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
</table>
