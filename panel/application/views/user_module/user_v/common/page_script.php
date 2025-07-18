<script>
    // ✅ Input Maskeleri Uygulayan Fonksiyon
    function applyInputMasks() {
        $("#phone").inputmask("(599) 999 99 99", {
            placeholder: "_",
            showMaskOnHover: false
        });

        $("#user_name").inputmask({
            regex: "^[a-zA-Z0-9_]{3,15}$",
            placeholder: "_"
        });

        $("#IBAN").inputmask("TR 99 9999 9999 9999 9999 9999 99");
    }

    // ✅ Flatpickr Tarih Seçici
    function initializeFlatpickr() {
        flatpickr(".flatpickr", {
            dateFormat: "d-m-Y",
            locale: "tr",
            allowInput: true,
            disableMobile: true
        });
    }

    // ✅ Ortak Başlatıcı (Tüm UI bileşenlerini burada çağır)
    function initializeUIComponents() {
        applyInputMasks();
        initializeFlatpickr();
        // Gerekirse: initializeSelect2(), initTooltips() vs...
    }

    // ✅ Sayfa ilk yüklendiğinde çalıştır
    $(document).ready(function () {
        initializeUIComponents();
    });

    // ✅ Tüm checkbox'ları tek tuşla seçme
    function toggleAllCheckboxes(group) {
        var checkboxes = document.querySelectorAll("." + group + " input[type='checkbox']");
        var masterCheckbox = document.getElementById("masterCheckbox_" + group);

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = masterCheckbox.checked;
        }
    }

    // ✅ Kullanıcı detayı gösterme (AJAX)
    function show_user_detail(ItemID) {
        var formAction = '<?php echo base_url("user/user_detail/"); ?>' + ItemID;

        $.post(formAction, function (response) {
            $(".user_details").html(response);
            initializeUIComponents(); // Eğer response içinde inputlar varsa maske uygula
        });
    }

    // ✅ Modal açarken Flatpickr (ve diğerleri) çalıştır
    function open_modal(modalId) {
        var modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
        initializeUIComponents();
    }

    // ✅ Modal içindeki formu AJAX ile gönder
    function submit_modal_form(formId, modalId = null, successDivId, errorDivId, DataTable = null) {
        var form = $('#' + formId)[0];
        var url = $(form).data('form-url');
        var formData = new FormData(form);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#' + successDivId).html(response.html);

                    // Eğer modalId tanımlıysa modalı kapat
                    if (modalId) {
                        $('#' + modalId).modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }

                    // Formu sıfırla
                    $('#' + formId)[0].reset();

                    // UI bileşenlerini yeniden başlat
                    initializeUIComponents();

                    // DataTable varsa yeniden yükle
                    if (DataTable) {
                        DataTable.ajax.reload(null, false);
                    }

                } else if (response.status === 'error') {
                    $('#' + errorDivId).html(response.html);

                    // Eğer modalId tanımlıysa modalı tekrar göster
                    if (modalId) {
                        $('#' + modalId).modal('show');
                    }

                    // Hatalı içerikte bileşenleri tekrar başlat
                    initializeUIComponents();
                }
            },
            error: function (xhr, status, error) {
                console.error('Form gönderiminde hata oluştu:', error);
                console.error('Hata Detayı:', xhr.responseText);
                alert('Form gönderiminde bir hata oluştu veya yetkiniz yok. Lütfen tekrar deneyin.');

                // AJAX hatasında da bileşenleri tekrar başlat
                initializeUIComponents();
            }
        });
    }

    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: 'Silme İşlemi',
            text: "Bu kullanıcıyı silmek istediğinize emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, sil',
            cancelButtonText: 'Hayır, iptal et'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(deleteUrl, function (response) {
                    let res = JSON.parse(response);
                    Swal.fire({
                        title: res.success ? 'Başarılı' : 'Uyarı',
                        text: res.message,
                        icon: res.success ? 'success' : 'warning'
                    }).then(() => {
                        if (res.success && res.redirect) {
                            window.location.href = res.redirect;
                        }
                    });
                }).fail(() => {
                    Swal.fire('Hata', 'İşlem sırasında bir hata oluştu.', 'error');
                });
            }
        });
    }




</script>


<!--verisi sil başı-->


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

                initializeUIComponents(); // ✅ Hatalı içerikte de input maskeleri yeniden uygula

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

<script>
    function loadDynamicContent(button) {
        const url = button.getAttribute("data-url");
        const target = button.getAttribute("data-target") || "#update-form";

        $.ajax({
            url: url,
            type: "POST",
            success: function (response) {
                $(target).html(response);
                initializeUIComponents(); // ✅ Hatalı içerikte de input maskeleri yeniden uygula
            },

            error: function (xhr, status, error) {
                console.error("Hata oluştu:", error);
                $(target).html("<div class='alert alert-danger'>İçerik yüklenemedi.</div>");
            }
        });
    }
</script>
<script>
    function cancelConfirmationModule(button) {
        swal.fire({
            title: 'Emin misiniz?',
            text: "Yaptığınız değişiklik varsa kaydedilmeyecektir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-arrow-circle-o-left fa-lg"></i> Değişiklik Yapmayacağım',
            cancelButtonText: 'Düzenlemeye Devam Et <i class="fa fa-arrow-circle-o-right fa-lg"></i>'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = button.getAttribute('url');
            }
        });
    }
</script>
