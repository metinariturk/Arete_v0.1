<?php

// Dizin içeriğini al
$files = scandir($sub_path);

// Klasör sayısını hesaplamak için bir değişken
$folder_count = 0;

// Dizin içindeki her dosyayı kontrol et
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $file_path = $sub_path . DIRECTORY_SEPARATOR . $file;
        // Eğer bu bir klasörse
        if (is_dir($file_path)) {
            $folder_count++;
        }
    }
}
?>
<div class="file-content">
    <div class="card">
        <div class="card-header">
            <div class="media">
                <form class="form-inline" action="#" method="get">
                    <div class="form-group mb-0"><i class="fa fa-search"></i>
                        <input class="form-control-plaintext" type="text" placeholder="Ara...">
                    </div>
                </form>
                <div class="media-body text-end">

                    <i class="fa fa-plus-square fa-2x" data-bs-toggle="modal" data-bs-target="#newFolderModal" style="cursor: pointer;"></i>

                    <!-- Modal -->
                    <div class="modal fade" id="newFolderModal" tabindex="-1" aria-labelledby="newFolderModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="newFolderModalLabel">Yeni Klasör Oluştur</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="newFolderForm">
                                        <input type="text" class="form-control" id="folderName" name="folderName" data-item-id="<?= $item->id ?>" placeholder="Klasör adını girin" required>
                                        <button type="submit" class="btn btn-primary">Klasör Oluştur</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body file-manager">
            <?php if ((isset($folder_name)) and ($folder_name != "Contract")) { ?>
            <h4 class="mb-3"><?php echo module_name($folder_name); ?></h4>

            <?php if ($folder_count > 0) {
                ; ?>
                <!-- Klasörler Grubu (Yan Yana Görüntülenmesi için düzenleme) -->
                <h5>Klasörler</h5>
                <div class="row">
                    <?php
                    // Dizin içindeki klasörleri listele
                    foreach ($files as $file) {
                        if ($file != '.' && $file != '..') {
                            $file_path = $sub_path . DIRECTORY_SEPARATOR . $file;
                            if (is_dir($file_path)) {
                                // Klasörse
                                $sub_files = scandir($file_path);
                                $sub_file_count = count($sub_files) - 2; // "." ve ".." dosyalarını çıkar

                                // Burada PHP değişkenlerini JavaScript'e düzgün şekilde iletebilmek için tırnakları dikkatlice kullanıyoruz
                                echo "<div class='col-12 col-sm-6 col-md-4 col-lg-3 mb-3'>
                    <div class='card folder-box' onclick='loadFolderContent(\"$file\")'>
                        <div class='card-body text-center'>
                            <i class='fa fa-folder f-36 txt-warning' onclick=\"sendFolderData('$folder_name', '$item->id', '$file')\"></i>
                            <h6 class='mt-3'>{$file}</h6>
                            <p>{$sub_file_count} dosya</p>
                        </div>
                    </div>
                  </div>";
                            }
                        }
                    }
                    ?>
                </div>
            <?php } ?>

            <!-- Dosyalar Grubu -->
            <?php if (count($files) > 0) { ?>
            <h5>Dosyalar</h5>
            <ul class="files">
                <?php
                // Dizin içindeki dosyaları listele
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $file_path = $sub_path . DIRECTORY_SEPARATOR . $file;
                        if (is_file($file_path)) {
                            // Dosya ise
                            $file_size = filesize($file_path);
                            $creation_time = date("Y-m-d H:i:s", filectime($file_path)); // Dosyanın oluşturulma tarihi
                            ?>
                            <li class='file-box'>
                                <div class='file-top'>
                                    <?php echo ext_img($file); ?>
                                </div>
                                <div class='file-bottom'>
                                    <h6><?php echo $file; ?></h6>
                                    <p class='mb-1'><?php echo round($file_size / 1024 / 1024, 2); ?> MB</p>
                                    <p><b>Oluşturulma Tarihi: </b><?php echo $creation_time; ?></p>

                                    <!-- File actions div: Sağda ve solda hizalanmış simgeler -->
                                    <div class="file-actions" style="display: flex; justify-content: space-between; width: 100%;">
                                        <!-- Sol tarafta indir simgesi -->
                                        <div style="text-align: left;">
                                            <a href="<?php echo base_url('contract/download_file/' . urlencode(base64_encode($file_path))); ?>" class="fa fa-download f-14"></a>
                                        </div>
                                        <!-- Sağ tarafta silme simgesi, kırmızı renk -->
                                        <a href="#" onclick="deleteFile('<?php echo urlencode(base64_encode($file_path)); ?>')">
                                            <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <?php
                        }
                    }
                }
                ?>
                <?php } ?>
            </ul>
        </div>
        <?php } else { ?>
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
        <?php } ?>
    </div>
</div>