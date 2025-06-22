<div class="file-content">
    <?php echo $date = dateFormat_dmy($item->report_date); ?><br>
    <?php echo $path = "uploads/project_v/$project->dosya_no/$site->dosya_no/Reports/$date/";?><br>
    <?php echo $item->id;?><br>

    <?php echo $upload_function = base_url("Report/file_upload/$item->id"); ?>

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
<?php echo $uploadDir; ?>
<script>
    function initFileUploader() {
        if ($('input[name="files"]').data('fileuploader')) {
            $('input[name="files"]').fileuploader('destroy');
        }

        const uploadFunctionUrl = "<?php echo $upload_function; ?>";
        const fileDeleteUrlPrefix = "<?php echo base_url($this->router->fetch_class()."/filedelete_java/"); ?>";

        $('input[name="files"]').fileuploader({
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
                url: uploadFunctionUrl,
                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,
                beforeSend: null,
                onSuccess: function(result, item) {
                    var data = {};

                    if (result && result.files)
                        data = result;
                    else
                        data.hasWarnings = true;

                    if (data.isSuccess && data.files[0]) {
                        item.name = data.files[0].name;
                        item.data.id = data.files[0].id; // Ensure your server returns 'id'
                        item.html.find('.column-title > div:first-child').text(data.files[0].name).attr('title', data.files[0].name);
                    }

                    if (data.hasWarnings) {
                        for (var warning in data.warnings) {
                            alert(data.warnings[warning]);
                        }

                        item.html.removeClass('upload-successful').addClass('upload-failed');
                        return this.onError ? this.onError(item) : null;
                    }

                    item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');
                    setTimeout(function() {
                        item.html.find('.progress-bar2').fadeOut(400);
                    }, 400);
                },
                onError: function(item) {
                    var progressBar = item.html.find('.progress-bar2');

                    if(progressBar.length) {
                        progressBar.find('span').html(0 + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                        item.html.find('.progress-bar2').fadeOut(400);
                    }

                    item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                        '<button type="button" class="fileuploader-action fileuploader-action-retry" title="Retry"><i class="fileuploader-icon-retry"></i></button>'
                    ) : null;
                },
                onProgress: function(data, item) {
                    var progressBar = item.html.find('.progress-bar2');

                    if(progressBar.length > 0) {
                        progressBar.show();
                        progressBar.find('span').html(data.percentage + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                    }
                },
                onComplete: null,
            },
            onRemove: function(item, listEl, parentEl, newInputEl, inputEl) {
                const fileIdToDelete = item.data && item.data.id ? item.data.id : null;

                if (!fileIdToDelete) {
                    console.error('Silinecek dosya ID\'si bulunamadı:', item);
                    return false;
                }

                $.ajax({
                    url: fileDeleteUrlPrefix + fileIdToDelete,
                    type: 'POST',
                    data: {
                        fileName: item.name
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('Dosya başarıyla silindi:', item.name);
                        } else {
                            console.error('Dosya silinirken hata oluştu:', item.name, response.message);
                            alert('Dosya silinirken bir hata oluştu: ' + (response.message || 'Bilinmeyen hata.'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Silme Hatası:', error);
                        alert('Dosya silme sırasında bir ağ hatası oluştu.');
                    }
                });
                return true;
            },
            captions: $.extend(true, {}, $.fn.fileuploader.languages['tr'], {}),
        });
    }
</script>