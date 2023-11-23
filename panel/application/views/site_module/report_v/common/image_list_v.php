<div class="container-fluid">
    <div>
        <div class="row product-page-main p-0">
            <div class="col-xl-12">
                <div class="product-slider owl-carousel owl-theme" id="sync1">
                    <?php
                    $report_date = dateFormat_dmy($item->report_date);
                    $path = "uploads/project_v/$project->proje_kodu/$site->dosya_no/Reports/$report_date/thumb";
                    echo $path;
                    ?>
                    <?php if (!empty($path)) { ?>
                        <?php
                        $support_ext = array("jpg", "jpeg", "gif", "png");
                        $files = directory_map($path, 1);
                        $i = 1;
                        if (!empty($files)) {
                            foreach ($files as $file) {
                                $ext = pathinfo($file, PATHINFO_EXTENSION);
                                if (in_array($ext, $support_ext)) { ?>
                                    <div class="item"><img src="<?php echo base_url("$path/$file"); ?>"
                                                           alt="123">
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="owl-carousel owl-theme" id="sync2">
                    <?php
                    $report_date = dateFormat_dmy($item->report_date);
                    $path = "uploads/project_v/$project->proje_kodu/$site->dosya_no/Reports/$report_date/thumb";
                    ?>
                    <?php if (!empty($path)) { ?>
                        <?php
                        $support_ext = array("jpg", "jpeg", "gif", "png");
                        $files = directory_map($path, 1);
                        $i = 1;
                        if (!empty($files)) {
                            foreach ($files as $file) {
                                $ext = pathinfo($file, PATHINFO_EXTENSION);
                                if (in_array($ext, $support_ext)) { ?>
                                    <div class="item"><img src="<?php echo base_url("$path/$file"); ?>"
                                                           alt="123">
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>




