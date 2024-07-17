div class="col-sm-12 d-none d-sm-block">
    <table class="table">
        <thead>
        <tr>
            <th class="w10">id</th>
            <th class="w20">Grubu</th>
            <th class="w30">Teşvik Veren Kurum</th>
            <th class="w30">Dosya</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($tesvikler)) { ?>
            <?php foreach ($tesvikler as $tesvik) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url("incentive/file_form/$tesvik->id"); ?>">
                            <?php echo $tesvik->id; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("incentive/file_form/$tesvik->id"); ?>">
                            <?php echo $tesvik->tesvik_grup; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo base_url("incentive/file_form/$tesvik->id"); ?>">
                            <?php echo $tesvik->tesvik_kurum; ?>
                        </a>
                    </td>
                    <td>
                        <div>
                            <?php if (!empty($tesvik->id)) {
                                $tesvik_files = get_module_files("incentive_files", "incentive_id", "$tesvik->id");
                                if (!empty($tesvik_files)) { ?>
                                    <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                       href="<?php echo base_url("incentive/download_all/$tesvik->id"); ?>"
                                       data-bs-original-title="<?php foreach ($tesvik_files as $tesvik_file) { ?>
                                            <?php echo filenamedisplay($tesvik_file->img_url); ?> |
                                            <?php } ?>"
                                       data-original-title="btn btn-pill btn-info btn-air-info ">
                                        <i class="fa fa-download" aria-hidden="true"></i> Dosya
                                        (<?php echo count($tesvik_files); ?>)
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
<div class="col-12 d-sm-none">
    <table class="table">
        <thead>
        <tr>
            <th class="w20">Grubu - Kurum</th>
            <th class="w30">Dosya</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($tesvikler)) { ?>
            <?php foreach ($tesvikler as $tesvik) { ?>
                <tr>
                    <td>
                        <a href="<?php echo base_url("incentive/file_form/$tesvik->id"); ?>">
                            <?php echo $tesvik->tesvik_grup; ?> - <?php echo $tesvik->tesvik_kurum; ?>
                        </a>
                    </td>
                    <td>
                        <div>
                            <?php if (!empty($tesvik->id)) {
                                $tesvik_files = get_module_files("incentive_files", "incentive_id", "$tesvik->id");
                                if (!empty($tesvik_files)) { ?>
                                    <a class="btn btn-pill btn-success btn-air-success" type="button" title=""
                                       href="<?php echo base_url("incentive/download_all/$tesvik->id"); ?>"
                                       data-bs-original-title="<?php foreach ($tesvik_files as $tesvik_file) { ?>
                                            <?php echo filenamedisplay($tesvik_file->img_url); ?> |
                                            <?php } ?>"
                                       data-original-title="btn btn-pill btn-info btn-air-info ">
                                        <i class="fa fa-download" aria-hidden="true"></i> Dosya
                                        (<?php echo count($tesvik_files); ?>)
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






