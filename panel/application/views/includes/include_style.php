<link rel="icon" href="<?php echo base_url("assets"); ?>/images/favicon.png" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo base_url("assets"); ?>/images/favicon.png" type="image/x-icon">

<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="Web Site Adı">
<link rel="apple-touch-icon" href="<?php echo base_url("assets"); ?>/images/favicon.png"
<link rel="shortcut icon" href="<?php echo base_url("assets"); ?>/images/favicon.png" type="image/x-icon">

<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
      rel="stylesheet">
<!--<link rel="stylesheet" type="text/css" href="--><?php //echo base_url("assets"); ?><!--/css/font-awesome.css">-->
<!-- ico-font-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/icofont.css">
<!-- Themify icon-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/themify.css">
<!-- Flag icon-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/flag-icon.css">
<!-- Feather icon-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/feather-icon.css">
<!-- Plugins css start-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/scrollbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/select2.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/dropzone.css">


<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/chartist.css">

<!-- Bootstrap css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet"/>

<!-- App css-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/style.css">
<link id="color" rel="stylesheet" href="<?php echo base_url("assets"); ?>/css/color-1.css" media="screen">

<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/date-picker.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/tree.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/custom.css">


<!-- INNO FILE UPLAOD -->
<link  href="<?php echo base_url("assets"); ?>/fonts/fileuploader/font-fileuploader.css" rel="stylesheet">
<link href="<?php echo base_url("assets"); ?>/css/fileuploader.min.css" media="all" rel="stylesheet">
<link href="<?php echo base_url("assets"); ?>/css/jquery.fileuploader-theme-dragdrop.css" media="all" rel="stylesheet">

<style>
    .tabs {
        display: flex;
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

    }

    .tab-item {
        position: relative;
    }

    .full-link {
        display: block;
        width: 100%;
        height: 100%;
        text-align: center; /* İsteğe bağlı: Metni ortalamak için */
    }

    .full-link:hover {
        cursor: pointer; /* Fare ile üzerine gelince imleç değişir */
    }

    .download_links {
        display: flex;           /* Öğeleri yan yana dizmek için */
        justify-content: flex-end; /* Öğeleri div'in en sağına yerleştir */
        gap: 10px;               /* Öğeler arasında boşluk bırakmak için */
        padding-right: 37px;     /* Sağdan 15px boşluk bırak */
    }

    .download_links a {
        text-decoration: none;   /* Linklerin alt çizgisini kaldırmak için */
    }

    .download_links a:hover i,
    .download_links i:hover {     /* İkonlara fareyle üzerine gelince renk değişimi */
        color: #63a45b;           /* İkon rengini yeşil yapar */
    }

    .download_links i {
        color: #007bff;           /* Normalde ikonların mavi olmasını sağlar */
    }

</style>