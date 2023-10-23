<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
<form action="<?php echo base_url("payment/export_pdf/$item->id"); ?>" method="post">
    <textarea name="header">
        <p style="text-align: center;"><?php echo contract_name($item->contract_id); ?></p>
    </textarea>
    <textarea name="body">
            <?php if ($target == "calculate") { ?>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/calculate"); ?>
            <?php } elseif ($target == "green") { ?>
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/green"); ?>
            <?php } ?>
    </textarea>
    <textarea name="sign">
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
        </textarea>
    <input type="submit" value="Sayfayı Kaydet">
</form>
</body>
</html>
