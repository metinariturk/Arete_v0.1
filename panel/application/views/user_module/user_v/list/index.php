<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url("assets"); ?>/css/vendors/flatpickr/flatpickr.min.css">

</head>
<body class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <?php $this->load->view("includes/navbar_left"); ?>
        </div>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>
<script src="<?php echo base_url("assets"); ?>/js/flat-pickr/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>

<script>
    $(document).ready(function () {
        $("#phone").inputmask("(599) 999 99 99", {
            placeholder: "_",
            showMaskOnHover: false
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Kullanıcı adı için input maskesi
        $("#username").inputmask({
            regex: "^[a-zA-Z0-9_]{3,15}$", // En az 3, en fazla 15 karakter, harf, rakam ve alt çizgi
            placeholder: "_"
        });
    });
</script>
<script>
    $(document).ready(function(){
        $("#IBAN").inputmask("TR 99 9999 9999 9999 9999 9999 99");  // IBAN formatı
    });
</script>
</body>
</html>



