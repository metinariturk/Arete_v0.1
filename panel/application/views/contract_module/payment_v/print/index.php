<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        @page {
            size: A4;
            counter-increment: page;
            content: "Sayfa " counter(page);
            margin-top: 100px; /* 100px üst boşluk */
        }

        @media print {
            .page-break-button {
                display: none;
            }

            /* Sayfanın altındaki "imza" div'i için CSS */
            #imza {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: white;
                display: block;
                margin-bottom: 0px;
            }

            #tablo {
                background-color: white;
                display: block;
                margin-bottom: 0; /* Tablonun alt boşluğunu sıfıra ayarla */
            }
        }

        .A4_page {
            width: 100%; /* Ekran genişliğine otomatik ayarlama */
            max-width: 21cm; /* A4 sayfa genişliği */
            margin: 0 auto; /* Ortala */
        }

    </style>
</head>
<body>
<div class="A4_page" id="tablo">
    <?php if ($target == "calculate") { ?>
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/calculate"); ?>
    <?php } elseif ($target == "green") { ?>
        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/green"); ?>
    <?php }  ?>
</div>
<div id="imza">
    <table style="width: 100%">
        <thead>
        <tr>
            <th style="border-style:solid; text-align:center; border-width:0.75pt;">YÜKLENİCİ</th>
            <th style="border-style:solid; text-align:center; border-width:0.75pt;" colspan="3">TAŞERON</th>
        </tr>
        </thead>
        <tbody>
        <tr style="height: 2cm;">
            <td style="border-style:solid; text-align:center; border-width:0.75pt;">
            </td>
            <td style="border-style:solid; text-align:center; border-width:0.75pt;">
            </td>
        </tr>
        <tr style="height: 2cm;">
            <td style="border-style:solid; text-align:center; border-width:0.75pt;">
                Proje Yöneticisi<br>
                Selim BATTIR
            </td>
            <td style="border-style:solid; text-align:center; border-width:0.75pt;">
                İnşaat Mühendisi<br>
                Bekir Metin ARITÜRK
            </td>
        </tr>
        <tr style="height: 2cm;">
            <td style="border-style:solid; text-align:center; border-width:0.75pt;">
            </td>
            <td style="border-style:solid; text-align:center; border-width:0.75pt;">
            </td>
        </tr>
        <tr style="height: 2cm;">
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

</body>
</html>
