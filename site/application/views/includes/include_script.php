<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery should be included first -->

<script src="<?php echo base_url("assets"); ?>/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="<?php echo base_url("assets"); ?>/js/custom.js"></script><!-- CUSTOM FUCTIONS  -->

<!-- SWITCHER FUCTIONS  -->
<!-- REVOLUTION JS FILES -->

<script  src="<?php echo base_url("assets"); ?>/plugins/revolution/revolution/js/jquery.themepunch.tools.min.js"></script>
<script  src="<?php echo base_url("assets"); ?>/plugins/revolution/revolution/js/jquery.themepunch.revolution.min.js"></script>

<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
<script  src="<?php echo base_url("assets"); ?>/plugins/revolution/revolution/js/extensions/revolution-plugin.js"></script>

<!-- REVOLUTION SLIDER SCRIPT FILES -->
<script  src="<?php echo base_url("assets"); ?>/js/rev-script-1.js"></script>

<script>
    function openGoogleMaps() {
        // Hedeflenen konumun koordinatlarını belirleyin (örneğin, Eiffel Kulesi)
        var latitude = 37.96277293286287;
        var longitude = 32.47521395803679;

        // Google Haritalar'ı açmak ve belirtilen konuma gitmek için URL oluşturun
        var url = "https://www.google.com/maps?q=" + latitude + "," + longitude;

        // Yeni bir pencerede Google Haritalar'ı açın
        window.open(url);
    }
</script>

