<table class="table-lg table-border-horizontal" id="collection_table">
    <thead>
    <tr>
        <th colspan="3"><p>TOPLAM YAPILAN ÖDEME</p></th>
        <th>
            <p><?php echo money_format(sum_anything("collection", "tahsilat_miktar", "contract_id", $item->id)); ?>
                <?php echo "$item->para_birimi"; ?></p>
        </th>
    </tr>
    </thead>
    <thead>
    <tr>
        <th class="d-none d-sm-table-cell"><i class="fa fa-reorder"></i></th>
        <th><p>Tarihi</p></th>
        <th><p>Ödeme Türü/Açıklama</p></th>
        <th class="d-none d-sm-table-cell"><p>Tutarı</p></th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($collections)) { ?>
        <?php foreach ($collections as $collection) { ?>
            <tr id="center_row">
                <td class="d-none d-sm-table-cell">
                    <p><?php echo $collection->id; ?></p>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <p><?php echo dateFormat_dmy($collection->tahsilat_tarih); ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <p><?php echo $collection->tahsilat_turu; ?> / <?php echo $collection->aciklama; ?></p>
                    </a>
                </td>
                <td>
                    <a target="_blank" href="<?php echo base_url("collection/file_form/$collection->id"); ?>">
                        <p><?php echo money_format($collection->tahsilat_miktar) . " " . get_currency($item->id); ?></p>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"><p>TOPLAM</p></td>
        <td>
            <p><?php echo money_format(sum_anything("collection", "tahsilat_miktar", "contract_id", $item->id)); ?>
                <?php echo "$item->para_birimi"; ?></p>
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