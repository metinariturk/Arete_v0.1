<div class="col-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
                <th class="d-none d-sm-table-cell">Grup</th>
                <th>Teknik Döküman Adı</th>
                <th class="d-none d-sm-table-cell">İnceleyen</th>
                <th>Dosyalar</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($cizimler)) { ?>
            <?php foreach ($cizimler as $cizim) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $cizim->id; ?>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("aucdraw/file_form/$cizim->id"); ?>">
                        <?php echo $cizim->cizim_grup; ?>
                    </a>
                </td>
                <td>
                    <a  href="<?php echo base_url("aucdraw/file_form/$cizim->id"); ?>">
                        <?php echo $cizim->cizim_ad; ?>
                    </a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <a  href="<?php echo base_url("aucdraw/file_form/$cizim->id"); ?>">
                        <?php echo full_name($cizim->onay); ?>
                    </a>
                </td>
                <td>
                    <div>
                        <?php if (!empty($cizim->id)) {
                            $cizim_files = get_module_files("aucdraw_files", "aucdraw_id", "$cizim->id");
                            if (!empty($cizim_files)) { ?>
                                <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                        href="<?php echo base_url("aucdraw/download_all/$cizim->id"); ?>"
                                        data-bs-original-title="<?php foreach ($cizim_files as $cizim_file) { ?>
                                            <?php echo filenamedisplay($cizim_file->img_url); ?> |
                                            <?php } ?>"
                                        data-original-title="btn btn-pill btn-info btn-air-info ">
                                   <i class="fa fa-download" aria-hidden="true"></i> Dosya (<?php echo count($cizim_files); ?>)
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
        </table>
    </div>
</div>









