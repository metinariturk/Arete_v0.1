
<script>
    function initializeFormScripts() {
        // Repeater
        $('.repeater').repeater({
            repeaters: [{
                selector: '.inner-repeater'
            }],
            hide: function (deleteElement) {
                if (confirm('Bu satırı Silmek İstediğinize Emin Misiniz?')) {
                    $(this).slideUp(deleteElement);
                }
            },
        });
    }

    // Sayfa ilk yüklendiğinde initializeFormScripts bir kere çalışacak
    $(document).ready(function() {
        initializeFormScripts();
    });
</script>

<script>

    function initializeFlatpickr() {
        var phpDates = <?php echo json_encode($dates); ?>; // PHP'den gelen JSON verisini alıyoruz

        var coolDates = [];
        phpDates.forEach(function(dateString) {
            // 'Y-m-d' formatındaki tarihi JavaScript Date objesine çeviriyoruz
            var dateParts = dateString.split('-');
            var jsDate = new Date(dateParts[0], parseInt(dateParts[1]) - 1, dateParts[2]);

            // Saat bilgisini sıfırlıyoruz (sadece tarih kısmına odaklanıyoruz)
            jsDate.setHours(0, 0, 0, 0);

            coolDates.push(jsDate.getTime()); // Milisaniye cinsinden değeri coolDates'e ekliyoruz
        });

// coolDates dizisini bir Set'e dönüştürerek hızlı arama yapıyoruz
        var coolDatesSet = new Set(coolDates);

// Start tarihi, PHP'den gelen son tarih (arraydeki son tarih)
        var startDate = new Date(phpDates[phpDates.length - 1]); // PHP'den gelen son tarih
        startDate.setHours(0, 0, 0, 0); // Saat bilgisini sıfırlıyoruz

// End tarihi, PHP'den gelen ilk tarih (arraydeki ilk tarih)
        var endDate = new Date(phpDates[0]); // PHP'den gelen ilk tarih
        endDate.setHours(0, 0, 0, 0); // Saat bilgisini sıfırlıyoruz

// flatpickr'ı yapılandırıyoruz
        flatpickr(".flatpickr", {
            dateFormat: "d-m-Y",
            locale: "tr",
            allowInput: true,
            disableMobile: true,
            maxDate: "today", // Bugünden sonra tarihleri engelliyoruz
            defaultDate: "today", // Bugünün tarihini varsayılan olarak ayarla
            position: "auto center", // Takvimi ortadan açacak şekilde konumlandır
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                // Eğer gün tarihi, PHP'den gelen tarihler arasında varsa, özel bir sınıf ekliyoruz
                if (coolDatesSet.has(dayElem.dateObj.getTime())) {
                    dayElem.className += " has-action";
                }

                // Eğer gün PHP'den gelen tarihlerde yoksa ve belirtilen tarih aralığındaysa kırmızı renkte boyuyoruz
                if (!coolDatesSet.has(dayElem.dateObj.getTime()) && dayElem.dateObj >= startDate && dayElem.dateObj <= endDate) {
                    dayElem.className += " in-range"; // in-range sınıfını ekliyoruz
                }
            }
        });

// CSS ile 'in-range' sınıfına transparan renkler ekliyoruz
        var style = document.createElement('style');
        style.innerHTML = `
    .has-action {
        background-color: rgba(0, 255, 0, 0.3) !important; /* Açık yeşil */
        color: black !important;
    }
    .in-range {
        background-color: rgba(255, 0, 0, 0.3) !important; /* Açık kırmızı */
        color: white !important;
    }
`;
        document.head.appendChild(style);
    }

    $(document).ready(function () {
        initializeFlatpickr(); // Sayfa yüklendiğinde çalıştır
    });
</script>

<script>
    document.getElementById('off_days').addEventListener('change', function () {
        var workSections = document.getElementById('work_sections');
        if (this.checked) {
            workSections.style.display = 'block'; // Çalışma Var
        } else {
            workSections.style.display = 'none';  // Çalışma Yok
        }
    });

    // Sayfa yüklenince de doğru durumda olsun:
    window.addEventListener('DOMContentLoaded', function () {
        var event = new Event('change');
        document.getElementById('off_days').dispatchEvent(event);
    });
</script>

<script>
    function submitReportForm() {
        var formData = $("#reportForm").serialize(); // Form verilerini al

        $.ajax({
            type: "POST",
            url: "<?= base_url('report/save/'.$site->id) ?>", // kendi kayıt url'in
            data: formData,
            dataType: "json",

            success: function(response) {
                if (response.success) {
                    // BAŞARILI İSE
                    if (response.redirect) {
                        // Redirect varsa, yönlendir
                        window.location.href = response.redirect;
                    } else if (response.message) {
                        // Mesaj varsa, ekrana göster (SweetAlert, toastr vs. kullanabilirsin)
                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı',
                            text: response.message
                        }).then(() => {
                            // İstersen sonra başka bir şey yap
                            location.reload(); // örneğin sayfayı yenile
                        });
                    }
                } else {
                    // BAŞARISIZ İSE
                    $("#formContainer").html(response.form_html);
                    initializeFlatpickr(); // Sayfa yüklendiğinde çalıştır
                    initializeFormScripts();
                }
            },
            error: function () {
                alert("Bir hata oluştu. Lütfen tekrar deneyin.");
            }
        });
    }

    // Butona basınca fonksiyon çalışacak
    $(document).on("click", "#submitBtn", function () {
        submitReportForm();
    });
</script>