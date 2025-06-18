const daysTag = document.querySelector(".days"),
    currentDate = document.querySelector(".current-date"),
    prevNextIcon = document.querySelectorAll(".icons span");

// getting new date, current year and month
let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

// storing full name of all months in array
const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz",
    "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];

const weekDays = ["Paz", "Pzt", "Sal", "Çar", "Per", "Cum", "Cmt"];


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

    let liTag = "";

    // Önceki ayın son günlerini pasif ekle
    for (let i = firstDayofMonth; i > 0; i--) {
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }

    // Bugünün tarihi (Date objesi)
    const today = new Date();

    // Mevcut ayın günleri
    for (let i = 1; i <= lastDateofMonth; i++) {
        // Günün string hali: YYYY-MM-DD
        const dayStr = `${currYear}-${String(currMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

        // Bugün mü kontrolü
        const isToday = i === today.getDate() && currMonth === today.getMonth() && currYear === today.getFullYear();

        // Rapor var mı kontrolü (reportLinks global değişkeni)
        const reportId = reportLinks[dayStr]; // ID ya da undefined

        // CSS sınıfını belirle
        const dayClass = isToday ? 'active' : reportId ? 'report-day' : 'no-report-day';

        // Eğer raporluysa link olarak göster, değilse sadece sayı
        const dayLink = reportId
            ? `<a href="#" class="report-link" data-id="${reportId}" data-date="${dayStr}">${i}</a>`
            : i;

        liTag += `<li class="${dayClass}">${dayLink}</li>`;
    }

    // Sonraki ayın ilk günlerini pasif ekle
    for (let i = lastDayofMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
    }

    // Başlık: ay ve yıl
    currentDate.innerText = `${months[currMonth]} ${currYear}`;

    // Takvim günlerini DOM'a yaz
    daysTag.innerHTML = liTag;
}
renderCalendar();

prevNextIcon.forEach(icon => {
    icon.addEventListener("click", () => {
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if(currMonth < 0 || currMonth > 11) {
            date = new Date(currYear, currMonth, 1);
            currYear = date.getFullYear();
            currMonth = date.getMonth();
        } else {
            // Burada date'yi güncelleme, çünkü zaten currMonth ve currYear güncellendi
            // Böylece date eski ay/yıla göre kalır
            date = new Date(currYear, currMonth, 1);
        }

        renderCalendar();
    });
});