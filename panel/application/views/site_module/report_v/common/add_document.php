<div class="file-content">
    <div class="fileuploader fileuploader-theme-dragdrop">
        <form method="post" enctype="multipart/form-data">
            <?php
            $uploadDir = $path;  // Dizin yolu
            $preloadedFiles = array();  // Önceden yüklenmiş dosyaları tutacak dizi

            // Dosya yolu var mı kontrol et
            if (!empty($uploadDir) && is_dir($uploadDir)) {
                $uploadsFiles = array_diff(scandir($uploadDir), array('.', '..'));  // Dizin içeriğini tarar

                foreach ($uploadsFiles as $file) {
                    if (is_dir($uploadDir . $file))
                        continue;  // Klasörleri atla

                    $preloadedFiles[] = array(
                        "name" => $file,
                        "auc_id" => $item->id,
                        "type" => FileUploader::mime_content_type($uploadDir . $file),
                        "size" => filesize($uploadDir . $file),
                        "file" => base_url($path) . $file,
                        "local" => base_url($path) . $file,
                    );
                }
            }

            // Preloaded files dizisini JSON formatına çevir
            $preloadedFiles = !empty($preloadedFiles) ? json_encode($preloadedFiles) : '[]';
            ?>
            <input type="file" name="files" data-fileuploader-files='<?php echo $preloadedFiles; ?>'>
        </form>
    </div>
</div>