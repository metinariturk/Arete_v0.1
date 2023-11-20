<table class="table">
    <tr>
        <td><strong>Dosya No</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Sözleşme Tutar</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo money_format(get_from_id("contract","sozlesme_bedel",get_from_id("collection", "contract_id",$item->id)))." ".get_currency(get_from_id("collection", "contract_id",$item->id)); ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Tahsilat Tarihi</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo dateFormat_dmy($item->tahsilat_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Tahsilat Miktar</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo money_format($item->tahsilat_miktar) . " " . get_currency($item->contract_id); ?></td>
    </tr>
    <tr>
        <td><strong>Ödeme Türü</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->tahsilat_turu; ?></td>
    </tr>
    <tr>
        <td><strong>Vade</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat_dmy($item->vade_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Tahsilat Açıklama</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
</table>


