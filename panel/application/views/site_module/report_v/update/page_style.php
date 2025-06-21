<style>
    .modern-save-btn {
        /* Temel Stil */
        background-color: #007bff; /* Mavi tonu */
        color: white;
        border: none;
        border-radius: 8px; /* Daha yumuşak köşeler */
        padding: 12px 28px; /* Daha geniş dolgu */
        font-size: 1.1rem; /* Daha belirgin metin */
        font-weight: 600; /* Kalınlık */
        cursor: pointer;
        transition: all 0.3s ease; /* Tüm geçişler için yumuşak animasyon */
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3); /* Hafif gölge */
        display: flex; /* İkon ve metni hizalamak için */
        align-items: center; /* Dikeyde ortala */
        justify-content: center; /* Yatayda ortala */
    }

    /* Hover Etkisi */
    .modern-save-btn:hover {
        background-color: #0056b3; /* Daha koyu mavi */
        box-shadow: 0 6px 15px rgba(0, 123, 255, 0.4); /* Gölgeyi büyüt */
        transform: translateY(-2px); /* Hafif yukarı kalkma */
    }

    /* Aktif (Tıklanmış) Durum */
    .modern-save-btn:active {
        background-color: #004085; /* Daha da koyu mavi */
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2); /* Gölgeyi küçült */
        transform: translateY(0); /* Normal konumuna dön */
    }

    /* Odaklanmış Durum (Klavye navigasyonu için) */
    .modern-save-btn:focus {
        outline: none; /* Varsayılan odak çerçevesini kaldır */
        box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.5); /* Bootstrap benzeri odak halkası */
    }

    /* İkon Stili */
    .modern-save-btn .fa {
        margin-right: 8px; /* İkon ile metin arasına boşluk */
        font-size: 1.2rem;
    }
</style>

<style>
    .info-link {
        color: inherit; /* Varsayılan link rengini engelle */
        text-decoration: none; /* Alt çizgiyi kaldır */
        display: block; /* Tam satırı tıklanabilir yap */
        padding: 5px 0; /* Tıklama alanını genişlet */
        transition: background-color 0.2s ease; /* Hover efekti için */
        border-radius: 4px; /* Hafif köşeler */
    }

    .info-link:hover {
        background-color: #f8f9fa; /* Hafif gri arka plan */
        color: inherit; /* Hover'da renk değişimi olmasın */
    }

    .info-link:hover strong {
        color: #007bff; /* Hover'da ana metnin rengini değiştir */
    }
</style>