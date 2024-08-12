<div class="fade tab-pane <?php if ($active_tab == "collection") {
    echo "active show";
} ?>"
     id="collection" role="tabpanel"
     aria-labelledby="collection-tab">

    <div class="card mb-0">
        <div class="card-header d-flex">
            <h6 class="mb-0">Avans Ödemesi</h6>
            <ul>
                <li>
                    <a class="pager-btn btn btn-info btn-outline"
                       href="<?php echo base_url("collection/new_form/$item->id"); ?>" target="_blank">
                        <i class="menu-icon fa fa-plus" aria-hidden="true"></i>Yeni Tahsilat Ekle
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-8">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/collection"); ?>
                </div>
                <div class="col-sm-4">
                    <div class="file-content-c">
                        <div class="fileuploader fileuploader-theme-dragdrop">
                            <form method="post" enctype="multipart/form-data">
                                <?php
                                $uploadCollection_path = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$item->dosya_no/Collection/";
                                $preloadedCollection_Files = array();
                                $uploadsCollectionFiles = array_diff(scandir($uploadCollection_path), array('.', '..'));
                                foreach ($uploadsCollectionFiles as $uploadsCollectionFile) {
                                    if (is_dir($uploadCollection_path . $uploadsCollectionFile))
                                        continue;
                                    $preloadedCollection_Files[] = array(
                                        "name" => $uploadsCollectionFile,
                                        "auc_id" => $item->id,
                                        "type" => FileUploader::mime_content_type($uploadCollection_path . $uploadsCollectionFile),
                                        "size" => filesize($uploadCollection_path . $uploadsCollectionFile),
                                        "file" => base_url($uploadCollection_path) . $uploadsCollectionFile,
                                        "local" => base_url($uploadCollection_path) . $uploadsCollectionFile,
                                    );
                                }
                                $preloadedCollection_Files = json_encode($preloadedCollection_Files);
                                ?>
                                <input type="file" name="cfiles" data-fileuploader-files='<?php echo $preloadedCollection_Files; ?>'>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>