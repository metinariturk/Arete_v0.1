<div class="fade tab-pane <?php if ($active_tab == "drawings") {
    echo "active show";
} ?>"
     id="drawings" role="tabpanel"
     aria-labelledby="drawings-tab">
    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Dokümanlar</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("drawings/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Doküman Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="file-content">
                <div class="fileuploader fileuploader-theme-dragdrop">
                    <form method="post" enctype="multipart/form-data">
                        <?php
                        $uploadDir = $draw_path;
                        !is_dir($draw_path) && mkdir($draw_path, 0777, TRUE);
                        $preloadedFiles_draw = array();
                        $uploadsFiles = array_diff(scandir($uploadDir), array('.', '..'));
                        foreach ($uploadsFiles as $file) {
                            if (is_dir($uploadDir . $file))
                                continue;
                            $preloadedFiles_draw[] = array(
                                "name" => $file,
                                "auc_id" => $item->id,
                                "type" => FileUploader::mime_content_type($uploadDir . $file),
                                "size" => filesize($uploadDir . $file),
                                "file" => base_url("uploads/project_v/$project->project_code/$item->dosya_no/Offer/Drawing/") . $file,
                                "local" => base_url("uploads/project_v/$project->project_code/$item->dosya_no/Offer/Drawing/") . $file,
                                "data" => array(
                                    "url" => base_url("uploads/project_v/$project->project_code/$item->dosya_no/Offer/Drawing/") . $file, // (optional)
                                    "thumbnail" => file_exists($uploadDir . 'thumbs/' . $file) ? $uploadDir . 'thumbs/' . $file : null, // (optional)
                                    "readerForce" => true // (optional) prevent browser cache
                                ),
                            );
                        }
                        $preloadedFiles_draw = json_encode($preloadedFiles_draw);
                        ?>
                        <input type="file" name="draw_files" data-fileuploader-files='<?php echo $preloadedFiles_draw; ?>'>
                    </form>
                </div>

                <div class="image_list_container">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
