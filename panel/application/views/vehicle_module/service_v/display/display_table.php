<table class="table">
    <tr>
        <td style="width: 150px"><strong>Araç Plaka</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><a href="<?php echo base_url("vehicle/file_form/$item->vehicle_id")?>">
            <?php echo get_from_any("vehicle","plaka","id","$item->vehicle_id"); ?></a>
        </td>
    </tr>
    <tr>
        <td><strong>Gerekçesi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo servis_gerekce($item->gerekce); ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Tarihi</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo dateFormat($format = 'd-m-Y', $item->servis_tarih); ?></td>
    </tr>
    <tr>
        <td><strong>Km-Saat</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->servis_km_saat; ?> <?php echo km_saat($item->km_saat); ?></td>
    </tr>
    <tr>
        <td><strong>İşlem Türü</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo islem_turu($item->islem_turu); ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Servis Firma</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo company_name($item->servis_firma); ?></td>
    </tr>
    <tr>
        <td><strong>Genel Açıklama</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->genel_bilgi; ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Fiyat</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo money_format($item->fiyat)." TL"; ?></td>
    </tr>
</table>


