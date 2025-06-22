<style>
    header #calendarSiteName {
        font-size: 1.6rem; /* Daha büyük */
        font-weight: 700;  /* Kalın */
        color: #333; /* Veya temanıza uygun bir renk */
        margin-bottom: 10px; /* Ay bilgisiyle arasına boşluk */
        text-align: center; /* Ortalamak için */
    }

    /* all.php'deki table-responsive div'ine veya genel olarak table'a taşınabilir */
    .clickable-site-row {
        cursor: pointer; /* Tıklanabilir olduğunu belirtmek için imleç */
        position: relative; /* "Seç" işareti için konum referansı */
    }

    /* Hover efektinde "Seç" işareti */
    .clickable-site-row::after {
        content: "Seç"; /* Görüntülenecek metin */
        position: absolute;
        right: 15px; /* Sağdan boşluk */
        top: 50%;
        transform: translateY(-50%); /* Dikeyde ortala */
        background-color: #28a745; /* Yeşil arka plan */
        color: white; /* Beyaz yazı */
        padding: 3px 8px; /* İç boşluk */
        border-radius: 4px; /* Hafif yuvarlak köşeler */
        font-size: 0.85em;
        opacity: 0; /* Başlangıçta gizli */
        transition: opacity 0.2s ease-in-out; /* Yumuşak geçiş */
        pointer-events: none; /* İşaretin tıklanmayı engellememesi için */
    }

    .clickable-site-row:hover::after {
        opacity: 1; /* Hover'da görünür yap */
    }

    /* Hover efektinde arka plan rengi */
    .clickable-site-row:hover {
        background-color: #f0f0f0; /* Hafif gri arka plan */
    }

    header {
        display: flex;
        flex-direction: column; /* Öğeleri dikey olarak alt alta sırala */
        align-items: center; /* Öğeleri yatayda (ortada) hizala */
        padding: 10px 0; /* Üstten ve alttan biraz boşluk ekle */
    }

    header .current-date {
        font-size: 1.45rem;
        font-weight: 500;
        margin-bottom: 5px; /* Ay adı ile oklar arasına biraz boşluk */
        text-align: center; /* Sadece metnin kendisini ortalamak için */
    }

    header .icons {
        display: flex; /* Ok ikonlarını kendi içlerinde yan yana dizer */
        align-items: center; /* Dikeyde ortalar */
        justify-content: center; /* Yatayda ortalar */
        margin-top: 5px; /* Başlıkla oklar arasına biraz boşluk */
        /* Diğer pozisyonlama özelliklerine gerek kalmaz */
    }

    header .icons span {
        height: 38px;
        width: 38px;
        margin: 0 5px; /* Oklar arasına ve kenarlara boşluk verin, 1px çok azdı */
        cursor: pointer;
        color: #878787;
        text-align: center;
        line-height: 38px;
        font-size: 1.9rem;
        user-select: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icons span:last-child {
        margin-right: 0; /* Kaldırıldı veya 0 yapıldı */
    }

    header .icons span:hover {
        background: #f2f2f2;
    }

    header .current-date {
        font-size: 1.45rem;
        font-weight: 500;
    }

    .calendar {
        padding: 20px;
    }

    .calendar ul {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        text-align: center;
    }

    .calendar .days {
        margin-bottom: 20px;
    }

    .calendar li {
        /* Tüm gün li'leri için temel stiller */
        color: #333; /* Varsayılan yazı rengi */
        width: calc(100% / 7); /* Bir satırda 7 gün */
        font-size: 1.07rem;
        z-index: 1;
        cursor: pointer;
        position: relative; /* ::before için referans */
        margin-top: 30px; /* Günler arası dikey boşluk */
        /* Li'nin kendisi için yuvarlaklığı ve ortalamayı kaldırıyoruz, A etiketine devrediyoruz */
        /* li yerine ::before ve a etiketine odaklanacağız */
        display: flex; /* İçindeki a etiketini veya sayıyı merkezlemek için */
        align-items: center; /* Dikey merkezleme */
        justify-content: center; /* Yatay merkezleme */
        height: 40px; /* ::before ile aynı boyutta olsun ki click alanı tam olsun */
    }

    /* Haftanın günleri başlıkları */
    .calendar .weeks li {
        font-weight: 500;
        cursor: default;
        height: auto; /* Haftanın günlerinin yüksekliğini kısıtlamayalım */
    }

    /* Gün içindeki <a> etiketi için stil */
    /* KRİTİK: Bu, gün numarasının/linkinin yuvarlak alanı tam olarak kaplamasını sağlar */
    .days li a {
        display: flex; /* İçindeki sayıyı merkezlemek için */
        align-items: center;
        justify-content: center;
        height: 100%; /* li'nin yüksekliğini kapla (40px) */
        width: 100%; /* li'nin genişliğini kapla (calc(100%/7) * parent'ın genişliği) */
        max-width: 40px; /* Sadece 40px ile sınırlayalım */
        max-height: 40px; /* Sadece 40px ile sınırlayalım */
        border-radius: 50%; /* Linkin de yuvarlak olmasını sağlar */
        text-decoration: none; /* Alt çizgiyi kaldır */
        color: inherit; /* Yazı rengini li'den miras al */
        background-color: transparent !important; /* A etiketinin kendi arka plan rengi olmasın, li::before kullanalım */
    }


    /* ::before pseudo-elementleri - TÜM arka plan renkleri ve yuvarlaklar buradan yönetilir */
    .days li::before {
        position: absolute;
        content: "";
        left: 50%;
        top: 50%;
        height: 40px; /* Yuvarlağın boyutu */
        width: 40px; /* Yuvarlağın boyutu */
        z-index: -1; /* İçerikteki metnin arkasında kalır */
        border-radius: 50%;
        transform: translate(-50%, -50%); /* Tam merkezleme */
        background-color: transparent; /* Varsayılan olarak şeffaf */
    }

    /* Bugünün (active) stili */
    .days li.active {
        color: white !important; /* Yazı rengi beyaz */
        font-weight: 600;
    }

    .days li.active::before {
        background: #2980b9; /* Mavi arka plan */
    }

    /* Hover efekti (aktif olmayan ve pasif olmayan günler için) */
    .days li:not(.active):not(.inactive):hover::before {
        background: #f2f2f2; /* Hafif gri hover rengi */
    }

    /* Pasif (inactive) günler */
    .days li.inactive {
        color: #ccc; /* Gri yazı */
        cursor: default;
    }

    .days li.inactive::before {
        background-color: transparent; /* Pasif günlerin arka planı olmasın */
    }

    .days li.inactive a {
        color: inherit; /* Pasif gün linklerinin rengi de gri olsun */
        cursor: default;
    }


    /* Raporlu günler (report-day) */
    .days li.report-day {
        color: #fff; /* Yazı rengi beyaz olsun */
        font-weight: bold;
    }

    .days li.report-day::before {
        background: #27ae60; /* Yeşil arka plan */
    }

    /* Raporsuz günler (no-report-day) - Kırmızı boyalı */
    .days li.no-report-day {
        color: white; /* Yazı rengi beyaz olsun */
        font-weight: bold;
    }

    .days li.no-report-day::before {
        background: #e74c3c; /* Kırmızı arka plan */
    }
</style>
