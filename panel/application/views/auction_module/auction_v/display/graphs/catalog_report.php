<?php
$project_code = project_code($item->proje_id);
$path = "uploads/project_v/$project_code/$item->dosya_no/Catalog/Thumb";
?>
<?php if (!empty($path)) { ?>
    <div class="col-12 box-col-10">
        <div class="card-header text-center">
            <h4>Katalog Görselleri</h4>
        </div>
        <div class="container-fluid">
            <div class="row">
                <?php
                $support_ext = array("jpg", "jpeg", "gif", "png");
                $files = directory_map($path, 1);
                $i = 1;
                if (!empty($files)) {
                    foreach ($files as $file) {
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        if (in_array($ext, $support_ext)) { ?>
                            <div class="col-6 col-lg-3">
                                <div class="card">
                                    <div class="blog-box blog-grid text-center">
                                        <img class="img-fluid top-radius-blog"
                                             src="<?php $thumb_name = $file;
                                             echo base_url("$path/$thumb_name"); ?>"
                                             alt="">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>






