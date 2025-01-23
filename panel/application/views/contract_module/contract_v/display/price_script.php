

<script>

    function update_group(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_tab_5").html(response);
        });
    }

    function delete_group(element, groupType) {
        var itemId = element.id;
        var formAction = '<?php echo base_url("contract/delete_group/"); ?>' + itemId;
        var title, text;

        // Silme türüne göre başlık ve metni ayarla
        if (groupType === 'main') {
            title = 'Silmek Üzeresiniz!';
            text = 'Bu grubu silerseniz, alt gruplar ve alt gruplara bağlı pozların hakedişlerdeki yaptığınız tüm metrajları da silinecektir? Emin misiniz?';
        } else if (groupType === 'sub') {
            title = 'Silmek Üzeresiniz!';
            text = 'Bu alt grubu silerseniz, hakedişlerdeki bu alt gruba dair yaptığınız tüm metrajlar da silinecektir? Emin misiniz?';
        }

        // SweetAlert ile onay penceresi
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'Hayır, iptal et'
        }).then((result) => {
            if (result.isConfirmed) {
                // Onay verildiyse silme işlemini gerçekleştir
                $.post(formAction, function (response) {
                    // Silme işleminden sonra sayfayı güncelle
                    $(".refresh_group").html(response);
                    Swal.fire(
                        'Silindi!',
                        'Grup başarıyla silindi.',
                        'success'
                    );
                }).fail(function () {
                    // Silme işleminde bir hata oluşursa kullanıcıyı bilgilendir
                    Swal.fire(
                        'Hata!',
                        'Silme işlemi sırasında bir hata oluştu.',
                        'error'
                    );
                });
            }
        });
    }

    // Input alanlarının değişikliklerini dinlemek için event listener ekle
    var inputElements = document.querySelectorAll('input[id$="_qty"], input[id$="_price"]');
    inputElements.forEach(function (input) {
        input.addEventListener("input", function () {
            var id = input.id.split("_")[0]; // ID'den malzeme numarasını al
            calculateTotal(id);
        });

        // Virgülü otomatik olarak noktaya çevir
        input.addEventListener("input", function () {
            var inputValue = input.value;
            // Virgülü noktaya çevir
            input.value = inputValue.replace(/,/g, '.');
        });
    });

    function formatNumberWithSpaces(number) {
        // Sayıyı binlik ayracı olan boşlukla formatla
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    function calculateTotal(materialId) {
        var qtyInput = document.getElementById(materialId + "_qty");
        var priceInput = document.getElementById(materialId + "_price");
        var totalInput = document.getElementById(materialId + "_total");

        // Kullanıcının girdiği değeri alırken virgülü otomatik olarak noktaya çeviriyoruz
        var qtyValue = qtyInput.value.replace(/ /g, '').replace(',', '.'); // Girilen boşluğu kaldır ve virgülü noktaya çevir
        var priceValue = priceInput.value.replace(/ /g, '').replace(',', '.'); // Girilen boşluğu kaldır ve virgülü noktaya çevir

        var qty = parseFloat(qtyValue) || 0; // Miktarı al, eğer geçersizse veya boşsa 0 kabul et
        var price = parseFloat(priceValue) || 0; // Birim fiyatı al, eğer geçersizse veya boşsa 0 kabul et

        var total = qty * price; // Toplam maliyeti hesapla

        totalInput.value = formatNumberWithSpaces(total.toFixed(2)); // Toplam maliyeti binlik ayracı ile formatlı olarak input alanına yaz

        // Tüm "_total" input alanlarının toplamını hesapla
        var totalContract = 0;
        var totalInputs = document.querySelectorAll('input[id$="_total"]');
        totalInputs.forEach(function (input) {
            totalContract += parseFloat(input.value.replace(/ /g, '')) || 0; // Girilen boşluğu kaldır
        });

        // Toplam maliyeti "total_contract" input alanına yaz
        document.getElementById("total_contract").value = formatNumberWithSpaces(totalContract.toFixed(2));
    }

    function open_contract_group(anchor) {
        $(".contract_group").show();
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            $(".contract_group").html(response);
            $('#list').DataTable();
        })
    }

    function delete_item(anchor) {
        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".contract_group").html(response);
        })
    }

    function hesaplaT(inputId) {
        // "q-X" ve "p-X" inputlarının id'sinden tüm inputları alın
        var qInput = document.querySelector('input[id="q-' + inputId + '"]');
        var pInput = document.querySelector('input[id="p-' + inputId + '"]');
        var tInput = document.querySelector('input[id="t-' + inputId + '"]');

        if (qInput && pInput && tInput) {
            // q ve p değerlerini alın
            var q = parseFloat(qInput.value) || 0;
            var p = parseFloat(pInput.value) || 0;

            // Çarpma işlemi
            var t = q * p;

            // Sonucu t-X inputuna yazın
            tInput.value = t.toFixed(2);
        }
    }

    function addInputListeners(inputType) {
        // Tüm "inputType-X" inputlarına bir "input" olay dinleyici ekleyin
        var inputs = document.querySelectorAll('input[id^="' + inputType + '-"]');
        inputs.forEach(function (input) {
            var inputId = input.id.split('-')[1];
            input.addEventListener('input', function () {
                hesaplaT(inputId);
            });
        });
    }

    // "q-X" inputlarına olay dinleyicilerini ekle
    addInputListeners("q");

    // "p-X" inputlarına olay dinleyicilerini ekle
    addInputListeners("p");

    function update_price(anchor) {
        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".price_update").html(response);
            hesaplaT();
            addInputListeners("q");
            addInputListeners("p");
        });
    }

    function delete_leader(element) {
        var itemId = element.id;
        var formAction = '<?php echo base_url("contract/delete_contract_price/"); ?>' + itemId;

        // SweetAlert ile onay kutusu ekleyelim
        Swal.fire({
            title: 'Bu öğeyi silmek istediğinizden emin misiniz?',
            text: "Bu işlemi geri alamazsınız!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, sil!',
            cancelButtonText: 'Hayır, vazgeç'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kullanıcı onaylarsa, AJAX isteğini yapalım
                $.post(formAction, function (response) {
                    if (response) { // Yanıtın boş olmadığını kontrol et
                        $(".leader_list").html(response);
                        Swal.fire(
                            'Silindi!',
                            'Öğe başarıyla silindi.',
                            'success'
                        );
                    } else {
                        console.error("AJAX isteği başarılı ancak boş yanıt alındı.");
                        Swal.fire(
                            'Hata!',
                            'Yanıt boş döndü.',
                            'error'
                        );
                    }
                })
                    .fail(function () {
                        console.error("AJAX isteği başarısız oldu.");
                        Swal.fire(
                            'Hata!',
                            'Silme işlemi başarısız oldu.',
                            'error'
                        );
                    });
            }
        });
    }

    // Displayde add_bond modal_form automatic calculation
    function calcular() {
        var valorA = parseFloat(document.getElementById('calA').value, 10); //A Hücresi Veri Giriş
        var valorB = parseFloat(document.getElementById('calB').value, 10); //B Hücresi Veri Giriş
        var valorC = valorA / valorB * 100; //C Hücresi Hesaplama
        var valorD = valorA / valorB * 100; //C Hücresi Hesaplama
        if (valorB > 0) {
            document.getElementById('calC').innerHTML = valorC.toFixed(2);
            document.getElementById('calD').value = valorD.toFixed(2);
        } else {
            document.getElementById('calC').innerHTML = 0;
            document.getElementById('calD').value = 0;
        }
    }

    function myFunction(e) {
        e.value = e.value.replace(/,/g, '.')
    }

    function save_leader(formId) {
        event.preventDefault(); // Formun normal submit edilmesini engeller
        var form = document.getElementById(formId);
        var formData = new FormData(form);

        // Ajax isteği
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Gelen cevabı leader_list div'ine yerleştir
                document.getElementById('leader_list').innerHTML = xhr.responseText;
            }
        };
        xhr.send(formData);
    }

    <!--Bu script poz kitabına eklenen poz üzerinde düzenleme yapmamızı sağlıyor.-->

    function update_leader_form(element) {

        <?php echo base_url('contract/update_leader'); ?>
        // Tıklanan satırdaki verileri bul
        var row = $(element).closest('tr');
        var leaderId = $(element).attr('id');
        var leaderCode = row.find('td:eq(1)').text(); // 1. sütundaki Kodu
        var leaderName = row.find('td:eq(2)').text(); // 2. sütundaki Poz Adı
        var leaderUnit = row.find('td:eq(3)').text(); // 3. sütundaki Birimi
        var leaderPrice = row.find('td:eq(4)').text(); // 4. sütundaki Fiyat

        // Bu verileri düzenleme formuna yerleştir (örneğin, bir modal açabilirsiniz)
        $('#edit_leader_id').val(leaderId);
        $('#edit_leader_code').val(leaderCode);
        $('#edit_leader_name').val(leaderName);
        $('#edit_leader_unit').val(leaderUnit);
        $('#edit_leader_price').val(leaderPrice);

        // Modal'ı açmak için:
        $('#editLeaderModal').modal('show');
    }

    function update_leader(element) {
        // Form verilerini al
        var formData = $('#edit_leader_form').serialize();

        $.ajax({
            url: '<?php echo base_url("contract/update_leader"); ?>',  // Controller URL'si
            type: 'POST',
            data: formData,
            success: function (response) {
                // Başarılı olursa modalı kapat ve formu sıfırla
                $('#editLeaderModal').modal('hide');
                $('#edit_leader_form')[0].reset();

                // Gelen cevabı direkt leader_list div'ine yerleştir
                $('#leader_list').html(response);
            },
            error: function (xhr, status, error) {
                // Hata varsa burada işlem yapılabilir
                alert('Bir hata oluştu: ' + error);
            }
        });
    }

    <!--birim fiyatların toplandığı tablo-->
    document.addEventListener('DOMContentLoaded', function () {
        // Kaydet butonuna tıklama olayını dinleyin
        document.getElementById('save-button-top').addEventListener('click', saveData);
        document.getElementById('save-button-bottom').addEventListener('click', saveData);

        // Miktar ve birim fiyat değiştiğinde toplamı güncelle
        document.querySelectorAll('.qty, .unit-price').forEach(function (element) {
            element.addEventListener('input', updateTotals);
        });

        function updateTotals() {
            document.querySelectorAll('.qty').forEach(function (qtyInput) {
                const rowId = qtyInput.getAttribute('data-row-id');
                const unitPrice = parseFloat(document.querySelector(`.unit-price[data-row-id="${rowId}"]`).textContent);
                const qty = parseFloat(qtyInput.value) || 0;
                const total = (unitPrice * qty).toFixed(2);
                document.querySelector(`.total[data-row-id="${rowId}"]`).textContent = total;
            });
        }

        function saveData() {
            const data = [];
            document.querySelectorAll('.qty').forEach(function (input) {
                const rowId = input.getAttribute('data-row-id');
                const qty = parseFloat(input.value) || 0;
                data.push({id: rowId, qty: qty});
            });

            fetch('<?php echo base_url("contract/update_boqs"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Veriler başarıyla güncellendi.');
                    } else {
                        alert('Bir hata oluştu.');
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                });
        }
    });


    function saveData() {
        const data = [];
        document.querySelectorAll('.qty').forEach(function (input) {
            const rowId = input.getAttribute('data-row-id');
            const qty = parseFloat(input.value) || 0;
            data.push({id: rowId, qty: qty});
        });

        fetch('<?php echo base_url("contract/update_boqs"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Veriler başarıyla güncellendi.');
                } else {
                    alert('Bir hata oluştu.');
                }
            })
            .catch(error => {
                console.error('Hata:', error);
            });
    }

    function refresh_leader_group(anchor) {
        // data-id ve data-url değerlerini al
        const id = anchor.getAttribute('data-id');
        const url = anchor.getAttribute('data-url') + id;

        // jQuery ile AJAX POST isteği
        $.post(url, {}, function (response) {
            $("#contract_group_div").html(response);
        }).fail(function (xhr, status, error) {
            console.error('Hata:', error);
            alert('Bir hata oluştu, lütfen tekrar deneyin.');
        });
    }

    function refresh_contract_price(anchor) {
        // data-id ve data-url değerlerini al
        const id = anchor.getAttribute('data-id');
        const url = anchor.getAttribute('data-url') + id;

        // jQuery ile AJAX POST isteği
        $.post(url, {}, function (response) {
            $("#contract_price_div").html(response);
        }).fail(function (xhr, status, error) {
            console.error('Hata:', error);
            alert('Bir hata oluştu, lütfen tekrar deneyin.');
        });
    }





</script>