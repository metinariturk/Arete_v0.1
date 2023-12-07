<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$this->moduleFolder}/{$this->viewFolder}/common/page_style"); ?>
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
            <?php $this->load->view("{$this->moduleFolder}/{$this->viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/include_form_script"); ?>
<?php $this->load->view("includes/calendar_script"); ?>
<?php $this->load->view("{$this->moduleFolder}/{$this->viewFolder}/common/page_script"); ?>


</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>


