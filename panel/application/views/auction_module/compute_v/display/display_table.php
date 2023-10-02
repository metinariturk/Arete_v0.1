<table class="table">
    <tr>
        <td><strong>Metraj Dosya No</strong></td>
        <td><?php echo $item->dosya_no; ?></td>
    </tr>
    <tr>
        <td><strong>Metraj Ad</strong></td>
        <td><?php echo $item->metraj_ad; ?></td>
    </tr>
    <tr>
        <td><strong>Yükleme Tarihi</strong></td>
        <td><?php echo $item->createdAt == null ? null : dateFormat($format = 'd-m-Y', $item->createdAt); ?></td>
    </tr>
    <tr>
        <td><strong>Onay</strong></td>
        <td><?php echo full_name($item->onay); ?></td>
    </tr>
    <tr>
        <td style="width: 150px"><strong>Açıklama</strong></td>
        <td><?php echo $item->aciklama; ?></td>
    </tr>
</table>


