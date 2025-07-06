<div class="container mt-5"> <div class="card p-4 shadow-sm"> <h2 class="card-title text-center mb-4">Şablon Dosyası Yükle</h2>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php echo form_open_multipart('template/template_upload', ['class' => 'mb-4']); ?>
        <div class="mb-3">
            <label for="template_file" class="form-label">Lütfen bir şablon dosyası seçin:</label>
            <input type="file" class="form-control" name="template_file" id="template_file" required>
            <div class="form-text text-muted" id="file_name_display">Henüz dosya seçilmedi.</div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Yükle</button>
        <?php echo form_close(); ?>

        <div class="file-list mt-4">
            <h3 class="mb-3">Yüklenen Dosyalar (<?php echo html_escape($upload_dir); ?>)</h3>
            <?php if (!empty($uploaded_files)): ?>
                <ul class="list-group"> <?php foreach ($uploaded_files as $file): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo html_escape($file); ?></span>
                            <div class="file-actions">
                                <?php
                                $full_file_path = $upload_dir . $file;
                                $encoded_path = urlencode(base64_encode($full_file_path));
                                ?>
                                <a href="<?php echo site_url('template/download_file/' . $encoded_path); ?>" class="btn btn-secondary btn-sm me-2">İndir</a>
                                <button type="button" class="btn btn-danger btn-sm delete-file-btn" data-encoded-path="<?php echo $encoded_path; ?>">Sil</button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted text-center">Henüz yüklenmiş bir dosya bulunmamaktadır.</p>
            <?php endif; ?>
        </div>

        <div id="rebar_optimizer_content" class="mt-5 p-4 border rounded shadow-sm">
            <p class="text-center text-muted">Bir CSV dosyasına tıklayarak içeriğini burada görüntüleyebilirsiniz.</p>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            // Dosya seçildiğinde adını gösterme
            $('#template_file').on('change', function() {
                var fileName = $(this).val().split('\\').pop(); // Dosya yolundan sadece adı al
                if (fileName) {
                    $('#file_name_display').text('Seçilen Dosya: ' + fileName);
                } else {
                    $('#file_name_display').text('Henüz dosya seçilmedi.');
                }
            });

            // Silme butonu click olayı
            $('.delete-file-btn').on('click', function(e) {
                e.preventDefault();

                var encodedPath = $(this).data('encoded-path');
                var deleteUrl = '<?php echo site_url("template/delete_file/"); ?>' + encodedPath;
                var $listItem = $(this).closest('li');

                if (confirm('"' + $listItem.find('span').text() + '" dosyasını silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                alert(response.message);
                                $listItem.fadeOut(300, function() {
                                    $(this).remove();
                                    if ($('.file-list ul li').length === 0) {
                                        $('.file-list ul').remove();
                                        $('.file-list').append('<p class="text-muted text-center">Henüz yüklenmiş bir dosya bulunmamaktadır.</p>');
                                    }
                                });
                                $('#rebar_optimizer_content').html('<p class="text-center text-muted">Bir CSV dosyasına tıklayarak içeriğini burada görüntüleyebilirsiniz.</p>');
                            } else {
                                alert('Hata: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Dosya silinirken bir hata oluştu. Konsolu kontrol edin.');
                            console.error("Delete AJAX Error:", status, error, xhr.responseText, xhr);
                        }
                    });
                }
            });
        });
    </script>