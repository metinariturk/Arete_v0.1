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
                    "file" => base_url($path) . $file,
                    "local" => base_url($path) . $file,
                );
            }
            $preloadedFiles = json_encode($preloadedFiles);
            ?>
            <input type="file" name="files" data-fileuploader-files='<?php echo $preloadedFiles; ?>'>
        </form>
    </div>
</div>
