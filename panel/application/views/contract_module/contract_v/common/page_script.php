<script src="<?php echo base_url("assets"); ?>/js/jquery.repeater.js"></script><!--Form Inputs-->

<script src="<?php echo base_url("assets"); ?>/js/datepicker/date-picker/datepicker.js"></script><!--Form Inputs-->
<script src="<?php echo base_url("assets"); ?>/js/datepicker/date-picker/datepicker.en.js"></script><!--Form Inputs-->
<script src="<?php echo base_url("assets"); ?>/js/datepicker/date-picker/datepicker.custom.js"></script><!--Form Inputs-->
<!-- Plugins JS start-->

<script src="<?php echo base_url("assets"); ?>/js/tooltip-init.js"></script>
<!-- Plugins JS Ends-->
<!-- scrollbar js-->
<script src="<?php echo base_url("assets"); ?>/js/scrollbar/simplebar.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/scrollbar/custom.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/editor/ckeditor/ckeditor.js"></script>


<script> function enable() {
        document.getElementById("change").disabled = false;
        var x = document.getElementById("save_button");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>



<script>
    function changeIcon(anchor) {
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
        })

        var icon = anchor.querySelector("i");
        icon.classList.toggle('fa-star');
        icon.classList.toggle('fa-star-o');
    }
</script>

<script>

    function update_group(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_group").html(response);
        });
    }
</script>

<script>
    function delete_group(element) {
        var itemId = element.id;
        var formAction = '<?php echo base_url("contract/delete_group/"); ?>' + itemId;

        $.post(formAction, function (response) {
            $(".refresh_group").html(response);

        });
    }
</script>

<script>
    // Checkbox öğesini seçiyoruz
    var checkbox = document.getElementById("toggleCheckbox");

    // Checkbox durumunu takip ediyoruz
    checkbox.addEventListener("change", function () {
        // Tüm input öğelerini seçiyoruz
        var inputElements = document.querySelectorAll("input[type='text']");

        // Checkbox işaretlendiğinde veya kaldırıldığında tüm input öğelerini etkinleştir veya devre dışı bırak
        for (var i = 0; i < inputElements.length; i++) {
            inputElements[i].disabled = !checkbox.checked;
        }
    });
</script>


<script>
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
</script>

<script>
    function open_contract_group(anchor) {
        $(".contract_group").show();
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            $(".contract_group").html(response);
            $('#list').DataTable();
        })
    }
</script>

<script>
    function delete_item(anchor) {
        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".contract_group").html(response);
        })
    }
</script>
<script>
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

</script>
<script>
    function update_price(anchor) {
        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".price_update").html(response);
            hesaplaT();
            activateDragAndDrop();
            addInputListeners("q");
            addInputListeners("p");
        });
    }
</script>
<script>
    function addLeader() {
        $("#add_leader_btn").click(function (e) {
            e.preventDefault();

            var leader_code = $("#leader_code").val();
            var leader_name = $("#leader_name").val();
            var leader_unit = $("#leader_unit").val();
            var leader_price = $("#leader_price").val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url("contract/add_leader/$item->id"); ?>",
                data: {
                    leader_code: leader_code,
                    leader_name: leader_name,
                    leader_unit: leader_unit,
                    leader_price: leader_price
                },
                success: function (response) {
                    // Sunucudan gelen yanıtı alarak price_update div'ini güncelle
                    $(".price_update").html(response);
                    hesaplaT();
                    activateDragAndDrop();
                    addLeader();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
        hesaplaT();
        activateDragAndDrop();
    }

    // Fonksiyonu çağırarak çalıştırabilirsiniz
    addLeader();
</script>
<script>
    function delete_price_item(element) {
        var itemId = element.id;
        var formAction = '<?php echo base_url("contract/delete_contract_price/"); ?>' + itemId;

        $.post(formAction, function (response) {
            $(".price_update").html(response);
            hesaplaT();
            activateDragAndDrop();
            addInputListeners("q");
            addInputListeners("p");
            addLeader()
        })
            .fail(function (error) {
                // Hata durumunda bu fonksiyon çalışır
                console.error('Error:', error.responseText);
                hesaplaT();
                activateDragAndDrop();
                addInputListeners("q");
                addInputListeners("p");
                addLeader();
            });

    }
</script>

<script>
    function activateDragAndDrop() {
        // Sürükleyici öğeleri seç
        var dragSources = document.querySelectorAll('#dragSource');
        // Hedef alanları seç
        var dropTargets = document.querySelectorAll('.dropTarget');

        // Her bir sürükleyici öğe için sürükleme başlatma olayını ekle
        dragSources.forEach(function (dragSource) {
            dragSource.addEventListener('dragstart', function (event) {
                // Veri aktarımı sırasında taşınacak veriyi belirt
                event.dataTransfer.setData('text/plain', event.target.dataset.info);
            });
        });

        // Her bir hedef alanı için bırakma olayını ekle
        dropTargets.forEach(function (dropTarget) {
            dropTarget.addEventListener('drop', function (event) {
                // Varsayılan davranışı engelle (örneğin, bağlantıyı açmayı engelle)
                event.preventDefault();
                // Sürüklenen öğenin veri bilgisini al
                var draggedItemData = event.dataTransfer.getData('text/plain');
                // Hedef alanın veri bilgisini al
                var dropTargetData = dropTarget.dataset.info;
                // Alert ile bilgileri ekrana bastır

                var formAction = '<?php echo base_url("contract/drag_drop_price/$item->id/"); ?>' + draggedItemData + "/" + dropTargetData;

                $.post(formAction, function (response) {
                    $(".price_update").html(response);
                    hesaplaT();
                    addLeader();
                    activateDragAndDrop();
                    addInputListeners("q");
                    addInputListeners("p");
                    activateDragAndDrop();
                });

            });

            // Bırakma olayının varsayılan davranışını engelle
            dropTarget.addEventListener('dragover', function (event) {
                event.preventDefault();
            });
        });
    }
    // Sürükleyici ve bırakma işlevselliğini etkinleştir
    activateDragAndDrop();
</script>

