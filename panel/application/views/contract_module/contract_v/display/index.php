
    <?php $this->load->view("contract_module/contract_v/common/page_style"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>
    <?php $this->load->view("includes/head"); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/custom.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/flatpickr/flatpickr.min.css">
<style>
    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
        max-width: 100%;
        white-space: nowrap;
    }
</style>
</head>
<body class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <?php $this->load->view("includes/navbar_left"); ?>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("contract_module/contract_v/display/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>

<?php $this->load->view("includes/include_datatable"); ?>
<?php $this->load->view("contract_module/contract_v/display/page_script"); ?>
<?php $this->load->view("contract_module/contract_v/display/price_script"); ?>

<div id="updateSuccessAlert" class="update-alert"></div>

</body>
</html>





