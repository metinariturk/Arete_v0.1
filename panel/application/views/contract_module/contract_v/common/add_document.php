<div class="file-content">
    <div class="fileuploader fileuploader-theme-dragdrop">
        <form method="post" enctype="multipart/form-data">
            <?php
            $preloadedFiles = array();
            $uploadDir = $path;
            $uploadsFiles = array_diff(scandir($uploadDir), array('.', '..'));
            foreach ($uploadsFiles as $file) {
                if (!is_dir($uploadDir . $file)) {
                    $preloadedFiles[] = array(
                        "name" => $file,
                        "type" => mime_content_type($uploadDir . $file),
                        "size" => filesize($uploadDir . $file),
                        "file" => base_url($path) . $file,
                        "local" => base_url($path) . $file,
                    );
                }
            }
            $preloadedFilesJson = htmlspecialchars(json_encode($preloadedFiles), ENT_QUOTES, 'UTF-8');
            ?>
            <input type="file" name="files" data-fileuploader-files='<?php echo $preloadedFilesJson; ?>'>
        </form>
    </div>
</div>