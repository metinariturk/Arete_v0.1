<div class="col-sm-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
                <th>Metraj Grup</th>
                <th class="d-none d-sm-table-cell">Metraj Adı</th>
                <th class="d-none d-sm-table-cell">Onay</th>
                <th>Dosyalar</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($metrajlar)) { ?>
                <?php foreach ($metrajlar as $metraj) { ?>
                    <tr id="center_row">
                        <td class="d-none d-sm-table-cell">
                            <?php echo $metraj->id; ?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <a  href="<?php echo base_url("compute/file_form/$metraj->id"); ?>">
                                <?php echo $metraj->metraj_grup; ?>
                            </a>
                        </td>
                        <td>
                            <a  href="<?php echo base_url("compute/file_form/$metraj->id"); ?>">
                                <?php echo $metraj->metraj_ad; ?>
                            </a>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <a  href="<?php echo base_url("compute/file_form/$metraj->id"); ?>">
                                <?php echo full_name($metraj->onay); ?>
                            </a>
                        </td>
                        <td>
                            <div>
                                <?php if (!empty($metraj->id)) {
                                    $metraj_files = get_module_files("compute_files", "compute_id", "$metraj->id");
                                    if (!empty($metraj_files)) { ?>
                                        <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                           href="<?php echo base_url("compute/download_all/$metraj->id"); ?>"
                                           data-bs-original-title="<?php foreach ($metraj_files as $metraj_file) { ?>
                                            <?php echo filenamedisplay($metraj_file->img_url); ?> |
                                            <?php } ?>"
                                           data-original-title="btn btn-pill btn-info btn-air-info ">
                                            <i class="fa fa-download" aria-hidden="true"></i> Dosya (<?php echo count($metraj_files); ?>)
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







