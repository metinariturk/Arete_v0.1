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
    function submit_modal_form(formId, modalId, successDivId, errorDivId, DataTable = null) {
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
                    $('#' + modalId).modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('#' + formId)[0].reset();

                    initializeUIComponents(); // ✅ Yeni içerikte input maskeleri ve flatpickr uygula
                    if (DataTable) DataTable.ajax.reload(null, false); // Tabloyu yenile (gerekirse)
                } else if (response.status === 'error') {
                    $('#' + errorDivId).html(response.html);
                    $('#' + modalId).modal('show');
                    initializeUIComponents(); // ✅ Hatalı içerikte de input maskeleri yeniden uygula
                }
            },
            error: function (xhr, status, error) {
                console.error('Form gönderiminde hata oluştu: ', error);
                console.error('Hata Detayı: ', xhr.responseText);
                alert('Form gönderiminde bir hata oluştu. Lütfen tekrar deneyin.');
                initializeUIComponents(); // ✅ AJAX hatasında da bileşenleri tekrar yükle
            }
        });
    }
</script>
