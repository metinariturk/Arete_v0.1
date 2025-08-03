<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--// Modal içindeki Formu Gönderip Belirli bir Div'i refresh eden script başı -->
<script>
    function initializeFlatpickr() {
        flatpickr(".flatpickr", {
            dateFormat: "d-m-Y",
            locale: "tr",
            allowInput: true,
            disableMobile: true
        });
    }
</script>
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

                    initializeFlatpickr();

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
            error: function (xhr, status, error) {
                console.error('Form gönderiminde hata oluştu: ', error);
                console.error('Hata Detayı: ', xhr.responseText); // Sunucudan dönen hata mesajı
                alert('Form gönderiminde bir hata oluştu veya yetkiniz yok. Lütfen tekrar deneyin.');
            }
        });
    }

</script>

<script>
    function delete_this_item(element) {
        // URL'yi al
        var url = element.getAttribute('data');

        // Tıklanan öğenin üstündeki div'in ID'sini al
        var divID = element.closest('.col-12').id; // Burada div'in ID'sini alıyoruz

        // Onay penceresi
        if (confirm('Bu dosyayı silmek istediğinize emin misiniz?')) {
            // AJAX isteği gönder
            fetch(url, {
                method: 'GET'
            })
                .then(response => response.text())
                .then(data => {
                    // Silme işlemi başarılıysa
                    if (data.includes("Dosya başarıyla silindi.")) {
                        // Belirtilen div'i DOM'dan kaldır
                        var divToRemove = document.getElementById(divID);
                        if (divToRemove) {
                            divToRemove.remove();
                        }
                        alert(data); // Başarı mesajını göster
                    } else {
                        alert(data); // Hata mesajını göster
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                });
        }
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
            success: function (response) {
                // Modalın içeriğini güncelle
                $('#' + ModalForm).html(response); // Gelen yanıtı modal içeriğine ekle

                // Modalı aç
                $('#' + ModalId).modal('show');

                // Modal padding ve overflow ayarlarını sıfırla (gerekirse)
                $('body').css('padding-right', '');
                $('body').css('overflow', '');

                initializeFlatpickr();
            },
            error: function () {
                alert('Modal içeriği yüklenirken bir hata oluştu.');
            }
        });
    }
</script>


<!--Stok verisi sil başı-->
<script>
    function confirmDelete(deleteUrl, refreshDiv, DataTable = null) {
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
                        if (!$.fn.DataTable.isDataTable('#' + DataTable)) {
                            $('#' + DataTable).DataTable({
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
                {"type": "date", "targets": [1]} // Burada 1, "report_date" sütununun index numarasıdır
            ],
            "order": [[1, "desc"]], // İstenilen sıralama
            language: {
                "sEmptyTable": "Hiç kayıt yok",
                "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
                "sInfoEmpty": "Kayıt yok",
                "sInfoFiltered": "(_MAX_ kayıt içinden filtrelendi)",
                "sLengthMenu": "Sayfa başına _MENU_ kayıt",
                "sLoadingRecords": "Yükleniyor...",
                "sProcessing": "İşleniyor...",
                "sSearch": "Ara:",
                "sZeroRecords": "Eşleşen kayıt bulunamadı",
                "oPaginate": {
                    "sFirst": "İlk",
                    "sLast": "Son",
                    "sNext": "Sonraki",
                    "sPrevious": "Önceki"
                },
                "oAria": {
                    "sSortAscending": ": artan sıralamak için aktif hale getir",
                    "sSortDescending": ": azalan sıralamak için aktif hale getir"
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#stock-table').DataTable({
            "columnDefs": [
                {"width": "5%", "targets": 0}, // İşlem sütunu
                {"width": "25%", "targets": 1}, // Stok Adı sütunu
                {"width": "15%", "targets": 2}, // Birim sütunu
                {"width": "7%", "targets": 3}, // Miktarı sütunu
                {"width": "7%", "targets": 4}, // Kalan sütunu
                {"width": "10%", "targets": 5}, // Tarihi sütunu
                {"width": "30%", "targets": 6}, // Açıklama sütunu
                {"width": "5%", "targets": 7}   // Sil sütunu
            ],
            "autoWidth": false, // Otomatik genişliği kapat
            ordering: false,
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
    $(document).ready(function () {
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
    $('#personelTable').DataTable({
        "responsive": true, // Mobil uyumluluk
        "lengthMenu": [10, 15, 20, 25], // Sayfa başına gösterilecek kayıt sayısı
        ordering: false,
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
    function change_list(div_id, url, DataTable) {
        // İlk olarak AJAX çağrısı başlatıyoruz
        $.ajax({
            url: url, // PHP'den gelen URL
            type: 'GET', // Yöntem
            success: function (response) {
                // AJAX başarılı olursa div'in içeriğini güncelle
                $("#" + div_id).html(response);
                // Eğer DataTable varsa önce destroy edelim
                if ($.fn.DataTable.isDataTable("#personelTable")) {
                    $("#" + DataTable).DataTable().destroy();
                }

                // DataTable'ı tekrar başlat
                $("#" + DataTable).DataTable({
                    // DataTable ayarlarınızı buraya ekleyebilirsiniz
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true
                });
            },
            error: function () {
                // Hata durumu
                alert("Veri alınırken bir hata oluştu!");
            }
        });
    }
</script>

<script>

    $(document).ready(function () {
        // FileUploader plugin initialization
        $('input[name="files"]').fileuploader({
            limit: 3, // Tek dosya sınırı
            onSelect: function (item) {
                // Upload butonunu ekliyoruz
                if (!item.html.find('.fileuploader-action-start').length)
                    item.html.find('.fileuploader-action-remove').before('<button type="button" class="fileuploader-action fileuploader-action-start" title="Upload"><i class="fileuploader-icon-upload"></i></button>');
            },
            upload: {
                url: 'php/ajax_upload_file.php', // Yükleme yapılacak PHP dosyası
                type: 'POST',
                enctype: 'multipart/form-data',
                start: false,
                synchron: true,
                beforeSend: function (item) {
                    // Custom dosya adı kontrolü
                    var input = $('#custom_file_name');
                    if (input.length) {
                        item.upload.data.custom_name = input.val(); // Custom adı POST verisine ekle
                    }
                    input.val(""); // Ad alanını sıfırla
                },
                onSuccess: function (result, item) {
                    // Yükleme başarılı olursa dosya adını güncelle
                    var data = result;
                    if (data.isSuccess && data.files[0]) {
                        item.name = data.files[0].name;
                        item.html.find('.column-title div').animate({opacity: 0}, 400);
                    }
                    // Başarı simgesi ve progress bar güncellenmesi
                    item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');
                    setTimeout(function () {
                        item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({opacity: 1}, 400);
                        $('#progress-bar').fadeOut(400);
                    }, 400);
                },
                onError: function (item) {
                    $('#file-progress-bar').hide(); // Hata durumunda progress bar gizlenir
                    alert('Dosya yükleme sırasında hata oluştu.');
                },
                onProgress: function (data, item) {
                    // Progress bar güncelleme
                    $('#file-progress-bar').show();
                    $('#progress-bar').val(data.percentage);
                    $('#progress-percentage').text(data.percentage + '%');
                }
            }
        });
    });

</script>


<script>
    let isTextEnlarged = false; // Toggle durumu için kontrol değişkeni

    function openPersonModal(iban, bank, name, position, social, date, editUrl) {
        const modalBody = document.getElementById('personModalBody');
        modalBody.innerHTML = `
        <p style="font-size: 1em"><strong>İsim:</strong> ${name}
            <button onclick="copyToClipboard('${name}')" style="border:none; background:none; cursor:pointer;">
                📋
            </button>
        </p>
        <p><strong>TC Kimlik No:</strong> ${social}</p>
        <p style="font-size: 1em" id="ibanText" onclick="toggleTextSize()" ><strong>IBAN:</strong> <span> ${iban}</span>
            <button onclick="copyToClipboard('${iban}')" style="border:none; background:none; cursor:pointer;">
                📋
            </button>
        </p>
        <p><strong>Bank:</strong> ${bank}</p>
        <p><strong>Görev:</strong> ${position}</p>
        <p><strong>Giriş/Çıkış Tarihi:</strong> ${date}</p>
       <p class="d-sm-none">
            <a data-bs-toggle="modal" class="text-primary"
               onclick="edit_modal_form('${editUrl}', 'edit_personel_modal', 'EditPersonelModal')">
               <i class="fa fa-edit fa-lg"></i> Düzenle
            </a>
        </p>
    `;

        var myModal = new bootstrap.Modal(document.getElementById('personModal'));
        myModal.show();
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert(text + ' başarıyla kopyalandı!');
        }).catch(err => {
            alert('Kopyalama işlemi başarısız oldu');
        });
    }

    function toggleTextSize() {
        const ibanText = document.getElementById('ibanText');
        if (isTextEnlarged) {
            ibanText.style.fontSize = '1em'; // Normal boyuta geri döndür
            ibanText.style.cursor = 'zoom-in'; // Küçültürken imleci zoom-in yap
        } else {
            ibanText.style.fontSize = '2em'; // Büyük boyuta ayarla
            ibanText.style.cursor = 'zoom-out'; // Büyüdüğünde imleci zoom-out yap
        }
        isTextEnlarged = !isTextEnlarged; // Toggle durumunu değiştir
    }
</script>


<!--Puantaj Tablosu-->


<script>
    function savePuantaj(checkbox) {
        // Checkbox'tan ilgili verileri al
        var workerId = $(checkbox).attr('workerid');
        var date = $(checkbox).attr('date');
        var isChecked = checkbox.checked ? 1 : 0; // CheckBox'ın durumuna göre 1 (checked) veya 0 (unchecked) değeri

        // AJAX isteği gönder
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Site/update_puantaj/$item->id"); ?>", // Sunucunuzun POST isteğini alacağı adres
            data: {
                workerId: workerId,
                date: date,
                isChecked: isChecked // CheckBox'ın durumu
            },
            success: function (response) {
                // Başarılı yanıt aldığınızda yapılacak işlemler
                $(".puantaj_total").html(response);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>

<script>
    function puantajDate(element) {
        var month = $('select[name="month"]').val();
        var year = $('select[name="year"]').val();

        var url = $('#puantajDate').attr('url');

        $.ajax({
            url: url,
            type: 'POST',
            data: {month: month, year: year},
            success: function (response) {
                $(".puantaj_list").html(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>


<script>
    function sendPuantajDate(type) {
        // Seçili ay ve yılı al
        var month = $('#month').val();
        var year = $('#year').val();

        // Bağlantı URL'sini oluştur
        var url;
        if (type == 'excel') {  // 'excel' değerini doğru şekilde string olarak yazdık
            url = '<?php echo base_url("Export/puantaj_print_excel/$item->id"); ?>/' + month + '/' + year;
        } else {
            url = '<?php echo base_url("Export/puantaj_print/$item->id"); ?>/' + month + '/' + year;
        }

        // AJAX isteğini gönder
        $.ajax({
            url: url,
            type: 'POST',
            data: {month: month, year: year},
            success: function (response) {
                // AJAX isteği başarılı olduğunda yapılacak işlemler
                console.log("AJAX isteği başarıyla tamamlandı.");
            },
            error: function (xhr, status, error) {
                // AJAX isteği başarısız olduğunda yapılacak işlemler
                console.error("AJAX isteği sırasında bir hata oluştu:", error);
            }
        });

        // Yeni sekme aç
        window.open(url, '_blank');
    }
</script>

<!--Puantaj Tablosu Bitiş-->


<!--İş Grupları-->

<script>
    function add_group(anchor) {
        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_list").html(response);
        })
    }

    function add_group_machine(anchor) {
        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_list_machine").html(response);
        })
    }

</script>

<!--Rapor İmza Ayarı-->


<script>
    $(document).ready(function () {
        $(".sortable").sortable();
        $(".sortable").on("sortupdate", function (event, ui) {
            var $data = $(this).sortable("serialize");
            var $data_url = $(this).data("url");
            $.post($data_url, {data: $data}, function (response) {
                // İsteğe bağlı: yanıtı işleyebilirsiniz
            });
        });
    });
</script>


<script>
    function delete_sign(btn) {
        var $url = btn.getAttribute('url');
        var $div = btn.getAttribute('div');

        Swal.fire({
            title: "Tüm isimler silinecek?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sil",
            cancelButtonText: "İptal",
            reverseButtons: true,
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.post($url, {}, function (response) {
                    $("." + $div).html(response);
                    $(".sortable").sortable();
                    $(".sortable").on("sortupdate", function (event, ui) {
                        var $data = $(this).sortable("serialize");
                        var $data_url = $(this).data("url");
                        $.post($data_url, {data: $data}, function (response) {
                            // İsterseniz burada bir işlem yapabilirsiniz
                        });
                    });
                });
                Swal.fire("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });
            } else {
                Swal.fire("Dosya Güvende");
            }
        });
    }
</script>


<script>
    function add_sign(anchor) {
        var formId = anchor.getAttribute('form-id');
        var divId = $("#" + formId).attr("div");
        var formAction = $("#" + formId).attr("action");
        var formData = $("#" + formId).serialize();

        $.post(formAction, formData, function (response) {
            $("." + divId).html(response);
            $(".sortable").sortable();
            $(".sortable").on("sortupdate", function (event, ui) {
                var $data = $(this).sortable("serialize");
                var $data_url = $(this).data("url");
                $.post($data_url, {data: $data}, function (response) {
                })
            })
        });
    }
</script>

<script>
    function delete_sign(btn) {
        var $url = btn.getAttribute('url');
        var $div = btn.getAttribute('div');

        Swal.fire({
            title: "Bu isim silinecek?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sil",
            cancelButtonText: "İptal",
            reverseButtons: true,
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.post($url, {}, function (response) {
                    $("." + $div).html(response);
                    $(".sortable").sortable();
                    $(".sortable").on("sortupdate", function(event, ui){
                        var $data = $(this).sortable("serialize");
                        var $data_url = $(this).data("url");
                        $.post($data_url, {data : $data}, function(response){});
                    });
                });

                Swal.fire("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });

            } else {
                Swal.fire("Dosya Güvende");
            }
        });
    }
</script>

<!-- Favori İşareti-->
<script>
    function changeIcon(anchor) {
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            // Gerekirse response verisini işleyebilirsiniz
        });

        var icon = anchor.querySelector("i");
        var text = anchor.querySelector("span");

        // İkon sınıfını değiştir
        icon.classList.toggle('fa-star');
        icon.classList.toggle('fa-times');

        // Metni ve rengi değiştir
        if (text.innerText === "Favori Ekle") {
            text.innerText = "Favori Çıkart";
            icon.style.color = "tomato"; // Favori çıkartıldığında kırmızı çarpı
        } else {
            text.innerText = "Favori Ekle";
            icon.style.color = "gold"; // Favori eklendiğinde sarı yıldız
        }
    }

    function change_Status(anchor) {
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            // Gerekirse response verisini işleyebilirsiniz
        });

        var icon = anchor.querySelector("i");
        var text = anchor.querySelector("span");

        // Duruma göre ikon ve metin değişimi
        if (text.innerText === "Tamamlandı Olarak İşaretle") {
            text.innerText = "Devam Ediyor Olarak İşaretle";
            icon.classList.remove('fa-check');
            icon.classList.add('fa-circle-o-notch');
            icon.style.color = "blue";  // Devam ediyor rengi mavi
        } else {
            text.innerText = "Tamamlandı Olarak İşaretle";
            icon.classList.remove('fa-circle-o-notch');
            icon.classList.add('fa-check');
            icon.style.color = "green";  // Tamamlandı rengi yeşil
        }
    }

</script>
<!-- Favori İşareti Son-->



<script>
    // clearAddPersonelFormCustom fonksiyonunuzun tanımı
    function clearAddPersonelFormCustom() {
        const form = document.getElementById('addPersonelForm');
        if (!form) {
            console.error("Form with ID 'addPersonelForm' not found in clearAddPersonelFormCustom.");
            return;
        }

        // Tüm metin, sayı ve textarea inputlarını temizle
        form.querySelectorAll('input[type="text"], input[type="number"], textarea').forEach(input => {
            input.value = '';
            input.classList.remove('is-invalid');
            // Hata mesajını kaldıralım, varsayalım input'tan sonraki ilk sibling invalid-feedback
            // Eğer yapınız farklıysa bu kısmı düzeltmeniz gerekebilir (örn: div > input + div.invalid-feedback)
            if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                input.nextElementSibling.remove();
            }
        });

        // Tarih inputunu temizle
        form.querySelectorAll('input[type="date"]').forEach(input => {
            input.value = '';
            input.classList.remove('is-invalid');
            if (input.nextElementSibling && input.nextElementSibling.classList.contains('invalid-feedback')) {
                input.nextElementSibling.remove();
            }
        });

        // Dosya inputunu temizle
        form.querySelectorAll('input[type="file"]').forEach(input => {
            input.value = '';
        });

        // Select2 ile oluşturulmuş select kutularını temizle (jQuery gerekli)
        // Eğer bu Select2'lerinizde varsayılan bir "Seçiniz" opsiyonu varsa,
        // .val('').trigger('change') daha uygun olabilir.
        const professionSelect = $('#select2-demo-profession');
        if (professionSelect.length) {
            professionSelect.val(null).trigger('change');
            // Select2'nin "placeholder"ını tekrar göstermesi için de tetikleme gerekebilir.
            // Bu genellikle .val(null).trigger('change') ile olur.
        }

        const bankSelect = $('#select2-demo-bank');
        if (bankSelect.length) {
            bankSelect.val(null).trigger('change');
        }

        // Genel .is-invalid sınıflarını ve .invalid-feedback divlerini kaldır
        form.querySelectorAll('.is-invalid').forEach(element => {
            element.classList.remove('is-invalid');
        });

        form.querySelectorAll('.invalid-feedback').forEach(feedbackDiv => {
            feedbackDiv.remove();
        });

        console.log('addPersonelForm temizleme işlemi tamamlandı.'); // Konsol çıktısı
    }


    // Bootstrap Modal Olay Dinleyicisi
    $(document).ready(function() {
        // 'AddPersonelModal' açılmadan hemen önce tetiklenir
        $('#AddPersonelModal').on('show.bs.modal', function (e) {
            console.log('AddPersonelModal açılma olayı tetiklendi. Form temizleniyor...');
            clearAddPersonelFormCustom();
        });
    });
</script>