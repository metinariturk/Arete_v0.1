<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <?php $this->load->view("includes/include_datatable_css"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button.page-item {
            padding: 2px 5px;  /* Buton içindeki boşlukları küçültün */
            font-size: 0.6em;    /* Yazı boyutunu daha da küçültün */
            margin: 0 1px;       /* Butonlar arasındaki boşluğu azaltın */
            border: 1px solid #007bff; /* Kenar rengi */
            border-radius: 4px;  /* Kenarları yuvarlatın */
            height: auto;        /* Yüksekliği otomatik ayarla */
            min-width: 25px;     /* Butonun minimum genişliğini ayarlayın */
            text-align: center;  /* Yazıyı ortalayın */
            overflow: hidden;    /* Taşmaları gizle */
            white-space: nowrap; /* Tek satıra zorla */
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.page-item a {
            line-height: 1.5; /* Buton içindeki yazının yüksekliğini ayarlayın */
            display: block;    /* Butonların dikey olarak tamamen doldurmasını sağlar */
            width: 100%;       /* Butonun tam genişlikte olmasını sağlar */
            font-size: inherit;/* Ana font boyutunu kullanın */
        }

        /* Aktif sayfa butonunun görünümünü ayarlamak için */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #007bff; /* Seçili sayfa butonunun arka plan rengi */
            color: white;               /* Seçili sayfa butonunun yazı rengi */
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #0056b3; /* Hover rengini ayarlayın */
            color: white;               /* Hover durumundaki yazı rengi */
        }

    </style>
    <!-- Plugins css start-->

    <!-- Plugins css Ends-->
</head>
<body  class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
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
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/file_upload_script.php"); ?>
<?php $this->load->view("includes/include_form_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>
<?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/page_script"); ?>


</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>





