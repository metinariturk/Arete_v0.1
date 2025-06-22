<script>

    $(document).ready(function() {
        const BASE_URL = "<?php echo base_url(); ?>";
        const SITE_ID = "<?php echo $site->id; ?>";
        const reportLinks = <?php
            $links = [];
            foreach ($reports as $r) {
                $date = date('Y-m-d', strtotime($r->report_date));
                $links[$date] = $r->id;
            }
            echo json_encode($links);
            ?>;

        const daysTag = document.querySelector(".days"),
            currentDateElement = document.querySelector(".current-date"),
            prevNextIcon = document.querySelectorAll(".icons span");

        let date = new Date(),
            currYear = date.getFullYear(),
            currMonth = date.getMonth();

        const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz",
            "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];

        const renderCalendar = () => {
            let firstDayofMonth = new Date(currYear, currMonth, 1).getDay();
            firstDayofMonth = (firstDayofMonth + 6) % 7;

            let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate();
            let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay();
            lastDayofMonth = (lastDayofMonth + 6) % 7;

            let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();

            let liTag = "";

            for (let i = firstDayofMonth; i > 0; i--) {
                liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            for (let i = 1; i <= lastDateofMonth; i++) {
                const dayStr = `${currYear}-${String(currMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                const currentDayDate = new Date(currYear, currMonth, i);
                currentDayDate.setHours(0, 0, 0, 0);

                const isToday = currentDayDate.getTime() === today.getTime();
                const isFutureDay = currentDayDate.getTime() > today.getTime();

                const reportId = reportLinks[dayStr];

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
                    dayContent = `<a href="#" class="add-report-link" data-add-url="${BASE_URL}report/new_form/${SITE_ID}/${dayStr}">${i}</a>`;
                }

                liTag += `<li class="${dayClassList.join(' ')}">${dayContent}</li>`;
            }

            for (let i = lastDayofMonth; i < 6; i++) {
                liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
            }

            currentDateElement.innerText = `${months[currMonth]} ${currYear}`;
            daysTag.innerHTML = liTag;
        };
        renderCalendar();

        prevNextIcon.forEach(icon => {
            icon.addEventListener("click", () => {
                currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

                if (currMonth < 0 || currMonth > 11) {
                    date = new Date(currYear, currMonth, 1);
                    currYear = date.getFullYear();
                    currMonth = date.getMonth();
                } else {
                    date = new Date(currYear, currMonth, 1);
                }
                renderCalendar();
            });
        });

        document.querySelector('.days').addEventListener('click', e => {
            if (e.target.tagName === 'A') {
                if (e.target.classList.contains('report-link')) {
                    e.preventDefault();

                    const reportId = e.target.getAttribute('data-id');

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
                else if (e.target.classList.contains('add-report-link')) {
                    e.preventDefault();

                    const addUrl = e.target.getAttribute('data-add-url');
                    if (addUrl) {
                        window.location.href = addUrl;
                    } else {
                        console.error('Yeni rapor ekleme URL\'si bulunamadı.');
                    }
                }
            }
        });

        initFileUploader();
    });
</script>