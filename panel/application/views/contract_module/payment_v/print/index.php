<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        @page {
            size: A4;
            counter-increment: page;
            content: "Sayfa " counter(page);
            margin-bottom: 50px; /* 50px alt boşluk */
        }

        @media print {
            .page-break-button {
                display: none;
            }
        }

        /* Sayfanın altındaki "imza" div'i için CSS */
        #imza {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white; /* Arka plan rengini sayfanın rengine ayarlayabilirsiniz */
            display: block;
            height: 10%; /* Sayfanın %20'si */
            width: 100%; /* Sayfanın tam genişliği */
            margin-top: 0;
        }

        /* "content" elementi için CSS */
        .content {
            height: 10%; /* Sayfanın %80'i */
            width: 100%; /* Sayfanın tam genişliği */
        }
    </style>
</head>
<body>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
<script>
    function togglePageBreak(button) {
        var table = button.nextElementSibling;

        if (table.style.pageBreakBefore === "always") {
            // Sayfayı bölmeyi iptal et
            button.innerHTML = "Sayfayı Böl";
            table.style.pageBreakBefore = "auto";
        } else {
            // Sayfayı bölebilir hale getir
            button.innerHTML = "Bölündü";
            table.style.pageBreakBefore = "always";
        }
    }
</script>
<div id="imza">

</div>

</body>
</html>
