<script>

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
            url: "<?= base_url('report/update/' . $report->id) ?>",
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
        handleOffDaysSwitch(); // Switch'i başlat

        // submitBtn'e click listener ata
        $(document).on("click", "#submitBtn", function () {
            submitReportForm();
        });
    });
</script>