<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        function toggleSectionVisibility($cb,$1,$2,$3,$4,$5,$6) {
            var checkbox = document.getElementById($cb);
            var section1 = document.getElementById($1); // Section 1'nin ID'sini belirlemelisiniz
            var section2 = document.getElementById($2); // Section 2'nin ID'sini belirlemelisiniz
            var section3 = document.getElementById($3); // Section 2'nin ID'sini belirlemelisiniz
            var section4 = document.getElementById($4); // Section 2'nin ID'sini belirlemelisiniz
            var section5 = document.getElementById($5); // Section 2'nin ID'sini belirlemelisiniz
            var section6 = document.getElementById($6); // Section 2'nin ID'sini belirlemelisiniz

            if (checkbox.checked) {
                // Checkbox işaretlenmişse, sectionları göster
                section1.style.display = "block";
                section2.style.display = "block";
                section3.style.display = "block";
                section4.style.display = "block";
                section5.style.display = "block";
                section6.style.display = "block";
            } else {
                // Checkbox işaretlenmemişse, sectionları gizle
                section1.style.display = "none";
                section2.style.display = "none";
                section3.style.display = "none";
                section4.style.display = "none";
                section5.style.display = "none";
                section6.style.display = "none";
            }
        }
    </script>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/scrollbar.css">

    <?php $this->load->view("includes/head"); ?>

    <style>


        td {
            height: 15pt;
        }

        td.calculate-row-right {
            text-align: right;
            border: 1px solid #a8b5cf;
        }

        td.total-group-row-right {
            text-align: right;
            border: 1px solid #a8b5cf;
        }

        td.calculate-row-left {
            text-align: left;
            border: 1px solid #a8b5cf;
        }

        td.total-group-row-left {
            text-align: left;
            border: 1px solid #a8b5cf;
        }

        td.calculate-row-center {
            text-align: center;
            border: 1px solid #a8b5cf;
        }

        td.total-group-row-center {
            text-align: center;
            border: 1px solid #a8b5cf;
        }

        td.total-group-header-center {
            background-color: #e7e7e7;
            text-align: center;
            border: 1px solid #a8b5cf;
        }

        td.calculate-header-center {
            background-color: #e7e7e7;
            text-align: center;
            border: 1px solid #a8b5cf;
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





