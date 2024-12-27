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
    function submit_modal_form(formId, modalId, DivId, DataTable = null) {
        var form = $('#' + formId)[0];  // Form referansını alıyoruz (DOM element olarak)
        var url = $(form).data('form-url');
        var formData = new FormData(form);  // FormData ile form verilerini ve dosyaları alıyoruz

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,  // FormData kullanıyoruz
            contentType: false,  // Dosya yükleme için `false` olmalı
            processData: false,  // Form verilerini manuel olarak işliyoruz
            dataType: 'html',
            success: function (response) {
                $('#' + DivId).html(response); // Gelen yanıtı Div'e ekle
                form.reset(); // Formu temizle

                // HTML yanıtı içerisindeki form_error'u kontrol et
                var formError = $('#form-error').val();

                $('#' + modalId).click(); // Önce modalı aç
                $('.modal-backdrop').remove(); // Modal arka planını kaldır
                $('.datepicker-here').datepicker({
                    language: 'tr',
                    dateFormat: 'dd-mm-yyyy'
                });


            },
            error: function (xhr, status, error) {
                console.error('Form gönderiminde hata oluştu: ', error);
                console.error('Hata Detayı: ', xhr.responseText); // Sunucudan dönen hata mesajı
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

    $(document).ready(function () {
        // FileUploader plugin initialization
        $('input[name="files"]').fileuploader({
            limit: 3, // Tek dosya sınırı
            onSelect: function (item) {
                // Upload butonunu ekliyoruz
                if (!item.html.find('.fileuploader-action-start').length)
                    item.html.find('.fileuploader-action-remove').before('<button type="button" class="fileuploader-action fileuploader-action-start" title="Upload"><i class="fileuploader-icon-upload"></i></button>');
            },
            upload: {
                url: 'php/ajax_upload_file.php', // Yükleme yapılacak PHP dosyası
                type: 'POST',
                enctype: 'multipart/form-data',
                start: false,
                synchron: true,
                beforeSend: function (item) {
                    // Custom dosya adı kontrolü
                    var input = $('#custom_file_name');
                    if (input.length) {
                        item.upload.data.custom_name = input.val(); // Custom adı POST verisine ekle
                    }
                    input.val(""); // Ad alanını sıfırla
                },
                onSuccess: function (result, item) {
                    // Yükleme başarılı olursa dosya adını güncelle
                    var data = result;
                    if (data.isSuccess && data.files[0]) {
                        item.name = data.files[0].name;
                        item.html.find('.column-title div').animate({opacity: 0}, 400);
                    }
                    // Başarı simgesi ve progress bar güncellenmesi
                    item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');
                    setTimeout(function () {
                        item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({opacity: 1}, 400);
                        $('#progress-bar').fadeOut(400);
                    }, 400);
                },
                onError: function (item) {
                    $('#file-progress-bar').hide(); // Hata durumunda progress bar gizlenir
                    alert('Dosya yükleme sırasında hata oluştu.');
                },
                onProgress: function (data, item) {
                    // Progress bar güncelleme
                    $('#file-progress-bar').show();
                    $('#progress-bar').val(data.percentage);
                    $('#progress-percentage').text(data.percentage + '%');
                }
            }
        });
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


<!--Puantaj Tablosu-->


<script>
    function savePuantaj(checkbox) {
        // Checkbox'tan ilgili verileri al
        var workerId = $(checkbox).attr('workerid');
        var date = $(checkbox).attr('date');
        var isChecked = checkbox.checked ? 1 : 0; // CheckBox'ın durumuna göre 1 (checked) veya 0 (unchecked) değeri

        // AJAX isteği gönder
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("$this->Module_Name/update_puantaj/$item->id"); ?>", // Sunucunuzun POST isteğini alacağı adres
            data: {
                workerId: workerId,
                date: date,
                isChecked: isChecked // CheckBox'ın durumu
            },
            success: function (response) {
                // Başarılı yanıt aldığınızda yapılacak işlemler
                $(".puantaj_list").html(response);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>

<script>
    function puantajDate(element) {
        var month = $('select[name="month"]').val();
        var year = $('select[name="year"]').val();

        var url = $('#puantajDate').attr('url');

        $.ajax({
            url: url,
            type: 'POST',
            data: {month: month, year: year},
            success: function (response) {
                $(".puantaj_list").html(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>


<script>
    function sendPuantajDate() {
        // Seçili ay ve yılı al
        var month = $('#month').val();
        var year = $('#year').val();

        // Bağlantı URL'sini oluştur
        var url = '<?php echo base_url("Export/puantaj_print/$item->id"); ?>/' + month + '/' + year;

        // AJAX isteğini gönder
        $.ajax({
            url: url,
            type: 'POST',
            data: {month: month, year: year},
            success: function (response) {
                // AJAX isteği başarılı olduğunda yapılacak işlemler
                console.log("AJAX isteği başarıyla tamamlandı.");
            },
            error: function (xhr, status, error) {
                // AJAX isteği başarısız olduğunda yapılacak işlemler
                console.error("AJAX isteği sırasında bir hata oluştu:", error);
            }
        });

        // Yeni sekme aç
        window.open(url, '_blank');
    }
</script>

<!--Puantaj Tablosu Bitiş-->


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
</script>

<!--Sözleşme Poz Ekleme Ekranı Arama Çubuğu-->
