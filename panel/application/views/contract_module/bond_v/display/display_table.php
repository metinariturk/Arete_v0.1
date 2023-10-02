<table class="table">

    <tr>
        <td><strong>Sözleşme Tutar</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo money_format(get_from_id("contract", "sozlesme_bedel", $item->contract_id)) . " " . get_currency($item->contract_id); ?></td>
    </tr>
    <tr>
        <td><strong>Teminat Türü</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->teminat_turu; ?></td>
    </tr>
    <?php if (isset($item->teminat_banka)) { ?>
        <tr>
            <td><strong>Teminat Banka</strong></td>
            <td><strong>:</strong></td>
            <td><?php echo $item->teminat_banka; ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td><strong>Teminat Miktar</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo money_format($item->teminat_miktar) . " " . get_currency($item->contract_id); ?></td>
    </tr>


    <?php $this->load->view("{$viewModule}/{$viewFolder}/$subViewFolder/detail"); ?>

    <tr style="padding-bottom: 10px;">
        <td><strong>Başlangıç Tarihi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->teslim_tarihi == null ? null : dateFormat($format = 'd-m-Y', $item->teslim_tarihi); ?></td>
    </tr>
    <tr>
        <td><strong>Geçerlilik Tarihi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->gecerlilik_tarihi == null ? "Süresiz" : dateFormat($format = 'd-m-Y', $item->gecerlilik_tarihi); ?></td>
    </tr>
    <tr>
        <td><strong>Geçerlilik Süre (Gün)</strong></td>
        <td><strong>:</strong></td>
        <td><?php cms_isset($item->teminat_sure, $item->teminat_sure . " Gün", "Süresiz"); ?> </td>
    </tr>
    <tr>
        <td><strong>Teminat Durumu</strong></td>
        <td><strong>:</strong></td>
        <?php if (isset($item->iade_tarihi)) { ?>
            <td>İade Edildi</td>
        <?php } else { ?>
            <td>İade Edilmedi</td>
        <?php } ?>
    </tr>
    <?php if (isset($item->iade_tarihi)) { ?>
    <tr>
        <td><strong>İade Tarihi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->iade_tarihi == null ? null : dateFormat($format = 'd-m-Y', $item->iade_tarihi); ?></td>
    </tr>
        <tr>
            <td><strong>İade Gerekçe</strong></td>
            <td><strong>:</strong></td>
            <td><?php echo $item->iade_aciklama; ?></td>
        </tr>
    <?php } ?>
</table>
