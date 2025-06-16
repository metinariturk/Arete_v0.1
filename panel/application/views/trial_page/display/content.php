<h3>Genel Toplam: <span id="genelToplam">0</span></h3>

<form id="hesapFormu">
    <div class="card row">
        <div class="col-12">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="hesapTablosu" style="width: 100%; table-layout: fixed;">
                        <thead>
                        <tr>
                            <th style="width: 5%">Mahal (S)</th>
                            <th style="width: 15%">Açıklama (N)</th>
                            <th style="width: 5%">Çarpan (M)</th>
                            <th style="width: 5%">Adet (Q)</th>
                            <th style="width: 5%">En (W)</th>
                            <th style="width: 5%">Boy (H)</th>
                            <th style="width: 5%">Uzunluk (L)</th>
                            <th style="width: 5%">Toplam (T)</th>
                            <th style="width: 5%">İşlem</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <button type="button" id="addRowBtn" class="btn btn-primary mt-3">Satır Ekle (+10)</button>
                    <button type="submit" id="saveDataBtn" class="btn btn-success mt-3 ml-2">Verileri Kaydet</button>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="boq_id" id="boqIdInput" value="660">
</form>

<script src="hesap_tablosu.js"></script>

<script>
    // Başlangıç verisi (API'den çekildiğinde kaldırılabilir veya API çağrısı ile doldurulur)
    const initialData = {
        "1": {"s": "TEMEL", "n": "GROBETON KALIBI", "q": "1", "w": "57.2", "h": "", "l": "0.1", "m": "", "t": "5.72"},
        "2": {
            "s": "TEMEL",
            "n": "KORUMA BETONU KALIBI",
            "q": "1",
            "w": "53.2",
            "h": "",
            "l": "0.5",
            "m": "1.5",
            "t": "26.60"
        },
        "19": {
            "s": "DÖŞEME",
            "n": "DÖŞEME BOŞLUĞU KENARI",
            "q": "2",
            "w": "1.3",
            "h": "",
            "l": "0.2",
            "m": "",
            "t": "0.52"
        }
    };

    // DOM Elementleri
    const hesapFormu = document.getElementById("hesapFormu"); // Yeni: Form elementi
    const hesapTablosuBody = document.querySelector("#hesapTablosu tbody");
    const genelToplamSpan = document.getElementById("genelToplam");
    const addRowButton = document.getElementById("addRowBtn");
    const saveDataButton = document.getElementById("saveDataBtn"); // Submit butonu

    let currentRowIndex = 0; // Satır indekslerini takip etmek için

    // Helper fonksiyon: Input değerini alıp sayıya çevirir, boşsa 1, sayı değilse 0 döndürür
    function getValue(inputElement) {
        const val = inputElement.value;
        if (val === "") {
            return 1; // Boşsa çarpımda etkisiz olması için 1 kabul et
        }
        const num = parseFloat(val);
        return isNaN(num) ? 0 : num; // Sayı değilse 0 döndür
    }

    // Yeni bir tablo satırı (<tr>) oluşturur ve event listener'ları ekler
    function createTableRow(data = {}) {
        const row = document.createElement("tr");

        // Her satırın benzersiz bir indeksi olacak
        const index = currentRowIndex++;

        row.innerHTML = `
        <td><input style="width: 100%" type="text" class="mahal" name="boq[${index}][s]" value="${data.s || ''}"></td>
        <td><input style="width: 100%" type="text" class="aciklama" name="boq[${index}][n]" value="${data.n || ''}"></td>
        <td><input style="width: 100%" type="number" class="multiple" name="boq[${index}][m]" value="${data.m || ''}"></td>
        <td><input style="width: 100%" type="number" class="adet" name="boq[${index}][q]" value="${data.q || ''}"></td>
        <td><input style="width: 100%" type="number" class="en" name="boq[${index}][w]" value="${data.w || ''}"></td>
        <td><input style="width: 100%" type="number" class="boy" name="boq[${index}][h]" value="${data.h || ''}"></td>
        <td><input style="width: 100%" type="number" class="uzunluk" name="boq[${index}][l]" value="${data.l || ''}"></td>
        <td><input style="width: 100%" type="text" class="toplam" name="boq[${index}][t]" value="${data.t || ''}" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm delete-row">Sil</button></td>
    `;

        // Her input alanına 'input' olay dinleyicisi ekle (değer değiştiğinde hesaplama için)
        Array.from(row.querySelectorAll('input')).forEach(input => {
            input.addEventListener('input', genelToplamiGuncelle);
        });

        // Sil butonuna 'click' olay dinleyicisi ekle
        row.querySelector('.delete-row').addEventListener('click', function () {
            row.remove(); // Satırı DOM'dan kaldır
            genelToplamiGuncelle(); // Genel toplamı yeniden hesapla
        });

        return row;
    }

    // Belirli bir satırdaki input değerlerini kullanarak satır toplamını hesaplar
    function hesaplaSatir(satir) {
        const multiple = getValue(satir.querySelector(".multiple"));
        const adet = getValue(satir.querySelector(".adet"));
        const en = getValue(satir.querySelector(".en"));
        const boy = getValue(satir.querySelector(".boy"));
        const uzunluk = getValue(satir.querySelector(".uzunluk"));

        // Tüm çarpanların çarpımı
        let carpimSonucu = multiple * adet * en * boy * uzunluk;

        // Eğer tüm çarpan inputları boşsa veya sayı değilse, toplamı boş bırak
        const originalInputs = [
            satir.querySelector(".multiple").value,
            satir.querySelector(".adet").value,
            satir.querySelector(".en").value,
            satir.querySelector(".boy").value,
            satir.querySelector(".uzunluk").value
        ];

        const allInputsEmpty = originalInputs.every(input => input === "" || isNaN(parseFloat(input)));

        if (allInputsEmpty) {
            satir.querySelector(".toplam").value = "";
            return 0;
        } else {
            satir.querySelector(".toplam").value = carpimSonucu.toFixed(2); // İki ondalık basamakla göster
            return carpimSonucu;
        }
    }

    // Tablodaki tüm satırların toplamını alarak genel toplamı günceller
    function genelToplamiGuncelle() {
        const satirlar = document.querySelectorAll("#hesapTablosu tbody tr");
        let genelToplam = 0;

        satirlar.forEach(satir => {
            genelToplam += hesaplaSatir(satir);
        });

        genelToplamSpan.textContent = genelToplam.toFixed(2); // Genel toplamı güncelle
    }

    // Veritabanından veriyi yükler ve başlangıçta boş satırları ekler
    function loadDataAndAddRows(data, initialEmptyRows = 10) {
        hesapTablosuBody.innerHTML = ''; // Mevcut tüm satırları temizle
        currentRowIndex = 0; // Indeksleri sıfırla

        // Gelen verileri tabloya ekle
        if (data && Object.keys(data).length > 0) {
            Object.values(data).forEach(item => {
                const row = createTableRow(item);
                hesapTablosuBody.appendChild(row);
            });
        }

        // Başlangıçta belirlenen sayıda boş satırı ekle
        for (let i = 0; i < initialEmptyRows; i++) {
            hesapTablosuBody.appendChild(createTableRow());
        }
        genelToplamiGuncelle(); // Tabloyu ilk kez yükledikten sonra genel toplamı güncelle
    }

    // Tabloya yeni satırlar ekler
    function addNewRows(count = 10) {
        for (let i = 0; i < count; i++) {
            hesapTablosuBody.appendChild(createTableRow());
        }
        genelToplamiGuncelle(); // Yeni eklenen satırlar sonrası genel toplamı güncelle
    }


    // Olay Dinleyicileri

    // "Satır Ekle" butonuna click olayı ekle
    addRowButton.addEventListener('click', () => addNewRows(10));

    // Form submit edildiğinde (Verileri Kaydet butonu tıklandığında)
    hesapFormu.addEventListener('submit', function (event) {
        event.preventDefault(); // Formun varsayılan gönderimini engelle

        // **ÖNEMLİ:** Bu değerleri kendi uygulamanızın bağlamından dinamik olarak almalısınız!

        const contractId = '58'; // Bu değeri dinamik olarak almalısınız
        const paymentId = '166'; // Bu değeri dinamik olarak almalısınız

        const boqId = document.getElementById('boqIdInput').value; // Hidden input'tan alıyoruz
        // Genel toplamı 'total_BOQ_ID' olarak FormData'ya ekleyeceğiz

        const boqTotal = genelToplamSpan.textContent; // Genel toplam
        // FormData objesi oluştur (doğrudan formu alabiliriz)
        const formData = new FormData(this); // 'this' burada hesapFormu'nu temsil eder

        // `total_boq_id`'yi manuel olarak ekle
        formData.append(`total_${boqId}`, boqTotal);

        // Boş satırları filtrelemek için, formdaki boq[] inputlarını kontrol edip
        // eğer bir satır tamamen boşsa FormData'dan çıkarmalıyız.
        // Ancak bu, `FormData` objesini karmaşık hale getirir.
        // En iyisi PHP tarafında boşları filtrelemeye devam etmek.
        // Veya: sadece dolu satırların name niteliklerini ayarlamak için createTableRow'u modifiye etmek.
        // Şimdilik PHP'nin filtrelemesine güvenelim.


        // Debug amaçlı: FormData içeriğini konsola yazdır
        console.log("Kaydedilecek Veri (FormData içeriği):", Object.fromEntries(formData.entries()));

        // **ÖNEMLİ:** CI3 Controller'ınızın doğru URL'sini buraya yazın.
        const saveUrl = "<?php echo base_url('Boq/save/') . $contractId . '/' . $paymentId; ?>";

        fetch(saveUrl, {
            method: 'POST',
            body: formData, // FormData'yı doğrudan body olarak gönderiyoruz
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Sunucu hatası');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Veri başarıyla gönderildi! CI3 Controller Cevabı:', data);
                alert('Veriler başarıyla gönderildi! Sunucu cevabını konsolda kontrol edin.');

                if (data.status === 'success' && data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else if (data.status === 'error') {
                    alert('Hata: ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Veri gönderilirken hata oluştu:', error);
                alert('Veri gönderilirken bir hata oluştu! Konsolu kontrol edin.');
            });
    });

    // Klavyede ok tuşları ile hücreler arasında gezinme ve içeriği seçme
    document.addEventListener('keydown', function (event) {
        const activeElement = document.activeElement;

        if (activeElement && activeElement.tagName === 'INPUT' && activeElement.closest('#hesapTablosu')) {
            const currentRow = activeElement.closest('tr');
            const allInputs = Array.from(document.querySelectorAll('#hesapTablosu input'));
            const currentIndex = allInputs.indexOf(activeElement);

            let nextInput = null;

            switch (event.key) {
                case 'ArrowRight':
                    if (currentIndex < allInputs.length - 1) {
                        nextInput = allInputs[currentIndex + 1];
                    }
                    break;
                case 'ArrowLeft':
                    if (currentIndex > 0) {
                        nextInput = allInputs[currentIndex - 1];
                    }
                    break;
                case 'ArrowDown':
                    const currentCellIndex = Array.from(activeElement.parentNode.parentNode.children).indexOf(activeElement.parentNode);
                    const nextRow = currentRow.nextElementSibling;
                    if (nextRow) {
                        const nextRowInputs = Array.from(nextRow.querySelectorAll('input'));
                        if (nextRowInputs[currentCellIndex]) {
                            nextInput = nextRowInputs[currentCellIndex];
                        } else if (nextRowInputs.length > 0) {
                            nextInput = nextRowInputs[0];
                        }
                    }
                    break;
                case 'ArrowUp':
                    const prevRow = currentRow.previousElementSibling;
                    if (prevRow) {
                        const currentCellIndex = Array.from(activeElement.parentNode.parentNode.children).indexOf(activeElement.parentNode);
                        const prevRowInputs = Array.from(prevRow.querySelectorAll('input'));
                        if (prevRowInputs[currentCellIndex]) {
                            nextInput = prevRowInputs[currentCellIndex];
                        } else if (prevRowInputs.length > 0) {
                            nextInput = prevRowInputs[0];
                        }
                    }
                    break;
                default:
                    return;
            }

            if (nextInput) {
                nextInput.focus();
                nextInput.select();
                event.preventDefault();
            }
        }
    });

    // Sayfa tamamen yüklendiğinde çalışacak kod
    document.addEventListener("DOMContentLoaded", () => {
        // Uygulama başladığında ilk verileri yükle ve boş satırları ekle
        // fetch('/api/getData').then(...).catch(...)
        loadDataAndAddRows(initialData, 10);
    });
</script>