<div class="fade tab-pane <?php if ($active_tab == "drawings") {
    echo "active show";
} ?>"
     id="drawings" role="tabpanel"
     aria-labelledby="drawings-tab">
    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="file-content-d">
                        <div class="fileuploader fileuploader-theme-dragdrop">
                            <form method="post" enctype="multipart/form-data">
                                <?php
                                $offer_drawings = "$this->Upload_Folder/$this->Module_Main_Dir/$project->project_code/$item->dosya_no/Offer/Drawings";
                                $preloadedCollection_Files = array();
                                $uploadsCollectionFiles = array_diff(scandir($offer_drawings), array('.', '..'));
                                foreach ($uploadsCollectionFiles as $uploadsCollectionFile) {
                                    if (is_dir($offer_drawings . $uploadsCollectionFile))
                                        continue;
                                    $preloadedCollection_Files[] = array(
                                        "name" => $uploadsCollectionFile,
                                        "auc_id" => $item->id,
                                        "type" => FileUploader::mime_content_type($offer_drawings . $uploadsCollectionFile),
                                        "size" => filesize($offer_drawings . $uploadsCollectionFile),
                                        "file" => base_url($offer_drawings) . $uploadsCollectionFile,
                                        "local" => base_url($offer_drawings) . $uploadsCollectionFile,
                                    );
                                }
                                $preloadedCollection_Files = json_encode($preloadedCollection_Files);
                                ?>
                                <input type="file" name="dfiles" data-fileuploader-files='<?php echo $preloadedCollection_Files; ?>'>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
