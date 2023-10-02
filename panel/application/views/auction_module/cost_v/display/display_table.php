<table class="table">
    <tr>
        <td style="width: 25%;"><strong>Dosya No</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td><strong>Yaklaşık Maliyet Ad</strong></td>
        <td><?php echo $item->ym_ad; ?></td>
    </tr>
    <tr>
        <td><strong>Yaklaşık Maliyet Tutar</strong></td>
        <td><?php echo money_format($item->cost); ?> <?php echo get_currency_auc($item->auction_id); ?></td>
    </tr>
    <tr>
        <td><strong>Kapsadığı Pozlar</strong></td>
        <td><?php echo $item->poz_no; ?></td>
    </tr>
    <tr>
        <td><strong>Onay</strong></td>
        <td><?php echo full_name($item->onay); ?></td>
    </tr>
    <tr>
        <td><strong>Açıklama</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
</table>


