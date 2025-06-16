<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$viewFolder}/common/page_style"); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/todo.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/flatpickr/flatpickr.min.css">
</head>
<body  class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<div class="loader-wrapper">
    <div class="loader-index"><span></span></div>
    <svg>
        <defs></defs>
        <filter id="goo">
            <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
            <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></fecolormatrix>
        </filter>
    </svg>
</div>
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <?php $this->load->view("includes/navbar_left"); ?>
        </div>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">

            <?php $this->load->view("{$viewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("{$viewFolder}/common/page_script"); ?>
<?php $this->load->view("includes/include_form_script"); ?>

<script src="<?php echo base_url("assets"); ?>/js/flat-pickr/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>

</body>
</html>

