<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--// Modal içindeki Formu Gönderip Belirli bir Div'i refresh eden script başı -->
<script>
    $(document).ready(function() {
        $('#PaymentTable').DataTable({
            "pageLength": 25, // Her sayfada 25 öğe göster
            "order": [[0, 'desc']] // 0. sütun (ilk sütun) göre azalan sıralama
        });
    });

    $('#collectionTable').DataTable({
        "order": [[1, 'desc']],  // Tarih sütununu yeniden eskiye sıralar (index 1)
        "columnDefs": [
            {
                "targets": 1,  // 1, tarih sütununu belirtir.
                "render": function(data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        // Y-m-d formatındaki tarihi d-m-Y formatına dönüştür
                        var dateParts = data.split('-');  // Y-m-d formatında ayır
                        var day = dateParts[2].replace(/\s+/g, '');  // Day kısmındaki boşlukları temizle
                        var month = dateParts[1].replace(/\s+/g, '');  // Month kısmındaki boşlukları temizle
                        var year = dateParts[0].replace(/\s+/g, '');  // Year kısmındaki boşlukları temizle
                        // d-m-Y formatında birleştir
                        return day + '-' + month + '-' + year;  // - ile birleştir
                    }
                    return data;
                }
            }
        ]
    });

    $('#bondTable').DataTable({
        "order": [[1, 'desc']],  // Tarih sütununu yeniden eskiye sıralar (index 1)
    });

    $('#advanceTable').DataTable({
        "order": [[1, 'desc']],  // Tarih sütununu yeniden eskiye sıralar (index 1)
        "columnDefs": [
            {
                "targets": 1,  // 1, tarih sütununu belirtir.
                "render": function(data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        // Y-m-d formatındaki tarihi d-m-Y formatına dönüştür
                        var dateParts = data.split('-');  // Y-m-d formatında ayır
                        var day = dateParts[2].replace(/\s+/g, '');  // Day kısmındaki boşlukları temizle
                        var month = dateParts[1].replace(/\s+/g, '');  // Month kısmındaki boşlukları temizle
                        var year = dateParts[0].replace(/\s+/g, '');  // Year kısmındaki boşlukları temizle
                        // d-m-Y formatında birleştir
                        return day + '-' + month + '-' + year;  // - ile birleştir
                    }
                    return data;
                }
            }
        ]
    });

</script>
<script>
    function submit_modal_form(formId, modalId, DivId) {
        var form = $('#' + formId)[0];
        var url = $(form).data('form-url');
        var formData = new FormData(form);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // JSON yanıt bekleniyor
            success: function(response) {
                if (response.status === 'success') {
                    // Başarılı durum: Div'i yenile ve modalı kapat
                    if (response.refreshDivId) {
                        $('#' + response.refreshDivId).load(location.href + " #" + response.refreshDivId + " > *", function() {
                            // Div güncellendikten sonra DataTable'ı yeniden başlat
                            if (response.dataTableId) {
                                var table = $('#' + response.dataTableId);
                                if ($.fn.DataTable.isDataTable(table)) {
                                    table.DataTable().clear().destroy(); // Mevcut DataTable'ı temizle ve yok et
                                }
                                table.DataTable({
                                    "order": [[1, 'desc']],  // Tarih sütununu yeniden eskiye sıralar (index 1)
                                    "columnDefs": [
                                        {
                                            "targets": 1,  // 1, tarih sütununu belirtir.
                                            "render": function(data, type, row) {
                                                if (type === 'display' || type === 'filter') {
                                                    // Y-m-d formatındaki tarihi d-m-Y formatına dönüştür
                                                    var dateParts = data.split('-');  // Y-m-d formatında ayır
                                                    var day = dateParts[2].replace(/\s+/g, '');  // Day kısmındaki boşlukları temizle
                                                    var month = dateParts[1].replace(/\s+/g, '');  // Month kısmındaki boşlukları temizle
                                                    var year = dateParts[0].replace(/\s+/g, '');  // Year kısmındaki boşlukları temizle
                                                    // d-m-Y formatında birleştir
                                                    return day + '-' + month + '-' + year;  // - ile birleştir
                                                }
                                                return data;
                                            }
                                        }
                                    ]
                                }); // DataTable'ı yeniden başlat
                            }
                        });
                    }

                    // Datepicker'ı yeniden başlat
                    $('.datepicker-here').datepicker({
                        dateFormat: 'dd-mm-yyyy'
                    });

                    if (response.closeModalId) {
                        $('#' + response.closeModalId).modal('hide'); // Modalı kapat
                        $('.modal-backdrop').remove(); // Arkaplanı temizle
                    }

                } else if (response.status === 'error') {
                    // Hata durumu: Form hatalarını göster ve modalı açık bırak
                    $('#' + DivId).html(response.formErrorHtml);
                    $('#' + modalId).modal('show'); // Hata modali açık kalmalı
                }
            },
            error: function(xhr, status, error) {
                console.error('Form gönderiminde hata oluştu: ', error);
                console.error('Hata Detayı: ', xhr.responseText);
                alert('Form gönderiminde bir hata oluştu. Lütfen tekrar deneyin.');
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
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('body').css('padding-right', '');
        $('body').css('overflow', 'auto');
    });
</script>
<!--// Modal içindeki Formu Gönderip Belirli bir Div'i refresh eden script  sonu-->

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

                $('.datepicker-here').datepicker({
                    language: 'tr',
                    dateFormat: 'dd-mm-yyyy'
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
            text: "Bu stok hareketini silmek istediğinize emin misiniz?",
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

                    success: function (response) {
                        $(refreshDiv).html(response);

                        if ($.fn.DataTable.isDataTable(DataTable)) {
                            $(DataTable).DataTable().destroy();
                        }

                        // DataTable yoksa, yeni bir DataTable başlat
                        if (!$.fn.DataTable.isDataTable('#' + DataTable)) {
                            $('#' + DataTable).DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                // Diğer DataTable ayarları
                            });
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
    function delete_stock_enter() {
        Swal.fire({
            icon: 'warning',
            title: 'Uyarı',
            text: 'Stok hareketi olan girişi silemezsiniz, önce stok hareketlerini dikkatli bir şekilde temizleyiniz.',
            confirmButtonText: 'Tamam'
        });
    }
</script>

<script>
    function empty_stock() {
        Swal.fire({
            icon: 'warning',
            title: 'Uyarı',
            text: 'Stokta ürün kalmadığı için bu işlemi yapamazsınız.',
            confirmButtonText: 'Tamam'
        });
    }
</script>

<script>
    $(document).ready(function () {
        $('#report_table').DataTable({
            "columnDefs": [
                {"type": "date", "targets": [1]} // Burada 1, "report_date" sütununun index numarasıdır
            ],
            "order": [[1, "desc"]], // İstenilen sıralama
            language: {
                "sEmptyTable": "Hiç kayıt yok",
                "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
                "sInfoEmpty": "Kayıt yok",
                "sInfoFiltered": "(_MAX_ kayıt içinden filtrelendi)",
                "sLengthMenu": "Sayfa başına _MENU_ kayıt",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing": "İşleniyor...",
                "sSearch": "Ara:",
                "sZeroRecords": "Eşleşen kayıt bulunamadı",
                "oPaginate": {
                    "sFirst": "İlk",
                    "sLast": "Son",
                    "sNext": "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending": ": artan sıralamak için aktif hale getir",
                    "sSortDescending": ": azalan sıralamak için aktif hale getir"
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#stock-table').DataTable({
            "columnDefs": [
                {"width": "5%", "targets": 0}, // İşlem sütunu
                {"width": "25%", "targets": 1}, // Stok Adı sütunu
                {"width": "15%", "targets": 2}, // Birim sütunu
                {"width": "7%", "targets": 3}, // Miktarı sütunu
                {"width": "7%", "targets": 4}, // Kalan sütunu
                {"width": "10%", "targets": 5}, // Tarihi sütunu
                {"width": "30%", "targets": 6}, // Açıklama sütunu
                {"width": "5%", "targets": 7}   // Sil sütunu
            ],
            "autoWidth": false, // Otomatik genişliği kapat
            ordering: false,
            "responsive": true, // Mobil uyumluluk
            "lengthMenu": [10, 15, 20, 25], // Sayfa başına gösterilecek kayıt sayısı
            "language": {
                "search": "Ara:",
                "lengthMenu": "Göster _MENU_ kayıt",
                "info": "_TOTAL_ kayıt arasından _START_ - _END_ arası gösteriliyor",
                "paginate": {
                    "next": "Sonraki",
                    "previous": "Önceki"
                }
            }
        });
    });
</script>

<script>
    function change_list(div_id, url, DataTable) {
        // İlk olarak AJAX çağrısı başlatıyoruz
        $.ajax({
            url: url, // PHP'den gelen URL
            type: 'GET', // Yöntem
            success: function (response) {
                // AJAX başarılı olursa div'in içeriğini güncelle
                $("#" + div_id).html(response);
                // Eğer DataTable varsa önce destroy edelim
                if ($.fn.DataTable.isDataTable("#personelTable")) {
                    $("#" + DataTable).DataTable().destroy();
                }

                // DataTable'ı tekrar başlat
                $("#" + DataTable).DataTable({
                    // DataTable ayarlarınızı buraya ekleyebilirsiniz
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true
                });
            },
            error: function () {
                // Hata durumu
                alert("Veri alınırken bir hata oluştu!");
            }
        });
    }
</script>


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


<script>
    let isTextEnlarged = false; // Toggle durumu için kontrol değişkeni

    function openPersonModal(iban, bank, name, position, social, date, editUrl) {
        const modalBody = document.getElementById('personModalBody');
        modalBody.innerHTML = `
        <p style="font-size: 1em"><strong>İsim:</strong> ${name}
            <button onclick="copyToClipboard('${name}')" style="border:none; background:none; cursor:pointer;">
                📋
            </button>
        </p>
        <p><strong>TC Kimlik No:</strong> ${social}</p>
        <p style="font-size: 1em" id="ibanText" onclick="toggleTextSize()" ><strong>IBAN:</strong> <span> ${iban}</span>
            <button onclick="copyToClipboard('${iban}')" style="border:none; background:none; cursor:pointer;">
                📋
            </button>
        </p>
        <p><strong>Bank:</strong> ${bank}</p>
        <p><strong>Görev:</strong> ${position}</p>
        <p><strong>Giriş/Çıkış Tarihi:</strong> ${date}</p>
       <p class="d-sm-none">
            <a data-bs-toggle="modal" class="text-primary"
               onclick="edit_modal_form('${editUrl}', 'edit_personel_modal', 'EditPersonelModal')">
               <i class="fa fa-edit fa-lg"></i> Düzenle
            </a>
        </p>
    `;

        var myModal = new bootstrap.Modal(document.getElementById('personModal'));
        myModal.show();
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert(text + ' başarıyla kopyalandı!');
        }).catch(err => {
            alert('Kopyalama işlemi başarısız oldu');
        });
    }

    function toggleTextSize() {
        const ibanText = document.getElementById('ibanText');
        if (isTextEnlarged) {
            ibanText.style.fontSize = '1em'; // Normal boyuta geri döndür
            ibanText.style.cursor = 'zoom-in'; // Küçültürken imleci zoom-in yap
        } else {
            ibanText.style.fontSize = '2em'; // Büyük boyuta ayarla
            ibanText.style.cursor = 'zoom-out'; // Büyüdüğünde imleci zoom-out yap
        }
        isTextEnlarged = !isTextEnlarged; // Toggle durumunu değiştir
    }
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

<!--Rapor İmza Ayarı-->


<script>
    $(document).ready(function () {
        $(".sortable").sortable();
        $(".sortable").on("sortupdate", function (event, ui) {
            var $data = $(this).sortable("serialize");
            var $data_url = $(this).data("url");
            $.post($data_url, {data: $data}, function (response) {
                // İsteğe bağlı: yanıtı işleyebilirsiniz
            });
        });
    });
</script>


<script>
    function delete_sign(btn) {
        var $url = btn.getAttribute('url');
        var $div = btn.getAttribute('div');

        Swal.fire({
            title: "Tüm isimler silinecek?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sil",
            cancelButtonText: "İptal",
            reverseButtons: true,
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.post($url, {}, function (response) {
                    $("." + $div).html(response);
                    $(".sortable").sortable();
                    $(".sortable").on("sortupdate", function (event, ui) {
                        var $data = $(this).sortable("serialize");
                        var $data_url = $(this).data("url");
                        $.post($data_url, {data: $data}, function (response) {
                            // İsterseniz burada bir işlem yapabilirsiniz
                        });
                    });
                });
                Swal.fire("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });
            } else {
                Swal.fire("Dosya Güvende");
            }
        });
    }
</script>


<script>
    function add_sign(anchor) {
        var formId = anchor.getAttribute('form-id');
        var divId = $("#" + formId).attr("div");
        var formAction = $("#" + formId).attr("action");
        var formData = $("#" + formId).serialize();

        $.post(formAction, formData, function (response) {
            $("." + divId).html(response);
            $(".sortable").sortable();
            $(".sortable").on("sortupdate", function (event, ui) {
                var $data = $(this).sortable("serialize");
                var $data_url = $(this).data("url");
                $.post($data_url, {data: $data}, function (response) {
                })
            })
        });
    }
</script>

<script>
    function delete_sign(btn) {
        var $url = btn.getAttribute('url');
        var $div = btn.getAttribute('div');

        Swal.fire({
            title: "Bu isim silinecek?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sil",
            cancelButtonText: "İptal",
            reverseButtons: true,
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.post($url, {}, function (response) {
                    $("." + $div).html(response);
                    $(".sortable").sortable();
                    $(".sortable").on("sortupdate", function (event, ui) {
                        var $data = $(this).sortable("serialize");
                        var $data_url = $(this).data("url");
                        $.post($data_url, {data: $data}, function (response) {
                        });
                    });
                });

                Swal.fire("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                Swal.fire("Dosya Güvende");
            }
        });
    }
</script>
<script>
    $(document).ready(function () {
        $("#mySelect").select2({
            matcher: function (params, data) {
                // Arama kutusu boşsa tüm sonuçları göster
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Küçük-büyük harf farkını kaldır
                const term = params.term.toLowerCase();
                const text = data.text.toLowerCase();

                // Aranan terim metnin herhangi bir yerinde geçiyorsa eşleştir
                if (text.indexOf(term) > -1) {
                    return data;
                }

                // Diğerlerini hariç tut
                return null;
            }
        });
    });
</script>


<script>
    function sendFolderData(folderName, contractID, folderID = null) {
        // AJAX isteği
        $.ajax({
            url: '<?= base_url('Contract/folder_open') ?>', // Controller ve method yolu
            type: 'POST',
            data: {
                folder_name: folderName,
                contractID: contractID, // Klasör ID'sini de gönderiyoruz
                folder_id: folderID // folder_id null olabilir
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
