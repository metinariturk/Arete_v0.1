<table class="table">
    <tbody>
    <tr>
        <td ><b>Dosya No</b></td>
        <td>
            <span><?php echo $item->dosya_no; ?></span><br>
            <span style="color: #ffd700"><?php echo cms_if_echo($item->master,"1",'<i class="fa fa-star" aria-hidden="true"></i> Kapak Görselleri',""); ?> </span>
        </td>
    </tr>
    <tr>
        <td ><b>Katalog Ad</b></td>
        <td>
            <span><?php echo $item->catalog_ad; ?></span>
        </td>
    </tr>
    <tr>
        <td ><b>Açıklama</b></td>
        <td>
            <span><?php echo $item->aciklama; ?></span>
        </td>
    </tr>
    </tbody>
</table>