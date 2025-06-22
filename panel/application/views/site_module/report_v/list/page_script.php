<script>
    // Global BASE_URL tanımı
    var BASE_URL = "<?php echo base_url(); ?>";

    // Takvim için global değişkenler
    let calendarDate = new Date();
    let currentYear = calendarDate.getFullYear();
    let currentMonth = calendarDate.getMonth();
    console.log("JS Yüklendi - Başlangıç Yıl:", currentYear, "Başlangıç Ay:", currentMonth);


    const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz",
        "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];

    let activeSiteId = null;
    let activeReportLinks = {};

    // calendarContainer'ı buraya taşıyoruz, böylece fetchAndRenderCalendar da erişebilir
    let calendarContainer = null; // Başlangıçta null olarak tanımla

    // renderCalendar fonksiyonu (bu fonksiyon, takvim HTML elementlerini DOM'dan yeniden seçecektir)
    const renderCalendar = () => {
        // DOM'dan takvim container'ını tekrar seç (çünkü fetchAndRenderCalendar onu yeniliyor)
        const currentCalendarDiv = calendarContainer.querySelector('.calendar'); // .calendar div'i

        if (!currentCalendarDiv) {
            console.error("Calendar div bulunamadı, takvim çizilemiyor.");
            return;
        }

        const daysTag = currentCalendarDiv.querySelector(".days"); // .calendar div'inin içindeki .days'i seç
        const currentDateElement = calendarContainer.querySelector(".current-date"); // Header'daki mevcut tarih

        console.log("renderCalendar çalışıyor. daysTag:", daysTag, "currentDateElement:", currentDateElement);

        if (!daysTag || !currentDateElement) {
            console.warn("Takvim elementleri bulunamadı. renderCalendar çalıştırılamıyor.");
            return;
        }

        // ... renderCalendar fonksiyonunun geri kalan kodu (yukarıda verdiğim gibi aynı kalsın) ...
        let firstDayofMonth = new Date(currentYear, currentMonth, 1).getDay();
        firstDayofMonth = (firstDayofMonth + 6) % 7;
        let lastDateofMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        let lastDayofMonth = new Date(currentYear, currentMonth, lastDateofMonth).getDay();
        lastDayofMonth = (lastDayofMonth + 6) % 7;
        let lastDateofLastMonth = new Date(currentYear, currentMonth, 0).getDate();
        let liTag = "";

        for (let i = firstDayofMonth; i > 0; i--) {
            liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        for (let i = 1; i <= lastDateofMonth; i++) {
            const dayStr = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const currentDayDate = new Date(currentYear, currentMonth, i);
            currentDayDate.setHours(0, 0, 0, 0);
            const isToday = currentDayDate.getTime() === today.getTime();
            const isFutureDay = currentDayDate.getTime() > today.getTime();
            const reportId = activeReportLinks[dayStr];

            let dayContent;
            let dayClassList = [];

            if (isToday) {
                dayClassList.push('active');
            }

            if (isFutureDay) {
                dayClassList.push('inactive');
                dayContent = i;
            } else if (reportId) {
                dayClassList.push('report-day');
                dayContent = `<a href="#" class="report-link" data-id="${reportId}" data-date="${dayStr}">${i}</a>`;
            } else {
                dayClassList.push('no-report-day');
                dayContent = `<a href="#" class="add-report-link" data-add-url="${BASE_URL}report/new_form/${activeSiteId}/${dayStr}">${i}</a>`;
            }

            liTag += `<li class="${dayClassList.join(' ')}">${dayContent}</li>`;
        }

        for (let i = lastDayofMonth; i < 6; i++) {
            liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
        }

        currentDateElement.innerText = `${months[currentMonth]} ${currentYear}`;
        daysTag.innerHTML = liTag;

        attachCalendarLinkListeners();
    };

    const attachMonthChangeListeners = () => {
        const prevNextIcon = document.querySelectorAll(".icons span");
        prevNextIcon.forEach(icon => {
            icon.removeEventListener("click", handleMonthChange);
            icon.addEventListener("click", handleMonthChange);
        });
    };

    const handleMonthChange = (e) => {
        const icon = e.currentTarget;
        currentMonth = icon.id === "prev" ? currentMonth - 1 : currentMonth + 1;

        if (currentMonth < 0 || currentMonth > 11) {
            calendarDate = new Date(currentYear, currentMonth, 1);
            currentYear = calendarDate.getFullYear();
            currentMonth = calendarDate.getMonth();
        } else {
            calendarDate = new Date(currentYear, currentMonth, 1);
        }

        if (activeSiteId) {
            fetchAndRenderCalendar(activeSiteId, currentYear, currentMonth + 1);
        } else {
            renderCalendar();
        }

        if (activeSiteId) {
            console.log("Ay Değişti - fetchAndRenderCalendar'a gönderilen Yıl:", currentYear, "Ay:", currentMonth + 1);
            fetchAndRenderCalendar(activeSiteId, currentYear, currentMonth + 1);
        }

    };

    const attachCalendarLinkListeners = () => {
        const daysContainer = document.querySelector('.days');
        if (daysContainer) {
            daysContainer.removeEventListener('click', handleDayLinkClick);
            daysContainer.addEventListener('click', handleDayLinkClick);
        }
    };

    const handleDayLinkClick = (e) => {
        if (e.target.tagName === 'A') {
            e.preventDefault(); // Sayfa yönlendirmesini engelle (AJAX yerine yeni sekmede açmak için)

            // Mevcut raporu gösterme (sarı/beyaz günler)
            if (e.target.classList.contains('report-link')) {
                const reportId = e.target.getAttribute('data-id');

                // AJAX çağrısı yerine yeni sekmede açma
                const reportUrl = `${BASE_URL}report/file_form/${reportId}`;
                window.open(reportUrl, '_blank'); // Yeni sekmede aç

                // Aşağıdaki fetch bloğunu tamamen kaldırıyoruz
                /*
                fetch(`${BASE_URL}report/refresh_day/${reportId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('refresh_report').innerHTML = data.form_html;
                            if (typeof initFileUploader === 'function') {
                                initFileUploader();
                            }
                        } else {
                            console.error('Mevcut rapor yüklenemedi:', data.message || 'Bilinmeyen Hata');
                            alert('Rapor yüklenirken bir hata oluştu: ' + (data.message || 'Lütfen tekrar deneyin.'));
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
                */
            }
            // Yeni rapor ekleme sayfasına yönlendirme (kırmızı günler)
            else if (e.target.classList.contains('add-report-link')) {
                // Bu kısım zaten window.location.href kullanıyordu, o yüzden değişmeyecek
                const addUrl = e.target.getAttribute('data-add-url');
                if (addUrl) {
                    window.location.href = addUrl;
                } else {
                    console.error('Yeni rapor ekleme URL\'si bulunamadı.');
                }
            }
        }
    };
    // Takvim HTML'ini çeken ve JS değişkenlerini güncelleyen ana fonksiyon
    const fetchAndRenderCalendar = (siteId, year, month) => {
        // calendarContainer'ın tanımlı olduğundan emin ol
        if (!calendarContainer) {
            console.error("calendarContainer henüz tanımlı değil. Lütfen DOMContentLoaded içinde başlatıldığından emin olun.");
            return;
        }

        // Opsiyonel: Yükleniyor animasyonu göster
        // calendarContainer.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

        const targetUrl = `${BASE_URL}report/get_calendar_for_site/${siteId}?year=${year}&month=${month}`;

        fetch(targetUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.form_html) {
                    calendarContainer.innerHTML = data.form_html;
                    activeSiteId = data.site_id_for_js;
                    activeReportLinks = data.report_links_for_js;

                    currentYear = data.current_year;
                    currentMonth = data.current_month - 1;

                    renderCalendar();
                    attachMonthChangeListeners();
                    attachCalendarLinkListeners();

                    console.log("Takvim başarıyla yüklendi ve güncellendi.");
                } else {
                    alert('Takvim yüklenirken bir hata oluştu: ' + (data.message || 'Bilinmeyen Hata'));
                }
            })
            .catch(error => {
                console.error('AJAX hatası:', error);
                alert('Takvim yüklenirken bir sorun oluştu. Detaylar konsolda.');
            });
    };

    document.addEventListener('DOMContentLoaded', function() {
        const clickableRows = document.querySelectorAll('.clickable-site-row');
        // calendarContainer'ı DOM yüklendikten sonra burada başlatıyoruz
        calendarContainer = document.querySelector('.col-lg-4.col-md-12 .wrapper');

        if (!calendarContainer) {
            console.error("Takvim kapsayıcısı (.col-lg-4.col-md-12 .wrapper) bulunamadı. Lütfen HTML yapısını kontrol edin.");
            return; // Kapsayıcı yoksa daha fazla devam etme
        }


        if (clickableRows.length > 0) {
            clickableRows[0].click(); // İlk şantiyeyi otomatik yükle
        } else {
            renderCalendar(); // Hiç şantiye yoksa, sadece boş takvimi çiz
            attachMonthChangeListeners();
            attachCalendarLinkListeners();
        }

        clickableRows.forEach(row => {
            row.addEventListener('click', function() {
                const siteId = this.dataset.siteId;
                activeSiteId = siteId;

                console.log("Şantiye Tıklandı - fetchAndRenderCalendar'a gönderilen Yıl:", currentYear, "Ay:", currentMonth + 1);

                fetchAndRenderCalendar(siteId, currentYear, currentMonth + 1);
            });
        });
    });
</script>
