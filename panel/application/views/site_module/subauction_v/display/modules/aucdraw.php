<div class="col-sm-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th colspan="4">
                    <h3>Teknik Döküman Grubu Ekle
                        <a data-tooltip-location="right" data-tooltip="Döküman Grubu Ekle" class=""
                           href="<?php echo base_url("aucdraw/new_form/auction_display/$item->id"); ?>">
                            <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i> </a>
                    </h3>
                </th>
            </tr>
            <tr>
                <th class="w5"><i class="fa fa-reorder"></i></th>
                <th>Teknik Döküman Adı</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($cizimler)) { ?>
                <?php foreach ($cizimler as $cizim) { ?>
                    <tr data-toggle="collapse" data-target="#accordion_aucdraw<?php echo $cizim->id; ?>" class="clickable"
                        id="center_row">
                        <td>
                            <a data-tooltip-location="right" data-tooltip="Döküman Grubu Ekle" class=""
                               href="">
                                <?php echo $cizim->id; ?>
                            </a>
                        </td>
                        <td><?php echo $cizim->cizim_ad." - ".$cizim->cizim_grup; ?></td>
                        <td>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)" data-text="Teknik Döküman"
                               data-note="Sayfadan Çıkmak Üzeresiniz"
                               data-url="<?php echo base_url("aucdraw/file_form/$cizim->id"); ?>">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <div id="accordion_aucdraw<?php echo $cizim->id; ?>" class="collapse">
                                <?php if (!empty($cizim->id)) {
                                    $cizim_files = get_module_files("aucdraw_files", "aucdraw_id", "$cizim->id");
                                    if (!empty($cizim_files)) {
                                        $i = 1;
                                        foreach ($cizim_files as $cizim_file) { ?>
                                            <div class="container-fluid text-left m-t-sm">
                                                <a class="pager-btn btn btn-purple btn-outline"
                                                   href="<?php echo base_url("aucdraw/file_download/$cizim_file->id/file_form"); ?>">
                                                    <?php echo $i++; ?> - <?php echo filenamedisplay($cizim_file->img_url); ?>
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







