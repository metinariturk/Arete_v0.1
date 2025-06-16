<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>

    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="<?php echo base_url("assets"); ?>/file_uploader_dist/font/font-fileuploader.css" rel="stylesheet">
    <link href="<?php echo base_url("assets"); ?>/file_uploader_dist/jquery.fileuploader.min.css" media="all" rel="stylesheet">
    <link href="<?php echo base_url("assets"); ?>/css/fileuploader-theme-avatar.css" media="all" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/flatpickr/flatpickr.min.css">

    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/avatar_custom"); ?>
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
</body>
</html>



