<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/photoswipe.css">

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

<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>

<script>
    function openList1() {
        var list = document.getElementById("ollist");

        if (list.style.display == "none"){
            list.style.display = "block";
        }else{
            list.style.display = "none";
        }
    }
</script>
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





