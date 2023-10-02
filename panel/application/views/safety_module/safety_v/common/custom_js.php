<script>
    function asd(btn) {
        var $data_url = $(this).data("url");
        var url = btn.getAttribute('data-url');
        var text = btn.getAttribute('data-text');
        var note = btn.getAttribute('data-note');

        swal({
            title: text + ' Sayfasına Yönlendiriliyorsunuz',
            text: note,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Devam',
            cancelButtonText: "İptal"
        }).then(function (result) {
            if (result.value) {

                window.location.href = url;
            }
        });
    }
</script>