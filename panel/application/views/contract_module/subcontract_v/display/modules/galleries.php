
<div class="col-sm-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th colspan="4">
                    <h3>Yeni Katalog Ekle
                        <a data-tooltip-location="right" data-tooltip="Katalog Ekle" class=""
                           href="<?php echo base_url("auc_catalog/new_form/$item->id"); ?>">
                            <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i> </a>
                    </h3>
                </th>
            </tr>

            <tr>
                <th class="w10"><i class="fa fa-reorder"></i></th>
                <th class="w20">Adı</th>
                <th class="w30">İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($auc_catalogs)) { ?>
                <?php foreach ($auc_catalogs as $auc_catalog) { ?>
                    <tr data-toggle="collapse" data-target="#accordion_auc_catalog<?php echo $auc_catalog->id; ?>" class="clickable"
                        id="center_row">
                        <td>
                            <a data-tooltip-location="right" data-tooltip="" class=""
                               href="">
                                <?php echo $auc_catalog->id; ?>
                            </a>
                        </td>
                        <td><?php echo $auc_catalog->catalog_ad; ?></td>
                        <td>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)" data-text="Bu Poliçe"
                               data-note="Sayfadan Çıkmak Üzeresiniz"
                               data-url="<?php echo base_url("auc_catalog/file_form/$auc_catalog->id"); ?>">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <div id="accordion_auc_catalog<?php echo $auc_catalog->id; ?>" class="collapse show">
                                <?php if (!empty($auc_catalog->id)) {
                                    $auc_catalog_files = get_module_files("auc_catalog_files", "catalog_id", "$auc_catalog->id");
                                    if (!empty($auc_catalog_files)) {
                                        $i = 1;
                                        foreach ($auc_catalog_files as $auc_catalog_file) {
                                            $thumb_name = get_thumb_name($auc_catalog_file->img_url)?>
                                            <div class="col-sm-2">
                                                <?php $project_code = project_code_auc($item->id); ?>
                                                <img width="150" height="150"
                                                     src="<?php echo base_url("uploads/project_v/$project_code/$item->dosya_no/Catalog/$auc_catalog->dosya_no/thumb/$thumb_name"); ?>"
                                                     alt="">
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














