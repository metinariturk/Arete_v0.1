<script>
    document.addEventListener("DOMContentLoaded", function () {
        var calendarEl = document.getElementById("calendar");

        var eventsArray = <?php echo json_encode($items); ?>; // PHP dizisini JavaScript dizisine dönüştür


        var calendar = new FullCalendar.Calendar(calendarEl, {
            // ... diğer ayarlar ...

            // Türkçe dil ayarları
            locale: "tr", // Türkçe dilini kullan

            // Türkçe ay isimleri
            monthNames: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
            monthNamesShort: ["Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara"],

            // Türkçe gün isimleri
            dayNames: ["Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"],
            dayNamesShort: ["Paz", "Pts", "Sal", "Çar", "Per", "Cum", "Cts"],
            dayNamesShortest: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],

            // Türkçe düğme metinleri
            buttonText: {
                today: "Bugün",
                month: "Ay",
                week: "Hafta",
                day: "Gün",
                list: "Liste",
            },

            firstDay: 1,

            events: eventsArray.flatMap(function (item) {
                var iconClass = '';

                if (item.event === 'Açık') {
                    iconClass = 'fas fa-sun fa-4x'; // Açık için güneş ikonu
                } else if (item.event === 'Bulutlu') {
                    iconClass = 'fas fa-cloud fa-2x'; // Bulutlu için bulut ikonu
                } else if (item.event === 'Sisli') {
                    iconClass = 'fas fa-smog fa-2x'; // Sisli için sis ikonu
                } else if (item.event === 'Yağmurlu') {
                    iconClass = 'fas fa-cloud-showers-heavy fa-2x'; // Yağmurlu için ağır yağmur ikonu
                } else if (item.event === 'Rüzgarlı') {
                    iconClass = 'fas fa-wind fa-2x'; // Rüzgarlı için rüzgar ikonu
                } else if (item.event === 'Kar Yağışlı') {
                    iconClass = 'fas fa-snowflake fa-2x'; // Kar yağışlı için kar tanesi ikonu
                } else if (item.event === 'Şiddetli Yağmur') {
                    iconClass = 'fas fa-cloud-showers-heavy fa-2x'; // Şiddetli yağmur için ağır yağmur ikonu
                } else if (item.event === 'Şiddetli Rüzgar') {
                    iconClass = 'fas fa-wind fa-2x'; // Şiddetli rüzgar için rüzgar ikonu
                } else if (item.event === 'Şiddetli Kar') {
                    iconClass = 'fas fa-snowflake fa-2x'; // Şiddetli kar yağışlı için kar tanesi ikonu
                }

                return [
                    {
                        title: '<i class="fas fa-arrow-up"></i> En Yüksek : ' + item.max + ' C°',
                        start: item.date,
                        // İlgili diğer özellikleri ekleyebilirsiniz
                    },
                    {
                        title: '<i class="fas fa-arrow-down"></i> En Düşük : ' + item.min + ' C°',
                        start: item.date,
                        // İlgili diğer özellikleri ekleyebilirsiniz
                    },
                    {
                        title: 'Olay : ' + item.event + '<br><i class="' + iconClass + '"></i>',
                        start: item.date,
                        // İlgili diğer özellikleri ekleyebilirsiniz
                    }
                ];
            }),
            eventContent: function (arg) {
                return {
                    html: '<div style="color: #0b0b0b" class="text-center">' + arg.event.title + '</div>',
                };
            },


            // ... diğer ayarlar ...
        });

        calendar.render();
    });
</script>