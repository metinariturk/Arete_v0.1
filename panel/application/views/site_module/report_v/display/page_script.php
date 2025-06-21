<script>
    function initFileUploader() {
        // İlk olarak varsa eski fileuploader'ı destroy et (çakışmasın)
        if ($('input[name="files"]').data('fileuploader')) {
            $('input[name="files"]').data('fileuploader').destroy();
        }

        // Preloaded dosyaları JSON olarak al
        let preloadedFiles = $('input[name="files"]').attr('data-fileuploader-files');
        preloadedFiles = preloadedFiles ? JSON.parse(preloadedFiles) : [];

        // Fileuploader başlat
        $('input[name="files"]').fileuploader({
            preloaded: preloadedFiles,
            // İstersen buraya diğer ayarlarını ekle
        });
    }

    $(document).ready(function() {
        initFileUploader();
    });

</script>
<script>
    // PHP'den gelen global değişkenler (site_id'yi de ekledik)
    // Bu kısım, eğer bu script PHP dosyası içinde yer alıyorsa geçerlidir.
    // Eğer ayrı bir .js dosyasıysa, bu değişkenleri farklı bir <script> bloğunda tanımlayıp sonra bu dosyayı dahil edin.
    const BASE_URL = "<?php echo base_url(); ?>";
    const SITE_ID = "<?php echo $site->id; ?>"; // Bu değişkenin PHP tarafından doğruca tanımlandığından emin olun

    // Rapor linkleri objesi (PHP'den JSON olarak geliyor)
    const reportLinks = <?php
        $links = [];
        foreach ($reports as $r) {
            $date = date('Y-m-d', strtotime($r->report_date));
            $links[$date] = $r->id;
        }
        echo json_encode($links);
        ?>;


    // DOM elementlerini seçiyoruz
    const daysTag = document.querySelector(".days"),
        currentDateElement = document.querySelector(".current-date"), // Adını değiştirdim, çakışmayı önlemek için
        prevNextIcon = document.querySelectorAll(".icons span");

    // Takvim durumu için global değişkenler
    // 'let' ile tanımlanmaları önemli, çünkü değerleri değişecek
    let date = new Date(),
        currYear = date.getFullYear(),
        currMonth = date.getMonth();

    // Ayların ve haftanın günlerinin isimleri
    const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz",
        "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];

    // Haftanın günleri için bu diziye gerek kalmadı sanırım, HTML'de Pzt, Sal vs. var.
    // const weekDays = ["Paz", "Pzt", "Sal", "Çar", "Per", "Cum", "Cmt"];


    // Takvimi çizen fonksiyon
    const renderCalendar = () => {
        // Haftanın ilk günü Pazartesi olacak şekilde ayarla
        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay();
        firstDayofMonth = (firstDayofMonth + 6) % 7; // Pazartesi = 0

        // Ayın son günü ve onun haftanın günü (Pazartesi bazlı)
        let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate();
        let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay();
        lastDayofMonth = (lastDayofMonth + 6) % 7;

        // Önceki ayın son günü
        let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();

        let liTag = ""; // Oluşturulacak li elementlerini tutar

        // Önceki ayın son günlerini pasif ekle
        for (let i = firstDayofMonth; i > 0; i--) {
            liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
        }

        // Bugünün tarihi (sadece karşılaştırma için, saat bilgisi olmadan)
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Bugünün başlangıcını al

        // Mevcut ayın günleri
        for (let i = 1; i <= lastDateofMonth; i++) {
            // Günün string hali: YYYY-MM-DD formatında URL ve objeler için
            const dayStr = `${currYear}-${String(currMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const currentDayDate = new Date(currYear, currMonth, i); // Döngüdeki günün Date objesi
            currentDayDate.setHours(0, 0, 0, 0); // Saat bilgisini sıfırla

            // Bugün mü kontrolü
            const isToday = currentDayDate.getTime() === today.getTime();

            // Gelecek gün mü kontrolü
            const isFutureDay = currentDayDate.getTime() > today.getTime();


            // Rapor var mı kontrolü (reportLinks global objesi)
            const reportId = reportLinks[dayStr]; // ID ya da undefined

            let dayContent; // <li> içinde ne göstereceğimizi tutacak (sayı veya <a> etiketi)
            let dayClassList = []; // <li>'ye eklenecek sınıfları tutacak

            // Eğer bugünse 'active' sınıfını ekle
            if (isToday) {
                dayClassList.push('active');
            }

            // Gelecek günleri 'inactive' olarak işaretle ve tıklanamaz yap
            if (isFutureDay) {
                dayClassList.push('inactive'); // Gelecek günlere inactive sınıfını ekle
                dayContent = i; // Link yerine sadece sayı göster
            } else if (reportId) {
                // Raporu olan günler (geçmiş veya bugün)
                dayClassList.push('report-day'); // Raporu olan günlerin görsel stili
                dayContent = `<a href="#" class="report-link" data-id="${reportId}" data-date="${dayStr}">${i}</a>`;
            } else {
                // Raporu olmayan günler (geçmiş veya bugün)
                dayClassList.push('no-report-day'); // Raporsuz günlerin görsel stili (kırmızı)
                dayContent = `<a href="#" class="add-report-link" data-add-url="${BASE_URL}report/new_form/${SITE_ID}/${dayStr}">${i}</a>`;
            }

            liTag += `<li class="${dayClassList.join(' ')}">${dayContent}</li>`;
        }

        // Sonraki ayın ilk günlerini pasif ekle (bu kısımda değişiklik yok)
        for (let i = lastDayofMonth; i < 6; i++) {
            liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
        }

        // Başlık: ay ve yıl günceller
        currentDateElement.innerText = `${months[currMonth]} ${currYear}`;

        // Takvim günlerini DOM'a yazar
        daysTag.innerHTML = liTag;
    };
    renderCalendar(); // İlk yüklemede takvimi çizer


    // Önceki/Sonraki Ay butonları için olay dinleyicisi
    prevNextIcon.forEach(icon => {
        icon.addEventListener("click", () => {
            // currMonth değerini günceller
            currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

            // Yılın değişip değişmediğini kontrol eder
            if (currMonth < 0 || currMonth > 11) {
                // Yeni bir Date objesi oluşturarak yılı ve ayı doğru bir şekilde ayarlar
                date = new Date(currYear, currMonth, 1);
                currYear = date.getFullYear();
                currMonth = date.getMonth();
            } else {
                // Yıl değişmediyse, sadece ay değiştiği için Date objesini günceller
                date = new Date(currYear, currMonth, 1);
            }

            renderCalendar(); // Takvimi yeniden çizer
        });
    });


    // Günlere tıklama olayları için genel dinleyici (Event Delegation)
    document.querySelector('.days').addEventListener('click', e => {
        // Sadece <a> etiketlerine tıklamaları dinle
        if (e.target.tagName === 'A') {
            // 1. Mevcut raporu gösterme (sarı/beyaz günler)
            if (e.target.classList.contains('report-link')) {
                e.preventDefault(); // Sayfa yönlendirmesini engelle (AJAX için)

                const reportId = e.target.getAttribute('data-id');

                // AJAX isteği ile raporu yükle
                fetch(`${BASE_URL}report/refresh_day/${reportId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('refresh_report').innerHTML = data.form_html;
                            // Eğer initFileUploader() fonksiyonu varsa burada çağırılır
                            if (typeof initFileUploader === 'function') {
                                initFileUploader();
                            }
                        } else {
                            console.error('Mevcut rapor yüklenemedi:', data.message || 'Bilinmeyen Hata');
                            alert('Rapor yüklenirken bir hata oluştu: ' + (data.message || 'Lütfen tekrar deneyin.'));
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            }
            // 2. Yeni rapor ekleme sayfasına yönlendirme (kırmızı günler)
            else if (e.target.classList.contains('add-report-link')) {
                e.preventDefault(); // Sayfa yönlendirmesini engelle (yönlendirme için)

                const addUrl = e.target.getAttribute('data-add-url');
                if (addUrl) {
                    window.location.href = addUrl; // Yeni rapor ekleme sayfasına yönlendir
                } else {
                    console.error('Yeni rapor ekleme URL\'si bulunamadı.');
                }
            }
        }
    });

    // initFileUploader fonksiyonu eğer tanımlı değilse, dışarıdan veya burada tanımlanmalıdır
    // function initFileUploader() {
    //     console.log("Dosya yükleyici başlatıldı.");
    //     // Dosya yükleyici bileşenlerini burada başlatın veya yeniden başlatın
    // }

</script>
