<script>
    $(document).ready(function() {

        // enable fileuploader plugin
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
                url: "<?php echo $upload_function; ?>",
                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,
                beforeSend: null,
                onSuccess: function(result, item) {
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
                        // go out from success function by calling onError function
                        // in this case we have a animation there
                        // you can also response in PHP with 404
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
                // AJAX isteği ile dosyanın sunucudan silinmesi
                $.ajax({
                    url: "<?php echo base_url($this->router->fetch_class()."/filedelete_java/$item->id/"); ?>", // Silme işlemini gerçekleştirecek endpoint
                    type: 'POST',
                    data: {
                        fileName: item.name // Dosyanın adı
                    },
                    success: function(response) {
                        if (response.success) {
                            // Sunucu silme işlemini başarıyla tamamladı
                            console.log('Dosya başarıyla silindi:', item.name);
                        } else {
                            // Sunucu bir hata mesajı döndürdü
                            console.error(item.id, response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // AJAX isteği başarısız oldu
                        console.error('Bir hata oluştu:', error);
                    }
                });

                // Dosyanın listeden hemen kaldırılmasını önlemek için false döndürün
                return true;
            },
            captions: $.extend(true, {}, $.fn.fileuploader.languages['tr'], {}),
        });

    });
</script>
