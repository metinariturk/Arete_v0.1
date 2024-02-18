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
    document.getElementById('contract_id').addEventListener('submit', function(event) {
        event.preventDefault(); // Formun varsayılan submit işlemini engeller

        // Form verilerini işleyebilir veya gönderebilirsiniz
        // Örneğin, form verilerini AJAX ile sunucuya göndermek için:
        var form = document.getElementById('contract_id');
        var formData = new FormData(form);

        // AJAX ile form verilerini sunucuya göndermek için örnek bir XMLHttpRequest isteği
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onreadystatechange = function() {
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
    function save_puantaj(anchor) {

        $.post($url, {}, function (response) {
            $(".personel_list").html(response);
        })
    }
</script>


