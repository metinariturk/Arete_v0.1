<?php if (empty($item_files)) { ?>
    <hr>
    <div class="image_list_container">
        <div class="content-container">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="media faq-widgets">
                        <div class="media-body">
                            <h5>Dosyalar</h5>
                            <p>Burada hiç dosya bulunmuyor</p>
                        </div>
                        <i class="fa fa-folder-o fa-5x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <?php $a = $this->Dependet_id_key;
    $delete_all_id = $item_files[0]->$a; ?>

    <div class="image_list_container">
        <div class="content-container">
            <table class="table table-bordered table-striped table-hover pictures_list">
                <thead>
                <tr>
                    <th class="order"><i class="fa fa-reorder"></i></th>
                    <th>Dosya Adı</th>
                    <th>
                        <a href="<?php echo base_url("Company/download_all/$item->id"); ?>">
                            <i style="font-size: 18px;" class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                        </a>
                    </th>
                    <th>
                        <a onclick="deleteConfirmationFile(this)"
                           url="<?php echo base_url("Company/fileDelete_all/$delete_all_id"); ?>"
                        <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o" aria-hidden="true"></i>
                        </a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($item_files as $file) { ?>
                    <tr id="ord-<?php echo $file->id; ?>">
                        <td class="order w5"><?php echo ext_img($file->img_url); ?></td>
                        <td><?php echo filenamedisplay($file->img_url); ?></td>
                        <td class="w15">
                            <a href="<?php echo base_url("Company/file_download/$file->id"); ?>">
                                <i style="font-size: 18px;" class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            <a onclick="deleteConfirmationFile(this)"
                               url="<?php echo base_url("Company/fileDelete/$file->id"); ?>"
                            <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                               aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>



