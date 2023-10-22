<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
<form action="<?php echo base_url("payment/export_pdf/$item->id"); ?>" method="post">
    <textarea name="header">
    <table style="width: 100%">
        <tr>
            <td style="width: 30%">
                <img class="img-fluid for-dark d-none" width="200px"
                     src="<?php echo base_url(); ?>/assets/images/logo/logo_dark.png" alt="">
            </td>
            <td colspan="3" style="width: 70%; text-align: center">
                <h4><?php echo contract_name($item->contract_id); ?></h4>
                <h4>
                    <?php if ($target == "calculate") { ?>
                        <strong>METRAJ CETVELİ</strong>
                    <?php } elseif ($target == "green") { ?>
                        <strong>METRAJ İCMALİ</strong>
                    <?php } ?>
                </h4>
                   <p><i><?php echo $item->hakedis_no; ?> No lu Hakediş</i></p>
            </td>
        </tr>
    </table>
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
