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
    $(document).ready(function () {
        $('#report_table').DataTable({
            "initComplete": function (settings, json) {
                // Sıra numaralarını güncelle
                $('#report_table').DataTable().column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }
        });
    });
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
    // Get the input element and table
    var input1 = document.getElementById('searchInput');
    var table1 = document.getElementById('myTable');

    // Add event listener to the input element
    input1.addEventListener('keyup', function () {
        var filter = input1.value.toLowerCase();
        var rows = table1.getElementsByTagName('tr');

        // Loop through all table rows, hide those that don't match the search query
        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var found = false;

            for (var j = 0; j < cells.length; j++) {
                var cellValue = cells[j].textContent || cells[j].innerText;

                if (cellValue.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }

            rows[i].style.display = found ? '' : 'none';
        }
    });
</script>

<script>
    // Get the input element and table
    var input = document.getElementById('searchInput_over');
    var table = document.getElementById('myTable_over');

    // Add event listener to the input element
    input.addEventListener('keyup', function () {
        var filter = input.value.toLowerCase();
        var rows = table.getElementsByTagName('tr');

        // Loop through all table rows, hide those that don't match the search query
        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var found = false;

            for (var j = 0; j < cells.length; j++) {
                var cellValue = cells[j].textContent || cells[j].innerText;

                if (cellValue.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }

            rows[i].style.display = found ? '' : 'none';
        }
    });
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
    function ExpenseToExcel(type, fn, dl) {
        var elt = document.getElementById('basic-1');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "sheet1", strip: false});

        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->santiye_ad; ?> Harcamalar.' + (type || 'xlsx')));
    }
</script>
<script>
    function deleteExpenseFile(btn) {
        var $url = btn.getAttribute('url');
        var table = $('#export-expense').DataTable();
        var row = table.row(btn.closest('tr')); // Silinecek satırı al

        swal({
            title: "Dosyayı Silmek İstediğine Emin Misin?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.post($url, {}, function () {
                    row.remove().draw(false); // Satırı tamamen kaldır
                });

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });
            } else {
                swal("Dosya Güvende");
            }
        });
    }
</script>

<script>
    function deleteDepositeFile(btn) {
        var $url = btn.getAttribute('url');
        var table = $('#export-deposit').DataTable();
        var row = table.row(btn.closest('tr')); // Silinecek satırı al

        swal({
            title: "Dosyayı Silmek İstediğine Emin Misin?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.post($url, {}, function () {
                    row.remove().draw(false); // Satırı tamamen kaldır
                });

                swal("Dosya Başarılı Bir Şekilde Silindi", {
                    icon: "success",
                });
            } else {
                swal("Dosya Güvende");
            }
        });
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
    function add_stock(anchor) {
        // Formun ID'sini almak
        var formId = $(anchor).attr('form_id');
        var form = $('#' + formId);
        var formData = new FormData(form[0]);
        var url = anchor.getAttribute('url');

        // AJAX isteğini başlatma
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,  // Cache'i engelle
            success: function (response) {
                console.log(response);
                $('#stock-list').html(response); // Tablonun doğru şekilde güncellenmesini sağlar
                $('#addStockModal').modal('hide'); // Modal'ı kapat
                $('.modal-backdrop').remove(); // Fade katmanını temizle
                form[0].reset(); // Formu temizle
            },
            error: function (xhr, status, error) {
                console.error('Bir hata oluştu: ' + xhr.responseText);
            }
        });

        // AJAX isteği yapılırken modal'ın kapalı kalması için return false
        return false;
    }
</script>

<script>
    document.querySelectorAll('.exit-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            var stockId = this.getAttribute('data-id');
            var stockName = this.getAttribute('data-stock_name');
            var unit = this.getAttribute('data-unit');
            var stockIn = this.getAttribute('data-stock_in');

            // Modal HTML yapısını oluştur
            var modalHtml = `
                <div class="modal fade" id="stockExitModal" tabindex="-1" aria-labelledby="stockExitModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="stockExitModalLabel">Malzeme Çıkış Yap</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Malzeme Adı:</strong> ${stockName}</p>
                                <p><strong>Birim:</strong> ${unit}</p>
                                <p><strong>Giriş Miktarı:</strong> ${stockIn}</p>
                                <div class="mb-3">
                                    <label for="exit-quantity" class="form-label">Çıkış Miktarı</label>
                                    <input type="number" class="form-control" id="exit-quantity" name="stock_out" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exit-date" class="form-label">Çıkış Tarihi</label>
                                    <input type="date" class="form-control" id="exit-date" name="exit_date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Açıklama</label>
                                    <textarea class="form-control" id="notes" name="notes"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                <button type="button" class="btn btn-primary save-exit" data-id="${stockId}">Gönder</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Modal HTML yapısını sayfaya ekle
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Modalı göster
            var modal = new bootstrap.Modal(document.getElementById('stockExitModal'));
            modal.show();

            // Modal kapandığında yapıyı temizle
            modal._element.addEventListener('hidden.bs.modal', function () {
                document.getElementById('stockExitModal').remove();
            });

            // Gönder butonuna tıklama işlemi
            document.querySelector('.save-exit').addEventListener('click', function () {
                var stockId = this.getAttribute('data-id');
                var stockOut = document.getElementById('exit-quantity').value;
                var exitDate = document.getElementById('exit-date').value;
                var notes = document.getElementById('notes').value;

                // AJAX isteği ile verileri gönder
                $.ajax({
                    url: `<?php echo base_url("Site/stock_exit/"); ?>${stockId}`,
                    type: 'POST',
                    data: {
                        stock_out: stockOut,
                        exit_date: exitDate,
                        notes: notes
                    },
                    success: function (response) {
                        modal.hide();
                        // Tabloyu AJAX ile yenile
                        $('#stock-list').html(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    });
</script>