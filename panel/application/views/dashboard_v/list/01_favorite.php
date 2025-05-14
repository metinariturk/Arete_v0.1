<div class="container-fluid">
    <div class="row justify-content-center">
        <?php
        $sections = [
            "Projeler" => "project",
            "Sözleşmeler" => "contract",
            "Şantiyeler" => "site",
            "Hızlı Rapor" => "site"
        ];
        foreach ($sections as $title => $module) { ?>
            <div class="col-xxl-4 col-md-6 col-sm-12 mb-4">
                <div class="p-2 rounded shadow-sm">
                    <h5 class="text-center mb-3"><?php echo $title; ?></h5>
                    <div class="d-grid gap-2">
                        <?php
                        $hasItems = false;
                        foreach ($favorites as $favorite) {
                            if ($favorite->module == $module) {
                                $hasItems = true; ?>
                                <a
                                        href="<?php echo base_url(($title == "Hızlı Rapor") ? "Report/new_form/$favorite->module_id" : "$favorite->module/$favorite->view/$favorite->module_id"); ?>"
                                        class="btn btn-outline-primary text-start text-wrap py-2 px-3"
                                        style="white-space: normal;"
                                >
                                    <?php echo $favorite->title; ?>
                                </a>
                            <?php }
                        }
                        if (!$hasItems) { ?>
                            <p class="text-muted text-center">Henüz favori yok.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
