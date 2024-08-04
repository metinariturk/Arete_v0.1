<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$viewFolder}/common/page_style.php"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>

    <style>
        .btn-outline-none {
            background: none;
            border: none;
            padding: 0;
            color: inherit;
        }

        .btn-outline-none:focus {
            outline: none;
            box-shadow: none;
        }
    </style>

</head>
<body onload="startTime()" class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>"> 
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
<?php $this->load->view("includes/file_upload_script.php"); ?>
<?php $this->load->view("{$viewFolder}/common/page_script"); ?>

<?php if (isset($form_error)){ ?>
    <script>
        // Sayfa tamamen yüklendiğinde modalı aç
        $(document).ready(function() {
            $('#exampleModalgetbootstrap').modal('show');
        });
    </script>
<?php } ?>
</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>


