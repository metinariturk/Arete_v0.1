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

    function test(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_list").html(response);
        });
    }

    function main(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_list").html(response);
        });
    }

    function show_book(anchor) {

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_list").html(response);
            $(".sortable").sortable();
        })
    }

    function show_sub(anchor) {

        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".refresh_poz").html(response);
            $(".sortable").sortable();
        })
    }

    function show_explain(anchor) {
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            $(".refresh_explain").html(response);
            $(".sortable").sortable();
        });
    }
</script>