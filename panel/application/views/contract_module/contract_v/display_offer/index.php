<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>

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
<?php $this->load->view("includes/include_datatable"); ?>

<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>

<script>
    var list = document.getElementById("ollist");
    var itemCount = list.getElementsByTagName("li").length;
    document.getElementById("result").innerHTML = itemCount;
</script>

<?php if (isset($form_errors)) { ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sayfa yüklendiğinde modalı aç
            $("#modal_payment").modal("show");
        });
    </script>
<?php } ?>


</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>





