<!DOCTYPE html>
<html lang="en">
<head>

    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/photoswipe.css">
    <style>
        /* Sayfa stilini tanımlayın */
        @page {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000;
        }

        /* İçerik stilini tanımlayın */
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }

        /* Sayfa içeriğini tanımlayın */
        .content {
            /* İçerik stilinizi burada belirleyin */
        }

        /* Alt bilgiyi içeriğe eklemek için 'after' seçicisini kullanın */
        .content:after {
            content: "Alt Bilgi Metni";
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10pt;
        }

        /* Belirli bir div'i sayfa içeriğine eklemek için 'content' sınıfını hedefleyin */
        .content .special-div {
            /* Belirli div'in stilini burada belirleyin */
            font-weight: bold;
            color: #FF0000;
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
<script>
    document.getElementById("printButton").addEventListener("click", function() {
        window.print();
    });

</script>

<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>


</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>





