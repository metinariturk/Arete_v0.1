<div class="card-body file-manager">
    <h4 class="mb-3">Evraklar
        <a href="<?php echo base_url("$this->Module_Name/download_all/$item->id/Contract"); ?>">
            <i class="fa fa-download f-18"></i>
        </a>
    </h4>
    <ul class="files ">
        <?php foreach ($item_files as $file) { ?>
            <li class="file-box">
                <div class="file-top">
                    <?php echo ext_img($file->img_url); ?>
                    <a href="<?php echo base_url("$this->Module_Name/file_download/$file->id"); ?>">
                        <i class="fa fa-download f-14 ellips"></i>
                    </a>
                </div>
                <div class="file-bottom">
                    <h6><?php echo filenamedisplay($file->img_url); ?></h6>
                    <p class="mb-1"><?php echo file_size($file->size) ?></p>
                    <a onclick="deleteConfirmationFile(this)"
                       url="<?php echo base_url("$this->Module_Name/fileDelete/$file->id"); ?>">
                    <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                       aria-hidden="true"></i>
                    </a>
                </div>
            </li>
        <?php } ?>
    </ul>
    <div class="col">
        <div class="text-end">
            <a onclick="deleteConfirmationFile(this)"
               class="btn btn-danger me-3" href="#"
               data-bs-original-title=""
               title=""
               url="<?php echo base_url("$this->Module_Name/fileDelete_all/$item->id"); ?>"
            ><i class="fa fa-trash-o""></i> Tümünü Sil</a>
        </div>
    </div>
</div>

