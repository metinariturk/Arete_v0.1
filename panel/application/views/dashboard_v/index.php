<?php $this->load->view("includes/head"); ?>
<?php $this->load->view("{$viewFolder}/common/page_style"); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/todo.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/flatpickr/flatpickr.min.css">
    <style>
     .cizili {
         text-decoration: line-through;
     }

    /* Genel ikon stilleri (başlık menüsündeki tüm Font Awesome ikonları için) */
    /* Bu, temadan gelen width:13px, height:0.5px gibi kısıtlamaları ve mor rengi kaldırır */
    /* ve ikonların genel boyutunu ayarlar. */
    .nav-right .nav-menus .fa,
    .nav-right .nav-menus .fas,
        /* Sidebar toggle ikonu */
    .toggle-sidebar .fas,
    .toggle-sidebar .fa,
        /* Arama formundaki kapatma ikonu */
    .search-full .close-search.fas,
        /* Arama dropdown içindeki ikonlar */
    .dropdown-menu .list-group-item .fas {
        width: auto !important; /* Tema tarafından uygulanan küçük width'i kaldır */
        height: auto !important; /* Tema tarafından uygulanan küçük height'ı kaldır */
        font-size: 1.5em !important; /* Ortak bir başlangıç boyutu, ihtiyaca göre ayarla */
        line-height: 1 !important; /* Dikey hizalama için */
        vertical-align: middle !important; /* Dikey hizalamayı garantilemek için */
        color: #495057 !important; /* Mor rengi geçersiz kılmak için koyu gri (temaya göre ayarlanabilir) */
    }

    /* Arama dropdown menüsü (Genel header arama ikonuna tıklandığında açılan) */
    .header-search-dropdown .dropdown-menu {
        min-width: 300px !important; /* İstediğiniz minimum genişliği belirleyin */
        max-width: 400px !important; /* Maksimum genişliği sınırlayın */
        max-height: 400px !important; /* Yüksekliği sınırlayın */
        overflow-y: auto !important; /* İçerik taşarsa kaydırma çubuğu */
        padding: 10px !important; /* İç boşluk */
        /* Z-index: Diğer elementlerin üzerinde görünmesini sağlamak için */
        z-index: 1050 !important; /* Bootstrap modal'larından daha düşük, ama diğerlerinin üstünde olsun */
        /* Konumlandırma (eğer dropdown doğru yerde açılmazsa kontrol edin) */
        /* position: absolute; top: 100%; left: 0; */ /* Gerekirse bu konumlandırmayı ekleyin */
    }

    /* Arama sonuçları listesi içindeki öğeler */
    #searchResultItems .list-group-item {
        padding: 8px 12px; /* İç boşluk */
        border: none; /* Varsayılan Bootstrap kenarlığını kaldırır */
    }
    #searchResultItems .list-group-item:hover {
        background-color: #f8f9fa; /* Hover efekti */
    }
    /* Arama sonuçlarındaki ikonların boyutu ve rengi */
    #searchResultItems .list-group-item .bookmark-icon .fas {
        font-size: 1.2em !important; /* Arama sonuçları ikon boyutu */
        color: #6c757d !important; /* Arama sonuçları ikon rengi */
    }
    /* Arama sonuçlarındaki başlık (name) metin rengi */
    #searchResultItems .list-group-item .fw-bold {
        color: #333 !important;
    }
    /* Arama sonuçlarındaki kategori metin rengi */
    #searchResultItems .list-group-item .text-muted {
        color: #777 !important;
    }

    /* "Hiç sonuç bulunamadı" mesajı */
    #searchResultItems .list-group-item.no-results-message {
        padding: 10px;
        color: #999;
        text-align: center;
        font-style: italic;
    }
</style>
</head>
<body class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<div class="loader-wrapper">
    <div class="loader-index"><span></span></div>
    <svg>
        <defs></defs>
        <filter id="goo">
            <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
            <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></fecolormatrix>
        </filter>
    </svg>
</div>
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
            <?php $this->load->view("includes/navbar_left"); ?>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">

            <?php $this->load->view("{$viewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("{$viewFolder}/common/page_script"); ?>



</body>
</html>

