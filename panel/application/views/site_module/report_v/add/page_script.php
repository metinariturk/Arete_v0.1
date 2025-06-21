<script>
    // Tüm scriptleri tek bir blokta veya ayrı bir JS dosyasında toplayın.
    // Fonksiyonları bir namespace (nesne) altında gruplayarak global kirliliği önleyin.
    // Özel Flatpickr CSS'ini sadece bir kez eklemek için kontrol
    function ensureFlatpickrStyles() {
        if (!document.getElementById('flatpickr-custom-styles')) {
            var style = document.createElement('style');
            style.id = 'flatpickr-custom-styles';
            style.innerHTML = `
                    .has-action { background-color: rgba(0, 255, 0, 0.3) !important; color: black !important; }
                    .in-range { background-color: rgba(255, 0, 0, 0.3) !important; color: white !important; }
                `;
            document.head.appendChild(style);
        }
    }

    function initializeFlatpickr() {
        ensureFlatpickrStyles();

        var phpDates = <?php echo json_encode(!empty($dates) ? $dates : []); ?>;

        var fpConfig = {
            dateFormat: "d-m-Y",
            locale: "tr",
            allowInput: true,
            disableMobile: true,
            maxDate: "today",
            position: "auto center"
        };

        // Bu kontrolü güçlendirelim ve foreach içinde de kontrol edelim
        if (phpDates && Array.isArray(phpDates) && phpDates.length > 0) {
            var coolDates = [];
            phpDates.forEach(function (dateString) {
                // Her dateString'in geçerli bir string olduğundan emin olun
                if (typeof dateString === 'string' && dateString.length > 0) { // <-- EK KONTROL BURADA
                    var dateParts = dateString.split('-');
                    var jsDate = new Date(dateParts[0], parseInt(dateParts[1]) - 1, dateParts[2]);
                    jsDate.setHours(0, 0, 0, 0);
                    coolDates.push(jsDate.getTime());
                } else {
                    console.warn("Flatpickr: Geçersiz tarih formatı algılandı, atlanıyor:", dateString);
                }
            });

            // Eğer coolDates boşsa, startDate ve endDate hatalarına karşı koruma
            if (coolDates.length > 0) {
                var coolDatesSet = new Set(coolDates);
                var startDate = new Date(phpDates[phpDates.length - 1]);
                startDate.setHours(0, 0, 0, 0);
                var endDate = new Date(phpDates[0]);
                endDate.setHours(0, 0, 0, 0);

                fpConfig.onDayCreate = function (dObj, dStr, fp, dayElem) {
                    if (coolDatesSet.has(dayElem.dateObj.getTime())) {
                        dayElem.className += " has-action";
                    }
                    if (!coolDatesSet.has(dayElem.dateObj.getTime()) && dayElem.dateObj >= startDate && dayElem.dateObj <= endDate) {
                        dayElem.className += " in-range";
                    }
                };
            } else {
                console.warn("Flatpickr: Filtrelenmiş geçerli tarih bulunamadı, özel renklendirme devre dışı.");
            }
        }

        flatpickr(".flatpickr", fpConfig);
    }

    function initializeRepeater() {
        // Repeater'ı DOM'dan kaldırıp tekrar eklediğimizde
        // eski instance'ı yok etme veya yeniden başlatma stratejisi önemlidir.
        // jquery.repeater'ın destroy metodu yoksa, formun HTML'i yenilendiğinde
        // otomatik olarak eski instance temizlenir ve yenisi başlatılır.
        $('.repeater').repeater({
            repeaters: [{
                selector: '.inner-repeater'
            }],
            hide: function (deleteElement) {
                if (confirm('Bu satırı Silmek İstediğinize Emin Misiniz?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            // Boş item'lar otomatik silinsin mi kontrolü eklenebilir.
            // show: function () { $(this).slideDown(); } // Opsiyonel: Yeni item'ın animasyonla gelmesi
        });
        // Select2 gibi kütüphaneleri de burada yeniden başlatmanız gerekebilir:
        $('[data-plugin="select2"]').select2();
    }

    function handleOffDaysSwitch() {
        var offDaysSwitch = document.getElementById('off_days');
        var workSections = document.getElementById('work_sections');

        if (offDaysSwitch && workSections) { // Elementler varsa çalıştır
            // Başlangıç durumu için hemen kontrol et
            workSections.style.display = offDaysSwitch.checked ? 'block' : 'none';

            offDaysSwitch.addEventListener('change', function () {
                workSections.style.display = this.checked ? 'block' : 'none';
            });
        }
    }

    function submitReportForm() {
        var form = $("#reportForm");
        // Eğer formda dosya yükleme varsa FormData kullanın, yoksa serialize() yeterli.
        // HTML'de enctype="multipart/form-data" varsa, buna dikkat edin.
        // var formData = new FormData(form[0]); // Dosya yükleme için
        var formData = form.serialize(); // Sadece form verileri için

        $.ajax({
            type: "POST",
            url: "<?= base_url('report/save/' . $site->id) ?>",
            data: formData,
            dataType: "json",
            // Eğer formData kullanıyorsanız, şu iki satırı ekleyin:
            // processData: false,
            // contentType: false,

            success: function (response) {
                if (response.success) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else if (response.message) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı',
                            text: response.message
                        }).then(() => {
                            // Formu temizle veya sayfayı yenile gibi işlemler
                            location.reload();
                        });
                    }
                } else {
                    // BAŞARISIZ İSE
                    // Form HTML'ini yeniden yükle ve scriptleri yeniden başlat
                    $("#formContainer").html(response.form_html);
                    initializeFlatpickr();
                    initializeRepeater(); // initializeFormScripts'i initializeRepeater olarak adlandırın
                    handleOffDaysSwitch(); // Switch'i de yeniden başlatın
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Daha detaylı hata yönetimi
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: 'Bir hata oluştu. Lütfen tekrar deneyin. (' + textStatus + ': ' + errorThrown + ')'
                });
            }
        });
    }

    // DOM yüklendiğinde ilk başlatmaları yap
    $(document).ready(function () {
        initializeRepeater(); // Repeater'ı başlat
        initializeFlatpickr(); // Flatpickr'ı başlat
        handleOffDaysSwitch(); // Switch'i başlat

        // submitBtn'e click listener ata
        $(document).on("click", "#submitBtn", function () {
            submitReportForm();
        });
    });
</script>