<script src="<?php echo base_url("assets"); ?>/js/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/scrollbar/simplebar.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/scrollbar/custom.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/sidebar-menu.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/fileuploader/jquery.fileuploader.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/script.js"></script>

<script src="https://kit.fontawesome.com/c5e2f40b81.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Feather Icons -->
<script src="<?php echo base_url("assets"); ?>/js/icons/feather-icon/feather.min.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/icons/feather-icon/feather-icon.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/calendar_script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function changeMode(anchor) {
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
        });
    }
</script>
<script>
    document.addEventListener("click", function(event) {
        var target = event.target;
        if (target.classList.contains("tt-suggestion") && target.classList.contains("tt-selectable")) {
            // Öğenin atası olan formu bulun
            var form = target.closest("form");

            if (form) {
                // Formu submit edin
                form.submit();
            }
        }
    });
</script>



<script>
    function cancelConfirmationModule(button) {
        swal.fire({
            title: 'Emin misiniz?',
            text: "Yaptığınız değişiklik varsa kaydedilmeyecektir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-arrow-circle-o-left fa-lg"></i> Değişiklik Yapmayacağım',
            cancelButtonText: 'Düzenlemeye Devam Et <i class="fa fa-arrow-circle-o-right fa-lg"></i>'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = button.getAttribute('url');
            }
        });
    }
</script>

<script>
    function deleteConfirmationModule(button) {
        swal.fire({
            title: 'Silmek İstediğinize Emin misiniz?',
            text: "Bu işlemi geri alamazsınız!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-trash-o"></i> Evet, SİL!',
            cancelButtonText: 'Hayır, vazgeç'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = button.getAttribute('url');
            }
        });
    }
</script>
