<!DOCTYPE html>
<html lang="en">
<head>

    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/scrollbar.css">

    <?php $this->load->view("includes/head"); ?>

    <style>
        table, tr, td, th {
            border: 0.75pt solid black;
            font-size: 9pt;
        }

        td {
            height: 15pt;
        }

        td.calculate-row-right {
            text-align: right;

        }

        td.total-group-row-right {
            text-align: right;
        }

        td.calculate-row-left {
            text-align: left;
        }

        td.total-group-row-left {
            text-align: left;
        }

        td.calculate-row-center {
            text-align: center;
        }

        td.total-group-row-center {
            text-align: center;
        }

        td.total-group-header-center {
            background-color: #e7e7e7;
            text-align: center;
        }

        td.calculate-header-center {
            background-color: #e7e7e7;
            text-align: center;
        }
    </style>
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
<?php $this->load->view("{$viewModule}/{$viewFolder}/common/scenario1.php"); ?>
<script>
    const columns = document.querySelectorAll('td[class^="w-"]');

    // Her bir sütunu dolaşın ve genişliklerini ayarlayın
    columns.forEach((column) => {
        const className = column.classList[0]; // Sınıf adını alın, örneğin "w-3"
        const width = parseInt(className.split('-')[1]); // "w-3" sınıfından 3 rakamını alın
        column.style.width = width + '%'; // Genişliği ayarlayın
    });
</script>
</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>





