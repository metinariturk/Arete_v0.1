<script>
    function submit_modal_form(formId, modalId, successDivId, errorDivId) {
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

                    // Feather ikonlarını tekrar yükle
                    if (typeof feather !== 'undefined') {
                        feather.replace();
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

                    // Feather ikonlarını tekrar yükle
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    initializeFlatpickr();
                }
            },
            error: function(xhr, status, error) {
                // AJAX isteği başarısız olursa:
                console.error('Form gönderiminde hata oluştu: ', error);
                console.error('Hata Detayı: ', xhr.responseText);
                alert('Form gönderiminde bir hata oluştu. Lütfen tekrar deneyin.');

                // Feather ikonlarını tekrar yükle
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }

                initializeFlatpickr(); // Flatpickr tekrar çalıştır
            }
        });
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

                // Modalı aç (Bootstrap 5 yöntemine göre)
                var myModal = new bootstrap.Modal(document.getElementById(ModalId), {
                    keyboard: false
                });
                myModal.show();

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
    function confirmDelete(deleteUrl, text ,refreshDiv) {
        // Kullanıcıdan onay al
        Swal.fire({
            title: 'Silme İşlemi',
            text: text + ' silmek istediğine emin misin?',
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

                        // Feather ikonlarını tekrar yükle
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: 'Hata',
                            text: 'Silme işlemi sırasında bir hata oluştu.',
                            icon: 'error'
                        });
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }
                    }
                });
            }
        });
    }

</script>

<script>
    function changeStat(deleteUrl, refreshDiv, DataTable = null) {
        // Kullanıcıdan onay al
        Swal.fire({
            title: 'Not Değişikliği',
            text: "Not silinmeyecektir, sadece durumu düzenlenecek ve hatırlatma iptal edilecektir.?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, durumu değiştir',
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
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: 'Hata',
                            text: 'Silme işlemi sırasında bir hata oluştu.',
                            icon: 'error'
                        });
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }
                    }
                });
            }
        });
    }

</script>

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

