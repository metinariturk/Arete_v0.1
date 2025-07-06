<div class="container mt-5"> <div class="card p-4 shadow-sm"> <h2 class="card-title text-center mb-4">CSV Dosyası Yükle</h2>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php echo form_open_multipart('Rebar/yukle_csv', ['class' => 'mb-4']); ?>
        <div class="mb-3">
            <label for="csv_dosyasi" class="form-label">Lütfen bir CSV dosyası seçin:</label>
            <input type="file" class="form-control" name="csv_dosyasi" id="csv_dosyasi" accept=".csv" required>
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
                                <a href="#" class="btn btn-info btn-sm me-2 file-link" data-encoded-path="<?php echo $encoded_path; ?>">İçeriği Görüntüle</a>
                                <a href="<?php echo site_url('Rebar/download_file/' . $encoded_path); ?>" class="btn btn-secondary btn-sm me-2">Ham Dosyayı İndir</a>
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

    </div> <script>
        $(document).ready(function() {
            // Dosya seçildiğinde adını gösterme
            $('#csv_dosyasi').on('change', function() {
                var fileName = $(this).val().split('\\').pop(); // Dosya yolundan sadece adı al
                if (fileName) {
                    $('#file_name_display').text('Seçilen Dosya: ' + fileName);
                } else {
                    $('#file_name_display').text('Henüz dosya seçilmedi.');
                }
            });

            // Dosya listesindeki linklere tıklama olayı
            $('.file-link').on('click', function(e) {
                e.preventDefault();

                var encodedPath = $(this).data('encoded-path');
                var url = '<?php echo site_url("Rebar/render_csv_table/"); ?>' + encodedPath;

                $('#rebar_optimizer_content').html('<p class="text-center text-muted">CSV içeriği yükleniyor...</p>');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    success: function(response_html) {
                        $('#rebar_optimizer_content').html(response_html);

                        $('#processCsvData').on('click', function() {
                            var formData = {};
                            formData.rows = [];

                            $('#csvDataForm tbody tr').each(function(rowIndex) {
                                var rowData = {};
                                $(this).find('input').each(function() {
                                    var inputName = $(this).attr('name');
                                    var matches = inputName.match(/rows\[(\d+)\]\[(.*?)\]/);

                                    if (matches && matches.length >= 3) {
                                        var key = matches[2];
                                        rowData[key] = $(this).val();
                                    }
                                });
                                formData.rows.push(rowData);
                            });

                            var jsonPayload = JSON.stringify(formData);

                            console.log("Gönderilecek JSON Verisi:", jsonPayload);

                            $.ajax({
                                url: '<?php echo site_url("Rebar/process_json_data"); ?>',
                                type: 'POST',
                                contentType: 'application/json',
                                data: jsonPayload,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status === 'success') {
                                        alert('Veriler başarıyla işlendi: ' + response.message);
                                    } else {
                                        alert('Veri işlenirken hata: ' + response.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    alert('Veri gönderilirken bir hata oluştu. Konsolu kontrol edin.');
                                    console.error("JSON Gönderim Hatası:", status, error, xhr.responseText, xhr);
                                }
                            });
                        });

                    },
                    error: function(xhr, status, error) {
                        $('#rebar_optimizer_content').html('<div class="alert alert-danger" role="alert">Dosya içeriği yüklenirken bir hata oluştu. Lütfen konsolu kontrol edin. <br> Hata Detayı: ' + xhr.responseText + '</div>');
                        console.error("AJAX Error:", status, error, xhr.responseText, xhr);
                    }
                });
            });

            // Silme butonu click olayı
            $('.delete-file-btn').on('click', function(e) {
                e.preventDefault();

                var encodedPath = $(this).data('encoded-path');
                var deleteUrl = '<?php echo site_url("Rebar/delete_file/"); ?>' + encodedPath;
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