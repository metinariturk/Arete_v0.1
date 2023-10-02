<div class="col-sm-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th colspan="4">
                    <h3> Metraj Grubu Ekle
                        <a data-tooltip-location="right" data-tooltip="Metraj Grubu" class=""
                           href="<?php echo base_url("compute/new_form/auction_display/$item->id"); ?>">
                            <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i> </a>
                    </h3>
                </th>
            </tr>
            <tr>
                <th class="w5"><i class="fa fa-reorder"></i></th>
                <th>Metraj Grubu Adı</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($metrajlar)) { ?>
                <?php foreach ($metrajlar as $metraj) { ?>
                    <tr data-toggle="collapse" data-target="#accordion_compute<?php echo $metraj->id; ?>" class="clickable"
                        id="center_row">
                        <td>
                            <a data-tooltip-location="right" data-tooltip="Metraj Ekle" class=""
                               href="">
                                <?php echo $metraj->id; ?>
                            </a>
                        </td>
                        <td><?php echo $metraj->metraj_ad." - ".$metraj->metraj_grup; ?></td>
                        <td>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)" data-text="Metraj"
                               data-note="Sayfadan Çıkmak Üzeresiniz"
                               data-url="<?php echo base_url("compute/file_form/$metraj->id"); ?>">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <div id="accordion_compute<?php echo $metraj->id; ?>" class="collapse">
                                <?php if (!empty($metraj->id)) {
                                    $metraj_files = get_module_files("compute_files", "compute_id", "$metraj->id");
                                    if (!empty($metraj_files)) {
                                        $i = 1;
                                        foreach ($metraj_files as $metraj_file) { ?>
                                            <div class="container-fluid text-left m-t-sm">
                                                <a class="pager-btn btn btn-purple btn-outline"
                                                   href="<?php echo base_url("compute/file_download/$metraj_file->id/file_form"); ?>">
                                                    <?php echo $i++; ?> - <?php echo filenamedisplay($metraj_file->img_url); ?>
                                                </a>
                                            </div>
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







