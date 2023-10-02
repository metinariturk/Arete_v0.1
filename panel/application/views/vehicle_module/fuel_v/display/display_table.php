<table class="table">
    <tr>
        <td style="width: 50%"><strong>Araç Plaka</strong></td>
        <td style="width: 5%"><strong>:</strong></td>
        <td style="width: 45%"><a href="<?php echo base_url("vehicle/file_form/$item->vehicle_id")?>">
            <?php echo get_from_any("vehicle","plaka","id","$item->vehicle_id"); ?></a>
        </td>
    </tr>
    <tr>
        <td><strong>İkmal Tarihi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo dateFormat($format = 'd-m-Y', $item->ikmal_tarih); ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>İkmal Anında Çalışma Süresi <?php km_saat($item->km_saat); ?></strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo $item->ikmal_km_saat; ?> <?php km_saat($item->km_saat); ?></td>
    </tr>

    <tr>
        <td><strong>Yakıt </strong></td>
        <td><strong>:</strong></td>
        <td><?php echo fuel($item->fuel_type); ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>İkmal Miktarı</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo $item->ikmal_miktar; ?> Litre</td>
    </tr>
    <tr>
        <td><strong>Birim Fiyat</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->ikmal_bf; ?> TL</td>
    </tr>
    <tr>
        <td><strong>Toplam Tutar (KDV Dahil)</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->ikmal_tutar; ?> TL</td>
    </tr>
    <tr>
        <td><strong>Açıklama</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
</table>


