<table class="table">
    <tr>
        <td style="width: 25%;"><strong>Dosya No</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td><strong>Teklif No</strong></td>
        <td><?php echo $item->offer_no; ?></td>
    </tr>
    <tr>
        <td><strong>Teklif Tarih</strong></td>
        <td><?php echo dateFormat_dmy($item->offer_date); ?></td>
    </tr>
    <tr>
        <td><strong>Teklif Tutar</strong></td>
        <td><?php echo money_format($item->offer_price); ?> <?php echo get_currency_auc($item->auction_id); ?></td>
    </tr>
    <tr>
        <td><strong>Açıklama</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
    <tr>
        <td><strong>Yüklendiği Tarih</strong></td>
        <td><?php echo dateFormat_dmy_hi($item->createdAt); ?></td>
    </tr>
</table>


