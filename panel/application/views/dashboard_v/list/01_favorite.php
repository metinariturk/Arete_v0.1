<div class="container-fluid">
    <div class="row widget-grid justify-content-center"> <!-- Merkeze hizalama eklendi -->
        <?php
        $sections = [
            "Projeler" => "project",
            "Sözleşmeler" => "contract",
            "Şantiyeler" => "site",
            "Hızlı Rapor" => "site"
        ];
        foreach ($sections as $title => $module) { ?>
            <div class="col-xxl-4 col-md-6 <?php echo ($title == "Hızlı Rapor") ? 'mx-auto' : ''; ?>"> <!-- Hızlı Rapor ortalanıyor -->
                <div class="card-body pt-3">
                    <h5 class="text-center"><?php echo $title; ?></h5>
                    <hr>
                    <ul>
                        <?php foreach ($favorites as $favorite) { ?>
                            <?php if ($favorite->module == $module) { ?>
                                <li>
                                    <a href="<?php echo base_url(($title == "Hızlı Rapor") ? "Report/new_form/$favorite->module_id" : "$favorite->module/$favorite->view/$favorite->module_id"); ?>">
                                        <?php echo $favorite->title; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
