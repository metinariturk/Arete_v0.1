<div class="content image_list_container">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <h4 class="header-title m-b-30">Fotoğraflar</h4>
                        </div>
                    </div>
                    <div class="row">
                        <?php $i = 1; ?>
                        <?php $date = dateFormat_dmy($item->report_date); ?>
                        <?php foreach ($item_files as $item_file) { ?>
                            <?php $org_path = base_url("uploads/project_v/$project->project_code/$site->dosya_no/Reports/$date/$item_file->img_url"); ?>
                            <?php $thumb_path = base_url("uploads/project_v/$project->project_code/$site->dosya_no/Reports/$date/thumbnails/$item_file->img_url"); ?>
                            <div class="col-sm-3">
                                <div class="row">

                                    <div class="col-6 text-right"><a
                                                href="<?php echo base_url("$this->Module_Name/file_download/$item_file->id"); ?>"
                                        <i style="font-size: 18px; color: #8c8cde;" class="fa fa-download"
                                           aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="col-6 text-left">
                                        <a onclick="deleteConfirmationFile(this)"
                                           url="<?php echo base_url("$this->Module_Name/fileDelete/$item_file->id"); ?>">
                                            <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                                               aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <col-12>
                                        <img src="<?php echo "$thumb_path"; ?>" class="img-fluid enlarge-image"
                                             alt="Büyütülebilir Resim"
                                             onclick="openImageInNewTab('<?php echo "$org_path"; ?>')">
                                    </col-12>
                                </div>
                                <div class="row text-center">
                                    <col-12>
                                        <?php echo file_size($item_file->size) ?>
                                    </col-12>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center mt-3">
                                <a class="btn btn-outline-primary w-md waves-effect waves-light"
                                   href="<?php echo base_url("$this->Module_Name/download_all/$item->id"); ?>">
                                    <i class="fa fa-download f-18"></i>Tümünü İndir
                                </a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center mt-3">
                                <a onclick="deleteConfirmationFile(this)"
                                   class="btn btn-outline-danger w-md waves-effect waves-light" href="#"
                                   data-bs-original-title=""
                                   title=""
                                   url="<?php echo base_url("$this->Module_Name/fileDelete_all/$item->id"); ?>"
                                ><i class="fa fa-trash-o""></i> Tümünü Sil</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
</div>
