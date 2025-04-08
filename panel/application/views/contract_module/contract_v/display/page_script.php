<script>
    function start_collection_table() {
        // DataTable başlat
        var table = $('#collectionTable').DataTable({
            "order": [[1, 'desc']], // 2. sütun (Ödeme Tarihi) tarih sıralaması ile başlasın
            "columnDefs": [
                {
                    "targets": 1, // 2. sütun (Ödeme Tarihi)
                    "render": function(data, type, row, meta) {
                        // Eğer veri type 'display' ise, tarihi istediğiniz formata dönüştür
                        if (type === 'display') {
                            // Y-m-d formatını d-m-Y formatına çevir
                            var date = new Date(data);
                            var day = ('0' + date.getDate()).slice(-2);  // Gün
                            var month = ('0' + (date.getMonth() + 1)).slice(-2); // Ay
                            var year = date.getFullYear(); // Yıl
                            return day + '-' + month + '-' + year; // d-m-Y formatı
                        }
                        return data;
                    }
                }
            ],
            "paging": true, // Sayfalama
            "searching": true, // Arama
            "ordering": true, // Sıralama
        });
    }

    $(document).ready(function() {
        // Fonksiyonu çağır
        start_collection_table();
    });

    function start_advance_table() {
        // DataTable başlat
        var table = $('#advanceTable').DataTable({
            "order": [[1, 'desc']], // 2. sütun (Ödeme Tarihi) tarih sıralaması ile başlasın
            "columnDefs": [
                {
                    "targets": 1, // 2. sütun (Ödeme Tarihi)
                    "render": function(data, type, row, meta) {
                        // Eğer veri type 'display' ise, tarihi istediğiniz formata dönüştür
                        if (type === 'display') {
                            // Y-m-d formatını d-m-Y formatına çevir
                            var date = new Date(data);
                            var day = ('0' + date.getDate()).slice(-2);  // Gün
                            var month = ('0' + (date.getMonth() + 1)).slice(-2); // Ay
                            var year = date.getFullYear(); // Yıl
                            return day + '-' + month + '-' + year; // d-m-Y formatı
                        }
                        return data;
                    }
                }
            ],
            "paging": true, // Sayfalama
            "searching": true, // Arama
            "ordering": true, // Sıralama
        });
    }

    $(document).ready(function() {
        // Fonksiyonu çağır
        start_advance_table();
    });

    function start_bond_table() {
        // DataTable başlat
        var table = $('#bondTable').DataTable({
            "order": [[1, 'desc']], // 2. sütun (Ödeme Tarihi) tarih sıralaması ile başlasın
            "columnDefs": [
                {
                    "targets": 1, // 2. sütun (Ödeme Tarihi)
                    "render": function(data, type, row, meta) {
                        // Eğer veri type 'display' ise, tarihi istediğiniz formata dönüştür
                        if (type === 'display') {
                            // Y-m-d formatını d-m-Y formatına çevir
                            var date = new Date(data);
                            var day = ('0' + date.getDate()).slice(-2);  // Gün
                            var month = ('0' + (date.getMonth() + 1)).slice(-2); // Ay
                            var year = date.getFullYear(); // Yıl
                            return day + '-' + month + '-' + year; // d-m-Y formatı
                        }
                        return data;
                    }
                }
            ],
            "paging": true, // Sayfalama
            "searching": true, // Arama
            "ordering": true, // Sıralama
        });
    }

    $(document).ready(function() {
        // Fonksiyonu çağır
        start_bond_table();
    });

</script>

<script>
    function submit_modal_form(formId, modalId, successDivId, errorDivId, DataTable = null) {
        var form = $('#' + formId)[0]; // Form elementini seç
        var url = $(form).data('form-url'); // Formun action URL'sini al
        var formData = new FormData(form); // Form verilerini FormData olarak al

        $.ajax({
            type: 'POST', // POST isteği gönder
            url: url, // URL'yi belirle
            data: formData, // Form verilerini ekle
            contentType: false, // Content-Type'ı false yap (FormData için gerekli)
            processData: false, // Veriyi işleme (FormData için gerekli)
            dataType: 'json', // JSON yanıt bekleniyor
            success: function(response) {
                if (response.status === 'success') {
                    // Başarılı cevap gelirse:
                    $('#' + successDivId).html(response.html); // Div'e yeni içeriği yükle

                    // DataTable'ı kontrol et ve yeniden başlat
                    if ($.fn.DataTable.isDataTable(DataTable)) {
                        $(DataTable).DataTable().destroy();
                    }

                    // DataTable ID'sine göre uygun fonksiyonu çalıştır
                    if (DataTable === 'collectionTable') {
                        start_collection_table();
                    } else if (DataTable === 'advanceTable') {
                        start_advance_table();
                    } else if (DataTable === 'bondTable') {
                        start_bond_table();
                    } else if (DataTable === 'paymentTable') {
                        start_payment_table();
                    }

                    // Modal'ı kapat
                    $('#' + modalId).modal('hide');
                    $('body').removeClass('modal-open'); // Body'den modal-open class'ını kaldır
                    $('.modal-backdrop').remove(); // Modal arka planını temizle

                    // Formdaki inputları temizle
                    $('#' + formId)[0].reset(); // Formu sıfırla

                } else if (response.status === 'error') {
                    // Hata cevabı gelirse:
                    $('#' + errorDivId).html(response.html); // Hata mesajını errorDivId içine yükle
                    $('#' + modalId).modal('show'); // Modalı açık tut
                    initializeFlatpickr();
                }
            },
            error: function(xhr, status, error) {
                // AJAX isteği başarısız olursa:
                console.error('Form gönderiminde hata oluştu: ', error);
                console.error('Hata Detayı: ', xhr.responseText);
                alert('Form gönderiminde bir hata oluştu. Lütfen tekrar deneyin.');
                initializeFlatpickr(); // Flatpickr tekrar çalıştır
            }
        });
    }
</script>


<script>
    function delete_this_item(element) {
        // URL'yi al
        var url = element.getAttribute('data');

        // Tıklanan öğenin üstündeki div'in ID'sini al
        var divID = element.closest('.col-12').id; // Burada div'in ID'sini alıyoruz

        // Onay penceresi
        if (confirm('Bu dosyayı silmek istediğinize emin misiniz?')) {
            // AJAX isteği gönder
            fetch(url, {
                method: 'GET'
            })
                .then(response => response.text())
                .then(data => {
                    // Silme işlemi başarılıysa
                    if (data.includes("Dosya başarıyla silindi.")) {
                        // Belirtilen div'i DOM'dan kaldır
                        var divToRemove = document.getElementById(divID);
                        if (divToRemove) {
                            divToRemove.remove();
                        }
                        alert(data); // Başarı mesajını göster
                    } else {
                        alert(data); // Hata mesajını göster
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                });
        }
    }
</script>

<script>
    function edit_modal_form(FormURL, ModalForm, ModalId) {
        // AJAX ile modal içeriğini yenile
        $.ajax({
            url: FormURL,
            type: 'GET',
            success: function (response) {
                // Modalın içeriğini güncelle
                $('#' + ModalForm).html(response); // Gelen yanıtı modal içeriğine ekle

                // Modalı aç
                $('#' + ModalId).modal('show');

                // Flatpickr'ı yeniden başlat
                flatpickr(".flatpickr", {
                    dateFormat: "d-m-Y",
                    locale: "tr",
                    allowInput: true,
                    disableMobile: true
                });

                // Modal padding ve overflow ayarlarını sıfırla (gerekirse)
                $('body').css('padding-right', '');
                $('body').css('overflow', '');
            },
            error: function () {
                alert('Modal içeriği yüklenirken bir hata oluştu.');
            }
        });
    }
</script>


<!--Stok verisi sil başı-->
<script>
    function confirmDelete(deleteUrl, refreshDiv, DataTable = null) {
        // Kullanıcıdan onay al
        Swal.fire({
            title: 'Silme İşlemi',
            text: "Bunu silmek istediğinize emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, sil',
            cancelButtonText: 'Hayır, iptal et'
        }).then((result) => {
            if (result.isConfirmed) {
                // Onay verildiğinde AJAX ile silme işlemi
                $.ajax({
                    url: deleteUrl, // Kontrolör URL'sini kullan
                    type: 'POST',
                    dataType: 'json', // JSON veri tipi
                    success: function (response) {
                        if (response.html) {
                            // HTML içeriğini response'dan al ve div'e ekle
                            $(refreshDiv).html(response.html);
                        }

                        // DataTable'ı kontrol et ve yeniden başlat
                        if ($.fn.DataTable.isDataTable(DataTable)) {
                            $(DataTable).DataTable().destroy();
                        }

                        // DataTable ID'sine göre uygun fonksiyonu çalıştır
                        if (DataTable === 'collectionTable') {
                            start_collection_table();
                        } else if (DataTable === 'advanceTable') {
                            start_advance_table();
                        } else if (DataTable === 'bondTable') {
                            start_bond_table();
                        } else if (DataTable === 'paymentTable') {
                            start_payment_table();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: 'Hata',
                            text: 'Silme işlemi sırasında bir hata oluştu.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

</script>
<!--Stok verisi sil sonu-->


<script>
    // Dosya Yükleme Scripti
    function initializeFileUploader(itemId) {
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
                url: "<?php echo base_url('Contract/file_upload/'); ?>" + itemId,
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
                    url: "<?php echo base_url('Contract/filedelete_java/'); ?>" + itemId,
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
    $(document).ready(function() {
        var itemId = <?php echo json_encode($item->id); ?>; // Örneğin, PHP'den alınan item ID'si
        initializeFileUploader(itemId); // Dosya yükleyiciyi başlat
    });
</script>

<!--İş Grupları-->

<script>
    function add_group(anchor) {
        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_list").html(response);
        })
    }

    function add_group_machine(anchor) {
        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_list_machine").html(response);
        })
    }

</script>


<script>

    function deleteFolder(icon) {
        var folderName = icon.getAttribute("data-folder-name");
        var contractId = icon.getAttribute("data-contract-id");

        Swal.fire({
            title: folderName + " klasörünü silmek istediğinize emin misiniz?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Evet, sil!",
            cancelButtonText: "Vazgeç"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('Contract/delete_folder') ?>",
                    type: "POST",
                    data: { folderName: folderName, contractId: contractId },
                    success: function(response) {
                        if (response.success) {
                            $(icon).closest('.col-12').remove(); // Kartı kaldır
                            Swal.fire("Silindi!", "Klasör başarıyla silindi.", "success");
                        } else {
                            Swal.fire("Hata!", "Silme işlemi başarısız: " + response.message, "error");
                        }
                    },
                    error: function(xhr) {
                        Swal.fire("Hata!", "Bir hata oluştu, lütfen tekrar deneyin.", "error");
                    }
                });
            }
        });
    }


    function sendFolderData(element) {

        let folderName = element.dataset.folderName || "";
        let contractID = element.dataset.contractId || "";
        let parentName = element.dataset.parentName || "";
        // AJAX isteği

        $.ajax({
            url: '<?= base_url('Contract/folder_open') ?>', // Controller ve method yolu
            type: 'POST',
            data: {
                folder_name: folderName,
                contractID: contractID, // Klasör ID'sini de gönderiyoruz
                parent_name: parentName, // Klasör ID'sini de gönderiyoruz
            },
            success: function(response) {
                // Eğer başarılıysa yapılacak işlemler
                console.log('Klasör adı: ' + folderName + ' ID: ' + contractID);
                console.log(response); // Server'dan gelen yanıt

                // Gelen yanıtı 'sub_folder' ID'sine sahip div'e yerleştiriyoruz
                $('#sub_folder').html(response);
            },
            error: function(xhr, status, error) {
                console.log("Bir hata oluştu: " + error);
            }
        });
    }

    $(document).ready(function () {
        // Belirli bir formun submit olayı
        $('#newFolderForm').on('submit', function (e) {
            e.preventDefault(); // Sayfa yenilemeyi engelle

            // Form verilerini al
            var formData = $(this).serialize();

            // Input alanındaki data-item-id değerini al
            var itemID = $('#folderName').data('item-id');

            // AJAX ile form ve itemID'yi gönder
            $.ajax({
                url: '<?= base_url("Contract/create_folder/") ?>' + itemID, // PHP kontrolör yolu
                type: 'POST',
                data: formData, // Form verilerini POST ile gönder
                success: function (response) {
                    // Modal'ı kapat
                    $('#newFolderModal').modal('hide');

                    // Example div'i yenile

                    // Formu sıfırla
                    $('#newFolderForm')[0].reset();
                },
                error: function (xhr, status, error) {
                    console.error('Bir hata oluştu:', error);
                    console.log('Hata Detayı:', xhr.responseText); // Sunucudan gelen hata mesajı
                    alert('Klasör oluşturulurken bir hata oluştu.');
                }
            });
        });
    });

    function deleteFile(encodedPath) {
        // Silme işlemi için AJAX
        $.ajax({
            url: '<?php echo base_url("Contract/delete_file/"); ?>' + encodedPath,
            type: 'GET',
            success: function(response) {
                // Dosya başarıyla silindiyse, sayfayı yenileyin veya başarı mesajı gösterin
                alert(response);  // Başarı veya hata mesajını gösterir
                location.reload(); // Sayfayı yenileyebilirsiniz
            },
            error: function(xhr, status, error) {
                alert('Silme işlemi sırasında bir hata oluştu!');
            }
        });
    }



</script>

<!-- Favori İşareti-->
<script>
    function changeIcon(anchor) {
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            // Gerekirse response verisini işleyebilirsiniz
        });

        var icon = anchor.querySelector("i");
        var text = anchor.querySelector("span");

        // İkon sınıfını değiştir
        icon.classList.toggle('fa-star');
        icon.classList.toggle('fa-times');

        // Metni ve rengi değiştir
        if (text.innerText === "Favori Ekle") {
            text.innerText = "Favori Çıkart";
            icon.style.color = "tomato"; // Favori çıkartıldığında kırmızı çarpı
        } else {
            text.innerText = "Favori Ekle";
            icon.style.color = "gold"; // Favori eklendiğinde sarı yıldız
        }
    }

    function change_Status(anchor) {
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            // Gerekirse response verisini işleyebilirsiniz
        });

        var icon = anchor.querySelector("i");
        var text = anchor.querySelector("span");

        // Duruma göre ikon ve metin değişimi
        if (text.innerText === "Tamamlandı Olarak İşaretle") {
            text.innerText = "Devam Ediyor Olarak İşaretle";
            icon.classList.remove('fa-check');
            icon.classList.add('fa-circle-o-notch');
            icon.style.color = "blue";  // Devam ediyor rengi mavi
        } else {
            text.innerText = "Tamamlandı Olarak İşaretle";
            icon.classList.remove('fa-circle-o-notch');
            icon.classList.add('fa-check');
            icon.style.color = "green";  // Tamamlandı rengi yeşil
        }
    }

</script>
<!-- Favori İşareti Son-->


<script>
    function initializeFlatpickr() {
        flatpickr(".flatpickr", {
            dateFormat: "d-m-Y",
            locale: "tr",
            allowInput: true,
            disableMobile: true
        });
    }

    $(document).ready(function () {
        initializeFlatpickr(); // Sayfa yüklendiğinde çalıştır
    });

    function open_modal(modalId) {
        var modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
        initializeFlatpickr(); // Modal açılınca Flatpickr'ı çalıştır
    }
</script>