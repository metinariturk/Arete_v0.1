<!-- latest jquery-->
<script src="<?php echo base_url("assets"); ?>/js/config.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/jquery-3.5.1.min.js"></script><!--Jquery-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<!-- Bootstrap js-->

<script src="<?php echo base_url("assets"); ?>/js/bootstrap/bootstrap.bundle.min.js"></script><!--Bootsrap Tema-->
<script src="<?php echo base_url("assets"); ?>/js/notify/bootstrap-notify.min.js"></script><!--Bootstrap Notlar-->
<!-- feather icon js-->
<script src="<?php echo base_url("assets"); ?>/js/icons/feather-icon/feather.min.js"></script><!--Icon Pack-->
<script src="<?php echo base_url("assets"); ?>/js/icons/feather-icon/feather-icon.js"></script><!--Icon Pack-->
<script src="https://kit.fontawesome.com/c5e2f40b81.js" crossorigin="anonymous"></script>

<!-- scrollbar js-->
<script src="<?php echo base_url("assets"); ?>/js/scrollbar/simplebar.js"></script><!--Sidebar-->
<script src="<?php echo base_url("assets"); ?>/js/scrollbar/custom.js"></script><!--Sidebar-->
<!-- Sidebar jquery-->

<script src="<?php echo base_url("assets"); ?>/js/sidebar-menu.js"></script><!--Sidebar Dropdown-->
<script src="<?php echo base_url("assets"); ?>/js/dashboard/default.js"></script><!--Ana Sayfa Özel Script-->
<script src="<?php echo base_url("assets"); ?>/js/typeahead/typeahead.bundle.js"></script><!--SearchBar-->
<?php $this->load->view("includes/typeahead"); ?><!--SearchBar-->

<script src="<?php echo base_url("assets"); ?>/js/fileuploader/jquery.fileuploader.js"></script><!--General Page Script -->
<script src="<?php echo base_url("assets"); ?>/js/dropzone/dropzone.js"></script><!--General Page Script -->
<script src="<?php echo base_url("assets"); ?>/js/dropzone/dropzone-script.js"></script><!--General Page Script -->
<script src="<?php echo base_url("assets"); ?>/js/sweet-alert/app.js"></script><!--General Page Script -->
<script src="<?php echo base_url("assets"); ?>/js/sweet-alert/sweetalert.min.js"></script><!--General Page Script -->
<script src="<?php echo base_url("assets"); ?>/js/custom-spec.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/tree/jstree.min.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/tree/tree.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/tooltip-init.js"></script>


<script src="<?php echo base_url("assets"); ?>/js/script.js"></script>

<?php $this->load->view("includes/alert"); ?>

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

