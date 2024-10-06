<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--// Modal içindeki Formu Gönderip Belirli bir Div'i refresh eden script başı -->

<script>
    function submit_modal_form(formId, modalId, DivId, DataTable = null) {
        var form = $('#' + formId)[0];  // Form referansını alıyoruz (DOM element olarak)
        var url = $(form).data('form-url');
        var formData = new FormData(form);  // FormData ile form verilerini ve dosyaları alıyoruz

        $('#ExitModal').on('shown.bs.modal', function () {
            $('#' + modalId).datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                language: 'tr'
            });
        });

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,  // FormData kullanıyoruz
            contentType: false,  // Dosya yükleme için `false` olmalı
            processData: false,  // Form verilerini manuel olarak işliyoruz
            dataType: 'html',
            success: function (response) {
                $('#' + DivId).html(response); // Gelen yanıtı Div'e ekle
                form.reset(); // Formu temizle

                // HTML yanıtı içerisindeki form_error'u kontrol et
                var formError = $('#form-error').val();

                if (formError == "1") {
                    $('#' + modalId).modal('show'); // Hata durumunda modalı tekrar aç
                } else {
                    $('#' + modalId).modal('hide'); // Başarılıysa modalı kapat
                    $('.modal-backdrop').remove(); // Modal arka planını kaldır
                    $('body').removeClass('modal-open'); // Body'den modal sınıfını kaldır
                    $('body').css('overflow', 'auto'); // Overflow'u sıfırla
                    $('body').css('padding-right', ''); // Padding-right'ı sıfırla

                    // Eğer DataTable parametresi verilmişse
                    if (DataTable) {
                        // Eğer mevcut DataTable varsa, onu yok et
                        if ($.fn.DataTable.isDataTable(DataTable)) {
                            $(DataTable).DataTable().destroy();
                        }

                        // DataTable yoksa, yeni bir DataTable başlat
                        if (!$.fn.DataTable.isDataTable('#' + DataTable)) {
                            $('#' + DataTable).DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                // Diğer DataTable ayarları
                            });
                        }
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Form gönderiminde hata oluştu: ', error);
                console.error('Hata Detayı: ', xhr.responseText); // Sunucudan dönen hata mesajı
                alert('Form gönderiminde bir hata oluştu. Lütfen tekrar deneyin.');
            }
        });
    }

</script>

<script>
    function delete_file(element) {
        // Data-URL'den silme URL'sini al
        var url = element.getAttribute("data-url");

        // AJAX isteği yapıyoruz
        fetch(url, {
            method: 'POST',
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Başarıyla silindiğinde yeni bir input alanı ekle
                    var fileUploadContainer = document.getElementById("file-upload-container");
                    fileUploadContainer.innerHTML = ''; // Mevcut içeriği temizle

                    // Yeni bir dosya yükleme alanı oluştur
                    var label = document.createElement("label");
                    label.className = "col-form-label";
                    label.innerHTML = "Dosya Yükle:";

                    var input = document.createElement("input");
                    input.className = "form-control";
                    input.name = "file";
                    input.id = "file-input";
                    input.type = "file";

                    // Yeni alanları ekleyin
                    fileUploadContainer.appendChild(label);
                    fileUploadContainer.appendChild(input);
                } else {
                    alert(data.message); // Hata mesajını göster
                }
            })
            .catch(error => {
                console.error('Hata:', error);
                alert('Bir hata oluştu!');
            });
    }
</script>

<script>
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('body').css('padding-right', '');
        $('body').css('overflow', 'auto');
    });
</script>
<!--// Modal içindeki Formu Gönderip Belirli bir Div'i refresh eden script  sonu-->

<script>
    function edit_modal_form(FormURL, ModalForm, ModalId) {
        // AJAX ile modal içeriğini yenile
        $.ajax({
            url: FormURL,
            type: 'GET',
            success: function(response) {
                // Modalın içeriğini güncelle
                $('#'+ModalForm).html(response); // Gelen yanıtı modal içeriğine ekle

                // Modalı aç
                $('#'+ModalId).modal('show');

                // Modal padding ve overflow ayarlarını sıfırla (gerekirse)
                $('body').css('padding-right', '');
                $('body').css('overflow', '');
            },
            error: function() {
                alert('Modal içeriği yüklenirken bir hata oluştu.');
            }
        });
    }
</script>


<!--Stok verisi sil başı-->
<script>
    function confirmDelete(deleteUrl, refreshDiv,DataTable = null) {
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

                    success: function (response) {
                        $(refreshDiv).html(response);

                        if ($.fn.DataTable.isDataTable(DataTable)) {
                            $(DataTable).DataTable().destroy();
                        }

                        // DataTable yoksa, yeni bir DataTable başlat
                        if (!$.fn.DataTable.isDataTable('#'+DataTable)) {
                            $('#'+DataTable).DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                // Diğer DataTable ayarları
                            });
                        }

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
        $('#depositsTable').DataTable({
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


