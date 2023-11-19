<script>
    function add_note(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".todo").html(response);
        });
    }

    function todoCheck(btn) {
        var $url = btn.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".todo").html(response);
        })

    }
</script>
