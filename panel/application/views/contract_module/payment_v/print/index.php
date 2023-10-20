<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        @page {
            size: A4;
            counter-increment: page;
            content: "Sayfa " counter(page);
            margin-top: 100px; /* 100px üst boşluk */
            margin-bottom: 100px; /* 100px alt boşluk */
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
            margin-top: 0;
        }

        .A4_page {
            width: 100%; /* Ekran genişliğine otomatik ayarlama */
            max-width: 21cm; /* A4 sayfa genişliği */
            margin: 0 auto; /* Ortala */
        }


    </style>

</head>
<body>
<div class="A4_page">
    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
</div>
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
    <table style="width: 100%">
        <thead>
        <tr>
            <th style="border-style:solid; text-align:center; border-width:0.75pt;" >YÜKLENİCİ</th>
            <th  style="border-style:solid; text-align:center; border-width:0.75pt;" colspan="3">TAŞERON</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="border-style:solid; text-align:center; border-width:0.75pt;">
                Proje Yöneticisi<br>
                Selim BATTIR
            </td>
            <td style="border-style:solid; text-align:center; border-width:0.75pt;">
                İnşaat Mühendisi<br>
                Bekir Metin ARITÜRK
            </td>
        </tr>
        </tbody>
    </table>
</div>

</body>
</html>
