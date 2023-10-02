<div class="widget-body">
    <div class="row">
        <div id="gallery" class="gallery m-b-lg">
            <div class="row">
                <?php
                $date = dateFormat_dmy($item->report_date);
                $site_id = get_from_any("report", "site_id", "id", "$item->id");
                $site_code = get_from_any("site", "dosya_no", "id", "$site_id");
                $contract_id = get_from_any("site", "contract_id", "id", "$site_id");
                $contract_code = get_from_any("contract", "dosya_no", "id", "$contract_id");
                $project_id = get_from_any("site", "proje_id", "id", "$site_id");
                $project_code = get_from_any("projects", "proje_kodu", "id", "$project_id");

                if ($contract_id > 0) {
                    $path = "uploads/project_v/$project_code/$contract_code/site/$site_code/reports/$date";
                } else {
                    $path = "uploads/project_v/$project_code/site/$site_code/reports/$date";
                }

                $support_ext = array("jpg", "jpeg", "gif", "png");
                $files = directory_map($path,1);
                foreach ($files as $file) {
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if (in_array($ext, $support_ext)) { ?>
                        <div class="col-xs-6 col-sm-4 col-md-3">
                            <div class="gallery-item">
                                <div class="thumb">
                                    <a href="<?php echo base_url("$path/$file"); ?>" data-lightbox="gallery-1"
                                       data-title="gallery image">
                                        <img class="img-responsive"
                                             src="
                                             <?php $thumb_name = get_thumb_name($file);
                                             echo base_url("$path/thumb/$thumb_name"); ?>" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php }
                }
                ?>
            </div>
        </div>
    </div>
</div>
