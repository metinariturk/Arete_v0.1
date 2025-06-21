
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("site_module/report_v/common/page_style"); ?>
    <?php $this->load->view("site_module/report_v/common/page_script"); ?>

    <?php $this->load->view("includes/drag_drop_style"); ?>
    <style>
        .card-body {
            position: relative; /* Bu satırı ekleyin (eğer yoksa) */
            padding: 4px; /* veya mevcut padding değeriniz */
        }
        .dropdown {
            position: absolute; /* Ebeveyni .card-body'ye göre konumlanır */
            top: 15px;          /* Kartın üst kenarından 15px aşağı */
            right: 15px;        /* Kartın sağ kenarından 15px içeri */
            left: auto;         /* Sol konumlandırmayı iptal eder */
            z-index: 10;        /* Diğer içeriklerin üzerinde görünmesini sağlar */
        }

        /* Dropdown menüsünün kendisi (menünün sağa açılması için) */
        .dropdown-menu {
            position: absolute; /* Butonun ebeveyni olan .dropdown'a göre konumlanır */
            top: 100%;          /* Butonun hemen altına */
            right: 0;           /* Butonun sağ kenarına hizalanır */
            left: auto;         /* Sol hizalamayı iptal eder */
            z-index: 1000;      /* Diğer elementlerin üzerinde görünmesini sağlar */
        }

        /* Nokta ikonu içeren buton */
        .light-square {
            /* Bu div'in display özelliği önemli olabilir */
            /* Varsayılan olarak block olabilir, bunu inline-block veya flex yapmayı deneyin */
            display: inline-block;
            cursor: pointer;
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
            <?php $this->load->view("site_module/report_v/display/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>


<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/file_upload_script.php"); ?>
<?php $this->load->view("site_module/report_v/display/page_script"); ?>


</body>
</html>



