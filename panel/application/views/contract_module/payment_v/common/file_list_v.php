<div class="card-body file-manager image_list_container">
    <h4 class="mb-3">Evraklar
        <a href="<?php echo base_url("$this->Module_Name/download_all/$item->id"); ?>">
            <i class="fa fa-download f-18"></i>
        </a>
    </h4>
    <table class="table table-bordered">
        <?php foreach ($item_files as $file) { ?>
            <tr>
                <td style="width: 20px">
                    <a href="<?php echo base_url("$this->Module_Name/file_download/$file->id"); ?>">
                        <i class="fa fa-download"></i>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("$this->Module_Name/file_download/$file->id"); ?>">
                    <?php echo file_size($file->size) ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("$this->Module_Name/file_download/$file->id"); ?>">
                        <?php echo ext_img($file->img_url); ?>
                        <?php echo filenamedisplay_long($file->img_url); ?>
                    </a>
                </td>
                <td class="col-1"><a onclick="deleteConfirmationFile(this)"
                                     url="<?php echo base_url("$this->Module_Name/fileDelete/$file->id"); ?>">
                        <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                           aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
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

