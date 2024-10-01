<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--// Modal içindeki Formu Gönderip Belirli bir Div'i refresh eden script başı -->

<script>
    function submit_modal_form(formId, modalId, DivId, DataTable = null) {
        var form = $('#' + formId);
        var url = form.data('form-url');

        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            dataType: 'html', // Sunucudan HTML dönecek
            success: function (response) {
                $('#' + DivId).html(response); // Gelen yanıtı Div'e ekle
                form[0].reset(); // Formu temizle

                // HTML yanıtı içerisindeki form_error'u kontrol et
                var formError = $('#form-error').val();

                if (formError == "1") {
                    $('#' + modalId).modal('show'); // Hata durumunda modalı tekrar aç
                } else {
                    $('#' + modalId).modal('hide'); // Başarılıysa modalı kapat
                    $('.modal-backdrop').remove();

                    // Eğer DataTable parametresi verilmişse
                    if (DataTable) {
                        // Eğer mevcut DataTable varsa, onu yok et
                        if ($.fn.DataTable.isDataTable(DataTable)) {
                            $(DataTable).DataTable().destroy();
                        }

                        if (!$.fn.DataTable.isDataTable('#'+DataTable)) {
                            $('#'+DataTable).DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                // Diğer DataTable ayarları
                            });
                        }
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Form gönderiminde hata oluştu: ', error);
                alert('Form gönderiminde bir hata oluştu. Lütfen tekrar deneyin.');
            }
        });
    }
</script>


<!--// Modal içindeki Formu Gönderip Belirli bir Div'i refresh eden script  sonu-->

<!--// Stok Çıkışında ID yi modal'a gönderen sccript başı -->

<script>
    function open_exit_stock_form(stockId, modalId) {
        // Input değerini ayarla
        $('#' + modalId).find('#stock_id').val(stockId);

        // Modal'ı aç
        $('#' + modalId).modal('show');

    }
</script>

<!--// Stok Çıkışında ID yi modal'a gönderen sccript sonu -->

<!--Stok verisi sil başı-->
<script>
    function confirmDelete(stockId, deleteUrl, refreshDiv) {
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
                        $(refreshDiv).html(response);
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
