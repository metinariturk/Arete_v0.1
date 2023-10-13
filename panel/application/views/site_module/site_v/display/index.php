<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/photoswipe.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/print_option.css">

    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>


    <style>
        @media print {
            .apexcharts-legend-marker {
                -webkit-print-color-adjust: exact;
            }
        }
        @page {
            size: A3 portrait;
            margin-left: 75px;
            margin-bottom: 60px;
            margin-right: 75px;
            margin-top: 75px;
        }
    </style>

    <?php $this->load->view("includes/head"); ?>
    <!-- Plugins css start-->

    <!-- Plugins css Ends-->
</head>
<body onload="startTime()" class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>"> 
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <?php $this->load->view("includes/navbar_left"); ?>
            <?php $this->load->view("includes/navbar_right"); ?>
        </div>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/title"); ?>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/include_form_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>


</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>





