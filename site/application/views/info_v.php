
    <?php $this->load->view("includes/head"); ?>
</head>
<body>
<!-- HEADER START -->
<?php $this->load->view("includes/header"); ?>
<!-- HEADER END -->

<!-- CONTENT START -->
<div class="page-content">

    <?php $this->load->view("{$viewFolder}/content"); ?>

    <?php $this->load->view("includes/about_main"); ?>

</div>
<!-- CONTENT END -->

<!-- FOOTER START -->
<?php $this->load->view("includes/footer"); ?>
<!-- FOOTER END -->

<?php $this->load->view("includes/include_script"); ?>


<script>
    function kopyala(elementId) {
        // Kopyalanacak metni seç
        var metin = document.getElementById(elementId).innerText;

        // Kopyala
        navigator.clipboard.writeText(metin).then(function() {
            console.log("Metin kopyalandı: " + metin);

            // Başarı mesajı olarak bir alert göster
            alert(metin + " kopyalandı!");
        }).catch(function(err) {
            console.error("Metin kopyalanırken bir hata oluştu: ", err);
        });
    }
</script>


</body>
</html>