<?php $this->load->view("includes/head"); ?>

<style>
    /* ... Mevcut stil kodları ... */
    .file-list li {
        /* flex özelliklerini düzenleyelim ki butonlar yanyana gelsin */
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap; /* Küçük ekranlarda sarması için */
    }

    .file-list li .file-actions {
        margin-left: auto; /* Sağ tarafa yaslamak için */
        display: flex;
        gap: 10px; /* Butonlar arasında boşluk */
    }

    .delete-file-btn {
        background-color: #dc3545; /* Kırmızı renk */
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85em;
        transition: background-color 0.3s ease;
    }

    .delete-file-btn:hover {
        background-color: #c82333;
    }

    /* Genel eksik veri satır stili */
    tr.missing-data-row {
        background-color: #ffe0e0; /* Açık kırmızı */
    }
    /* Eksik Adet, Çap, Uzunluk inputları için özel stil */
    input.missing-qty, input.missing-r, input.missing-l {
        border: 2px solid #ff0000; /* Kırmızı çerçeve */
        background-color: #fff0f0; /* Açık kırmızı iç renk */
    }

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <?php $this->load->view("includes/navbar_left"); ?>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("template/display/content"); ?>
        </div>
    </div>
    <?php $this->load->view("includes/footer"); ?>
</div>
<?php $this->load->view("includes/include_script"); ?>
</body>
</html>



