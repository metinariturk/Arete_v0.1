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
                    success: function(response) {
                        alert("başarılı silindi");
                        // tab_3_sitestock div'ini yenile
                        $('#tab_3_sitestock').html(response);
                    },
                    error: function() {
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