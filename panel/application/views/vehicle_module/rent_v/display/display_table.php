<table class="table">
    <tr>
        <td style="width: 150px"><strong>Araç Plaka</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><a href="<?php echo base_url("vehicle/file_form/$item->vehicle_id")?>">
            <?php echo get_from_any("vehicle","plaka","id","$item->vehicle_id"); ?></a>
        </td>
    </tr>
    <tr>
        <td><strong>Kiralayan Firma</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->kiralayan_firma; ?></td>
    </tr>
    <tr>
        <td><strong>Kiralanan Firma</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->kiralanan_firma; ?></td>
    </tr>
    <tr>
        <td><strong>Kiralama Süresi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->sure; ?> <?php kiralama_turu($item->kiralama_turu); ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Başlangıç Tarihi</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo dateFormat($format = 'd-m-Y', $item->baslangic); ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Bitiş Tarihi</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo dateFormat($format = 'd-m-Y', $item->bitis); ?></td>
    </tr>
    <tr style="padding-bottom: 10px;">
        <td style="width: 150px"><strong>Fiyat</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo money_format($item->fiyat); ?> / <?php kiralama_turu($item->kiralama_turu); ?></td>
    </tr>
    <tr>
        <td><strong>Yakıt</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo liability($item->yakit); ?></td>
    </tr>
    <tr>
        <td><strong>Operatör</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo liability($item->operator); ?></td>
    </tr>
    <tr>
        <td><strong>Bakım ve Servis</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo liability($item->bakim_servis); ?></td>
    </tr>
</table>


