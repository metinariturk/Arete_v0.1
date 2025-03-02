<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$viewFolder}/common/page_style.php"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/custom.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/flatpickr/flatpickr.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <!-- Choices.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <style>
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            max-width: 100%;
            white-space: nowrap;
        }
    </style>

</head>
<body  class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>"> 
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
            <?php $this->load->view("{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/include_form_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>
<?php $this->load->view("{$viewFolder}/{$subViewFolder}/page_script"); ?>
<script src="<?php echo base_url("assets"); ?>/js/flat-pickr/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>

</body>
</html>



