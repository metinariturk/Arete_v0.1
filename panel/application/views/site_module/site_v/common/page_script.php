<script>
    function delete_sign(btn) {
        var $url = btn.getAttribute('url');
        var $div = btn.getAttribute('div');

        swal({
            title: "Tüm isimler silinecek?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.post($url, {}, function (response) {
                        $("." + $div).html(response);
                        $(".sortable").sortable();
                        $(".sortable").on("sortupdate", function (event, ui) {
                            var $data = $(this).sortable("serialize");
                            var $data_url = $(this).data("url");
                            $.post($data_url, {data: $data}, function (response) {
                            })
                        })
                    })
                    swal("Dosya Başarılı Bir Şekilde Silindi", {
                        icon: "success",
                    });
                } else {
                    swal("Dosya Güvende");
                }
            })
    }
</script>
<script>
    $(".sortable").sortable();
    $(".sortable").on("sortupdate", function (event, ui) {
        var $data = $(this).sortable("serialize");
        var $data_url = $(this).data("url");
        $.post($data_url, {data: $data}, function (response) {
        })
    })
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
    function savePuantaj(checkbox) {
        // Checkbox'tan ilgili verileri al
        var workerId = $(checkbox).attr('workerid');
        var date = $(checkbox).attr('date');
        var isChecked = checkbox.checked ? 1 : 0; // CheckBox'ın durumuna göre 1 (checked) veya 0 (unchecked) değeri

        // AJAX isteği gönder
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("$this->Module_Name/update_puantaj/$item->id"); ?>", // Sunucunuzun POST isteğini alacağı adres
            data: {
                workerId: workerId,
                date: date,
                isChecked: isChecked // CheckBox'ın durumu
            },
            success: function (response) {
                // Başarılı yanıt aldığınızda yapılacak işlemler
                $(".puantaj_list").html(response);
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
    function sendFormData() {
        // Seçili ay ve yılı al
        var month = $('#month').val();
        var year = $('#year').val();

        // Bağlantı URL'sini oluştur
        var url = '<?php echo base_url("Site/puantaj_print/$item->id"); ?>/' + month + '/' + year;

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
            url: "<?php echo base_url("$this->Module_Name/update_personel_form/"); ?>", // Sunucunuzun POST isteğini alacağı adres
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
    $(document).ready(function() {
        // Handle form submission for adding stock
        $('#addStockForm').submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#responseMessage').html(response);
                    $('#AddStockModal').modal('hide');
                },
                error: function() {
                    $('#responseMessage').html('Bir hata oluştu. Lütfen tekrar deneyin.');
                }
            });
        });

        // Handle form submission for exiting stock
        $('#exitStockForm').submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#responseMessage').html(response);
                    $('#ExitModal').modal('hide');
                },
                error: function() {
                    $('#responseMessage').html('Bir hata oluştu. Lütfen tekrar deneyin.');
                }
            });
        });

        // Show stock ID in exit modal
        $('#ExitModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var stockId = button.data('id'); // Extract info from data-* attributes
            $('#stock-id-display').text(stockId); // Update the modal's content
            $('#stock_id').val(stockId);
        });

        // Reset form on modal hidden
        $('#AddStockModal').on('hidden.bs.modal', function() {
            $('#addStockForm')[0].reset();
        });

        $('#ExitModal').on('hidden.bs.modal', function() {
            $('#exitStockForm')[0].reset();
        });

        // Initialize datepicker
        $('.datepicker-here').datepicker({
            format: 'dd-mm-yyyy',
            language: 'tr'
        });
    });
</script>