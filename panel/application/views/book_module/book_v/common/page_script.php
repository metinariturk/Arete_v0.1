<script>
    function delete_sub(anchor) {
        var $url = anchor.getAttribute('url');
        var $text = anchor.getAttribute('text');

        swal({
            title: $text + " Silmek İstediğine Emin Misin?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    $.post($url, {}, function (response) {
                        $(".refresh_list").html(response);
                    })

                    swal("Dosya Başarılı Bir Şekilde Silindi", {
                        icon: "success",
                    });

                } else {
                    swal("Dosya Güvende");
                }
            })
    }

    function main(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_list").html(response);
            $('#book').DataTable();
            $('#list').DataTable();
            $('#poz').DataTable();
            $(".sortable").sortable({
                stop: function (event, ui) {
                    var $data = $(this).sortable("serialize");
                    var $data_url = $(this).data("url");
                    $.post($data_url, {data: $data}, function (response) {
                    })
                }
            });
        });
    }

    function show_book(anchor) {

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_list").html(response);
            $('#book').DataTable();
            $('#list').DataTable();
            $('#poz').DataTable();

            $(".sortable").sortable({
                stop: function (event, ui) {
                    var $data = $(this).sortable("serialize");
                    var $data_url = $(this).data("url");
                    $.post($data_url, {data: $data}, function (response) {
                    })
                }
            });
        })
    }

    function show_sub(anchor) {

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_poz").html(response);
            $('#book').DataTable();
            $('#list').DataTable();
            $('#poz').DataTable();

            $(".sortable").sortable({
                stop: function (event, ui) {
                    var $data = $(this).sortable("serialize");
                    var $data_url = $(this).data("url");

                    $.post($data_url, {data: $data}, function (response) {
                    })
                }
            });
        })
    }

    function add_group(anchor) {

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".add_group").html(response);

            $(".sortable").sortable({
                stop: function (event, ui) {
                    var $data = $(this).sortable("serialize");
                    var $data_url = $(this).data("url");

                    $.post($data_url, {data: $data}, function (response) {
                    })
                }
            });
        })
    }

    function show_explain(anchor) {
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            $(".refresh_explain").html(response);
            $('#book').DataTable();
            $('#list').DataTable();
            $('#poz').DataTable();
            $(".sortable").sortable({
                stop: function (event, ui) {
                    var $data = $(this).sortable("serialize");
                    var $data_url = $(this).data("url");
                    $.post($data_url, {data: $data}, function (response) {
                    })
                }
            });
        });
    }


</script>
<script>
    $(document).ready(function() {
        $("#saveButton").click(function() {
            // Form verilerini al
            var bookName = $("input[name='book_name']").val();
            var year = $("input[name='year']").val();

            // Burada form verilerini işleyebilirsiniz, örneğin bir AJAX isteği gönderilir.


            // Formun temizlenmesi
            $("input[name='book_name']").val('');
            $("input[name='year']").val('');

            // Modal penceresinin kapanmamasını sağla
            return false; // Formun sayfayı yenilememesi ve modalın kapanmaması için kullanılır
        });
    });
</script>
<script>
    $('#book').DataTable();
    $('#list').DataTable();
    $('#poz').DataTable();
    $(".sortable").sortable({
        stop: function (event, ui) {
            var $data = $(this).sortable("serialize");
            var $data_url = $(this).data("url");
            $.post($data_url, {data: $data}, function (response) {
            })
        }
    });
</script>