<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("site_module/site_v/common/page_style"); ?>
    <?php $this->load->view("includes/include_datatable_css"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>

    <!-- Plugins css start-->

    <!-- Plugins css Ends-->
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
            <?php $this->load->view("site_module/site_v/display/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/file_upload_script.php"); ?>
<?php $this->load->view("includes/include_form_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>
<?php $this->load->view("site_module/site_v/display/page_script"); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</body>
</html>






