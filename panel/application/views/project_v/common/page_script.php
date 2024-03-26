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
    $(document).ready(function() {
        $('#example tbody').on('click', 'tr.parent', function () {
            var parentId = $(this).data('parent');
            $('.parent-' + parentId).toggle();
        });
    });
</script>