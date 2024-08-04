<div class="tab-pane fade <?php if (empty($active_tab)) {
    echo "active show";
} ?>"
     id="genel" role="tabpanel"
     aria-labelledby="genel-tab">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-7 col-lg-12 col-md-12 box-col-10">
                <div class="container">
                    <div class="row py-3">
                        <div class="col-12">
                            <?php if (!empty($item->final_date)) { ?>
                                <h3>Kesin Kabulü Yapılmış</h3>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-12" style="text-align: center">
                            <h4>
                                <?php if (!empty($item->parent)) { ?>
                                    <strong>Taşeron Sözleşmesi</strong>
                                <?php } else { ?>
                                    <strong>Sözleşme</strong>
                                <?php } ?>
                                <a onclick="changeIcon(this)"
                                   url="<?php echo base_url("$this->Module_Name/favorite/$item->id"); ?>"
                                   id="myBtn">
                                    <i class="fa <?php echo $fav ? 'fa-star' : 'fa-star-o'; ?>"> </i>
                                </a>
                            </h4>
                            <?php echo contract_code_name($item->id); ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Proje</strong>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo base_url("project/file_form/$item->proje_id"); ?>">
                                <?php echo project_code_name($item->proje_id); ?>
                            </a>
                        </div>
                    </div>
                    <?php if (!empty($item->parent)) { ?>
                        <div class="row py-3">
                            <div class="col-6">
                                <strong>Ana Sözleşme:</strong>
                            </div>
                            <div class="col-6">
                                <a href="<?php echo base_url("contract/file_form/$item->parent"); ?>">
                                    <?php echo contract_code_name($item->parent); ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>İşveren:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo company_name($item->isveren); ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Yüklenici Adı:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo company_name($item->yuklenici); ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>İşin Süresi:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->isin_suresi; ?> Gün
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Teklif Verme Tarihi:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->sozlesme_tarih == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_tarih); ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Teklif Bitiş Tarihi:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->sozlesme_bitis == null ? null : dateFormat($format = 'd-m-Y', $item->sozlesme_bitis); ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>İşin Türü:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->isin_turu; ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Teklif Türü:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo $item->sozlesme_turu; ?>
                        </div>
                    </div>
                    <div class="row py-3">
                        <div class="col-6">
                            <strong>Sözleşme Bedeli:</strong>
                        </div>
                        <div class="col-6">
                            <?php echo money_format($item->sozlesme_bedel) . " " . $item->para_birimi; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-12 col-md-12 box-col-10">
                <div class="file-content">
                    <div class="fileuploader fileuploader-theme-dragdrop">
                        <form method="post" enctype="multipart/form-data">
                            <?php
                            $uploadDir = $path;
                            $preloadedFiles = array();
                            $uploadsFiles = array_diff(scandir($uploadDir), array('.', '..'));
                            foreach ($uploadsFiles as $file) {
                                if (is_dir($uploadDir . $file))
                                    continue;
                                $preloadedFiles[] = array(
                                    "name" => $file,
                                    "auc_id" => $item->id,
                                    "type" => FileUploader::mime_content_type($uploadDir . $file),
                                    "size" => filesize($uploadDir . $file),
                                    "file" => base_url("uploads/project_v/$project->project_code/$item->dosya_no/Offer/") . $file,
                                    "local" => base_url("uploads/project_v/$project->project_code/$item->dosya_no/Offer/") . $file,
                                    "data" => array(
                                        "url" => base_url("uploads/project_v/$project->project_code/$item->dosya_no/Offer/") . $file, // (optional)
                                        "thumbnail" => file_exists($uploadDir . 'thumbs/' . $file) ? $uploadDir . 'thumbs/' . $file : null, // (optional)
                                        "readerForce" => true // (optional) prevent browser cache
                                    ),
                                );
                            }
                            $preloadedFiles = json_encode($preloadedFiles);
                            ?>
                            <input type="file" name="files" data-fileuploader-files='<?php echo $preloadedFiles; ?>'>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>