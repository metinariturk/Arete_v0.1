<table class="table">
    <tr>
        <td style="width: 20%"><strong>Dosya No</strong></td>
        <td style="width: 10%"><strong>:</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td><strong>Karar Tarih</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat($format = 'd-m-Y', $item->karar_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Başlangıç Tarih</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat($format = 'd-m-Y', $item->baslangic_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Süre Uzatımı Miktar</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->uzatim_miktar ?> Gün</td>
    </tr>
    <tr>
        <td><strong>Bitiş Tarih</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat($format = 'd-m-Y', $item->bitis_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Süre Uzatımı Gerekçe</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->uzatim_turu; ?></td>
    </tr>
    <tr>
        <td><strong>Süre Uzatımı Açıklama</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
</table>


