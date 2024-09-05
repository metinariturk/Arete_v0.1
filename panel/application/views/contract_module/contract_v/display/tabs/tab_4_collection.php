<table class="table" id="collection_table">
    <thead>
    <tr>
        <th colspan="3">TOPLAM YAPILAN ÖDEME</th>
        <th>
            <?php echo money_format(sum_anything("collection", "tahsilat_miktar", "contract_id", $item->id)); ?>
            <?php echo "$item->para_birimi"; ?>
        </th>
    </tr>
    </thead>
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th>Tarihi</th>
        <th>Ödeme Türü/Açıklama</th>
        <th class="d-none d-sm-table-cell">Tutarı</th>
    </tr>
    </thead>
    <tbody>

    <?php if (!empty($collections)) { ?>
        <?php foreach ($collections as $collection) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <?php echo $collection->id; ?>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo dateFormat_dmy($collection->tahsilat_tarih); ?>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo $collection->tahsilat_turu; ?> / <?php echo $collection->aciklama; ?>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <?php echo money_format($collection->tahsilat_miktar) . " " . get_currency($item->id); ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3">
            TOPLAM
        </td>
        <td>
            <?php echo money_format(sum_anything("collection", "tahsilat_miktar", "contract_id", $item->id)); ?>
            <?php echo "$item->para_birimi"; ?>
        </td>
    </tr>
    </tfoot>
</table>

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