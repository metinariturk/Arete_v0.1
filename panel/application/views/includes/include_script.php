<script src="<?php echo base_url("assets"); ?>/js/jquery-3.5.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="https://kit.fontawesome.com/c5e2f40b81.js" crossorigin="anonymous"></script>


<script src="<?php echo base_url("assets"); ?>/js/scrollbar/simplebar.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/scrollbar/custom.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/fileuploader/jquery.fileuploader.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/select2/select2.full.min.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/select2/select2-custom.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/bootstrap-tagsinput.min.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/flat-pickr/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="<?php echo base_url("assets"); ?>/js/sidebar-menu.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/script.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/tooltip-init.js"></script>


<script>
    function changeMode(anchor) {
        var $url = anchor.getAttribute('url');
        // jQuery'nin hazır olduğundan emin olmak için $().ready() içine alabilirsiniz,
        // ancak buradaki gibi kullanmak da genellikle sorun çıkarmaz
        // çünkü jQuery zaten yukarılarda yüklenmiş oluyor.
        $.post($url, {}, function (response) {
            // Yanıt işleme kodunuz
        });
    }
</script>