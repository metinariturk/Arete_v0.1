<?php $this->load->view("includes/head"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/flatpickr/flatpickr.min.css">
<?php $this->load->view("site_module/report_v/add/page_style"); ?>
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
            <?php $this->load->view("site_module/report_v/add/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/include_form_script"); ?>
<script src="<?php echo base_url("assets"); ?>/js/jquery.repeater.js"></script><!--Form Inputs-->
<script src="<?php echo base_url("assets"); ?>/js/flat-pickr/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
<?php $this->load->view("site_module/report_v/add/page_script"); ?>

</body>
</html>
