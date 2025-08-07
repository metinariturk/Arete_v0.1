<script>
    function delete_boq(btn) {
        var $url = btn.getAttribute('url');

        Swal.fire({
            title: "Metrajı Silmek İstediğine Emin Misin?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sil",
            cancelButtonText: "İptal",
            dangerMode: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.post($url, {}, function (response) {
                    $(".dynamic").html(response);
                });

                Swal.fire("Metraj Başarılı Bir Şekilde Silindi", {
                    icon: "İşlem Tamam",
                });

            } else {
                Swal.fire("Metraj Güvende");
            }
        });
    }
</script>
<script>
    function renderCalculate(btn) {
        var $url = btn.getAttribute('url');
        $.post($url, {}, function (response) {
            $(".dynamic").html(response);
        })
    }
</script>
<script>
    function saveManuel(buttonElement) {

        var url = buttonElement.getAttribute('data-url');
        var formId = buttonElement.getAttribute('form');

        // Serialize the form data
        var formData = new FormData(document.getElementById(formId));

        // Send an AJAX POST request
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Assuming the response contains the updated content
                $(".dynamic").html(response);
                var autoRefreshButton = document.querySelector('.auto-refresh-button');
                if (autoRefreshButton) {
                    autoRefreshButton.click();
                }

            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>
<script>
    function renderGroup(btn) {
        var $url = btn.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".renderGroup").html(response);
        })
    }
</script>
<script>
    function auto_refresh_list() {
        var contractId = document.getElementById("myElement").getAttribute("data-contract-id");
        var paymentNo = document.getElementById("myElement").getAttribute("data-payment-no");
        var groupId = document.getElementById("myElement").getAttribute("data-group-id");

        var url = base_url + "/" + this.Module_Name + "/select_group/" + contractId + "/" + paymentNo + "/" + groupId;

        $.post($url, {}, function (response) {
            $(".renderGroup").html(response);
        })
    }
</script>
<script>
    function calculaterebarAndSetResult(income, row_number) {
        var totalResult = 0;
        var total = 0; // Toplamı saklamak için bir değişken tanımlayın
        var allEmpty = true; // Tüm q, w, h, l değerleri boş mu?

        for (var i = 1; i <= <?php echo $j + 11; ?>; i++) {
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
                q = isNaN(q) ? 1 : q;
                w = isNaN(w) ? 1 : w;
                h = isNaN(h) ? 1 : h;
                l = isNaN(l) ? 1 : l;

                var m = n.includes(forbiddenWord) ? -1 : 1;

                var result = Math.PI* (q**2)/4 * 7.85 / 1000 * m * w * h * l;
                result = result.toFixed(2);
                document.getElementById('t_' + income + '_' + i).value = result;
                totalResult += parseFloat(result)/1000;
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


