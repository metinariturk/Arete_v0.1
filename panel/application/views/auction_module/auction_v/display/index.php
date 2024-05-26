<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/scrollbar.css">

    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <style>
        /* input */
        .fileuploader-theme-dragdrop .fileuploader-input {
            display: block;
            padding: 60px 0;
            background: #fff;
            border: 2px dashed #c2cdda;
            border-radius: 14px;
            text-align: center;
        }

        .fileuploader-theme-dragdrop .fileuploader-input .fileuploader-icon-main {
            display: block;
            font-size: 56px;
            margin: 0 auto;
            margin-bottom: 26px;
        }
        .fileuploader-theme-dragdrop .fileuploader-input h3 {
            margin: 0;
            margin-bottom: 8px;
            padding: 0;
            background: none;
            border: none;
            border-radius: 0;
            font-size: 18px;
            font-weight: bold;
            color: #5B5B7B;
            white-space: normal;
            box-shadow: none;
        }
        .fileuploader-theme-dragdrop .fileuploader-input p {
            margin: 0;
            padding: 0;
            color: #90a0bc;
            margin-bottom: 12px;
        }

        /* dragging state */
        .fileuploader-theme-dragdrop .fileuploader-input .fileuploader-input-inner > * {
            -webkit-transition: 500ms cubic-bezier(0.17, 0.67, 0, 1.01);
            transition: 500ms cubic-bezier(0.17, 0.67, 0, 1.01);
        }
        .fileuploader-theme-dragdrop .fileuploader-input.fileuploader-dragging .fileuploader-input-inner > * {
            transform: translateY(18px);
            opacity: 0;
        }
        .fileuploader-theme-dragdrop .fileuploader-input.fileuploader-dragging .fileuploader-icon-main {
            transform: translateY(30px) scale(1.2);
            opacity: 0.6;
        }
        .fileuploader-theme-dragdrop .fileuploader-input.fileuploader-dragging .fileuploader-input-caption {
            transform: translateY(30px);
            opacity: 0.6;
        }
    </style>

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
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>

</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>




