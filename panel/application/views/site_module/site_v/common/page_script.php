



<script>

    function showrow(row) {
        var outcomeId = "outcome-" + row.id;
        var outcomeRows = document.querySelectorAll("#" + outcomeId);

        for (var i = 0; i < outcomeRows.length; i++) {
            var outcomeRow = outcomeRows[i];
            if (outcomeRow.style.display === "none") {
                outcomeRow.style.display = "";
            } else {
                outcomeRow.style.display = "none";
            }
        }
    }

    function showrow_over(row) {
        var outcomeId = "over-" + row.id;
        var outcomeRows = document.querySelectorAll("#" + outcomeId);

        for (var i = 0; i < outcomeRows.length; i++) {
            var outcomeRow = outcomeRows[i];
            if (outcomeRow.style.display === "none") {
                outcomeRow.style.display = "";
            } else {
                outcomeRow.style.display = "none";
            }
        }
    }
</script>

<script>
    document.getElementById('contract_id').addEventListener('submit', function (event) {
        event.preventDefault(); // Formun varsayılan submit işlemini engeller

        // Form verilerini işleyebilir veya gönderebilirsiniz
        // Örneğin, form verilerini AJAX ile sunucuya göndermek için:
        var form = document.getElementById('contract_id');
        var formData = new FormData(form);

        // AJAX ile form verilerini sunucuya göndermek için örnek bir XMLHttpRequest isteği
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // İstek başarılı olduğunda yapılacak işlemler
                console.log('Form gönderildi!');

                // Modalı kapatmak için:
                var modal = document.getElementById('exampleModalmdo');
                var modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();
            }
        };
        xhr.send(formData);
    });


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
    function sendPersonelData(anchor) {

        var is_active = anchor.getAttribute('isActive');

        var url = '<?php echo base_url("Site/personel_print/$item->id"); ?>/' + is_active;

        // AJAX isteğini gönder
        $.ajax({
            url: url,
            type: 'POST',
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

<script>
    function updatePersonelForm(checkbox) {
        // Checkbox'tan ilgili verileri al
        var workerId = $(checkbox).attr('workerid');

        // AJAX isteği gönder
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Site/update_personel_form/"); ?>", // Sunucunuzun POST isteğini alacağı adres
            data: {
                workerId: workerId,
            },
            success: function (response) {
                // Başarılı yanıt aldığınızda yapılacak işlemler
                $(".personel_update_form").html(response);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>

<script>
    function updatePersonel(anchor) {
        var formId = $(anchor).attr('form_id');
        var form = $('#' + formId);
        var formData = new FormData(form[0]);
        var url = anchor.getAttribute('url');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $(".personel_list").html(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>

<script>
    // Tarih sıralama eklentisini tanımlama
    $.fn.dataTable.ext.order['date-uk-reverse'] = function (data) {
        return new Date(data).getTime(); // Negatif işareti ile büyükten küçüğe sıralama
    };

    $(document).ready(function() {
        var table = $('#report_table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/2.1.6/i18n/tr.json"
            },
            "columnDefs": [
                {
                    "targets": 0, // Tarih sütununun indeksini buraya yazın
                    "type": "date-uk"
                }
            ],
            "order": [[0, 'desc']] // İlk sütunu büyükten küçüğe sıralama
        });
    });
</script>

<script>
    function savePersonel(btn) {
        var formId = "personel_form"; // doğru form ID'si olduğundan emin olun
        var formData = new FormData(document.getElementById(formId));

        var url = document.getElementById(formId).getAttribute('action');

        // Send an AJAX POST request
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Assuming the response contains the updated content
                $(".personel_list").html(response);

                // Clear input fields after successful submission
                document.getElementById(formId).reset();
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>


