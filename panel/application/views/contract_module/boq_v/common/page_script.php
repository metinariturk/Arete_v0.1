<script>
    function renderCalculate(btn) {
        var $url = btn.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".dynamic").html(response);
        })
    }
</script>
<script>
    function calculateAndSetResult(income, row_number) {
        var totalResult = 0;
        var total = 0; // Toplamı saklamak için bir değişken tanımlayın
        var allEmpty = true; // Tüm q, w, h, l değerleri boş mu?

        for (var i = 1; i <= 10; i++) {
            var q = parseFloat(document.getElementById('q_' + income + '_' + i).value);
            var w = parseFloat(document.getElementById('w_' + income + '_' + i).value);
            var h = parseFloat(document.getElementById('h_' + income + '_' + i).value);
            var l = parseFloat(document.getElementById('l_' + income + '_' + i).value);

            var qElement = document.getElementById('q_' + income + '_' + i);
            if (qElement) {
                var q = parseFloat(qElement.value);
                // Diğer işlemleri yapın
            } else {
                console.log("Element bulunamadı: q_" + income + "_" + i);
            }

            var n = document.getElementById('n_' + income + '_' + i).value.toLowerCase();

            var forbiddenWord = 'minha';

            var qInput = document.getElementById('q_' + income + '_' + i);
            var wInput = document.getElementById('w_' + income + '_' + i);
            var nInput = document.getElementById('n_' + income + '_' + i);
            var sInput = document.getElementById('s_' + income + '_' + i);
            var hInput = document.getElementById('h_' + income + '_' + i);
            var lInput = document.getElementById('l_' + income + '_' + i);
            var tInput = document.getElementById('t_' + income + '_' + i);

            if (n.includes(forbiddenWord)) {
                qInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                wInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                hInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                lInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                tInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                nInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
                sInput.style.backgroundColor = 'rgba(246,145,98,0.66)';
            } else {
                qInput.style.backgroundColor = '';
                wInput.style.backgroundColor = '';
                hInput.style.backgroundColor = '';
                lInput.style.backgroundColor = '';
                tInput.style.backgroundColor = '';
                nInput.style.backgroundColor = '';
                sInput.style.backgroundColor = '';
            }

            // Değerler boşsa, t değerini 0 olarak ayarla
            if (isNaN(q) && isNaN(w) && isNaN(h) && isNaN(l)) {
                document.getElementById('t_' + income + '_' + i).value = "0";
            } else {
                q = q || 1; // Eğer q değeri yoksa veya NaN ise 1 olarak ayarla
                w = w || 1; // Benzer şekilde diğer değerleri de düzelt
                h = h || 1;
                l = l || 1;

                var m = n.includes(forbiddenWord) ? -1 : 1;

                var result = m * q * w * h * l;
                result = result.toFixed(2);
                document.getElementById('t_' + income + '_' + i).value = result;
                totalResult += parseFloat(result);
                allEmpty = false; // En az bir değer dolu, allEmpty değerini false yap
            }

        }

        if (allEmpty) {
            document.getElementById('total_' + income).value = "0";
        } else {
            document.getElementById('total_' + income).value = totalResult.toFixed(2);
        }

    }

</script>
<script>
    function toggleReadOnly(income) {
        var toggleCheckbox = document.getElementById('toggleCheckbox');
        var readonlyInput = document.getElementById('total_' + income);

        readonlyInput.readOnly = !toggleCheckbox.checked;

        for (var i = 1; i <= 10; i++) {
            var qInput = document.getElementById('q_' + income + '_' + i);
            var wInput = document.getElementById('w_' + income + '_' + i);
            var nInput = document.getElementById('n_' + income + '_' + i);
            var sInput = document.getElementById('s_' + income + '_' + i);
            var hInput = document.getElementById('h_' + income + '_' + i);
            var lInput = document.getElementById('l_' + income + '_' + i);
            var tInput = document.getElementById('t_' + income + '_' + i);

            qInput.readOnly = toggleCheckbox.checked;
            wInput.readOnly = toggleCheckbox.checked;
            nInput.readOnly = toggleCheckbox.checked;
            sInput.readOnly = toggleCheckbox.checked;
            hInput.readOnly = toggleCheckbox.checked;
            lInput.readOnly = toggleCheckbox.checked;
            tInput.readOnly = toggleCheckbox.checked;
        }
    }
</script>