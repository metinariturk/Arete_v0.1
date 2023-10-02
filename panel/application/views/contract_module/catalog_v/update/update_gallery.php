<div class="card-body">
    <?php $catalog_number = increase_code_suffix("catalog"); ?>
    <div class="image_list_container">
        <div class="row">
            <?php
            $path =  "$this->Upload_Folder/$this->Module_Main_Dir/$project_code/$contract_code/Catalog/$item->dosya_no";

            $support_ext = array("jpg", "jpeg", "gif", "png");
            $files = directory_map($path, 1);
            $i = 1;
            if (!empty($files)) {
                foreach ($files as $file) {
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if (in_array($ext, $support_ext)) { ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="prooduct-details-box">
                                <div class="media">
                                    <img class="img-thumbnail"
                                         src="<?php $thumb_name = get_thumb_name($file);
                                         echo base_url("$path/thumb/$thumb_name"); ?>"
                                         itemprop="thumbnail"
                                         alt="Çift Yüklenmiş Görsel">
                                </div>
                                <div class="text-center">
                                    <a onclick="deleteConfirmationCatalog(this)"
                                       url="<?php echo base_url("$this->Module_Name/UpdatefileDelete/$file/$item->id"); ?>"
                                    <i style="font-size: 30px; color: Tomato;"
                                       class="fa fa-times-circle-o"
                                       aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
