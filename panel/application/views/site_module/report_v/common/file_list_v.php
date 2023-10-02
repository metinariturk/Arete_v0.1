<div>
    <div class="row mt-3">
        <div class="col-10 ">
            <h5>Evraklar</h5>
        </div>
        <div class="col-1">
            <a href="<?php echo base_url("$this->Module_Name/download_all/$item->id"); ?>">
                <i class="fa fa-download"></i>
            </a>
        </div>
        <div class="col-1">
            <a onclick="deleteConfirmationFile(this)"
               url="<?php echo base_url("$this->Module_Name/fileDelete_all/$item->id"); ?>"
            <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
               aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <?php foreach ($item_files as $file) { ?>
        <?php $ext = mb_strtolower(pathinfo($file->img_url, PATHINFO_EXTENSION));
        if (!in_array($ext, array("jpg", "jpeg", "png", "gif", "bmp"))) { ?>
            <div class="row mt-2 d-flex align-items-center">
                <div class="col-2">
                    <?php echo ext_img($file->img_url); ?>
                </div>
                <div class="col-8  ">
                    <p class="task_desc_0"><?php echo filenamedisplay($file->img_url); ?></p>
                </div>
                <div class="col-1">
                    <a href="<?php echo base_url("$this->Module_Name/file_download/$file->id"); ?>">
                        <i class="fa fa-download"></i>
                    </a>
                </div>
                <div class="col-1">
                    <a onclick="deleteConfirmationFile(this)"
                       url="<?php echo base_url("$this->Module_Name/fileDelete_file/$file->id"); ?>"
                    <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                       aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
<hr>
    <div class="row mt-3">
        <div class="col-10">
            <h5>Görseller</h5>
        </div>
    </div>
    <?php foreach ($item_files as $file) { ?>
        <?php $ext = mb_strtolower(pathinfo($file->img_url, PATHINFO_EXTENSION));
        if (in_array($ext, array("jpg", "jpeg", "png", "gif", "bmp"))) { ?>
            <div class="row mt-2 d-flex align-items-center">
                <div class="col-2">
                    <?php echo ext_img($file->img_url); ?>
                </div>
                <div class="col-8">
                    <p class="task_desc_0"><?php echo filenamedisplay($file->img_url); ?></p>
                </div>
                <div class="col-1">
                    <a href="<?php echo base_url("$this->Module_Name/file_download/$file->id"); ?>">
                        <i class="fa fa-download"></i>
                    </a>
                </div>
                <div class="col-1">
                    <a onclick="deleteConfirmationFile(this)"
                       url="<?php echo base_url("$this->Module_Name/fileDelete_image/$file->id"); ?>"
                    <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                       aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

