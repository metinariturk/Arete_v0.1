<div class="col-sm-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th colspan="4">
                    <h3>Teşvik Grubu Ekle
                        <a data-tooltip-location="right" data-tooltip="Teşvik Grubu Ekle" class=""
                           href="<?php echo base_url("incentive/new_form/auction_display/$item->id"); ?>">
                            <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i> </a>
                    </h3>
                </th>
            </tr>

            <tr>
                <th class="w10">id</th>
                <th class="w20">Grubu</th>
                <th class="w30">Teşvik Veren Kurum</th>
                <th class="w30">İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($tesvikler)) { ?>
                <?php foreach ($tesvikler as $tesvik) { ?>
                    <tr data-toggle="collapse" data-target="#accordion_incentive<?php echo $tesvik->id; ?>" class="clickable"
                        id="center_row">
                        <td>
                            <a data-tooltip-location="right" data-tooltip="Teşvik Belgesi Ekle" class=""
                               href="">
                                <?php echo $tesvik->id; ?>
                            </a>
                        </td>
                        <td><?php echo $tesvik->tesvik_grup; ?></td>
                        <td><?php echo $tesvik->tesvik_kurum; ?></td>
                        <td>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)" data-text="Teşvik"
                               data-note="Sayfadan Çıkmak Üzeresiniz"
                               data-url="<?php echo base_url("incentive/file_form/$tesvik->id"); ?>">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <div id="accordion_incentive<?php echo $tesvik->id; ?>" class="collapse">
                                <?php if (!empty($tesvik->id)) {
                                    $tesvik_files = get_module_files("incentive_files", "incentive_id", "$tesvik->id");
                                    if (!empty($tesvik_files)) {
                                        $i = 1;
                                        foreach ($tesvik_files as $tesvik_file) { ?>
                                            <div class="container-fluid text-left m-t-sm">
                                                <a class="pager-btn btn btn-purple btn-outline"
                                                   href="<?php echo base_url("incentive/file_download/$tesvik_file->id/file_form"); ?>">
                                                    <?php echo $i++; ?> - <?php echo filenamedisplay($tesvik_file->img_url); ?>
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








