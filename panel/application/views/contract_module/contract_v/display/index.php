<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>
    <?php $this->load->view("includes/head"); ?>
    <style>
        .light-square[role="button"]::after {
            content: none !important; /* Aşağı ok işaretini tamamen kaldırır */
        }

        .custom-dropdown-menu {
            background-color: #f8f9fa; /* Menü arka planı */
            border-radius: 4px;       /* Köşelerin yuvarlatılması */
            padding: 5px 0;           /* Dikey boşluk */
            min-width: 200px;         /* Menü genişliği */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); /* Hafif gölge efekti */
        }

        .custom-dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;      /* Simge ve metni hizalama */
            padding: 10px 15px;       /* İç dolgu */
            font-size: 14px;          /* Yazı boyutu */
        }

        .custom-dropdown-menu .dropdown-item i {
            margin-right: 10px;       /* Simge ile metin arasında boşluk */
            color: #6c757d;           /* Simge rengi */
        }

        .custom-dropdown-menu .dropdown-item:hover {
            background-color: #e9ecef; /* Hover sırasında arka plan rengi */
            color: #000;               /* Yazı rengi */
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
<?php $this->load->view("includes/include_form_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>
<?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/page_script"); ?>
<?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/price_script"); ?>
<?php $this->session->set_flashdata("alert", null); ?>
</body>
</html>





