<table class="table">
    <tr>
        <td style="width: 150px"><strong>Araç Plaka</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><a href="<?php echo base_url("vehicle/file_form/$item->vehicle_id")?>">
            <?php echo get_from_any("vehicle","plaka","id","$item->vehicle_id"); ?></a>
        </td>
    </tr>
    <tr>
        <td><strong>Sigorta Firma</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->sigorta_firma; ?></td>
    </tr>
    <tr>
        <td><strong>Poliçe No</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->police_no; ?></td>
    </tr>
    <tr>
        <td><strong>Sigorta Prim Bedeli</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo money_format($item->prim_bedel)." TL"; ?></td>
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
        <td style="width: 150px"><strong>Düzenlenme Tarihi</strong></td>
        <td style="width: 20px"><strong>:</strong></td>
        <td><?php echo dateFormat($format = 'd-m-Y', $item->duzenlenme); ?></td>
    </tr>
    <tr>
        <td><strong>Sigorta Acentesi</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->acente_ad; ?></td>
    </tr>
    <tr>
        <td><strong>Sigorta Acente İletişim</strong></td>
        <td><strong>:</strong></td>
        <td><?php echo $item->acente_adres." - ".$item->acente_tel; ?></td>
    </tr>
</table>


