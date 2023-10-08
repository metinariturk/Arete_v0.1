<script>
    // Input alanlarını virgülleri otomatik olarak noktaya çevir ve hesaplamaları yap
    var inputElements = document.querySelectorAll('input[id$="_thisqty"], input[id$="_unitprice"], input[id$="_oldqty"]');
    inputElements.forEach(function(input) {
        input.addEventListener("input", function() {
            var id = input.id.split("_")[0]; // ID'den malzeme numarasını al

            // Virgülü otomatik olarak noktaya çevir
            var inputValue = input.value;
            input.value = inputValue.replace(/,/g, '.');

            // Hesaplamaları yap
            calculateTotal(id);
            calculateoldTotal(id);
        });
    });

    function formatNumberWithSpaces(number) {
        // Sayıyı binlik ayracı olan boşlukla formatla
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    function calculateTotal(materialId) {
        var qtyInput = document.getElementById(materialId + "_thisqty");
        var priceInput = document.getElementById(materialId + "_unitprice");
        var totalInput = document.getElementById(materialId + "_thisprice");

        // Kullanıcının girdiği değeri alırken virgülü otomatik olarak noktaya çeviriyoruz
        var qtyValue = qtyInput.value.replace(/ /g, '').replace(',', '.'); // Girilen boşluğu kaldır ve virgülü noktaya çevir
        var priceValue = priceInput.value.replace(/ /g, '').replace(',', '.'); // Girilen boşluğu kaldır ve virgülü noktaya çevir

        var qty = parseFloat(qtyValue) || 0; // Miktarı al, eğer geçersizse veya boşsa 0 kabul et
        var price = parseFloat(priceValue) || 0; // Birim fiyatı al, eğer geçersizse veya boşsa 0 kabul et

        var total = qty * price; // Toplam maliyeti hesapla

        totalInput.value = formatNumberWithSpaces(total.toFixed(2)); // Toplam maliyeti binlik ayracı ile formatlı olarak input alanına yaz

        // Tüm "_total" input alanlarının toplamını hesapla
        var totalContract = 0;
        var totalInputs = document.querySelectorAll('input[id$="_thisprice"]');
        totalInputs.forEach(function(input) {
            totalContract += parseFloat(input.value.replace(/ /g, '')) || 0; // Girilen boşluğu kaldır
        });

        // Toplam maliyeti "total_contract" input alanına yaz
        document.getElementById("this_payment").value = formatNumberWithSpaces(totalContract.toFixed(2));

        var oldQtyInput = document.getElementById(materialId + "_oldqty");
        var oldPriceInput = document.getElementById(materialId + "_unitprice");
        var oldTotalInput = document.getElementById(materialId + "_oldprice");

        // Kullanıcının girdiği değeri alırken virgülü otomatik olarak noktaya çeviriyoruz
        var oldQtyValue = oldQtyInput.value.replace(/ /g, '').replace(',', '.'); // Girilen boşluğu kaldır ve virgülü noktaya çevir
        var oldPriceValue = oldPriceInput.value.replace(/ /g, '').replace(',', '.'); // Girilen boşluğu kaldır ve virgülü noktaya çevir

        var oldQty = parseFloat(oldQtyValue) || 0; // Miktarı al, eğer geçersizse veya boşsa 0 kabul et
        var oldPrice = parseFloat(oldPriceValue) || 0; // Birim fiyatı al, eğer geçersizse veya boşsa 0 kabul et

        var oldTotal = oldQty * oldPrice; // Toplam maliyeti hesapla

        oldTotalInput.value = formatNumberWithSpaces(oldTotal.toFixed(2)); // Toplam maliyeti binlik ayracı ile formatlı olarak input alanına yaz

        // Tüm "_total" input alanlarının toplamını hesapla
        var oldTotalContract = 0;
        var oldTotalInputs = document.querySelectorAll('input[id$="_oldprice"]');
        oldTotalInputs.forEach(function(input) {
            oldTotalContract += parseFloat(input.value.replace(/ /g, '')) || 0; // Girilen boşluğu kaldır
        });

        // Toplam maliyeti "total_contract" input alanına yaz
        document.getElementById("old_payment").value = formatNumberWithSpaces(oldTotalContract.toFixed(2));

        var sonuc = oldTotal + total;
        document.getElementById(materialId + "_totalprice").value = formatNumberWithSpaces(sonuc.toFixed(2));

        var genel_sonuc = oldTotalContract + totalContract;
        document.getElementById("total_payment").value = formatNumberWithSpaces(genel_sonuc.toFixed(2));
    }

</script>
