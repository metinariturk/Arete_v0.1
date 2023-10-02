<?php if (empty($item_files)) { ?>

    <div class="alert alert-info text-center">
        <p>Burada herhangi bir dosya bulunmamaktadır.</a></p>
    </div>

<?php } else { ?>
    <?php $a = $this->Dependet_id_key;
    $delete_all_id = $item_files[0]->$a; ?>
    <?php if ($subViewFolder=="update") { $from = "update_form"; } elseif ($subViewFolder=="display") { $from = "file_form";} elseif ($subViewFolder=="statement") { $from = "statement_form";} ?>

    <table class="table table-bordered table-striped table-hover pictures_list">
        <thead>
        <th class="order"><i class="fa fa-reorder"></i></th>
        <th>#id</th>
        <th>Dosya Adı</th>
        <th>İşlem
            <a onclick="deleteConfirmationFile(this)" data-text="Tüm Dosyaları"
               data-url="<?php echo base_url("$this->Module_Name/fileDelete_all/$delete_all_id/$from"); ?>">
               <span data-tooltip-location="top"
                     data-tooltip="Tümünü Sil">
               <i style="font-size: 18px; color: Tomato;" class="fa fa-ban" aria-hidden="true"></i>
            </a>
        </thead>
        <tbody>
        <?php foreach ($item_files as $file) { ?>
            <tr id="ord-<?php echo $file->id; ?>">
                <td class="order w5"><?php echo ext_img($file->img_url); ?></td>
                <td class="w5c">#<?php echo $file->id; ?></td>
                <td><?php echo filenamedisplay($file->img_url); ?></td>
                <td class="w15">
                    <a href="<?php echo base_url("$this->Module_Name/file_download/$file->id/$from"); ?>">
                        <i style="font-size: 18px;" class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                    </a>
                    <a onclick="deleteConfirmationFile(this)" data-text="Bu Dosyayı"
                       data-url="<?php echo base_url("$this->Module_Name/fileDelete/$file->id/$from"); ?>">
                        <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
<?php } ?>



