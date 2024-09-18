<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>

    <?php $this->load->view("includes/head"); ?>
    <style>
        .tabs {
            display: flex;
            border-bottom: 2px solid #ccc;
        }

        .tab-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex: 1;
            border-radius: 15px 15px 0 0; /* Üst köşeleri pahlı yapmak için */
            text-align: center;
            border-bottom: none;
            padding: 10px;
        }

        .tab-item a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        .tab-item:not(:last-child) {
            margin-right: -1px; /* Sekmeleri birbirine değdirmek için */
        }

        .tab-item:hover {
            background-color: #e9ecef;
        }

        .custom-card {
            border-radius: 0 0 15px 15px; /* Üst köşeleri pahlı yapmak için */
            border: 1px solid #dcdcdc; /* İncecik ve çok açık gri çerçeve */
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .custom-card-header {
            font-size: 0.8rem; /* Başlık boyutu */
            font-weight: bold;
            border-radius: 15px 15px 0 0; /* Üst köşeleri pahlı yapmak için */
            background-color: #f8f9fa; /* Başlık arka plan rengi */
            padding: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .custom-card-body {
            padding: 1rem;
            border: 1px solid #dcdcdc; /* İncecik ve çok açık gri çerçeve */

        }


    </style>
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
            <?php $this->load->view("{$viewModule}/{$viewFolder}/display/content"); ?>
        </div>
    </div>
</div>
<?php $this->load->view("includes/footer"); ?>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>

<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>


</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>





