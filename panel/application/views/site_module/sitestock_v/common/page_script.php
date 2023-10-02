<script src="<?php echo base_url("assets"); ?>/js/jquery.repeater.js"></script><!--Form Inputs-->

<script>
    $(document).ready(function () {
        $('.repeater').repeater({
            // (Required if there is a nested repeater)
            // Specify the configuration of the nested repeaters.
            // Nested configuration follows the same format as the base configuration,
            // supporting options "defaultValues", "show", "hide", etc.
            // Nested repeaters additionally require a "selector" field.
            repeaters: [{
                // (Required)
                // Specify the jQuery selector for this nested repeater
                selector: '.inner-repeater'
            }],
            hide: function (deleteElement) {
                if (confirm('Bu satırı Silmek İstediğinize Emin Misiniz?')) {
                    $(this).slideUp(deleteElement);
                }
            },
        });
    });
</script>

<script>
    function extraction(button) {
        // Formun parent form elementini bulur
        var form = button.closest("form");

        // AJAX çağrısı yapılır
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Başarılı yanıt alındığında, hedef div'i günceller
                    document.getElementById("resultDiv").innerHTML = xhr.responseText;
                } else {
                    // İstek sırasında hata oluştuysa, hata mesajını görüntüler
                    console.error("Hata: " + xhr.status);
                }
            }
        };

        // AJAX isteği yapılır
        xhr.open(form.method, form.action, true);
        xhr.setRequestHeader("Content-Type", "multipart/form-data");
        xhr.send(new FormData(form));

        // Formun gönderilmesini engeller
        return false;
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        let income = parseFloat(document.getElementById("icomeDiv").innerText.replace(".", "").replace(",", "."));
        let remain = 0;
        document.querySelectorAll('[id^="remain"]').forEach(function(span) {
            remain += parseFloat(span.innerText.replace(".", "").replace(",", "."));
        });
        let used = income - remain;
        document.getElementById("remainDiv").innerText = formatNumber(remain);
        document.getElementById("usedDiv").innerText = formatNumber(used);
    });

    function formatNumber(number) {
        return new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(number);
    }
</script>


