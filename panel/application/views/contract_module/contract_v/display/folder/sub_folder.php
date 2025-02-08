<div class="card">
    <div class="card-body file-manager">
        <?php if (isset($folder_name)) { ?>
            <h4 class="mb-3"><?php echo module_name($folder_name); ?></h4>

            <?php if ($folder_count > 0) { ?>
                <h5>Klasörler</h5>
                <div class="row">
                    <?php
                    // Dizin içindeki klasörleri listele
                    foreach ($folders as $folder) {
                        if ($folder != '.' && $folder != '..') {
                            $file_path = $sub_path . DIRECTORY_SEPARATOR . $folder;
                            if (is_dir($file_path)) {
                                // Klasörse
                                $sub_files = scandir($file_path);
                                $sub_file_count = count($sub_files) - 2; // "." ve ".." dosyalarını çıkar
                                ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card folder-box">
                                        <div class="card-body text-center">
                                            <i class="fa fa-folder f-36 txt-warning" style="cursor: pointer"
                                               data-folder-name="<?= $folder_name ?>"
                                               data-contract-id="<?= $item->id ?>"
                                               data-parent-name="<?= htmlspecialchars($folder, ENT_QUOTES, 'UTF-8') ?>"
                                               onclick="sendFolderData(this)"></i>
                                            <h6 class="mt-3"><?= $folder ?></h6>
                                            <p><?= $sub_file_count ?> dosya</p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            <?php } ?>
            <!-- Dosyalar Grubu -->
            <h5>Dosyalar  <?php echo !empty($folder_id) ? "- ".$folder_id : ""; ?></h5>
            <ul class="files">
                <script>
                    // Dosya Yükleme Scripti
                    function initializeFileUploader(itemId) {
                        $('input[name="files_<?php echo $folder_name; ?>"]').fileuploader({
                            changeInput: '<div class="fileuploader-input">' +
                                '<div class="fileuploader-input-inner">' +
                                '<div class="fileuploader-icon-main"></div>' +
                                '<h3 class="fileuploader-input-caption"><span>${captions.feedback}</span></h3>' +
                                '<p>${captions.or}</p>' +
                                '<button type="button" class="fileuploader-input-button"><span>${captions.button}</span></button>' +
                                '</div>' +
                                '</div>',
                            theme: 'dragdrop',
                            upload: {
                                url: "<?php echo base_url("Contract/file_upload/$folder_name/$item->id/$folder_id"); ?>",
                                data: null,
                                type: 'POST',
                                enctype: 'multipart/form-data',
                                start: true,
                                synchron: true,
                                beforeSend: null,
                                onSuccess: function (result, item) {
                                    var data = {};

                                    // get data
                                    if (result && result.files)
                                        data = result;
                                    else
                                        data.hasWarnings = true;

                                    // if success
                                    if (data.isSuccess && data.files[0]) {
                                        item.name = data.files[0].name;
                                        item.html.find('.column-title > div:first-child').text(data.files[0].name).attr('title', data.files[0].name);
                                    }

                                    // if warnings
                                    if (data.hasWarnings) {
                                        for (var warning in data.warnings) {
                                            alert(data.warnings[warning]);
                                        }

                                        item.html.removeClass('upload-successful').addClass('upload-failed');
                                        return this.onError ? this.onError(item) : null;
                                    }

                                    item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');
                                    setTimeout(function () {
                                        item.html.find('.progress-bar2').fadeOut(400);
                                    }, 400);
                                },
                                onError: function (item) {
                                    var progressBar = item.html.find('.progress-bar2');

                                    if (progressBar.length) {
                                        progressBar.find('span').html(0 + "%");
                                        progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                                        item.html.find('.progress-bar2').fadeOut(400);
                                    }

                                    if (item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0) {
                                        item.html.find('.column-actions').prepend(
                                            '<button type="button" class="fileuploader-action fileuploader-action-retry" title="Retry"><i class="fileuploader-icon-retry"></i></button>'
                                        );
                                    }
                                },
                                onProgress: function (data, item) {
                                    var progressBar = item.html.find('.progress-bar2');

                                    if (progressBar.length > 0) {
                                        progressBar.show();
                                        progressBar.find('span').html(data.percentage + "%");
                                        progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                                    }
                                },
                                onComplete: null,
                            },
                            onRemove: function (item, listEl, parentEl, newInputEl, inputEl) {
                                // AJAX isteği ile dosyanın sunucudan silinmesi
                                $.ajax({
                                    url: "<?php echo base_url("Contract/filedelete_java/$folder_name/"); ?>" + itemId,
                                    type: 'POST',
                                    data: {
                                        fileName: item.name // Dosyanın adı
                                    },
                                    success: function (response) {
                                        if (response.success) {
                                            // Sunucu silme işlemini başarıyla tamamladı
                                            console.log('Dosya başarıyla silindi:', item.name);
                                        } else {
                                            // Sunucu bir hata mesajı döndürdü
                                            console.error(item.id, response.message);
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        // AJAX isteği başarısız oldu
                                        console.error('Bir hata oluştu:', error);
                                    }
                                });

                                // Dosyanın listeden hemen kaldırılmasını önlemek için false döndürün
                                return true;
                            },
                            captions: $.extend(true, {}, $.fn.fileuploader.languages['tr'], {}),
                        });
                    }

                    // Sayfa yüklendiğinde dosya yükleyici fonksiyonunu başlat
                    $(document).ready(function () {
                        var itemId = <?php echo json_encode($item->id); ?>; // Örneğin, PHP'den alınan item ID'si
                        initializeFileUploader(itemId); // Dosya yükleyiciyi başlat
                    });
                </script>
                <div class="file-content">
                    <div class="fileuploader fileuploader-theme-dragdrop">
                        <form method="post" enctype="multipart/form-data">
                            <?php
                            $uploadDir = $sub_path . DIRECTORY_SEPARATOR;
                            $preloadedFiles = array();
                            $uploadsFiles = array_diff(scandir($uploadDir), array('.', '..'));
                            foreach ($uploadsFiles as $file) {
                                if (is_dir($uploadDir . $file))
                                    continue;
                                $preloadedFiles[] = array(
                                    "name" => $file,
                                    "type" => FileUploader::mime_content_type($uploadDir . $file),
                                    "size" => filesize($uploadDir . $file),
                                    "file" => base_url($sub_path . DIRECTORY_SEPARATOR) . $file,
                                    "local" => base_url($sub_path . DIRECTORY_SEPARATOR) . $file,
                                );
                            }
                            $preloadedFiles = json_encode($preloadedFiles);
                            ?>
                            <input type="file" name="files_<?php echo $folder_name; ?>"
                                   data-fileuploader-files='<?php echo $preloadedFiles; ?>'>
                        </form>
                    </div>
                </div>
            </ul>
        <?php } else { ?>
            <h5>Klasörler</h5>
            <div class="row">
                <?php
                // Dizin içindeki klasörleri listele
                foreach ($main_folders as $main_folder) {
                    if ($main_folder != '.' && $main_folder != '..') {
                        $file_path = $main_path . DIRECTORY_SEPARATOR . $main_folder;
                        if (is_dir($file_path)) {
                            // Klasörse
                            $sub_files = scandir($file_path);
                            $sub_file_count = count($sub_files) - 2; // "." ve ".." dosyalarını çıkar
                            ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                <div class="card folder-box">
                                    <div class="card-body text-center">
                                        <i class="fa fa-folder f-36 txt-warning" style="cursor: pointer"
                                           data-folder-name="<?= $main_folder ?>"
                                           data-contract-id="<?= $item->id ?>"
                                           data-parent-name=""
                                           onclick="sendFolderData(this)"></i>
                                        <h6 class="mt-3"><?= module_name($main_folder) ?></h6>
                                        <p><?= $sub_file_count ?> dosya</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
