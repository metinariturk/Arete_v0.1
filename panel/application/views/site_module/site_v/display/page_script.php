<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--// Modal içindeki Formu Gönderip Belirli bir Div'i refresh eden script başı -->
<script>
    // Formu ve modal'ı işleyen fonksiyon
    function submit_modal_form(formId, resultDivId, modalId) {
        const form = document.querySelector(`#${formId}`);
        const resultDiv = document.querySelector(`#${resultDivId}`);

        const formData = new FormData(form);  // Form verilerini toplar
        const actionUrl = form.getAttribute('data-form-url');  // data-form-url değerini alır

        // AJAX isteği
        fetch(actionUrl, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())  // Cevabı text olarak alır
            .then(data => {
                resultDiv.innerHTML = data;  // Sonuç div'ini yeniler
            })
            .catch(error => console.error('Hata:', error));

        // Modal'ı kapatır
        const modal = bootstrap.Modal.getInstance(document.querySelector(`#${modalId}`));
        modal.hide();
        document.getElementById(formId).reset();
    }
</script>
<!--// Modal içindeki Formu Gönderip Belirli bir Div'i refresh eden script  sonu-->

<!--// Stok Çıkışında ID yi modal'a gönderen sccript başı -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal açılmadan önce buton tıklama olayını dinle
        var exitModal = document.getElementById('ExitModal');
        exitModal.addEventListener('show.bs.modal', function (event) {
            // Tıklanan butonu al
            var button = event.relatedTarget;
            // Butondaki data-id değerini al
            var stockId = button.getAttribute('data-id');
            // Modal içindeki span veya input gibi elementlere bu değeri ata
            var stockIdDisplay = document.getElementById('stock-id-display');
            var stockIdInput = document.getElementById('stock_id');
            stockIdDisplay.textContent = stockId; // Span etiketine gösterim için
            stockIdInput.value = stockId;         // Input hidden alanına formda göndermek için
        });
    });
</script>
<!--// Stok Çıkışında ID yi modal'a gönderen sccript sonu -->

<!--Stok verisi sil başı-->
<script>
    function confirmDelete(stockId, deleteUrl) {
        // Kullanıcıdan onay al
        Swal.fire({
            title: 'Silme İşlemi',
            text: "Bu stok hareketini silmek istediğinize emin misiniz?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, sil',
            cancelButtonText: 'Hayır, iptal et'
        }).then((result) => {
            if (result.isConfirmed) {
                // Onay verildiğinde AJAX ile silme işlemi
                $.ajax({
                    url: deleteUrl, // Kontrolör URL'sini kullan
                    type: 'POST',
                    data: {
                        id: stockId // Silinecek stok ID'sini gönder
                    },
                    success: function (response) {
                        alert("başarılı silindi");
                        // tab_3_sitestock div'ini yenile
                        $('#tab_3_sitestock').html(response);
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Hata',
                            text: 'Silme işlemi sırasında bir hata oluştu.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }
</script>
<!--Stok verisi sil sonu-->

<script>
    function delete_stock_enter() {
        Swal.fire({
            icon: 'warning',
            title: 'Uyarı',
            text: 'Stok hareketi olan girişi silemezsiniz, önce stok hareketlerini dikkatli bir şekilde temizleyiniz.',
            confirmButtonText: 'Tamam'
        });
    }
</script>

<script>
    function empty_stock() {
        Swal.fire({
            icon: 'warning',
            title: 'Uyarı',
            text: 'Stokta ürün kalmadığı için bu işlemi yapamazsınız.',
            confirmButtonText: 'Tamam'
        });
    }
</script>

<script>
    $(document).ready(function () {
        $('#report_table').DataTable({
            "columnDefs": [
                { "type": "date", "targets": [1] } // Burada 1, "report_date" sütununun index numarasıdır
            ],
            "order": [[1, "desc"]], // İstenilen sıralama
            language: {
                "sEmptyTable":     "Hiç kayıt yok",
                "sInfo":           "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
                "sInfoEmpty":      "Kayıt yok",
                "sInfoFiltered":   "(_MAX_ kayıt içinden filtrelendi)",
                "sLengthMenu":     "Sayfa başına _MENU_ kayıt",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing":     "İşleniyor...",
                "sSearch":         "Ara:",
                "sZeroRecords":    "Eşleşen kayıt bulunamadı",
                "oPaginate": {
                    "sFirst":      "İlk",
                    "sLast":       "Son",
                    "sNext":       "Sonraki",
                    "sPrevious":   "Önceki"
                },
                "oAria": {
                    "sSortAscending":  ": artan sıralamak için aktif hale getir",
                    "sSortDescending": ": azalan sıralamak için aktif hale getir"
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#stock-table').DataTable({

            "responsive": true, // Mobil uyumluluk
            "lengthMenu": [10, 15, 20, 25], // Sayfa başına gösterilecek kayıt sayısı
            "language": {
                "search": "Ara:",
                "lengthMenu": "Göster _MENU_ kayıt",
                "info": "_TOTAL_ kayıt arasından _START_ - _END_ arası gösteriliyor",
                "paginate": {
                    "next": "Sonraki",
                    "previous": "Önceki"
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#expensesTable').DataTable({
            "responsive": true, // Mobil uyumluluk
            "lengthMenu": [10, 15, 20, 25], // Sayfa başına gösterilecek kayıt sayısı
            "language": {
                "search": "Ara:",
                "lengthMenu": "Göster _MENU_ kayıt",
                "info": "_TOTAL_ kayıt arasından _START_ - _END_ arası gösteriliyor",
                "paginate": {
                    "next": "Sonraki",
                    "previous": "Önceki"
                }
            }
        });
        });
        $('#advancesTable').DataTable({
            "responsive": true, // Mobil uyumluluk
            "lengthMenu": [10, 15, 20, 25], // Sayfa başına gösterilecek kayıt sayısı
            "language": {
                "search": "Ara:",
                "lengthMenu": "Göster _MENU_ kayıt",
                "info": "_TOTAL_ kayıt arasından _START_ - _END_ arası gösteriliyor",
                "paginate": {
                    "next": "Sonraki",
                    "previous": "Önceki"
                }
            }
        });
</script>



<div class="col-md-6">
    <?php
    $monthly_expenses = [];
    $i = 1; // Satır numarası için sayaç

    // Harcamaları aylara göre gruplama
    foreach ($all_expenses as $expense) {
        $month = date('Y-m', strtotime($expense->date)); // Yıl ve ay bilgisi
        $price = $expense->price; // Fiyatı float'a çevirme

        // Eğer ay dizide yoksa başlat
        if (!isset($monthly_expenses[$month])) {
            $monthly_expenses[$month] = 0;
        }

        // Ayın toplamını güncelle
        $monthly_expenses[$month] += $price;
    }

    $chart_expense = json_encode($monthly_expenses);


    ?>

    <script>
        // PHP'den alınan harcama verisini JavaScript'te kullanmak için
        var monthlyExpenses = <?php echo $chart_expense; ?>;

        // Grafik verilerini hazırlama
        var labels = Object.keys(monthlyExpenses); // Aylar
        var data = Object.values(monthlyExpenses); // Toplam harcamalar

        // Her çubuk için farklı renkler tanımlama
        var colors = [
            'rgba(75, 192, 192, 0.2)', // Ocak
            'rgba(255, 99, 132, 0.2)', // Şubat
            'rgba(255, 206, 86, 0.2)', // Mart
            'rgba(75, 192, 192, 0.2)', // Nisan
            'rgba(54, 162, 235, 0.2)', // Mayıs
            'rgba(153, 102, 255, 0.2)', // Haziran
            'rgba(255, 159, 64, 0.2)', // Temmuz
            'rgba(255, 99, 132, 0.2)', // Ağustos
            'rgba(75, 192, 192, 0.2)', // Eylül
            'rgba(255, 206, 86, 0.2)', // Ekim
            'rgba(54, 162, 235, 0.2)', // Kasım
            'rgba(153, 102, 255, 0.2)'  // Aralık
        ];

        // Grafik oluşturma
        var ctx = document.getElementById('expenseChart').getContext('2d');
        var expenseChart = new Chart(ctx, {
            type: 'bar', // Çubuk grafik
            data: {
                labels: labels,
                datasets: [{
                    label: 'Aylık Harcama (TL)',
                    data: data,
                    backgroundColor: colors.slice(0, data.length), // Her çubuğa farklı renk
                    borderColor: colors.slice(0, data.length).map(color => color.replace('0.2', '1')), // Kenar rengi
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
